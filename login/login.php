<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);
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


</head>

<body>
  <header>
    <div class="container d-flex flex-row align-items-center flex-wrap justify-content-end py-3" style="color: #b5221b;">
      <div class="px-2"><i class="bi bi-geo-alt-fill"></i><a class="text-reset" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/place/Cardiol%C3%B3gica+Medicina+Diagn%C3%B3stica/@-23.5017891,-46.6296408,17z/data=!3m1!5s0x94cef62912572b05:0xe31bc360c7afa97c!4m10!1m2!2m1!1scardiol%C3%B3gica+medicina+diagn%C3%B3stica+endere%C3%A7o!3m6!1s0x94cef62c1d7c945d:0x8e11d34a3ab45fd9!8m2!3d-23.5020952!4d-46.6271096!15sCi1jYXJkaW9sw7NnaWNhIG1lZGljaW5hIGRpYWduw7NzdGljYSBlbmRlcmXDp28iAkgBkgERZGlhZ25vc3RpY19jZW50ZXLgAQA!16s%2Fg%2F1tsyqx_6?entry=ttu">
          <b>Rua Salete, 200, Cj. 92</b></a></div>
      <div class="px-2"><i class="bi bi-envelope-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="mailto: agenda@cardiologica.net"><b>email@cardiologica.net</b></a> </i></div>
      <div class="px-2"><i class="bi bi-telephone-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="tel:+551121396900"><b>(11) 2139-6900</b></a> </i></div>
    </div>
  </header>

  <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" id="nav1">
    <div class="container-fluid ms-3 rounded">
      <a class="navbar-brand flutuante-text" href="../index.php">
        <img src="../imgs/cardMaisLogo.png" alt="Logo CardMais" width="70px" height="35px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse" aria-controls="navCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link flutuante-text" href="../saibaMais.php">Sobre Card+</a>
          </li>
          <li class="nav-item">
            <a class="nav-link flutuante-text" href="../parceiros.php">Parceiros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link flutuante-text" href="../contato.php">Fale Conosco</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container py-5 col-8" id="">
    <h2 class="text-center">Login</h2>
    <br>
    <fieldset class="p-4 rounded-3 field">
      <form action="<?php echo htmlspecialchars("../login/loginSecreto.php"); ?>" method="POST" id="frmIndividual">

        <div class="mb-3 col-8 m-auto">
          <label class="form-label" for="cpfLogin">CPF</label>
          <input type="text" class="form-control" maxlength="11" placeholder="Digite seu CPF" id="cpfLogin" name="cpfLogin" required>
        </div>

        <div class="mb-3 col-8 m-auto">
          <label class="form-label" for="senhaLogin">Senha</label>
          <input type="password" class="form-control" maxlength="100" placeholder="Digite sua senha" id="senhaLogin" name="senhaLogin" required>
          <span class="text-danger"><?php if (isset($_SESSION["msg"])) {
                                      echo $_SESSION["msg"];
                                      session_destroy();
                                    } else {
                                      echo "";
                                    } ?></span>
        </div>

        <div class="d-grid gap-2 pt-3 mb-3 container col-8">
          <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnLogin">Login</button>
        </div>

      </form>
    </fieldset>
  </div>






  <a data-bs-toggle="tooltip" data-bs-title="Tooltip on left" href="https://wa.me/55(aqui seu numero com ddd | tudo junto)?text=Adorei%20seu%20artigo" class="wpp flutuante" target="_blank">
    <i style="margin-top:16px" class="fa fa-whatsapp"></i>
  </a>


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
            <img src="../imgs/cardMaisLogo.png" class="img-fluid">
            <p>
              Seu cartão de benefícios.
            </p>
          </div>

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-1">

            <h6 class="text-uppercase fw-bold mb-4">Contatos</h6>
            <p><i class="bi bi-geo-alt-fill me-2"></i>Rua Salete, 200, Santana, SP - SP</p>
            <p><i class="bi bi-envelope-fill me-2"></i>info@example.com</p>
            <p><i class="bi bi-telephone-fill me-2"></i>(11) 2139-6900</p>
            <p><i class="bi bi-phone-fill me-2"></i>(11) 91111-1111 Whats</p>
          </div>

        </div>

      </div>
    </section>

    <div class="text-center p-4 mt-5" style="background-color: #b5221b;">
      © 2023 Copyright:
      <a class="text-reset fw-bold" href="cardiologica.net">Cardiológica Medicina Diagnóstica</a>
    </div>

  </footer>

</body>


</html>