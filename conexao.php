<?php
    $servername = "bz42";
    $username = "cardma98_adminuser";
    $password = "CardioMED@2024_";
    $dbName = "cardma98_cardmais";

    // Cria Conexão
    $conn = new mysqli($servername, $username, $password, $dbName);

    // Checa a Conexão
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
      //echo "Connected successfully";
?>