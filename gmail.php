<?php

require './vendor/autoload.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
$mail->CharSet = 'utf-8';
$mail->Host = "smtp.googlemail.com";
$mail->From = "adminphp@gmail.com";
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Username = $_SESSION['nom'];
$mail->Password = $_SESSION['ctsnya'];
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->AddAddress("mailDestinatario@example.com");
$mail->AddAddress("paramonty@gmail.com");
$mail->SMTPDebug  = 1;   //Muestra las trazas del mail, 0 para ocultarla
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

/*if ($archivoName != "") {
	$mail->AddAttachment($archivoTemp, $archivoName);
}*/
if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo 'Message has been sent';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail</title>
</head>
<body>
    
</body>
</html>