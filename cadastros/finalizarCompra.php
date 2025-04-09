<?php
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}

session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

error_reporting(0);

ob_start();

require_once "../conexao.php";

$insrt = $conn->prepare("INSERT INTO pedidos (idPaciente, status) VALUES (?, 0)");
$insrt->bind_param("i", $_SESSION['id']);

$insrt2 = $conn->prepare("INSERT INTO pedidos_parceiros_procedimentos (idPedido, idParceiro, idProcedimento, vlUnitario) VALUES (?, ?, ?, ?)");

foreach ($_SESSION['carrinho'] as $key => $value) {

    foreach ($_SESSION['carrinho'][$key] as $k => $proc) {
        if (str_contains($proc['descProcedimento'], "Consulta")) {
            $insrt->execute();
            $slct = $conn->prepare("SELECT idPedido FROM pedidos WHERE idPaciente = ? ORDER BY idPedido DESC LIMIT 1");
            $slct->bind_param("i", $_SESSION['id']);
            $slct->execute();
            $slct = $slct->get_result();
            $slct = $slct->fetch_assoc();

            $insrt2->bind_param("iiid", $slct['idPedido'], $key, $_SESSION['carrinho'][$key][$k]['idProcedimento'], $_SESSION['carrinho'][$key][$k]['vlProcedimento']);
            $insrt2->execute();
            $vlTotal += $_SESSION['carrinho'][$key][$k]['vlProcedimento'];

            $insrt3 = $conn->prepare("UPDATE pedidos SET VlTotal = ? WHERE idPedido = ?");
            $insrt3->bind_param("di", $vlTotal, $slct['idPedido']);
            $insrt3->execute();
            $vlTotal = 0;
            unset($_SESSION['carrinho'][$key][$k]);
        }
    }

    if (count($_SESSION['carrinho'][$key]) > 0) {
        $insrt->execute();
        $slct = $conn->prepare("SELECT idPedido FROM pedidos WHERE idPaciente = ? ORDER BY idPedido DESC LIMIT 1");
        $slct->bind_param("i", $_SESSION['id']);
        $slct->execute();
        $slct = $slct->get_result();
        $slct = $slct->fetch_assoc();
        foreach ($_SESSION['carrinho'][$key] as $k => $proc) {
            $insrt2->bind_param("iiid", $slct['idPedido'], $key, $_SESSION['carrinho'][$key][$k]['idProcedimento'], $_SESSION['carrinho'][$key][$k]['vlProcedimento']);
            $insrt2->execute();
            $vlTotal += $_SESSION['carrinho'][$key][$k]['vlProcedimento'];
        }
        $insrt3 = $conn->prepare("UPDATE pedidos SET VlTotal = ? WHERE idPedido = ?");
        $insrt3->bind_param("di", $vlTotal, $slct['idPedido']);
        $insrt3->execute();
        $vlTotal = 0;
    }
}

$insrt->close();
$insrt2->close();

if ($conn->errno == 0) {
    $conn->close();
    unset($_SESSION['carrinho']);
    unset($_SESSION['procs']);
    header("Location: ../login/infLogin.php");
    exit();
} else {
    header("Location: ../consultas/carrinho.php");
}



// Status Pedido
// 0 - Pedido Feito
// 1 - Pedido Pago
// 2 - Esperando Pagamento
// 3 - Pedido Pago no Parceiro
// 4 - Voucher Finalizado