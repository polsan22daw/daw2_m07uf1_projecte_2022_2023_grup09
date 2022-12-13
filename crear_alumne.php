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

if ((isset($_POST['nom'])) && (isset($_POST['cognom'])) && (isset($_POST['nota1'])) && (isset($_POST['nota2'])) && (isset($_POST['nota3'])) && (isset($_POST['nota4'])) && (isset($_POST['nota5'])) && (isset($_POST['nota6']))){		
    $afegit=fNouAlumne($_POST['nom'],$_POST['cognom'],$_POST['nota1'],$_POST['nota2'],$_POST['nota3'],$_POST['nota4'],$_POST['nota5'],$_POST['nota6']);
    $_SESSION['afegit']=$afegit;
    header("refresh: 2; url=interficie_admin.php");
}	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creació nou alumne</title>
</head>
<body>
    <form action="crear_alumne.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom" required><br>
        <label for="cognom">Cognom:</label>
        <input type="text" name="cognom" id="cognom" required><br>
        <label for="nota">Nota M01:</label>
        <input type="number" name="nota1" id="nota1" required><br>
        <label for="nota">Nota M02:</label>
        <input type="number" name="nota2" id="nota2" required><br>
        <label for="nota">Nota M03:</label>
        <input type="number" name="nota3" id="nota3" required><br>
        <label for="nota">Nota M04:</label>
        <input type="number" name="nota4" id="nota4" required><br>
        <label for="nota">Nota M011:</label>
        <input type="number" name="nota5" id="nota5" required><br>
        <label for="nota">Nota M012:</label>
        <input type="number" name="nota6" id="nota6" required><br>
        <input type="submit" value="Crear">
    </form>
    
    <?php
    if (isset($_SESSION['afegit'])){
        if ($_SESSION['afegit']) echo "<p style='color:red'>L'Usuari ha estat registrat correctament</p>";
        else{
            echo "L'Usuari no ha estat registrat<br>";
            echo "Comprova si hi ha algún problema del sistema per poder enregistrar nous usuaris<br>";
            header("refresh: 2; url=avis.php");
            header("refresh: 2; url=crear_alumne.php");
        }
        unset($_SESSION['afegit']);
    } 

    echo "<button onclick='window.location.href=\"interficie_admin.php\"'>Tornar enrera</button><br><br>";
    echo "<button onclick='window.location.href=\"logout.php\"'>Logout</button>";
    ?>
</body>
</html>

