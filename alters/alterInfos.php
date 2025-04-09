<?php
    require_once ('conexao.php');

    session_start();

    //error_reporting(0);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $infP = $_POST['infP'];
        $id = $_SESSION['id'];

        $updt = "UPDATE pacientes
                 SET nomePaciente = ?, cpfPaciente = ?, dtNascPaciente = ?, sexoPaciente = ?
                 WHERE idPaciente = ?";
        $updt = $conn->prepare($updt);
        $updt->bind_param("ssssi", $infP[0], $infP[1], $infP[2], $infP[4] ,$id);
        $updt->execute();
                
        if ($conn->errno == 0) {
            $conn->close();
            $_SESSION['msg'] = "Informação(ões) Alterada(s) com sucesso! Por favor, faça login novamente";
            header("Location: login.php");
            die();
          } else {
            $conn->close();
            $_SESSION['msg'] = "Ocorreu um erro ao alterar a(s) informação(ões), tente novamente mais tarde.";
            header("Location: infLogin.php");
            die();
          }
    }
?>