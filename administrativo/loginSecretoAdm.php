<?php
include_once '../conexao.php';

    $nick = $conn->real_escape_string($_POST["nickLogin"]);
    $senha = $conn->real_escape_string($_POST["senhaLogin"]);
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      $slct = $conn->prepare("SELECT * FROM adm WHERE login = CAST(? AS BINARY)");
      $slct->bind_param("s", $nick);

      $slct->execute();
      $slct = $slct->get_result();

      $slct = $slct->fetch_assoc();

      if(!password_verify($senha, $slct['senha'])){
        
        $_SESSION["msg"] = "Login ou Senha inválidos, por favor, tente novamente.";
        
        $conn->close();

        header("location: ../administrativo/loginAdm.php");

        die();
      }
      elseif(password_verify($senha, $slct['senha'])){

        $_SESSION["idAdm"] = $slct["idAdm"];
        $_SESSION["nome"] = $slct["nome"];

        $conn->close();

        header("location: ../administrativo/menuAdm.php");

        die();
      }
    }
  ?>