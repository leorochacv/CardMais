<?php
require_once "../conexao.php";

session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

// Se não existe a sessão Adm, redireciona para página inicial
if (!isset($_SESSION['idAdm'])) {
  header("Location: ../index.php");
}
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
  <!-- Barra de navegação -->
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
              <a class="flutuante-text dropdown-item" href="./cadAdmPagina.php">Cadastro Usuário administrativo</a>
            </li>
            <li>
              <a class="flutuante-text dropdown-item" href="./cadUserPag.php">Cadastro Usuário Vendedor</a>
            </li>
          </ul>
        </div>

        <div class="dropdown ms-1">
          <a class="btn btn-card-contra" href="#" data-bs-toggle="dropdown" aria-expanded="false">Consultas</a>
          <ul class="dropdown-menu">
            <li>
              <a class="flutuante-text dropdown-item" href="./conPaciente.php">Consultar Paciente</a>
              <a class="flutuante-text dropdown-item" href="./conParceiro.php">Consultar Parceiro</a>
              <a class="flutuante-text dropdown-item" href="./comissoes.php">Consultar Comissões</a>
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
  <!-- Fim da barra de navegação -->

<!-- Início do corpo da página -->

<!-- Pesquisar o paciente -->
  <div class="container py-5 col-8">
    <fieldset class="field rounded-3 p-4">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <select name="slctPesquisa" id="slctPesquisa" class="form-select mb-3" required>
          <option selected disabled value="">Escolha uma opção</option>
          <option value="dt">Data de Nascimento</option>
          <option value="cpf">CPF</option>
        </select>

        <div class="mb-3 col">
          <input disabled class="form-control" maxlength="11" placeholder="Digite" id="pesquisarPaciente" name="pesquisarPaciente" required>
        </div>

        <div class="d-grid gap-2 pt-3 mb-3 container">
          <button class="btn btn-lg btn-card-contra shadow" id="btnCadParc" type="submit">Pesquisar</button>
        </div>
      </form>
    </fieldset>
  </div>




  <div class="container py-5 col-8">
    <fieldset class="field rounded-3 p-4">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $pesquisarPaciente = $_POST["pesquisarPaciente"];
        $slctPesquisa = $_POST["slctPesquisa"];

        try {
          if ($slctPesquisa == "dt") {
            $slct = $conn->prepare("SELECT nomePaciente, cpfPaciente FROM pacientes WHERE dtNascPaciente = ?");
            $slct->bind_param("s", $pesquisarPaciente);
            $slct->execute();
            $slct = $slct->get_result();

            if ($slct->num_rows == 0) {
              echo "<script>alert('Nenhum paciente encontrado com essa Data de Nascimento')</script>";
              $conn->close();
            } else {
              while ($row = $slct->fetch_assoc()) {

      ?>
                <div class="d-grid gap-2 pt-3 mb-3 container">
                  <a class="btn btn-lg btn-card-contra shadow" name="btnPac" href="./infPaciente.php?paciente=<?php echo $row['cpfPaciente']; ?>"><?php echo $row['nomePaciente'] ?> - <?php echo $row['cpfPaciente'] ?></a>
                </div>

              <?php
              }
              $conn->close();
            }
          }
          if ($slctPesquisa == "cpf") {
            $slct = $conn->prepare("SELECT nomePaciente, cpfPaciente FROM pacientes WHERE cpfPaciente = ?");
            $slct->bind_param("s", $pesquisarPaciente);
            $slct->execute();
            $slct = $slct->get_result();

            if ($slct->num_rows == 0) {
              echo "<script>alert('Nenhum paciente encontrado com esse CPF')</script>";
              $conn->close();
            } else {
              while ($row = $slct->fetch_assoc()) {
              ?>
                <div class="d-grid gap-2 pt-3 mb-3 container">
                  <a class="btn btn-lg btn-card-contra shadow" name="btnPac" href="./infPaciente.php?paciente=<?php echo $row['cpfPaciente']; ?>"><?php echo $row['nomePaciente'] ?> - <?php echo $row['cpfPaciente'] ?></a>
                </div>

      <?php
              }
              $conn->close();
            }
          }
        } catch (\Throwable $th) {
          echo "Erro: " . $th->getMessage();
          $conn->close();
        }
      }
      ?>
    </fieldset>
  </div>
  <!-- Fim da pesquisa de paciente -->

  <!-- Fim do corpo da página -->
</body>
</html>



<script>
  const slctPesquisa = document.getElementById("slctPesquisa");
  const pesquisarPaciente = document.getElementById("pesquisarPaciente");

  slctPesquisa.addEventListener("change", () => {
    if (slctPesquisa.value == "dt") {
      pesquisarPaciente.disabled = false;
      pesquisarPaciente.type = "date";
      pesquisarPaciente.value = "";
    }
    if (slctPesquisa.value == "cpf") {
      pesquisarPaciente.disabled = false;
      pesquisarPaciente.type = "text";
      pesquisarPaciente.value = "";
    }
  })
</script>