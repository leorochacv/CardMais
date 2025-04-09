<?php
    require_once "../conexao.php";

    session_start();

    $dataAtual = date('Y-m-d');
    $dataValidade = date('Y-m-d', strtotime('+1 year'));
    $statusCartao = 0;

    if(isset($_SESSION['idPaciente'])){
        $insert = $conn->prepare("INSERT INTO cartoes (idPaciente, statusCartao)
                                    VALUES (?, ?)");
        $insert->bind_param("ii", $_SESSION['idPaciente'], $statusCartao);
        $insert->execute();
        $insert->store_result();

    
        if($insert->affected_rows > 0){
            header("Location: ../formulario.php");

        }
        else{
            $_SESSION['msg'] = "Houve um erro ao cadastrar os seu cartão Card+. Por favor, tente novamente mais tarde!";
            header("Location: ../formulario.php");

        }
    
    
    }
    $insert->close();
    $conn->close();
    die();

    /*
    Status para o cartão:
    0 - Falta Pagamento;
    1 - Pagamento Efetuado (Cartão ativo);
    2 - Cartão Vencido;
    3 - Cartão Renovado;
    */
?>