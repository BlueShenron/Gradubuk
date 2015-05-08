<?php

require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}


function mysqlSelectArticleByID($id_article){
$connexion = connexion();

$request = 'SELECT a.id_article, a.article_titre, a.article_date_publication, ai.url_article_illustration
			
			FROM  2015_article AS a
			
			LEFT JOIN 2015_article_illustration AS ai
			ON ai.id_article = a.id_article
		
			WHERE a.id_article = '.mysql_real_escape_string($id_article).'';

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

function mysqlInsertArticlePhoto($id_article,$image_name,$photo_titre,$id_categorie_image){
$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_article_photo
			VALUES ('','".mysql_real_escape_string($id_article)."','".mysql_real_escape_string($image_name)."','".mysql_real_escape_string($photo_titre)."','".mysql_real_escape_string(trim($id_categorie_image))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlUpdateArticleDateModif($id_article){

$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_article
			SET 
			
			article_date_modif= NOW()
		
				WHERE id_article = "'.mysql_real_escape_string($id_article).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdateArticlePhoto($id_article_photo,$photo_titre,$id_categorie_image){

$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_article_photo
			SET 
			
			
			photo_titre = "'.mysql_real_escape_string($photo_titre).'",
			
			id_categorie_image = "'.mysql_real_escape_string($id_categorie_image).'"
				
			WHERE id_article_photo = "'.mysql_real_escape_string($id_article_photo).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlSelectAllArticlePhoto($id_article){
$connexion = connexion();
$request = 'SELECT ap.id_article_photo, ap.photo_titre, ap.article_photo_nom , ic.categorie_image_nom
			FROM  2015_article_photo AS ap
			
			LEFT JOIN 2015_categorie_image AS ic
			ON ic.id_categorie_image = ap.id_categorie_image
			
			WHERE ap.id_article = \''.mysql_real_escape_string($id_article).'\'
			
			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}
function mysqlSelectArticlePhoto($id_article_photo){
$connexion = connexion();
$request = 'SELECT ap.article_photo_nom,ap.id_article_photo,ap.photo_titre,a.article_titre,a.id_article, ic.id_categorie_image
			FROM  2015_article_photo AS ap
			
			LEFT JOIN 2015_categorie_image AS ic
			ON ic.id_categorie_image = ap.id_categorie_image
			
			LEFT JOIN 2015_article AS a
			ON a.id_article = ap.id_article
			
			WHERE ap.id_article_photo = \''.mysql_real_escape_string($id_article_photo).'\'
			
			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteArticlePhoto($id_article_photo){


	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_article_photo
				WHERE id_article_photo = "'.mysql_real_escape_string($id_article_photo).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);

}
?>