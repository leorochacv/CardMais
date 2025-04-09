<?php
session_start();

$idProduto = filter_input(INPUT_GET, "cod");

$ids = explode("-", $idProduto, 2);

$idProduto = $ids[0];
$idParceiro = $ids[1];


foreach ($_SESSION['procs'] as $value) {
    if ($value['idProcedimento'] == $idProduto && $value['idParceiro'] == $idParceiro) {
        if (!isset($_SESSION['carrinho'][$idParceiro][$idProduto])) {
            $_SESSION['carrinho'][$idParceiro][$idProduto] = [];
            $_SESSION['carrinho'][$idParceiro][$idProduto] = $value;
            echo json_encode($_SESSION['carrinho']);
        }
        else{
            echo "0";
        }
    }
}


