<?php
session_start();

require_once '../conexao.php';
// require '../email/enviarEmail.php';

session_set_cookie_params(['httponly' => true]);

ob_start();

session_regenerate_id(true);

if (!isset($_SESSION['id'])) {
    header("Location: index.php");

    die();
}

$idParceiro = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$dataAtual = date("Y-m-d");
$dataValidade = date('Y-m-d', strtotime('+1 year'));

$valor = 0;

$slct = "SELECT * FROM pacientes WHERE idPaciente = ?";
$slct = $conn->prepare($slct);
$slct->bind_param("i", $_SESSION['id']);
$slct->execute();
$slct = $slct->get_result();
$slct = $slct->fetch_assoc();

$slct2 = "SELECT * FROM dependentes WHERE idPaciente = ?";
$slct2 = $conn->prepare($slct2);
$slct2->bind_param("i", $_SESSION['id']);
$slct2->execute();
$slct2 = $slct2->get_result();

$slct3 = $conn->prepare("SELECT * FROM cartoes WHERE idPaciente = ?");
$slct3->bind_param("i", $_SESSION['id']);
$slct3->execute();
$slct3 = $slct3->get_result();
$slct3 = $slct3->fetch_assoc();

$slctValPedidos = $conn->prepare("SELECT idPedido FROM pedidos WHERE dataValidade = ? AND idPaciente = ?");
$slctValPedidos->bind_param("si", $dataAtual, $_SESSION['id']);
$slctValPedidos->execute();
$slctValPedidos = $slctValPedidos->get_result();
if ($slctValPedidos->num_rows > 0) {
    while ($r = $slctValPedidos->fetch_assoc()) {
        $updtStatusVal = $conn->prepare("UPDATE pedidos SET status = 5 WHERE idPedido = ?");
        $updtStatusVal->bind_param("i", $r['idPedido']);
        $updtStatusVal->execute();
        $updtStatusVal->store_result();
    }
}

if ((($slct3['idTransacao'] != null) && ($slct3['statusCartao'] == 0)) || ($slct3['statusCartao'] == 3)) {

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/$slct3[idTransacao]/status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "access_token: \$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNzYzODI6OiRhYWNoXzFmYjg5Y2EzLTIxYWMtNDBlZC1hMDQyLTJjM2RhMGU3YzU2MQ=="
        ],
    ]);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $resposta = json_decode($response);

        if (($resposta->status == "CONFIRMED") || ($resposta->status == "RECEIVED")) {
            $updt = $conn->prepare("UPDATE cartoes SET statusCartao = '1', dtObtidoCartao = ?, dtValidadeCartao = ? WHERE idPaciente = ?");
            $updt->bind_param("ssi", $dataAtual, $dataValidade, $_SESSION['id']);
            $updt->execute();
            $updt->close();

            $slct3 = $conn->prepare("SELECT * FROM cartoes WHERE idPaciente = ?");
            $slct3->bind_param("i", $_SESSION['id']);
            $slct3->execute();
            $slct3 = $slct3->get_result();
            $slct3 = $slct3->fetch_assoc();

            //emailCompraCartao($slct['nomePaciente'], $slct['emailPaciente'], $slct3['idCartao'], $slct3['dtObtidoCartao'], $slct3['dtValidadeCartao']);

            $dados = [];
            $dados['paciente'] = $slct['nomePaciente'];
            $dados['email'] = $slct['emailPaciente'];
            $dados['cartao'] = $slct3['idCartao'];
            $dados['aquisicao'] = $slct3['dtObtidoCartao'];
            $dados['validade'] = $slct3['dtValidadeCartao'];

            echo "<script>var cartaoFinal = " . json_encode($dados) . "</script>";
        }
    }
}

if ($slct3['dtValidadeCartao'] == $dataAtual) {
    $updt = $conn->prepare("UPDATE cartoes SET statusCartao = '2' WHERE idPaciente = ?");
    $updt->bind_param("i", $_SESSION['id']);
    $updt->execute();
    $updt->close();

    $slct3 = $conn->prepare("SELECT * FROM cartoes WHERE idPaciente = ?");
    $slct3->bind_param("i", $_SESSION['id']);
    $slct3->execute();
    $slct3 = $slct3->get_result();
    $slct3 = $slct3->fetch_assoc();
}

if ($slct2->num_rows == 0) {
    $valor = 100;
} else {
    $valor = 200;
}

