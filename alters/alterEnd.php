<?php
    require_once ('conexao.php');

    session_start();

    error_reporting(0);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $endP = $_POST['endP'];
        $id = $_SESSION['id'];

        $updt = "UPDATE pacientes
                 SET cepPaciente = ?, ruaPaciente = ?, bairroPaciente = ?, 
                 cidadePaciente = ?, estadoPaciente = ?, numeroPaciente = ?, complPaciente = ?
                 WHERE idPaciente = ?";
        $updt = $conn->prepare($updt);
        $updt->bind_param("sssssssi", $endP[0], $endP[1], $endP[2], $endP[3], $endP[4], $endP[5], $endP[6], $id);
        $updt->execute();
                
        if ($conn->errno == 0) {
            $conn->close();
            $_SESSION['msg'] = "Endereço Alterado com sucesso!";
            header("Location: infLogin.php");
            die();
          } else {
            $conn->close();
            $_SESSION['msg'] = "Ocorreu um erro ao alterar o endereço, tente novamente mais tarde.";
            header("Location: infLogin.php");
            die();
          }
    }
?>