<?php
require "../conexao.php";

session_start();

$dados = json_decode(file_get_contents("php://input"));

if (($dados[0]) && ($dados[1]) && ($dados[2])) {
    try {
        $nome = "%" .$dados[2] ."%";
        $slct = $conn->prepare("SELECT DISTINCT v.nomeVendedor, a.dataCadastro, b.nomePaciente, d.idPaciente FROM comissionados a
                            INNER JOIN pacientes b ON a.idPaciente = b.idPaciente
                            INNER JOIN cartoes c ON b.idPaciente = c.idPaciente
                            INNER JOIN vendedores v ON a.idVendedor = v.idVendedor
                            LEFT JOIN dependentes d ON d.idPaciente = d.idPaciente
                            WHERE a.dataCadastro BETWEEN ? AND ?
                            AND v.nomeVendedor LIKE ?
                            AND c.statusCartao = 1
                            ORDER BY v.nomeVendedor");
        $slct->bind_param("sss", $dados[0], $dados[1], $nome);
        $slct->execute();
        $slct = $slct->get_result();

        while ($p = $slct->fetch_assoc()) {
            $resultados[] = [
                'nomeVendedor' => $p['nomeVendedor'],
                'nomePaciente' => $p['nomePaciente'],
                'dataCadastro' => $p['dataCadastro'],
                'idPaciente' => $p['idPaciente']
            ];
        }


        if (isset($resultados)) {
            echo json_encode($resultados);
            die();
        } else {
            echo json_encode(['Erro' => 'Nada encontrado nesse período e Nome informado']);
            die();
        }
    } catch (\Throwable $th) {
        echo $th;
    }
}elseif(($dados[0]) && ($dados[1])){
    try {
        $slct = $conn->prepare("SELECT DISTINCT a.dataCadastro, b.nomePaciente, d.idPaciente, v.nomeVendedor FROM comissionados a
                            INNER JOIN pacientes b ON a.idPaciente = b.idPaciente
                            INNER JOIN cartoes c ON b.idPaciente = c.idPaciente
                            INNER JOIN vendedores v ON a.idVendedor = v.idVendedor
                            LEFT JOIN dependentes d ON c.idPaciente = d.idPaciente
                            WHERE a.dataCadastro BETWEEN ? AND ?
                            AND c.statusCartao = 1
                            ORDER BY v.nomeVendedor");
        $slct->bind_param("ss", $dados[0], $dados[1]);
        $slct->execute();
        $slct = $slct->get_result();

        while ($p = $slct->fetch_assoc()) {
            $resultados[] = [
                'nomeVendedor' => $p['nomeVendedor'],
                'nomePaciente' => $p['nomePaciente'],
                'dataCadastro' => $p['dataCadastro'],
                'idPaciente' => $p['idPaciente'],
            ];
        }


        if (isset($resultados)) {
            echo json_encode($resultados);
            die();
        } else {
            echo json_encode(['Erro' => 'Nada encontrado nesse período informado']);
            die();
        }
    } catch (\Throwable $th) {
        echo $th;
    }
}elseif($dados[2]){
    try {
        $nome = "%" .$dados[2] ."%";
        $slct = $conn->prepare("SELECT DISTINCT v.nomeVendedor, a.dataCadastro, b.nomePaciente, d.idPaciente FROM comissionados a
                            INNER JOIN pacientes b ON a.idPaciente = b.idPaciente
                            INNER JOIN cartoes c ON b.idPaciente = c.idPaciente
                            INNER JOIN vendedores v ON a.idVendedor = v.idVendedor
                            LEFT JOIN dependentes d ON c.idPaciente = d.idPaciente
                            AND v.nomeVendedor LIKE ?
                            AND c.statusCartao = 1
                            ORDER BY v.nomeVendedor");
        $slct->bind_param("s", $nome);
        $slct->execute();
        $slct = $slct->get_result();

        while ($p = $slct->fetch_assoc()) {
            $resultados[] = [
                'nomeVendedor' => $p['nomeVendedor'],
                'nomePaciente' => $p['nomePaciente'],
                'dataCadastro' => $p['dataCadastro'],
                'idPaciente' => $p['idPaciente']
            ];
        }


        if (isset($resultados)) {
            echo json_encode($resultados);
            die();
        } else {
            echo json_encode(['Erro' => 'Nada encontrado nesse Nome informado']);
            die();
        }
    } catch (\Throwable $th) {
        echo $th;
    }
}
