<?php
// require("./biblioteca.php");

session_start();
echo "<h2>Nom d'usuari: ".$_SESSION
['nom']."</h2><br>";
// if(fAutoritzacio($_SESSION['nom'])){
//     echo "<h2>Usuari administrador</h2><br>";
// }
// else{
//     echo "<h2>Usuari normal</h2><br>";
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
        require("biblioteca.php");
        $llista = fLlegeixFitxer(FITXER_ALUMNES);
        fCreaTaula($llista,"alumnes");
    ?>
    </tbody>
    </table>

    <?php
    echo "<br><button onclick='window.location.href=\"crear_pdf.php\"'>Crear PDF de la taula de notes</button><br><br>";
    echo "<button onclick='window.location.href=\"interficie_usuari.php\"'>Tornar enrera</button><br><br>";
    echo "<button onclick='window.location.href=\"logout.php\"'>Logout</button>";
    ?>
    
</body>
</html>