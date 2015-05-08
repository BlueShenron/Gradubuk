<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllPlateformes(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_plateforme 
			ORDER BY plateforme_nom_generique';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllPlateformesWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT p.id_plateforme,p.plateforme_nom_generique,
			CASE WHEN p.retro = "1" THEN "oui" ELSE "non" END AS retro,
			
			
			COALESCE(c.constructeur_nom,"non renseigné") AS constructeur_nom,
			CASE WHEN c.constructeur_nom IS NULL THEN "resultat_nok" ELSE "resultat" END AS class_constructeur_resultat,

			
			
			CASE WHEN p.plateforme_image_generique = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN p.plateforme_image_generique = "" THEN "nopicture.jpg"
			WHEN p.plateforme_image_generique IS NULL THEN "nopicture.jpg"
			ELSE CONCAT_WS("/",p.plateforme_dossier,p.plateforme_image_generique) END AS plateforme_image_generique,
			
			
			CASE WHEN p.plateforme_description IS NULL THEN "aucune description" 
			WHEN p.plateforme_description = "" THEN "aucune description" 
			ELSE p.plateforme_description END AS plateforme_description,
			
			CASE WHEN p.plateforme_description IS NULL THEN "resultat_nok" 
			 WHEN p.plateforme_description = "" THEN "resultat_nok"
			ELSE "resultat" END AS class_plateforme_resultat

			
			FROM  2015_plateforme AS p
			LEFT JOIN 2015_constructeur AS c
			ON p.id_constructeur = c.id_constructeur
			

			
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'plateforme_nom_generique' && $order != 'constructeur_nom' ){$request .='DESC ';}

$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertPlateforme($id_constructeur,$plateforme_name,$plateforme_descriptif,$plateforme_retro,$plateforme_dossier,$image_nom){
$connexion = connexion();

$request = "INSERT INTO 2015_plateforme
			VALUES ('','".mysql_real_escape_string(trim($id_constructeur))."','".mysql_real_escape_string(trim($plateforme_name))."','".mysql_real_escape_string(trim($image_nom))."','".mysql_real_escape_string(trim($plateforme_descriptif))."','".mysql_real_escape_string(trim($plateforme_retro))."',NOW(),NOW(),'".mysql_real_escape_string(trim($plateforme_dossier))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeletePlateformeByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_plateforme
			WHERE id_plateforme = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());

mysql_close($connexion);


}

