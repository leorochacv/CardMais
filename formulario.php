<?php
  session_set_cookie_params(['httponly' => true]);

  session_start();

  session_regenerate_id(true);

  error_reporting(0);

  $message = $_SESSION['message'];
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
  <meta name="image" property="og:image" itemprop="image" content="./imgs/cardMaisLogo.png" />
  <meta name="type" property="og:type" content="website" />
  <meta name="url" property="og:url" content="https://url.page" />
  <meta name="site_name" property="og:site_name" content="CardMais" />
  <meta name="locale" property="og:locale" content="pt_BR" />

  <link rel="icon" type="image/jpg" href="./imgs/cardMaisLogo.png" />

  <link rel="stylesheet" href="./css/bootstrap.css">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- <script src="./js/bootstrap.bundle.min.js"></script> -->
  <script src="./js/bootstrap.js"></script>

</head>

<body>
<!-- Cabeçalho -->
  <header>
    <div class="container d-flex flex-row align-items-center flex-wrap justify-content-end py-3" style="color: #b5221b;">
      <div class="px-2"><i class="bi bi-geo-alt-fill"></i><a class="text-reset" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/place/Cardiol%C3%B3gica+Medicina+Diagn%C3%B3stica/@-23.5017891,-46.6296408,17z/data=!3m1!5s0x94cef62912572b05:0xe31bc360c7afa97c!4m10!1m2!2m1!1scardiol%C3%B3gica+medicina+diagn%C3%B3stica+endere%C3%A7o!3m6!1s0x94cef62c1d7c945d:0x8e11d34a3ab45fd9!8m2!3d-23.5020952!4d-46.6271096!15sCi1jYXJkaW9sw7NnaWNhIG1lZGljaW5hIGRpYWduw7NzdGljYSBlbmRlcmXDp28iAkgBkgERZGlhZ25vc3RpY19jZW50ZXLgAQA!16s%2Fg%2F1tsyqx_6?entry=ttu">
          <b>Rua Salete, 200, Cj. 92</b></a></div>
      <div class="px-2"><i class="bi bi-envelope-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="mailto: agenda@cardiologica.net"><b>email@cardiologica.net</b></a> </i></div>
      <div class="px-2"><i class="bi bi-telephone-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="tel:+551121396900"><b>(11) 2139-6900</b></a> </i></div>
    </div>
  </header>
<!-- Fim do cabeçalho  -->

<!-- Barra de navegação  -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" id="nav1">
    <div class="container-fluid ms-3 rounded">
      <a class="navbar-brand flutuante-text" href="./index.php">
        <img src="./imgs/cardMaisLogo.png" alt="Logo CardMais" width="70px" height="35px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse" aria-controls="navCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link flutuante-text" href="./saibaMais.php">Sobre Card+</a>
          </li>
          <li class="nav-item">
            <a class="nav-link flutuante-text" href="./parceiros.php">Parceiros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link flutuante-text" href="./contato.php">Fale Conosco</a>
          </li>
        </ul>
        <?php
        if (isset($_SESSION['statusCartao']) && $_SESSION['statusCartao'] == 1) {
          echo '<a class="btn btn-card-contra" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><i class="bi bi-cart-fill"></i></a>';
        }

        if (isset($_SESSION["id"])) {
          echo '<a class="btn btn-card-contra text-end flutuante-text" href="./login/infLogin.php"><i class="bi bi-person-circle"> Olá ' . htmlspecialchars($_SESSION['nomePaciente']) . '</i></a>';
        } else {
          echo '<a class="btn btn-card-contra text-end flutuante-text" href="./login/login.php"><i class="bi bi-person-circle"> Entrar</i></a>
                  <a class="btn btn-card-contra flutuante-text" href="./formulario.php">Adquira já o seu</a>';
        }
        ?>
      </div>
    </div>
  </nav>
<!-- Fim da barra de navegação  -->

