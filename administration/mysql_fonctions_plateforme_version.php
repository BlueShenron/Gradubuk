<?php
require_once('mysql_bdd_connect.php'); 
require_once('authentification.php');
session_start();


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
			ORDER BY plateforme_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllPlateformeVersionsWithPageNumber($page, $order, $id_plateforme){

$connexion = connexion();
$debut=($page*10)-10;
$fin=$page*10;
$request = 'SELECT pv.id_plateforme_version, pv.plateforme_version_nom, pv.plateforme_version_date_creation, pv.plateforme_version_date_modif, 
			p.plateforme_nom_generique AS plateforme_nom,
			
			CASE WHEN pv.plateforme_version_description IS NULL THEN "non renseigné" 
			WHEN pv.plateforme_version_description = "" THEN "non renseigné" 
			ELSE pv.plateforme_version_description END AS description
			
			FROM  2015_plateforme_version AS pv
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			WHERE pv.id_plateforme = '.$id_plateforme.'
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'plateforme_version_nom'){$request .='DESC ';}
$request .=	'LIMIT '.mysql_real_escape_string(trim($debut)).','.mysql_real_escape_string(trim($fin)).'';



$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertPlateformeVersion($id_plateforme,$plateforme_version_name,$plateforme_version_descriptif,$date_lancement,$date_fin){

$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = "INSERT INTO 2015_plateforme_version
			VALUES ('','".mysql_real_escape_string(trim($id_plateforme))."','".mysql_real_escape_string(trim($plateforme_version_name))."','".mysql_real_escape_string(trim($date_lancement))."','".mysql_real_escape_string(trim($date_fin))."','".mysql_real_escape_string(trim($plateforme_version_descriptif))."',NOW(),NOW(),'".$id_membre."')";
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeletePlateformeVersionByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_plateforme_version
			WHERE id_plateforme_version = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPlateformeByID($id){
$connexion = connexion();

$request = 'SELECT p.id_plateforme, p.plateforme_nom_generique, p.retro, p.id_constructeur, p.plateforme_description,
 			p.plateforme_dossier,p.plateforme_image_generique,
			
			CASE WHEN p.plateforme_image_generique = "nopicture.jpg" THEN "nopicture.jpg"  
			ELSE CONCAT_WS("/",p.plateforme_dossier,p.plateforme_image_generique) END AS plateforme_image_generique_url
			
			FROM 2015_plateforme AS p
			WHERE id_plateforme = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPlateformeVersionsByID($id){
$connexion = connexion();

$request = 'SELECT pv.plateforme_version_nom
			
			FROM 2015_plateforme_version AS pv
			LEFT OUTER JOIN 2015_plateforme AS p
			ON pv.id_plateforme = p.id_plateforme

			
			WHERE pv.id_plateforme = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectPlateformeVersionByID($id){
$connexion = connexion();

$request = 'SELECT pv.plateforme_version_nom, pv.plateforme_version_description,  p.plateforme_nom_generique, 
			pv.date_lancement, pv.date_fin,
			p.id_plateforme, p.plateforme_dossier
			
			FROM 2015_plateforme_version AS pv
			LEFT OUTER JOIN 2015_plateforme AS p
			ON pv.id_plateforme = p.id_plateforme

			
			WHERE pv.id_plateforme_version = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlUpdatePlateformeVersion($id_plateforme_version,$plateforme_version_name,$plateforme_version_descriptif,$date_lancement,$date_fin){

$connexion = connexion();
$request = 'UPDATE 2015_plateforme_version
			SET plateforme_version_nom="'.mysql_real_escape_string(trim($plateforme_version_name)).'" , 
			plateforme_version_description="'.mysql_real_escape_string(trim($plateforme_version_descriptif)).'",
			date_lancement="'.mysql_real_escape_string(trim($date_lancement)).'",
			date_fin="'.mysql_real_escape_string(trim($date_fin)).'",

			plateforme_version_date_modif=NOW()
			WHERE id_plateforme_version = "'.mysql_real_escape_string(trim($id_plateforme_version)).'"';
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

function mysqlInsertPlateformeVersionImage($id_plateforme,$image_nom){

$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = "INSERT INTO 2015_plateforme_version_image
			VALUES ('','".mysql_real_escape_string(trim($id_plateforme))."','".mysql_real_escape_string(trim($image_nom))."',NOW(),'".$id_membre."')";
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlSelectAllPlateformeVersionImages($id_plateforme_version){

$connexion = connexion();

$request = 'SELECT i.plateforme_version_image_nom,i.id_plateforme_version_image,pv.plateforme_version_nom,
			p.plateforme_dossier
			
			FROM 2015_plateforme_version_image AS i
			LEFT OUTER JOIN 2015_plateforme_version AS pv
			ON pv.id_plateforme_version = i.id_plateforme_version

			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			WHERE i.id_plateforme_version = \''.mysql_real_escape_string(trim($id_plateforme_version)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllPlateformeVersionImage($id){

$connexion = connexion();

$request = 'SELECT i.plateforme_version_image_nom,i.id_plateforme_version_image,pv.plateforme_version_nom,
			p.plateforme_dossier
			
			FROM 2015_plateforme_version_image AS i
			LEFT OUTER JOIN 2015_plateforme_version AS pv
			ON pv.id_plateforme_version = i.id_plateforme_version

			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			WHERE i.id_plateforme_version_image = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlDeletePlateformeVersionImageByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_plateforme_version_image
			WHERE id_plateforme_version_image = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

?>