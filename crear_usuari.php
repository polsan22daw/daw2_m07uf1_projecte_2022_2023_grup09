<?php
	require("biblioteca.php");
	session_start();
	if(!fAutoritzacio($_SESSION['nom'])){
		header("Location: login.php");
	}
	if (!isset($_SESSION['nom'])){
		header("Location: error_acces.php");
	}
	else{
		$autoritzat=fAutoritzacio($_SESSION['nom']);
		if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)){
			header("Location: logout_expira_sessio.php");
		}
		else if(!$autoritzat){
			header("Location: error_autoritzacio.php");
		}
	}
	if ((isset($_POST['nom_nou_usuari'])) && (isset($_POST['cts_nou_usuari'])) && (isset($_POST['tipus_nou_usuari'])) && (isset($_POST['extra_nou_usuari']))){		
		$afegit=fActualitzaUsuaris($_POST['nom_nou_usuari'],$_POST['cts_nou_usuari'],$_POST['tipus_nou_usuari'],$_POST['extra_nou_usuari']);
		$_SESSION['afegit']=$afegit;
		header("refresh: 2; url=interficie_admin.php");
	}			
?>
<!DOCTYPE html>
<html lang="ca">
	<head>
		<meta charset="utf-8">
		<title>Crear usuari</title>
		<link rel="stylesheet" href="crear_usuari.css">
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
    
            <div class="collapse navbar-collapse" id="navbarsExample02">
            
            </div>
        </div>
    </nav>
		<h3><b>Creació de nous Usuaris</b></h3>
		<p><b>Indica les dades de l'usuari a registrar dins de l'aplicació: </b></p>			
		<form action="crear_usuari.php" method="POST">			
			<p>
				<label>Nom del nou usuari:</label> 
				<input type="text" name="nom_nou_usuari" required>
			</p>
			<p>
				<label>Contrasenya del nou usuari:</label> 
				<input type="password" name="cts_nou_usuari" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràter especial" required>
			</p> 
			<label>Tipus d'usuari de l'aplicació</label><br>
			<input type="radio" name="tipus_nou_usuari" value=<?php echo USR ?> checked>Usuari de l'aplicació<br>
			<input type="radio" name="tipus_nou_usuari" value=<?php echo ADMIN ?> >Administrador de l'aplicació<br>
			<br>
			<p>
				<label>Informació extra (Nº telefon Usuari/ DNI Administrador):</label> 
				<input type="number" name="extra_nou_usuari" title="Nº telefon Usuari/ DNI Administrador" required>
			</p> 
			<input type="submit" value="Enregistra el nou usuari"/>
		</form>
		<p><a href="interficie_admin.php">Torna al menú</a></p>
		<label class="diahora">
		<?php
			date_default_timezone_set('Europe/Andorra');
			echo "<p>Data i hora: ".date('d/m/Y h:i:s')."</p>";
			if (isset($_SESSION['afegit'])){
				if ($_SESSION['afegit']) echo "<p style='color:red'>L'Usuari ha estat registrat correctament</p>";
				else{
					echo "L'Usuari no ha estat registrat<br>";
					echo "Comprova si hi ha algún problema del sistema per poder enregistrar nous usuaris<br>";
				}
				unset($_SESSION['afegit']);
			} 
        ?>
		</label>
	</body>
</html>