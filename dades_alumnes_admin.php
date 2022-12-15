<?php
// require("./biblioteca.php");

session_start();
require("biblioteca.php");
if(!fAutoritzacio($_SESSION['nom'])){
    header("Location: login.php");
}
if (!isset($_SESSION['nom'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici</title>
    <link rel="stylesheet" href="dades_alum_admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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
    <h1>Visualitzacio dades alumnes</h1>

    <table>
    <thead>
				<tr>
                    <th>Id</th>
					<th>Noms</th>
					<th>Cognom</th>
					<th>Nota M01 (Sistemes Operatius)</th>
                    <th>Nota M02 (Bases de Dades)</th>
                    <th>Nota M03 (Programació)</th>
                    <th>Nota M04 (Llenguatge de marques i XML)</th>
                    <th>Nota M011 (FOL)</th>
                    <th>Nota M012 (EIE)</th>
				</tr>
			</thead>
    <tbody>
    <?php
        
        if(!fAutoritzacio($_SESSION['nom'])){
            header("Location: login.php");
        }
        $llista = fLlegeixFitxer(FITXER_ALUMNES);
        fCreaTaula($llista,"alumnes");
    ?>
    </tbody>
    </table>

    <?php
    echo "<br><button onclick='window.location.href=\"crear_pdf.php\"'>Crear PDF de la taula de notes</button><br><br>";
    echo "<button onclick='window.location.href=\"gmail.php\"'>Enviar G-mail</button><br><br>";
    echo "<button onclick='window.location.href=\"interficie.php\"'>Tornar enrera</button><br><br>";
    ?>
    
</body>
</html>