<!-- Começo do corpo da página  -->
  <div class="d-grid gap-2 pt-3 mb-3 container" id="divBtn">
    <!-- Cadastro CardMais Individual  -->
    <!--
    <a class="btn btn-lg btn-card-contra shadow" data-bs-toggle="collapse" href="#collIndividual" role="button" aria-expanded="false" aria-controls="collIndividual">Card+ Saúde Individual</a>
    <div class="container py-5 col-8 collapse" id="collIndividual" data-bs-parent="#divBtn">
      <h2 class="text-center">Preencha os campos - Individual</h2>
      <br>
      <fieldset class="p-4 rounded-3 field">
        <form action="<?php echo htmlspecialchars('./cadastros/cadPacienteInd.php'); ?>" method="POST" id="frmIndividual">

          <div class="mb-3 col">
            <label class="form-label" for="nomePacInd">Nome Completo:</label>
            <input type="text" class="form-control" maxlength="200" placeholder="Digite seu nome completo" id="nomePacInd" name="nomePacInd" required>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="cpfPacInd">CPF:</label>
              <input type="text" class="form-control" maxlength="11" placeholder="CPF" id="cpfPacInd" name="cpfPacInd" required>
            </div>
            <div class="col">
              <label class="form-label" for="dtNascPacInd">Data de Nascimento:</label>
              <input type="date" class="form-control" placeholder="Digite sua data de nascimento" id="dtNascPacInd" name="dtNascPacInd" required>
            </div>
          </div>

          <div class="mb-3 col">
            <label class="form-label" for="emailPacInd">Email:</label>
            <input type="email" class="form-control" maxlength="200" placeholder="Digite seu Email" id="emailPacInd" name="emailPacInd" required>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="telPacInd">Telefone:</label>
              <input type="text" class="form-control" maxlength="11" placeholder="(11)91111-1111" id="telPacInd" name="telPacInd" required>
            </div>
            <div class="col">
              <label class="form-label" for="telOpcPacInd">Telefone Opcional</label>
              <input type="text" class="form-control" maxlength="11" placeholder="(11)91111-1111" id="telOpcPacInd" name="telOpcPacInd">
            </div>
          </div>

          <div class="form-floating">
            <select class="form-select" id="generoPacInd" aria-label="" name="generoPacInd" required>
              <option selected disabled value="">Gênero Paciente</option>
              <option value="F">Feminino</option>
              <option value="M">Masculino</option>
              <option value="O">Outro</option>
            </select>
            <label for="generoPacInd">Selecione: </label>
          </div>

          <div class="mb-3 col">
            <span id="message" style="color: #b5221b;" class="fw-bold"></span><br>
            <label class="form-label" for="cepPac">CEP</label>
            <input type="text" class="form-control" maxlength="8" placeholder="Digite seu CEP" id="cepPac" name="cepPac" required>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="ruaPac">Rua</label>
              <input type="text" class="form-control disabled" maxlength="200" placeholder="Rua" id="ruaPac" name="ruaPac" required>
            </div>
            <div class="col">
              <label class="form-label" for="bairroPac">Bairro</label>
              <input type="text" class="form-control" maxlength="200" placeholder="Bairro" id="bairroPac" name="bairroPac" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="cidadePac">Cidade</label>
              <input type="text" class="form-control" maxlength="200" placeholder="Cidade" id="cidadePac" name="cidadePac" required>
            </div>
            <div class="col">
              <label class="form-label" for="estadoPac">Estado</label>
              <input type="text" class="form-control" maxlength="200" placeholder="Estado" id="estadoPac" name="estadoPac" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="numPac">Número</label>
              <input type="text" class="form-control" maxlength="5" placeholder="Número" id="numPac" name="numPac" required>
            </div>
            <div class="col">
              <label class="form-label" for="complPac">Complemento</label>
              <input type="text" class="form-control" maxlength="100" placeholder="Complemento" id="complPac" name="complPac">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label" for="senhaPacInd">Senha</label>
              <input type="password" class="form-control" maxlength="100" placeholder="Digite uma Senha" id="senhaPacInd" name="senhaPacInd" required>
            </div>
            <div class="col">
              <label class="form-label" for="senhaConPacInd">Confirme sua senha</label>
              <input type="password" class="form-control" maxlength="100" placeholder="Confirmar Senha" id="senhaConPacInd" name="senhaConPacInd" required>
            </div>
          </div>
          <div class="col">
            <span id="spnSenha"></span>
          </div>
          
          <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="checkAdesao" required>
              <label class="form-check-label" for="checkAdesao">
                Li e Concordo com os <a href="./anexos/TERMO DE ADESÃO CARD+.pdf" target="_blank" rel="noreferrer noopener nofollow">Termos de Adesão CardMais Saúde.</a>
              </label>
            </div>
          
        
          <div class="d-grid gap-2 pt-3 mb-3 container">
            <button class="btn btn-lg btn-card-contra shadow" id="btnCadInd" type="submit">Fazer Cadastro</button>
          </div>

        </form>
      </fieldset>
    </div>
    -->
    
 

    <!-- Cadastro CardMais Em Grupo -->
    <a class="btn btn-lg btn-card-contra shadow" data-bs-toggle="collapse" href="#collFamiliar" role="button" aria-expanded="false" aria-controls="collFamiliar">Card+ Saúde em Grupo (Titular +4 Dependentes)</a>
    <div class="container py-5 col-8 collapse" id="collFamiliar" data-bs-parent="#divBtn">
      <h2 class="text-center">Preencha os campos - Familiar</h2>
      <br>
      <fieldset class="p-4 rounded-3 field">
        <form action="<?php echo htmlspecialchars('./cadastros/cadPacienteFam.php'); ?>" method="POST" id="frmFamiliar">

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
              <input type="date" class="form-control" placeholder="Digite sua data de nascimento" id="dtNascPacFam" name="dtNascPacFam" required>
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
          
          <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="checkAdesaoGrupo" required>
              <label class="form-check-label" for="checkAdesaoGrupo">
                Li e Concordo com os <button type="button" class="btn btn-sm btn-card-contra" data-bs-toggle="modal" data-bs-target="#exampleModal">Termos de Adesão CardMais Saúde.</button>
              </label>
            </div>

          <div class="d-grid gap-2 pt-3 mb-3 container">
            <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnCadFam">Fazer Cadastro</button>
          </div>

        </form>
      </fieldset>
    </div>
    <!-- Fim Cadastro Em Grupo -->
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Termo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h1>TERMO DE ADESÃO</h1>
        <p>CARD+Saúde é uma plataforma de serviços que visa colocar em contato consumidor e fornecedor, sendo o último na área de serviços ou bens materiais. Portanto, não é plano de saúde, não garante e não se responsabiliza pelos serviços oferecidos e pelo pagamento das despesas, nem assegura desconto em todos os serviços obrigatoriamente garantidos por plano de saúde. Tudo que o cliente usar ou comprar será por ele pago diretamente ao prestador / parceiro.</p>
        <p>CARD+Saúde proporciona ao ADERENTE e seus dependentes acesso apenas os preços e descontos que constam na relação de parceiros (empresas e serviços) divulgados no site www.cardmaissaude.com.br</p>  
        <p>São oferecidos ao ADERENTE, através do presente Contrato de Adesão, acesso a valores reduzidos, a empresas de prestação de serviços e oferta de produtos em diversos segmentos, incluindo as áreas de saúde, educação, lazer, entre outros.</p>
        <p>CARD+Saúde busca no mercado parceiros de padrão elevado, porém, não se responsabiliza pela qualidade técnica e profissional dos serviços prestados pelos mesmos, bem como pelo recebimento dos valores estabelecidos pelos parceiros.</p> 
        <h3><b>Cláusula 1 - Penalidades por Inobservância</b></h3>
        <p>Em caso de inobservância das disposições contidas no caput desta cláusula, será aplicada uma multa equivalente a 50% (cinquenta por cento) sobre o valor total das mensalidades vincendas.</p>
        <h3><b>Cláusula 2 - Rescisão do Contrato</b></h3>
        <p>A rescisão do presente instrumento somente será efetivada mediante o pagamento integral de todas as mensalidades em atraso.</p>
        <h3><b>Cláusula 3 - Direito de Cobrança</b></h3> 
        <p>O CARD+Saúde reserva-se o direito de realizar a cobrança extrajudicial e judicial das mensalidades não quitadas e em atraso pelo ADERENTE, acrescidas de multa de 2% (dois por cento) e juros moratórios de 1% (um por cento) ao mês.</p>
        <h3><b>Cláusula 4 - Suspensão de Cobranças</b></h3>
        <p>A suspensão ou cancelamento das cobranças das mensalidades não implica no cancelamento do contrato de adesão, nem na renúncia do CARD+Saúde ao direito de cobrar a mensalidade do ADERENTE por outros meios.</p>
        <h3><b>Cláusula 5 - Interpretação do Contrato</b></h3> 
        <p>O presente contrato será interpretado de acordo com as normas previstas no Código de Defesa do Consumidor, sendo acessível a qualquer momento pelo ADERENTE no site www.cardmaissaude.com.br, na seção “Contrato de Adesão”.</p>
        <h3><b>Cláusula 6 - Foro</b></h3>  
        <p>As partes elegem o Foro da Comarca Local, renunciando expressamente a qualquer outro, por mais privilegiado que seja.</p>
        <h3><b>Cláusula 7 - Atualização de Cadastro</b></h3>  
        <p>É de inteira responsabilidade do ADERENTE manter o CARD+Saúde informado sobre quaisquer alterações em seu cadastro.</p>
        <h3><b>Cláusula 8 - Reajuste Anual</b></h3>
        <p>O reajuste anual do valor da adesão, conforme mencionado no caput, ocorrerá em janeiro de cada ano, de acordo com o IGPM integral da FGV do ano anterior, sendo comunicado aos ADERENTES com, no mínimo, 30 (trinta) dias de antecedência de sua efetivação, através do site www.cardmaissaude.com.br.</p>
        <h3><b>Cláusula 9 - Responsabilidade por Informações</b></h3>  
        <p>O CARD+Saúde não se responsabiliza pelas informações prestadas pelo ADERENTE no momento da assinatura do contrato, reservando-se o direito de regresso em caso de fraude.</p>
        <h3><b>Cláusula 10 - Validade do Contrato</b></h3>  
        <p>O presente contrato terá validade pelo período correspondente ao plano de ADESÃO escolhido pelo ADERENTE, contado a partir do pagamento da 1ª mensalidade. As mensalidades serão renovadas automaticamente por prazo indeterminado, salvo manifestação expressa em contrário por uma das partes.</p>
        <h3><b>Cláusula 11 - Direito de Rescisão</b></h3>
        <p>O ADERENTE poderá rescindir o presente contrato sem quaisquer ônus no prazo de 7 (sete) dias, contados da data de sua adesão, na unidade do CARD+Saúde localizada na Rua Salete, nº 200, conjunto 92 – Santana – São Paulo.</p>
        <h3><b>Cláusula 12 - Rescisão Após Renovação Automática</b></h3> 
        <p>Após a renovação automática do presente contrato, por prazo indeterminado, qualquer uma das partes poderá rescindir o contrato sem multa, mediante comunicação prévia de 30 (trinta) dias, por escrito, devendo a comunicação ser realizada diretamente na sede do CARD+Saúde, no caso do ADERENTE, ou por meio eletrônico (e-mail), no caso do CARD+Saúde.</p>
        <h3><b>Cláusula 13 - Comunicação de Atualizações</b></h3>  
        <p>Atualizações referentes aos parceiros serão comunicadas por meio deste mesmo canal e/ou pelo envio de comunicação eletrônica ao ADERENTE que tiver fornecido ao CARD+Saúde seu endereço eletrônico no momento da adesão.</p>
        <h3><b>Cláusula 14 - Acesso aos Serviços</b></h3>  
        <p>O ADERENTE e seus familiares (cônjuge, progenitores e filhos) terão direito ao acesso às empresas e serviços parceiros, desde que devidamente inscritos e em dia com suas obrigações financeiras junto ao CARD+Saúde, conforme a modalidade de adesão escolhida.</p>
        <h3><b>Cláusula 15 - Variação de Acesso</b></h3>  
        <p>O acesso às empresas e serviços parceiros poderá variar de acordo com o tipo de adesão optada pelo ADERENTE, podendo ser consultado no site www.cardmaissaude.com.br antes da efetivação.</p>
        <h3><b>Cláusula 16 - Pagamento das Mensalidades</b></h3>  
        <p>O ADERENTE obriga-se a pagar ao CARD+Saúde, a partir da assinatura deste contrato, por si e por seus familiares inscritos, o valor mensal correspondente ao tipo de adesão escolhida, mediante autorização de débito em cartão de crédito ou pagamento direto na sede do CARD+Saúde.</p>
        <h3><b>Cláusula 17 - Condição para Disponibilização de Serviços</b></h3>  
        <p>Os pagamentos mensais e sucessivos somente serão devidos, e os serviços ora contratados somente serão disponibilizados, após o pagamento da 1ª mensalidade.</p>
        <h3><b>Cláusula 18 - Isenção de Responsabilidade</b></h3> 
        <p>O CARD+Saúde é uma plataforma de serviços que visa conectar consumidores e fornecedores, não se configurando como um plano de saúde. Assim, não garante nem se responsabiliza pelos serviços oferecidos e pelo pagamento das despesas, nem assegura desconto em todos os serviços obrigatoriamente garantidos por plano de saúde. Todo uso ou compra será de responsabilidade do ADEREENTE em relação ao prestador.</p>
        <h3><b>Cláusula 19 - Declaração de Acesso às Informações</b></h3>  
        <p>O ADERENTE declara ter recebido, no momento da celebração do presente Contrato de Adesão, informações sobre todas as empresas e serviços parceiros do CARD+Saúde, que podem ser acessadas a qualquer momento por meio do site www.cardmaissaude.com.br</p> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" onclick="conc()" data-bs-dismiss="modal">Concordo com os Termos</button>
      </div>
    </div>
  </div>
