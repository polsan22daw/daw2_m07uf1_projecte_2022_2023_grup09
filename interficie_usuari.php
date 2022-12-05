<?php
require("./biblioteca.php");
echo "<h1>Interficie usuari</h1><br><br>";

session_start();
if(fAutoritzacio($_SESSION['nom'])){
    header("Location: login.php");
}
echo "<h2>Nom d'usuari: ".$_SESSION
['nom']."</h2><br>";
if(fAutoritzacio($_SESSION['nom'])){
    echo "<h2>Usuari administrador</h2><br>";
}
else{
    echo "<h2>Usuari normal</h2><br>";
}
echo "<h2>Temps d'expiració: ".$_SESSION
['expira']."</h2><br>";
echo "<a href='dades_alumnes_basic.php'>Veure les dades dels alumnes</a><br><br>";

echo "<button onclick='window.location.href=\"logout.php\"'>Logout</button>";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interficie Usuari</title>
</head>
<body>

</body>
</html>