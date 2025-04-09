<?php
require "../email/PHPMailer-master/src/PHPMailer.php";
require "../email/PHPMailer-master/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;

ob_start();

$dados = file_get_contents("php://input");

$pdf = base64_decode($dados);

file_put_contents('./anexo2.pdf', $pdf);

try {
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

    $mail->FromName = "Cardmais Saúde";

    //Destinatário
    $mail->addAddress("oakrockleo@gmail.com", "Leonardo Rocha");

    //Define se o corpo é em HTML
    $mail->IsHTML(true);

    $mail->CharSet = "UTF-8";

    //Assunto da Mensagem
    $mail->Subject = "Finalização Cartão - Cardmais Saúde";

    //Corpo da Mensagem
    $mail->isHTML(true);

    $mail->Body = "<div style='text-align: center; border: 1px solid black;'>
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

    $mail->addAttachment('./anexo.pdf', "CardmaisSaudeCartao.pdf");

    
    if(!$mail->send()){
        echo "Erro";
    }else{
        ob_end_clean();
        echo "Sucesso";
    }
    
} catch (\Throwable $th) {
    echo $th;
}
