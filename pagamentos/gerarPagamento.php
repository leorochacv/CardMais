<?php

require_once '../conexao.php';

session_start();

$dados = json_decode(file_get_contents("php://input"));

$curl = curl_init();


curl_setopt_array($curl, [
  CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'billingType' => $dados[4],
    'customer' => $dados[0],
    'value' => $dados[1],
    'dueDate' => date('Y-m-d', strtotime('+1 day'))
  ]),
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "access_token: \$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNzYzODI6OiRhYWNoXzFmYjg5Y2EzLTIxYWMtNDBlZC1hMDQyLTJjM2RhMGU3YzU2MQ==",
    "content-type: application/json"
  ],
]);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$resposta = json_decode($response);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    if($dados[2] == 1){
        $updt = $conn->prepare("UPDATE cartoes
                        SET idTransacao = ?
                        WHERE idCartao = ?");
        $updt->bind_param("ss", $resposta->id, $_SESSION['idCard']);
        $updt->execute();
        $updt->store_result();  
        if($updt->affected_rows > 0){
            echo json_encode(['link' => $resposta->invoiceUrl]);
            $updt->close();
            die();
        }
    }
    else if($dados[2] == 2){
        $updt = $conn->prepare("UPDATE pedidos SET idTransacao = ?, status = 2 WHERE idPedido = ?");
        $updt->bind_param("si", $resposta->id, $dados[3]);
        $updt->execute();
        $updt->store_result();
        if($updt->affected_rows > 0){
            echo json_encode(['link' => $resposta->invoiceUrl]);
            $updt->close();
            die();
        }
    } else if($dados[2] == 3){
      $updt = $conn->prepare("UPDATE cartoes
                        SET idTransacao = ?, statusCartao = 3
                        WHERE idCartao = ?");
        $updt->bind_param("ss", $resposta->id, $_SESSION['idCard']);
        $updt->execute();
        $updt->store_result();  
        if($updt->affected_rows > 0){
            echo json_encode(['link' => $resposta->invoiceUrl]);
            $updt->close();
            die();
        }
      }
  }