</div>

     <!-- Cadastro Corporativo  -->
    <a class="btn btn-lg btn-card-contra shadow" data-bs-toggle="collapse" href="#collCorporativo" role="button" aria-expanded="false" aria-controls="collCorporativo">Card+ Saúde Corporativo</a>
    <div class="container py-5 col-8 collapse text-center" id="collCorporativo" data-bs-parent="#divBtn">
      <fieldset class="p-4 rounded-3 field">
        <p>Para saber mais sobre o Card+ Saúde Corporativo por favor, entre em contato conosco!</p>
        <a class="btn btn-lg btn-card-contra shadow" href="#" role="button">Chames-nos no WhatsApp</a>
        <a class="btn btn-lg btn-card-contra shadow" href="mailto:agenda@cardiologica.net" role="button">Mande-nos um E-mail</a>
        <a class="btn btn-lg btn-card-contra shadow" href="tel:+551121396900" role="button">Ligue-nos</a>
      </fieldset>
    </div>
    <!-- Fim Corporativo -->
  </div>

  <!-- Botao WhatsApp  -->
    <a data-bs-toggle="tooltip" data-bs-title="Tooltip on left" href="https://wa.me/55(aqui seu numero com ddd | tudo junto)?text=Adorei%20seu%20artigo" class="wpp flutuante" target="_blank">
      <i style="margin-top:16px" class="fa fa-whatsapp"></i>
    </a>
  <!-- Fim do Botão WhatsApp  -->
