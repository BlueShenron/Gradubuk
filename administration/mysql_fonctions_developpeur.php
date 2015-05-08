<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllDeveloppeurs(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_developpeur 
			ORDER BY developpeur_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllDeveloppeursWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT d.id_developpeur AS id_developpeur, d.developpeur_nom,
			
			CASE WHEN d.developpeur_image_nom = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN d.developpeur_image_nom = "" THEN "nopicture.jpg"
			WHEN d.developpeur_image_nom IS NULL THEN "nopicture.jpg"
			ELSE d.developpeur_image_nom END AS developpeur_logo
		
			FROM  2015_developpeur AS d
			
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'developpeur_nom'){$request .='DESC ';}
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertDeveloppeur($developpeur_name,$image_nom){
$connexion = connexion();

$request = "INSERT INTO 2015_developpeur
			VALUES ('','".mysql_real_escape_string(trim($developpeur_name))."',NOW(),NOW(),'".$image_nom."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}



function mysqlDeleteDeveloppeurByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_developpeur
			WHERE id_developpeur = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectDeveloppeurByID($id){
$connexion = connexion();

$request = 'SELECT  d.id_developpeur, d.developpeur_nom,
			
			CASE WHEN d.developpeur_image_nom = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN d.developpeur_image_nom = "" THEN "nopicture.jpg"
			WHEN d.developpeur_image_nom IS NULL THEN "nopicture.jpg"
			ELSE d.developpeur_image_nom END AS developpeur_logo

			FROM  2015_developpeur AS d
			
			WHERE d.id_developpeur = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlUpdateDeveloppeur($developpeur_name, $developpeur_id, $image_nom){
$connexion = connexion();
$request = 'UPDATE 2015_developpeur
			SET developpeur_nom="'.mysql_real_escape_string(trim($developpeur_name)).'" ,
			developpeur_image_nom="'.mysql_real_escape_string(trim($image_nom)).'" , 
			developpeur_date_modif=NOW()
			WHERE id_developpeur = '.mysql_real_escape_string(trim($developpeur_id)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlDeleteNewsDeveloppeurOrpheline(){
	$connexion = connexion();
	$request = 'DELETE nd
				FROM 2015_news_developpeur AS nd
				LEFT JOIN 2015_developpeur AS d ON nd.id_developpeur = d.id_developpeur
				WHERE ISNULL(d.id_developpeur)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlCountNewsImage($url){
	$connexion = connexion();
	$request = 'SELECT
(SELECT COUNT(*) FROM 2015_news_illustration AS nillu WHERE nillu.url_news_illustration="'.mysql_real_escape_string(trim($url)).'") 
+(SELECT COUNT(*) FROM 2015_news_image AS nimg WHERE nimg.url_news_image="'.mysql_real_escape_string(trim($url)).'") AS SumCount
			
			';
			
	$result = mysql_query($request) or die(mysql_error());
	return $result;
mysql_close($connexion);
	
	

}



function mysqlDeleteNewsImage($url){
	$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_image AS ni		
				WHERE ni.url_news_image = "'.mysql_real_escape_string(trim($url)).'"';
			
	$result = mysql_query($request) or die(mysql_error());
	
	$request = 'DELETE ni
				FROM 2015_news_illustration AS ni		
				WHERE ni.url_news_illustration = "'.mysql_real_escape_string(trim($url)).'"';
			
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

?>