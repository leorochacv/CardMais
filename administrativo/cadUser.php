<?php
session_start();

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dados = $_POST['user'];

    $inst = $conn->prepare("INSERT INTO vendedores (idParceiro, nomeVendedor, loginVendedor, senhaVendedor) VALUES (?, ?, ?, ?)");
    $inst->bind_param("isss", $dados[0], $dados[1], $dados[2], password_hash($dados[3], PASSWORD_DEFAULT));
    $inst->execute();
    $inst->store_result();

    if($inst->affected_rows > 0){
        $_SESSION['msg'] = "Vendedor cadastrado com sucesso!";
        $inst->close();
        $conn->close();
        header("Location: ./cadUserPag.php");
    }
    else{
        $_SESSION['msg'] = "Ocorreu algum erro, por favor, tente novamente mais tarde.";
        $inst->close();
        $conn->close();
        header("Location: ./cadUserPag.php");
    }
}
die();