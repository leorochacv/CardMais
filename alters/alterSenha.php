<?php

    require_once('conexao.php');

    session_start();

    if(!isset($_SESSION['id'])){
        header("Location: index.php");

        die();
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $id =  $_SESSION['id'];
        $senhaAtual = $_POST['passAtual'];
        $novaSenha = password_hash(htmlspecialchars($_POST['passNovaConf']), PASSWORD_DEFAULT);

        $slct = "SELECT senhaPaciente FROM pacientes WHERE idPaciente = ?";
        $slct = $conn->prepare($slct);
        $slct->bind_param("i", $id);
        $slct->execute();
        $slct = $slct->get_result();
        $slct = $slct->fetch_assoc();

        if(password_verify($senhaAtual, $slct['senhaPaciente'])){
            $updt = "UPDATE pacientes SET senhaPaciente = ? WHERE idPaciente = ?";
            $updt = $conn->prepare($updt);
            $updt->bind_param("si", $novaSenha, $id);
            $updt->execute();
            $updt->store_result();

            if($updt->affected_rows === 1){
                $_SESSION['msg'] = "Senha alterada com sucesso!";
            }
            $conn->close();
            $updt->close();
            header("Location: ../login/login.php");
            die();
        }
        else{
            $_SESSION['msg'] = "Senha Atual não coincide com a cadastrada!";
            $conn->close();
            header("Location: ../login/infLogin.php");
            die();
        }

    }


?>