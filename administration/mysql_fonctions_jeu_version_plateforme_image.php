<?php
require_once('mysql_bdd_connect.php'); 
require_once('authentification.php');

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectVersionsCompletesByjeuVersionPlateformeID($id_jeu_version_plateforme){
$connexion = connexion();
$request = 'SELECT DISTINCT j.id_jeu, j.jeu_nom_generique, j.jeu_dossier, 
jvpi.image_nom, jvpi.id_jeu_version_plateforme_image,

p.id_plateforme, p.plateforme_nom_generique


FROM  2015_jeu_version_plateforme AS jvp
LEFT OUTER JOIN 2015_jeu AS j
ON j.id_jeu = jvp.id_jeu


LEFT OUTER JOIN 2015_jeu_version_plateforme_image AS jvpi
ON jvpi.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_categorie_image AS ci
ON jvpi.id_categorie_image = ci.id_categorie_image


LEFT OUTER JOIN  2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme


WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'"


';		
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

function mysqlSelectAllImagesByJeuVersionPlateformeId($id_jeu_version_plateforme){
$connexion = connexion();
$request = 'SELECT DISTINCT jvpi.image_nom, j.jeu_dossier,
jvpi.image_titre, jvpi.id_jeu_version_plateforme_image, coalesce(ic.categorie_image_nom,"non renseigné") AS categorie_image_nom, jvp.id_jeu_version_plateforme


FROM 2015_jeu_version_plateforme_image AS jvpi

LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme

LEFT OUTER JOIN  2015_jeu AS j
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN  2015_categorie_image AS ic
ON ic.id_categorie_image = jvpi.id_categorie_image

WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'"

ORDER BY ic.categorie_image_nom
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectImgCategoriesById($id_categorie_image){
$connexion = connexion();

$request = 'SELECT ic.id_categorie_image, coalesce(ic.categorie_image_nom,"non renseigné") AS categorie_image_nom
			FROM  2015_categorie_image AS ic
			WHERE id_categorie_image = '.$id_categorie_image.'';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertImageJeuVersionPlateforme($id_jeu_version_plateforme,$image_name, $id_categorie_image, $image_titre){
$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_jeu_version_plateforme_image
			VALUES ('','".mysql_real_escape_string($id_jeu_version_plateforme)."','".mysql_real_escape_string($image_name)."','".mysql_real_escape_string($id_categorie_image)."','".mysql_real_escape_string(trim($image_titre))."',NOW(),'".mysql_real_escape_string(trim($id_membre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlSelectJeuVersionPlateformeImage($id){

$connexion = connexion();

$request = 'SELECT jvpi.image_nom,
			jvpi.id_jeu_version_plateforme_image,
			j.jeu_dossier
			
			FROM 2015_jeu_version_plateforme_image AS jvpi
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE jvpi.id_jeu_version_plateforme_image = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteJeuVersionPlateformeImageByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_jeu_version_plateforme_image
			WHERE id_jeu_version_plateforme_image = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectVersionsCompletesByjeuVersionPlateformeIdImage($id_image){

$connexion = connexion();
$request = 'SELECT jvpi.image_nom, j.jeu_dossier, j.id_jeu, j.jeu_nom_generique,p.plateforme_nom_generique,
jvpi.image_titre, jvpi.id_jeu_version_plateforme_image, coalesce(ic.categorie_image_nom,"non renseigné") AS categorie_image_nom, 
ic.id_categorie_image,
jvp.id_jeu_version_plateforme


FROM 2015_jeu_version_plateforme_image AS jvpi

LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme

LEFT OUTER JOIN  2015_jeu AS j
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN  2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme

LEFT OUTER JOIN  2015_categorie_image AS ic
ON ic.id_categorie_image = jvpi.id_categorie_image

WHERE jvpi.id_jeu_version_plateforme_image = "'.mysql_real_escape_string($id_image).'"

ORDER BY ic.categorie_image_nom
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqUpdateJeuVersionPlateformeImageIdImage($id_jeu_version_plateforme_image, $image_titre, $id_categorie_image){


$connexion = connexion();
$request = 'UPDATE 2015_jeu_version_plateforme_image
			SET image_titre="'.mysql_real_escape_string(trim($image_titre)).'" , 
			id_categorie_image="'.mysql_real_escape_string(trim($id_categorie_image)).'"
			
			WHERE id_jeu_version_plateforme_image = "'.mysql_real_escape_string(trim($id_jeu_version_plateforme_image)).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);

}

//--------------------------//



?>