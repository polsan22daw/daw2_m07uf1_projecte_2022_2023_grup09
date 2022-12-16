<?php
require("./biblioteca.php");

session_start();
if(!fAutoritzacio($_SESSION['nom'])){
    header("Location: login.php");
}
if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)){
    header("Location: logout_expira_sessio.php");
}
if (isset($_POST['metode']) == 'DELETE'){
    $borrar=fBorraAlumne($_POST['id']);
    if ($borrar == false) {
        header("refresh: 0; url=avisesborraalumn.php");
    }
    $_SESSION['borrar']=$borrar;
    header("refresh: 2; url=interficie.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="esb_alum.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <title>Esborrar alumne</title>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container-fluid">
        <?php
            echo "<button type='button' class='btn btn-light' onclick='window.location.href=\"logout.php\"'>Logout</button>";
            ?>
            <div id="usuari">
            <svg xmlns="http://www.w3.org/2000/svg" width="23px" height="23px" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
            </svg>
            <a class="navbar-brand"><?php
            echo $_SESSION['nom'];
            ?></a>
            <a class="navbar-brand"><?php
                if(fAutoritzacio($_SESSION['nom'])){
                echo "Usuari: administrador";
                }
                else{
                echo "Usuari: normal";
                }
            ?></a>
            </div>
        </div>
    </nav>
    <h4>Esborrar alumne</h4>
    <form action="esborrar_alumne.php" method="post">
        <div class="mb-3">
            <div>
                <input type="hidden" name="metode" value="DELETE"/>
                <label for="nom" class="form-label">Id d'Alumne</label>
                <input type="text" name="id" id="id" class="form-control" required >
            </div>
        </div>
        <input type="submit" class="btn btn-outline-danger" value="Esborra">
    </form>
<?php
    if (isset($_SESSION['borrar'])){
        if ($_SESSION['borrar']) echo "<p style='color:green'>L'Alumne ha estat esborrat correctament</p>";
        else{
            header("refresh: 0; url=avisesborraalumn.php");
        }
        unset($_SESSION['borrar']);
    } 
    echo "<button class='btn btn-outline-primary' id='torna' onclick='window.location.href=\"interficie.php\"'>Tornar enrera</button><br><br>";
    ?>
</body>
</html>