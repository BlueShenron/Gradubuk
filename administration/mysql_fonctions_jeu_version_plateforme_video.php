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
$request = 'SELECT DISTINCT j.id_jeu, j.jeu_nom_generique,
jvpv.video_url, jvpv.id_jeu_version_plateforme_video,

p.id_plateforme, p.plateforme_nom_generique


FROM  2015_jeu_version_plateforme AS jvp
LEFT OUTER JOIN 2015_jeu AS j
ON j.id_jeu = jvp.id_jeu


LEFT OUTER JOIN 2015_jeu_version_plateforme_video AS jvpv
ON jvpv.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_categorie_video AS ci
ON jvpv.id_categorie_video = ci.id_categorie_video


LEFT OUTER JOIN  2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme


WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllVideoCategories(){
$connexion = connexion();

$request = 'SELECT ic.id_categorie_video, coalesce(ic.categorie_video_nom,"non renseigné") AS categorie_video_nom
			FROM  2015_categorie_video AS ic 
			ORDER BY categorie_video_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllVideosByJeuVersionPlateformeId($id_jeu_version_plateforme){
$connexion = connexion();
$request = 'SELECT DISTINCT jvpv.video_url, 
jvpv.video_titre, jvpv.id_jeu_version_plateforme_video, 
coalesce(ic.categorie_video_nom,"non renseigné") AS categorie_video_nom, jvp.id_jeu_version_plateforme


FROM 2015_jeu_version_plateforme_video AS jvpv

LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu_version_plateforme = jvpv.id_jeu_version_plateforme

LEFT OUTER JOIN  2015_jeu AS j
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN  2015_categorie_video AS ic
ON ic.id_categorie_video = jvpv.id_categorie_video

WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'"

ORDER BY ic.categorie_video_nom
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectVideoCategoriesById($id_categorie_video){
$connexion = connexion();

$request = 'SELECT ic.id_categorie_video, coalesce(ic.categorie_video_nom,"non renseigné") AS categorie_video_nom
			FROM  2015_categorie_video AS ic
			WHERE id_categorie_video = '.$id_categorie_video.'';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertVideoJeuVersionPlateforme($id_jeu_version_plateforme,$video_name, $id_categorie_video, $video_titre){
$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_jeu_version_plateforme_video
			VALUES ('','".mysql_real_escape_string($id_jeu_version_plateforme)."','".mysql_real_escape_string($video_name)."','".mysql_real_escape_string($id_categorie_video)."','".mysql_real_escape_string(trim($video_titre))."',NOW(),'".mysql_real_escape_string(trim($id_membre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlSelectJeuVersionPlateformeVideo($id){

$connexion = connexion();

$request = 'SELECT jvpv.video_url,
			jvpv.id_jeu_version_plateforme_video,
			j.jeu_dossier
			
			FROM 2015_jeu_version_plateforme_video AS jvpv
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = jvpv.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE jvpv.id_jeu_version_plateforme_video = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteJeuVersionPlateformeVideoByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_jeu_version_plateforme_video
			WHERE id_jeu_version_plateforme_video = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectVersionsCompletesByjeuVersionPlateformeIdVideo($id_video){

$connexion = connexion();
$request = 'SELECT jvpv.video_url, j.jeu_dossier, j.id_jeu, j.jeu_nom_generique,p.plateforme_nom_generique,
jvpv.video_titre, jvpv.id_jeu_version_plateforme_video, coalesce(ic.categorie_video_nom,"non renseigné") AS categorie_video_nom, 
ic.id_categorie_video,
jvp.id_jeu_version_plateforme


FROM 2015_jeu_version_plateforme_video AS jvpv

LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu_version_plateforme = jvpv.id_jeu_version_plateforme

LEFT OUTER JOIN  2015_jeu AS j
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN  2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme

LEFT OUTER JOIN  2015_categorie_video AS ic
ON ic.id_categorie_video = jvpv.id_categorie_video

WHERE jvpv.id_jeu_version_plateforme_video = "'.mysql_real_escape_string($id_video).'"

ORDER BY ic.categorie_video_nom
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqUpdateJeuVersionPlateformeVideoIdVideo($id_jeu_version_plateforme_video, $video_titre, $id_categorie_video){


$connexion = connexion();
$request = 'UPDATE 2015_jeu_version_plateforme_video
			SET video_titre="'.mysql_real_escape_string(trim($video_titre)).'" , 
			id_categorie_video="'.mysql_real_escape_string(trim($id_categorie_video)).'"
			
			WHERE id_jeu_version_plateforme_video = "'.mysql_real_escape_string(trim($id_jeu_version_plateforme_video)).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);

}

//--------------------------//



?>