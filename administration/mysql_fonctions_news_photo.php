<?php

require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}


function mysqlSelectNewsByID($id_news){
$connexion = connexion();

$request = 'SELECT a.id_news, a.news_titre, a.news_date_publication, ai.url_news_illustration
			
			FROM  2015_news AS a
			
			LEFT JOIN 2015_news_illustration AS ai
			ON ai.id_news = a.id_news
		
			WHERE a.id_news = '.mysql_real_escape_string($id_news).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectAllImgCategories(){
$connexion = connexion();

$request = 'SELECT ic.id_categorie_image, coalesce(ic.categorie_image_nom,"non renseigné") AS categorie_image_nom
			FROM  2015_categorie_image AS ic 
			ORDER BY categorie_image_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertNewsPhoto($id_news,$image_name,$photo_titre,$id_categorie_image){
$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_news_photo
			VALUES ('','".mysql_real_escape_string($id_news)."','".mysql_real_escape_string($image_name)."','".mysql_real_escape_string($photo_titre)."','".mysql_real_escape_string(trim($id_categorie_image))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlUpdateNewsDateModif($id_news){

$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_news
			SET 
			
			news_date_modif= NOW()
		
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdateNewsPhoto($id_news_photo,$photo_titre,$id_categorie_image){

$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_news_photo
			SET 
			
			
			photo_titre = "'.mysql_real_escape_string($photo_titre).'",
			
			id_categorie_image = "'.mysql_real_escape_string($id_categorie_image).'"
				
			WHERE id_news_photo = "'.mysql_real_escape_string($id_news_photo).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlSelectAllNewsPhoto($id_news){
$connexion = connexion();
$request = 'SELECT ap.id_news_photo, ap.photo_titre, ap.news_photo_nom , ic.categorie_image_nom
			FROM  2015_news_photo AS ap
			
			LEFT JOIN 2015_categorie_image AS ic
			ON ic.id_categorie_image = ap.id_categorie_image
			
			WHERE ap.id_news = \''.mysql_real_escape_string($id_news).'\'
			
			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}
function mysqlSelectNewsPhoto($id_news_photo){
$connexion = connexion();
$request = 'SELECT ap.news_photo_nom,ap.id_news_photo,ap.photo_titre,a.news_titre,a.id_news, ic.id_categorie_image
			FROM  2015_news_photo AS ap
			
			LEFT JOIN 2015_categorie_image AS ic
			ON ic.id_categorie_image = ap.id_categorie_image
			
			LEFT JOIN 2015_news AS a
			ON a.id_news = ap.id_news
			
			WHERE ap.id_news_photo = \''.mysql_real_escape_string($id_news_photo).'\'
			
			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteNewsPhoto($id_news_photo){


	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_photo
				WHERE id_news_photo = "'.mysql_real_escape_string($id_news_photo).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);

}
?>