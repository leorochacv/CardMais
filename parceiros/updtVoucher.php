<?php

require_once "../conexao.php";

ob_start();

error_reporting(0);

$status = filter_input(INPUT_GET, "status");
$voucher = filter_input(INPUT_GET, "voucher");

$conn->begin_transaction();
if($status != null){

    $updt = $conn->prepare("UPDATE pedidos a
                            SET a.status = ? 
                            WHERE idPedido = ?");
    $updt->bind_param("ii", $status, $voucher);
    $updt->execute();
    $updt->store_result();

    if($conn->errno == 0){
        $conn->commit();
        echo $voucher;
        
        exit();
    }
    else{
        $conn->rollback();
        echo "Erro";
    }
}