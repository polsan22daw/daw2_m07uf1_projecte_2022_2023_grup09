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
		$usuaris = fLlegeixFitxer(FITXER_USUARIS);
		$usuaris_nou = array();
		$ctsnya_hash=password_hash($ctsnya,PASSWORD_DEFAULT);
		$dades_nou_usuari=$nomUsuari.":".$ctsnya_hash.":".$tipus;
		array_push($usuaris_nou,$dades_nou_usuari);
		foreach ($usuaris as $usuari) {
			array_push($usuaris_nou,$usuari);
		}
		$usuaris_nou = implode(PHP_EOL,$usuaris_nou);
		if ($fp=fopen(FITXER_USUARIS,"w")) {
			if (fwrite($fp,$usuaris_nou)){
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
		if(($nota1>10 || $nota1<0) || ($nota2>10 || $nota2<0) || ($nota3>10 || $nota3<0) || ($nota4>10 || $nota4<0) || ($nota5>10 || $nota5<0) || ($nota6>10 || $nota6<0)){
			return false;
		}
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
		if($id > count($alumnes) || $id < 1){
			return false;
		}
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
		if($id > count($alumnes) || $id < 1){
			return false;
		}
		if($notanova > 10 || $notanova < 0){
			return false;
		}
		$alumnes_nou = array();
		foreach ($alumnes as $alumne) {
			$dadesAlumne = explode(":", $alumne);
			$idAlumneActual = $dadesAlumne[0];
			if($idAlumneActual == $id){
				if($notaantiga == "nota1"){
					$alumne = $id.":".$dadesAlumne[1].":".$dadesAlumne[2].":".$notanova.":".$dadesAlumne[4].":".$dadesAlumne[5].":".$dadesAlumne[6].":".$dadesAlumne[7].":".$dadesAlumne[8];
				}
				if($notaantiga == "nota2"){
					$alumne = $id.":".$dadesAlumne[1].":".$dadesAlumne[2].":".$dadesAlumne[3].":".$notanova.":".$dadesAlumne[5].":".$dadesAlumne[6].":".$dadesAlumne[7].":".$dadesAlumne[8];
				}
				if($notaantiga == "nota3"){
					$alumne = $id.":".$dadesAlumne[1].":".$dadesAlumne[2].":".$dadesAlumne[3].":".$dadesAlumne[4].":".$notanova.":".$dadesAlumne[6].":".$dadesAlumne[7].":".$dadesAlumne[8];
				}
				if($notaantiga == "nota4"){
					$alumne = $id.":".$dadesAlumne[1].":".$dadesAlumne[2].":".$dadesAlumne[3].":".$dadesAlumne[4].":".$dadesAlumne[5].":".$notanova.":".$dadesAlumne[7].":".$dadesAlumne[8];
				}
				if($notaantiga == "nota5"){
					$alumne = $id.":".$dadesAlumne[1].":".$dadesAlumne[2].":".$dadesAlumne[3].":".$dadesAlumne[4].":".$dadesAlumne[5].":".$dadesAlumne[6].":".$notanova.":".$dadesAlumne[8];
				}
				if($notaantiga == "nota6"){
					$alumne = $id.":".$dadesAlumne[1].":".$dadesAlumne[2].":".$dadesAlumne[3].":".$dadesAlumne[4].":".$dadesAlumne[5].":".$dadesAlumne[6].":".$dadesAlumne[7].":".$notanova;
				}
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