$_SESSION['statusCartao'] = $slct3['statusCartao'];
$_SESSION['idPag'] = $slct['idPagamento'];
$_SESSION['idCard'] = $slct3['idCartao'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>Minha Conta - Cardmais</title>
    <meta name="title" property="og:title" content="Minha Conta" />
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

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                <div>
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
        </div>
    </nav>


    <div class="container-fluid py-5" id="divMenu">
        <div class="row">
            <div class="col-sm-3 pb-5">
                <div class="list-group field">
                    <a class="list-group-item list-group-item-action hidden">Menu</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#divEndereco">Endereço</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#divContato">Contatos</a>
                    <a href="#divCartao" data-bs-toggle="collapse" class="list-group-item list-group-item-action">Meu Card+ Saúde</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#divDependente">Dependentes</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#divInf">Informações Pessoais</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" href="#divHist">Histórico de Compra</a>
                    <a role="button" href="./logout.php" class="list-group-item list-group-item-action text-center text-danger">Sair</a>
                </div>
            </div>

            <div class="col collapse" id="divEndereco" data-bs-parent="#divMenu">
                <form action="<?php echo htmlspecialchars('./alters/alterEnd.php'); ?>" method="POST">
                    <div class="row">
                        <div class="col">
                            <label for="cepP">CEP:</label>
                            <input class="form-control" type="text" name="endP[]" maxlength="8" id="cepP" value="<?php echo htmlspecialchars($slct['cepPaciente']); ?>" disabled>
                        </div>
                        <div class="col">
                            <label for="ruaP">Logradouro:</label>
                            <input class="form-control" type="text" name="endP[]" id="ruaP" value="<?php echo htmlspecialchars($slct['ruaPaciente']); ?>" disabled>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col">
                            <label for="bairroP">Bairro:</label>
                            <input class="form-control" type="text" name="endP[]" id="bairroP" value="<?php echo htmlspecialchars($slct['bairroPaciente']); ?>" disabled>
                        </div>
                        <div class="col">
                            <label for="cidadeP">Cidade:</label>
                            <input class="form-control" type="text" name="endP[]" id="cidadeP" value="<?php echo htmlspecialchars($slct['cidadePaciente']); ?>" disabled>
                        </div>
                        <div class="col">
                            <label for="estadoP">Estado:</label>
                            <input class="form-control" type="text" name="endP[]" id="estadoP" value="<?php echo htmlspecialchars($slct['estadoPaciente']); ?>" disabled>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col">
                            <label for="numeroP">Numero:</label>
                            <input class="form-control" type="text" name="endP[]" maxlength="10" id="numeroP" value="<?php echo htmlspecialchars($slct['numeroPaciente']); ?>" disabled>
                        </div>
                        <div class="col">
                            <label for="complP">Complemento:</label>
                            <input class="form-control" type="text" name="endP[]" id="complP" maxlength="50" value="<?php echo htmlspecialchars($slct['complPaciente']); ?>" disabled>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col">
                            <input type="checkbox" class="form-check-input" name="chkP" id="chkP">
                            <label for="chkP">Selecione para alterar alguma informação</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2 pt-3 mb-3 container">
                        <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnAlterEnd" disabled>Alterar Informações</button>
                    </div>
                </form>
            </div>

            <div class="col collapse" id="divContato" data-bs-parent="#divMenu">
                <form action="<?php echo htmlspecialchars('./alters/alterContato.php'); ?>" method="POST">
                    <div class="row">
                        <div class="col">
                            <label for="telP">Telefone:</label>
                            <input type="text" name="contP[]" id="telP" maxlength="11" class="form-control" value="<?php echo htmlspecialchars($slct['telefonePaciente']); ?>" disabled>
                        </div>
                        <div class="col">
                            <label for="telOP">Telefone Opcional:</label>
                            <input type="text" name="contP[]" id="telOP" maxlength="11" class="form-control" value="<?php echo htmlspecialchars($slct['telefoneOpcPaciente']); ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pt-2">
                            <label for="emailP">Email:</label>
                            <input type="email" name="contP[]" id="emailP" maxlength="100" class="form-control" value="<?php echo htmlspecialchars($slct['emailPaciente']); ?>" disabled>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col">
                            <input type="checkbox" class="form-check-input" name="chkC" id="chkC">
                            <label for="chkC">Selecione para alterar alguma informação</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 pt-3 mb-3 container">
                        <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnAlterCont" disabled>Alterar Informações</button>
                    </div>
                </form>
            </div>

            <div class="col collapse" id="divDependente" data-bs-parent="#divMenu">

                <div class="d-lg-none d-sm-block">
                    <span class="text-success fw-bold">Para melhor visualização no celular, vire-o na horizontal!</span>
                </div>

                <form action="<?php echo htmlspecialchars('../alters/alterDependente.php'); ?>" method="POST">
                    <?php
                    if ($slct2->num_rows == 0) {
                        echo "<p class='fw-bold fs-5'>Você não possui nenhum dependente.</p>";
                    } else {
                        $n = 0;
                        while ($row = $slct2->fetch_assoc()) {
                            $n++;
                            echo "<div class='row border rounded p-2 mb-2'>
                                    <div class='col pt-2'>
                                        <label class='form-label'>" . $n . "º Dependente:</label>
                                        <input type='text' class='form-control' name='dep" . $n . "[]' value='" . htmlspecialchars($row['nomeDependente']) . "' disabled><input value='" . htmlspecialchars($row['idDependente']) . "' hidden disabled name='dep" . $n . "[]'>
                                    </div>
                                    <div class='col pt-2'>
                                        <label class='form-label'>Data de Nascimento:</label>
                                        <input type='date' class='form-control' name='dep" . $n . "[]' value='" . htmlspecialchars($row['dtNascDependente']) . "' disabled>
                                    </div>
                                    <div class='col pt-2'>
                                        <label class='form-label'>CPF:</label>
                                        <input type='text' class='form-control' maxlength='11' name='dep" . $n . "[]' value='" . htmlspecialchars($row['cpfDependente']) . "' disabled>
                                    </div>
                                    <div class='col pt-5'>
                                        <div class='form-check'>
                                            <input type='checkbox' class='form-check-input' id='chkDep" . $n . "' name='chkDep'>
                                            <label class='form-check-label fw-bold' for='chkDep" . $n . "'>Selecione para alterar</label>
                                        </div>
                                    </div>
                                    <div class='d-grid gap-2 pt-3 mb-3 container'>
                                        <button class='btn btn-sm btn-card-contra shadow' type='button' id='carteiraDep' onclick='gerarPdfCartaoDep(\"$row[nomeDependente]\", \"$row[dtNascDependente]\")'>Gerar Carteirinha do Dependente</button>
                                    </div>
                                </div>";
                        }
                        echo "<div class='d-grid gap-2 pt-3 mb-3 container'>
                                            <button class='btn btn-lg btn-card-contra shadow' type='submit' id='btnAlterDep' disabled>Alterar Informações</button>
                                        </div>";

                        while ($n < 4) {
                            $n++;
                            echo "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' id='chAddDep$n' name='chAddDep'>
                                    <label class='form-check-label' for='chAddDep$n'>Adicionar $n º Dependente</label>
                                </div>
                                <div class='mb-3 col'>
                                    <label class='form-label'>$n º Dependente</label>
                                    <input type='text' class='form-control addDep' maxlength='200' id='nomeDep$n' name='addDep$n" ."[]' placeholder='Nome completo Dependente ' hidden>
                                </div>
                                <div class='row'>
                                    <div class='mb-3 col-4'>
                                    <input type='text' class='form-control addDep' maxlength='11' id='cpfDep$n' name='addDep$n" ."[]' placeholder='CPF do Dependente ' hidden>
                                    </div>
                                    <div class='mb-3 col-4'>
                                    <input type='date' class='form-control addDep' id='dtNascDep$n' name='addDep$n" ."[]' placeholder='Data de Nascimento do Dependente ' hidden>
                                    </div>
                                    <div class='form-floating mb-3 col-4'>
                                    <select class='form-select addDep' id='generoDep$n' aria-label='' name='addDep$n" ."[]' hidden>
                                        <option selected disabled value=''>Gênero Paciente</option>
                                        <option value='F'>Feminino</option>
                                        <option value='M'>Masculino</option>
                                        <option value='O'>Outro</option>
                                    </select>
                                    </div>
                                </div>
                                <div class='d-grid gap-2 pt-3 mb-3 container'>
                                    <input type='button' class='btn btn-md btn-card-contra shadow' id='btnAddDep$n' onclick='funcAddDep$n()' value='Adicionar Dependente' hidden>
                                </div>";
                                echo "<script>
                                    const chAddDep$n = document.getElementById('chAddDep$n');
                                    const addDep$n = document.getElementsByName('addDep$n" ."[]');
                                    let dados$n = [];

                                        chAddDep$n.addEventListener('click', ()=>{
                                            if(chAddDep$n.checked == true){
                                                for(let it of addDep$n){
                                                    it.hidden = false;
                                                    document.getElementById('btnAddDep$n').hidden = false;              
                                                }
                                            }
                                            else{
                                                for(let it of addDep$n){
                                                    it.hidden = true;
                                                    document.getElementById('btnAddDep$n').hidden = true;
                                                }
                                            }
                                        })

                                        function funcAddDep$n(){
                                            dados$n = [];
                                            for(let it of addDep$n){
                                                dados$n.push(it.value);
                                                console.log(dados$n);              
                                            }

                                            var xmlhttp = new XMLHttpRequest();

                                            xmlhttp.open('POST', '../cadastros/cadDepLogin.php', true);
                                            xmlhttp.setRequestHeader('Content-Type', 'application/json');
                                            xmlhttp.send(JSON.stringify(dados$n));
                                            xmlhttp.onreadystatechange = function() {
                                                if (this.readyState == 4 && this.status == 200) {
                                                    var resposta = JSON.parse(xmlhttp.response);
                                                    if (resposta['Confirm']) {
                                                        document.getElementById('toastOkDep').innerText = resposta['Confirm'];
                                                        const toastLiveExample = document.getElementById('liveToastDepOk')
                                                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                                                        toastBootstrap.show()
                                                        location.reload();
                                                    } else if (resposta['erro']) {
                                                        document.getElementById('toastNDep').innerText = resposta['erro'];
                                                        const toastLiveExample = document.getElementById('liveToastDepN')
                                                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                                                        toastBootstrap.show()
                                                    }
                                                }
                                            }
                                        }


                                </script>";

                                
                        }
                        // echo "<div class='d-grid gap-2 pt-3 mb-3 container'>
                        //             <button class='btn btn-md btn-card-contra shadow' id='btnAddDep' disabled>Adicionar Dependente(s)</button>
                        //         </div>";
                    }
                    ?>
                </form>
            </div>

            <div class="col collapse dispose" id="divInf" data-bs-parent="#divMenu">
                <span class="text-danger fw-bold">Atenção! Ao mudar alguma informação será necessário fazer o login novamente.</span>
                <form action="<?php echo htmlspecialchars('./alters/alterInfos.php'); ?>" method="POST">
                    <fieldset class="border rounded p-2">
                        <div class="row">
                            <div class="col">
                                <label for="nomeP">Nome:</label>
                                <input type="text" id="nomeP" name="infP[]" class="form-control" value="<?php echo htmlspecialchars($slct['nomePaciente']); ?>" disabled>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col">
                                <label for="cpfP">CPF:</label>
                                <input type="text" id="cpfP" maxlength="11" name="infP[]" class="form-control" value="<?php echo htmlspecialchars($slct['cpfPaciente']); ?>" disabled>
                            </div>
                            <div class="col">
                                <label for="nomeP">Data de Nascimento:</label>
                                <input type="date" id="dtNascP" name="infP[]" class="form-control" value="<?php echo htmlspecialchars($slct['dtNascPaciente']); ?>" disabled>
                            </div>
                            <div class="col">
                                <label for="nomeP">Genero:</label>
                                <input type="text" id="generoP" name="infP[]" class="form-control" value="<?php echo htmlspecialchars($slct['sexoPaciente']); ?>" disabled>
                                <select class="form-select" id="generoPs" aria-label="" name="infP[]" hidden>
                                    <option selected disabled value="">Gênero Paciente</option>
                                    <option value="F" name="opt">Feminino</option>
                                    <option value="M" name="opt">Masculino</option>
                                    <option value="O" name="opt">Outro</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col">
                                <input type="checkbox" class="form-check-input" name="chkI" id="chkI">
                                <label for="chkI">Selecione para alterar alguma informação</label>
                            </div>
                        </div>
                        <div class="d-grid gap-2 pt-3 mb-3 container">
                            <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnAlterInf" disabled>Alterar Informações</button>
                        </div>
                    </fieldset>
                </form>

                <div class="mt-3">
                    <form action="<?php echo htmlspecialchars('../alters/alterSenha.php'); ?>" method="POST">
                        <fieldset class="border rounded p-2">
                            <p class="fw-bold">Mudar Senha:</p>
                            <div class="row">
                                <div class="col">
                                    <label for="passAtual" class="form-label">Senha Atual:</label>
                                    <input type="password" name="passAtual" id="passAtual" class="form-control" required>
                                </div>
                                <div class="row pt-4">
                                    <div class="col">
                                        <label for="passNova" class="form-label">Nova Senha:</label>
                                        <input type="password" name="passNova" id="passNova" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col">
                                        <label for="passNovaConf" class="form-label">Confirma nova Senha:</label>
                                        <input type="password" name="passNovaConf" id="passNovaConf" class="form-control" required>
                                        <span id="spnSenha"></span>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 pt-3 mb-3 container">
                                    <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnAlterSenha" disabled>Alterar Senha</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="col collapse" id="divCartao" data-bs-parent="#divMenu">
                <fieldset class="border rounded p-4">
                    <input type="hidden" name="infP[]" value="<?php echo htmlspecialchars($slct['idPagamento']); ?>">
                    <?php
                    if ($slct3['statusCartao'] == "0") {
                        echo "<div class='row'>
                                    <div class='col'>
                                        <label for='numCartao' class='form-label'>Numero do cartão</label>
                                        <input type='text' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['idCartao'] . "' disabled>
                                    </div>
                                </div>";
                        echo "<span>Você ainda não finalizou a compra do seu cartão. Por favor, finalize-o para ter todos os acessos.</span>";
                        echo "<div class='d-grid gap-2 pt-3 mb-3 container'>
                                    <button class='btn btn-lg btn-card-contra shadow' type='submit' id='btnFinalizar' onclick='criarCliente(" . $valor . ", 1)'>Finalizar Compra</button>
                                </div>";
                    } else {
                        if ($slct3['statusCartao'] == "1") {
                            echo "<div class='row'>
                                    <div class='col'>
                                        <label for='numCartao' class='form-label'>Numero do cartão</label>
                                        <input type='text' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['idCartao'] . "' disabled>
                                    </div>
                                </div>";
                            echo "<div class='row pt-2'>
                                    <div class='col'>
                                        <label for='numCartao' class='form-label'>Data de Aquisição</label>
                                        <input type='date' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['dtObtidoCartao'] . "' disabled>
                                    </div>
                                    <div class='col'>
                                        <label for='numCartao' class='form-label'>Data de Validade</label>
                                        <input type='date' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['dtValidadeCartao'] . "' disabled>
                                    </div>
                                </div>
                                <div class='row pt-4'>
                                    <div class='col'>
                                        <span>Você está liberado para poder fazer compras no site. Vá para área de <b>Parceiros</b> ou <a href='../parceiros.php' class='btn btn-sm btn-card-contra'>Clique Aqui</a></span>
                                    </div>
                                </div>";
                            echo "<div class='d-grid gap-2 pt-3 mb-3 container'>
                                                <button class='btn btn-md btn-card-contra shadow' type='submit' id='btnFinalizar' onclick='gerarPdfCartao()'>Gerar PDF do seu Cartão Digital</button>
                                        </div>";
                        } else {
                            if ($slct3['statusCartao'] == "2") {
                                echo "<div class='row'>
                                    <div class='col'>
                                        <label for='numCartao' class='form-label'>Numero do cartão</label>
                                        <input type='text' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['idCartao'] . "' disabled>
                                    </div>
                                </div>";
                                echo "<div class='row pt-2'>
                                    <span class='text-danger fw-bold'>Seu cartão está vencido!</span>
                                    <div class='col'>
                                        <label for='numCartao' class='form-label'>Data de Validade</label>
                                        <input type='date' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['dtValidadeCartao'] . "' disabled>
                                    </div>
                                </div>";
                                echo "<div class='d-grid gap-2 pt-3 mb-3 container'>
                                            <button class='btn btn-lg btn-card-contra shadow' type='submit' id='btnFinalizar' onclick='criarCliente(" . $valor . ", 3)'>Renovar Cartão</button>
                                    </div>";
                            } else {
                                if ($slct3['statusCartao'] == "3") {
                                    echo "<div class='row'>
                                        <div class='col'>
                                            <label for='numCartao' class='form-label'>Numero do cartão</label>
                                            <input type='text' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['idCartao'] . "' disabled>
                                        </div>
                                    </div>";
                                    echo "<div class='row pt-2'>
                                        <span class='text-danger fw-bold'>Seu cartão está vencido!</span>
                                        <div class='col'>
                                            <label for='numCartao' class='form-label'>Data de Validade</label>
                                            <input type='date' class='form-control' name='numCartao' id='numCartao' value='" . $slct3['dtValidadeCartao'] . "' disabled>
                                        </div>
                                    </div>";
                                    echo "<div class='d-grid gap-2 pt-3 mb-3 container'>
                                                <button class='btn btn-lg btn-card-contra shadow' type='submit' id='btnFinalizar' onclick='location.reload()')'>Já fiz a Renovação - Atualizar</button>
                                        </div>";
                                }
                            }
                        }
                    }
                    if ($slct3 == null) {
                        echo "Erro, cartão não cadastrado.";
                    }
                    ?>
                </fieldset>
            </div>

            <div class="col collapse show" id="divHist" data-bs-parent="#divMenu">
                <?php
                $slctPedidos = $conn->prepare("SELECT b.idPedido, e.nomeParceiro, e.ruaParceiro, e.bairroParceiro, e.cidadeParceiro, e.estadoParceiro, e.numeroParceiro, e.complParceiro, e.telefoneParceiro, 
                                                        f.descProcedimento, b.vlTotal, c.vlUnitario, 
                                                        b.status, b.dataEmissao, b.dataValidade FROM pacientes a
                                                        INNER JOIN pedidos b on a.idPaciente = b.idPaciente
                                                        INNER JOIN pedidos_parceiros_procedimentos c ON b.idPedido = c.idPedido
                                                        INNER JOIN parceiros e ON c.idParceiro = e.idParceiro
                                                        INNER JOIN procedimentos f ON c.idProcedimento = f.idProcedimento
                                                        WHERE a.idPaciente = ?
                                                        ORDER BY b.idPedido ASC");
                $slctPedidos->bind_param("i", $_SESSION['id']);
                $slctPedidos->execute();
                $slctPedidos = $slctPedidos->get_result();

                $pedidos = [];
                ?>
                <?php
                while ($row = $slctPedidos->fetch_assoc()) {
                    $pedidos[$row['idPedido']]['status'] = $row['status'];
                    $pedidos[$row['idPedido']][$row['nomeParceiro']][] = $row;
                }
                if (count($pedidos) == 0) {
                    echo "<h2>Você ainda não fez nenhum pedido!</h2>";
                } else {

                ?>
                    <div class="container">
                        <div class="row row-cols-1 row-cols-md-4 gap-3 text-center">
                        <?php
                        foreach ($pedidos as $idPedido => $parceiros) {
                            $vlTotal = 0;
                            $dados = [];
                            $list .= "<div class='col field p-4 rounded'>";
                            $list .= "<h4 class='pt-2 text-danger-emphasis'>Pedido: $idPedido</h4>";
                            if ($parceiros['status'] == 0) {
                                $list .= "<span class='text-info'>Status: $parceiros[status] - Pedido feito - Continue para o pagamento.</span>";
                            } elseif ($parceiros['status'] == 1) {
                                $list .= "<span class='text-primary'>Status: $parceiros[status] - Pedido Pago - Vá Até o parceiro para finalizar.</span>";
                            } elseif ($parceiros['status'] == 2) {
                                $list .= "<span class='text-warning'>Status: $parceiros[status] - Aguardando Pagamento.</span>";
                            } elseif ($parceiros['status'] == 3) {
                                $list .= "<span class='text-success'>Status: $parceiros[status] - Pago no Parceiro - Pode ser utilizado.</span>";
                            } elseif ($parceiros['status'] == 4) {
                                $list .= "<span class='text-success fw-bold'>Status: $parceiros[status] - Pedido Finalizado!</span>";
                            } elseif ($parceiros['status'] == 5) {
                                $list .= "<span class='text-danger fw-bold'>Status: $parceiros[status] - Voucher Vencido!</span>";
                            }
                            foreach ($parceiros as $nomeParceiro => $itens) {
                                if ($nomeParceiro != 'status') {
                                    $list .= "<h5 class='pt-4 fw-bold'>$nomeParceiro</h5>";
                                    $list .= "<ul class='list-group'>";
                                    foreach ($itens as $item) {
                                        $list .= "<li class='list-group-item'>- " . $item['descProcedimento'] . "</li>";
                                        $vlTotal += $item['vlUnitario'];
                                        $dados['Procedimento'][] = $item['descProcedimento'];
                                    }
                                    $list .= "</ul>";
                                    //$vlTotal = $vlTotal+($vlTotal*0.1);
                                    if(str_contains($nomeParceiro, "Cardiológica")){
                                        $list .= "<h6 class='pt-5 text-info fw-bold'>Total: R$ " . str_replace(".", ",", $vlTotal) ."</h6>";
                                        if($parceiros['status'] == 0){
                                            $list .= "<a class='btn btn-sm btn-card-contra' onclick='criarCliente($vlTotal, 2, " . $idPedido . ")'>Fazer Pagamento</a>";
                                        }
                                    }
                                    else{
                                        if (str_contains($item['descProcedimento'], "Consulta")) {
                                            $list .= "<h6 class='pt-5 text-info fw-bold'>Total: R$ " . str_replace(".", ",", $vlTotal) . " <br> Taxa de Serviço: R$ 30</h6>";
                                        } else {
                                            $list .= "<h6 class='pt-5 text-info fw-bold'>Total: R$ " . str_replace(".", ",", $vlTotal) . " <br> Taxa de Serviço: R$" . $vlTotal * 0.25 . "</h6>";
                                        }

                                        if ($parceiros['status'] == 0) {
                                            if (str_contains($item['descProcedimento'], "Consulta")) {
                                                $list .= "<a class='btn btn-sm btn-card-contra' onclick='criarCliente(30, 2, " . $idPedido . ")'>Fazer Pagamento</a>";
                                            } else {
                                                $vlTotal *= 0.25;
                                                $list .= "<a class='btn btn-sm btn-card-contra' onclick='criarCliente(" . $vlTotal . ", 2, " . $idPedido . ")'>Fazer Pagamento</a>";
                                            }
                                        }
                                    }
                                    
                                    if ($parceiros['status'] == 2) {
                                        $dados['pedido'] = $idPedido;
                                        $dados['parceiro'] = $nomeParceiro;
                                        $dados['total'] = $vlTotal;
                                        $dados['telefone'] = $item['telefoneParceiro'];
                                        $dados['endereco'] = $item['ruaParceiro'] . ", " . $item['numeroParceiro'] . " - " . $item['bairroParceiro'] . " - " . $item['cidadeParceiro'] . "/" . $item['estadoParceiro'] . " - " . $item['complParceiro'];
                                        $dados['emissao'] = $item['dataEmissao'];
                                        $dados['validade'] = $item['dataValidade'];
                                        $list .= "<a class='btn btn-sm btn-card-contra' onclick='verificarPagamento($idPedido, " . json_encode($dados) . ")'>Já realizei pagamento - Atualizar</a>";
                                    }
                                    if ($parceiros['status'] == 1) {

                                        $dados['pedido'] = $idPedido;
                                        $dados['parceiro'] = $nomeParceiro;
                                        $dados['total'] = $vlTotal;
                                        $dados['telefone'] = $item['telefoneParceiro'];
                                        $dados['endereco'] = $item['ruaParceiro'] . ", " . $item['numeroParceiro'] . " - " . $item['bairroParceiro'] . " - " . $item['cidadeParceiro'] . "/" . $item['estadoParceiro'] . " - " . $item['complParceiro'];
                                        $dados['emissao'] = $item['dataEmissao'];
                                        $dados['validade'] = $item['dataValidade'];

                                        $list .= "<a class='btn btn-sm btn-card-contra' onclick='gerarPdfVoucher(" . json_encode($dados) . ")'>Gerar PDF Voucher</a>";
                                    }
                                    if ($parceiros['status'] == 5) {
                                        $dt = new DateTime($item['dataValidade']);

                                        $list .= "<h6 class='pt-5 text-danger fw-bolder'>Valido até: " . date_format($dt, "d-m-Y") . "</h6>";
                                    }
                                }
                            }
                            $list .= "</div>";
                        }
                        echo $list;
                    }
                        ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>

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
                                            <form action="./limparCarrinho.php" method="post">
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
                        <td><a href="../consultas/carrinho.php" class="btn btn-card-contra btn-sm">Ir para o Carrinho</a></td>
                    </tfoot>
                </table>

            <?php
            } else {
                echo "<h3>Seu Carrinho está vazio.</h3>";
            }
            ?>
        </div>
    </div>

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

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToastDepOk" class="toast bg-success-subtle" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Sucesso</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastOkDep">
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToastDepN" class="toast bg-success-subtle" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Sucesso</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastNDep">
            </div>
        </div>
    </div>


    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToastOk" class="toast bg-danger-subtle" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Carrinho</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-ok">
            </div>
        </div>
    </div>

