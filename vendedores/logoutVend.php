<?php

    session_start();

    unset($_SESSION['idVend']);

    session_destroy();

    header("Location: ../index.php");

    die();

?>