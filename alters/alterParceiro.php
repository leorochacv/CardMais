<?php
require_once "../conexao.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $infPar = $_POST['infPar'];

    $updt = $conn->prepare("UPDATE parceiros 
                            SET cnpjParceiro = ?, nomeParceiro = ?, emailParceiro = ?, telefoneParceiro = ?, telefoneOpcParceiro = ?, cepParceiro = ?, ruaParceiro = ?, bairroParceiro = ?, cidadeParceiro = ?, estadoParceiro = ?, numeroParceiro = ?, complParceiro = ?, regiaoParceiro = ?
                            WHERE idParceiro = ?");
    $updt->bind_param("sssssssssssssi", $infPar[1], $infPar[0], $infPar[4], $infPar[2], $infPar[3], $infPar[5], $infPar[6], $infPar[7], $infPar[8], $infPar[9], $infPar[10], $infPar[11], $infPar[13], $infPar[14]);
    $updt->execute();
    $updt->store_result();

    if($conn->errno == 0){
        $_SESSION['msg'] = "Informações Alteradas com sucesso.";
    }
    else{
        $_SESSION['msg'] = "Houve algum erro, tente novamente mais tarde.";
    }

    $updt->close();
    $conn->close();
    header("Location: ../consultas/conParceiro.php");
    die();
}


?>