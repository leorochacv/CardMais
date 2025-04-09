<?php

$tuss = $_POST['tuss'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    $slct = "SELECT a.nomeParceiro FROM Parceiros a
              INNER JOIN tabela_procedimentos b ON b.idParceiro = a.idParceiro
              INNER JOIN tblprocedimentos c ON b.idTblProcedimento = c.idTblProcedimento
              INNER JOIN Procedimentos d ON d.idProcedimento = c.idProcedimento
              WHERE d.idProcedimento = '" . $tuss . "'
              GROUP BY a.nomeParceiro ASC LIMIT 20";
    $slct = $conn->query($slct);

    if($slct->num_rows == 0){
      echo "Nada encontrado";
    }
    else{
      while($row = $slct->fetch_assoc()){
        $row['nomeParceiro'];

        
      }
       
    }        
    
  } catch (\Throwable $th) {
    echo "Erro: " . $th->getMessage();
    $conn->close();
  }
}

?>