<!-- Fim do corpo da página  -->


<!-- Rodapé  -->
  <footer class="text-center text-lg-start bg-light text-muted">

    <section class="d-flex justify-content-center justify-content-lg-between p-4">

      <div class="me-5 d-none d-lg-block">
        <span><b>Siga-nos nas Redes Sociais</b></span>
      </div>



      <div>
        <a href="" class="me-4 text-reset">
          <i class="bi bi-facebook flutuante-text" style="color: #b5221b;"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="bi bi-twitter flutuante-text" style="color: #b5221b;"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="bi bi-google flutuante-text" style="color: #b5221b;"></i>
        </a>
        <a href="" class="me-4 text-reset">
          </b><i class="bi bi-instagram flutuante-text" style="color: #b5221b;"></i>
        </a>
      </div>



    </section>

    <hr class="featurette-divider" style="color: red;">

    <section>
      <div class="container text-center text-md-start mt-5 ">

        <div class="row mt-3">

          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4 text-center">
            <img src="./imgs/cardMaisLogo.png" class="img-fluid">
            <p>
              Seu cartão de benefícios.
            </p>
          </div>

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-1">
            <address>
              <h6 class="text-uppercase fw-bold mb-4">Contatos</h6>
              <p><i class="bi bi-geo-alt-fill me-2"></i>Rua Salete, 200, Santana, SP - SP</p>
              <p><i class="bi bi-envelope-fill me-2"></i>info@example.com</p>
              <p><i class="bi bi-telephone-fill me-2"></i>(11) 2139-6900</p>
              <p><i class="bi bi-phone-fill me-2"></i>(11) 91111-1111 Whats</p>
            </address>
          </div>

        </div>

      </div>
    </section>

    <div class="text-center p-4 mt-5" style="background-color: #b5221b;">
      <!-- © 2023 Copyright:
      <a class="text-reset fw-bold" href="cardiologica.net">Cardiológica Medicina Diagnóstica</a> -->
    </div>

  </footer>
