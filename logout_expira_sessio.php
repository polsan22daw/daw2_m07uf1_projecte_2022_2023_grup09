<?php
	session_start();
	session_unset();
	$cookie_sessio = session_get_cookie_params();
	setcookie("PHPSESSID","",time()-3600,$cookie_sessio['path'], $cookie_sessio['domain'], $cookie_sessio['secure'], $cookie_sessio['httponly']); 
	session_destroy();	
?>
<!DOCTYPE html>
<html lang="ca">
	<head>
		<meta charset="utf-8">
		<title>Sessio expirada</title>
		<link rel="stylesheet" href="logout.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
	<body>
	<div id="barra" class="bg-dark">
	</div>
		<h4>Finalització de sessió per temps d'expiració</h4>
        <p>L'aplicació finalitza la sessió automàticament si es superen 15 minuts, per a continuar el que estaves fent torna a iniciar sessió.</p>
		<label class="diahoraexp">
        <?php
			date_default_timezone_set('Europe/Andorra');
			echo "<p>Data i hora: ".date('d/m/Y h:i:s')."</p>";						
        ?>
        </label> 
		<?php
		echo "<button id='tornainici' class='btn btn-outline-primary' onclick='window.location.href=\"inici.html\"'>Ves a l'inici</button><br><br>";
		?>
	</body>
</html> 