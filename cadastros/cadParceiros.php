<?php
include("../conexao.php");

session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

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



  <div class="container py-5 col-8">

    <fieldset class="field rounded-3 p-4">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="mb-3 col">
          <label class="form-label" for="nomeParceiro">Nome do Parceiro</label>
          <input type="text" class="form-control" maxlength="200" placeholder="Digite o Parceiro" id="nomeParceiro" name="nomeParceiro" required>
        </div>

        <div class="mb-3 col">
          <label class="form-label" for="cnpjParceiro">CNPJ do Parceiro</label>
          <input type="text" class="form-control" maxlength="14" placeholder="Digite o Parceiro" id="cnpjParceiro" name="cnpjParceiro" required>
        </div>

        <div class="mb-3 col">
          <label class="form-label" for="telefoneParceiro">Telefone Parceiro</label>
          <input type="text" class="form-control" maxlength="11" placeholder="Digite o Telefone do Parceiro" id="telefoneParceiro" name="telefoneParceiro" required>
        </div>

        <div class="mb-3 col">
          <label class="form-label" for="telefoneOpcParceiro">Telefone Parceiro Opcional</label>
          <input type="text" class="form-control" maxlength="11" placeholder="Digite Telefone Opcional do Parceiro" id="telefoneParceiro" name="telefoneOpcParceiro">
        </div>

        <div class="mb-3 col">
          <label class="form-label" for="emailParceiro">Email Parceiro</label>
          <input type="email" class="form-control" maxlength="200" placeholder="Digite o email do Parceiro" id="emailParceiro" name="emailParceiro" required>
        </div>

        <div class="mb-3 col">
          <span id="message" style="color: #b5221b;" class="fw-bold"></span><br>
          <label class="form-label" for="cepParceiro">CEP</label>
          <input type="text" class="form-control" maxlength="8" placeholder="Digite o CEP" id="cepParceiro" name="cepParceiro" required>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label" for="ruaParceiro">Rua</label>
            <input type="text" class="form-control" maxlength="200" placeholder="Rua" id="ruaParceiro" name="ruaParceiro">
          </div>
          <div class="col">
            <label class="form-label" for="bairroParceiro">Bairro</label>
            <input type="text" class="form-control" maxlength="200" placeholder="Bairro" id="bairroParceiro" name="bairroParceiro">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label" for="cidadeParceiro">Cidade</label>
            <input type="text" class="form-control" maxlength="200" placeholder="Cidade" id="cidadeParceiro" name="cidadeParceiro">
          </div>
          <div class="col">
            <label class="form-label" for="estadoParceiro">Estado</label>
            <input type="text" class="form-control" maxlength="200" placeholder="Estado" id="estadoParceiro" name="estadoParceiro">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label" for="numParceiro">Número</label>
            <input type="text" class="form-control" maxlength="5" placeholder="Número" id="numParceiro" name="numParceiro" required>
          </div>
          <div class="col">
            <label class="form-label" for="complParceiro">Complemento</label>
            <input type="text" class="form-control" maxlength="100" placeholder="Complemento" id="complParceiro" name="complParceiro">
          </div>
          <div class="col">
            <label class="form-label" for="slctRegiao">Região</label>
            <select name="slctRegiao" id="slctRegiao" class="form-control">
              <option value="" selected disabled>Selecione a Região</option>
              <option value="zn">Zona Norte</option>
              <option value="zs">Zona Sul</option>
              <option value="cn">Centro</option>
              <option value="zl">Zona Leste</option>
              <option value="zo">Zona Oeste</option>
            </select>
          </div>
        </div>

        <hr class="featurette-divider" style="color: red;">

        <span>Selecione as especialidades do parceiro.</span>
        <br>
        <?php
        $select = $conn->prepare("SELECT * FROM especialidades");
        $select->execute();
        $select = $select->get_result();
        while ($row = $select->fetch_assoc()) {

        ?>
          <div id="divEspecPar" class="form-check form-check-inline mb-3 pt-3">
            <input type="checkbox" class="form-check-input" name="chkEspecialidades[]" id="<?php echo $row['idEspecialidade'] ?>" value="<?php echo $row['idEspecialidade'] ?>">
            <label for="<?php echo $row['idEspecialidade'] ?>"><?php echo $row['descEspecialidade'] ?></label>
          </div>
        <?php
        }
        $select->close();
        ?>

        <hr class="featurette-divider" style="color: red;">

        <span>Selecione o Tipo de Atendimento.</span>
        <br>
        <?php
        $slctTipo = $conn->prepare("SELECT * FROM tipoatendimento");
        $slctTipo->execute();
        $slctTipo = $slctTipo->get_result();

        while ($row = $slctTipo->fetch_assoc()) {
        ?>
          <div id="divTipo" class="form-check form-check-inline mb-3 pt-3">
            <input type="checkbox" class="form-check-input" name="chkTipo[]" id="tipo<?php echo $row['idTipo'] ?>" value="<?php echo $row['idTipo'] ?>">
            <label for="tipo<?php echo $row['idTipo'] ?>"><?php echo $row['descTipo'] ?></label>
          </div>
        <?php
        }
        $slctTipo->close();
        ?>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label" for="senhaPar">Senha</label>
            <input type="password" class="form-control" maxlength="100" placeholder="Digite uma Senha" id="senhaPar" name="senhaPar" required>
          </div>
          <div class="col">
            <label class="form-label" for="senhaConPar">Confirme sua senha</label>
            <input type="password" class="form-control" maxlength="100" placeholder="Confirmar Senha" id="senhaConPar" name="senhaConPar" required>
          </div>
        </div>
        <div class="col">
          <span id="spnSenhaPar"></span>
        </div>




        <div class="d-grid gap-2 pt-3 mb-3 container">
          <button class="btn btn-lg btn-card-contra shadow" id="btnCadParc" type="submit" disabled>Fazer Cadastro</button>
        </div>

      </form>
    </fieldset>

  </div>


  <script>
    const cepParceiro = document.getElementById("cepParceiro");
    const ruaParceiro = document.getElementById("ruaParceiro");
    const bairroParceiro = document.getElementById("bairroParceiro");
    const cidadeParceiro = document.getElementById("cidadeParceiro");
    const estadoParceiro = document.getElementById("estadoParceiro");
    const messageP = document.getElementById("message");
    const senha = document.getElementById("senhaPar");
    const conSenha = document.getElementById("senhaConPar");
    const spnSenhaPar = document.getElementById("spnSenhaPar");


    cepParceiro.addEventListener("focusout", async () => {
      const apenasNum = /^[0-9]+$/;

      try {
        if (!apenasNum.test(cepParceiro.value)) {
          throw {
            cep_erro: 'Cep Inválido'
          };
        }
        const response = await fetch(`https://viacep.com.br/ws/${cepParceiro.value}/json/`)

        if (!response.ok) {
          throw await response.json();
        }

        const responseCep = await response.json();

        ruaParceiro.value = responseCep.logradouro;
        bairroParceiro.value = responseCep.bairro;
        cidadeParceiro.value = responseCep.localidade;
        estadoParceiro.value = responseCep.uf;


      } catch (error) {
        if (error?.cep_erro) {
          messageP.textContent = error.cep_erro;
          setTimeout(() => {
            message.textContent = "";
          }, 5000)
        }

      }
    })

    conSenha.addEventListener("keyup", () => {
      if (senha.value != conSenha.value) {
        spnSenhaPar.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
        document.getElementById("btnCadParc").disabled = true;
      } else {
        spnSenhaPar.innerHTML = "<p class='text-success'>Ok</p>";
        document.getElementById("btnCadParc").disabled = false;
        if (senha.value === conSenha.value && senha.value.length < 8) {
          spnSenhaPar.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
          document.getElementById("btnCadParc").disabled = true;
        }
      }
    })

    senha.addEventListener("keyup", () => {
      if (senha.value != conSenha.value) {
        spnSenhaPar.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
      } else {
        spnSenhaPar.innerHTML = "<p class='text-success'>Ok</p>";
        if (senha.value === conSenha.value && senha.value.length < 8) {
          spnSenhaPar.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
        }
      }
    })
  </script>

