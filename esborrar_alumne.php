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


if (isset($_POST['id'])){		
    $borrar=fBorraAlumne($_POST['id']);
    $_SESSION['borrar']=$borrar;
    header("refresh: 5; url=interficie_admin.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
}	

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminació alumne</title>
</head>
<body>
    <p>introdueix el id del alumne que vols eliminar</p>
    <form action="esborrar_alumne.php" method="post">
            <label for="nom">Id:</label>
            <input type="text" name="id" id="id" required><br>
            <input type="submit" value="Borrar">
    </form>
<?php
    if (isset($_SESSION['borrar'])){
        if ($_SESSION['borrar']) echo "<p style='color:red'>L'Usuari ha estat esborrat correctament</p>";
        else{
            echo "L'Usuari no ha estat esborrat<br>";
            echo "Comprova si hi ha algún problema del sistema per poder esborrar usuaris<br>";
            // header("refresh: 2; url=avis.php");
            header("refresh: 2; url=esborrar_alumne.php");
        }
        unset($_SESSION['borrar']);
    } 
    echo "<button onclick='window.location.href=\"interficie_admin.php\"'>Tornar enrera</button><br><br>";
    echo "<button onclick='window.location.href=\"logout.php\"'>Logout</button>";
    ?>
</body>
</html>