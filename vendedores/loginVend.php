<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

if (isset($_SESSION['idAdm'])) {
  header("Location: ../index.php");
}
if (isset($_SESSION['id'])) {
  header("Location: ../index.php");
}
if (isset($_SESSION['idPar'])) {
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

      </div>
    </div>
  </nav>


  <div class="container py-5 col-8" id="">
    <h2 class="text-center">Login Vendedores</h2>
    <br>
    <fieldset class="p-4 rounded-3 field">
      <form action="<?php echo htmlspecialchars("../vendedores/loginSecretoVend.php"); ?>" method="POST" id="frmIndividual">

        <div class="mb-3 col-8 m-auto">
          <label class="form-label" for="nickLogin">Login</label>
          <input type="text" class="form-control" maxlength="11" placeholder="Digite seu Login" id="nickLogin" name="nickLogin" required>
        </div>

        <div class="mb-3 col-8 m-auto">
          <label class="form-label" for="senhaLogin">Senha</label>
          <input type="password" class="form-control" maxlength="100" placeholder="Digite sua senha" id="senhaLogin" name="senhaLogin" required>
        </div>

        <div class="d-grid gap-2 pt-3 mb-3 container col-8">
          <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnLogin">Login</button>
        </div>

      </form>
    </fieldset>
  </div>






</body>

</html>

<?php
if (isset($_SESSION['msg'])) {
  echo "<script>alert('" . htmlspecialchars($_SESSION['msg']) . "');</script>";
  unset($_SESSION['msg']);
}
?>