<?php

    session_start();

    unset($_SESSION['idAdm']);

    session_destroy();

    header("Location: ../index.php");

    die();

?>