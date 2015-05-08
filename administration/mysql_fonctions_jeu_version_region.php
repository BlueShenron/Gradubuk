<?php
require_once('mysql_bdd_connect.php'); 
require_once('authentification.php');

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectJeuVersionRegionByJeuVersionPlateformeID($id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT DISTINCT jvr.jeu_region, jvr.jeu_region_nom, jvr.id_jeu_version_region,
			CASE WHEN jvr.jeu_date_sortie = "0000-00-00" THEN "non renseignée" ELSE DATE_FORMAT(jvr.jeu_date_sortie, "%d/%m/%Y") END AS jeu_date_sortie,
			jvr.jeu_cover_file_url,
			j.jeu_dossier,
			jvp.id_jeu,
			j.id_jeu,
			j.jeu_nom_generique,
			p.plateforme_nom_generique,
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
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE jvr.id_jeu_version_plateforme = '.mysql_real_escape_string($id_jeu_version_plateforme).'	
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlSelectAllEditeurs(){
$connexion = connexion();
$request = 'SELECT * 
			FROM  2015_editeur
			ORDER BY editeur_nom';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuRegion($id_jeu_version_region){
$connexion = connexion();

$request = 'SELECT DISTINCT jvr.jeu_region, 
			jvr.jeu_region_nom,e.editeur_nom,
			j.jeu_dossier,j.jeu_nom_generique,
			
			jvr.id_jeu_version_region,
			
			jvr.jeu_date_sortie,
			CASE WHEN jvr.jeu_region_cover = "" THEN "nopicture" WHEN  jvr.jeu_region_cover IS NULL THEN "nopicture" ELSE jvr.jeu_region_cover END AS jeu_region_cover,
			CASE WHEN jvr.jeu_region_jaquette = "" THEN "nopicture" WHEN  jvr.jeu_region_jaquette IS NULL THEN "nopicture" ELSE jvr.jeu_region_jaquette END AS jeu_region_jaquette,

			cero.cero_a ,  cero.cero_b ,  cero.cero_c ,  cero.cero_d ,  cero.cero_z ,  cero.cero_romance ,  cero.cero_sexe ,  cero.cero_violence ,  cero.cero_horreur ,  cero.cero_argent ,  cero.cero_crime ,  cero.cero_alcool ,  cero.cero_drogue , cero.cero_langage,
			esrb.esrb_c ,  esrb.esrb_e ,  esrb.esrb_e10 ,  esrb.esrb_t ,  esrb.esrb_m ,  esrb.esrb_a ,  esrb.esrb_info ,  esrb.esrb_location ,  esrb.esrb_interact, 
			pegi.pegi_3 ,  pegi.pegi_4 ,  pegi.pegi_6 ,  pegi.pegi_7 ,  pegi.pegi_12 ,  pegi.pegi_16 ,  pegi.pegi_18 ,  pegi.pegi_langage ,  pegi.pegi_discrimination ,  pegi.pegi_drogue ,  pegi.pegi_peur ,  pegi.pegi_jeux_hasard ,  pegi.pegi_sexe , pegi.pegi_violence ,  pegi.pegi_internet,
			jvp.id_plateforme,jvp.id_jeu_version_plateforme, jvp.id_jeu , p.id_plateforme, p.plateforme_nom_generique, j.id_jeu, j.jeu_nom_generique
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
			LEFT OUTER JOIN 2015_plateforme AS p
			ON jvp.id_plateforme = p.id_plateforme
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			WHERE jvr.id_jeu_version_region = '.mysql_real_escape_string($id_jeu_version_region).'	
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlDeleteJeuVersionRegionByID($id_jeu_version_region){
$connexion = connexion();

$request = 'DELETE
			FROM  2015_jeu_version_region
			WHERE id_jeu_version_region = '.mysql_real_escape_string($id_jeu_version_region).'
			';
$result = mysql_query($request) or die(mysql_error());

return $result;
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

function mysqlUpdateJeuVersionRegion($id_jeu_version_region, $jeu_nom_region, $jeu_region, $jeu_date_sortie, $jeu_region_cover, $jeu_region_jaquette, $id_editeur){

$connexion = connexion();
$request = 'UPDATE 2015_jeu_version_region
			SET 
			
			jeu_region_nom="'.mysql_real_escape_string($jeu_nom_region).'" , 
			jeu_region="'.mysql_real_escape_string($jeu_region).'" , 
			jeu_date_sortie="'.mysql_real_escape_string($jeu_date_sortie).'" , 
			id_editeur="'.mysql_real_escape_string($id_editeur).'",

			jeu_region_cover="'.mysql_real_escape_string($jeu_region_cover).'" ,  
			jeu_region_jaquette="'.mysql_real_escape_string($jeu_region_jaquette).'" , 
			
			jeu_version_plateforme_date_modification=NOW()
			WHERE id_jeu_version_region = "'.mysql_real_escape_string($id_jeu_version_region).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlSelectEditeurIDByName($name){
$connexion = connexion();

$request = 'SELECT id_editeur
			FROM 2015_editeur 
			WHERE editeur_nom = \''.mysql_real_escape_string($name).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertEditeur($editeur_name){
$connexion = connexion();

$request = "INSERT INTO 2015_editeur
			VALUES ('','".mysql_real_escape_string($editeur_name)."',NOW(),NOW(),'')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}


function updatePegi($id_jeu_version_region, $nom_champ, $data){
$connexion = connexion();
	//echo $nom_champ.'  '.$data;
	$request = 'UPDATE 2015_classification_pegi 
				SET 
				'.$nom_champ.'='. $data.'
				WHERE id_jeu_version_region = '.$id_jeu_version_region.'';
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}
function updateEsrb($id_jeu_version_region, $nom_champ, $data){
$connexion = connexion();
	//echo $nom_champ.'  '.$data;
	$request = 'UPDATE 2015_classification_esrb 
				SET 
				'.$nom_champ.'='. $data.'
				WHERE id_jeu_version_region = '.$id_jeu_version_region.'';
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}
function updateCero($id_jeu_version_region, $nom_champ, $data){
$connexion = connexion();
	//echo $nom_champ.'  '.$data;
	$request = 'UPDATE 2015_classification_cero 
				SET 
				'.$nom_champ.'='. $data.'
				WHERE id_jeu_version_region = '.$id_jeu_version_region.'';
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}
function resetPegi($id_jeu_version_region){
	$connexion = connexion();

	$request = 'UPDATE 2015_classification_pegi 
				SET 
			
				pegi_3="0" , 
				pegi_4="0" , 
				pegi_6="0" , 
				pegi_7="0" , 
				pegi_12="0" ,
				pegi_16="0" , 
				pegi_18="0" , 
				pegi_langage="0" ,
				pegi_discrimination="0" ,
				pegi_drogue="0" ,
				pegi_peur="0" ,
				pegi_jeux_hasard="0" ,
				pegi_sexe="0" ,
				pegi_violence="0" ,
				pegi_internet="0"
				WHERE id_jeu_version_region = "'.$id_jeu_version_region.'"';
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}
function resetEsrb($id_jeu_version_region){
	$connexion = connexion();

	$request = 'UPDATE 2015_classification_esrb 
				SET 
				esrb_c="0" , 
				esrb_e="0" , 
				esrb_e10="0" , 
				esrb_t="0" , 
				esrb_m="0" ,
				esrb_a="0" , 
				esrb_info="0" , 
				esrb_location="0" ,
				esrb_interact="0" 
				WHERE id_jeu_version_region = "'.$id_jeu_version_region.'"';
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}

function resetCero($id_jeu_version_region){
	$connexion = connexion();

	$request = 'UPDATE 2015_classification_cero 
				SET 
				cero_a="0" , 
				cero_b="0" , 
				cero_c="0" , 
				cero_d="0" , 
				cero_z="0" ,
				cero_romance="0" , 
				cero_sexe="0" , 
				cero_violence="0" ,
				cero_horreur="0" ,
				cero_argent="0" ,
				cero_crime="0" ,
				cero_alcool="0" ,
				cero_drogue="0" ,
				cero_langage="0" 
				WHERE id_jeu_version_region = "'.$id_jeu_version_region.'"';
	
	$result = mysql_query($request) or die(mysql_error());
	mysql_close($connexion);
}

function mysqlUpdateJeuDate($id_jeu){
$connexion = connexion();
$request = 'UPDATE 2015_jeu
			SET 
			jeu_date_modif= NOW()
			WHERE id_jeu = '.mysql_real_escape_string($id_jeu).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlInsertEditeurImage($id_dev,$image_name){
$id_membre = mysql_real_escape_string(trim(getID()));

$connexion = connexion();
$request = "INSERT INTO 2015_editeur_image
			VALUES ('','".mysql_real_escape_string(trim($id_dev))."','".mysql_real_escape_string(trim($image_name))."',NOW(),'".mysql_real_escape_string(trim($id_membre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}
?>