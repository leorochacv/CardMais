<?php
require_once "../conexao.php";

session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

error_reporting(0);

// Se não houver sessão Adm, redireciona para página inicial
if (!isset($_SESSION['idAdm'])) {
    header("Location: ../index.php");
}

// Seleciona os Parceiros cadastrados em sistema
$slct = $conn->prepare("SELECT idParceiro, nomeParceiro FROM parceiros");
$slct->execute();
$slct = $slct->get_result();
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

    <!-- Barra de navegação -->
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
                            <a class="flutuante-text dropdown-item" href="./cadAdmPagina.php">Cadastro Usuário administrativo</a>
                        </li>
                        <li>
                            <a class="flutuante-text dropdown-item" href="./cadUserPag.php">Cadastro Usuário Vendedor</a>
                        </li>
                    </ul>
                </div>

                <div class="dropdown ms-1">
                    <a class="btn btn-card-contra" href="#" data-bs-toggle="dropdown" aria-expanded="false">Consultas</a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="flutuante-text dropdown-item" href="./conPaciente.php">Consultar Paciente</a>
                            <a class="flutuante-text dropdown-item" href="./conParceiro.php">Consultar Parceiro</a>
                            <a class="flutuante-text dropdown-item" href="./comissoes.php">Consultar Comissões</a>
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
    <!-- Fim da barra de navegação -->

<!-- Início do corpo da página -->

<!-- Pesquisa do Parceiro -->
    <div class="container py-5 col-8">
        <fieldset class="field rounded-3 p-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <select name="slctPar" id="slctPar" class="form-select mb-3" required>
                    <option selected disabled value="">Escolha uma opção</option>
                    <?php
                    while ($row = $slct->fetch_assoc()) {
                        echo '<option value="' . $row['idParceiro'] . '">' . $row['nomeParceiro'] . '</option>';
                    }
                    ?>
                </select>

                <div class="d-grid gap-2 pt-3 mb-3 container">
                    <button class="btn btn-lg btn-card-contra shadow" id="btnCadParc" type="submit">Pesquisar</button>
                </div>
            </form>
        </fieldset>
    </div>
<!-- Fim da pesquisa do parceiro -->

