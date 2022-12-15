<?php
    require("./biblioteca.php");
    session_start();
    if(!fAutoritzacio($_SESSION['nom'])){
        header("Location: login.php");
    }
    if ((isset($_POST['nom'])) && (isset($_POST['cognom'])) && (isset($_POST['nota1'])) && (isset($_POST['nota2'])) && (isset($_POST['nota3'])) && (isset($_POST['nota4'])) && (isset($_POST['nota5'])) && (isset($_POST['nota6']))){		
        $afegit=fNouAlumne($_POST['nom'],$_POST['cognom'],$_POST['nota1'],$_POST['nota2'],$_POST['nota3'],$_POST['nota4'],$_POST['nota5'],$_POST['nota6']);
        $_SESSION['afegit']=$afegit;
        header("refresh: 2; url=interficie.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="crear_alumne.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <title>Creació nou alumne</title>
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
    
            <div class="collapse navbar-collapse" id="navbarsExample02">
            
            </div>
        </div>
    </nav>
    <h4>Creació nou alumne</h4>
    <form action="crear_alumne.php" method="post">
        <div>
        <div class="mb-1">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" aria-describedby="emailHelp" required >
        </div>
        <div class="mb-1">
            <label for="cognom" class="form-label">Cognom</label>
            <input type="text" name="cognom" id="cognom" required class="form-control">
        </div>
        <div class="mb-1">
            <label class="form-label" for="nota">Nota M01</label>
            <input type="number" name="nota1" id="nota1" required class="form-control">
        </div>
        <div class="mb-1">
            <label class="form-label" for="nota">Nota M02</label>
            <input type="number" name="nota2" id="nota2" required class="form-control">
        </div>
        <div class="mb-1">
            <label class="form-label" for="nota">Nota M03</label>
            <input type="number" name="nota3" id="nota3" required class="form-control">
        </div>
        <div class="mb-1">
            <label class="form-label" for="nota">Nota M04</label>
            <input type="number" name="nota4" id="nota4" required class="form-control">
        </div>
        <div class="mb-1">
            <label class="form-label" for="nota">Nota M11</label>
            <input type="number" name="nota5" id="nota5" required class="form-control">
        </div>
        <div class="mb-1">
            <label class="form-label" for="nota">Nota M12</label>
            <input type="number" name="nota6" id="nota6" required class="form-control">
        </div>
        </div>
        <input type="submit" class="btn btn-outline-success" value="Crear">
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

    echo "<button id='torna' class='btn btn-outline-primary' onclick='window.location.href=\"interficie.php\"'>Torna enrera</button><br><br>";
?>
</body>
</html>

