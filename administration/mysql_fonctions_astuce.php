<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllAstuce(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_astuce';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllAstuceWithJeuVersionPlateformeId($id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_astuce AS a
			WHERE a.id_jeu_version_plateforme = '.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllAstuceWithJeuNom($jeu_nom_generique){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_astuce AS a
			LEFT JOIN 2015_jeu_version_plateforme AS jvp 
			ON jvp.id_jeu_version_plateforme = a.id_jeu_version_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON j.id_jeu = jvp.id_jeu
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE j.jeu_nom_generique LIKE "%'.mysql_real_escape_string($jeu_nom_generique).'%" 
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectCountAllAstuceWithIdJeuVersionPlateforme($id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT count(*) AS count, p.plateforme_nom_generique, j.jeu_nom_generique
			FROM  2015_astuce AS a
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp 
			ON jvp.id_jeu_version_plateforme = a.id_jeu_version_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON j.id_jeu = jvp.id_jeu
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE a.id_jeu_version_plateforme  = '.mysql_real_escape_string($id_jeu_version_plateforme).'';
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlSelectAllAstuceWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT a.id_astuce, j.jeu_nom_generique, p.plateforme_nom_generique,
			DATE_FORMAT(a.astuce_date_creation,"%d %b %Y - %H:%i") AS astuce_date_creation,
			 
			
			CASE WHEN a.astuce_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(a.astuce_date_publication, "%d/%m/%Y - %H:%i") END AS astuce_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo AS membre_createur,
			a.astuce_titre,
			a.astuce
			
			FROM  2015_astuce AS a
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = a.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = a.id_membre_modificateur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON a.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			ORDER BY '.mysql_real_escape_string(trim($order)).' DESC ';


$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllAstuceWithPageNumberAndJeuVersionPlateformeId($page, $order, $nb_element_par_page,$id_jeu_version_plateforme){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT a.id_astuce, j.jeu_nom_generique, p.plateforme_nom_generique,
			DATE_FORMAT(a.astuce_date_creation,"%d %b %Y - %H:%i") AS astuce_date_creation,
			 
			
			CASE WHEN a.astuce_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(a.astuce_date_publication, "%d/%m/%Y - %H:%i") END AS astuce_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo AS membre_createur,
			a.astuce_titre,
			a.astuce
			
			FROM  2015_astuce AS a
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = a.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = a.id_membre_modificateur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON a.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE a.id_jeu_version_plateforme = '.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'
			ORDER BY '.mysql_real_escape_string(trim($order)).' DESC ';


$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllAstuceWithPageNumberAndJeuNom($page, $order, $nb_element_par_page,$jeu_nom_generique){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT a.id_astuce, j.jeu_nom_generique, p.plateforme_nom_generique,
			DATE_FORMAT(a.astuce_date_creation,"%d %b %Y - %H:%i") AS astuce_date_creation,
			 
			
			CASE WHEN a.astuce_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(a.astuce_date_publication, "%d/%m/%Y - %H:%i") END AS astuce_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo AS membre_createur,
			a.astuce_titre,
			a.astuce
			
			FROM  2015_astuce AS a
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = a.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = a.id_membre_modificateur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON a.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE j.jeu_nom_generique LIKE "%'.mysql_real_escape_string($jeu_nom_generique).'%" 
			ORDER BY '.mysql_real_escape_string(trim($order)).' DESC ';


$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllPlateformesByConstructeur(){
$connexion = connexion();
$request = 'SELECT 

			p.plateforme_nom_generique,c.id_constructeur,p.id_plateforme,
			
			CASE WHEN c.constructeur_nom = "" THEN "non renseigné"
			WHEN c.constructeur_nom IS NULL THEN "non renseigné"
			ELSE c.constructeur_nom END AS constructeur_nom
			
			
			FROM  2015_plateforme AS p
			
			
			
			LEFT JOIN 2015_constructeur AS c
			ON p.id_constructeur = c.id_constructeur
			
			ORDER BY c.constructeur_nom';	
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


function mysqlSelectJeuVersionPlateformeID($id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT DISTINCT 
			j.jeu_dossier,
			jvp.id_jeu,
			j.id_jeu,
			j.jeu_nom_generique,
			p.plateforme_nom_generique
			
			FROM  2015_jeu_version_plateforme AS jvp
			
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE jvp.id_jeu_version_plateforme = '.mysql_real_escape_string($id_jeu_version_plateforme).'	
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}
function mysqlSelectCountAllAstuceWithJeuNom($jeu_nom_generique){
$connexion = connexion();

$request = 'SELECT count(*) AS count
		
			
			FROM  2015_astuce AS a
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = a.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE j.jeu_nom_generique LIKE "%'.mysql_real_escape_string($jeu_nom_generique).'%" 
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlInsertAstuce($id_jeu_version_plateforme,$titre,$astuce,$date_publication){
$id_membre = mysql_real_escape_string(trim(getID()));

$connexion = connexion();
$request = "INSERT INTO 2015_astuce
			VALUES ('','".mysql_real_escape_string(trim($id_jeu_version_plateforme))."','".mysql_real_escape_string(trim($titre))."','".mysql_real_escape_string(trim($astuce))."','".mysql_real_escape_string(trim($id_membre))."','".mysql_real_escape_string(trim($id_membre))."',NOW(),NOW(),'".mysql_real_escape_string(trim($date_publication))."')";
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteAstuce($id_astuce){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_astuce
				WHERE id_astuce = "'.mysql_real_escape_string($id_astuce).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlSelectAstuceByID($id_astuce){
$connexion = connexion();

$request = 'SELECT a.id_astuce, j.jeu_nom_generique, a.id_jeu_version_plateforme,p.plateforme_nom_generique,
			DATE_FORMAT(a.astuce_date_creation,"%d %b %Y - %H:%i") AS astuce_date_creation, 
			DATE_FORMAT(a.astuce_date_publication,"%d %b %Y - %h:%i") AS astuce_date_publication, 
			a.astuce_date_publication AS astuce_date_publication_non_formate,
			m.pseudo,
			a.astuce_titre,
			a.astuce
		
			
			FROM  2015_astuce AS a
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = a.id_membre_createur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = a.id_jeu_version_plateforme
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON j.id_jeu = jvp.id_jeu
		
			
			
		
			WHERE a.id_astuce = '.mysql_real_escape_string($id_astuce).'
			
			
			'
			
			;
			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}



function mysqlUpdateAstuce($id_astuce,$titre,$astuce,$publish_date){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_astuce
			SET 
			
			astuce_titre = "'.mysql_real_escape_string($titre).'",
			astuce = "'.mysql_real_escape_string($astuce).'",
			id_membre_modificateur = "'.mysql_real_escape_string($id_membre).'",
			astuce_date_publication ="'.mysql_real_escape_string($publish_date).'"
			
			WHERE id_astuce = "'.mysql_real_escape_string($id_astuce).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdateAstucePublishDate($id_astuce){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_astuce
			SET 

			id_membre_modificateur = "'.mysql_real_escape_string($id_membre).'",
			astuce_date_publication=NOW(),
			astuce_date_modif=NOW() 
			
			WHERE id_astuce = "'.mysql_real_escape_string($id_astuce).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}
?>