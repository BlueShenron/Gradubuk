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

$request = 'SELECT n.id_news, n.news_titre, n.news_corps,
			DATE_FORMAT(n.news_date_creation,"%d %b %Y - %H:%i") AS news_date_creation, 
			
			CASE WHEN n.news_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(n.news_date_publication, "le %d/%m/%Y à %H:%i") END AS news_date_publication,
			
			n.news_date_publication AS news_date_publication_non_formate,
			m.pseudo,
			
			nillu.url_news_illustration
			
			FROM  2015_news AS n
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = n.id_membre_createur
			
			
		
			LEFT JOIN 2015_news_illustration AS nillu
			ON nillu.id_news = n.id_news
		
			
		
			
		
			WHERE n.id_news = '.mysql_real_escape_string($id_news).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectNewsWithPageNumber($page,$nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT n.id_news, n.news_titre, n.news_corps,
			DATE_FORMAT(n.news_date_creation,"%d %b %Y - %H:%i") AS news_date_creation, 
			
			CASE WHEN n.news_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(n.news_date_publication, "le %d/%m/%Y à %H:%i") END AS news_date_publication,
			
			n.news_date_publication AS news_date_publication_non_formate,
			m.pseudo,
			
			nillu.url_news_illustration
			
			FROM  2015_news AS n
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = n.id_membre_createur
			
			LEFT JOIN 2015_news_illustration AS nillu
			ON nillu.id_news = n.id_news
		
			
			WHERE n.news_date_publication < NOW()
			AND n.news_date_publication <> "0000-00-00"
			ORDER BY n.news_date_publication DESC  ';
			
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlCountAllNews(){
$connexion = connexion();

$request = 'SELECT count(*) AS count
			
			FROM  2015_news AS n
			
			';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}
?>