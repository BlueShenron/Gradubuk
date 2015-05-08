<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}



function mysqlSelectAllNewsWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT n.id_news, n.news_titre, 
			DATE_FORMAT(n.news_date_creation,"%d %b %Y - %H:%i") AS news_date_creation,
			 
			
			CASE WHEN n.news_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(n.news_date_publication, "%d/%m/%Y - %H:%i") END AS news_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo
			FROM  2015_news AS n
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = n.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = n.id_membre_modificateur
			
			ORDER BY '.mysql_real_escape_string(trim($order)).' DESC ';


$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllNewsWithPageNumberIdSousCategorieNews($page, $order, $nb_element_par_page,$id_sous_categorie_news){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT a.id_news, a.news_titre, 
			DATE_FORMAT(a.news_date_creation,"%d %b %Y - %H:%i") AS news_date_creation,
			 
			
			CASE WHEN a.news_date_publication = "0000-00-00" THEN "en attente" 
			ELSE DATE_FORMAT(a.news_date_publication, "%d/%m/%Y - %H:%i") END AS news_date_publication,

			mc.pseudo AS pseudo_correcteur,
			m.pseudo
			FROM  2015_news AS a
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = a.id_membre_createur
			
			LEFT JOIN 2015_membre AS mc
			ON mc.id_membre = a.id_membre_modificateur
			
			WHERE a.id_news IN (SELECT ascn.id_news FROM 2015_news_sous_categorie_news AS ascn WHERE id_sous_categorie_news = '.mysql_real_escape_string(trim($id_sous_categorie_news)).'
			
			
			)
			ORDER BY '.mysql_real_escape_string(trim($order)).' DESC ';


$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllNews(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_news';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectAllNewsIdSousCategorieNews($id_sous_categorie_news){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_news AS a
			WHERE a.id_news IN (SELECT ascn.id_news FROM 2015_news_sous_categorie_news AS ascn WHERE id_sous_categorie_news = '.mysql_real_escape_string(trim($id_sous_categorie_news)).'
			
			
			)
			
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectCountNewsIdSousCategorieNews($id_sous_categorie_news){
$connexion = connexion();

$request = '
SELECT count(*) AS count, sous_categorie_news_nom FROM (
SELECT a.id_news, scn.id_sous_categorie_news, scn.sous_categorie_news_nom FROM 2015_news AS a LEFT JOIN 2015_news_sous_categorie_news AS ascn ON ascn.id_news = a.id_news LEFT JOIN 2015_sous_categorie_news AS scn ON scn.id_sous_categorie_news = ascn.id_sous_categorie_news WHERE a.id_news IN ( SELECT ascn.id_news FROM 2015_news_sous_categorie_news AS ascn WHERE id_sous_categorie_news ='.mysql_real_escape_string(trim($id_sous_categorie_news)).')
    
   ) AS sub WHERE id_sous_categorie_news = '.mysql_real_escape_string(trim($id_sous_categorie_news)).'

';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}
function mysqlSelectAllSousCategorieByCategorie(){
$connexion = connexion();
$request = 'SELECT * 
FROM  2015_sous_categorie_news AS scn

LEFT JOIN 2015_categorie_news AS cn
ON cn.id_categorie_news = scn.id_categorie_news

ORDER BY cn.categorie_news_nom, scn.sous_categorie_news_nom' 
;
			
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

function mysqlInsertNews($news_titre,$news_corps,$date_publication){
$id_membre = mysql_real_escape_string(trim(getID()));

$connexion = connexion();
$request = "INSERT INTO 2015_news
			VALUES ('','".mysql_real_escape_string(trim($news_titre))."','".mysql_real_escape_string(trim($news_corps))."',NOW(),NOW(),'".mysql_real_escape_string(trim($date_publication))."','".mysql_real_escape_string(trim($id_membre))."','".mysql_real_escape_string(trim($id_membre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlSelectNewsByID($id_news){
$connexion = connexion();

$request = 'SELECT n.id_news, n.news_titre, n.news_corps,
			DATE_FORMAT(n.news_date_creation,"%d %b %Y - %H:%i") AS news_date_creation, 
			DATE_FORMAT(n.news_date_publication,"%d %b %Y - %h:%i") AS news_date_publication, 
			n.news_date_publication AS news_date_publication_non_formate,
			m.pseudo
			
			FROM  2015_news AS n
			
			LEFT JOIN 2015_membre AS m
			ON m.id_membre = n.id_membre_createur
			
			LEFT JOIN 2015_news_image AS ni
			ON ni.id_news = n.id_news
		
			LEFT JOIN 2015_news_video AS nv
			ON nv.id_news = n.id_news
		
			LEFT JOIN 2015_news_illustration AS nillu
			ON nillu.id_news = n.id_news
		
			LEFT JOIN 2015_news_sous_categorie_news AS nscn
			ON nscn.id_news = n.id_news
		
			LEFT JOIN 2015_news_plateforme AS np
			ON np.id_news = n.id_news
		
			LEFT JOIN 2015_news_constructeur AS nc
			ON nc.id_news = n.id_news
		
			LEFT JOIN 2015_news_developpeur AS nd
			ON nd.id_news = n.id_news
		
			LEFT JOIN 2015_news_jeu_version_plateforme AS njvp
			ON njvp.id_news = n.id_news
		
			
		
			WHERE n.id_news = '.mysql_real_escape_string($id_news).'';


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlInsertNewsImage($id_news,$url_image,$image_titre,$image_alt){
$connexion = connexion();
$request = "INSERT INTO 2015_news_image
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($url_image))."','".mysql_real_escape_string(trim($image_titre))."','".mysql_real_escape_string(trim($image_alt))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsVideo($id_news,$url_video,$video_titre){
$connexion = connexion();
$request = "INSERT INTO 2015_news_video
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($url_video))."','".mysql_real_escape_string(trim($video_titre))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsIllustration($id_news,$url_image,$image_titre,$image_alt){
$connexion = connexion();
$request = "INSERT INTO 2015_news_illustration
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($url_image))."','".mysql_real_escape_string(trim($image_titre))."','".mysql_real_escape_string(trim($image_alt))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsSousCategorieNews($id_news,$id_sous_categorie_news){
$connexion = connexion();
$request = "INSERT INTO 2015_news_sous_categorie_news
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($id_sous_categorie_news))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsPlateforme($id_news,$id_plateforme){
$connexion = connexion();
$request = "INSERT INTO 2015_news_plateforme
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($id_plateforme))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsConstructeur($id_news,$id_constructeur){
$connexion = connexion();
$request = "INSERT INTO 2015_news_constructeur
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($id_constructeur))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsDeveloppeur($id_news,$id_developpeur){
$connexion = connexion();
$request = "INSERT INTO 2015_news_developpeur
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($id_developpeur))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsEditeur($id_news,$id_editeur){
$connexion = connexion();
$request = "INSERT INTO 2015_news_editeur
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($id_editeur))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlInsertNewsJeuVersionPlateforme($id_news,$id_jeu_version_plateforme){
$connexion = connexion();
$request = "INSERT INTO 2015_news_jeu_version_plateforme
			VALUES ('','".mysql_real_escape_string(trim($id_news))."','".mysql_real_escape_string(trim($id_jeu_version_plateforme))."')";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}
//------------------//
function mysqlSelectNewsPlateformes($id_news){
$connexion = connexion();
$request = '
SELECT DISTINCT p.id_plateforme, p.plateforme_nom_generique, p.id_constructeur

FROM 2015_plateforme AS p

LEFT OUTER JOIN 2015_news_plateforme AS np 
ON p.id_plateforme = np.id_plateforme

WHERE np.id_news ="'.mysql_real_escape_string($id_news).'"
ORDER BY p.id_constructeur
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsSousCategorieNews($id_news){

$connexion = connexion();
$request = '
SELECT DISTINCT scn.id_sous_categorie_news, scn.sous_categorie_news_nom, scn.id_categorie_news

FROM 2015_sous_categorie_news AS scn

LEFT OUTER JOIN 2015_news_sous_categorie_news AS nscn
ON scn.id_sous_categorie_news = nscn.id_sous_categorie_news

WHERE nscn.id_news ="'.mysql_real_escape_string($id_news).'"
ORDER BY scn.sous_categorie_news_nom
';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsConstructeurs($id_news){

$connexion = connexion();
$request = '
SELECT DISTINCT p.id_constructeur, p.constructeur_nom
FROM 2015_constructeur AS p

LEFT OUTER JOIN 2015_news_constructeur AS np 
ON p.id_constructeur = np.id_constructeur

WHERE np.id_news ="'.mysql_real_escape_string($id_news).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}



function mysqlSelectJeuxIdWithNewsId($id_news){
$connexion = connexion();
$request = '
SELECT DISTINCT j.id_jeu

FROM 2015_jeu AS j

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN 2015_news_jeu_version_plateforme AS njvp
ON njvp.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

WHERE njvp.id_news ="'.mysql_real_escape_string($id_news).'"
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

function mysqlCheckJeuVersionPlateforme($id_jeu_version_plateforme, $id_news){
$connexion = connexion();
$request = 'SELECT COUNT(*) AS nbelements

FROM  2015_news_jeu_version_plateforme AS njvp

WHERE njvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'"
AND njvp.id_news = "'.mysql_real_escape_string($id_news).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsSousCategorieNewsImage($id_sous_categorie_news){

$connexion = connexion();
$request = '
SELECT 		scn.sous_categorie_news_image_nom AS sous_categorie_news_image,scn.id_sous_categorie_news AS id_sous_categorie_news,
			scn.sous_categorie_news_nom, cn.categorie_news_nom,
		
			
			
			CASE WHEN scn.sous_categorie_news_image_nom = "nopicture.jpg" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom= "" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image
			
			
			
			
			
			FROM 2015_sous_categorie_news AS scn 
			
			LEFT OUTER JOIN 2015_categorie_news AS cn
			ON scn.id_categorie_news = cn.id_categorie_news
		
			
			WHERE scn.id_sous_categorie_news = "'.mysql_real_escape_string($id_sous_categorie_news).'"
			AND scn.sous_categorie_news_image_nom <> ""
			AND scn.sous_categorie_news_image_nom IS NOT NULL
			AND scn.sous_categorie_news_image_nom <> "nopicture.jpg"
			';


	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsPlateformeImage($id_plateforme){

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

function mysqlSelectNewsConstructeurImage($id_constructeur){

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

function mysqlSelectNewsDeveloppeurImage($id_developpeur){

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

function mysqlSelectJeuWithNewsId($id_news){

$connexion = connexion();
$request = '
SELECT njvp.id_jeu_version_plateforme, jvp.id_jeu
FROM 2015_news_jeu_version_plateforme AS njvp

LEFT OUTER JOIN  2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu_version_plateforme = njvp.id_jeu_version_plateforme


WHERE njvp.id_news ="'.mysql_real_escape_string($id_news).'"
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

function mysqlCountNewsCategorieNewsIllustration($id_news,$url_news_illustration){
	$connexion = connexion();
$request = '
SELECT count(*) FROM 2015_news_illustration 
WHERE id_news = "'.mysql_real_escape_string($id_news).'"
AND url_news_illustration = "'.mysql_real_escape_string($url_news_illustration).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlNewsIllustration($id_news,$url_news_illustration){
	$connexion = connexion();
$request = '
SELECT count(*) AS count FROM 2015_news_illustration 
WHERE id_news = "'.mysql_real_escape_string($id_news).'"
AND url_news_illustration = "'.mysql_real_escape_string($url_news_illustration).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlNewsImage($id_news,$url_news_image){
	$connexion = connexion();
$request = '
SELECT count(*) AS count FROM 2015_news_image 
WHERE id_news = "'.mysql_real_escape_string($id_news).'"
AND url_news_image = "'.mysql_real_escape_string($url_news_image).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlNewsVideo($id_news,$url_news_video){
	$connexion = connexion();
$request = '
SELECT count(*) AS count FROM 2015_news_video 
WHERE id_news = "'.mysql_real_escape_string($id_news).'"
AND url_news_video = "'.mysql_real_escape_string($url_news_video).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

//---------------------------------//

function mysqlDeleteNewsImage($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_image
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsVideo($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_video
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsIllustration($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_illustration
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsSousCategorieNews($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_sous_categorie_news
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsPlateforme($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_plateforme
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsConstructeur($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_constructeur
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsDeveloppeur($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_developpeur
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsEditeur($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_editeur
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsJeuVersionPlateforme($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news_jeu_version_plateforme
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteNews($id_news){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_news
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}


function mysqlUpdateNews($id_news, $titre, $corps_news ,$date_publication){

$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_news
			SET 
			news_titre="'.mysql_real_escape_string($titre).'" , 
			news_corps="'.mysql_real_escape_string($corps_news).'" , 
			
			news_date_publication = "'.mysql_real_escape_string($date_publication).'",
			news_date_modif= NOW(), 
			id_membre_modificateur="'.mysql_real_escape_string(trim($id_membre)).'" 
		
				WHERE id_news = "'.mysql_real_escape_string($id_news).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}



function mysqlDeleteNewsImageOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_image AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsVideoOrpheline(){
$connexion = connexion();
		$request = 'DELETE ni
				FROM 2015_news_video AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsIllustrationOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_illustration AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsSousCategorieNewsOrpheline(){
$connexion = connexion();
	$request = 'DELETE nscn
				FROM 2015_news_sous_categorie_news AS nscn
				LEFT JOIN 2015_news AS n ON n.id_news = nscn.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsPlateformeOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_plateforme AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsConstructeurOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_constructeur AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}
function mysqlDeleteNewsDeveloppeurOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_developpeur AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteNewsEditeurOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_editeur AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlDeleteNewsJeuVersionPlateformeOrpheline(){
$connexion = connexion();
	$request = 'DELETE ni
				FROM 2015_news_jeu_version_plateforme AS ni
				LEFT JOIN 2015_news AS n ON n.id_news = ni.id_news
				WHERE ISNULL(n.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlUpdateDatePublicationNews($id_news){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_news
			SET 
			id_membre_modificateur="'.mysql_real_escape_string($id_membre).'",
			news_date_modif= NOW(), 
			news_date_publication=NOW() 
		
			WHERE id_news = "'.mysql_real_escape_string($id_news).'"';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}


//----------------les fonctions pour les images en bas de la page de creation de news----------------//
function mysqlSelectAllImageNews($id_news){
$connexion = connexion();
$request = '
SELECT * 
FROM 2015_news_image 
WHERE id_news = "'.mysql_real_escape_string($id_news).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlIsThisImageIllustrationOfTheNews($id_news,$url){
$connexion = connexion();
$request = '
SELECT 

CASE
WHEN count > 0 then "true"
ELSE "false"
END AS result

FROM(
SELECT count(*) AS count FROM 2015_news_illustration 
WHERE id_news = '.mysql_real_escape_string($id_news).'
AND url_news_illustration = "'.mysql_real_escape_string($url).'") AS countquery


';		

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectIllustationNewsThatIsNotImage($id_news){
$connexion = connexion();
$request = '
SELECT ni.url_news_illustration , ni.image_titre, ni.image_alt

FROM 2015_news_illustration AS ni
WHERE ni.url_news_illustration NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
AND ni.id_news = '.mysql_real_escape_string($id_news).'


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsDeveloppeur($id_news){

$connexion = connexion();
$request = '
SELECT DISTINCT d.id_developpeur, d.developpeur_nom
FROM 2015_developpeur AS d

LEFT OUTER JOIN 2015_news_developpeur AS nd
ON d.id_developpeur = nd.id_developpeur

WHERE nd.id_news ="'.mysql_real_escape_string($id_news).'"

';	

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsEditeur($id_news){

$connexion = connexion();
$request = '
SELECT DISTINCT e.id_editeur, e.editeur_nom
FROM 2015_editeur AS e

LEFT OUTER JOIN 2015_news_editeur AS ne
ON e.id_editeur = ne.id_editeur

WHERE ne.id_news ="'.mysql_real_escape_string($id_news).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsConstructeur($id_news){

$connexion = connexion();
$request = '
SELECT DISTINCT c.id_constructeur, c.constructeur_nom
FROM 2015_constructeur AS c

LEFT OUTER JOIN 2015_news_constructeur AS nc
ON c.id_constructeur = nc.id_constructeur

WHERE nc.id_news ="'.mysql_real_escape_string($id_news).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsPlateforme($id_news){

$connexion = connexion();
$request = '
SELECT DISTINCT p.id_plateforme, p.plateforme_nom_generique
FROM 2015_plateforme AS p

LEFT OUTER JOIN 2015_news_plateforme AS np
ON p.id_plateforme = np.id_plateforme

WHERE np.id_news ="'.mysql_real_escape_string($id_news).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsCategorie($id_news){

$connexion = connexion();
$request = '
SELECT DISTINCT scn.id_sous_categorie_news, scn.sous_categorie_news_nom
FROM 2015_sous_categorie_news AS scn

LEFT OUTER JOIN 2015_news_sous_categorie_news AS nscn
ON scn.id_sous_categorie_news = nscn.id_sous_categorie_news

WHERE nscn.id_news ="'.mysql_real_escape_string($id_news).'"

';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNewsJeux($id_news){

$connexion = connexion();
$request = '
SELECT  DISTINCT jvp.id_jeu
FROM 2015_jeu_version_plateforme AS jvp

LEFT OUTER JOIN 2015_news_jeu_version_plateforme AS njvp
ON jvp.id_jeu_version_plateforme = njvp.id_jeu_version_plateforme


WHERE njvp.id_news ="'.mysql_real_escape_string($id_news).'"

';

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);

}

function mysqlSelectDeveloppeurImageThatIsNotAlReadyInNews($id_news,$id_developpeur){
$connexion = connexion();
$request = '
SELECT CONCAT("developpeurs","/",d.developpeur_image_nom) AS developpeur_image_url, d.developpeur_nom
FROM 2015_developpeur AS d


LEFT OUTER JOIN 2015_news_developpeur AS nd
ON d.id_developpeur = nd.id_developpeur

WHERE d.id_developpeur = '.mysql_real_escape_string($id_developpeur).'
AND nd.id_news = '.mysql_real_escape_string($id_news).'
AND CONCAT("developpeurs","/",d.developpeur_image_nom) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
AND CONCAT("developpeurs","/",d.developpeur_image_nom) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")
AND d.developpeur_image_nom <> ""

';	

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectEditeurImageThatIsNotAlReadyInNews($id_news,$id_editeur){
$connexion = connexion();
$request = '
SELECT CONCAT("editeurs","/",e.editeur_image_nom) AS editeur_image_url, e.editeur_nom
FROM 2015_developpeur AS d
FROM 2015_editeur AS e


LEFT OUTER JOIN 2015_news_editeur AS ne
ON e.id_editeur = ne.id_editeur

WHERE e.id_editeur = '.mysql_real_escape_string($id_editeur).'
AND ne.id_news = '.mysql_real_escape_string($id_news).'
AND CONCAT("editeurs","/",e.editeur_image_nom) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
AND CONCAT("editeurs","/",e.editeur_image_nom) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")
AND e.editeur_image_nom <> ""


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectConstructeurImageThatIsNotAlReadyInNews($id_news,$id_constructeur){
$connexion = connexion();
$request = '
SELECT CONCAT("constructeurs","/",c.constructeur_image_nom) AS constructeur_image_url,  c.constructeur_nom
FROM 2015_constructeur AS c


LEFT OUTER JOIN 2015_news_constructeur AS nc
ON c.id_constructeur = nc.id_constructeur

WHERE c.id_constructeur = '.mysql_real_escape_string($id_constructeur).'
AND nc.id_news = '.mysql_real_escape_string($id_news).'
AND CONCAT("constructeurs","/",c.constructeur_image_nom) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
AND CONCAT("constructeurs","/",c.constructeur_image_nom) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")
AND c.constructeur_image_nom <> ""

';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPlateformeImageThatIsNotAlReadyInNews($id_news,$id_plateforme){
$connexion = connexion();
$request = '
SELECT CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) AS plateforme_image_url,p.plateforme_nom_generique
FROM 2015_plateforme AS p

LEFT OUTER JOIN 2015_news_plateforme AS np
ON p.id_plateforme = np.id_plateforme

WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
AND np.id_news = '.mysql_real_escape_string($id_news).'
AND CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
AND CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")
AND p.plateforme_image_generique <> ""

';	

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectPlateformeVersionImageThatIsNotAlReadyInNews($id_news,$id_plateforme){
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
			
			LEFT OUTER JOIN 2015_news_plateforme AS np
			ON p.id_plateforme = np.id_plateforme

			WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")

';	


$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectCategorieNewsImageThatIsNotAlReadyInNews($id_news,$id_sous_categorie_news){
$connexion = connexion();
$request = '
SELECT CONCAT("categories_news","/",scn.sous_categorie_news_image_nom) AS sous_categorie_news_image_url,scn.sous_categorie_news_nom
FROM 2015_sous_categorie_news AS scn


LEFT OUTER JOIN 2015_news_sous_categorie_news AS nscn
ON scn.id_sous_categorie_news = nscn.id_sous_categorie_news

WHERE scn.id_sous_categorie_news = '.mysql_real_escape_string($id_sous_categorie_news).'
AND nscn.id_news = '.mysql_real_escape_string($id_news).'
AND CONCAT("categories_news","/",scn.sous_categorie_news_image_nom) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
AND CONCAT("categories_news","/",scn.sous_categorie_news_image_nom) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")

AND scn.sous_categorie_news_image_nom <> ""

';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuxImageThatIsNotAlReadyInNews($id_news,$id_jeu){
$connexion = connexion();
$request = '
SELECT DISTINCT CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) AS jeu_image_url,  CONCAT(p.plateforme_nom_generique," ",j.jeu_nom_generique) AS jeu_nom
FROM 2015_jeu AS j

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON jvp.id_jeu = j.id_jeu

LEFT OUTER JOIN 2015_jeu_version_plateforme_image AS jvpi
ON jvpi.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_news_jeu_version_plateforme AS njvp
ON jvp.id_jeu_version_plateforme = njvp.id_jeu_version_plateforme

LEFT OUTER JOIN 2015_plateforme AS p
ON jvp.id_plateforme = p.id_plateforme


WHERE j.id_jeu = '.mysql_real_escape_string($id_jeu).'
AND CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
AND CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuxCoverThatIsNotAlReadyInNews($id_news,$id_jeu){
$connexion = connexion();
$request = "
SELECT DISTINCT jvr.jeu_region_cover,
		j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique, 
		jvp.id_jeu_version_plateforme,
		CONCAT('jeux/',j.jeu_dossier,'/covers/',jvr.jeu_region_cover) AS url,
		CONCAT(p.plateforme_nom_generique,' ',j.jeu_nom_generique) AS alt,
		
		CASE WHEN jvr.jeu_region_cover = 'nopicture.jpg' THEN 'nok'
			WHEN jvr.jeu_region_cover = '' THEN 'nok'
			WHEN jvr.jeu_region_cover IS NULL THEN 'nok'
			ELSE 'ok' END AS image
					
		FROM 2015_jeu_version_region AS jvr 
		
		LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
		ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme 
		
		LEFT OUTER JOIN 2015_plateforme AS p 
		ON jvp.id_plateforme = p.id_plateforme 
		
		LEFT OUTER JOIN 2015_jeu AS j 
		ON jvp.id_jeu = j.id_jeu 


WHERE j.id_jeu = '.mysql_real_escape_string($id_jeu).'
AND CONCAT('jeux/',j.jeu_dossier,'/covers/',jvr.jeu_region_cover) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = '".mysql_real_escape_string($id_news)."')
AND CONCAT('jeux/',j.jeu_dossier,'/covers/',jvr.jeu_region_cover) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = '".mysql_real_escape_string($id_news)."')


";	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlSelectJeuxJaquetteThatIsNotAlReadyInNews($id_news,$id_jeu){
$connexion = connexion();
$request = "
SELECT DISTINCT jvr.jeu_region_jaquette,
		j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique, 
		jvp.id_jeu_version_plateforme,
		CONCAT('jeux/',j.jeu_dossier,'/jaquettes/',jvr.jeu_region_jaquette) AS url,
		CONCAT(p.plateforme_nom_generique,' ',j.jeu_nom_generique) AS alt,
			
			
		CASE WHEN jvr.jeu_region_jaquette = 'nopicture.jpg' THEN 'nok'
			WHEN jvr.jeu_region_jaquette = '' THEN 'nok'
			WHEN jvr.jeu_region_jaquette IS NULL THEN 'nok'
			ELSE 'ok' END AS image
					
		FROM 2015_jeu_version_region AS jvr 
		
		LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
		ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme 
		
		LEFT OUTER JOIN 2015_plateforme AS p 
		ON jvp.id_plateforme = p.id_plateforme 
		
		LEFT OUTER JOIN 2015_jeu AS j 
		ON jvp.id_jeu = j.id_jeu 


WHERE j.id_jeu = '.mysql_real_escape_string($id_jeu).'
AND CONCAT('jeux/',j.jeu_dossier,'/jaquettes/',jvr.jeu_region_jaquette) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = '".mysql_real_escape_string($id_news)."')
AND CONCAT('jeux/',j.jeu_dossier,'/jaquettes/',jvr.jeu_region_jaquette) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = '".mysql_real_escape_string($id_news)."')


";	

$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllNewsPhotoNotInNews($id_news){
$connexion = connexion();
$request = 'SELECT ap.id_news_photo, ap.photo_titre, ap.news_photo_nom , ic.categorie_image_nom,
		CONCAT("news","/",ap.news_photo_nom)	AS photo_url
			FROM  2015_news_photo AS ap
			
			LEFT JOIN 2015_categorie_image AS ic
			ON ic.id_categorie_image = ap.id_categorie_image
			
			WHERE ap.id_news = \''.mysql_real_escape_string($id_news).'\'
			AND CONCAT("news","/",ap.news_photo_nom) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
			AND CONCAT("news","/",ap.news_photo_nom) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")

			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}




function mysqlSelectAllVideoNews($id_news){
$connexion = connexion();
$request = '
SELECT *
FROM 2015_news_video 
WHERE id_news = "'.mysql_real_escape_string($id_news).'"


';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectJeuxVideoThatIsNotAlReadyInNews($id_news,$id_jeu){
$connexion = connexion();
$request = '
SELECT jvpv.video_url, jvpv.video_titre
FROM 2015_jeu_version_plateforme_video AS jvpv

LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp
ON jvpv.id_jeu_version_plateforme = jvp.id_jeu_version_plateforme


LEFT OUTER JOIN 2015_jeu AS j
ON jvp.id_jeu = j.id_jeu

WHERE j.id_jeu = '.mysql_real_escape_string($id_jeu).'
AND jvpv.video_url NOT IN (SELECT nv.url_news_video FROM 2015_news_video AS nv WHERE nv.id_news = "'.mysql_real_escape_string($id_news).'")


';	
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlCountFrontpage($id_news){
$connexion = connexion();

$request = 'SELECT count(*) AS count, f.id_frontpage
			FROM  2015_frontpage_news AS f
		
			WHERE f.id_news = '.mysql_real_escape_string($id_news).'
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}

function mysqlDeleteFrontpage($id_frontpage){
	$connexion = connexion();
	$request = 'DELETE 
				FROM 2015_frontpage_news
				WHERE id_frontpage = "'.mysql_real_escape_string($id_frontpage).'"
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}

function mysqlSelectFrontpage($id_news){
$connexion = connexion();

$request = 'SELECT *
			FROM  2015_frontpage_news AS f
		
			WHERE f.id_news = '.mysql_real_escape_string($id_news).'
			';
			
$result = mysql_query($request) or die(mysql_error());

return $result;
mysql_close($connexion);
}


function mysqlUpdateFrontpagePublicationDate($id_news,$date_publication){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_frontpage_news
			SET 
		
			frontpage_date_publication = "'.mysql_real_escape_string($date_publication).'"
		
			WHERE id_news = "'.mysql_real_escape_string($id_news).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlUpdateFrontpageImageUrl($id_news,$image_url){
$id_membre = mysql_real_escape_string(trim(getID()));
$connexion = connexion();

$request = 'UPDATE 2015_frontpage_news
			SET 
		
			frontpage_image_url = "'.mysql_real_escape_string($image_url).'"
		
			WHERE id_news = "'.mysql_real_escape_string($id_news).'"';

$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}

function mysqlSelectAllNewsPhoto($id_news){
$connexion = connexion();
$request = 'SELECT ap.id_news_photo, ap.photo_titre, ap.news_photo_nom , ic.categorie_image_nom
			FROM  2015_news_photo AS ap
			
			LEFT JOIN 2015_categorie_image AS ic
			ON ic.id_categorie_image = ap.id_categorie_image
			
			WHERE ap.id_news = \''.mysql_real_escape_string($id_news).'\'
			
			';		
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlDeleteNewsPhotoOrpheline(){
$connexion = connexion();
	$request = 'DELETE ap
				FROM 2015_news_photo AS ap
				LEFT JOIN 2015_news AS a ON a.id_news = ap.id_news
				WHERE ISNULL(a.id_news)
			';	
	$result = mysql_query($request) or die(mysql_error());
	//return $result;
	mysql_close($connexion);
}







?>