function mysqlSelectPlateformeByID($id){
$connexion = connexion();

$request = 'SELECT p.id_plateforme, p.plateforme_nom_generique, p.retro, p.id_constructeur,c.constructeur_nom, p.plateforme_description,
 			p.plateforme_dossier,
			
			CASE WHEN p.plateforme_image_generique = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN p.plateforme_image_generique = "" THEN "nopicture.jpg"
			WHEN p.plateforme_image_generique IS NULL THEN "nopicture.jpg"
			ELSE p.plateforme_image_generique END AS  plateforme_image_generique,
			
			CASE WHEN p.plateforme_image_generique = "nopicture.jpg" THEN "nopicture.jpg"
			WHEN p.plateforme_image_generique = "" THEN "nopicture.jpg"
			WHEN p.plateforme_image_generique IS NULL THEN "nopicture.jpg"
			ELSE CONCAT_WS("/",p.plateforme_dossier,p.plateforme_image_generique) END AS plateforme_image_generique_url
			
			FROM 2015_plateforme AS p
			LEFT JOIN 2015_constructeur AS c
			ON c.id_constructeur = p.id_constructeur

			WHERE p.id_plateforme = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllPlateformeVersions($id_plateforme){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT pv.id_plateforme_version, pv.plateforme_version_nom, pv.plateforme_version_date_creation, pv.plateforme_version_date_modif, 
			p.plateforme_nom_generique AS plateforme_nom,
			
			CASE WHEN pv.date_lancement = "0000-00-00" THEN "non renseignée" ELSE DATE_FORMAT(pv.date_lancement, "%d/%m/%Y") END AS date_lancement,
			
			CASE WHEN pv.date_lancement = "0000-00-00" THEN "resultat_nok" ELSE "resultat" END AS class_date_lancement,
			
			CASE WHEN pv.date_fin = "0000-00-00" THEN "non renseignée" ELSE DATE_FORMAT(pv.date_fin, "%d/%m/%Y") END AS date_fin,
			
			CASE WHEN pv.date_fin = "0000-00-00" THEN "resultat_nok" ELSE "resultat" END AS class_date_fin,

			
			CASE WHEN pv.plateforme_version_description IS NULL THEN "non renseigné" 
			WHEN pv.plateforme_version_description = "" THEN "non renseigné" 
			ELSE pv.plateforme_version_description END AS description,
			
			CASE WHEN pv.plateforme_version_description IS NULL THEN "non resultat_nok" 
			WHEN pv.plateforme_version_description = "" THEN "non resultat_nok" 
			ELSE "resultat" END AS class_description
			

			FROM  2015_plateforme_version AS pv
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			WHERE pv.id_plateforme = '.$id_plateforme.'';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlCountVersionsPlateformeByID($id){
$connexion = connexion();

$request = 'SELECT

			CASE WHEN count(*) = 0 THEN "aucune version"  
			ELSE count(*) END AS count,
			
			CASE WHEN count(*) = 0 THEN "resultat_nok" 
			ELSE "resultat" END AS class_count_resultat
			
			FROM 2015_plateforme_version AS pv
			
			WHERE pv.id_plateforme = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlUpdatePlateforme($id_plateforme,$id_constructeur, $plateforme_name,$plateforme_descriptif,$retro,$image_nom){

$connexion = connexion();
$request = 'UPDATE 2015_plateforme
			SET plateforme_nom_generique="'.mysql_real_escape_string(trim($plateforme_name)).'" , 
			id_constructeur="'.mysql_real_escape_string(trim($id_constructeur)).'",

			plateforme_description="'.mysql_real_escape_string(trim($plateforme_descriptif)).'",
			plateforme_image_generique="'.mysql_real_escape_string(trim($image_nom)).'",
			retro="'.mysql_real_escape_string(trim($retro)).'",
			plateforme_date_modif=NOW()
			WHERE id_plateforme = "'.mysql_real_escape_string(trim($id_plateforme)).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdatepicturePlateforme($plateforme_id, $image_name){
$connexion = connexion();
$request = 'UPDATE 2015_plateforme
			SET	plateforme_image_generique="'.mysql_real_escape_string(trim($image_name)).'"
			WHERE id_plateforme = '.mysql_real_escape_string(trim($plateforme_id)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlSelectAllConstructeurs(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_constructeur 
			ORDER BY constructeur_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}



function mysqlDeletePlateformeVersionsOrphelines(){
	$connexion = connexion();
	$request = 'DELETE pv
				FROM 2015_plateforme_version AS pv 
				LEFT JOIN 2015_plateforme AS p 
				ON pv.id_plateforme = p.id_plateforme
				WHERE ISNULL(p.id_plateforme)
			';	
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}

function mysqlDeletePlateformeVersionImagesOrphelines(){
	$connexion = connexion();
	$request = 'DELETE ipv
				FROM 2015_plateforme_version_image AS ipv
				LEFT JOIN 2015_plateforme_version AS pv
				ON ipv.id_plateforme_version = pv.id_plateforme_version
				WHERE ISNULL(pv.id_plateforme_version)
			';	
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}



function mysqlCountPlateformeVersion($id_plateforme){
$connexion = connexion();

$request = 'SELECT count(*) AS count,
			CASE WHEN count(*) = 0 THEN 1 ELSE count(*) END AS rowspan
			FROM 2015_plateforme_version AS pv
			
			WHERE pv.id_plateforme = \''.mysql_real_escape_string(trim($id_plateforme)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectPremierPlateformeVersion($id_plateforme){

$connexion = connexion();

$request = 'SELECT  *
			
		
			FROM  2015_plateforme_version AS pv

			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			WHERE pv.id_plateforme = \''.mysql_real_escape_string(trim($id_plateforme)).'\'
			ORDER BY  pv.plateforme_version_nom
			LIMIT 1';
	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPlateformeVersionSuivante($limit,$id_plateforme){

$connexion = connexion();

$request = 'SELECT  *
			
		
			FROM  2015_plateforme_version AS pv

			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			WHERE pv.id_plateforme = \''.mysql_real_escape_string(trim($id_plateforme)).'\'
			ORDER BY  pv.plateforme_version_nom

			LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET 1';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}



?>