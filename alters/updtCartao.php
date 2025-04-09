<?php
require "../conexao.php";

session_start();

$dados = json_decode(file_get_contents("php://input"));

if($dados){
    try {
    $updt = $conn->prepare("UPDATE cartoes 
                            SET statusCartao = 1, dtObtidoCartao = curDate(), dtValidadeCartao = ADDDATE(CURDATE(), INTERVAL 1 YEAR)
                            WHERE idCartao = ?");
    $updt->bind_param("i", $dados);
    $updt->execute();
    $updt->store_result();

    if($updt->affected_rows > 0){
        echo "OK";
    }
    else{
        echo "Falha ao atualizar o Status do cartão";
    }
} catch (\Throwable $th) {
    echo $th;
}
}