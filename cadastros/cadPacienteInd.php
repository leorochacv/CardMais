<?php
      require "../conexao.php";
      require "../email/enviarEmail.php";

      ob_start();

      if ($_SERVER["REQUEST_METHOD"] == "POST"){
        try {

          $nomePacInd = $_POST["nomePacInd"];
          $cpfPacInd = $_POST["cpfPacInd"];
          $dtNascPacInd = $_POST["dtNascPacInd"];
          $emailPacInd = $_POST["emailPacInd"];
          $telPacInd = $_POST["telPacInd"];
          $telOpcPacInd = $_POST["telOpcPacInd"];
          $generoPacInd = $_POST["generoPacInd"];
          $cepPac = $_POST["cepPac"];
          $ruaPac = $_POST["ruaPac"];
          $bairroPac = $_POST["bairroPac"];
          $cidadePac = $_POST["cidadePac"];
          $estadoPac = $_POST["estadoPac"];
          $numPac = $_POST["numPac"];
          $complPac = $_POST["complPac"];
          $senhaPacInd = $_POST["senhaPacInd"];
          $senhaConPacInd = password_hash($_POST["senhaConPacInd"], PASSWORD_DEFAULT);
          
          $select = "SELECT cpfPaciente FROM Pacientes WHERE cpfPaciente = ?";

          $select = $conn->prepare($select);
          $select->bind_param("s", $cpfPacInd);
          $select->execute();
          $select->store_result();

          if($select->num_rows == 0){
            $select->close();
            $insert = "INSERT INTO Pacientes (nomePaciente, cpfPaciente, emailPaciente, dtNascPaciente, telefonePaciente, telefoneOpcPaciente, sexoPaciente, cepPaciente, ruaPaciente, bairroPaciente, cidadePaciente, estadoPaciente, numeroPaciente, complPaciente, senhaPaciente)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $insert = $conn->prepare($insert);
            $insert->bind_param("ssssssssssssiss", $nomePacInd, $cpfPacInd, $emailPacInd, $dtNascPacInd, $telPacInd, $telOpcPacInd, $generoPacInd, $cepPac, $ruaPac, $bairroPac, $cidadePac, $estadoPac, $numPac, $complPac, $senhaConPacInd);
            $insert->execute();
            $insert->store_result();  
          }
          else{
            $_SESSION['message'] = "Paciete com CPF já cadastrado em nosso sistema.";
            $insert->close();
            $conn->close();

            header("Location: ../formulario.php");
          } 

          if($insert->affected_rows > 0){
            $_SESSION['message'] = "Paciente Cadastrado com sucesso! Por favor, entre na sua área de Login e faça o pagamento para ter todos os acessos.";

            $slct = $conn->prepare("SELECT idPaciente, emailPaciente, nomePaciente FROM Pacientes WHERE cpfPaciente = ?");
            $slct->bind_param("s", $cpfPacInd);
            $slct->execute();
            $slct = $slct->get_result();
            $slct = $slct->fetch_assoc();

            $_SESSION['idPaciente'] = $slct['idPaciente'];

            emailCadastroFinalizado($slct['emailPaciente'], $slct['nomePaciente']);

            header("Location: ./cadCartao.php");
          }
          else{
            $_SESSION['message'] = "Algo deu errado, por favor tente novamente.";
            $insert->close();
            $conn->close();


            header("Location: ../formulario.php");
          }
        
        } catch (\Throwable $th) {
          echo "Erro: " .$th->getMessage();
          $conn->close();
        }
      }

  ?>