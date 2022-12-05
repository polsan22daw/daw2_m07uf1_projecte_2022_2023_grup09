<?php
require("./biblioteca.php");

session_start();
echo "<h2>Nom d'usuari: ".$_SESSION
['nom']."</h2><br>";
if(fAutoritzacio($_SESSION['nom'])){
    echo "<h2>Usuari administrador</h2><br>";
}
else{
    echo "<h2>Usuari normal</h2><br>";
}

if ((isset($_POST['id'])) && (isset($_POST['notaantiga'])) && (isset($_POST['notanova']))){
    $modificat=fModificarNota($_POST['id'],$_POST['notaantiga'],$_POST['notanova']);
    $_SESSION['modificat']=$modificat;
    header("refresh: 5; url=interficie_admin.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
}	

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificació notes</title>
</head>
<body>
    <form action="modificar_notes.php" method="post">
        <label for="id">Id del alumne:</label>
        <input type="text" name="id" id="id" required><br>
        <select name="notaantiga">
            <option value="nota1">M01</option>
            <option value="nota2">M02</option>
            <option value="nota3">M03</option>
            <option value="nota4">M04</option>
            <option value="nota5">M011</option>
            <option value="nota6">M012</option>
        </select>
        <label for="nota">Nota nova:</label>
        <input type="text" name="notanova" id="notanova" required><br>
        <input type="submit" value="Modificar">
    </form>

<?php
    if (isset($_SESSION['modificat'])){
        if ($_SESSION['modificat']) echo "<p style='color:red'>Nota canviada correctament</p>";
        else{
            echo "L'Usuari no ha estat modificat<br>";
            echo "Comprova si hi ha algún problema del sistema per poder canviar la nota<br>";
            header("refresh: 2; url=avis.php");
            header("refresh: 2; url=modificar_alumne.php");
        }
        unset($_SESSION['modificat']);
    } 
    echo "<button onclick='window.location.href=\"interficie_admin.php\"'>Tornar enrera</button><br><br>";
    echo "<button onclick='window.location.href=\"logout.php\"'>Logout</button>";
    ?>
</body>
</html>