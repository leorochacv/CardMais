<?php

require_once "../conexao.php";

$dados = json_decode(file_get_contents("php://input"));

$slct = $conn->prepare("SELECT idPagamento FROM pacientes WHERE cpfPaciente = ?");
$slct->bind_param("s", $dados[1]);
$slct->execute();
$slct = $slct->get_result();
$slct = $slct->fetch_assoc();

if ($slct['idPagamento'] == "") {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://sandbox.asaas.com/api/v3/customers",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'name' => $dados[0],
            'cpfCnpj' => $dados[1]
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

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $resposta = json_decode($response);

        $conn->begin_transaction();
        $updt = $conn->prepare("UPDATE pacientes 
                                SET idPagamento = ?
                                WHERE cpfPaciente = ?");
        $updt->bind_param("ss", $resposta->id, $dados[1]);
        $updt->execute();
        $updt->store_result();

        if ($updt->affected_rows > 0) {
            $conn->commit();
            echo json_encode(['Confirm' => $resposta->id]);
        } else {
            $conn->rollback();
        }

    }
    $updt->close();
    $conn->close();
    die();
}
else{
    $conn->close();
    $erro = json_encode(['erro' => 'Paciente já possui cadastro']);
    echo $erro;
    die();
}