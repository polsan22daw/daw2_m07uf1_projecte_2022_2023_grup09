<?php

require("./biblioteca.php");

if ((isset($_POST['nom'])) && (isset($_POST['ctsnya']))){
    $autenticat = fAutenticacio($_POST['nom']);
    if($autenticat){
        session_start(); // Inici de sessió
        $_SESSION['nom'] = $_POST['nom'];
        //$_SESSION['nom'] EMMAGATZEMA EL NOM DE L'nom VALIDAT
        $_SESSION['expira'] = time() + TEMPS_EXPIRACIO;
        if(fAutoritzacio($_POST['nom'])){
            header("Location: interficie_admin.php");
        }
        else{
            header("Location: interficie_usuari.php");
        }	
    }
    if (!isset($_SESSION['nom'])){
        header("Location: avis.php");
    }	
}	
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="CSS/estilsinici.css" rel="stylesheet" type="text/css">
        <TITLE>Projecte M07 - UF1</TITLE>
</head>

<body>
    <nav>
        <a href="Inici.html">Enrera</a>
    </nav>
    <form method="post" action="login.php">
        <table>
            <tr><td><label>Autenticació</label></td></tr>
            <tr><td><label>Nom nom</label></td></tr>
            <tr><td><input type="text" name="nom"/></td></tr>

            <tr><td><label>Contrasenya</label></td></tr>
            <tr><td><input type="password" name="ctsnya"/></td></tr>

            <tr><td><input type="submit" value="login"/></td></tr>
        </table>
    </form>
</body>

</html>