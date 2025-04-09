<?php
require_once '../conexao.php';

error_reporting(0);

session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

if (!isset($_SESSION['idAdm'])) {
  header("Location: ../index.php");
}

$cpfPaciente = filter_input(INPUT_GET, "paciente", FILTER_VALIDATE_INT);

$slct = "SELECT * FROM pacientes WHERE cpfPaciente = ?";
$slct = $conn->prepare($slct);
$slct->bind_param("i", $cpfPaciente);
$slct->execute();
$slct = $slct->get_result();
$slct = $slct->fetch_assoc();

$slctCard = $conn->prepare("SELECT * FROM cartoes WHERE idPaciente = ?");
$slctCard->bind_param("i", $slct['idPaciente']);
$slctCard->execute();
$slctCard = $slctCard->get_result();
$slctCard = $slctCard->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <title>Parceiros - CardMais</title>
  <meta name="title" property="og:title" content="Parceiros - CardMais" />
  <meta name="description" property="og:description" content="Page Description" />
  <meta name="image" property="og:image" itemprop="image" content="../imgs/cardMaisLogo.png" />
  <meta name="type" property="og:type" content="website" />
  <meta name="url" property="og:url" content="https://url.page" />
  <meta name="site_name" property="og:site_name" content="CardMais" />
  <meta name="locale" property="og:locale" content="pt_BR" />

  <link rel="icon" type="image/jpg" href="../imgs/cardMaisLogo.png" />


  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


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






  <div class="container py-5">
    <h1 class="text-center fw-bold"><?php echo 'Paciente: ' . htmlspecialchars($slct['nomePaciente']); ?></h1>

    <div class="row p-4">
      <div class="col-6">
        <ul class="list-group">
          <li class="list-group-item fs-4 fw-bold text-center">Endereço do Paciente:</li>
          <li class="list-group-item fs-5"><?php echo '<b>Logradouro: </b>' . htmlspecialchars($slct['ruaPaciente']) . ' - ' . htmlspecialchars($slct['numeroPaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Bairro: </b>' . htmlspecialchars($slct['bairroPaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Cidade: </b>' . htmlspecialchars($slct['cidadePaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Estado: </b>' . htmlspecialchars($slct['estadoPaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Complemento: </b>' . htmlspecialchars($slct['complPaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>CEP: </b>' . htmlspecialchars($slct['cepPaciente']); ?></li>
        </ul>
      </div>
      <div class="col-6">
        <ul class="list-group">
          <li class="list-group-item fs-4 fw-bold text-center">Contatos do Paciente:</li>
          <li class="list-group-item fs-5"><?php echo '<b>Telefone: </b>' . htmlspecialchars($slct['telefonePaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Telefone Opcional: </b>' . htmlspecialchars($slct['telefoneOpcPaciente']); ?></li>
          <li class="list-group-item fs-5 text-break"><?php echo '<b>Email: </b>' . htmlspecialchars($slct['emailPaciente']); ?></li>
        </ul>
        <br>
        <ul class="list-group">
          <li class="list-group-item fs-4 fw-bold text-center">Infos. do Paciente:</li>
          <li class="list-group-item fs-5"><?php echo '<b>Gênero: </b>' . htmlspecialchars($slct['sexoPaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Cpf: </b>' . htmlspecialchars($slct['cpfPaciente']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Data de Nascimento: </b>' . htmlspecialchars($slct['dtNascPaciente']); ?></li>
        </ul>
      </div>
    </div>
    <div class="row p-4">
      <div class="col">
        <ul class="list-group">
          <li class="list-group-item fs-4 fw-bold text-center">Dados do Cartão:</li>
          <li class="list-group-item fs-5"><?php echo '<b>Numero do Cartão: </b>' . htmlspecialchars($slctCard['idCartao']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Data de Validade: </b>' . htmlspecialchars($slctCard['dtValidadeCartao']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Data que foi Obtido: </b>' . htmlspecialchars($slctCard['dtObtidoCartao']); ?></li>
          <li class="list-group-item fs-5"><?php echo '<b>Status Cartão: </b>' . htmlspecialchars($slctCard['statusCartao']);
                                            echo $r = ($slctCard['statusCartao'] == 0 ? " - Cartão Ainda não obtido" : ($slctCard['statusCartao'] == 1 ? " - Cartão está ativo." : ($slctCard['statusCartao'] == 2 ? " - O cartão passou da validade." : "Nada encontrado"))); ?></li>
        </ul>
      </div>
    </div>

  </div>


</body>

</html>