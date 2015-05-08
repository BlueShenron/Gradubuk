<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllSousCategorieNews(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_sous_categorie_news 
			ORDER BY sous_categorie_news_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}



function mysqlInsertSousCategorieNews($sous_categorie_news_name, $id_famille_sous_categorie_news, $image){
$connexion = connexion();

$request = "INSERT INTO 2015_sous_categorie_news
			VALUES ('','".mysql_real_escape_string(trim($id_famille_sous_categorie_news))."','".mysql_real_escape_string(trim($sous_categorie_news_name))."',NOW(),NOW(),'".mysql_real_escape_string(trim($image))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}



function mysqlDeleteSousCategorieNewsByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_sous_categorie_news
			WHERE id_sous_categorie_news = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectSousCategorieNewsByID($id){
$connexion = connexion();

$request = 'SELECT  scn.id_sous_categorie_news, scn.sous_categorie_news_nom,cn.id_categorie_news,cn.categorie_news_nom,
			
			CASE WHEN scn.sous_categorie_news_image_nom = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN scn.sous_categorie_news_image_nom = "" THEN "nopicture.jpg"
			WHEN scn.sous_categorie_news_image_nom IS NULL THEN "nopicture.jpg"
			ELSE scn.sous_categorie_news_image_nom END AS sous_categorie_news_logo
		
			FROM  2015_sous_categorie_news AS scn
			
			
			LEFT OUTER JOIN 2015_categorie_news AS cn
			ON cn.id_categorie_news = scn.id_categorie_news
			
			WHERE scn.id_sous_categorie_news = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlUpdateSousCategorieNews($sous_categorie_news_name, $sous_categorie_news_id, $id_famille_sous_categorie_news,$image){
$connexion = connexion();
$request = 'UPDATE 2015_sous_categorie_news
			SET sous_categorie_news_nom="'.mysql_real_escape_string(trim($sous_categorie_news_name)).'" ,
			id_categorie_news="'.mysql_real_escape_string(trim($id_famille_sous_categorie_news)).'" , 
			sous_categorie_news_image_nom="'.mysql_real_escape_string(trim($image)).'" , 
			sous_categorie_news_date_modif=NOW()
			WHERE id_sous_categorie_news = '.mysql_real_escape_string(trim($sous_categorie_news_id)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdateSousCategorieNewsImage($id_dev, $image_name){
$connexion = connexion();
$request = 'UPDATE 2015_sous_categorie_news_image
			SET	sous_categorie_news_image_nom ="'.mysql_real_escape_string(trim($image_name)).'"
			WHERE id_sous_categorie_news = '.mysql_real_escape_string(trim($id_dev)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}



function mysqlSelectAllCategorieNews(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_categorie_news 
			ORDER BY categorie_news_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}
function mysqlSelectCategorieNewsByID($id){
$connexion = connexion();

$request = 'SELECT * 
			FROM 2015_categorie_news 
			WHERE id_categorie_news = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteNewsSousCategorieNewsSousCategorieNewsOrpheline(){
	$connexion = connexion();
	$request = 'DELETE nscn
				FROM 2015_news_sous_categorie_news AS nscn
				LEFT JOIN 2015_sous_categorie_news AS scn ON scn.id_sous_categorie_news = nscn.id_sous_categorie_news
				WHERE ISNULL(scn.id_sous_categorie_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}


?>