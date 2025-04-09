<?php
require_once '../conexao.php';

session_start();

// Cadastro de usuário administrativo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = filter_var($_POST['nomeAdm'], FILTER_SANITIZE_SPECIAL_CHARS);
    $login = filter_var($_POST['loginAdm'], FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = password_hash($_POST['senhaAdm'], PASSWORD_DEFAULT);


    // Verificar se já existe um administrador com o mesmo login
    $stmt = $conn->prepare("SELECT idAdm FROM adm WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    // Se já existe exibe erro
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        $_SESSION['msg'] = "Já existe um administrador com esse login.";
        header("Location: ../administrativo/cadAdmPagina.php");
        die();
    } else {
        // Senão existe, insere os dados no banco de dados 
        $inst = "INSERT INTO adm (nome, login, senha) VALUES (?, ?, ?)";
        $inst = $conn->prepare($inst);
        $inst->bind_param("sss", $nome, $login, $senha);
        $inst->execute();
        $inst->close();

        // Se não houver erro ao cadastrar, exibe a mensagem
        if ($conn->errno == 0) {
            $conn->close();
            $_SESSION['msg'] = "Login Administrativo cadastrado com sucesso!";
            header("Location: ../administrativo/loginAdm.php");
            die();
        } else {
            // Se houver erro ao cadastrar, exibe o erro 
            $conn->close();
            $_SESSION['msg'] = "Algo deu errado, por favor, tente novamente mais tarde.";
            header("Location: ../administrativo/cadAdmPagina.php");
            die();
        }
    }
}
// Fim do cadastro administrativo
