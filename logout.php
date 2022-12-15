<?php
	require("./biblioteca.php");
	if ((isset($_POST['resp'])) && ($_POST['resp']=="y")){
		session_start();
		//Alliberant variables de sessió. Esborra el contingut de les variables de sessió del fitxer de sessió. Buida l'array $_SESSION. No esborra cookies
		session_unset();
		//Destrucció de la cookie de sessió dins del navegador
		$cookie_sessio = session_get_cookie_params();
		setcookie("PHPSESSID","",time()-3600,$cookie_sessio['path'], $cookie_sessio['domain'], $cookie_sessio['secure'], $cookie_sessio['httponly']); //Neteja cookie de sessió
		//Destrucció de la informació de sessió (per exemple, el fitxer de sessió  o l'identificador de sessió) 
		session_destroy();
		header("Location: login.php");
	}
	else{
		session_start();
		if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)){
			header("Location: logout_expira_sessio.php");
		}
	}	
?>
<!DOCTYPE html>
<html lang="ca">
	<head>
		<meta charset="utf-8">
		<title>Visualitzador de l'agenda</title>
		<link rel="stylesheet" href="logout.css">
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
	<body>
	<nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container-fluid">
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
		<h3><b>Finalització de sessió</b></h3>
        <p>Estàs segur que vols finalitzar la sessió?:</p>
        <form action="logout.php" method="POST">
			<input type="radio" name="resp" value="y"/>Sí<br/>
			<input type="radio" name="resp" value="n" checked/>No<br/>
			<br>
			<input type="submit" value="Valida" />
		</form>
		<label class="diahora"> 
        <?php
			
			if ((isset($_POST['resp'])) && ($_POST['resp']=="n")){
				if(fAutoritzacio($_SESSION['nom'])){
					header("Location: interficie_admin.php");
				}
				else{	
					header("Location: interficie_usuari.php");
				}
			}
			date_default_timezone_set('Europe/Andorra');
			echo "<p>Data i hora: ".date('d/m/Y h:i:s')."</p>";						
        ?>
         <label class="diahora"> 
	</body>
</html> 