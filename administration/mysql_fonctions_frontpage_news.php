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

function mysqlInsertFrontpage($frontpage_titre,$frontpage_sous_titre,$id_news,$date_publication,$image_url){

$connexion = connexion();

$request = "INSERT INTO 2015_frontpage_news
			VALUES ('','".mysql_real_escape_string(trim($frontpage_titre))."','".mysql_real_escape_string(trim($frontpage_sous_titre))."','".mysql_real_escape_string(trim($image_url))."',NOW(),NOW(),'".mysql_real_escape_string(trim($date_publication))."','".mysql_real_escape_string(trim($id_news))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlUpdateNews($id_news){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_news
			SET 
			id_membre_modificateur="'.mysql_real_escape_string($id_membre).'",
			news_date_modif= NOW()
		
			WHERE id_news = "'.mysql_real_escape_string($id_news).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlDeleteFrontpage($id_frontpage){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_frontpage_news
				WHERE id_frontpage = "'.mysql_real_escape_string($id_frontpage).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlSelectFrontpageByID($id_frontpage){
$connexion = connexion();

$request = 'SELECT *
			
			FROM  2015_frontpage_news AS f
		
			WHERE f.id_frontpage = '.mysql_real_escape_string($id_frontpage).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlUpdateFrontpage($id_frontpage,$frontpage_titre,$frontpage_sous_titre){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_frontpage_news
			SET 
			frontpage_titre="'.mysql_real_escape_string($frontpage_titre).'" , 
			frontpage_sous_titre="'.mysql_real_escape_string($frontpage_sous_titre).'" , 
			frontpage_date_modif = NOW()
		
			WHERE id_frontpage = "'.mysql_real_escape_string($id_frontpage).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}
?>