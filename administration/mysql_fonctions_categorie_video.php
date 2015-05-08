<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllCategorieVideos(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_categorie_video 
			ORDER BY categorie_video_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllCategorieVideosWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT * 
			FROM  2015_categorie_video
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'categorie_video_nom'){$request .='DESC ';}
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertCategorieVideo($categorie_video_name){
$connexion = connexion();

$request = "INSERT INTO 2015_categorie_video
			VALUES ('','".mysql_real_escape_string(trim($categorie_video_name))."',NOW(),NOW())";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteCategorieVideoByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_categorie_video
			WHERE id_categorie_video = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectCategorieVideoByID($id){
$connexion = connexion();

$request = 'SELECT * 
			FROM 2015_categorie_video 
			WHERE id_categorie_video = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlUpdateCategorieVideo($categorie_video_name, $categorie_video_id){
$connexion = connexion();
$request = 'UPDATE 2015_categorie_video
			SET categorie_video_nom="'.mysql_real_escape_string(trim($categorie_video_name)).'" , 
			categorie_video_date_modif=NOW()
			WHERE id_categorie_video = '.mysql_real_escape_string(trim($categorie_video_id)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}
?>