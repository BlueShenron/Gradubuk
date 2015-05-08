<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectTestByID($id_test){
$connexion = connexion();

$request = 'SELECT tjvp.id_test_jeu_version_plateforme AS id_test_jeu_version_plateforme, tjvp.test_titre AS test_titre, t.test_date_publication AS test_date_publication, 
			tjvpi.url_test_jeu_version_plateforme_illustration,
			tjvpi.image_alt
			FROM 2015_test_jeu_version_plateforme AS tjvp
			LEFT JOIN 2015_test AS t
			ON t.id_test = tjvp.id_test

			LEFT JOIN 2015_test_jeu_version_plateforme_illustration AS tjvpi
			ON tjvpi.id_test_jeu_version_plateforme = tjvp.id_test_jeu_version_plateforme

			WHERE tjvp.id_jeu_version_plateforme = t.id_jeu_version_plateforme
		
			AND t.id_test = '.mysql_real_escape_string($id_test).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}


function mysqlInsertFrontpage($frontpage_titre,$frontpage_sous_titre,$id_test,$test_date_publication,$frontpage_image_url){

$connexion = connexion();

$request = "INSERT INTO 2015_frontpage_test
			VALUES ('','".mysql_real_escape_string(trim($frontpage_titre))."','".mysql_real_escape_string(trim($frontpage_sous_titre))."','".mysql_real_escape_string(trim($frontpage_image_url))."',NOW(),NOW(),'".mysql_real_escape_string(trim($test_date_publication))."','".mysql_real_escape_string(trim($id_test))."')";
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlUpdateTest($id_test){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_test
			SET 
			id_membre_modificateur="'.mysql_real_escape_string($id_membre).'",
			test_date_modif= NOW()
		
			WHERE id_test = "'.mysql_real_escape_string($id_test).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlDeleteFrontpage($id_frontpage){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_frontpage_test
				WHERE id_frontpage = "'.mysql_real_escape_string($id_frontpage).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlSelectFrontpageByID($id_frontpage){
$connexion = connexion();

$request = 'SELECT *
			
			FROM  2015_frontpage_test AS f
		
			WHERE f.id_frontpage = '.mysql_real_escape_string($id_frontpage).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlUpdateFrontpage($id_frontpage,$frontpage_titre,$frontpage_sous_titre){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_frontpage_test
			SET 
			frontpage_titre="'.mysql_real_escape_string($frontpage_titre).'" , 
			frontpage_sous_titre="'.mysql_real_escape_string($frontpage_sous_titre).'" 
			
			
		
			WHERE id_frontpage = "'.mysql_real_escape_string($id_frontpage).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}




?>