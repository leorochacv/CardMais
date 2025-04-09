<?php
require_once "../conexao.php";
require_once "../email/enviarEmail.php";

ob_start();

error_reporting(0);

$status = filter_input(INPUT_GET, "status");
$voucher = filter_input(INPUT_GET, "voucher");


if ($status == 4) {
    $slct = $conn->prepare("SELECT a.nomePaciente, a.emailPaciente FROM pacientes a
                                    INNER JOIN pedidos b ON a.idPaciente = b.idPaciente
                                    WHERE b.idPedido = ?");
    $slct->bind_param("i", $voucher);
    $slct->execute();
    $slct = $slct->get_result();
    $slct = $slct->fetch_assoc();

    emailStatusFinalizado($slct['nomePaciente'], $slct['emailPaciente'], $voucher);
}

exit();
