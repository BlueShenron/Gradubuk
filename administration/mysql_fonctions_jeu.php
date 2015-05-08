<?php
require_once('mysql_bdd_connect.php'); 
require_once('authentification.php');

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllGenres(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_genre 
			ORDER BY genre_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllDeveloppeurs(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_developpeur
			ORDER BY developpeur_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllNbJoueurs(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_nombre_joueur
			ORDER BY nombre_joueur_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectDeveloppeurIDByName($name){
$connexion = connexion();
$request = 'SELECT id_developpeur
			FROM 2015_developpeur
			WHERE developpeur_nom = \''.mysql_real_escape_string($name).'\'
			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertDeveloppeur($developpeur_name){
$connexion = connexion();
$request = "INSERT INTO 2015_developpeur 
			VALUES ('','".mysql_real_escape_string($developpeur_name)."',NOW(),NOW(),'')";		
$result = mysql_query($request) or die(mysql_error());
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertJeu($id_developpeur, $id_genre, $jeu_name, $jeu_descriptif, $id_nb_joueur_offline,$id_nb_joueur_online, $jeu_dossier){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();
$request = "INSERT INTO 2015_jeu 
			VALUES ('','". mysql_real_escape_string($id_developpeur)."','".mysql_real_escape_string($id_genre)."','".mysql_real_escape_string(trim($jeu_name))."','".mysql_real_escape_string($id_nb_joueur_offline)."','".mysql_real_escape_string($id_nb_joueur_online)."','".mysql_real_escape_string(trim($jeu_descriptif))."','".mysql_real_escape_string(trim($jeu_dossier))."',NOW(),NOW(),'".mysql_real_escape_string(trim($id_membre))."')";
$result = mysql_query($request) or die(mysql_error());
return mysql_insert_id();
mysql_close($connexion);
}


function mysqlSelectAllJeuxWithPageNumber($page, $order,$nb_element_par_page){
$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT j.jeu_nom_generique, j.id_jeu, j.jeu_date_creation,

coalesce(d.developpeur_nom,"non renseigné") AS developpeur_nom,
CASE WHEN d.developpeur_nom IS NULL THEN "resultat_nok" ELSE "resultat" END AS class_developpeur_resultat,
d.id_developpeur , 

coalesce(g.genre_nom,"non renseigné") AS genre_nom,
CASE WHEN g.genre_nom IS NULL THEN "resultat_nok" ELSE "resultat" END AS class_genre_resultat,
g.id_genre , 

coalesce(j.jeu_dossier,"aucun dossier pour ce jeu") AS jeu_dossier,
CASE WHEN j.jeu_dossier IS NULL THEN "important_rouge" ELSE "resultat" END AS class_jeu_dossier_resultat,


coalesce(nbj_offline.nombre_joueur_nom, "non renseigné") AS nbj_offline,
CASE WHEN nbj_offline.nombre_joueur_nom IS NULL THEN "resultat_nok" ELSE "resultat" END AS class_nbj_offline_resultat, 
nbj_offline.id_nombre_joueur, 

coalesce(nbj_online.nombre_joueur_nom,"pas de mode online") AS nbj_online, 
nbj_online.id_nombre_joueur, 
CASE WHEN j.jeu_descriptif = "" THEN "pas de descriptif" ELSE j.jeu_descriptif END AS jeu_descriptif,
CASE WHEN j.jeu_descriptif IS NULL THEN "resultat_nok" 
WHEN j.jeu_descriptif = "" THEN "resultat_nok" 
ELSE "resultat" END AS class_jeu_descriptif_resultat 


FROM 2015_jeu AS j 
LEFT OUTER JOIN 2015_developpeur AS d
ON j.id_developpeur = d.id_developpeur
LEFT OUTER JOIN 2015_genre AS g
ON j.id_genre = g.id_genre
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_offline
ON j.id_nombre_joueur_offline = nbj_offline.id_nombre_joueur
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_online
ON j.id_nombre_joueur_online = nbj_online.id_nombre_joueur
ORDER BY '.$order.' ';
if($order == 'jeu_nom_generique'){
$request .= ' ';
}
else{
$request .= 'DESC ';
}

$request .= 'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';	
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectAllJeuxWithNameAndWithPageNumber($page, $name,$nb_element_par_page,$order){
$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT j.jeu_nom_generique, j.id_jeu, j.jeu_date_creation,

coalesce(d.developpeur_nom,"non renseigné") AS developpeur_nom,
CASE WHEN d.developpeur_nom IS NULL THEN "resultat_nok" ELSE "resultat" END AS class_developpeur_resultat,
d.id_developpeur , 

coalesce(g.genre_nom,"non renseigné") AS genre_nom,
CASE WHEN g.genre_nom IS NULL THEN "resultat_nok" ELSE "resultat" END AS class_genre_resultat,
g.id_genre , 

coalesce(j.jeu_dossier,"aucun dossier pour ce jeu") AS jeu_dossier,
CASE WHEN j.jeu_dossier IS NULL THEN "important_rouge" ELSE "resultat" END AS class_jeu_dossier_resultat,


coalesce(nbj_offline.nombre_joueur_nom, "non renseigné") AS nbj_offline,
CASE WHEN nbj_offline.nombre_joueur_nom IS NULL THEN "resultat_nok" ELSE "resultat" END AS class_nbj_offline_resultat, 
nbj_offline.id_nombre_joueur, 

coalesce(nbj_online.nombre_joueur_nom,"pas de mode online") AS nbj_online, 
nbj_online.id_nombre_joueur, 
CASE WHEN j.jeu_descriptif = "" THEN "pas de descriptif" ELSE j.jeu_descriptif END AS jeu_descriptif,
CASE WHEN j.jeu_descriptif IS NULL THEN "resultat_nok" 
WHEN j.jeu_descriptif = "" THEN "resultat_nok" 
ELSE "resultat" END AS class_jeu_descriptif_resultat 


FROM 2015_jeu AS j 
LEFT OUTER JOIN 2015_developpeur AS d
ON j.id_developpeur = d.id_developpeur
LEFT OUTER JOIN 2015_genre AS g
ON j.id_genre = g.id_genre
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_offline
ON j.id_nombre_joueur_offline = nbj_offline.id_nombre_joueur
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_online
ON j.id_nombre_joueur_online = nbj_online.id_nombre_joueur
WHERE j.jeu_nom_generique LIKE "%'.mysql_real_escape_string($name).'%" 
ORDER BY '.$order.' ';
if($order == 'jeu_nom_generique'){
$request .= ' ';
}
else{
$request .= 'DESC ';
}

$request .= 'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllJeuxWithPlateformeAndWithPageNumber($page, $id_plateforme,$nb_element_par_page,$order){
$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT jvp.id_jeu_version_plateforme, j.jeu_nom_generique, j.id_jeu, j.jeu_date_creation,

coalesce(d.developpeur_nom,"non renseigné") AS developpeur_nom,
d.id_developpeur



FROM 2015_jeu_version_plateforme AS jvp 
LEFT OUTER JOIN 2015_jeu AS j
ON j.id_jeu = jvp.id_jeu
LEFT OUTER JOIN 2015_developpeur AS d
ON j.id_developpeur = d.id_developpeur
LEFT OUTER JOIN 2015_genre AS g
ON j.id_genre = g.id_genre
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_offline
ON j.id_nombre_joueur_offline = nbj_offline.id_nombre_joueur
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_online
ON j.id_nombre_joueur_online = nbj_online.id_nombre_joueur
WHERE jvp.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
ORDER BY '.$order.' ';
if($order == 'jeu_nom_generique'){
$request .= ' ';
}
else{
$request .= 'DESC ';
}

$request .= 'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllJeux(){
$connexion = connexion();
$request = 'SELECT j.id_jeu
FROM 2015_jeu AS j 
';			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllJeuxWithName($name){
$connexion = connexion();
$request = 'SELECT j.id_jeu,j.jeu_nom_generique
FROM 2015_jeu AS j 
WHERE j.jeu_nom_generique = "'.$name.'"
';			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteJeu($id_jeu){
	$connexion = connexion();
	$request = 'DELETE
				FROM 2015_jeu
				WHERE id_jeu = '.mysql_real_escape_string($id_jeu).'
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
	//mysqlDeleteJeuVersionsPlateformesOrphelines();
}

function mysqlSelectJeuByID($id){
$connexion = connexion();
$request = 'SELECT j.jeu_nom_generique, j.id_jeu,
d.developpeur_nom AS developpeur_nom, d.id_developpeur ,
coalesce(g.genre_nom,"non renseigné") AS genre_nom, g.id_genre ,
coalesce(nbj_offline.nombre_joueur_nom, "non renseigné") AS nbj_offline, nbj_offline.id_nombre_joueur AS id_nbj_offline,
coalesce(nbj_online.nombre_joueur_nom,"pas de mode online") AS nbj_online, nbj_online.id_nombre_joueur AS id_nbj_online,
j.jeu_descriptif AS jeu_descriptif,
j.jeu_dossier
FROM 2015_jeu AS j 
LEFT OUTER JOIN 2015_developpeur AS d
ON j.id_developpeur = d.id_developpeur
LEFT OUTER JOIN 2015_genre AS g
ON j.id_genre = g.id_genre
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_offline
ON j.id_nombre_joueur_offline = nbj_offline.id_nombre_joueur
LEFT OUTER JOIN 2015_nombre_joueur AS nbj_online
ON j.id_nombre_joueur_online = nbj_online.id_nombre_joueur
WHERE j.id_jeu ='.mysql_real_escape_string($id).'
';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlUpdateJeu($id_jeu, $id_developpeur,$id_genre,$jeu_nom_generique,$jeu_descriptif,$id_nb_joueurs_offline,$id_nb_joueurs_online){
$connexion = connexion();
$request = 'UPDATE 2015_jeu 
			SET 
			id_developpeur="'.mysql_real_escape_string($id_developpeur).'" , 
			id_genre="'.mysql_real_escape_string($id_genre).'" , 
			id_nombre_joueur_offline="'.mysql_real_escape_string($id_nb_joueurs_offline).'" , 
			id_nombre_joueur_online="'.mysql_real_escape_string($id_nb_joueurs_online).'" , 
			jeu_nom_generique="'.mysql_real_escape_string($jeu_nom_generique).'" , 
			jeu_descriptif="'.mysql_real_escape_string(trim($jeu_descriptif)).'" ,
			jeu_date_modif= NOW()
			WHERE id_jeu = '.mysql_real_escape_string($id_jeu).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlSelectVersionsCompletesByJeuID($id_jeu){
$connexion = connexion();
$request = 'SELECT DISTINCT j.id_jeu,
jvp.id_jeu, jvp.id_jeu_version_plateforme,
jvr.jeu_region,jvr.id_jeu_version_region, jvr.jeu_region_nom, jvr.jeu_cover_file_url,
p.plateforme_nom_generique, p.id_plateforme,
coalesce(e.editeur_nom,"non renseigné") AS editeur_nom,
cero.cero_a ,  cero.cero_b ,  cero.cero_c ,  cero.cero_d ,  cero.cero_z ,  cero.cero_romance ,  cero.cero_sexe ,  cero.cero_violence ,  cero.cero_horreur ,  cero.cero_argent ,  cero.cero_crime ,  cero.cero_alcool ,  cero.cero_drogue , cero.cero_langage,
esrb.esrb_c ,  esrb.esrb_e ,  esrb.esrb_e10 ,  esrb.esrb_t ,  esrb.esrb_m ,  esrb.esrb_a ,  esrb.esrb_info ,  esrb.esrb_location ,  esrb.esrb_interact, 
pegi.pegi_3 ,  pegi.pegi_4 ,  pegi.pegi_6 ,  pegi.pegi_7 ,  pegi.pegi_12 ,  pegi.pegi_16 ,  pegi.pegi_18 ,  pegi.pegi_langage ,  pegi.pegi_discrimination ,  pegi.pegi_drogue ,  pegi.pegi_peur ,  pegi.pegi_jeux_hasard ,  pegi.pegi_sexe , pegi.pegi_violence ,  pegi.pegi_internet,
CASE WHEN jvr.jeu_date_sortie = "0000-00-00" THEN "non renseignée" ELSE DATE_FORMAT(jvr.jeu_date_sortie, "%d/%m/%Y") END AS jeu_date_sortie

FROM  2015_jeu AS j
LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON j.id_jeu = jvp.id_jeu
LEFT OUTER JOIN  2015_jeu_version_region AS jvr
ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme
LEFT OUTER JOIN  2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme
LEFT OUTER JOIN 2015_classification_cero AS cero
ON jvr.id_jeu_version_region = cero.id_jeu_version_region
LEFT OUTER JOIN 2015_classification_esrb AS esrb
ON jvr.id_jeu_version_region = esrb.id_jeu_version_region
LEFT OUTER JOIN 2015_classification_pegi AS pegi
ON jvr.id_jeu_version_region = pegi.id_jeu_version_region
LEFT OUTER JOIN 2015_editeur AS e
ON jvr.id_editeur = e.id_editeur
WHERE j.id_jeu = "'.mysql_real_escape_string($id_jeu).'"
AND jvp.id_jeu_version_plateforme IS NOT NULL	
ORDER BY p.plateforme_nom_generique
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuVersionPlateformeByJeuID($id_jeu){
$connexion = connexion();
$request = '
SELECT DISTINCT 
j.id_jeu,
jvp.id_jeu_version_plateforme,
p.id_plateforme, p.plateforme_nom_generique

FROM  2015_jeu AS j
LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON j.id_jeu = jvp.id_jeu

LEFT OUTER JOIN  2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme
WHERE j.id_jeu = "'.mysql_real_escape_string($id_jeu).'"	

ORDER BY p.plateforme_nom_generique
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllPlateformesByConstructeur(){
$connexion = connexion();
$request = 'SELECT p.plateforme_nom_generique, p.id_plateforme, c.id_constructeur, c.constructeur_nom 
			FROM  2015_plateforme AS p
			
			LEFT OUTER JOIN  2015_constructeur AS c
			ON c.id_constructeur = p.id_constructeur
			
			ORDER BY constructeur_nom';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectConstructeursByID($id){
$connexion = connexion();
$request = 'SELECT * 
			FROM 2015_constructeur
			WHERE id_constructeur = \''.mysql_real_escape_string($id).'\'
			';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuVersionByPlateformeIdAndJeuId($id_plateforme, $id_jeu){
$connexion = connexion();
$request = 'SELECT *
			FROM  2015_jeu AS j, 2015_plateforme AS p , 2015_jeu_version_plateforme AS jvp
			WHERE jvp.id_plateforme = \''.mysql_real_escape_string($id_plateforme).'\'
			AND jvp.id_jeu = j.id_jeu
			AND j.id_jeu = \''.mysql_real_escape_string($id_jeu).'\'
			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
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

function mysqlCountJeuVersionPlateformeByJeuID($id_jeu){
	$connexion = connexion();
	$request = 'SELECT COUNT(*) AS count,
				CASE WHEN count(*) = 0 THEN 1 ELSE count(*) END AS rowspan
				FROM 2015_jeu_version_plateforme
				WHERE id_jeu = '.mysql_real_escape_string($id_jeu).'
			';	
	$result = mysql_query($request) or die(mysql_error());
	return $result;
	mysql_close($connexion);
	//mysqlDeleteJeuVersionsRegionsOrphelines();
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

function mysqlSelectJeuIdByJeuVersionPlateformeID($id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT DISTINCT jvp.id_jeu FROM 2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme ='.mysql_real_escape_string($id_jeu_version_plateforme).'


			';
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlCountJeuVersionRegionByJeuVersionPlateformeIDAndRegion($id_jeu_version_plateforme, $region){
$connexion = connexion();

$request = 'SELECT count(*) AS count, jvr.id_jeu_version_region
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

function mysqlCountJeuVersionPlateforme($id_jeu){
$connexion = connexion();

$request = 'SELECT count(*) AS count, p.plateforme_nom_generique,
CASE WHEN count(*) = 0 THEN 1 ELSE count(*) END AS rowspan
			FROM  2015_jeu_version_plateforme AS jvp
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE jvp.id_jeu = '.mysql_real_escape_string($id_jeu).'
	
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlDeleteJeuVersionPlateformeOrpheline(){
	$connexion = connexion();
	$request = 'DELETE jvp
				FROM 2015_jeu_version_plateforme AS jvp LEFT JOIN 2015_jeu AS j ON jvp.id_jeu = j.id_jeu
				WHERE ISNULL(j.id_jeu)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
	//mysqlDeleteJeuVersionsRegionsOrphelines();
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

function mysqlSelectCountAllJeuxWithName($jeu_nom_generique){
$connexion = connexion();

$request = 'SELECT count(*) AS count
			FROM  2015_jeu AS j
			WHERE j.jeu_nom_generique LIKE "%'.mysql_real_escape_string($jeu_nom_generique).'%" ';
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlSelectCountAllJeuxWithID($id_jeu){
$connexion = connexion();

$request = 'SELECT count(*) AS count, j.jeu_nom_generique
			FROM  2015_jeu AS j
			

			
			WHERE j.id_jeu = "'.mysql_real_escape_string($id_jeu).'" ';
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlSelectCountAllJeuxWithPlateforme($id_plateforme){
$connexion = connexion();

$request = 'SELECT count(*) AS count, p.plateforme_nom_generique
			FROM  2015_jeu AS j
			LEFT JOIN 2015_jeu_version_plateforme AS jvp 
			ON jvp.id_jeu = j.id_jeu
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE jvp.id_plateforme  = '.mysql_real_escape_string($id_plateforme).'';
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlInsertDeveloppeurImage($id_dev,$image_name){
$id_membre = mysql_real_escape_string(trim(getID()));

$connexion = connexion();
$request = "INSERT INTO 2015_developpeur_image
			VALUES ('','".mysql_real_escape_string(trim($id_dev))."','".mysql_real_escape_string(trim($image_name))."',NOW(),'".mysql_real_escape_string(trim($id_membre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}


function mysqlSelectPremierJeuVersionPlateforme($id_jeu){

$connexion = connexion();

$request = 'SELECT DISTINCT 
			j.id_jeu,
			jvp.id_jeu_version_plateforme,
			p.id_plateforme, p.plateforme_nom_generique
			
		
			
			FROM  2015_jeu AS j
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON j.id_jeu = jvp.id_jeu

			LEFT OUTER JOIN  2015_plateforme AS p
			ON jvp.id_plateforme = p.id_plateforme
			WHERE j.id_jeu = "'.mysql_real_escape_string($id_jeu).'"	
			ORDER BY p.plateforme_nom_generique
			LIMIT 1';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}
function mysqlIsRegionJeuVersionPlateforme($id_jeu_version_plateforme,$region){

$connexion = connexion();

$request = '
			SELECT 
			CASE count(*) WHEN 0 THEN "region_not_exist" ELSE "region_exist" END AS class,
			count(*) AS count,
			CASE WHEN count(*) = 0 THEN 1 ELSE count(*) END AS rowspan
			from 2015_jeu_version_region AS jvr
			WHERE jvr.jeu_region =  "'.mysql_real_escape_string($region).'"
			AND jvr.id_jeu_version_plateforme =  "'.mysql_real_escape_string($id_jeu_version_plateforme).'"
			
			';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectJeuVersionPlateformeSuivant($limit,$id_jeu){

$connexion = connexion();

$request = 'SELECT DISTINCT 
			j.id_jeu,
			jvp.id_jeu_version_plateforme,
			p.id_plateforme, p.plateforme_nom_generique

			FROM  2015_jeu AS j
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON j.id_jeu = jvp.id_jeu

			LEFT OUTER JOIN  2015_plateforme AS p
			ON jvp.id_plateforme = p.id_plateforme
			WHERE j.id_jeu = "'.mysql_real_escape_string($id_jeu).'"	
			
			ORDER BY  p.plateforme_nom_generique

			LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET 1';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}
?>