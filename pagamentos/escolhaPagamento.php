<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

if (!isset($_SESSION['id'])) {
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
        <h3 class="text-center pb-5">Por favor, escolha sua forma de pagamento.</h3 class="text-center">

        <div id="divVl" class="text-center p-4 fw-bold"></div>

        <fieldset class="p-4 rounded-3 field">
            <input type="hidden" id="hddn" value="<?php echo htmlspecialchars($_SESSION['idPag']) ?>">
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="checkbox" role="switch" name="chkPag" id="chkCard">
                <label class="form-check-label" for="chkCard">Cartão de Crédito</label>
            </div>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="checkbox" role="switch" name="chkPag" id="chkPix">
                <label class="form-check-label" for="chkPix">PIX</label>
            </div>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="checkbox" role="switch" name="chkPag" id="chkBol">
                <label class="form-check-label" for="chkBol">Boleto</label>
            </div>

            <div class="d-grid gap-2 pt-3 mb-3 container" id="divBtn">
                <!-- <button class="btn btn-lg btn-card-contra shadow" id="btnCadAdm" type="submit">Cartão de Crédito</button> -->
            </div>

        </fieldset>
    </div>

</body>

<script>
    const chkPag = document.getElementsByName("chkPag");
    const divBtn = document.getElementById("divBtn");
    const hddn = document.getElementById("hddn");

    document.getElementById("divVl").innerHTML = "<p> Atenção! Você irá pagar agora o valor de: R$" +sessionStorage.getItem('valor') +"</p>"

    chkPag[0].addEventListener('change', () => {
        if (chkPag[0].checked == true) {
            chkPag[1].checked = false;
            chkPag[2].checked = false;
            var html = "<button class='btn btn-lg btn-card-contra shadow' id='btnCard' type='submit' onclick='gerarPag(\"CREDIT_CARD\")'>Ir para Pagamento com Cartão de Crédito</button>";
            divBtn.innerHTML = html;
        }
    })
    
    chkPag[1].addEventListener('change', () => {
        if (chkPag[1].checked == true) {
            chkPag[0].checked = false;
            chkPag[2].checked = false;
            var html = "<button class='btn btn-lg btn-card-contra shadow' id='btnPix' type='submit' onclick='gerarPag(\"PIX\")'>Ir para Pagamento com PIX</button>";
            divBtn.innerHTML = html;
        }
    })
    
    chkPag[2].addEventListener('change', () => {
        if (chkPag[2].checked == true) {
            chkPag[0].checked = false;
            chkPag[1].checked = false;
            var html = "<button class='btn btn-lg btn-card-contra shadow' id='btnBol' type='submit' onclick='gerarPag(\"BOLETO\")'>Ir para Pagamento com Boleto</button>";
            divBtn.innerHTML = html;
        }
    })

    function gerarPag(tipo){
    var xmlhttp = new XMLHttpRequest();
    var values = [];
    values.push(sessionStorage.getItem('id'));
    values.push(sessionStorage.getItem('valor'));
        values.push(sessionStorage.getItem('tipo'));
        values.push(sessionStorage.getItem('pedido'));
        values.push(tipo);
    
        xmlhttp.open("POST", "./gerarPagamento.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.send(JSON.stringify(values));
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resposta = JSON.parse(xmlhttp.response);
                window.open(resposta['link']);
                setTimeout(()=>{
                        window.location.replace("../login/infLogin.php");
                    }, 10000);
            }
        }
    }   
    
</script>

</html>