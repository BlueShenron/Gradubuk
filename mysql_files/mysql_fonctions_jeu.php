<?php

require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectJeuVersionPlateformeById($id_jeu_version_plateforme, $jeu_region){
$connexion = connexion();

$request = '
SELECT jvp.id_jeu_version_plateforme, j.jeu_nom_generique, p.plateforme_nom_generique, jvr.id_jeu_version_region, jvr.jeu_region, e.editeur_nom,

CASE 
WHEN jvr.jeu_region_cover <> "" THEN CONCAT("jeux","/",j.jeu_dossier,"/covers/",jvr.jeu_region_cover) 
ELSE "jeux/nopicture.jpg" END AS url, 

CASE WHEN g.genre_nom IS NULL THEN "non renseigné" 
ELSE g.genre_nom END AS genre_nom,

CASE WHEN d.developpeur_nom IS NULL THEN "non renseigné" 
ELSE d.developpeur_nom END AS developpeur_nom,

CASE WHEN e.editeur_nom IS NULL THEN "non renseigné" 
ELSE e.editeur_nom END AS editeur_nom,

CASE WHEN jvr.jeu_region_nom ="" THEN "non renseigné" 
ELSE jvr.jeu_region_nom END AS jeu_region_nom


FROM 2015_jeu AS j

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN 2015_jeu_version_region AS jvr
ON jvr.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme

LEFT OUTER JOIN 2015_genre AS g
ON g.id_genre = j.id_genre

LEFT OUTER JOIN 2015_developpeur AS d
ON d.id_developpeur = j.id_developpeur

LEFT OUTER JOIN 2015_editeur AS e
ON e.id_editeur = jvr.id_editeur

LEFT OUTER JOIN 2015_test_jeu_version_plateforme AS tjvp
ON tjvp.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme 



WHERE jvp.id_jeu_version_plateforme = '.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'
AND jvr.jeu_region = "'.mysql_real_escape_string(trim($jeu_region)).'"
';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectJeuWithPageNumber($page,$nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = '
SELECT id_jeu_version_plateforme,jeu_nom_generique,plateforme_nom_generique,jeu_region,id_jeu_version_region,genre_nom,developpeur_nom,id_test_jeu_version_plateforme,test_date_publication,priority,url
FROM(
SELECT jvp.id_jeu_version_plateforme, j.jeu_nom_generique, p.plateforme_nom_generique, jvr.jeu_region, jvr.id_jeu_version_region,

CASE 
WHEN jvr.jeu_region_cover <> "" THEN CONCAT("jeux","/",j.jeu_dossier,"/covers/",jvr.jeu_region_cover) 
ELSE "jeux/nopicture.jpg" END AS url, 

CASE WHEN g.genre_nom IS NULL THEN "non renseigné" 
ELSE g.genre_nom END AS genre_nom,

CASE WHEN d.developpeur_nom IS NULL THEN "non renseigné" 
ELSE d.developpeur_nom END AS developpeur_nom,
	
CASE WHEN tjvp.id_test_jeu_version_plateforme IS NULL THEN "aucun test" 
ELSE tjvp.id_test_jeu_version_plateforme END AS id_test_jeu_version_plateforme,

CASE WHEN t.test_date_publication = "0000-00-00" THEN "test en attente" 
ELSE "test ok" END AS test_date_publication,

CASE 
WHEN jvr.jeu_region = "pal" THEN "1" 
WHEN jvr.jeu_region = "jp" THEN "2" 
ELSE "3" END AS priority 

FROM 2015_jeu AS j

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN 2015_jeu_version_region AS jvr
ON jvr.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme

LEFT OUTER JOIN 2015_genre AS g
ON g.id_genre = j.id_genre

LEFT OUTER JOIN 2015_developpeur AS d
ON d.id_developpeur = j.id_developpeur

LEFT OUTER JOIN 2015_test_jeu_version_plateforme AS tjvp
ON tjvp.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme 

LEFT OUTER JOIN 2015_test AS t
ON t.id_test = tjvp.id_test

WHERE jvp.id_jeu_version_plateforme IS NOT NULL
AND jvr.id_jeu_version_region IS NOT NULL

ORDER BY jvp.id_jeu_version_plateforme, priority
) AS SUB_QUERY
GROUP BY  id_jeu_version_plateforme ';


			
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlCountAllJeux(){
$connexion = connexion();

$request = 'SELECT count(*) AS count
			
			FROM  2015_jeu_version_plateforme AS jvp
			
			';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectTestJeuVersionPlateforme($id_jeu_version_plateforme){

$connexion = connexion();

$request = '
SELECT tjvp.id_test_jeu_version_plateforme, tjvp.test_note, tjvp.test_corps,

CASE WHEN t.test_date_publication = "0000-00-00" THEN "test en attente" 
ELSE "test ok" END AS test_date_publication

FROM 2015_test_jeu_version_plateforme AS tjvp

LEFT OUTER JOIN 2015_test_jeu_version_plateforme AS jvp
ON tjvp.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_test AS t
ON t.id_test = tjvp.id_test

WHERE jvp.id_jeu_version_plateforme = '.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'
';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

?>