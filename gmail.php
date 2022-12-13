<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'polbovesanz@gmail.com';
$mail->Password = 'xcbvowdepgmcnvcm';
$mail->SMTPSecure = 'ssl'; //o ssl
$mail->Port = 465; //o 465

$mail->setFrom('polbovesanz@gmail.com');
$mail->addAddress('15584149.clot@fje.edu');

$mail->isHTML(true);

$mail->Subject = 'Notes dels alumnes';

require("biblioteca.php");
$llista = fLlegeixFitxer(FITXER_ALUMNES);
$cuerpo=fRetornaAlumnes($llista,"alumnes");
$mail->Body = '<p>Notes dels alumnes:</p>
<table>
<thead>
            <tr>
                <th>Id</th>
                <th>Noms</th>
                <th>Cognom</th>
                <th>Nota M01 (Sistemes Operatius)</th>
                <th>Nota M02 (Bases de Dades)</th>
                <th>Nota M03 (Programació)</th>
                <th>Nota M04 (Llenguatge de marques i XML)</th>
                <th>Nota M011 (FOL)</th>
                <th>Nota M012 (EIE)</th>
            </tr>
        </thead>
<tbody>
' . $cuerpo . '
</tbody>
</table>';

if (!$mail->send()) {
    echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent.';
}

echo "<script>alert('Email enviado correctamente');</script>";
?>