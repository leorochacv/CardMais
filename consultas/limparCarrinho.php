<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ids = $_POST['parc-proc'];
    $ids = explode("-", $ids);

    unset($_SESSION['carrinho'][$ids[0]][$ids[1]]);

    if ($_SESSION['carrinho'][$ids[0]] == null) {
        unset($_SESSION['carrinho'][$ids[0]]);
    }

    header("Location: ./carrinho.php");

    die();
}
