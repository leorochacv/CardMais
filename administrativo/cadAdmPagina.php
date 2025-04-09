<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

// Se não existe a sessions Adm, o mesmo retorna para a página principal
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


<!-- Inicio do corpo da página  -->

  <!-- Cadastro de user administrativo -->
  <div class="container py-5 col-8">

    <fieldset class="field rounded-3 p-4">
      <form action="<?php echo htmlspecialchars("../administrativo/cadAdm.php"); ?>" method="POST">
        <div class="row">
          <div class="col">
            <label for="nomeAdm" class="form-label">Nome Adm</label>
            <input type="text" class="form-control" id="nomeAdm" name="nomeAdm">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="loginAdm" class="form-label">Login Adm</label>
            <input type="text" id="loginAdm" name="loginAdm" class="form-control">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="senhaAdm" class="form-label">Senha</label>
            <input type="password" id="senhaAdm" name="senhaAdm" class="form-control">
          </div>
          <div class="col">
            <label for="senhaConAdm" class="form-label">Confirmar Senha</label>
            <input type="password" id="senhaConAdm" name="senhaConAdm" class="form-control">
          </div>
        </div>

        <div class="d-grid gap-2 pt-3 mb-3 container">
          <button class="btn btn-lg btn-card-contra shadow" id="btnCadAdm" type="submit">Fazer Cadastro</button>
        </div>
      </form>
    </fieldset>

  </div>
  <!-- Fim do cadastro de user administrativo  -->

<!-- Fim do corpo da página  -->
</body>

</html>

<!-- Exibe mensagem se houve -->
<?php
if (isset($_SESSION['msg'])) {
  echo "<script>alert('" . htmlspecialchars($_SESSION['msg']) . "');</script>";
  unset($_SESSION['msg']);
}
?>