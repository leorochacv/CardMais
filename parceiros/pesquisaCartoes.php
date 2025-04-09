<?php
require "../conexao.php";

session_start();

$dados = json_decode(file_get_contents("php://input"));

if($dados[0]){
    try {
        $slct = $conn->prepare("SELECT a.statusCartao, a.idCartao, b.nomePaciente, b.cpfPaciente FROM cartoes a
                                INNER JOIN pacientes b ON a.idPaciente = b.idPaciente
                                INNER JOIN comissionados c ON b.idPaciente = c.idPaciente
                                WHERE b.cpfPaciente = ?");
        $slct->bind_param("s", $dados[0]);
        $slct->execute();
        $slct = $slct->get_result();
        $slct = $slct->fetch_assoc();

        if($slct != null){
            echo json_encode($slct);
        }
        else{
            echo json_encode(['Erro' => 'Nenhum Paciente encontrado com o CPF pesquisado']);
        }

    } catch (\Throwable $th) {
        echo $th;
    }               
}