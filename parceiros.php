<?php
  require_once './conexao.php';

  session_set_cookie_params(['httponly' => true]);

  session_start();

  session_regenerate_id(true);

  error_reporting(0);

  ob_start()
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <title>Parceiros - CardMais</title>
  <meta name="title" property="og:title" content="parceiros - CardMais" />
  <meta name="description" property="og:description" content="Page Description" />
  <meta name="image" property="og:image" itemprop="image" content="./cardMaisLogo.png" />
  <meta name="type" property="og:type" content="website" />
  <meta name="url" property="og:url" content="https://url.page" />
  <meta name="site_name" property="og:site_name" content="CardMais" />
  <meta name="locale" property="og:locale" content="pt_BR" />

  <link rel="icon" type="image/jpg" href="./imgs/cardMaisLogo.png" />


  <link rel="stylesheet" href="./css/bootstrap.css">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


  <script src="./js/bootstrap.bundle.min.js"></script>

</head>

<body>

  <!-- Cabeçalho  -->
  <header>
    <div class="container d-flex flex-row align-items-center flex-wrap justify-content-end py-3" style="color: #b5221b;">
      <div class="px-2"><i class="bi bi-geo-alt-fill"></i><a class="text-reset" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/place/Cardiol%C3%B3gica+Medicina+Diagn%C3%B3stica/@-23.5017891,-46.6296408,17z/data=!3m1!5s0x94cef62912572b05:0xe31bc360c7afa97c!4m10!1m2!2m1!1scardiol%C3%B3gica+medicina+diagn%C3%B3stica+endere%C3%A7o!3m6!1s0x94cef62c1d7c945d:0x8e11d34a3ab45fd9!8m2!3d-23.5020952!4d-46.6271096!15sCi1jYXJkaW9sw7NnaWNhIG1lZGljaW5hIGRpYWduw7NzdGljYSBlbmRlcmXDp28iAkgBkgERZGlhZ25vc3RpY19jZW50ZXLgAQA!16s%2Fg%2F1tsyqx_6?entry=ttu">
          <b>Rua Salete, 200, Cj. 92</b></a></div>
      <div class="px-2"><i class="bi bi-envelope-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="mailto: agenda@cardiologica.net"><b>email@cardiologica.net</b></a> </i></div>
      <div class="px-2"><i class="bi bi-telephone-fill"><a class="text-reset" target="_blank" rel="noopener noreferrer" href="tel:+551121396900"><b>(11) 2139-6900</b></a> </i></div>
    </div>
  </header>
  <!-- Fim do cabeçalho -->

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
  <!-- Fim da barra de navegação  -->


  <!-- Começo do corpo da página  -->
  <div class="container col-xxl-8 px-4 py-4">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="./imgs/parceiros.jpg" class="d-block mx-lg-auto img-fluid rounded-4" alt="..." width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Parceiros</h1>
      </div>
    </div>
  </div>



  <!-- Pesquisa os tipos de atendimento -->
  <div class="container py-5" disabled>
    <?php
    $slctTipo = "SELECT * FROM tipoatendimento ORDER BY descTipo ASC";
    $slctTipo = $conn->prepare($slctTipo);
    $slctTipo->execute();
    $slctTipo = $slctTipo->get_result();
    ?>
    <div class="row align-items-center">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="col">
          <select name="slctTipo" id="slctTipo" class="form-control text-center fw-bold" style="width: 100%;">
            <option value="" selected disabled>Selecione o Atendimento</option>
            <?php
            while ($dados = $slctTipo->fetch_assoc()) {
              echo '<option value="' . $dados['idTipo'] . '">' . $dados['descTipo'] . '</option>';
            }
            ?>
          </select>
        </div>
    </div>
  </div>
  <!-- Fim pesquisa tipos de atendimento -->



  <!-- Divisão Atendimento Odontológico e Farmácias -->
  <div class="container py-5" hidden id="divAo">

    <div class="row">
      <div class="col">
        <select name="slctRegiao" id="slctRegiao" class="form-control">
          <option value="" selected disabled>Selecione a Região</option>
          <option value="zn">Zona Norte</option>
          <option value="zs">Zona Sul</option>
          <option value="cn">Centro</option>
          <option value="zl">Zona Leste</option>
          <option value="zo">Zona Oeste</option>
        </select>
      </div>
      <div class="col">
        <div class="d-grid gap-2">
          <button class="btn btn-lg btn-card-contra" type="submit">Pesquisar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fim divisão atendimento odontológico e Farmácias -->

  <!-- Divisão Exames complementares -->
  <div class="container py-5" hidden disabled id="divEc">
    <div class="row align-items-center">
      <div class="col">
        <input type="text" class="form-control" placeholder="Pesquise o Procedimento" id="pesquisarProc" name="pesquisarProc" onkeyup="carregar_proc(this.value)">
        <span id="spnProc"></span>
        <input type="text" hidden id="tuss" name="tuss">
      </div>
      <div class="col">
        <select name="slctRegiao" id="slctRegiao" class="form-control">
          <option value="" selected disabled>Selecione a Região</option>
          <option value="zn">Zona Norte</option>
          <option value="zs">Zona Sul</option>
          <option value="cn">Centro</option>
          <option value="zl">Zona Leste</option>
          <option value="zo">Zona Oeste</option>
        </select>
      </div>
      <div class="col">
        <div class="d-grid gap-2">
          <button class="btn btn-lg btn-card-contra" type="submit">Pesquisar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fim divisão exames complementares -->

  <!-- Divisão Atendimento Ambulatorial  -->
  <div class="container py-5" hidden id="divAma">
    <div class="row">
      <div class="col">
        <select name="slctRegiao" id="slctRegiao" class="form-control">
          <option value="" selected disabled>Selecione a Região</option>
          <option value="zn">Zona Norte</option>
          <option value="zs">Zona Sul</option>
          <option value="cn">Centro</option>
          <option value="zl">Zona Leste</option>
          <option value="zo">Zona Oeste</option>
        </select>
      </div>
      <div class="col">
        <select name="slctEspecialidade" id="slctEspecialidade" class="form-control">
          <option value="" selected disabled>Selecione a Especialidade</option>
          <?php
          $slctEspecs = $conn->prepare("SELECT * FROM especialidades WHERE descEspecialidade NOT IN('Análises Clínicas', 'Consultas', 'Neurofisiologia', 'Radiodiagnósticos', 'Tomografia', 'Ultrassonografia') ORDER BY descEspecialidade ASC");
          $slctEspecs->execute();
          $slctEspecs = $slctEspecs->get_result();

          while ($row = $slctEspecs->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['idEspecialidade']) . "'>" . htmlspecialchars($row['descEspecialidade']) . "</option>";
          }

          $slctEspecs->close();
          ?>
        </select>
      </div>
      <div class="col">
        <div class="d-grid gap-2">
          <button class="btn btn-lg btn-card-contra" type="submit">Pesquisar</button>
        </div>
      </div>
    </div>
    </form>
  </div>
  <!-- Fim divisão atendimento ambulatorial -->


  <!-- Divisão de pesquisa dos parceiros de acordo com o tipo de atendimento e filtros escolhidos -->
  <div class="container py-5">
    <?php

    function validarString($string)
    {
      return trim($string);
    }

    $tuss = isset($_POST['tuss']) ? validarString($_POST['tuss']) : '';
    $slctRegiao = isset($_POST['slctRegiao']) ? validarString($_POST['slctRegiao']) : '';
    $slctEspecialidade = isset($_POST['slctEspecialidade']) ? validarString($_POST['slctEspecialidade']) : '';
    $slctTipo = htmlspecialchars($_POST['slctTipo']);


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      try {

        if ($slctRegiao != null && $tuss != null) {
          $slct = $conn->prepare("SELECT a.idParceiro, a.nomeParceiro, a.ruaParceiro, a.bairroParceiro, a.cidadeParceiro, a.estadoParceiro, a.numeroParceiro 
                    FROM parceiros a
                    INNER JOIN tabela_procedimentos b ON b.idParceiro = a.idParceiro
                    INNER JOIN tblprocedimentos c ON b.idTblProcedimento = c.idTblProcedimento
                    INNER JOIN procedimentos d ON d.idProcedimento = c.idProcedimento
                    INNER JOIN tipoatendimentoparceiro e ON e.idParceiro = a.idParceiro
                    WHERE d.idProcedimento = ? AND a.regiaoParceiro = ? AND e.idTipo = ?
                    GROUP BY a.nomeParceiro
                    ORDER BY a.nomeParceiro LIMIT 20");
          $slct->bind_param("ssi", $tuss, $slctRegiao, $slctTipo);
        } elseif ($slctEspecialidade != null && $slctRegiao != null) {
          $slct = $conn->prepare("SELECT c.idParceiro, c.nomeParceiro, c.ruaParceiro, c.bairroParceiro, c.cidadeParceiro, c.estadoParceiro, c.numeroParceiro 
                    FROM especialidades a
                    INNER JOIN parceiros_especialidades b ON a.idEspecialidade = b.idEspecialidade
                    INNER JOIN parceiros c ON b.idParceiro = c.idParceiro
                    INNER JOIN tipoatendimentoparceiro d ON d.idParceiro = c.idParceiro
                    WHERE b.idEspecialidade = ? AND c.regiaoParceiro = ? AND d.idTipo = ?
                    GROUP BY c.nomeParceiro
                    ORDER BY c.nomeParceiro ASC");
          $slct->bind_param("sss", $slctEspecialidade, $slctRegiao, $slctTipo);
        } elseif ($tuss != null) {
          $slct = $conn->prepare("SELECT a.idParceiro, a.nomeParceiro, a.ruaParceiro, a.bairroParceiro, a.cidadeParceiro, a.estadoParceiro, a.numeroParceiro
              FROM parceiros a
              INNER JOIN tabela_procedimentos b ON b.idParceiro = a.idParceiro
              INNER JOIN tblprocedimentos c ON b.idTblProcedimento = c.idTblProcedimento
              INNER JOIN procedimentos d ON d.idProcedimento = c.idProcedimento
              INNER JOIN tipoatendimentoparceiro e ON e.idParceiro = a.idParceiro
              WHERE d.idProcedimento = ? AND e.idTipo = ?
              GROUP BY a.nomeParceiro
              ORDER BY a.nomeParceiro LIMIT 20");
          $slct->bind_param("si", $tuss, $slctTipo);
        } elseif ($slctEspecialidade != null) {
          $slct = $conn->prepare("SELECT c.idParceiro, c.nomeParceiro, c.ruaParceiro, c.bairroParceiro, c.cidadeParceiro, c.estadoParceiro, c.numeroParceiro 
                    FROM especialidades a
                    INNER JOIN parceiros_especialidades b ON a.idEspecialidade = b.idEspecialidade
                    INNER JOIN parceiros c ON b.idParceiro = c.idParceiro
                    INNER JOIN tipoatendimentoparceiro d ON d.idParceiro = c.idParceiro
                    WHERE b.idEspecialidade = ? AND d.idTipo = ?
                    GROUP BY c.nomeParceiro
                    ORDER BY c.nomeParceiro ASC");
          $slct->bind_param("si", $slctEspecialidade, $slctTipo);
        } elseif ($slctRegiao != null) {
          $slct = $conn->prepare("SELECT c.idParceiro, c.nomeParceiro, c.ruaParceiro, c.bairroParceiro, c.cidadeParceiro, c.estadoParceiro, c.numeroParceiro 
                    FROM especialidades a
                    INNER JOIN parceiros_especialidades b ON a.idEspecialidade = b.idEspecialidade
                    INNER JOIN parceiros c ON b.idParceiro = c.idParceiro
                    INNER JOIN tipoatendimentoparceiro d ON d.idParceiro = c.idParceiro
                    WHERE c.regiaoParceiro = ? AND d.idTipo = ?
                    GROUP BY c.nomeParceiro
                    ORDER BY c.nomeParceiro ASC");
          $slct->bind_param("si", $slctRegiao, $slctTipo);
        }

        $slct->execute();
        $slct = $slct->get_result();

        if ($conn->errno == 0) {
          while ($row = $slct->fetch_assoc()) {
            echo '<div class="d-grid gap-2">
                    <a class="btn btn-lg btn-card-contra" href="./consultas/infParceiros.php?id=' . htmlspecialchars($row['idParceiro']) . '">' . htmlspecialchars($row['nomeParceiro'])
              . '<br>' . htmlspecialchars($row['ruaParceiro']) . ', ' . htmlspecialchars($row['numeroParceiro']) . ' - ' . htmlspecialchars($row['bairroParceiro']) . ' - ' . htmlspecialchars($row['cidadeParceiro']) . ' - ' . htmlspecialchars($row['estadoParceiro']) . '</a>
                  </div>';
          }
        } else {
          echo "Nenhum Parceiro encontrado com esses Filtros";
        }
        $slct->close();
        $conn->close();
      } catch (\Throwable $th) {
        echo "Erro: " . $th->getMessage();
        $conn->close();
      }
    }

    ?>
  </div>

  <!-- Fim divisão de pesquisa -->

  <!-- Botão WhatsApp -->

  <a data-bs-toggle="tooltip" data-bs-title="Tooltip on left" href="https://wa.me/55(aqui seu numero com ddd | tudo junto)?text=Adorei%20seu%20artigo" class="wpp flutuante" target="_blank">
    <i style="margin-top:16px" class="fa fa-whatsapp"></i>
  </a>

  <!-- Fim Botão WhatsApp -->

  <!-- Carrinho Bottom -->
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
  <!-- Fim Carrinho Bottom -->

  <!-- Fim Corpo da página -->


  <!-- Rodapé -->
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
      <!-- © 2023 Copyright:
      <a class="text-reset fw-bold" href="cardiologica.net">Cardiológica Medicina Diagnóstica</a> -->
    </div>

  </footer>
  <!-- Fim do rodapé -->
</body>

</html>


<!-- Scripts em JS -->
<script>
  async function carregar_proc(valor) {
    if (valor.length >= 3) {
      const dados = await fetch('./consultas/listarProcedimentos.php?desc=' + valor);
      const resposta = await dados.json();

      var html = "<ul class='list-group'>";

      if (resposta["erro"]) {
        html += "<li class='list-group-item disabled'>" + resposta["msg"] + "</li>"
      } else {
        for (let i = 0; i < resposta['dados'].length; i++) {
          html += "<li class='list-group-item list-group-item-action' onclick='getProc(" + resposta["dados"][i].id + "," + JSON.stringify(resposta["dados"][i].desc) + ")'>" + resposta["dados"][i].desc + "</li>"
        }
      }

      html += "</ul>"

      document.getElementById("spnProc").innerHTML = html;

    }
  }

  function getProc(id, desc) {
    document.getElementById("pesquisarProc").value = desc;
    document.getElementById("tuss").value = id;
  }

  document.addEventListener("click", function(event) {
    const valida = document.getElementById("pesquisarProc").contains(event.target);
    if (!valida) {
      document.getElementById("spnProc").innerHTML = "";
    }
  })


  document.getElementById("slctTipo").addEventListener("change", () => {
    if (document.getElementById("slctTipo").value == 1) {
      document.getElementById("divAma").hidden = false;
      document.getElementById("divAo").hidden = true;
      document.getElementById("divEc").hidden = true;
    }
    if (document.getElementById("slctTipo").value == 2) {
      document.getElementById("divEc").hidden = true;
      document.getElementById("divAo").hidden = false;
      document.getElementById("divAma").hidden = true;
    }
    if (document.getElementById("slctTipo").value == 3) {
      document.getElementById("divEc").hidden = false;
      document.getElementById("divAo").hidden = true;
      document.getElementById("divAma").hidden = true;
    }
    if (document.getElementById("slctTipo").value == 4) {
      document.getElementById("divEc").hidden = true;
      document.getElementById("divAo").hidden = false;
      document.getElementById("divAma").hidden = true;
    }
  })
</script>
<!-- Fim Scripts JS -->