</body>


</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    $nomeParceiro = $_POST["nomeParceiro"];
    $cnpjParceiro = $_POST["cnpjParceiro"];
    $emailParceiro = $_POST["emailParceiro"];
    $telefoneParceiro = $_POST["telefoneParceiro"];
    $telefoneOpcParceiro = $_POST["telefoneOpcParceiro"];
    $cepParceiro = $_POST["cepParceiro"];
    $ruaParceiro = $_POST["ruaParceiro"];
    $bairroParceiro = $_POST["bairroParceiro"];
    $cidadeParceiro = $_POST["cidadeParceiro"];
    $estadoParceiro = $_POST["estadoParceiro"];
    $numParceiro = $_POST["numParceiro"];
    $complParceiro = $_POST["complParceiro"];
    $chkEspecialidades = $_POST["chkEspecialidades"];
    $regiaoParceiro = $_POST["slctRegiao"];
    $senha = $_POST["senhaConPar"];

    $chkTipo = $_POST["chkTipo"];

    $inParc = "INSERT INTO parceiros (nomeParceiro, cnpjParceiro, emailParceiro, telefoneParceiro, telefoneOpcParceiro, cepParceiro, ruaParceiro, bairroParceiro, cidadeParceiro, estadoParceiro, numeroParceiro, complParceiro, regiaoParceiro, senha)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $slct = $conn->prepare("SELECT idParceiro FROM parceiros WHERE cnpjParceiro = ?");
    $slct->bind_param("s", $cnpjParceiro);
    $slct->execute();
    $slct->store_result();

    if ($slct->num_rows > 0) {
      echo "<script>alert('Parceiro Já cadastro no sistema');</script>";
      $conn->close();
      die();
    } else {
      $inParc = $conn->prepare($inParc);
      $inParc->bind_param("ssssssssssssss", $nomeParceiro, $cnpjParceiro, $emailParceiro, $telefoneParceiro, $telefoneOpcParceiro, $cepParceiro, $ruaParceiro, $bairroParceiro, $cidadeParceiro, $estadoParceiro, $numParceiro, $complParceiro, $regiaoParceiro, password_hash($senha, PASSWORD_DEFAULT));
      $inParc->execute();
      $inParc->store_result();

      if ($conn->errno == 0) {
        $selParc = $conn->prepare("SELECT idParceiro FROM parceiros WHERE cnpjParceiro = ?");
        $selParc->bind_param("s", $cnpjParceiro);
        $selParc->execute();
        $selParc = $selParc->get_result();
        $selParc = $selParc->fetch_assoc();

        foreach ($chkEspecialidades as $chk) {
          $inEspec = $conn->prepare("INSERT INTO parceiros_especialidades (idParceiro, idEspecialidade) VALUES (?, ?)");
          $inEspec->bind_param("ii", $selParc['idParceiro'],  $chk);
          $inEspec->execute();
        }
        foreach ($chkTipo as $chk) {
          $inTipo = $conn->prepare("INSERT INTO tipoatendimentoparceiro (idTipo, idParceiro) VALUES (?, ?)");
          $inTipo->bind_param("ii", $chk, $selParc['idParceiro']);
          $inTipo->execute();
        }

        if ($conn->errno == 0) {
          echo "<script>alert('Parceiro Cadastrado');</script>";
        }

        $conn->close();
        die();
      } else {
        echo "<script>alert('Parceiro Não Cadastrado, Algo deu errado');</script>";
        $conn->close();
        die();
      }
    }
  } catch (\Throwable $th) {
    echo "Erro: " . $th->getMessage();
    $conn->close();
  }
}



?>