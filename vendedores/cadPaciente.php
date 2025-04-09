<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

if (!isset($_SESSION['idVend'])) {
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

  <title>CardMais</title>
  <meta name="title" property="og:title" content="CardMais" />
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
          <?php if (isset($_SESSION["idVend"])) {
            echo '<a data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-card-contra flutuante-text" href="../administrativo/menuVend.php"><i class="bi bi-person-circle"> Olá ' . htmlspecialchars($_SESSION['nome']) . '</i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="' . htmlspecialchars("logoutVend.php") . '">Sair</a></li>
                                </ul>';
          } ?>
        </div>

        <div class="dropdown">
          <a class="btn btn-card-contra" href="#" data-bs-toggle="dropdown" aria-expanded="false">Cadastros</a>
          <ul class="dropdown-menu">
            <li>
              <a class="flutuante-text dropdown-item" href="../vendedores/cadPaciente.php">Cadastro Paciente</a>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </nav>


  <div class="d-grid gap-2 pt-3 mb-3 container" id="divBtn">

    <a class="btn btn-lg btn-card-contra shadow" data-bs-toggle="collapse" href="#collFamiliar" role="button" aria-expanded="false" aria-controls="collFamiliar">Card+ Saúde Individual ou Em Grupo (Titular +4 Dependentes)</a>

    <!-- Familiar -->
    <div class="container py-5 col-8 collapse" id="collFamiliar" data-bs-parent="#divBtn">
      <h2 class="text-center">Preencha os campos</h2>
      <h6 class="text-center">*ATENÇÃO! Para o cadastro de Card+ em Grupo é Obrigatório o preenchimento dos Dependentes!!! <br> Senão o mesmo será cadastrado como INDIVIDUAL.</h6>
      <br>
      <fieldset class="p-4 rounded-3 field">
        <form action="<?php echo htmlspecialchars('./cadPacienteDB.php'); ?>" method="POST" id="frmFamiliar">

          <div class="mb-3 col">
            <label for="formGroupExampleInput" class="form-label" for="nomePacFam">Nome Completo:</label>
            <input type="text" class="form-control" maxlength="200" placeholder="Digite seu nome completo" id="nomePacFam" name="nomePacFam" required>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label for="formGroupExampleInput" class="form-label" for="cpfPacFam">CPF:</label>
              <input type="text" class="form-control" maxlength="11" placeholder="CPF" id="cpfPacFam" name="cpfPacFam" required>
            </div>
            <div class="col">
              <label for="formGroupExampleInput" class="form-label" for="dtNascPacFam">Data de Nascimento:</label>
              <input type="date" class="form-control" placeholder="Digite sua data de nascimento" id="PacFam" name="dtNascPacFam" required>
            </div>
          </div>

          <div class="mb-3 col">
            <label for="formGroupExampleInput" class="form-label" for="emailPacFam">Email:</label>
            <input type="email" class="form-control" maxlength="200" id="emailPacFam" name="emailPacFam" placeholder="Digite seu Email" required>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label for="formGroupExampleInput" class="form-label" for="telPacFam">Telefone:</label>
              <input type="text" class="form-control" maxlength="11" placeholder="(11)91111-1111" id="telPacFam" name="telPacFam" required>
            </div>
            <div class="col">
              <label for="formGroupExampleInput" class="form-label" for="telOpcPacFam">Telefone Opcional</label>
              <input type="text" class="form-control" maxlength="11" placeholder="(11)91111-1111" id="telOpcPacFam" name="telOpcPacFam">
            </div>
          </div>

          <div class="form-floating">
            <select class="form-select" id="generoPacFam" aria-label="" name="generoPacFam" required>
              <option selected disabled value="">Gênero Paciente</option>
              <option value="F">Feminino</option>
              <option value="M">Masculino</option>
              <option value="O">Outro</option>
            </select>
            <label for="generoPacFam">Selecione: </label>
          </div>

          <div class="mb-3 col">
            <span id="messageFam" style="color: #b5221b;" class="fw-bold"></span><br>
            <label class="form-label" for="cepPacFam">CEP</label>
            <input type="text" class="form-control" maxlength="8" placeholder="Digite seu CEP" id="cepPacFam" name="cepPacFam" required>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="ruaPacFam">Rua</label>
              <input type="text" class="form-control" maxlength="200" placeholder="Rua" id="ruaPacFam" name="ruaPacFam" required>
            </div>
            <div class="col">
              <label class="form-label" for="bairroPacFam">Bairro</label>
              <input type="text" class="form-control" maxlength="200" placeholder="Bairro" id="bairroPacFam" name="bairroPacFam" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="cidadePacFam">Cidade</label>
              <input type="text" class="form-control" maxlength="200" placeholder="Cidade" id="cidadePacFam" name="cidadePacFam" required>
            </div>
            <div class="col">
              <label class="form-label" for="estadoPacFam">Estado</label>
              <input type="text" class="form-control" maxlength="200" placeholder="Estado" id="estadoPacFam" name="estadoPacFam" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="numPacFam">Número</label>
              <input type="text" class="form-control" maxlength="5" placeholder="Número" id="numPacFam" name="numPacFam" required>
            </div>
            <div class="col">
              <label class="form-label" for="complPacFam">Complemento</label>
              <input type="text" class="form-control" maxlength="100" placeholder="Complemento" id="complPacFam" name="complPacFam">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="senhaPacFam">Senha</label>
              <input type="password" class="form-control" maxlength="100" placeholder="Digite uma Senha" id="senhaPacFam" name="senhaPacFam" required>
            </div>
            <div class="col">
              <label class="form-label" for="senhaConPacFam">Confirme sua senha</label>
              <input type="password" class="form-control" maxlength="100" placeholder="Confirmar Senha" id="senhaConPacFam" name="senhaConPacFam" required>
            </div>
          </div>
          <div class="col">
            <span id="spnSenhaFam"></span>
          </div>

          <div class="form-check pt-4">
            <input class="form-check-input" type="checkbox" name="chkDep" id="chkDep1">
            <label class="form-check-label" for="chkDep1">Adicionar 1º Dependente</label>
          </div>
          <div class="mb-3 col">
            <label class="form-label">1º Dependente</label>
            <input type="text" class="form-control dep1" maxlength="200" id="nomeDep1" name="nomeDep1" placeholder="Nome completo Dependente 1" hidden>
          </div>
          <div class="row">
            <div class="mb-3 col-4">
              <input type="text" class="form-control dep1" maxlength="11" id="cpfDep1" name="cpfDep1" placeholder="CPF do Dependente 1" hidden>
            </div>
            <div class="mb-3 col-4">
              <input type="date" class="form-control dep1" id="dtNascDep1" name="dtNascDep1" placeholder="Data de Nascimento do Dependente 1" hidden>
            </div>
            <div class="form-floating mb-3 col-4">
              <select class="form-select dep1" id="generoDep1" aria-label="" name="generoDep1" hidden>
                <option selected disabled value="">Gênero Paciente</option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
                <option value="O">Outro</option>
              </select>
            </div>
          </div>


          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="chkDep" id="chkDep2">
            <label class="form-check-label" for="chkDep2">Adicionar 2º Dependente</label>
          </div>
          <div class="mb-3 col">
            <label class="form-label">2º Dependente</label>
            <input type="text" class="form-control dep2" maxlength="200" id="nomeDep2" name="nomeDep2" placeholder="Nome completo Dependente 2" hidden>
          </div>
          <div class="row">
            <div class="mb-3 col-4">
              <input type="text" class="form-control dep2" maxlength="11" id="cpfDep2" name="cpfDep2" placeholder="CPF do Dependente 2" hidden>
            </div>
            <div class="mb-3 col-4">
              <input type="date" class="form-control dep2" id="dtNascDep2" name="dtNascDep2" placeholder="Data de Nascimento do Dependente 2" hidden>
            </div>
            <div class="form-floating mb-3 col-4">
              <select class="form-select dep2" id="generoDep2" aria-label="" name="generoDep2" hidden>
                <option selected disabled value="">Gênero Paciente</option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
                <option value="O">Outro</option>
              </select>
            </div>
          </div>


          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="chkDep" id="chkDep3">
            <label class="form-check-label" for="chkDep3">Adicionar 3º Dependente</label>
          </div>
          <div class="mb-3 col">
            <label class="form-label">3º Dependente</label>
            <input type="text" class="form-control dep3" maxlength="200" id="nomeDep3" name="nomeDep3" placeholder="Nome completo Dependente 3" hidden>
          </div>
          <div class="row">
            <div class="mb-3 col-4">
              <input type="text" class="form-control dep3" maxlength="11" id="cpfDep3" name="cpfDep3" placeholder="CPF do Dependente 3" hidden>
            </div>
            <div class="mb-3 col-4">
              <input type="date" class="form-control dep3" id="dtNascDep3" name="dtNascDep3" placeholder="Data de Nascimento do Dependente 3" hidden>
            </div>
            <div class="form-floating mb-3 col-4">
              <select class="form-select dep3" id="generoDep3" aria-label="" name="generoDep3" hidden>
                <option selected disabled value="">Gênero Paciente</option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
                <option value="O">Outro</option>
              </select>
            </div>
          </div>


          <div class="form-check">
            <input class="form-check-input dep4" type="checkbox" name="chkDep" id="chkDep4">
            <label class="form-check-label" for="chkDep4">Adicionar 4º Dependente</label>
          </div>
          <div class="mb-3 col">
            <label class="form-label">4º Dependente</label>
            <input type="text" class="form-control dep4" maxlength="200" id="nomeDep4" name="nomeDep4" placeholder="Nome completo Dependente 4" hidden>
          </div>
          <div class="row">
            <div class="mb-3 col-4">
              <input type="text" class="form-control dep4" maxlength="11" id="cpfDep4" name="cpfDep4" placeholder="CPF do Dependente 4" hidden>
            </div>
            <div class="mb-3 col-4">
              <input type="date" class="form-control dep4" id="dtNascDep4" name="dtNascDep4" placeholder="Data de Nascimento do Dependente 4" hidden>
            </div>
            <div class="form-floating mb-3 col-4">
              <select class="form-select dep4" id="generoDep4" aria-label="" name="generoDep4" hidden>
                <option selected disabled value="">Gênero Paciente</option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
                <option value="O">Outro</option>
              </select>
            </div>
          </div>

          <div class="d-grid gap-2 pt-3 mb-3 container">
            <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnCadFam">Fazer Cadastro</button>
          </div>

        </form>
      </fieldset>
    </div>
    <!-- Fim Familiar -->
  </div>



  <script>
    const chkDep = document.getElementsByName("chkDep");
    const dep1 = document.getElementsByClassName("dep1");
    const dep2 = document.getElementsByClassName("dep2");
    const dep3 = document.getElementsByClassName("dep3");
    const dep4 = document.getElementsByClassName("dep4");

    const senhaFam = document.getElementById("senhaPacFam");
    const conSenhaFam = document.getElementById("senhaConPacFam");
    const spnSenhaFam = document.getElementById("spnSenhaFam");

    conSenhaFam.addEventListener("keyup", () => {
      if (senhaFam.value != conSenhaFam.value) {
        spnSenhaFam.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
      } else {
        spnSenhaFam.innerHTML = "<p class='text-success'>Ok</p>";
        if (senhaFam.value === conSenhaFam.value && senhaFam.value.length < 8) {
          spnSenhaFam.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
        }
      }
    })

    senhaFam.addEventListener("keyup", () => {
      if (senhaFam.value != conSenhaFam.value) {
        spnSenhaFam.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
      } else {
        spnSenhaFam.innerHTML = "<p class='text-success'>Ok</p>";
        if (senhaFam.value === conSenhaFam.value && senhaFam.value.length < 8) {
          spnSenhaFam.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
        }
      }
    })



    chkDep[0].addEventListener("click", () => {
      if (chkDep[0].checked == true) {
        for (let it of dep1) {
          it.hidden = false;
        }
      } else {
        for (let it of dep1) {
          it.hidden = true;
        }
      }
    })
    chkDep[1].addEventListener("click", () => {
      if (chkDep[1].checked == true) {
        for (let it of dep2) {
          it.hidden = false;
        }
      } else {
        for (let it of dep2) {
          it.hidden = true;
        }
      }
    })
    chkDep[2].addEventListener("click", () => {
      if (chkDep[2].checked == true) {
        for (let it of dep3) {
          it.hidden = false;
        }
      } else {
        for (let it of dep3) {
          it.hidden = true;
        }
      }
    })
    chkDep[3].addEventListener("click", () => {
      if (chkDep[3].checked == true) {
        for (let it of dep4) {
          it.hidden = false;
        }
      } else {
        for (let it of dep4) {
          it.hidden = true;
        }
      }
    })

    const cepF = document.getElementById("cepPacFam");
    const ruaF = document.getElementById("ruaPacFam");
    const bairroF = document.getElementById("bairroPacFam");
    const cidadeF = document.getElementById("cidadePacFam");
    const estadoF = document.getElementById("estadoPacFam");
    const messageF = document.getElementById("messageFam");

    cepF.addEventListener("focusout", async () => {
      const apenasNum = /^[0-9]+$/;

      try {
        if (!apenasNum.test(cepF.value)) {
          throw {
            cep_erro: 'Cep Inválido'
          };
        }
        const response = await fetch(`https:\\viacep.com.br/ws/${cepF.value}/json/`)

        if (!response.ok) {
          throw await response.json();
        }

        const responseCep = await response.json();

        ruaF.value = responseCep.logradouro;
        bairroF.value = responseCep.bairro;
        cidadeF.value = responseCep.localidade;
        estadoF.value = responseCep.uf;


      } catch (error) {
        if (error?.cep_erro) {
          messageF.textContent = error.cep_erro;
          setTimeout(() => {
            message.textContent = "";
          }, 5000)
        }

      }
    })
  </script>

  <?php

  if (isset($_SESSION['message'])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    session_abort();
  }

  ?>

</body>


</html>