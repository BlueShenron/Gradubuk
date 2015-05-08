<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}



function mysqlSelectAllTestWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT t.id_test, j.jeu_nom_generique, p.plateforme_nom_generique,
			DATE_FORMAT(t.test_date_creation,"%d %b %Y - %H:%i") AS test_date_creation,
			 
			
			CASE WHEN t.test_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(t.test_date_publication, "%d/%m/%Y - %H:%i") END AS test_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo
			FROM  2015_test AS t
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = t.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = t.id_membre_modificateur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON t.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			ORDER BY '.mysql_real_escape_string(trim($order)).'';
			if($order == 'jeu_nom_generique'){
				$request .= ' ';
			}
			else{
				$request .= ' DESC ';
			}
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllTestWithPageNumberAndIdJeuVersionPlateforme($page, $order, $nb_element_par_page, $id_jeu_version_plateforme){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT t.id_test, j.jeu_nom_generique, p.plateforme_nom_generique,
			DATE_FORMAT(t.test_date_creation,"%d %b %Y - %H:%i") AS test_date_creation,
			 
			
			CASE WHEN t.test_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(t.test_date_publication, "%d/%m/%Y - %H:%i") END AS test_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo
			FROM  2015_test AS t
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = t.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = t.id_membre_modificateur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON t.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE t.id_test  IN (	SELECT t.id_test 
								FROM 2015_test AS t 
								LEFT JOIN 2015_test_jeu_version_plateforme AS tjvp
								ON tjvp.id_test = t.id_test
								WHERE tjvp.id_jeu_version_plateforme = '.mysql_real_escape_string(trim($id_jeu_version_plateforme)).')
			ORDER BY '.mysql_real_escape_string(trim($order)).'';
			if($order == 'jeu_nom_generique'){
				$request .= ' ';
			}
			else{
				$request .= ' DESC ';
			}
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllTestWithPageNumberAndJeuNom($page, $order, $nb_element_par_page, $jeu_nom_generique){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT t.id_test, j.jeu_nom_generique, p.plateforme_nom_generique,
			DATE_FORMAT(t.test_date_creation,"%d %b %Y - %H:%i") AS test_date_creation,
			 
			
			CASE WHEN t.test_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(t.test_date_publication, "%d/%m/%Y - %H:%i") END AS test_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo
			FROM  2015_test AS t
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = t.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = t.id_membre_modificateur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON t.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme
			
			LEFT JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE t.id_test  IN (	SELECT t.id_test 
								FROM 2015_test AS t 
								
								LEFT JOIN 2015_test_jeu_version_plateforme AS tjvp
								ON tjvp.id_test = t.id_test
								
								LEFT JOIN 2015_jeu_version_plateforme AS jvp
								ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme
								
								LEFT JOIN 2015_jeu AS j
								ON j.id_jeu = jvp.id_jeu
								
								WHERE j.jeu_nom_generique LIKE "%'.mysql_real_escape_string($jeu_nom_generique).'%" )
			ORDER BY '.mysql_real_escape_string(trim($order)).'';
			if($order == 'jeu_nom_generique'){
				$request .= ' ';
			}
			else{
				$request .= ' DESC ';
			}

$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}




function mysqlSelectAllTest(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_test';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllTestIdJeuVersionPlateforme($id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_test AS t
			WHERE t.id_test  IN (	SELECT t.id_test 
								FROM 2015_test AS t 
								LEFT JOIN 2015_test_jeu_version_plateforme AS tjvp
								ON tjvp.id_test = t.id_test
								WHERE tjvp.id_jeu_version_plateforme = '.mysql_real_escape_string(trim($id_jeu_version_plateforme)).')
			
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllTestJeuNom($jeu_nom_generique){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_test AS t
			WHERE t.id_test  IN (	SELECT t.id_test 
								FROM 2015_test AS t 
								
								LEFT JOIN 2015_test_jeu_version_plateforme AS tjvp
								ON tjvp.id_test = t.id_test
								
								LEFT JOIN 2015_jeu_version_plateforme AS jvp
								ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme
								
								LEFT JOIN 2015_jeu AS j
								ON j.id_jeu = jvp.id_jeu
								
								WHERE j.jeu_nom_generique LIKE "%'.mysql_real_escape_string($jeu_nom_generique).'%" )
			
			';
			
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

function mysqlSelectAllConstructeurs(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_constructeur
			ORDER BY constructeur_nom';
			
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
			j.jeu_nom_generique
			
			FROM  2015_jeu_version_plateforme AS jvp
			
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON jvp.id_jeu = j.id_jeu
			
			WHERE jvp.id_jeu_version_plateforme = '.mysql_real_escape_string($id_jeu_version_plateforme).'	
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlSelectAllJeuVersionPlateforme($id_jeu_version_plateforme){
$connexion = connexion();

$requete = 'SELECT DISTINCT j.id_jeu,j.jeu_nom_generique,
					jvp.id_jeu, jvp.id_jeu_version_plateforme,
					p.plateforme_nom_generique, p.id_plateforme

					FROM  2015_jeu AS j
					LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
					ON j.id_jeu = jvp.id_jeu

					LEFT OUTER JOIN  2015_plateforme AS p
					ON jvp.id_plateforme = p.id_plateforme


					WHERE j.id_jeu = (SELECT jvp.id_jeu FROM  2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'")
					AND jvp.id_jeu_version_plateforme IS NOT NULL	
					ORDER BY p.plateforme_nom_generique';
			
$result = mysql_query($requete) or die(mysql_error());

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

function mysqlSelectAllEditeurs(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_editeur
			ORDER BY editeur_nom';
			
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

function mysqlInsertTest($id_jeu_version_plateforme,$date_publication){
$id_membre = mysql_real_escape_string(trim(getID()));

$connexion = connexion();
$request = "INSERT INTO 2015_test
			VALUES ('','".mysql_real_escape_string(trim($id_jeu_version_plateforme))."','".mysql_real_escape_string(trim($id_membre))."','".mysql_real_escape_string(trim($id_membre))."',NOW(),NOW(),'".mysql_real_escape_string(trim($date_publication))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestJeuVersionPlateforme($id_test,$id_jeu_version_plateforme,$test_titre,$test_corps,$test_note,$test_plus,$test_moins){
$id_membre = mysql_real_escape_string(trim(getID()));

$connexion = connexion();
$request = "INSERT INTO 2015_test_jeu_version_plateforme
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($id_jeu_version_plateforme))."','".mysql_real_escape_string(trim($test_titre))."','".mysql_real_escape_string(trim($test_corps))."','".mysql_real_escape_string(trim($test_note))."','".mysql_real_escape_string(trim($test_plus))."','".mysql_real_escape_string(trim($test_moins))."','".mysql_real_escape_string(trim($id_membre))."','".mysql_real_escape_string(trim($id_membre))."',NOW(),NOW())";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlSelectTestByID($id_test){
$connexion = connexion();

$request = 'SELECT t.id_test, j.jeu_nom_generique, t.id_jeu_version_plateforme,
			DATE_FORMAT(t.test_date_creation,"%d %b %Y - %H:%i") AS test_date_creation, 
			DATE_FORMAT(t.test_date_publication,"%d %b %Y - %h:%i") AS test_date_publication, 
			t.test_date_publication AS test_date_publication_non_formate,
			m.pseudo,
			tjvp.test_titre,
			tjvp.test_corps,
			tjvp.test_note,
			tjvp.test_plus,
			tjvp.test_moins
			
			FROM  2015_test AS t
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = t.id_membre_createur
			
			LEFT JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = t.id_jeu_version_plateforme
			
			LEFT JOIN 2015_jeu AS j
			ON j.id_jeu = jvp.id_jeu
		
			LEFT JOIN 2015_test_jeu_version_plateforme AS tjvp
			ON tjvp.id_test = t.id_test
			AND tjvp.id_jeu_version_plateforme = t.id_jeu_version_plateforme
			
		
			WHERE t.id_test = '.mysql_real_escape_string($id_test).'
			
			
			'
			
			;
			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlInsertTestImage($id_test,$url_image){
$connexion = connexion();
$request = "INSERT INTO 2015_test_image
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($url_image))."','')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestVideo($id_test,$url_video){
$connexion = connexion();
$request = "INSERT INTO 2015_test_video
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($url_video))."','')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestIllustration($id_test,$url_image){
$connexion = connexion();
$request = "INSERT INTO 2015_test_illustration
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($url_image))."','')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestSousCategorieTest($id_test,$id_sous_categorie_test){
$connexion = connexion();
$request = "INSERT INTO 2015_test_sous_categorie_test
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($id_sous_categorie_test))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestPlateforme($id_test,$id_plateforme){
$connexion = connexion();
$request = "INSERT INTO 2015_test_plateforme
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($id_plateforme))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestConstructeur($id_test,$id_constructeur){
$connexion = connexion();
$request = "INSERT INTO 2015_test_constructeur
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($id_constructeur))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestDeveloppeur($id_test,$id_developpeur){
$connexion = connexion();
$request = "INSERT INTO 2015_test_developpeur
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($id_developpeur))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestEditeur($id_test,$id_editeur){
$connexion = connexion();
$request = "INSERT INTO 2015_test_editeur
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($id_editeur))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

/*function mysqlInsertTestJeuVersionPlateforme($id_test,$id_jeu_version_plateforme){
$connexion = connexion();
$request = "INSERT INTO 2015_test_jeu_version_plateforme
			VALUES ('','".mysql_real_escape_string(trim($id_test))."','".mysql_real_escape_string(trim($id_jeu_version_plateforme))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}*/
//------------------//
function mysqlSelectTestPlateformes($id_test){
$connexion = connexion();
$request = '
SELECT DISTINCT p.id_plateforme, p.plateforme_nom_generique, p.id_constructeur

FROM 2015_plateforme AS p

LEFT OUTER JOIN 2015_test_plateforme AS np 
ON p.id_plateforme = np.id_plateforme

WHERE np.id_test ="'.mysql_real_escape_string($id_test).'"
ORDER BY p.id_constructeur
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestSousCategorieTest($id_test){

$connexion = connexion();
$request = '
SELECT DISTINCT scn.id_sous_categorie_test, scn.sous_categorie_test_nom, scn.id_categorie_test

FROM 2015_sous_categorie_test AS scn

LEFT OUTER JOIN 2015_test_sous_categorie_test AS nscn
ON scn.id_sous_categorie_test = nscn.id_sous_categorie_test

WHERE nscn.id_test ="'.mysql_real_escape_string($id_test).'"
ORDER BY scn.sous_categorie_test_nom
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestConstructeurs($id_test){

$connexion = connexion();
$request = '
SELECT DISTINCT p.id_constructeur, p.constructeur_nom
FROM 2015_constructeur AS p

LEFT OUTER JOIN 2015_test_constructeur AS np 
ON p.id_constructeur = np.id_constructeur

WHERE np.id_test ="'.mysql_real_escape_string($id_test).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}



function mysqlSelectJeuxIdWithTestId($id_test){
$connexion = connexion();
$request = '
SELECT DISTINCT j.id_jeu

FROM 2015_jeu AS j

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN 2015_test_jeu_version_plateforme AS njvp
ON njvp.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

WHERE njvp.id_test ="'.mysql_real_escape_string($id_test).'"
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectVersionsPlateformesByJeuID($id_jeu){
$connexion = connexion();
$request = 'SELECT DISTINCT j.id_jeu, j.jeu_nom_generique,
jvp.id_jeu, jvp.id_jeu_version_plateforme,

p.plateforme_nom_generique, p.id_plateforme

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

function mysqlCheckJeuVersionPlateforme($id_jeu_version_plateforme, $id_test){
$connexion = connexion();
$request = 'SELECT COUNT(*) AS nbelements

FROM  2015_test_jeu_version_plateforme AS njvp

WHERE njvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'"
AND njvp.id_test = "'.mysql_real_escape_string($id_test).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestSousCategorieTestImage($id_sous_categorie_test){

$connexion = connexion();
$request = '
SELECT 		scn.sous_categorie_test_image_nom AS sous_categorie_test_image,scn.id_sous_categorie_test AS id_sous_categorie_test,
			scn.sous_categorie_test_nom, cn.categorie_test_nom,
		
			
			
			CASE WHEN scn.sous_categorie_test_image_nom = "nopicture.jpg" THEN "nok"
			WHEN scn.sous_categorie_test_image_nom= "" THEN "nok"
			WHEN scn.sous_categorie_test_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image
			
			
			
			
			
			FROM 2015_sous_categorie_test AS scn 
			
			LEFT OUTER JOIN 2015_categorie_test AS cn
			ON scn.id_categorie_test = cn.id_categorie_test
		
			
			WHERE scn.id_sous_categorie_test = "'.mysql_real_escape_string($id_sous_categorie_test).'"
			AND scn.sous_categorie_test_image_nom <> ""
			AND scn.sous_categorie_test_image_nom IS NOT NULL
			AND scn.sous_categorie_test_image_nom <> "nopicture.jpg"
			';


	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestPlateformeImage($id_plateforme){

$connexion = connexion();
$request = '
SELECT 		p.plateforme_image_generique AS plateforme_image,p.id_plateforme,
			p.plateforme_nom_generique,p.plateforme_dossier,
		
			CASE WHEN p.plateforme_image_generique = "nopicture.jpg" THEN "nok"
			WHEN p.plateforme_image_generique = "" THEN "nok"
			WHEN p.plateforme_image_generique IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_plateforme AS p

			
			WHERE p.id_plateforme = "'.mysql_real_escape_string($id_plateforme).'"
			AND p.plateforme_image_generique <> ""
			';
			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectTestConstructeurImage($id_constructeur){

$connexion = connexion();
$request = '
SELECT 		c.constructeur_image_nom AS constructeur_image,c.id_constructeur,
			c.constructeur_nom,
		
			CASE WHEN c.constructeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN c.constructeur_image_nom = "" THEN "nok"
			WHEN c.constructeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_constructeur AS c
			
		
			
			WHERE c.id_constructeur = "'.mysql_real_escape_string($id_constructeur).'"
			AND c.constructeur_image_nom <> ""
			';
			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectTestDeveloppeurImage($id_developpeur){

$connexion = connexion();
$request = '
SELECT 		d.developpeur_image_nom AS developpeur_image,d.id_developpeur AS id_developpeur,
			d.developpeur_nom,
		
			CASE WHEN d.developpeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN d.developpeur_image_nom = "" THEN "nok"
			WHEN d.developpeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_developpeur AS d
			
	
			
			WHERE d.id_developpeur = "'.mysql_real_escape_string($id_developpeur).'"
			AND d.developpeur_image_nom <> ""
			';
			

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectJeuWithTestId($id_test){

$connexion = connexion();
$request = '
SELECT njvp.id_jeu_version_plateforme, jvp.id_jeu
FROM 2015_test_jeu_version_plateforme AS njvp

LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu_version_plateforme = njvp.id_jeu_version_plateforme


WHERE njvp.id_test ="'.mysql_real_escape_string($id_test).'"
GROUP BY jvp.id_jeu
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectAllJeuPicture($id_jeu){

$connexion = connexion();
$request = '
SELECT DISTINCT jvpi.image_nom, j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique,
					jvpi.image_titre, jvpi.id_jeu_version_plateforme_image AS id_image, coalesce(ic.categorie_image_nom,"non renseigné") AS categorie_image_nom, jvp.id_jeu_version_plateforme

					FROM 2015_jeu_version_plateforme_image AS jvpi

					LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
					ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme
					
					LEFT OUTER JOIN  2015_plateforme AS p
					ON jvp.id_plateforme = p.id_plateforme

					LEFT OUTER JOIN  2015_jeu AS j
					ON jvp.id_jeu = j.id_jeu

					LEFT OUTER JOIN  2015_categorie_image AS ic
					ON ic.id_categorie_image = jvpi.id_categorie_image

					WHERE jvp.id_jeu = "'.mysql_real_escape_string($id_jeu).'"

					ORDER BY p.plateforme_nom_generique
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectAllJeuVideo($id_jeu){

$connexion = connexion();
$request = '
SELECT DISTINCT jvpv.video_url, p.plateforme_nom_generique,
					jvpv.video_titre, jvpv.id_jeu_version_plateforme_video, 
					coalesce(ic.categorie_video_nom,"non renseigné") AS categorie_video_nom, jvp.id_jeu_version_plateforme


					FROM 2015_jeu_version_plateforme_video AS jvpv

					LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
					ON jvp.id_jeu_version_plateforme = jvpv.id_jeu_version_plateforme

					LEFT OUTER JOIN  2015_jeu AS j
					ON jvp.id_jeu = j.id_jeu
					
					LEFT OUTER JOIN  2015_plateforme AS p
					ON jvp.id_plateforme = p.id_plateforme


					LEFT OUTER JOIN  2015_categorie_video AS ic
					ON ic.id_categorie_video = jvpv.id_categorie_video

					WHERE jvp.id_jeu = "'.mysql_real_escape_string($id_jeu).'"

					ORDER BY ic.categorie_video_nom
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlCountTestCategorieTestIllustration($id_test,$url_test_illustration){
	$connexion = connexion();
$request = '
SELECT count(*) FROM 2015_test_illustration 
WHERE id_test = "'.mysql_real_escape_string($id_test).'"
AND url_test_illustration = "'.mysql_real_escape_string($url_test_illustration).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlTestIllustration($id_test,$url_test_illustration){
	$connexion = connexion();
$request = '
SELECT count(*) AS count FROM 2015_test_illustration 
WHERE id_test = "'.mysql_real_escape_string($id_test).'"
AND url_test_illustration = "'.mysql_real_escape_string($url_test_illustration).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlTestImage($id_test,$url_test_image){
	$connexion = connexion();
$request = '
SELECT count(*) AS count FROM 2015_test_image 
WHERE id_test = "'.mysql_real_escape_string($id_test).'"
AND url_test_image = "'.mysql_real_escape_string($url_test_image).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlTestVideo($id_test,$url_test_video){
	$connexion = connexion();
$request = '
SELECT count(*) AS count FROM 2015_test_video 
WHERE id_test = "'.mysql_real_escape_string($id_test).'"
AND url_test_video = "'.mysql_real_escape_string($url_test_video).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

//---------------------------------//

function mysqlDeleteTestImage($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_image
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestVideo($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_video
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestIllustration($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_illustration
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestSousCategorieTest($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_sous_categorie_test
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestPlateforme($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_plateforme
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestConstructeur($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_constructeur
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestDeveloppeur($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_developpeur
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestEditeur($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_editeur
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestJeuVersionPlateformeByTest($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestJeuVersionPlateforme($id_test_jeu_version_plateforme){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme
				WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTest($id_test){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test
				WHERE id_test = "'.mysql_real_escape_string($id_test).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}







function mysqlDeleteTestImageOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_test_image AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestVideoOrpheline(){
$connexion = connexion();
		$request = 'DELETE ni
				FROM 2015_test_video AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestIllustrationOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_test_illustration AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestSousCategorieTestOrpheline(){
$connexion = connexion();
	$request = 'DELETE nscn
				FROM 2015_test_sous_categorie_test AS nscn
				LEFT JOIN 2015_test AS n ON n.id_test = nscn.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestPlateformeOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_test_plateforme AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestConstructeurOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_test_constructeur AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestDeveloppeurOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_test_developpeur AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteTestEditeurOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_test_editeur AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteTestJeuVersionPlateformeOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_test_jeu_version_plateforme AS ni
				LEFT JOIN 2015_test AS n ON n.id_test = ni.id_test
				WHERE ISNULL(n.id_test)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlUpdateDatePublicationTest($id_test){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_test
			SET 
			id_membre_modificateur="'.mysql_real_escape_string($id_membre).'",
			test_date_modif= NOW(), 
			test_date_publication=NOW() 
		
			WHERE id_test = "'.mysql_real_escape_string($id_test).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}


//----------------les fonctions pour les images en bas de la page de creation de test----------------//
function mysqlSelectAllImageTest($id_test){
$connexion = connexion();
$request = '
SELECT * 
FROM 2015_test_image 
WHERE id_test = "'.mysql_real_escape_string($id_test).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlIsThisImageIllustrationOfTheTest($id_test,$url){
$connexion = connexion();
$request = '
SELECT 

CASE
WHEN count > 0 then "true"
ELSE "false"
END AS result

FROM(
SELECT count(*) AS count FROM 2015_test_illustration 
WHERE id_test = '.mysql_real_escape_string($id_test).'
AND url_test_illustration = "'.mysql_real_escape_string($url).'") AS countquery


';		

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectIllustationTestThatIsNotImage($id_test){
$connexion = connexion();
$request = '
SELECT ni.url_test_illustration 

FROM 2015_test_illustration AS ni
WHERE ni.url_test_illustration NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
AND ni.id_test = '.mysql_real_escape_string($id_test).'


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestDeveloppeur($id_test){

$connexion = connexion();
$request = '
SELECT DISTINCT d.id_developpeur, d.developpeur_nom
FROM 2015_developpeur AS d

LEFT OUTER JOIN 2015_test_developpeur AS nd
ON d.id_developpeur = nd.id_developpeur

WHERE nd.id_test ="'.mysql_real_escape_string($id_test).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestEditeur($id_test){

$connexion = connexion();
$request = '
SELECT DISTINCT e.id_editeur, e.editeur_nom
FROM 2015_editeur AS e

LEFT OUTER JOIN 2015_test_editeur AS ne
ON e.id_editeur = ne.id_editeur

WHERE ne.id_test ="'.mysql_real_escape_string($id_test).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestConstructeur($id_test){

$connexion = connexion();
$request = '
SELECT DISTINCT c.id_constructeur, c.constructeur_nom
FROM 2015_constructeur AS c

LEFT OUTER JOIN 2015_test_constructeur AS nc
ON c.id_constructeur = nc.id_constructeur

WHERE nc.id_test ="'.mysql_real_escape_string($id_test).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestPlateforme($id_test){

$connexion = connexion();
$request = '
SELECT DISTINCT p.id_plateforme, p.plateforme_nom_generique
FROM 2015_plateforme AS p

LEFT OUTER JOIN 2015_test_plateforme AS np
ON p.id_plateforme = np.id_plateforme

WHERE np.id_test ="'.mysql_real_escape_string($id_test).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestCategorie($id_test){

$connexion = connexion();
$request = '
SELECT DISTINCT scn.id_sous_categorie_test, scn.sous_categorie_test_nom
FROM 2015_sous_categorie_test AS scn

LEFT OUTER JOIN 2015_test_sous_categorie_test AS nscn
ON scn.id_sous_categorie_test = nscn.id_sous_categorie_test

WHERE nscn.id_test ="'.mysql_real_escape_string($id_test).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestJeux($id_test){

$connexion = connexion();
$request = '
SELECT  DISTINCT jvp.id_jeu
FROM 2015_jeu_version_plateforme AS jvp

LEFT OUTER JOIN 2015_test_jeu_version_plateforme AS njvp
ON jvp.id_jeu_version_plateforme = njvp.id_jeu_version_plateforme


WHERE njvp.id_test ="'.mysql_real_escape_string($id_test).'"

';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectDeveloppeurImageThatIsNotAlReadyInTest($id_test,$id_developpeur){
$connexion = connexion();
$request = '
SELECT CONCAT("developpeurs","/",d.developpeur_image_nom) AS developpeur_image_url
FROM 2015_developpeur AS d


LEFT OUTER JOIN 2015_test_developpeur AS nd
ON d.id_developpeur = nd.id_developpeur

WHERE d.id_developpeur = '.mysql_real_escape_string($id_developpeur).'
AND nd.id_test = '.mysql_real_escape_string($id_test).'
AND CONCAT("developpeurs","/",d.developpeur_image_nom) NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
AND CONCAT("developpeurs","/",d.developpeur_image_nom) NOT IN (SELECT nillu.url_test_illustration FROM 2015_test_illustration AS nillu WHERE nillu.id_test = "'.mysql_real_escape_string($id_test).'")
AND d.developpeur_image_nom <> ""

';	

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectEditeurImageThatIsNotAlReadyInTest($id_test,$id_editeur){
$connexion = connexion();
$request = '
SELECT CONCAT("editeurs","/",e.editeur_image_nom) AS editeur_image_url
FROM 2015_editeur AS e


LEFT OUTER JOIN 2015_test_editeur AS ne
ON e.id_editeur = ne.id_editeur

WHERE e.id_editeur = '.mysql_real_escape_string($id_editeur).'
AND ne.id_test = '.mysql_real_escape_string($id_test).'
AND CONCAT("editeurs","/",e.editeur_image_nom) NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
AND CONCAT("editeurs","/",e.editeur_image_nom) NOT IN (SELECT nillu.url_test_illustration FROM 2015_test_illustration AS nillu WHERE nillu.id_test = "'.mysql_real_escape_string($id_test).'")
AND e.editeur_image_nom <> ""


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectConstructeurImageThatIsNotAlReadyInTest($id_test,$id_constructeur){
$connexion = connexion();
$request = '
SELECT CONCAT("constructeurs","/",c.constructeur_image_nom) AS constructeur_image_url
FROM 2015_constructeur AS c


LEFT OUTER JOIN 2015_test_constructeur AS nc
ON c.id_constructeur = nc.id_constructeur

WHERE c.id_constructeur = '.mysql_real_escape_string($id_constructeur).'
AND nc.id_test = '.mysql_real_escape_string($id_test).'
AND CONCAT("constructeurs","/",c.constructeur_image_nom) NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
AND CONCAT("constructeurs","/",c.constructeur_image_nom) NOT IN (SELECT nillu.url_test_illustration FROM 2015_test_illustration AS nillu WHERE nillu.id_test = "'.mysql_real_escape_string($id_test).'")
AND c.constructeur_image_nom <> ""

';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPlateformeImageThatIsNotAlReadyInTest($id_test,$id_plateforme){
$connexion = connexion();
$request = '
SELECT CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) AS plateforme_image_url
FROM 2015_plateforme AS p

LEFT OUTER JOIN 2015_test_plateforme AS np
ON p.id_plateforme = np.id_plateforme

WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
AND np.id_test = '.mysql_real_escape_string($id_test).'
AND CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
AND CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) NOT IN (SELECT nillu.url_test_illustration FROM 2015_test_illustration AS nillu WHERE nillu.id_test = "'.mysql_real_escape_string($id_test).'")
AND p.plateforme_image_generique <> ""

';	

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPlateformeVersionImageThatIsNotAlReadyInTest($id_test,$id_plateforme){
$connexion = connexion();
$request = '
			SELECT 
			CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) AS plateforme_version_image_url,
			p.plateforme_nom_generique
			

			FROM 2015_plateforme_version_image AS pvi
			
			LEFT OUTER JOIN 2015_plateforme_version AS pv
			ON pvi.id_plateforme_version = pv.id_plateforme_version
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			LEFT OUTER JOIN 2015_test_plateforme AS np
			ON p.id_plateforme = np.id_plateforme

			WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) NOT IN (SELECT nillu.url_test_illustration FROM 2015_test_illustration AS nillu WHERE nillu.id_test = "'.mysql_real_escape_string($id_test).'")

';	


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectCategorieTestImageThatIsNotAlReadyInTest($id_test,$id_sous_categorie_test){
$connexion = connexion();
$request = '
SELECT CONCAT("categories_test","/",scn.sous_categorie_test_image_nom) AS sous_categorie_test_image_url
FROM 2015_sous_categorie_test AS scn


LEFT OUTER JOIN 2015_test_sous_categorie_test AS nscn
ON scn.id_sous_categorie_test = nscn.id_sous_categorie_test

WHERE scn.id_sous_categorie_test = '.mysql_real_escape_string($id_sous_categorie_test).'
AND nscn.id_test = '.mysql_real_escape_string($id_test).'
AND CONCAT("categories_test","/",scn.sous_categorie_test_image_nom) NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
AND CONCAT("categories_test","/",scn.sous_categorie_test_image_nom) NOT IN (SELECT nillu.url_test_illustration FROM 2015_test_illustration AS nillu WHERE nillu.id_test = "'.mysql_real_escape_string($id_test).'")

AND scn.sous_categorie_test_image_nom <> ""

';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuxImageThatIsNotAlReadyInTest($id_test,$id_jeu){
$connexion = connexion();
$request = '
SELECT DISTINCT CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) AS jeu_image_url
FROM 2015_jeu AS j

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN 2015_jeu_version_plateforme_image AS jvpi
ON jvpi.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_test_jeu_version_plateforme AS njvp
ON jvp.id_jeu_version_plateforme = njvp.id_jeu_version_plateforme


WHERE j.id_jeu = '.mysql_real_escape_string($id_jeu).'
AND CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) NOT IN (SELECT nimg.url_test_image FROM 2015_test_image AS nimg WHERE nimg.id_test = "'.mysql_real_escape_string($id_test).'")
AND CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) NOT IN (SELECT nillu.url_test_illustration FROM 2015_test_illustration AS nillu WHERE nillu.id_test = "'.mysql_real_escape_string($id_test).'")


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectAllVideoTest($id_test){
$connexion = connexion();
$request = '
SELECT *
FROM 2015_test_video 
WHERE id_test = "'.mysql_real_escape_string($id_test).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuxVideoThatIsNotAlReadyInTest($id_test,$id_jeu){
$connexion = connexion();
$request = '
SELECT jvpv.video_url, jvpv.video_titre
FROM 2015_jeu_version_plateforme_video AS jvpv

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON jvpv.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme


LEFT OUTER JOIN 2015_jeu AS j
ON jvp.id_jeu = j.id_jeu

WHERE j.id_jeu = '.mysql_real_escape_string($id_jeu).'
AND jvpv.video_url NOT IN (SELECT nv.url_test_video FROM 2015_test_video AS nv WHERE nv.id_test = "'.mysql_real_escape_string($id_test).'")


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlCountFrontpage($id_test){
$connexion = connexion();

$request = 'SELECT count(*) AS count, f.id_frontpage,
			CASE WHEN count(*) = 0 THEN 1 ELSE count(*) END AS rowspan
			FROM  2015_frontpage_test AS f
		
			WHERE f.id_test = '.mysql_real_escape_string($id_test).'
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlDeleteFrontpage($id_frontpage){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_frontpage_test
				WHERE id_frontpage = "'.mysql_real_escape_string($id_frontpage).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlSelectFrontpage($id_test){
$connexion = connexion();

$request = 'SELECT *
			FROM  2015_frontpage_test AS f
		
			WHERE f.id_test = '.mysql_real_escape_string($id_test).'
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlCountTestJeuPlateformeVersion($id_test){
$connexion = connexion();

$request = 'SELECT count(*) AS count,
			CASE WHEN count(*) = 0 THEN 1 ELSE count(*) END AS rowspan
			FROM 2015_test_jeu_version_plateforme AS tjvp
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme
			
		
			
			WHERE tjvp.id_test = \''.mysql_real_escape_string(trim($id_test)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlTestIsJeuPlateformeVersion($id_test,$id_jeu_version_plateforme){
$connexion = connexion();

$request = 'SELECT count(*) AS count, tjvp.id_jeu_version_plateforme, p.plateforme_nom_generique

			FROM 2015_test_jeu_version_plateforme AS tjvp
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE tjvp.id_test = \''.mysql_real_escape_string(trim($id_test)).'\'
			AND tjvp.id_jeu_version_plateforme = \''.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'\'
			';
	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPremierTestJeuVersionPlateforme($id_test){

$connexion = connexion();

$request = 'SELECT  p.plateforme_nom_generique, tjvp.id_test_jeu_version_plateforme
		
			FROM  2015_test_jeu_version_plateforme AS tjvp

			
			LEFT OUTER JOIN 2015_test AS t
			ON t.id_test = tjvp.id_test
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			
			WHERE tjvp.id_test = \''.mysql_real_escape_string(trim($id_test)).'\'
			ORDER BY  tjvp.id_test_jeu_version_plateforme
			LIMIT 1';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestJeuVersionPlateformeSuivant($limit,$id_test){

$connexion = connexion();

$request = 'SELECT  p.plateforme_nom_generique, tjvp.id_test_jeu_version_plateforme
		
			FROM  2015_test_jeu_version_plateforme AS tjvp

			
			LEFT OUTER JOIN 2015_test AS t
			ON t.id_test = tjvp.id_test
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE tjvp.id_test = \''.mysql_real_escape_string(trim($id_test)).'\'
			
			
			ORDER BY  tjvp.id_test_jeu_version_plateforme

			LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET 1';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestJeuVersionPlateformeByID($id_test_jeu_version_plateforme){

$connexion = connexion();

$request = 'SELECT  p.plateforme_nom_generique, tjvp.id_test_jeu_version_plateforme, tjvp.test_titre, tjvp.test_corps,
			tjvp.test_note, tjvp.test_moins, tjvp.test_plus, t.id_test, j.jeu_nom_generique, tjvp.id_jeu_version_plateforme
			FROM  2015_test_jeu_version_plateforme AS tjvp

			
			LEFT OUTER JOIN 2015_test AS t
			ON t.id_test = tjvp.id_test
			
			LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
			ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme
			
			LEFT OUTER JOIN 2015_jeu AS j
			ON j.id_jeu = jvp.id_jeu
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = jvp.id_plateforme
			
			WHERE tjvp.id_test_jeu_version_plateforme = \''.mysql_real_escape_string(trim($id_test_jeu_version_plateforme)).'\'';
			
			
	
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}
function mysqlUpdateTestJeuVersionPlateformeByTest($id_test_jeu_version_plateforme,$titre,$corps_test,$note,$plus,$moins){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_test_jeu_version_plateforme
			SET 
			test_titre="'.mysql_real_escape_string($titre).'" , 
			test_corps="'.mysql_real_escape_string($corps_test).'" , 
			test_note="'.mysql_real_escape_string($note).'" ,
			test_plus="'.mysql_real_escape_string($plus).'",
			id_membre_modificateur = "'.$id_membre.'",
			test_date_modif = NOW(),
			test_moins="'.mysql_real_escape_string($moins).'"
			WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdateTest($id_test,$publish_date,$id_jeu_version_plateforme){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_test
			SET 
			
			id_membre_modificateur = "'.mysql_real_escape_string($id_membre).'",
			test_date_publication ="'.mysql_real_escape_string($publish_date).'",
			id_jeu_version_plateforme ="'.mysql_real_escape_string($id_jeu_version_plateforme).'"
			WHERE id_test = "'.mysql_real_escape_string($id_test).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdateTestDate($id_test){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_test
			SET 
			
			id_membre_modificateur = "'.$id_membre.'",
			test_date_modif = NOW()
			
			WHERE id_test = "'.mysql_real_escape_string($id_test).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlSelectVersionNotTestByID($id_test){

$connexion = connexion();

$requete = 'SELECT DISTINCT j.id_jeu,j.jeu_nom_generique,
					jvp.id_jeu, jvp.id_jeu_version_plateforme,
					p.plateforme_nom_generique, p.id_plateforme

					FROM  2015_jeu_version_plateforme AS jvp
					
					LEFT OUTER JOIN  2015_plateforme AS p
					ON jvp.id_plateforme = p.id_plateforme
					
					LEFT OUTER JOIN  2015_jeu AS j
					ON j.id_jeu = jvp.id_jeu
					
					WHERE j.id_jeu = (
					
					
					SELECT j.id_jeu
					FROM  2015_test AS t
			

			
					LEFT JOIN 2015_jeu_version_plateforme AS jvp
					ON jvp.id_jeu_version_plateforme = t.id_jeu_version_plateforme
			
					LEFT JOIN 2015_jeu AS j
					ON j.id_jeu = jvp.id_jeu
		
			
		
					WHERE t.id_test = '.mysql_real_escape_string($id_test).'
					
					
					)
					
					AND jvp.id_jeu_version_plateforme NOT IN (SELECT tjvp.id_jeu_version_plateforme FROM 2015_test_jeu_version_plateforme AS tjvp WHERE tjvp.id_test = "'.mysql_real_escape_string($id_test).'")

					
							
					';
		
$result = mysql_query($requete) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectTestJeuVersionPlateforme($id_test){

$connexion = connexion();

$request = 'SELECT tjvp.id_test_jeu_version_plateforme,tjvp.test_titre,tjvp.test_corps,tjvp.test_note,tjvp.test_moins,tjvp.test_plus FROM 2015_test_jeu_version_plateforme AS tjvp LEFT OUTER JOIN 2015_test AS t ON t.id_test = tjvp.id_test LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp ON jvp.id_jeu_version_plateforme = tjvp.id_jeu_version_plateforme LEFT OUTER JOIN 2015_plateforme AS p ON p.id_plateforme = jvp.id_plateforme
			
			WHERE tjvp.id_test = \''.mysql_real_escape_string(trim($id_test)).'\'
			
			AND tjvp.id_jeu_version_plateforme = (SELECT t.id_jeu_version_plateforme FROM 2015_test AS t WHERE t.id_test = \''.mysql_real_escape_string(trim($id_test)).'\')
			
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectImageJeuVersionPlateforme($id_jeu_version_plateforme){

$connexion = connexion();

$request = 'SELECT DISTINCT jvpi.image_nom, j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique,
					jvpi.image_titre, jvpi.id_jeu_version_plateforme_image AS id_image, 
					coalesce(ic.categorie_image_nom,"non renseigné") AS categorie_image_nom, 
					jvp.id_jeu_version_plateforme,
					CONCAT(\'jeux/\',j.jeu_dossier,\'/pictures/\',jvpi.image_nom) AS url,
					CONCAT(p.plateforme_nom_generique,\' \',j.jeu_nom_generique) AS alt
					
					FROM 2015_jeu_version_plateforme_image AS jvpi

					LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
					ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme
					
					LEFT OUTER JOIN  2015_plateforme AS p
					ON jvp.id_plateforme = p.id_plateforme

					LEFT OUTER JOIN  2015_jeu AS j
					ON jvp.id_jeu = j.id_jeu

					LEFT OUTER JOIN  2015_categorie_image AS ic
					ON ic.id_categorie_image = jvpi.id_categorie_image

					WHERE jvpi.id_jeu_version_plateforme = \''.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'\'


			';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPhotoTest($id_test){

$connexion = connexion();

$request = 'SELECT tjvpp.id_test_jeu_version_plateforme_photo, 


CONCAT("tests","/",tjvpp.test_jeu_version_plateforme_photo_nom) AS url

FROM 2015_test_jeu_version_plateforme_photo AS tjvpp

LEFT OUTER JOIN 2015_test_jeu_version_plateforme AS tjvp
ON tjvp.id_test_jeu_version_plateforme = tjvpp.id_test_jeu_version_plateforme

WHERE tjvp.id_test = \''.mysql_real_escape_string(trim($id_test)).'\'
GROUP BY tjvpp.test_jeu_version_plateforme_photo_nom

					
';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPhotoTestJeuVersionPlateforme($id_test_jeu_version_plateforme){

$connexion = connexion();

$request = 'SELECT tjvpp.id_test_jeu_version_plateforme_photo, 


CONCAT("tests","/",tjvpp.test_jeu_version_plateforme_photo_nom) AS url

FROM 2015_test_jeu_version_plateforme_photo AS tjvpp


WHERE tjvpp.id_test_jeu_version_plateforme = \''.mysql_real_escape_string(trim($id_test_jeu_version_plateforme)).'\'

					
';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectVideoJeuVersionPlateforme($id_jeu_version_plateforme){

$connexion = connexion();

$request = 'SELECT DISTINCT jvpv.video_url, p.plateforme_nom_generique,
					jvpv.video_titre, jvpv.id_jeu_version_plateforme_video, 
					coalesce(ic.categorie_video_nom,"non renseigné") AS categorie_video_nom, jvp.id_jeu_version_plateforme


					FROM 2015_jeu_version_plateforme_video AS jvpv

					LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
					ON jvp.id_jeu_version_plateforme = jvpv.id_jeu_version_plateforme

					LEFT OUTER JOIN  2015_jeu AS j
					ON jvp.id_jeu = j.id_jeu
					
					LEFT OUTER JOIN  2015_plateforme AS p
					ON jvp.id_plateforme = p.id_plateforme


					LEFT OUTER JOIN  2015_categorie_video AS ic
					ON ic.id_categorie_video = jvpv.id_categorie_video

					WHERE jvp.id_jeu_version_plateforme = \''.mysql_real_escape_string(trim($id_jeu_version_plateforme)).'\'
					
					ORDER BY ic.categorie_video_nom


			';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlUpdateFrontpagePublicationDate($id_test,$date_publication){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_frontpage_test
			SET 
		
			frontpage_date_publication = "'.mysql_real_escape_string($date_publication).'"
		
			WHERE id_test = "'.mysql_real_escape_string($id_test).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}


function mysqlInsertTestJeuVersionPlateformeImage($id_test_jeu_version_plateforme,$url_image,$image_titre,$image_alt){
$connexion = connexion();
$request = "INSERT INTO 2015_test_jeu_version_plateforme_image
			VALUES ('','".mysql_real_escape_string(trim($id_test_jeu_version_plateforme))."','".mysql_real_escape_string(trim($url_image))."','".mysql_real_escape_string(trim($image_titre))."','".mysql_real_escape_string(trim($image_alt))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestJeuVersionPlateformeVideo($id_test_jeu_version_plateforme,$url_video,$video_titre){
$connexion = connexion();
$request = "INSERT INTO 2015_test_jeu_version_plateforme_video
			VALUES ('','".mysql_real_escape_string(trim($id_test_jeu_version_plateforme))."','".mysql_real_escape_string(trim($url_video))."','".mysql_real_escape_string(trim($video_titre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertTestJeuVersionPlateformeIllustration($id_test_jeu_version_plateforme,$url_image,$image_titre,$image_alt){
$connexion = connexion();
$request = "INSERT INTO 2015_test_jeu_version_plateforme_illustration
			VALUES ('','".mysql_real_escape_string(trim($id_test_jeu_version_plateforme))."','".mysql_real_escape_string(trim($url_image))."','".mysql_real_escape_string(trim($image_titre))."','".mysql_real_escape_string(trim($image_alt))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlSelectIdTestJeuVersionPlateforme($id_test){



$connexion = connexion();

$requete = '
SELECT t.id_jeu_version_plateforme
FROM 2015_test AS t

WHERE t.id_test ='.mysql_real_escape_string($id_test).'';
	
	
$result = mysql_query($requete) or die(mysql_error());

return $result;
mysql_close($connexion);

}


function mysqlIsImageTestJeuVersionPlateforme($url,$id_test,$id_jeu_version_plateforme){



$connexion = connexion();

$requete = '
SELECT count(*) AS count 
FROM 2015_test_jeu_version_plateforme_image AS tjvpi 


WHERE tjvpi.url_test_jeu_version_plateforme_image = "'.$url.' "
AND tjvpi.id_test_jeu_version_plateforme = (

SELECT tjvp.id_test_jeu_version_plateforme 
FROM 2015_test_jeu_version_plateforme AS tjvp


WHERE tjvp.id_test = '.$id_test.' 
AND tjvp.id_jeu_version_plateforme = '.$id_jeu_version_plateforme.'
)


';
	
	
$result = mysql_query($requete) or die(mysql_error());

return $result;
mysql_close($connexion);

}

function mysqlIsIllustrationTestJeuVersionPlateforme($url,$id_test,$id_jeu_version_plateforme){



$connexion = connexion();

$requete = '
SELECT count(*) AS count 
FROM 2015_test_jeu_version_plateforme_illustration AS tjvpi 


WHERE tjvpi.url_test_jeu_version_plateforme_illustration = "'.$url.' "
AND tjvpi.id_test_jeu_version_plateforme = (

SELECT tjvp.id_test_jeu_version_plateforme 
FROM 2015_test_jeu_version_plateforme AS tjvp


WHERE tjvp.id_test = '.$id_test.' 
AND tjvp.id_jeu_version_plateforme = '.$id_jeu_version_plateforme.'
)


';
	
	
$result = mysql_query($requete) or die(mysql_error());

return $result;
mysql_close($connexion);

}

function mysqlIsIllustrationTestJeuVersionPlateforme2($url,$id_test_jeu_version_plateforme){



$connexion = connexion();

$requete = '
SELECT count(*) AS count 
FROM 2015_test_jeu_version_plateforme_illustration AS tjvpi 


WHERE tjvpi.url_test_jeu_version_plateforme_illustration = "'.$url.' "
AND tjvpi.id_test_jeu_version_plateforme = '.$id_test_jeu_version_plateforme.'



';
	
//echo $requete;
$result = mysql_query($requete) or die(mysql_error());

return $result;
mysql_close($connexion);

}

function mysqlIsVideoTestJeuVersionPlateforme($url,$id_test,$id_jeu_version_plateforme){



$connexion = connexion();

$requete = '
SELECT count(*) AS count 
FROM 2015_test_jeu_version_plateforme_video AS tjvpv


WHERE tjvpv.url_test_jeu_version_plateforme_video = "'.$url.' "
AND tjvpv.id_test_jeu_version_plateforme = (

SELECT tjvp.id_test_jeu_version_plateforme 
FROM 2015_test_jeu_version_plateforme AS tjvp


WHERE tjvp.id_test = '.$id_test.' 
AND tjvp.id_jeu_version_plateforme = '.$id_jeu_version_plateforme.'
)


';
	
	
$result = mysql_query($requete) or die(mysql_error());

return $result;
mysql_close($connexion);

}

function mysqlInsertTestJeuVersionPlateformePhoto($id_test_jeu_version_plateforme,$image_name,$photo_titre,$id_categorie_image){
//$id_membre = mysql_real_escape_string(trim(getID()));


$connexion = connexion();

$request = "INSERT INTO 2015_test_jeu_version_plateforme_photo
			VALUES ('','".mysql_real_escape_string($id_test_jeu_version_plateforme)."','".mysql_real_escape_string($image_name)."','".mysql_real_escape_string($photo_titre)."','".mysql_real_escape_string(trim($id_categorie_image))."')";


			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteTestJeuVersionPlateformePhoto($id_test_jeu_version_plateforme){
$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme_photo
				WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}




function mysqlDeleteTestJeuVersionPlateformeImage($id_test_jeu_version_plateforme){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme_image
				WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestJeuVersionPlateformeVideo($id_test_jeu_version_plateforme){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme_video
				WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteTestJeuVersionPlateformeIllustration($id_test_jeu_version_plateforme){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_test_jeu_version_plateforme_illustration
				WHERE id_test_jeu_version_plateforme = "'.mysql_real_escape_string($id_test_jeu_version_plateforme).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

?>