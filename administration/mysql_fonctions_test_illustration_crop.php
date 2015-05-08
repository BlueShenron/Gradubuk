<?php

require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}


function mysqlInsertTestJeuVersionPlateformePhoto($id_test_jeu_version_plateforme,$image_name,$photo_titre,$id_categorie_image){
//$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_test_jeu_version_plateforme_photo
			VALUES ('','".mysql_real_escape_string($id_test_jeu_version_plateforme)."','".mysql_real_escape_string($image_name)."','".mysql_real_escape_string($photo_titre)."','".mysql_real_escape_string(trim($id_categorie_image))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteTestJeuVersionPlateformeIllustration($id_test_jeu_version_plateforme){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme_illustration
				WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlInsertTestJeuVersionPlateformeIllustration($id_test_jeu_version_plateforme,$url_image,$image_titre,$image_alt){
$connexion = connexion();
$request = "INSERT INTO 2015_test_jeu_version_plateforme_illustration
			VALUES ('','".mysql_real_escape_string(trim($id_test_jeu_version_plateforme))."','".mysql_real_escape_string(trim($url_image))."','".mysql_real_escape_string(trim($image_titre))."','".mysql_real_escape_string(trim($image_alt))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlSelectTestJeuVersionPlateforme($id_test){

$connexion = connexion();

$request = 'SELECT tjvp.id_test_jeu_version_plateforme, tjvp.id_test, tjvp.test_titre,tjvp.test_corps,tjvp.test_note,tjvp.test_moins,tjvp.test_plus FROM 2015_test_jeu_version_plateforme AS tjvp LEFT OUTER JOIN 2015_test AS t ON t.id_test = tjvp.id_test LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme LEFT OUTER JOIN 2015_plateforme AS p ON p.id_plateforme = jvp.id_plateforme
			
			WHERE tjvp.id_test = \''.mysql_real_escape_string(trim($id_test)).'\'
			
			
			';
			
$result = mysql_query($request) or die(mysql_error());
//echo ">>>>   ".$request."   <<<<<<";
return $result;
mysql_close($connexion);
}

function mysqlDeleteTestJeuVersionPlateformePhoto($id_test_jeu_version_plateforme){
$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme_photo
				WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
?>