<?php
require_once('mysql_bdd_connect.php'); 
require_once('authentification.php');

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlInsertJeuVersionPlateforme($id_jeu, $id_plateforme){
$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_jeu_version_plateforme
			VALUES ('','".$id_jeu."','".$id_plateforme."',NOW(),NOW(),'".mysql_real_escape_string(trim($id_membre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlUpdateJeuDate($id_jeu){
$connexion = connexion();
$request = 'UPDATE 2015_jeu 
			SET 
			jeu_date_modif = NOW()
			WHERE id_jeu = '.mysql_real_escape_string($id_jeu).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlDeleteJeuVersionPlateforme($id_jeu_version_plateforme){
	$connexion = connexion();
	$request = 'DELETE
				FROM 2015_jeu_version_plateforme
				WHERE id_jeu_version_plateforme = '.mysql_real_escape_string($id_jeu_version_plateforme).'
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
	//mysqlDeleteJeuVersionsRegionsOrphelines();
}

function mysqlInsertJeuVersionRegion($id_jeu_version_plateforme, $jeu_nom_region, $jeu_region, $jeu_date_sortie, $id_editeur, $jeu_cover_file_url, $jeu_jaquette_file_url){


$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_jeu_version_region 
			VALUES ('','".$id_jeu_version_plateforme."','".mysql_real_escape_string($jeu_nom_region)."','".mysql_real_escape_string($jeu_region)."','".mysql_real_escape_string($jeu_date_sortie)."','".$id_editeur."','".trim($jeu_cover_file_url)."','".trim($jeu_jaquette_file_url)."',NOW(),NOW(),'".mysql_real_escape_string(trim($id_membre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlCountJeuVersionRegionByJeuVersionPlateformeIDAndRegion($id_jeu_version_plateforme, $region){
$connexion = connexion();

$request = 'SELECT count(*) AS count
			FROM  2015_jeu_version_region AS jvr
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme
			
			
			
			WHERE jvr.id_jeu_version_plateforme = '.mysql_real_escape_string($id_jeu_version_plateforme).'
			AND jvr.jeu_region = "'.$region.'"
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlDeleteJeuVersionRegionByJeuVersionPlateformeIDAndRegion($id_jeu_version_plateforme, $region){
$connexion = connexion();

$request = 'DELETE
			FROM  2015_jeu_version_region
			WHERE id_jeu_version_plateforme = '.mysql_real_escape_string($id_jeu_version_plateforme).'
			AND jeu_region = "'.$region.'"
			';
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlDeleteJeuVersionRegionOrpheline(){
	$connexion = connexion();
	$request = 'DELETE jvr
				FROM 2015_jeu_version_region AS jvr LEFT JOIN 2015_jeu_version_plateforme AS jvp ON jvr.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme
				WHERE ISNULL(jvp.id_jeu_version_plateforme)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}


function mysqlInsertPegi($id_jeu_version_region){
$connexion = connexion();

$request = "INSERT INTO 2015_classification_pegi
			VALUES ('','".$id_jeu_version_region."','','','','','','','','','','','','','','','')";
			
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertEsrb($id_jeu_version_region){
$connexion = connexion();

$request = "INSERT INTO 2015_classification_esrb 
			VALUES ('','".$id_jeu_version_region."','','','','','','','','','')";
			
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertCero($id_jeu_version_region){
$connexion = connexion();

$request = "INSERT INTO 2015_classification_cero 
			VALUES ('','".$id_jeu_version_region."','','','','','','','','','','','','','','')";
			
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}


function mysqlDeletePegiOrpheline(){
	$connexion = connexion();
	$request = 'DELETE pegi
				FROM 2015_classification_pegi AS pegi LEFT JOIN 2015_jeu_version_region AS jvr ON jvr.id_jeu_version_region = pegi.id_jeu_version_region
				WHERE ISNULL(jvr.id_jeu_version_region)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteCeroOrpheline(){
	$connexion = connexion();
	$request = 'DELETE cero
				FROM 2015_classification_cero AS cero LEFT JOIN 2015_jeu_version_region AS jvr ON jvr.id_jeu_version_region = cero.id_jeu_version_region
				WHERE ISNULL(jvr.id_jeu_version_region)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteEsrbOrpheline(){
	$connexion = connexion();
	$request = 'DELETE esrb
				FROM 2015_classification_esrb AS esrb LEFT JOIN 2015_jeu_version_region AS jvr ON jvr.id_jeu_version_region = esrb.id_jeu_version_region
				WHERE ISNULL(jvr.id_jeu_version_region)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}


function mysqlSelectJeuVersionRegionByJeuVersionPlateformeID($id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT DISTINCT jvr.jeu_region, jvr.jeu_region_nom, jvr.id_jeu_version_region,
			CASE WHEN jvr.jeu_date_sortie = "0000-00-00" THEN "non renseignée" ELSE DATE_FORMAT(jvr.jeu_date_sortie, "%d/%m/%Y") END AS jeu_date_sortie,
			jvr.jeu_region_cover,
			jvr.jeu_region_jaquette,
			j.jeu_dossier,
			jvp.id_jeu,
			j.id_jeu,
			j.jeu_nom_generique,
			e.id_editeur, coalesce(e.editeur_nom,"non renseigné") AS editeur_nom,
			cero.cero_a ,  cero.cero_b ,  cero.cero_c ,  cero.cero_d ,  cero.cero_z ,  cero.cero_romance ,  cero.cero_sexe ,  cero.cero_violence ,  cero.cero_horreur ,  cero.cero_argent ,  cero.cero_crime ,  cero.cero_alcool ,  cero.cero_drogue , cero.cero_langage,
			esrb.esrb_c ,  esrb.esrb_e ,  esrb.esrb_e10 ,  esrb.esrb_t ,  esrb.esrb_m ,  esrb.esrb_a ,  esrb.esrb_info ,  esrb.esrb_location ,  esrb.esrb_interact, 
			pegi.pegi_3 ,  pegi.pegi_4 ,  pegi.pegi_6 ,  pegi.pegi_7 ,  pegi.pegi_12 ,  pegi.pegi_16 ,  pegi.pegi_18 ,  pegi.pegi_langage ,  pegi.pegi_discrimination ,  pegi.pegi_drogue ,  pegi.pegi_peur ,  pegi.pegi_jeux_hasard ,  pegi.pegi_sexe , pegi.pegi_violence ,  pegi.pegi_internet 
			FROM  2015_jeu_version_region AS jvr
			LEFT OUTER JOIN 2015_editeur AS e
			ON jvr.id_editeur = e.id_editeur
			LEFT OUTER JOIN 2015_classification_cero AS cero
			ON jvr.id_jeu_version_region = cero.id_jeu_version_region
			LEFT OUTER JOIN 2015_classification_esrb AS esrb
			ON jvr.id_jeu_version_region = esrb.id_jeu_version_region
			LEFT OUTER JOIN 2015_classification_pegi AS pegi
			ON jvr.id_jeu_version_region = pegi.id_jeu_version_region
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE jvr.id_jeu_version_plateforme = '.mysql_real_escape_string($id_jeu_version_plateforme).'	
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlSelectJeuVersionPlateformeImage($id_jeu_version_plateforme){

$connexion = connexion();

$request = 'SELECT jvpi.image_nom,
			jvpi.id_jeu_version_plateforme_image,
			j.jeu_dossier AS jeu_dossier
			
			FROM 2015_jeu_version_plateforme_image AS jvpi
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE jvpi.id_jeu_version_plateforme = \''.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteJeuVersionPlateformeImageOrpheline(){
	$connexion = connexion();
	$request = 'DELETE jvpi
				FROM 2015_jeu_version_plateforme_image AS jvpi 
				LEFT JOIN 2015_jeu_version_plateforme AS jvp ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme
				WHERE ISNULL(jvp.id_jeu_version_plateforme)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteJeuVersionPlateformeVideoOrpheline(){
	$connexion = connexion();
	$request = 'DELETE jvpv
				FROM 2015_jeu_version_plateforme_video AS jvpv
				LEFT JOIN 2015_jeu_version_plateforme AS jvp ON jvp.id_jeu_version_plateforme = jvpv.id_jeu_version_plateforme
				WHERE ISNULL(jvp.id_jeu_version_plateforme)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

?>