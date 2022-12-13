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
fCreaTaula($llista,"alumnes");
//body con la tabla de alumnos
$mail->Body = 'Las notas son: ' . $cuerpo;

if (!$mail->send()) {
    echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent.';
}

echo "<script>alert('Email enviado correctamente');</script>";
?>