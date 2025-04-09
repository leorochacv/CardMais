<?php
require "../conexao.php";
require "../email/enviarEmail.php";

ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {

    $nomePacFam = $_POST["nomePacFam"];
    $cpfPacFam = $_POST["cpfPacFam"];
    $dtNascPacFam = $_POST["dtNascPacFam"];
    $emailPacFam = $_POST["emailPacFam"];
    $telPacFam = $_POST["telPacFam"];
    $telOpcPacFam = $_POST["telOpcPacFam"];
    $generoPacFam = $_POST["generoPacFam"];
    $cepPacFam = $_POST["cepPacFam"];
    $ruaPacFam = $_POST["ruaPacFam"];
    $bairroPacFam = $_POST["bairroPacFam"];
    $cidadePacFam = $_POST["cidadePacFam"];
    $estadoPacFam = $_POST["estadoPacFam"];
    $numPacFam = $_POST["numPacFam"];
    $complPacFam = $_POST["complPacFam"];
    $senhaConPacFam = password_hash($_POST["senhaConPacFam"], PASSWORD_DEFAULT);

    $nomeDep1 = $_POST["nomeDep1"];
    $cpfDep1 = $_POST["cpfDep1"];
    $dtNascDep1 = $_POST["dtNascDep1"];
    $generoDep1 = $_POST["generoDep1"];

    $nomeDep2 = $_POST["nomeDep2"];
    $cpfDep2 = $_POST["cpfDep2"];
    $dtNascDep2 = $_POST["dtNascDep2"];
    $generoDep2 = $_POST["generoDep2"];

    $nomeDep3 = $_POST["nomeDep3"];
    $cpfDep3 = $_POST["cpfDep3"];
    $dtNascDep3 = $_POST["dtNascDep3"];
    $generoDep3 = $_POST["generoDep3"];

    $nomeDep4 = $_POST["nomeDep4"];
    $cpfDep4 = $_POST["cpfDep4"];
    $dtNascDep4 = $_POST["dtNascDep4"];
    $generoDep4 = $_POST["generoDep4"];


    $select = "SELECT cpfPaciente FROM pacientes WHERE cpfPaciente = ?";
    $select = $conn->prepare($select);
    $select->bind_param("s", $cpfPacFam);
    $select->execute();
    $select->store_result();

    if ($select->num_rows == 0) {
      $select->close();
      $insert = "INSERT INTO pacientes (nomePaciente, cpfPaciente, emailPaciente, dtNascPaciente, telefonePaciente, telefoneOpcPaciente, sexoPaciente, cepPaciente, ruaPaciente, bairroPaciente, cidadePaciente, estadoPaciente, numeroPaciente, complPaciente, senhaPaciente)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
      $insert = $conn->prepare($insert);
      $insert->bind_param("ssssssssssssiss", $nomePacFam, $cpfPacFam, $emailPacFam, $dtNascPacFam, $telPacFam, $telOpcPacFam, $generoPacFam, $cepPacFam, $ruaPacFam, $bairroPacFam, $cidadePacFam, $estadoPacFam, $numPacFam, $complPacFam, $senhaConPacFam);

      $insert->execute();

      $select2 = "SELECT idPaciente, emailPaciente, nomePaciente FROM pacientes WHERE cpfPaciente = ?";
      $select2 = $conn->prepare($select2);
      $select2->bind_param("s", $cpfPacFam);
      $select2->execute();
      $slct = $select2->get_result();
      $slct = $slct->fetch_assoc();


      // Inicializar variável para armazenar as consultas SQL
      $sql = "";

      // Verificar se há registros a serem inseridos
      if ($slct != null) {
        // Array associativo para mapear os campos dos dependentes
        $dependentes = array(
          array($nomeDep1, $cpfDep1, $dtNascDep1, $generoDep1),
          array($nomeDep2, $cpfDep2, $dtNascDep2, $generoDep2),
          array($nomeDep3, $cpfDep3, $dtNascDep3, $generoDep3),
          array($nomeDep4, $cpfDep4, $dtNascDep4, $generoDep4)
        );

        // Loop para cada dependente
        foreach ($dependentes as $dependente) {
          // Verificar se o CPF do dependente está preenchido e se é único
          if (!empty($dependente[1])) {
            // Consulta preparada para inserção do dependente
            $sql = "INSERT INTO dependentes (nomeDependente, cpfDependente, dtNascDependente, sexoDependente, idPaciente) VALUES (?, ?, ?, ?, ?);";

            // Bind dos parâmetros da consulta preparada
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $dependente[0], $dependente[1], $dependente[2], $dependente[3], $slct['idPaciente']);
            $stmt->execute();

            // Limpar a consulta preparada
            $stmt->close();
          }
        }

        // Verificar se as inserções foram bem-sucedidas
        if ($conn->errno == 0) {
          $_SESSION['message'] = "Paciente e Dependente(s) cadastrados com sucesso! Por favor, continue para Pagamento.";
          $_SESSION['idPaciente'] = $slct['idPaciente'];
          $conn->close();

          emailCadastroFinalizadoFam($slct['emailPaciente'], $slct['nomePaciente']);

          header("Location: ./cadCartao.php");

        } else {
          $_SESSION['message'] = "Ocorreu um erro ao cadastrar os dependentes.";
        }
      } else {
        $_SESSION['message'] = "Erro ao encontrar o paciente associado aos dependentes.";
      }
      } else {
      $_SESSION['message'] = "Paciete com CPF já cadastrado em nosso sistema.";
      $conn->close();
      header("Location: ../formulario.php");
    }
  } catch (\Throwable $th) {
    echo "Erro: " . $th->getMessage();
    $conn->close();
  }
}
