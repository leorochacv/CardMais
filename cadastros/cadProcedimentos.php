<?php
include("../conexao.php");

session_set_cookie_params(['httponly' => true]);

  session_start();

  session_regenerate_id(true);

  if(!isset($_SESSION['idAdm'])){
      header("Location: ../index.php"); 
  }

  error_reporting(0);

  $select = $conn->execute_query("SELECT * FROM especialidades");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <title>CardMais - Adm</title>


  <link rel="icon" type="image/jpg" href="../imgs/cardMaisLogo.png" />

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
        <div class="row">
          <div class="mb-3 col-4">
            <input type="text" class="form-control" maxlength="8" placeholder="Código TUSS" name="Tuss[]" required>
          </div>

          <div class="mb-3 col-7">
            <input type="text" class="form-control" maxlength="200" placeholder="Descrição Procedimento" name="Procedimento[]" required>
          </div>

          <div class="my-auto col">
            <a class="btn btn-sm btn-card-contra" id="btnIncluiProc" name="btnIncluiProc">+</a>
          </div>
        </div>

        <div id="divRow">


        </div>

        <div class="d-grid gap-2 pt-3 mb-3 container">
          <button class="btn btn-lg btn-card-contra shadow" id="btnCadInd" type="submit">Fazer Cadastro</button>
        </div>
      </form>
    </fieldset>

  </div>

  <script>
    const divRow = document.getElementById("divRow");
    const btnIncluiProc = document.getElementsByName("btnIncluiProc");

    btnIncluiProc[0].addEventListener("click", () => {
      const newInput = document.createElement("input");
      newInput.type = "text";
      newInput.className = "form-control";
      newInput.maxLength = "200";
      newInput.placeholder = "Descrição Procedimento";
      newInput.name = "Procedimento[]";
      
      const newInput2 = document.createElement("input");
      newInput2.type = "text";
      newInput2.className = "form-control";
      newInput2.maxLength = "8";
      newInput2.placeholder = "Código TUSS";
      newInput2.name = "Tuss[]";

      const newDiv = document.createElement("div");
      newDiv.className = "row"

      const newDivDesc = document.createElement("div");
      newDivDesc.className = "col-7 mb-3";

      const newDivVl = document.createElement("div");
      newDivVl.className = "col-4 mb-3";


      divRow.append(newDiv);
      newDiv.append(newDivVl);
      newDivVl.append(newInput2);
      newDiv.append(newDivDesc);
      newDivDesc.append(newInput);
    })
  </script>

</body>


</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $Procedimento = $_POST["Procedimento"];
  $Tuss = $_POST["Tuss"];
  $in;
  try {

    for ($i = 0; $i < count($Tuss); $i++) {
      $slct = $conn->prepare("SELECT * FROM procedimentos WHERE idProcedimento = ?");
      $slct->bind_param("s", $Tuss[$i]);
      $slct->execute();
      $slct = $slct->get_result();
      $slct = $slct->fetch_assoc();
      if ($slct != null) {
        echo "<script>alert('Procedimento" . " " . $Procedimento[$i] . " " . "Já cadastrado');</script>";
      } else {
        $in .= ("INSERT INTO procedimentos (tussProcedimento, descProcedimento) VALUES ($Tuss[$i], '$Procedimento[$i]');");
      }
    }
    if ($in != null && $conn->multi_query($in) == TRUE) {
      echo "<script>alert('Procedimentos Cadastrados');</script>";
    }

    $conn->close();
  } catch (\Throwable $th) {
    echo "Erro: " . $th->getMessage();
    $conn->close();
  }
}
?>