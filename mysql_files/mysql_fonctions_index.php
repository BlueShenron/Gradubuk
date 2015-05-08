<?php

require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectFrontpage(){

$connexion = connexion();
$request = "SELECT f.TITRE, f.SOUS_TITRE,
			f.URL,
			f.DATE_PUBLICATION,
			
			
			CASE WHEN f.ILLUSTRATION = '' THEN 'ressources/frontpage_defaut.jpg'

			ELSE f.ILLUSTRATION END AS ILLUSTRATION
			
			FROM frontpage AS f
			WHERE DATE_PUBLICATION < NOW()
			AND DATE_PUBLICATION <> '0000-00-00'
			ORDER BY DATE_PUBLICATION DESC LIMIT 5";
			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

?>