</body>

<script>
    const senha = document.getElementById("passNova");
    const conSenha = document.getElementById("passNovaConf");
    const atualSenha = document.getElementById("passAtual");
    const spnSenha = document.getElementById("spnSenha");

    const chkDep = document.getElementsByName("chkDep");
    const dep1 = document.getElementsByName("dep1[]");
    const dep2 = document.getElementsByName("dep2[]");
    const dep3 = document.getElementsByName("dep3[]");
    const dep4 = document.getElementsByName("dep4[]");

    const chkP = document.getElementsByName("chkP");
    const endP = document.getElementsByName("endP[]");

    const chkC = document.getElementById("chkC");
    const contP = document.getElementsByName("contP[]");

    const chkI = document.getElementById("chkI");
    const infP = document.getElementsByName("infP[]");



    function criarCliente(valor, tipo, pedido) {
        var xmlhttp = new XMLHttpRequest();
        var pacientes = document.getElementsByName("infP[]");
        var values = [];

        for (let i of pacientes) {
            values.push(i.value);
        }

        values.push(values['tipo'] = tipo);

        xmlhttp.open("POST", "../pagamentos/criarCliente.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.send(JSON.stringify(values));
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resposta = JSON.parse(xmlhttp.response);
                if (resposta['erro']) {
                    sessionStorage.setItem('valor', valor);
                    sessionStorage.setItem('tipo', tipo);
                    sessionStorage.setItem('id', values[5]);
                    sessionStorage.setItem('pedido', pedido);
                    window.location.assign("../pagamentos/escolhaPagamento.php");
                } else if (resposta['Confirm']) {
                    sessionStorage.setItem('valor', valor);
                    sessionStorage.setItem('tipo', tipo);
                    sessionStorage.setItem('id', resposta['Confirm']);
                    window.location.assign("../pagamentos/escolhaPagamento.php");
                }
            }
        }
    }

    function verificarPagamento(pedido, dados) {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("POST", "../pagamentos/verificarPagamento.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.send(JSON.stringify(pedido));
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resposta = JSON.parse(xmlhttp.response);
                if (resposta['erro']) {
                    document.getElementById("toast-ok").innerText = resposta['erro'];
                    const toastLiveExample = document.getElementById('liveToastOk')
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                    toastBootstrap.show()
                } else if (resposta['Confirm']) {
                    gerarPdfVoucher(dados)
                    location.reload();
                }
            }
        }
    }

    function formatarData(data) {
        var partes = data.split('-');
        var ano = partes[0];
        var mes = partes[1];
        var dia = partes[2];

        return dia + "-" + mes + "-" + ano;
    }

    function gerarPdfCartao() {
        const numCartao = document.getElementsByName("numCartao");
        const pac = document.getElementsByName("infP[]");

        var htmlString = " <div style='border: 2px solid #e8e6e6; margin-left: 25%; margin-right: 25%; margin-top: 100px; background-color: #e8e6e6; text-align: end; border-radius: 10px 10px 0px 0px;'>" +
            "<img src='../imgs/cardMaisLogo.png' alt='' width='30%'>" +
            "</div>" +
            "<div style='border: 2px solid #b5221b; margin-left: 25%; margin-right: 25%; background-color: #b5221b; font-size: large; padding-top: 25px; padding-bottom: 25px;'>" +
            "<p style='text-align: center; color: white;'><b>Nº do Cartão:</b> " + numCartao[0].value + "</p>" +
            "<p style='text-align: center; color: white;'><b>Nome do Titular:</b> " + pac[0].value + "</p>" +
            "<span style='color: white; padding-left: 10px;'><b>Data de Nascimento: </b>" + formatarData(pac[2].value) + "</span>" +
            "<span style='color: white; float: right; padding-right: 10px;'><b>Data de validade: </b>" + formatarData(numCartao[2].value) + "</span>" +
            "</div>" +
            "<div style='border: 2px solid #e8e6e6; margin-left: 25%; margin-right: 25%; background-color: #e8e6e6; font-size: large; padding-right: 10px; text-align: end; border-radius: 0px 0px 10px 10px'>" +
            "<p><b>Central de Atendimento</b></p>" +
            "<p><b>(11)2139-6900</b></p>" +
            "</div>"

        var element = document.createElement('div');
        element.innerHTML = htmlString;
        document.body.appendChild(element);

        var opt = {
            filename: 'MeuCartaoCardmaisSaude.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'landscape'
            }
        };

        html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdf) {
            var pdfUrl = URL.createObjectURL(pdf.output('blob'));
            window.open(pdfUrl, '_blank');


            var pdfBase64 = btoa(pdf.output());

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", "../email/enviarEmailCartaoFinal.php", true);
            xmlhttp.send(pdfBase64);
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resposta = xmlhttp.response;

                    console.log(resposta);
                }
            }
        });

        // Remove the element from the document after creating the PDF.
        document.body.removeChild(element);
    }

    function gerarPdfVoucher(dados) {
        const pac = document.getElementsByName("infP[]");

        var htmlString = " <div style='border: 2px solid #e8e6e6; margin-left: 20%; margin-right: 20%; margin-top: 100px; background-color: #e8e6e6; text-align: end; border-radius: 10px 10px 0px 0px;'>" +
            "<img src='../imgs/cardMaisLogo.png' alt='' width='30%'>" +
            "</div>" +
            "<div style='border: 2px solid #b5221b; margin-left: 20%; margin-right: 20%; background-color: #b5221b; font-size: large; padding-top: 25px; padding-bottom: 25px;'>" +
            "<p style='text-align: center; color: white;'><b>Nº do Voucher:</b> " + dados['pedido'] + "</p>" +
            "<p style='text-align: start; color: white; padding-left: 10px;'><b>Beneficiário:</b> " + pac[0].value + "</p>" +
            "<p style='color: white; padding-left: 10px; text-align: start;'><b>Parceiro: </b>" + dados['parceiro'] + "</p>" +
            "<p style='color: white; padding-left: 10px; text-align: start;'><b>Endereço: </b>" + dados['endereco'] + "</p>" +
            "<p style='color: white; padding-left: 10px; text-align: start;'><b>Telefone: </b>" + dados['telefone'] + "</p>" +
            "<span style='color: white; padding-left: 10px;'><b>Emissão: </b>" + formatarData(dados['emissao']) + "</span>" +
            "<span style='color: white; float: right; padding-right: 10px;'><b>Validade: </b>" + formatarData(dados['validade']) + "</span>" +
            "<p style='color: white; padding-left: 10px; text-align: start; padding-top: 10px'><b>Procedimento(s): </b></p>";
        for (i = 0; i < dados['Procedimento'].length; i++) {
            htmlString += "<p style='color: white; padding-left: 10px; text-align: start;'><b>- </b>" + dados['Procedimento'][i] + "</p>"
        }
        htmlString += "<p style='color: white; text-align: center;'><b>Valor Total para o Parceiro:</b> R$" + dados['total'] + "</p>" +
            "</div>" +
            "<div style='border: 2px solid #e8e6e6; margin-left: 20%; margin-right: 20%; background-color: #e8e6e6; font-size: large; padding-right: 10px; text-align: end; border-radius: 0px 0px 10px 10px'>" +
            "<p><b>Central de Atendimento</b></p>" +
            "<p><b>(11)2139-6900</b></p>" +
            "</div>";

        var element = document.createElement('div');
        element.innerHTML = htmlString;
        document.body.appendChild(element);

        var opt = {
            filename: 'VoucherPedido.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'landscape'
            }
        };

        html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdf) {
            var pdfUrl = URL.createObjectURL(pdf.output('blob'));
            window.open(pdfUrl, '_blank');


            var pdfBase64 = btoa(pdf.output());

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", "../email/enviarEmailVoucherPdf.php", true);
            xmlhttp.send(pdfBase64);
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resposta = xmlhttp.response;

                    console.log(resposta);
                }
            }
        });

        // Remove the element from the document after creating the PDF.
        document.body.removeChild(element);
    }

    function gerarPdfCartaoDep(dep, dtNascDep) {
        const numCartao = document.getElementsByName("numCartao");
        const pac = document.getElementsByName("infP[]");

        var htmlString = " <div style='border: 2px solid #e8e6e6; margin-left: 25%; margin-right: 25%; margin-top: 100px; background-color: #e8e6e6; text-align: end; border-radius: 10px 10px 0px 0px;'>" +
            "<img src='../imgs/cardMaisLogo.png' alt='' width='30%'>" +
            "</div>" +
            "<div style='border: 2px solid #b5221b; margin-left: 25%; margin-right: 25%; background-color: #b5221b; font-size: large; padding-top: 25px; padding-bottom: 25px;'>" +
            "<p style='text-align: center; color: white;'><b>Nº do Cartão:</b> " + numCartao[0].value + "</p>" +
            "<p style='text-align: center; color: white;'><b>Nome do Titular:</b> " + pac[0].value + "</p>" +
            "<p style='text-align: center; color: white;'><b>Nome do Dependente:</b> " + dep + "</p>" +
            "<span style='color: white; padding-left: 10px;'><b>Data de Nascimento: </b>" + formatarData(dtNascDep) + "</span>" +
            "<span style='color: white; float: right; padding-right: 10px;'><b>Data de validade: </b>" + formatarData(numCartao[2].value) + "</span>" +
            "</div>" +
            "<div style='border: 2px solid #e8e6e6; margin-left: 25%; margin-right: 25%; background-color: #e8e6e6; font-size: large; padding-right: 10px; text-align: end; border-radius: 0px 0px 10px 10px'>" +
            "<p><b>Central de Atendimento</b></p>" +
            "<p><b>(11)2139-6900</b></p>" +
            "</div>"

        var element = document.createElement('div');
        element.innerHTML = htmlString;
        document.body.appendChild(element);

        var opt = {
            filename: 'MeuCartaoCardmaisSaude.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'landscape'
            }
        };

        html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdf) {
            var pdfUrl = URL.createObjectURL(pdf.output('blob'));
            window.open(pdfUrl, '_blank');


            // var pdfBase64 = btoa(pdf.output());

            // var xmlhttp = new XMLHttpRequest();

            // xmlhttp.open("POST", "../email/enviarEmailCartaoFinal.php", true);
            // xmlhttp.send(pdfBase64);
            // xmlhttp.onreadystatechange = function() {
            //     if (this.readyState == 4 && this.status == 200) {
            //         var resposta = xmlhttp.response;

            //         console.log(resposta);
            //     }
            // }
        });

        // Remove the element from the document after creating the PDF.
        document.body.removeChild(element);
    }





    chkI.addEventListener("click", () => {
        if (chkI.checked == true) {
            for (let i of infP) {
                i.disabled = false;
                document.getElementById("btnAlterInf").disabled = false;
            }
            infP[3].hidden = true;
            infP[4].hidden = false;
            if (infP[3].value == "O") {
                document.getElementsByName("opt")[2].selected = true;
            } else if (infP[3].value == "F") {
                document.getElementsByName("opt")[0].selected = true;
            } else if (infP[3].value == "M") {
                document.getElementsByName("opt")[1].selected = true;
            }
        } else {
            for (let i of infP) {
                i.disabled = true;
                document.getElementById("btnAlterInf").disabled = true;

            }
            infP[3].hidden = false;
            infP[4].hidden = true;
        }
    })

    chkC.addEventListener("click", () => {
        if (chkC.checked == true) {
            for (let i of contP) {
                i.disabled = false;
                document.getElementById("btnAlterCont").disabled = false;
            }
        } else {
            for (let i of contP) {
                i.disabled = true;
                document.getElementById("btnAlterCont").disabled = true;
            }
        }
    })

    chkP[0].addEventListener("click", () => {
        if (chkP[0].checked == true) {
            for (let i of endP) {
                i.disabled = false;
                document.getElementById("btnAlterEnd").disabled = false;
            }
        } else {
            for (let i of endP) {
                i.disabled = true;
                document.getElementById("btnAlterEnd").disabled = true;
            }
        }
    })

    conSenha.addEventListener("keyup", () => {
        if (senha.value != conSenha.value) {
            spnSenha.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
            document.getElementById("btnAlterSenha").disabled = true;
        } else {
            spnSenha.innerHTML = "<p class='text-success'>Ok</p>";
            document.getElementById("btnAlterSenha").disabled = false;
            if (senha.value === conSenha.value && senha.value.length < 8) {
                spnSenha.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
                document.getElementById("btnAlterSenha").disabled = true;
            }
        }

        if (conSenha.value === atualSenha.value) {
            spnSenha.innerHTML = "<p class='text-danger'>A Nova senha não pode ser igual a atual!</p>";
        }
    })

    senha.addEventListener("keyup", () => {
        if (senha.value != conSenha.value) {
            spnSenha.innerHTML = "<p class='text-danger'>Senhas não coincidem!!</p>";
            document.getElementById("btnAlterSenha").disabled = true;
        } else {
            spnSenha.innerHTML = "<p class='text-success'>Ok</p>";
            document.getElementById("btnAlterSenha").disabled = false;
            if (senha.value === conSenha.value && senha.value.length < 8) {
                spnSenha.innerHTML += "<p class='text-danger'>Deve conter pelo menos 8 caracteres</p>"
                document.getElementById("btnAlterSenha").disabled = true;
            }
        }
    })


    chkDep[0].addEventListener("click", () => {
        if (chkDep[0].checked == true) {
            for (let it of dep1) {
                it.disabled = false;
                document.getElementById("btnAlterDep").disabled = false;
            }
        } else {
            for (let it of dep1) {
                it.disabled = true;
                document.getElementById("btnAlterDep").disabled = true;
            }
        }
    })
    chkDep[1].addEventListener("click", () => {
        if (chkDep[1].checked == true) {
            for (let it of dep2) {
                it.disabled = false;
                document.getElementById("btnAlterDep").disabled = false;
            }
        } else {
            for (let it of dep2) {
                it.disabled = true;
                document.getElementById("btnAlterDep").disabled = true;
            }
        }
    })
    chkDep[2].addEventListener("click", () => {
        if (chkDep[2].checked == true) {
            for (let it of dep3) {
                it.disabled = false;
                document.getElementById("btnAlterDep").disabled = false;
            }
        } else {
            for (let it of dep3) {
                it.disabled = true;
                document.getElementById("btnAlterDep").disabled = true;
            }
        }
    })
    chkDep[3].addEventListener("click", () => {
        if (chkDep[3].checked == true) {
            for (let it of dep4) {
                it.disabled = false;
                document.getElementById("btnAlterDep").disabled = false;
            }
        } else {
            for (let it of dep4) {
                it.disabled = true;
                document.getElementById("btnAlterDep").disabled = true;
            }
        }
    })

</script>

</html>

