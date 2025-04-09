<?php
    require_once '../conexao.php';

    error_reporting(0);

    session_set_cookie_params(['httponly' => true]);

    session_start();

    session_regenerate_id(true);

    $idParceiro = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    $slct = "SELECT * FROM parceiros WHERE idParceiro = ?";
    $slct = $conn->prepare($slct);
    $slct->bind_param("i", $idParceiro);
    $slct->execute();
    $slct = $slct->get_result();
    $slct = $slct->fetch_assoc();
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


    <!-- <script src="../js/bootstrap.js"></script> -->
    <script src="../js/bootstrap.bundle.min.js"></script>

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
                <div class="">
                    <?php
                    if (isset($_SESSION['statusCartao']) && $_SESSION['statusCartao'] == 1) {
                        echo '<a class="btn btn-card-contra" href="./carrinho.php"><i class="bi bi-cart-fill"></i></a>';
                    }

                    if (isset($_SESSION["id"])) {
                        echo '<a class="btn btn-card-contra text-end flutuante-text" href="../login/infLogin.php"><i class="bi bi-person-circle"> Olá ' . htmlspecialchars($_SESSION['nomePaciente']) . '</i></a>';
                    } else {
                        echo '<a class="btn btn-card-contra text-end flutuante-text" href="../login/login.php"><i class="bi bi-person-circle"> Entrar</i></a>
                            <a class="btn btn-card-contra flutuante-text" href="../formulario.php">Adquira já o seu</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>



    <div class="container py-5">
        <h1 class="text-center fw-bold"><?php echo 'Parceiro: ' . htmlspecialchars($slct['nomeParceiro']); ?></h1>

        <div class="row p-4">
            <div class="col-6">
                <ul class="list-group">
                    <li class="list-group-item fs-4 fw-bold text-center">Endereço do Parceiro:</li>
                    <li class="list-group-item fs-5"><?php echo '<b>Logradouro: </b>' . htmlspecialchars($slct['ruaParceiro']) . ' - ' . htmlspecialchars($slct['numeroParceiro']); ?></li>
                    <li class="list-group-item fs-5"><?php echo '<b>Bairro: </b>' . htmlspecialchars($slct['bairroParceiro']); ?></li>
                    <li class="list-group-item fs-5"><?php echo '<b>Cidade: </b>' . htmlspecialchars($slct['cidadeParceiro']); ?></li>
                    <li class="list-group-item fs-5"><?php echo '<b>Estado: </b>' . htmlspecialchars($slct['estadoParceiro']); ?></li>
                    <li class="list-group-item fs-5"><?php echo '<b>Complemento: </b>' . htmlspecialchars($slct['complParceiro']); ?></li>
                    <li class="list-group-item fs-5"><?php echo '<b>CEP: </b>' . htmlspecialchars($slct['cepParceiro']); ?></li>
                </ul>
            </div>
            <div class="col-6">
                <ul class="list-group">
                    <li class="list-group-item fs-4 fw-bold text-center">Contatos do Parceiro:</li>
                    <li class="list-group-item fs-5"><?php echo '<b>Telefone: </b>' . htmlspecialchars($slct['telefoneParceiro']); ?></li>
                    <li class="list-group-item fs-5"><?php echo '<b>Telefone Opcional: </b>' . htmlspecialchars($slct['telefoneOpcParceiro']); ?></li>
                    <li class="list-group-item fs-5 text-break"><?php echo '<b>Email: </b>' . htmlspecialchars($slct['emailParceiro']); ?></li>
                </ul>
            </div>
        </div>

        <div class="row p-5">
            <?php
            $procs;
            if (!isset($_SESSION["id"])) {
                echo "<p class='fs-6 fw-bold'>Para saber mais informações de procedimentos e preços desse parceiro, faça Login!</p>";
            } else if (isset($_SESSION["id"]) && isset($_SESSION['statusCartao']) && $_SESSION['statusCartao'] == 1) {
                $procs = "SELECT a.idProcedimento, d.descProcedimento, a.vlProcedimento, c.idParceiro, c.nomeParceiro, d.tussProcedimento
                                    FROM tblprocedimentos a 
                                    INNER JOIN tabela_procedimentos b ON a.idTblProcedimento = b.idTblProcedimento 
                                    INNER JOIN parceiros c ON c.idParceiro = b.idParceiro 
                                    INNER JOIN procedimentos d ON d.idProcedimento = a.idProcedimento 
                                    WHERE c.idParceiro = ?;";
                $procs = $conn->prepare($procs);
                $procs->bind_param("i", $idParceiro);
                $procs->execute();
                $procs = $procs->get_result();


                echo "<table class='table table-bordered border-3 rounded align-middle text-center'>";
                echo "<tr>
                                    <th>Procedimento</th>
                                    <th>Valor</th>
                                    <th>Carrinho</th>
                                </tr>";
                while ($row = $procs->fetch_assoc()) {
                    $_SESSION['procs'][$row['idProcedimento']] = $row;
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['tussProcedimento']) . " - " . htmlspecialchars($row['descProcedimento']) . "</td>";
                    echo "<td>" . "R$" . htmlspecialchars($row['vlProcedimento']) . "</td>";
                    echo "<td><a class='btn btn-card-contra' name='" . htmlspecialchars($row['idProcedimento']) . "-" . htmlspecialchars($row['idParceiro']) . "' onclick='setCarrinho(this.name)'><i class='bi bi-cart-plus-fill'></i></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                $procs = "SELECT a.idProcedimento, d.descProcedimento, a.vlProcedimento, d.tussProcedimento 
                                    FROM tblprocedimentos a 
                                    INNER JOIN tabela_procedimentos b ON a.idTblProcedimento = b.idTblProcedimento 
                                    INNER JOIN parceiros c ON c.idParceiro = b.idParceiro 
                                    INNER JOIN procedimentos d ON d.idProcedimento = a.idProcedimento 
                                    WHERE c.idParceiro = ?;";
                $procs = $conn->prepare($procs);
                $procs->bind_param("i", $idParceiro);
                $procs->execute();
                $procs = $procs->get_result();

                echo "<table class='table table-bordered border-3 rounded align-middle text-center'>";
                echo "<tr>
                                    <th>Procedimento</th>
                                    <th>Valor</th>
                                </tr>";
                while ($row = $procs->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['tussProcedimento']) . " - " . htmlspecialchars($row['descProcedimento']) . "</td>";
                    echo "<td>" . "R$" . htmlspecialchars($row['vlProcedimento']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>
    </div>


    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToastErro" class="toast bg-danger-subtle" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Carrinho</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Procedimento já existe no carrinho!!
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToastOk" class="toast bg-success-subtle" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Carrinho</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-ok">
            </div>
        </div>
    </div>


    <footer class="text-center text-lg-start bg-light text-muted">

        <section class="d-flex justify-content-center justify-content-lg-between p-4">

            <div class="me-5 d-none d-lg-block">
                <span><b>Siga-nos nas Redes Sociais</b></span>
            </div>



            <div>
                <a href="" class="me-4 text-reset">
                    <i class="bi bi-facebook flutuante-text" style="color: #b5221b;"> </i>
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

    <script>
        function setCarrinho(valor) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "./criarCarrinho.php?cod=" + valor, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resposta = JSON.parse(xmlhttp.response);

                    if (resposta == 0) {
                        const toastLiveExample = document.getElementById('liveToastErro')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                        toastBootstrap.show()
                    } else {
                        const valores = valor.split("-");
                        const proc = valores[0];
                        const parc = valores[1];

                        for (let key in resposta) {
                            if (key == parc) {
                                let objetoParc = resposta[key];
                                if (objetoParc.hasOwnProperty(proc)) {
                                    document.getElementById("toast-ok").innerText = resposta[key][proc]['descProcedimento'] + " Adicionado ao carrinho!";
                                    const toastLiveExample = document.getElementById('liveToastOk')
                                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                                    toastBootstrap.show()
                                }
                            }
                        }

                    }
                }
            }
        }
    </script>




</body>

</html>