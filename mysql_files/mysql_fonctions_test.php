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

$request = 'SELECT t.id_test,  tjvp.test_corps,  tjvp.test_titre,
			DATE_FORMAT(t.test_date_creation,"%d %b %Y - %H:%i") AS test_date_creation, 
			
			CASE WHEN t.test_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(t.test_date_publication, "le %d/%m/%Y à %H:%i") END AS test_date_publication,
			
			t.test_date_publication AS test_date_publication_non_formate,
			m.pseudo,
			
			CASE WHEN tjvpi.url_test_jeu_version_plateforme_illustration = "" THEN "ressources/frontpage_defaut.jpg"
			WHEN tjvpi.url_test_jeu_version_plateforme_illustration IS NULL THEN "ressources/frontpage_defaut.jpg"
			ELSE tjvpi.url_test_jeu_version_plateforme_illustration END AS url_test_jeu_version_plateforme_illustration
			
			FROM  2015_test AS t
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = t.id_membre_createur
			
			LEFT JOIN 2015_test_jeu_version_plateforme AS tjvp
			ON tjvp.id_test = t.id_test
			
		
			LEFT JOIN 2015_test_jeu_version_plateforme_illustration AS tjvpi
			ON tjvpi.id_test_jeu_version_plateforme = tjvp.id_test_jeu_version_plateforme
			
		
			WHERE t.id_test = '.mysql_real_escape_string($id_test).'
			AND tjvp.id_jeu_version_plateforme = t.id_jeu_version_plateforme
			';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectTestWithPageNumber($page,$nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT t.id_test,  tjvp.test_corps,  tjvp.test_titre,
			DATE_FORMAT(t.test_date_creation,"%d %b %Y - %H:%i") AS test_date_creation, 
			
			CASE WHEN t.test_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(t.test_date_publication, "le %d/%m/%Y à %H:%i") END AS test_date_publication,
			
			t.test_date_publication AS test_date_publication_non_formate,
			m.pseudo,
			
			CASE WHEN tjvpi.url_test_jeu_version_plateforme_illustration = "" THEN "ressources/frontpage_defaut.jpg"
			WHEN tjvpi.url_test_jeu_version_plateforme_illustration IS NULL THEN "ressources/frontpage_defaut.jpg"
			ELSE tjvpi.url_test_jeu_version_plateforme_illustration END AS url_test_jeu_version_plateforme_illustration
			
			FROM  2015_test AS t
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = t.id_membre_createur
			
			LEFT JOIN 2015_test_jeu_version_plateforme AS tjvp
			ON tjvp.id_test = t.id_test
			
		
			LEFT JOIN 2015_test_jeu_version_plateforme_illustration AS tjvpi
			ON tjvpi.id_test_jeu_version_plateforme = tjvp.id_test_jeu_version_plateforme
			
			WHERE t.test_date_publication < NOW()
			AND t.test_date_publication <> "0000-00-00"
			AND tjvp.id_jeu_version_plateforme = t.id_jeu_version_plateforme
			ORDER BY t.test_date_publication DESC  ';
			
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlCountAllTests(){
$connexion = connexion();

$request = 'SELECT count(*) AS count
			
			FROM  2015_test AS t
			
			';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}
?>