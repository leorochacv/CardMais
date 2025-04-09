<?php
    $servername = "";
    $username = "";
    $password = "";
    $dbName = "";

    // Cria Conexão
    $conn = new mysqli($servername, $username, $password, $dbName);

    // Checa a Conexão
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
      //echo "Connected successfully";
?>
