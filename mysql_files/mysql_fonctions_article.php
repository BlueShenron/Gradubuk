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

$request = 'SELECT n.id_article, n.article_titre, n.article_corps,
			DATE_FORMAT(n.article_date_creation,"%d %b %Y - %H:%i") AS article_date_creation, 
			
			CASE WHEN n.article_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(n.article_date_publication, "le %d/%m/%Y à %H:%i") END AS article_date_publication,
			
			n.article_date_publication AS article_date_publication_non_formate,
			m.pseudo,
			
			nillu.url_article_illustration
			
			FROM  2015_article AS n
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = n.id_membre_createur
			
			
		
			LEFT JOIN 2015_article_illustration AS nillu
			ON nillu.id_article = n.id_article
		
			
		
			
		
			WHERE n.id_article = '.mysql_real_escape_string($id_article).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectArticleWithPageNumber($page,$nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT n.id_article, n.article_titre, n.article_corps,
			DATE_FORMAT(n.article_date_creation,"%d %b %Y - %H:%i") AS article_date_creation, 
			
			CASE WHEN n.article_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(n.article_date_publication, "le %d/%m/%Y à %H:%i") END AS article_date_publication,
			
			n.article_date_publication AS article_date_publication_non_formate,
			m.pseudo,
			
			nillu.url_article_illustration
			
			FROM  2015_article AS n
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = n.id_membre_createur
			
		
			LEFT JOIN 2015_article_illustration AS nillu
			ON nillu.id_article = n.id_article
		
			
			WHERE n.article_date_publication < NOW()
			AND n.article_date_publication <> "0000-00-00"
			ORDER BY n.article_date_publication DESC  ';
			
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlCountAllArticles(){
$connexion = connexion();

$request = 'SELECT count(*) AS count
			
			FROM  2015_article AS n
			
			';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}
?>