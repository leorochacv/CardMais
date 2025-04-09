<?php
    require_once ('../conexao.php');

    session_start();

    error_reporting(0);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $contP = $_POST['contP'];
        $id = $_SESSION['id'];

        $updt = "UPDATE pacientes
                 SET telefonePaciente = ?, telefoneOpcPaciente = ?, emailPaciente = ?
                 WHERE idPaciente = ?";
        $updt = $conn->prepare($updt);
        $updt->bind_param("sssi", $contP[0], $contP[1], $contP[2] ,$id);
        $updt->execute();
                
        if ($conn->errno == 0) {
            $conn->close();
            $_SESSION['msg'] = "Contato(s) Alterado(s) com sucesso!";
            header("Location: ../infLogin.php");
            die();
          } else {
            $conn->close();
            $_SESSION['msg'] = "Ocorreu um erro ao alterar o(s) contato(s), tente novamente mais tarde.";
            header("Location: ../infLogin.php");
            die();
          }
    }
?>