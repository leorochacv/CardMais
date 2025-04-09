<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

// Se não existe a sessão Adm, é redirecionado para a página Inicial
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

  <title>CardMais - Parceiros</title>

  <link rel="icon" type="image/jpg" href="../imgs/cardMaisLogo.png" />

  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <script src="../js/bootstrap.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <!-- Começo da barra de navegação -->
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

  <!-- Começo do corpo da página -->

  <!-- Consulta as comissões -->
  <div class="container py-5 col-8">

    <fieldset class="field rounded-3 p-4">
      <div class="row">
        <div class="col">
          <label for="txtDataI" class="form-label">Data Inicial</label>
          <input type="date" name="txtData" id="txtDataI" class="form-control">
        </div>
        <div class="col">
          <label for="txtDataF" class="form-label">Data Final</label>
          <input type="date" name="txtData" id="txtDataF" class="form-control">
        </div>
      </div>
      <div class="text-center">
        <p>E/OU</p>
      </div>
      <div class="row">
        <div class="col">
          <label for="txtAtende" class="form-label">Nome do Atendente</label>
          <input type="text" name="txtData" id="txtAtende" class="form-control">
        </div>
      </div>

      <div class="d-grid gap-2 pt-3 mb-3 container">
        <button class="btn btn-lg btn-card-contra shadow" id="btnCadParc" type="submit" onclick="getComissoes()">Pesquisar</button>
      </div>
    </fieldset>

  </div>

  <div class="container py-5 col-8">

    <fieldset class="field rounded-3 p-4">

      <div class="container">
        <div class="text-center" id="div">


        </div>
      </div>

    </fieldset>

  </div>
<!-- Fim da consulta das comições -->


<!-- Script em AJAX para pesquisar as comissões cadastradas -->
  <script>
    function getComissoes() {

      const dts = document.getElementsByName("txtData");
      const div = document.getElementById("div");
      values = [];

      for (i of dts) {
        values.push(i.value);
      }

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.open("POST", "./pesquisaComissoes.php", true);
      xmlhttp.setRequestHeader("Content-Type", "application/json");
      xmlhttp.send(JSON.stringify(values));
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var resposta = JSON.parse(xmlhttp.response);

          if (resposta["Erro"]) {
            document.getElementById("div").innerHTML = resposta['Erro'];
          } else {
            let d = "<table class='table'> <thead> <tr> <th scope='col'>#</th> <th scope='col'>Atendente</th> <th scope='col'>Paciente</th> <th scope='col'>Data do Cadastro</th> <th scope='col'>Ind/Fam</th> </tr> </thead>";
            d += "<tbody>";
            let n = 0;
            for (i of resposta) {
              n += 1;
              d += "<tr>";
              d += "<th scope='row'>" + n + "</th>";
              d += "<td>" + i['nomeVendedor'] + "</td>";
              d += "<td>" + i['nomePaciente'] + "</td>";
              d += "<td>" + i['dataCadastro'] + "</td>";
              if (i['idPaciente'] == null) {
                d += "<td>Individual</td>";
              } else {
                d += "<td>Familiar</td>";
              }
              d += "</tr>";
            }
            d += "</table>";
            div.innerHTML = d;
          }

        }
      }
    }
  </script>
<!-- Fim do script de comissões -->

<!-- Fim do corpo da página -->
</body>


</html>