<!-- Fim do rodapé  -->

  <script src="./cep.js"></script>


  <script>
    const chkTerm = document.getElementById("checkAdesaoGrupo");
  
    const chkDep = document.getElementsByName("chkDep");
    const chkDep4 = document.getElementById("chkDep4");
    const dep1 = document.getElementsByClassName("dep1");
    const dep2 = document.getElementsByClassName("dep2");
    const dep3 = document.getElementsByClassName("dep3");
    const dep4 = document.getElementsByClassName("dep4");

    const senha = document.getElementById("senhaPacInd");
    const conSenha = document.getElementById("senhaConPacInd");
    const spnSenha = document.getElementById("spnSenha");

    const senhaFam = document.getElementById("senhaPacFam");
    const conSenhaFam = document.getElementById("senhaConPacFam");
    const spnSenhaFam = document.getElementById("spnSenhaFam");
    
    function conc(){
        chkTerm.checked = true;
    }


    conSenha.addEventListener("keyup", () => {
      if (senha.value != conSenha.value) {
        spnSenha.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
      } else {
        spnSenha.innerHTML = "<p class='text-success'>Ok</p>";
        if (senha.value === conSenha.value && senha.value.length < 8) {
          spnSenha.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
        }
      }
    })

    senha.addEventListener("keyup", () => {
      if (senha.value != conSenha.value) {
        spnSenha.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
      } else {
        spnSenha.innerHTML = "<p class='text-success'>Ok</p>";
        if (senha.value === conSenha.value && senha.value.length < 8) {
          spnSenha.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
        }
      }
    })


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
    chkDep4.addEventListener("click", () => {
      if (chkDep4.checked == true) {
        for (let it of dep4) {
          it.hidden = false;
        }
      } else {
        for (let it of dep4) {
          it.hidden = true;
        }
      }
    })
  </script>

  <?php
  if (isset($_SESSION['message'])) {
    echo "<script>alert('$message');</script>";
    session_abort();
  }
  ?>

</body>


</html>