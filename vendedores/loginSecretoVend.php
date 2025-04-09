<?php
    include_once '../conexao.php';

    $nick = $conn->real_escape_string($_POST["nickLogin"]);
    $senha = $conn->real_escape_string($_POST["senhaLogin"]);
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      $slct = $conn->prepare("SELECT * FROM vendedores WHERE loginVendedor = CAST(? AS BINARY)");
      $slct->bind_param("s", $nick);

      $slct->execute();
      $slct = $slct->get_result();

      $slct = $slct->fetch_assoc();

      if(!password_verify($senha, $slct['senhaVendedor'])){
        
        $_SESSION["msg"] = "Login ou Senha inválidos, por favor, tente novamente.";
        
        $conn->close();

        header("location: ../vendedores/loginVend.php");

        die();
      }
      elseif(password_verify($senha, $slct['senhaVendedor'])){

        $_SESSION["idVend"] = $slct["idVendedor"];
        $_SESSION["nome"] = $slct["nomeVendedor"];
        $_SESSION['idParVend'] = $slct['idParceiro'];

        $conn->close();

        header("location: ../vendedores/menuVend.php");

        die();
      }
    }
  ?>