<?php

    session_start();

    unset($_SESSION['idPar']);

    session_destroy();

    header("Location: ../index.php");

    die();

?>