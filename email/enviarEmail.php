<?php
require "../email/PHPMailer-master/src/PHPMailer.php";
require "../email/PHPMailer-master/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;

session_start();

$dados = json_decode(file_get_contents("php://input"));

$assunto = '';
$body = '';


function enviarEmail($email, $nome, $assunto, $corpo)
{

        $mail = new PHPMailer();

        $mail->isSMTP();

        $mail->Host = "smtp.gmail.com";

        $mail->Port = 587;

        $mail->SMTPAuth = true;

        $mail->Username = "nickhyuuga0@gmail.com";

        $mail->Password = "ruml uldr cpcb cpxn";

        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));

        $mail->SMTPDebug = 2;

        //Remetente
        $mail->From = "no-reply@cardiologica.net";

        $mail->FromName = "Cardmais";

        //Destinatário
        $mail->addAddress($email, $nome);

        //Define se o corpo é em HTML
        $mail->IsHTML(true);

        $mail->CharSet = "UTF-8";

        //Assunto da Mensagem
        $mail->Subject = $assunto;

        //Corpo da Mensagem
        $mail->isHTML(true);

        $mail->Body = $corpo;

        $mail->send();
}



function emailCadastroFinalizado($email, $nome)
{

    $assunto = "Finalização Cadastro - Cardmais";
    $corpo = "<div style='text-align: center; border: 1px solid black;'>
    <p><b>Obrigado por finalizar o cadastro conosco =)<b></p> <br>
    <p>Aproveite todas as funcionalidades do seu <span style='color: #b5221b;'>Cartão CardMais Saúde!</span></p> <br>
    <p>Entre em seu perfil e Finalize a Compra para liberar todos os acessos.</p>
    <p>Em caso de dúvidas estamos à disposição.</p>
    </div>
    <div style='background-color: #b5221b; '>
        <p style='text-align: end; font-family: Arial, Helvetica, sans-serif; font-size: 1.25em; color: white; padding: 20px; border: 1px solid #b5221b; box-shadow: 10px 10px 15px gray' ><b>CardMais Saúde</b></p>
    </div>";

    enviarEmail($email, $nome, $assunto, $corpo);
}

function emailCadastroFinalizadoFam($email, $nome)
{

    $assunto = "Finalização Cadastro - Cardmais";
    $corpo = "<div style='text-align: center; border: 1px solid black'>
    <p style='color: #b5221b;'><b>Cardmais Em Grupo (Titular +4 Dependentes)</b></p> <br>
    <p>Obrigado por finalizar o cadastro conosco =)</p> <br>
    <p>Você e seus Dependentes agora podem utilizar do <span style='color: #b5221b'>Cartão CardMais Saúde!</span></p>
    <p>Aproveite todas as funcionalidades do seu cartão.</p> <br>
    <p>Entre em seu perfil e Finalize a Compra para liberar todos os acessos.</p>
    <p>Em caso de dúvidas estamos à disposição.</p>
    </div>
    <div style='background-color: #b5221b; '>
        <p style='text-align: end; font-family: Arial, Helvetica, sans-serif; font-size: 1.25em; color: white; padding: 20px; border: 1px solid #b5221b; box-shadow: 10px 10px 15px gray' ><b>CardMais Saúde</b></p>
    </div>";

    enviarEmail($email, $nome, $assunto, $corpo);
    
}

function emailCompraCartao($nome, $email, $cartao, $dtAqui, $dtVal)
{

    $assunto = "Finalização - Cartão CardMais Saúde";
    $corpo = "<div style='text-align: center; border: 1px solid black;'>
    <p><b>Obrigado por adquirir nosso cartão =)</b></p><br>
    <p>Agora você tem acesso aos procedimentos e valores de nossos parceiros.</p><br>
    <div>
        <table style='table-layout: fixed; width: 100%; border: 1px solid black;'>
            <thead>
                <tr>
                    <th style='color: #b5221b;'>Número do Cartão</th>
                    <th style='color: #b5221b;'>Data da Aquisição</th>
                    <th style='color: #b5221b;'>Data de Validade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td><b>" . $cartao . "</b></td>
                <td><b>" . $dtAqui . "</b></td>
                <td><b>" . $dtVal . "</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <p style='text-align: end; padding-right: 10px'><b>Em caso de dúvidas estamos à disposição!</b></p>
    </div>
    <div style='background-color: #b5221b; '>
        <p style='text-align: end; font-family: Arial, Helvetica, sans-serif; font-size: 1.25em; color: white; padding: 20px; border: 1px solid #b5221b; box-shadow: 10px 10px 15px gray' ><b>CardMais Saúde</b></p>
      </div>";

    enviarEmail($email, $nome, $assunto, $corpo);
}

function emailCompraProcedimento($nome, $email, $pedido)
{

    $assunto = "Aquisição Procedimentos - Cartão CardMais Saúde";
    $corpo = "<div style='text-align: center; border: 1px solid black;'>
    <div style='height: 200px; width: 15%; margin: auto; border: 1px solid #b5221b; background-color: #b5221b; color: white; box-shadow: 10px 10px 15px gray; margin-top: 10px;'>
    <p style='padding-top: 75px; font-size: 1.25em'><b>Voucher: $pedido</b></p>
    </div>
    <br>
        <p>Obrigado por fazer a compra dos procedimentos =)</p><br>
        <p>Agora é só ir até o Parceiro escolhido e mostrar esse número do Voucher.</p><br>
        <p style='text-align: end; padding: 10px'><b>Em caso de dúvida estamos à disposição</b></p>
        </div>
        <div style='background-color: #b5221b; '>
    <p style='text-align: end; font-family: Arial, Helvetica, sans-serif; font-size: 1.25em; color: white; padding: 20px; border: 1px solid #b5221b; box-shadow: 10px 10px 15px gray' ><b>CardMais Saúde</b></p>
  </div>";

    enviarEmail($email, $nome, $assunto, $corpo);
}


function emailStatusFinalizado($nome, $email, $pedido)
{

    $assunto = "Finalização Voucher  - Cardmais";
    $corpo = "<div style='text-align: center; border: 1px solid black;'>
    <p styler='color: red '>Ficamos felizes que tenha finalizado o Voucher <b>Nº $pedido</b> =)</p> <br>
    <p style='text-align: center;'>Aproveite sempre o seu <span style='color: #b5221b;'><b>Cartão Cardmais Saúde!</b></span></p> <br>
    <p style='text-align: end; padding: 10px;'><b>Por favor, deixe a sua avaliação em nossa página do google.</b></p>
    <p style='text-align: end; padding: 10px;'><b>Qualquer dúvida estamos à disposição.</b></p>
    </div>
    
    <div style='background-color: #b5221b; '>
<p style='text-align: end; font-family: Arial, Helvetica, sans-serif; font-size: 1.25em; color: white; padding: 20px; border: 1px solid #b5221b; box-shadow: 10px 10px 15px gray' ><b>CardMais Saúde</b></p>
</div>";

    enviarEmail($email, $nome, $assunto, $corpo);
}

if ($dados) {
    $corpo = $dados[0]  . "<br>" . $dados[1] . "<br>" . $dados[2] . "<br>" . $dados[3];
    enviarEmail("nickhyuuga0@gmail.com", "Cardmais", "Cardmais - Contato Site", $corpo);
}
