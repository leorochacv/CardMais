<?php

    include_once '../conexao.php';

    $cpf = $conn->real_escape_string($_POST["cpfLogin"]);
    $senha = $conn->real_escape_string($_POST["senhaLogin"]);
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      $slct = $conn->prepare("SELECT idPaciente, nomePaciente, senhaPaciente FROM pacientes WHERE cpfPaciente = ?");
      $slct->bind_param("s", $cpf);
      $slct->execute();
      $slct = $slct->get_result();
      $slct = $slct->fetch_assoc();

      if(!password_verify($senha, $slct['senhaPaciente'])){
        
        $_SESSION["msg"] = "CPF ou Senha inválidos, por favor, tente novamente.";
        
        $conn->close();

        header("location: ../login/login.php");

        die();
      }
      elseif(password_verify($senha, $slct['senhaPaciente'])){

        $_SESSION["id"] = $slct["idPaciente"];
        $_SESSION["nomePaciente"] = $slct["nomePaciente"];

        $conn->close();

        header("location: ../login/infLogin.php");

        die();

      }

    }
  
  
  ?>