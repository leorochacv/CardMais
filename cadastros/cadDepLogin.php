<?php
require_once "../conexao.php";

session_start();

$dados = json_decode(file_get_contents("php://input"));

if (count($dados) > 0) {
  $stmt = $conn->prepare("INSERT INTO dependentes (nomeDependente, cpfDependente, dtNascDependente, sexoDependente, idPaciente) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssi", $dados[0], $dados[1], $dados[2], $dados[3], $_SESSION['id']);
  $stmt->execute();
  $stmt->store_result();

  if($stmt->affected_rows > 0){
    echo json_encode(['Confirm' => 'Dependente cadastro com Sucesso!! Atualize a página para aplicar a inserção.']);
  }else{
    echo json_encode(['erro' => 'Houve algum erro ao cadastrar um novo dependente. Por favor, tente novamente mais tarde.']);
  }
}

$stmt->close();
$conn->close();
exit();