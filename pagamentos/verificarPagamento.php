<?php

require_once "../conexao.php";

ob_start();

$dados = json_decode(file_get_contents("php://input"));

$slct = $conn->prepare("SELECT a.idTransacao, b.nomePaciente, b.emailPaciente FROM pedidos a
                        INNER JOIN pacientes b ON a.idPaciente = b.idPaciente 
                        WHERE idPedido = ?");
$slct->bind_param("i", $dados);
$slct->execute();
$slct = $slct->get_result();
$slct = $slct->fetch_assoc();

$dataAtual = date("Y-m-d");
$dataValidade = date("Y-m-d", strtotime("+3 months"));

$curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/$slct[idTransacao]/status",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "access_token: \$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNzYzODI6OiRhYWNoXzFmYjg5Y2EzLTIxYWMtNDBlZC1hMDQyLTJjM2RhMGU3YzU2MQ=="
            ],
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $resposta = json_decode($response);

            if (($resposta->status == "CONFIRMED") || ($resposta->status == "RECEIVED")) {
                $updt = $conn->prepare("UPDATE pedidos SET status = 1, dataEmissao = ?, dataValidade = ? WHERE idPedido = ?");
                $updt->bind_param("ssi", $dataAtual, $dataValidade, $dados);
                $updt->execute();
                $updt->store_result();
                if($updt->affected_rows > 0){
                    echo json_encode(['Confirm' => 'Ok']);
                }
            }else if($resposta->status == "PENDING"){
                echo json_encode(['erro' => 'Transação ainda Pendente!']);
            }
            else if($resposta->status == "OVERDUE"){
                echo json_encode(['erro' => 'Transação Vencida!']);
            }
            else{
                echo json_encode(['erro' => 'Transação ainda não foi confirmada!']);
            }
        }

        $conn->close();
        die();