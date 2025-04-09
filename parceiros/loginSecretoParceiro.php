<?php
    include_once '../conexao.php';

    $cnpj = $conn->real_escape_string($_POST["cnpjLogin"]);
    $senha = $conn->real_escape_string($_POST["senhaLogin"]);
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      $slct = $conn->prepare("SELECT idParceiro, nomeParceiro, senha FROM parceiros WHERE cnpjParceiro = ?");
      $slct->bind_param("s", $cnpj);
      $slct->execute();
      $slct = $slct->get_result();
      $slct = $slct->fetch_assoc();

      if(!password_verify($senha, $slct['senha'])){
        
        $_SESSION["msg"] = "Login ou Senha inválidos, por favor, tente novamente.";
        
        $conn->close();

        header("location: ./loginParceiro.php");

        die();
      }
      elseif(password_verify($senha, $slct['senha'])){

        $_SESSION["idPar"] = $slct["idParceiro"];
        $_SESSION["nomeParceiro"] = $slct["nomeParceiro"];

        $conn->close();

        header("location: ./menuParceiros.php");

        die();
      }
    }
  ?>