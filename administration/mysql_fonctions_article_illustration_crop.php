<?php

require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}


function mysqlInsertArticlePhoto($id_article,$image_name,$photo_titre,$id_categorie_image){
//$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_article_photo
			VALUES ('','".mysql_real_escape_string($id_article)."','".mysql_real_escape_string($image_name)."','".mysql_real_escape_string($photo_titre)."','".mysql_real_escape_string(trim($id_categorie_image))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteArticleIllustration($id_article){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_article_illustration
				WHERE id_article = "'.mysql_real_escape_string($id_article).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlInsertArticleIllustration($id_article,$url_image,$image_titre,$image_alt){
$connexion = connexion();
$request = "INSERT INTO 2015_article_illustration
			VALUES ('','".mysql_real_escape_string(trim($id_article))."','".mysql_real_escape_string(trim($url_image))."','".mysql_real_escape_string(trim($image_titre))."','".mysql_real_escape_string(trim($image_alt))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}
?>