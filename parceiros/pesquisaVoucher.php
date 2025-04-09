<?php

require_once "../conexao.php";

ob_start();
session_start();

error_reporting(0);


$voucher = filter_input(INPUT_GET, "voucher");

if ($voucher != null) {

    $slct = $conn->prepare("SELECT a.idPedido, b.idProcedimento, c.descProcedimento, a.status, d.nomeParceiro, b.vlUnitario, e.nomePaciente, e.cpfPaciente FROM pedidos a
                            INNER JOIN pedidos_parceiros_procedimentos b ON b.idPedido = a.idPedido
                            INNER JOIN procedimentos c ON b.idProcedimento = c.idProcedimento
                            INNER JOIN parceiros d ON b.idParceiro = d.idParceiro
                            INNER JOIN pacientes e ON a.idPaciente = e.idPaciente
                            WHERE a.idPedido = ? AND b.idParceiro = ?
                            ORDER BY a.idPedido ASC");
    $slct->bind_param("ii", $voucher, $_SESSION['idPar']);
    $slct->execute();
    $slct = $slct->get_result();

    $pedidos = [];

    while ($row = $slct->fetch_assoc()) {
        $pedidos[$row['idPedido']]['status'] = $row['status'];
        $pedidos[$row['idPedido']]['paciente']['nomePaciente'] = $row['nomePaciente'];
        $pedidos[$row['idPedido']]['paciente']['cpfPaciente'] = $row['cpfPaciente'];
        $pedidos[$row['idPedido']][$row['nomeParceiro']][] = $row;
    }

    if (!count($pedidos) == 0) {

        foreach ($pedidos as $idPedido => $parceiros) {
            $vlTotal = 0;
            $list .= "<div class='col field p-4 rounded'>";
            $list .= "<h4 class='pt-2 text-danger-emphasis'>Pedido: $idPedido</h4>";
            $list .= "<p class='fw-bold'>Paciente: ".$parceiros['paciente']['nomePaciente'] ."- CPF: ".$parceiros['paciente']['cpfPaciente']."</p>";
            if ($parceiros['status'] == 0) {
                $list .= "<span class='text-info fw-bold'>Status: $parceiros[status] - Pedido feito - Ainda Sem Pagamento!</span>";
            } elseif ($parceiros['status'] == 1) {
                $list .= "<span class='text-primary fw-bold'>Status: $parceiros[status] - Pedido Pago.</span>";
            } elseif ($parceiros['status'] == 2) {
                $list .= "<span class='text-warning fw-bold'>Status: $parceiros[status] - Pedido Aguardando Pagamento.</span>";
            } elseif ($parceiros['status'] == 3) {
                $list .= "<span class='text-success fw-bold'>Status: $parceiros[status] - Pago no Parceiro - Pode ser utilizado.</span>";
            } elseif ($parceiros['status'] == 4) {
                $list .= "<span class='text-success fw-bold'>Status: $parceiros[status] - Pedido Finalizado!</span>";
            } elseif ($parceiros['status'] == 5) {
                $list .= "<span class='text-danger fw-bold'>Status: $parceiros[status] - Voucher Vencido!</span>";
            }
            foreach ($parceiros as $nomeParceiro => $itens) {
                if ($nomeParceiro != 'status' && $nomeParceiro != 'paciente') {
                    $list .= "<h5 class='pt-4 fw-bold'>$nomeParceiro</h5>";
                    $list .= "<ul class='list-group'>";
                    foreach ($itens as $item) {
                        $list .= "<li class='list-group-item'>- " . $item['descProcedimento'] . "</li>";
                        $vlTotal += $item['vlUnitario'];
                    }
                    $list .= "</ul>";
                    if($parceiros['status'] != 5){
                        $list .= "<h6 class='pt-5 text-info fw-bold'>Total: R$$vlTotal</h6>";
                    }
                    if ($parceiros['status'] == 1) {
                        $list .= "<button class='btn btn-sm btn-success' onclick='updtStatus(3, document.getElementById(\"txtVoucher\").value)'>Sinalizar pagamento feito no Parceiro!</button>";
                    }
                    if ($parceiros['status'] == 3) {
                        $list .= "<button class='btn btn-sm btn-primary' onclick='updtStatus(4, document.getElementById(\"txtVoucher\").value)'>Sinalizar como Voucher Utilizado!</button>";
                    }
                }
            }
            $list .= "</div>";
        }
        echo $list;
    } else {
        echo $list = "<span class='fw-bold fs-6'>Nenhum Voucher com esse número encontrado para esse parceiro!</span>";
    }
}
