<?php
  include("../conexao.php");

  session_set_cookie_params(['httponly' => true]);

  session_start();

  session_regenerate_id(true);

  if (!isset($_SESSION['idAdm'])) {
      header("Location: ../index.php");
  }

  $select = $conn->execute_query("SELECT * FROM parceiros ORDER BY nomeParceiro ASC");
  $slctProcs = $conn->execute_query("SELECT * FROM procedimentos ORDER BY tussProcedimento ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>CardMais</title>

    <link rel="icon" type="image/jpg" href="./imgs/cardMaisLogo.png" />

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>

</head>

<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" id="nav1">
    <div class="container-fluid ms-3 rounded">
      <a class="navbar-brand flutuante-text" href="../index.php">
        <img src="../imgs/cardMaisLogo.png" alt="Logo CardMais" width="70px" height="35px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse" aria-controls="navCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navCollapse">

        <div class="dropdown">
          <?php if (isset($_SESSION["idAdm"])) {
            echo '<a data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-card-contra flutuante-text" href="../administrativo/menuAdm.php"><i class="bi bi-person-circle"> Olá ' . htmlspecialchars($_SESSION['nome']) . '</i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="' . htmlspecialchars("logoutAdm.php") . '">Sair</a></li>
                                </ul>';
          } ?>
        </div>

        <div class="dropdown">
          <a class="btn btn-card-contra" href="#" data-bs-toggle="dropdown" aria-expanded="false">Cadastros</a>
          <ul class="dropdown-menu">
            <li>
              <a class="flutuante-text dropdown-item" href="../cadastros/cadProcedimentos.php">Cadastro Procedimento</a>
            </li>
            <li>
              <a class="flutuante-text dropdown-item" href="../cadastros/cadParceiros.php">Cadastro Parceiros</a>
            </li>
            <li>
              <a class="flutuante-text dropdown-item" href="../cadastros/cadEspecialidades.php">Cadastro Especialidades</a>
            </li>
            <li>
              <a class="flutuante-text dropdown-item" href="../cadastros/cadTabelaProcedimentos.php">Cadastro Tabela Procedimentos</a>
            </li>
            <li>
              <a class="flutuante-text dropdown-item" href="../administrativo/cadAdmPagina.php">Cadastro Usuário administrativo</a>
            </li>
            <li>
              <a class="flutuante-text dropdown-item" href="../administrativo/cadUserPag.php">Cadastro Usuário Vendedor</a>
            </li>
          </ul>
        </div>

        <div class="dropdown ms-1">
            <a class="btn btn-card-contra" href="#" data-bs-toggle="dropdown" aria-expanded="false">Consultas</a>
            <ul class="dropdown-menu">
              <li>
                <a class="flutuante-text dropdown-item" href="../administrativo/conPaciente.php">Consultar Paciente</a>
                <a class="flutuante-text dropdown-item" href="../administrativo/conParceiro.php">Consultar Parceiro</a>
                <a class="flutuante-text dropdown-item" href="../administrativo/comissoes.php">Consultar Comissões</a>
              </li>
            </ul>
          </div>

          <div class="dropdown ms-1">
            <a class="btn btn-card-contra" href="#" data-bs-toggle="dropdown" aria-expanded="false">Relatórios</a>
            <ul class="dropdown-menu">
              <li>
                <a class="flutuante-text dropdown-item" href="#">Paciente que não finalizou cartão</a>
              </li>
            </ul>
          </div>

      </div>
    </div>
  </nav>

    <div class="container py-5 col-10">
        <fieldset class="field rounded-3 p-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">



                <select class="form-select mb-3" name="slctParceiro">
                    <option selected disabled>Selecione o Parceiro</option>
                    <?php
                    while ($row = $select->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $row['idParceiro'] ?>"><?php echo $row['nomeParceiro'] ?></option>
                    <?php
                    }
                    ?>
                </select>

                <div class="row">

                    <table class="table table-bordered align-middle">
                        <?php
                        while ($row = $slctProcs->fetch_assoc()) {
                        ?>
                            <tr>
                                <td>
                                    <input class="form-check-input" type="checkbox" value="<?php echo $row['idProcedimento'] ?>" id="chk<?php echo $row['idProcedimento'] ?>" name="Procedimentos[]">
                                    <label class="form-check-label" for="chk<?php echo $row['idProcedimento'] ?>"><?php echo $row['tussProcedimento'] ?> - <?php echo $row['descProcedimento'] ?></label>
                                </td>

                                <td>
                                    <input class="form-control" type="number" step="any" placeholder="Valor Procedimento" name="vlProcedimento[]" id="inpt<?php echo $row['idProcedimento'] ?>" disabled>
                                </td>
                            </tr>
                            <script>
                                const inpt<?php echo $row['idProcedimento'] ?> = document.getElementById("inpt<?php echo $row['idProcedimento'] ?>");
                                const chk<?php echo $row['idProcedimento'] ?> = document.getElementById("chk<?php echo $row['idProcedimento'] ?>");

                                chk<?php echo $row['idProcedimento'] ?>.addEventListener("change", () => {
                                    if (chk<?php echo $row['idProcedimento'] ?>.checked == true) {
                                        inpt<?php echo $row['idProcedimento'] ?>.disabled = false;
                                    } else {
                                        inpt<?php echo $row['idProcedimento'] ?>.disabled = true;
                                    }
                                })
                            </script>
                        <?php
                        }
                        ?>
                    </table>

                </div>


                <div class="d-grid gap-2 pt-3 mb-3 container">
                    <button class="btn btn-lg btn-card-contra shadow" id="btnCadTabela" type="submit">Fazer Cadastro</button>
                </div>
            </form>
        </fieldset>

    </div>

</body>


</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $Procedimentos = $_POST["Procedimentos"];
        $vlProcedimento = $_POST["vlProcedimento"];
        $slctParceiro = $_POST["slctParceiro"];
        $in;
        $slctTblProc;

        $slct = $conn->prepare("SELECT idTblProcedimento FROM tabela_procedimentos WHERE idParceiro = ?");
        $slct->bind_param("s", $slctParceiro);
        $slct->execute();
        $slct = $slct->get_result();
        $slct = $slct->fetch_assoc();

        if ($slct == null) {
            $conn->execute_query("INSERT INTO tabela_procedimentos (idParceiro) VALUES ($slctParceiro);");
            $slctTblProc = $conn->execute_query("SELECT idTblProcedimento FROM tabela_procedimentos WHERE idParceiro = $slctParceiro;");
            $slctTblProc = $slctTblProc->fetch_assoc();
        } else {
            $slctTblProc = $conn->execute_query("SELECT idTblProcedimento FROM tabela_procedimentos WHERE idParceiro = $slctParceiro;");
            $slctTblProc = $slctTblProc->fetch_assoc();
        }

        for ($i = 0; $i < count($Procedimentos); $i++) {
            $in .= ("INSERT INTO tblprocedimentos (idTblProcedimento, idProcedimento, vlProcedimento) VALUES ($slctTblProc[idTblProcedimento] ,$Procedimentos[$i], $vlProcedimento[$i]);");
        }

        if ($conn->multi_query($in) == TRUE) {
            echo "<script>alert('Tabela Cadastrada');</script>";
        } else {
            echo "<script>alert('Algo deu errado, Tabela não cadastrada');</script>";
        }

        $conn->close();
    } catch (\Throwable $th) {
        echo "Erro: " . $th->getMessage();
        $conn->close();
    }
}



?>