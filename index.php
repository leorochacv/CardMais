<?php
  session_set_cookie_params(['httponly' => true]);

  session_start();

  session_regenerate_id(true);

  error_reporting(0);
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
  <meta name="description" property="og:description" content="O CardMais Saúde é um cartão de benefícios criado para quem não tem plano de saúde. Através do CardMais Saúde você pode realizar procedimentos ambulatoriais tais como exames complementares e consultas médicas nas mais diversas especialidades a um valor bastante acessível." />
  <meta name="image" property="og:image" itemprop="image" content="../imgs/cardMaisLogo.png" />
  <meta name="type" property="og:type" content="website" />
  <meta name="url" property="og:url" content="https://url.page" />
  <meta name="site_name" property="og:site_name" content="CardMais Saúde" />
  <meta name="locale" property="og:locale" content="pt_BR" />

  <link rel="icon" type="image/jpg" href="./imgs/cardMaisLogo.png" />

  <link rel="stylesheet" href="./css/bootstrap.css">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <script src="./js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <!-- Cabeçalho -->
  <header>
    <div class="container d-flex flex-row align-items-center flex-wrap  justify-content-end py-3" style="color: #b5221b;">
      <div class="px-2"><i class="bi bi-geo-alt-fill"></i><a class="text-reset" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/place/Cardiol%C3%B3gica+Medicina+Diagn%C3%B3stica/@-23.5017891,-46.6296408,17z/data=!3m1!5s0x94cef62912572b05:0xe31bc360c7afa97c!4m10!1m2!2m1!1scardiol%C3%B3gica+medicina+diagn%C3%B3stica+endere%C3%A7o!3m6!1s0x94cef62c1d7c945d:0x8e11d34a3ab45fd9!8m2!3d-23.5020952!4d-46.6271096!15sCi1jYXJkaW9sw7NnaWNhIG1lZGljaW5hIGRpYWduw7NzdGljYSBlbmRlcmXDp28iAkgBkgERZGlhZ25vc3RpY19jZW50ZXLgAQA!16s%2Fg%2F1tsyqx_6?entry=ttu">
          <b>Rua Salete, 200, Cj. 92</b></a></div>
      <div class="px-2"><i class="bi bi-envelope-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="mailto: agenda@cardiologica.net"><b>email@cardiologica.net</b></a> </i></div>
      <div class="px-2"><i class="bi bi-telephone-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="tel:+551121396900"><b>(11) 2139-6900</b></a> </i></div>
    </div>
  </header>
  <!-- Fim Cabeçalho -->

  <!-- Barra de navegação -->
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
          echo '<a class="btn btn-card-contra" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas"><i class="bi bi-cart-fill"></i></a>';
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
  <!-- Fim da barra de navegação -->

  <!-- Corpo da página -->
  <div style="background-image: linear-gradient(to bottom, white, lightblue);" data-bs-spy="scroll" data-bs-target="#nav1" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
    <div>
      <img src="./imgs/Topo.png" class="d-block img-fluid" alt="">
    </div>
    <div class="d-flex flex-row-reverse flex-wrap-reverse d-block">
      <div class="text-end">
        <img src="./imgs/MaoComCartao2.png" class="img-fluid" alt="...">
      </div>
      <div class="text-start flex-fill mt-3 py-5 ps-5">
        <p class="fw-bold fs-4">Consultas médicas e exames</p>
        <p class="fw-bold fs-4">a um <span style="color: #b5221b;">preço</span> realmente <span style="color: #b5221b;">acessível</span>.</p>

        <a class='btn btn-sm btn-ind shadow text-center fs-5 mt-5 fw-bold' style="width: 80%; cursor: default;" data-bs-toggle="tooltip" data-bs-title="Default tooltip">Taxa única Plano Mensal - R$50</a><br>
        <a class='btn btn-sm btn-ind shadow text-center fs-5 mt-3 fw-bold' style="width: 80%; cursor: default;">Taxa única Plano Trimestral - R$200</a><br>
        <a class='btn btn-sm btn-ind shadow text-center fs-5 mt-3 fw-bold' style="width: 80%; cursor: default;">Taxa única Plano Semestral - R$350</a><br>
        <a class='btn btn-sm btn-ind shadow text-center fs-5 mt-3 fw-bold' style="width: 80%; cursor: default;">Taxa única Plano Anual - R$600</a><br>
        <span><b>Todos os planos abrangem Titular +4 Dependentes.</b></span>
        
        <div class="ps-lg-5 pt-3 fw-bold fs-5">
          <p>Cuidar bem da sua saúde agora cabe no seu bolso.</p>
        </div>

        <div class="pt-3">
          <a class='btn btn-sm btn-card shadow text-center fs-5 fw-bold' style="width: 80%" href="./saibaMais.php">Saíba Mais</a><br>
        </div>
        
      </div>
      <div class="text-start pt-5 ps-5 d-none d-sm-block">
        <img src="./imgs/arrow-right-circle-fill.svg" class="img-fluid" width="125">
      </div>
      <div class="text-center pt-5 flex-fill d-block d-sm-none">
        <img src="./imgs/arrow-down-circle-fill.svg" class="img-fluid" width="125">
      </div>

    </div>

    <a class="wpp flutuante" href="#">
      <i style="margin-top:16px" class="fa fa-whatsapp" data-bs-trigger="manual" data-bs-toggle="popover" data-bs-content="Popover" data-ls-popover="open" id="popwpp"></i>
    </a>
    <!-- target -->
    <!-- href="https://wa.me/55(aqui seu numero com ddd | tudo junto)?text=Adorei%20seu%20artigo" -->
  </div>
  <!-- Fim do corpo da página -->

  <!-- Carrinho no Bottom  -->
  <div class="offcanvas offcanvas-bottom" data-bs-scroll="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header bg-danger-subtle">
      <i class="bi bi-cart-fill"></i>
      <h5 class="offcanvas-title" id="offcanvasLabel">Carrinho</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <?php
      if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) != 0) {
      ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Tuss</th>
              <th scope="col">Descrição</th>
              <th scope="col">Valor</th>
              <th scope="col">Parceiro</th>
            </tr>
          </thead>
          <?php
          $n = 0;
          foreach ($_SESSION['procs'] as $k => $produto) {
            foreach ($_SESSION['carrinho'] as $key => $value) {
              if (($produto['idProcedimento'] == $value[$produto['idProcedimento']]['idProcedimento'])) {
                $n++;
          ?>
                <tbody>
                  <tr>
                    <td scope="row"><?php echo $n ?></td>
                    <td><?php echo htmlspecialchars($value[$produto['idProcedimento']]['idProcedimento']) ?></td>
                    <td><?php echo htmlspecialchars($value[$produto['idProcedimento']]['descProcedimento']) ?></td>
                    <td><?php echo "R$" . htmlspecialchars($value[$produto['idProcedimento']]['vlProcedimento']) ?></td>
                    <td><?php echo htmlspecialchars($value[$produto['idProcedimento']]['nomeParceiro']) ?></td>
                    <td>
                      <form action="./consultas/limparCarrinho.php" method="post">
                        <input type="hidden" name="parc-proc" value="<?php echo $key . "-" . $value[$produto['idProcedimento']]['idProcedimento'] ?>">
                        <button class="btn btn-sm btn-card-contra" type="submit" name="remover" value="Remover"><i class="bi bi-trash3-fill"></i></button>
                      </form>
                    </td>
                  </tr>
                </tbody>

          <?php
                $vlTotal += $value[$produto['idProcedimento']]['vlProcedimento'];
              }
            }
          }
          ?>
          <tfoot>
            <td></td>
            <td></td>
            <td></td>
            <td class="fw-bold"><?php echo "Valor Total: R$" . htmlspecialchars($vlTotal) ?></td>
            <td><a href="./consultas/carrinho.php" class="btn btn-card-contra btn-sm">Ir para o Carrinho</a></td>
          </tfoot>
        </table>

      <?php
      } else {
        echo "<h3>Seu Carrinho está vazio.</h3>";
      }
      ?>
    </div>
  </div>
  <!-- Fim carrinho no Bottom -->

  <!-- Rodapé -->
  <footer class="text-center text-lg-start bg-light text-muted">

    <section class="d-flex justify-content-center justify-content-lg-between p-4">

      <div class="me-5 d-none d-lg-block">
        <span><b>Siga-nos nas Redes Sociais</b></span>
      </div>



      <div>
        <a href="https://www.facebook.com/cardiologicasantanasp" class="me-4 text-reset">
          <i class="bi bi-facebook flutuante-text" style="color: #b5221b;"> </i>
        </a>
        <a href="#" class="me-4 text-reset">
          <i class="bi bi-google flutuante-text" style="color: #b5221b;"> </i>
        </a>
        <a href="https://www.instagram.com/cardiologicasantanasp?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="me-4 text-reset">
          <i class="bi bi-instagram flutuante-text" style="color: #b5221b;"> </i>
        </a>
      </div>




    </section>

    <hr class="featurette-divider" style="color: red;">

    <section>
      <div class="container text-center text-md-start mt-5 ">

        <div class="row mt-3">

          <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mb-4 text-center">
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

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-1">
            <h6 class="text-uppercase fw-bold mb-4">Outros</h6>
            <div class="list-group list-group-flush">
              <p class=""><a href="./parceiros/loginParceiro.php" class="text-reset">Sou Parceiro</a></p>
              <p class=""><a href="./administrativo/loginAdm.php" class="text-reset">Sou Administrativo</a></p>
              <p class=""><a href="./vendedores/loginVend.php" class="text-reset">Sou Vendedor</a></p>
            </div>
          </div>

        </div>

      </div>
    </section>

    <div class="text-center p-4 mt-5" style="background-color: #b5221b;">
      <!-- © 2023 Copyright:
      <a class="text-reset fw-bold" href="cardiologica.net">Cardiológica Medicina Diagnóstica</a> -->
    </div>

  </footer>
  <!-- Fim do Rodapé  -->
</body>
</html>

<!-- Se existir alguma sessão de mensagem, exibe a mensagem  -->
<?php
  if (isset($_SESSION['msg'])) {
    echo "<script>alert('" . $_SESSION['msg'] . "');</script>";
    unset($_SESSION['msg']);
  }
?>