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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Login</title>
    
</head>
<body class="text-center" cz-shortcut-listen="true">
<nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="inici.html">Pàgina inicial</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarsExample02">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                <a class="nav-link active" href="login.php">Autenticació</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="webinformativa.html">Informació</a>
                </li>
            </ul>
            </div>
        </div>
  </nav>
    <main class="form-signin w-100 m-auto">
        <form action="login.php" method="post">
          <h1 class="h3 mb-3 fw-normal">Pol&Marc.SL</h1>
          <div class="form-floating">
            <input type="text" class="form-control" name="nom" placeholder="admin123">
            <label>Usuari</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" name="ctsnya" placeholder="Contrasenya">
            <label>Contrasenya</label>
          </div>
      
          <div class="checkbox mb-3">
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Inicia Sessió</button>
          <p class="mt-5 mb-3 text-muted">© 2022–2023</p>
        </form>
      </main>
</body>
</html>