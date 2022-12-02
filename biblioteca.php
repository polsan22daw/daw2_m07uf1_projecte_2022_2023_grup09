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

	function fNouAlumne($id,$nom,$cognom,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6){
		$alumne_nou="\n".$id.":".$nom.":".$cognom.":".$nota1.":".$nota2.":".$nota3.":".$nota4.":".$nota5.":".$nota6;
		if ($fp=fopen(FITXER_ALUMNES,"a")) {
			if (fwrite($fp,$alumne_nou)){
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
	
	function fBorrarAlumne($id){
		$alumnes = fLlegeixFitxer(FITXER_ALUMNES);
		$alumnes_nou=array();
		foreach ($alumnes as $alumne) {
			$dadesAlumne = explode(":", $alumne);
			$idAlumne = $dadesAlumne[0];
			if($idAlumne != $id){
				array_push($alumnes_nou,$alumne);
			}
		}
		if ($fp=fopen(FITXER_ALUMNES,"w")) {
			foreach ($alumnes_nou as $alumne_nou) {
				if (fwrite($fp,$alumne_nou."\n")){
					$afegit=true;
				}
				else{
					$afegit=false;
				}
			}
			fwrite($fp,"\r");
			fclose($fp);
		}
		else{
			$afegit=false;
		}
		return $afegit;
	}

	function fModificarNota($id,$notaantiga,$notanova){
		$alumnes = fLlegeixFitxer(FITXER_ALUMNES);
		$alumnes_nou=array();
		foreach ($alumnes as $alumne) {
			$dadesAlumne = explode(":", $alumne);
			$idAlumne = $dadesAlumne[0];
			if($idAlumne == $id){
				$alumne_nou="\n".$id.":".$dadesAlumne[1].":".$dadesAlumne[2].":".$dadesAlumne[3].":".$dadesAlumne[4].":".$dadesAlumne[5].":".$dadesAlumne[6].":".$dadesAlumne[7].":".$dadesAlumne[8];
				$alumne_nou=substr_replace($alumne_nou,$notaantiga,$notanova,1);
				array_push($alumnes_nou,$alumne_nou);
			}
			else{
				array_push($alumnes_nou,$alumne);
			}
		}
		if ($fp=fopen(FITXER_ALUMNES,"w")) {
			foreach ($alumnes_nou as $alumne_nou) {
				if (fwrite($fp,$alumne_nou)){
					$afegit=true;
				}
				else{
					$afegit=false;
				}
			}
			fclose($fp);
		}
		else{
			$afegit=false;
		}
		return $afegit;
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
