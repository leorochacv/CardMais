<?php
    require_once ('../conexao.php');

    session_start();

    error_reporting(0);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $dep1 = $_POST['dep1'];
        $dep2 = $_POST['dep2'];
        $dep3 = $_POST['dep3'];
        $dep4 = $_POST['dep4'];

        $dependentes = array(
            array($dep1[0], $dep1[1], $dep1[2], $dep1[3]),
            array($dep2[0], $dep2[1], $dep2[2], $dep2[3]),
            array($dep3[0], $dep3[1], $dep3[2], $dep3[3]),
            array($dep4[0], $dep4[1], $dep4[2], $dep4[3])
        );

        foreach($dependentes as $dpd){
            if(!empty($dpd[1])){
                $updt = "UPDATE dependentes 
                        SET nomeDependente = ?, dtNascDependente = ?, cpfDependente = ?
                        WHERE idDependente = ?";
                $updt = $conn->prepare($updt);
                $updt->bind_param("sssi", $dpd[0], $dpd[2], $dpd[3], $dpd[1]);
                $updt->execute();

                $updt->close();
            }
        }

        if ($conn->errno == 0) {
            $conn->close();
            $_SESSION['msg'] = "Dependente(s) Alterado(s) com sucesso!";
            header("Location: ../login/infLogin.php");
            die();
          } else {
            $conn->close();
            $_SESSION['msg'] = "Ocorreu um erro ao alterar o(s) dependente(s).";
            header("Location: ../login/infLogin.php");
            die();
          }
    }
?>