<!-- Mostra o parceiro selecionado -->
    <div class="container py-5 col-8">

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $parceiro = htmlspecialchars($_POST['slctPar']);

            $select = $conn->prepare("SELECT * FROM parceiros WHERE idParceiro = ?");
            $select->bind_param("i", $parceiro);
            $select->execute();
            $select = $select->get_result();
            $select = $select->fetch_assoc();
        }
        ?>

        <fieldset class="field rounded-3 p-4">
            <form action="<?php echo htmlspecialchars('../alters/alterParceiro.php'); ?>" method="POST">

                <div class="mb-3 col">
                    <label class="form-label" for="nomeParceiro">Nome do Parceiro</label>
                    <input disabled type="text" class="form-control" maxlength="200" placeholder="Digite o Parceiro" id="nomeParceiro" name="infPar[]" value="<?php echo $select['nomeParceiro'] ?>">
                </div>

                <div class="mb-3 col">
                    <label class="form-label" for="cnpjParceiro">CNPJ do Parceiro</label>
                    <input disabled type="text" class="form-control" maxlength="14" placeholder="Digite o Parceiro" id="cnpjParceiro" name="infPar[]" value="<?php echo $select['cnpjParceiro'] ?>">
                </div>

                <div class="mb-3 col">
                    <label class="form-label" for="telefoneParceiro">Telefone Parceiro</label>
                    <input disabled type="text" class="form-control" maxlength="11" placeholder="Digite o Telefone do Parceiro" id="telefoneParceiro" name="infPar[]" value="<?php echo $select['telefoneParceiro'] ?>">
                </div>

                <div class="mb-3 col">
                    <label class="form-label" for="telefoneOpcParceiro">Telefone Parceiro Opcional</label>
                    <input disabled type="text" class="form-control" maxlength="11" placeholder="Digite Telefone Opcional do Parceiro" id="telefoneParceiro" name="infPar[]" value="<?php echo $select['telefoneOpcParceiro'] ?>">
                </div>

                <div class="mb-3 col">
                    <label class="form-label" for="emailParceiro">Email Parceiro</label>
                    <input disabled type="email" class="form-control" maxlength="200" placeholder="Digite o email do Parceiro" id="emailParceiro" name="infPar[]" value="<?php echo $select['emailParceiro'] ?>">
                </div>

                <div class="mb-3 col">
                    <span id="message" style="color: #b5221b;" class="fw-bold"></span><br>
                    <label class="form-label" for="cepParceiro">CEP</label>
                    <input disabled type="text" class="form-control" maxlength="8" placeholder="Digite o CEP" id="cepParceiro" name="infPar[]" value="<?php echo $select['cepParceiro'] ?>">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label" for="ruaParceiro">Rua</label>
                        <input disabled type="text" class="form-control" maxlength="200" placeholder="Rua" id="ruaParceiro" name="infPar[]" value="<?php echo $select['ruaParceiro'] ?>">
                    </div>
                    <div class="col">
                        <label class="form-label" for="bairroParceiro">Bairro</label>
                        <input disabled type="text" class="form-control" maxlength="200" placeholder="Bairro" id="bairroParceiro" name="infPar[]" value="<?php echo $select['bairroParceiro'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label" for="cidadeParceiro">Cidade</label>
                        <input disabled type="text" class="form-control" maxlength="200" placeholder="Cidade" id="cidadeParceiro" name="infPar[]" value="<?php echo $select['cidadeParceiro'] ?>">
                    </div>
                    <div class="col">
                        <label class="form-label" for="estadoParceiro">Estado</label>
                        <input disabled type="text" class="form-control" maxlength="200" placeholder="Estado" id="estadoParceiro" name="infPar[]" value="<?php echo $select['estadoParceiro'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label" for="numParceiro">Número</label>
                        <input disabled type="text" class="form-control" maxlength="5" placeholder="Número" id="numParceiro" name="infPar[]" value="<?php echo $select['numeroParceiro'] ?>">
                    </div>
                    <div class="col">
                        <label class="form-label" for="complParceiro">Complemento</label>
                        <input disabled type="text" class="form-control" maxlength="100" placeholder="Complemento" id="complParceiro" name="infPar[]" value="<?php echo $select['complParceiro'] ?>">
                    </div>
                    <div class="col">
                        <label class="form-label" for="slctRegiao">Região</label>
                        <input disabled type="text" class="form-control" maxlength="100" placeholder="Complemento" id="regiaoParceiro" name="infPar[]" value="<?php echo $select['regiaoParceiro'] ?>">
                        <select hidden name="infPar[]" id="slctRegiao" class="form-control">
                            <option value="" selected disabled>Selecione a Região</option>
                            <option value="zn" name="opt">Zona Norte</option>
                            <option value="zs" name="opt">Zona Sul</option>
                            <option value="cn" name="opt">Centro</option>
                            <option value="zl" name="opt">Zona Leste</option>
                            <option value="zo" name="opt">Zona Oeste</option>
                        </select>
                    </div>
                    <input hidden id="idParceiro" name="infPar[]" value="<?php echo $select['idParceiro'] ?>">
                </div>
                <div class="row pt-3">
                    <div class="col">
                        <input type="checkbox" class="form-check-input" name="chkP" id="chkP">
                        <label for="chkP">Selecione para alterar alguma informação</label>
                    </div>
                </div>

                <div class="d-grid gap-2 pt-3 mb-3 container">
                    <button class="btn btn-lg btn-card-contra shadow" type="submit" id="btnAlterar" disabled>Alterar</button>
                </div>
            </form>

        </fieldset>
    </div>

    <div class="container py-5 col-8">
        <fieldset class="field rounded-3 p-4">

            <div class="row">
                <?php
                $procs = "SELECT a.idProcedimento, d.descProcedimento, a.vlProcedimento 
                        FROM tblprocedimentos a 
                        INNER JOIN tabela_procedimentos b ON a.idTblProcedimento = b.idTblProcedimento 
                        INNER JOIN parceiros c ON c.idParceiro = b.idParceiro 
                        INNER JOIN procedimentos d ON d.idProcedimento = a.idProcedimento 
                        WHERE c.idParceiro = ?;";

                $procs = $conn->prepare($procs);
                $procs->bind_param("i", $parceiro);
                $procs->execute();
                $procs = $procs->get_result();

                echo "<table class='table table-bordered border-3 rounded align-middle text-center'>";
                echo "<tr>
                        <th>Procedimento</th>
                        <th>Valor</th>
                    </tr>";
                while ($row = $procs->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['idProcedimento']) . " - " . htmlspecialchars($row['descProcedimento']) . "</td>";
                    echo "<td>" . "R$" . htmlspecialchars($row['vlProcedimento']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";

                ?>
            </div>

        </fieldset>
    </div>
<!-- Fim da mostragem do parceiro  -->


</body>

</html>

<script>
    const chkP = document.getElementById("chkP");
    const infPar = document.getElementsByName("infPar[]");

    chkP.addEventListener("click", () => {
        if (chkP.checked == true) {

            infPar[12].hidden = true;
            infPar[13].hidden = false;
            document.getElementById("btnAlterar").disabled = false;

            for (let i of infPar) {
                i.disabled = false;
            }

            if (infPar[12].value == "zn") {
                document.getElementsByName("opt")[0].selected = true;
            } else if (infPar[12].value == "zs") {
                document.getElementsByName("opt")[1].selected = true;
            } else if (infPar[12].value == "cn") {
                document.getElementsByName("opt")[2].selected = true;
            } else if (infPar[12].value == "zl") {
                document.getElementsByName("opt")[3].selected = true;
            } else if (infPar[12].value == "zo") {
                document.getElementsByName("opt")[4].selected = true;
            }
        } else {
            for (let i of infPar) {
                i.disabled = true;
            }
            document.getElementById("btnAlterar").disabled = true;
        }
    })
</script>