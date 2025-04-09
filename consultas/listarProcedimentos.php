<?php
    include_once("../conexao.php");

    $descProcedimento = filter_input(INPUT_GET, "desc");

    if(!empty($descProcedimento)){

        $pesq_proc = "%" . $descProcedimento . "%";

        $slct = $conn->prepare("SELECT * FROM procedimentos WHERE descProcedimento LIKE ? ORDER BY descProcedimento ASC LIMIT 20");
        $slct->bind_param("s", $pesq_proc);

        $slct->execute();

        $resulSlct = $slct->get_result();

        if(($resulSlct) && ($resulSlct->num_rows != 0)){
            while($row = $resulSlct->fetch_assoc()){
                $dados[] = [
                    'id' => htmlspecialchars($row["idProcedimento"]),
                    'desc' => htmlspecialchars($row["descProcedimento"])
                ];
        
            }
            $retorna = ['erro' => false, 'dados' => $dados];
        }
        else{
            $retorna = ['erro' => true, 'msg' => "Descrição não encontrada"];
        }
    }
    else{
        $retorna = ['erro' => true, 'msg' => "Descrição não encontrada"];
    }

    echo json_encode($retorna);