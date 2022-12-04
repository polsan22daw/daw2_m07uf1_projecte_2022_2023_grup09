<?php
	define('TEMPS_EXPIRACIO',900); #TEMPS D'EXPIRACIÓ DE LA SESSIÓ EN SEGONS
	define('TIMEOUT',5); #TEMPS DE VISUALITZACIÓ DEL MISSATGE INFORMATIU SOBRE LA CREACIÓ D'USUARIS
	define('ERROR',10);
	define('COMU',"COMU");
	define('PROFESSIONAL',"PROFESSIONAL");
	define('ADMIN',"1");
	define('USR',"0");
	define('FITXER_USUARIS',"./usuaris/usuaris");
	define('FITXER_ALUMNES',"./dades/dadesalumnes");
	// define('FITXER_PERSONAL',"/var/www/html/agendaV3/dades/familia_amics.txt");
	// define('FITXER_PROFESSIONAL',"/var/www/html/agendaV3/dades/professional");
	// define('FITXER_SERVEIS',"/var/www/html/agendaV3/dades/serveis");
	//Namespaces
	use Dompdf\Dompdf;
	use Dompdf\Options;
	use Dompdf\Exception as DomException;
	use Dompdf\Option;
	
	function fLlegeixFitxer($nomFitxer){
		if ($fp=fopen($nomFitxer,"r")) {
			$midaFitxer=filesize($nomFitxer);
			$dades = explode(PHP_EOL, fread($fp,$midaFitxer));
			// array_pop($dades);		
			fclose($fp);
		}
		return $dades;
	}
	
	function fAutoritzacio($nomUsuariComprova){
		$usuaris = fLlegeixFitxer(FITXER_USUARIS);
		foreach ($usuaris as $usuari) {
			$dadesUsuari = explode(":", $usuari);
			$nomUsuari = $dadesUsuari[0];
			$ctsUsuari = $dadesUsuari[1];
			$tipusUsuari = $dadesUsuari[2];
			if(($nomUsuari == $nomUsuariComprova) && ($tipusUsuari==ADMIN)){
				$autoritzat=true;
				break;	
			}
			else  $autoritzat=false;
		}
		return $autoritzat;
	}
	
	function fAutenticacio($nomUsuariComprova){
		$usuaris = fLlegeixFitxer(FITXER_USUARIS);
		foreach ($usuaris as $usuari) {
			$dadesUsuari = explode(":", $usuari);
			$nomUsuari = $dadesUsuari[0];
			$ctsUsuari = $dadesUsuari[1];
			if(($nomUsuari == $nomUsuariComprova) && (password_verify($_POST['ctsnya'],$ctsUsuari))){
				$autenticat=true;
				break;
			}
			else  $autenticat=false;
		}
		return $autenticat;
	}
	
	function fActualitzaUsuaris($nomUsuari,$ctsnya,$tipus){
		$ctsnya_hash=password_hash($ctsnya,PASSWORD_DEFAULT);
		$dades_nou_usuari=$nomUsuari.":".$ctsnya_hash.":".$tipus."\n";
		if ($fp=fopen(FITXER_USUARIS,"a")) {
			if (fwrite($fp,$dades_nou_usuari)){
				$afegit=true;
			}
			else{
				$afegit=false;
			}				
			fclose($fp);
		}
		else{
			$afegit=false;
		}
		return $afegit;
	}

	function fNouAlumne($nom,$cognom,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6){
		$alumnes = fLlegeixFitxer(FITXER_ALUMNES);
		$alumnes_nou = array();
		$id = count($alumnes)+1;
		$alumne = $id.":".$nom.":".$cognom.":".$nota1.":".$nota2.":".$nota3.":".$nota4.":".$nota5.":".$nota6;
		array_push($alumnes_nou,$alumne);
		foreach ($alumnes as $alumne) {
			array_push($alumnes_nou,$alumne);
		}
		$alumnes_nou = implode(PHP_EOL,$alumnes_nou);
		if ($fp=fopen(FITXER_ALUMNES,"w")) {
			if (fwrite($fp,$alumnes_nou)){
				$afegit=true;
			}
			else{
				$afegit=false;
			}				
			fclose($fp);
		}
		else{
			$afegit=false;
		}
		return $afegit;
	}

	function fBorraAlumne($id){
		$alumnes = fLlegeixFitxer(FITXER_ALUMNES);
		$alumnes_nou = array();
		foreach ($alumnes as $alumne) {
			$dadesAlumne = explode(":", $alumne);
			$idAlumneActual = $dadesAlumne[0];
			if($idAlumneActual != $id){
				array_push($alumnes_nou,$alumne);
			}
		}
		$alumnes_nou = implode(PHP_EOL,$alumnes_nou);
		if ($fp=fopen(FITXER_ALUMNES,"w")) {
			if (fwrite($fp,$alumnes_nou)){
				$borrat=true;
			}
			else{
				$borrat=false;
			}				
			fclose($fp);
		}
		else{
			$borrat=false;
		}
		return $borrat;
	}

	function fModificarNota($id,$notaantiga,$notanova){
		$alumnes = fLlegeixFitxer(FITXER_ALUMNES);
		$alumnes_nou = array();
		foreach ($alumnes as $alumne) {
			$dadesAlumne = explode(":", $alumne);
			$idAlumneActual = $dadesAlumne[0];
			if($idAlumneActual == $id){
				$dadesAlumne[$notaantiga] = $notanova;
				$alumne = implode(":",$dadesAlumne);
			}
			array_push($alumnes_nou,$alumne);
		}
		$alumnes_nou = implode(PHP_EOL,$alumnes_nou);
		if ($fp=fopen(FITXER_ALUMNES,"w")) {
			if (fwrite($fp,$alumnes_nou)){
				$modificat=true;
			}
			else{
				$modificat=false;
			}				
			fclose($fp);
		}
		else{
			$modificat=false;
		}
		return $modificat;
	}

		
	function fCreaTaula($llista,$tipus){
		foreach ($llista as $entrada) {
			$dadesEntrada = explode(":", $entrada);
			$id = $dadesEntrada[0];
			$nom = $dadesEntrada[1];
			$cognom = $dadesEntrada[2];
			$nota1 = $dadesEntrada[3];
			$nota2 = $dadesEntrada[4];
			$nota3 = $dadesEntrada[5];
			$nota4 = $dadesEntrada[6];
			$nota5 = $dadesEntrada[7];
			$nota6 = $dadesEntrada[8];
			if ($tipus=="alumnes"){
				echo "<tr><td>$id</td><td>$nom</td><td>$cognom</td><td>$nota1</td><td>$nota2</td><td>$nota3</td><td>$nota4</td><td>$nota5</td><td>$nota6</td></tr>";
			}
			else{
				$carrec = $dadesEntrada[2];
				$nota = $dadesEntrada[3]; 
				echo "<tr><td>$id</td><td>$nom</td><td>$cognom</td><td>$nota</td></tr>";
			}					
		}
		return 0;
	}

?>
