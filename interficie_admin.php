<?php
require("./biblioteca.php");

session_start();
if(!fAutoritzacio($_SESSION['nom'])){
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

echo "<button onclick='window.location.href=\"logout.php\"'>Logout</button>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interficie admin</title>
</head>
<body>
    <h1>Interficie admin</h1>

    <nav>
        <ul>
            <li><a href="crear_alumne.php">Crear alumne</a></li>
            <li><a href="dades_alumnes_admin.php">Veure dade alumnes</a></li>
            <li><a href="modificar_notes.php">Modificar notes</a></li>
            <li><a href="esborrar_alumne.php">Esborrar un alumne</a></li>
            <li><a href="crear_usuari.php">Crear nou usuari</a></li>
        </ul>
    </nav>
</body>
</html>