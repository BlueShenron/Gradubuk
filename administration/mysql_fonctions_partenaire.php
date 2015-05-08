<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllPartenaires(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_partenaire 
			ORDER BY partenaire_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllPartenairesWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT d.id_partenaire AS id_partenaire, d.partenaire_nom,d.partenaire_url,
			
			CASE WHEN d.partenaire_image_nom = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN d.partenaire_image_nom = "" THEN "nopicture.jpg"
			WHEN d.partenaire_image_nom IS NULL THEN "nopicture.jpg"
			ELSE d.partenaire_image_nom END AS partenaire_logo
		
			FROM  2015_partenaire AS d
			
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'partenaire_nom'){$request .='DESC ';}
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertPartenaire($partenaire_name,$partenaire_url,$image_nom){
$connexion = connexion();

$request = "INSERT INTO 2015_partenaire
			VALUES ('','".mysql_real_escape_string(trim($partenaire_name))."','".mysql_real_escape_string(trim($partenaire_url))."',NOW(),NOW(),'".$image_nom."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}



function mysqlDeletePartenaireByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_partenaire
			WHERE id_partenaire = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPartenaireByID($id){
$connexion = connexion();

$request = 'SELECT  d.id_partenaire, d.partenaire_nom,d.partenaire_url,
			
			CASE WHEN d.partenaire_image_nom = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN d.partenaire_image_nom = "" THEN "nopicture.jpg"
			WHEN d.partenaire_image_nom IS NULL THEN "nopicture.jpg"
			ELSE d.partenaire_image_nom END AS partenaire_logo

			FROM  2015_partenaire AS d
			
			WHERE d.id_partenaire = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlUpdatePartenaire($partenaire_name, $partenaire_id, $image_nom, $partenaire_url){
$connexion = connexion();
$request = 'UPDATE 2015_partenaire
			SET partenaire_nom="'.mysql_real_escape_string(trim($partenaire_name)).'" ,
			partenaire_image_nom="'.mysql_real_escape_string(trim($image_nom)).'" , 
			partenaire_url="'.mysql_real_escape_string(trim($partenaire_url)).'" , 

			partenaire_date_modif=NOW()
			WHERE id_partenaire = '.mysql_real_escape_string(trim($partenaire_id)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}


?>