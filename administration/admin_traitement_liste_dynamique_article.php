<?php
require_once('mysql_bdd_connect.php'); 
require_once('dossiers_ressources.php'); 

/*
if(isset($_GET['id_sous_categorie_news'])){
	$id_sous_categorie_news = trim(htmlentities(intval($_GET['id_sous_categorie_news'])));
	$json = array();

	
	$requete = 'SELECT scn.sous_categorie_news_image_nom AS categorie_news_image,
	
			scn.sous_categorie_news_nom, cn.categorie_news_nom,
		
			
			
			CASE WHEN scn.sous_categorie_news_image_nom = "nopicture.jpg" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom = "" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image
			
			
			
			
			
			FROM 2015_sous_categorie_news AS scn 
			
			LEFT OUTER JOIN 2015_categorie_news AS cn
			ON cn.id_categorie_news = scn.id_categorie_news
	
			
			WHERE scn.id_sous_categorie_news = "'.mysql_real_escape_string($id_sous_categorie_news).'"';
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_sous_categorie_news']]['url']='categories_news/'.$data['categorie_news_image'];
			$json[$data['id_sous_categorie_news']]['alt']=$data['categorie_news_nom'].'/'.$data['sous_categorie_news_nom'];
		}
	}
	
	
	
	
	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
	
	
	
		
}
*/

//-------------------sous catégorie---------------------//
if(isset($_GET['id_sous_categorie_news']) && isset($_GET['id_article'])){
	$id_sous_categorie_news = trim(htmlentities(intval($_GET['id_sous_categorie_news'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT scn.sous_categorie_news_image_nom AS sous_categorie_news_image,
			scn.sous_categorie_news_nom,
			CONCAT("categories_news","/",scn.sous_categorie_news_image_nom) AS sous_categorie_news_image_url,
			scn.id_sous_categorie_news, nscn.id_article,
		
			CASE WHEN scn.sous_categorie_news_image_nom = "nopicture.jpg" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom = "" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_sous_categorie_news AS scn
			
			
			LEFT OUTER JOIN 2015_article_sous_categorie_news AS nscn
			ON scn.id_sous_categorie_news = nscn.id_sous_categorie_news

			WHERE scn.id_sous_categorie_news = '.mysql_real_escape_string($id_sous_categorie_news).'
			AND CONCAT("categories_news","/",scn.sous_categorie_news_image_nom) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
			AND CONCAT("categories_news","/",scn.sous_categorie_news_image_nom) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")

			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_sous_categorie_news']]['url']=$data['sous_categorie_news_image_url'];
			$json[$data['id_sous_categorie_news']]['alt']=$data['sous_categorie_news_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}

else if(isset($_GET['id_sous_categorie_news']) && !isset($_GET['id_article'])){
	$id_sous_categorie_news = trim(htmlentities(intval($_GET['id_sous_categorie_news'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT scn.sous_categorie_news_image_nom AS sous_categorie_news_image,
			scn.sous_categorie_news_nom,
			CONCAT("categories_news","/",scn.sous_categorie_news_image_nom) AS sous_categorie_news_image_url,
			scn.id_sous_categorie_news, nscn.id_article,
		
			CASE WHEN scn.sous_categorie_news_image_nom = "nopicture.jpg" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom = "" THEN "nok"
			WHEN scn.sous_categorie_news_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_sous_categorie_news AS scn
			
			
			LEFT OUTER JOIN 2015_article_sous_categorie_news AS nscn
			ON scn.id_sous_categorie_news = nscn.id_sous_categorie_news

			WHERE scn.id_sous_categorie_news = '.mysql_real_escape_string($id_sous_categorie_news).'
			
			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_sous_categorie_news']]['url']=$data['sous_categorie_news_image_url'];
			$json[$data['id_sous_categorie_news']]['alt']=$data['sous_categorie_news_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}
//-------------------sous_categorie_news---------------------//

//-------------------plateforme---------------------//
else if(isset($_GET['id_plateforme']) && isset($_GET['id_article'])){
	$id_plateforme = trim(htmlentities(intval($_GET['id_plateforme'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT p.plateforme_image_generique AS plateforme_image_generique,
			p.plateforme_nom_generique,p.plateforme_dossier,
			CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) AS plateforme_image_generique_url,
			p.id_plateforme, np.id_article,
		
			CASE WHEN p.plateforme_image_generique = "nopicture.jpg" THEN "nok"
			WHEN p.plateforme_image_generique = "" THEN "nok"
			WHEN p.plateforme_image_generique IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_plateforme AS p
			
			
			LEFT OUTER JOIN 2015_article_plateforme AS np
			ON p.id_plateforme = np.id_plateforme

			WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")

			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
    $result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['plateforme_image_generique_url']]['url']=$data['plateforme_image_generique_url'];
			$json[$data['plateforme_image_generique_url']]['alt']=$data['plateforme_nom_generique'];
		}
	}
	
	
	
	mysql_free_result($data);

	//------------------------//
	
	$requete = 'SELECT 
			CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) AS plateforme_version_image_url,
			p.plateforme_nom_generique
			

			FROM 2015_plateforme_version_image AS pvi
			
			LEFT OUTER JOIN 2015_plateforme_version AS pv
			ON pvi.id_plateforme_version = pv.id_plateforme_version
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			LEFT OUTER JOIN 2015_article_plateforme AS np
			ON p.id_plateforme = np.id_plateforme

			WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
			AND CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")

			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
    $result2 = mysql_query($requete) or die(mysql_error());
	
	while($data2 = mysql_fetch_array($result2)){
			$json[$data2['plateforme_version_image_url']]['url']=$data2['plateforme_version_image_url'];
			$json[$data2['plateforme_version_image_url']]['alt']=$data2['plateforme_nom_generique'];
	}

	echo json_encode($json);
	mysql_free_result($data2);
	mysql_close();
    	
}

else if(isset($_GET['id_plateforme']) && !isset($_GET['id_article'])){
	$id_plateforme = trim(htmlentities(intval($_GET['id_plateforme'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT p.plateforme_image_generique AS plateforme_image_generique,
			p.plateforme_nom_generique,p.plateforme_dossier,
			CONCAT("plateformes","/",p.plateforme_dossier,"/",p.plateforme_image_generique) AS plateforme_image_generique_url,
			p.id_plateforme, np.id_article,
		
			CASE WHEN p.plateforme_image_generique = "nopicture.jpg" THEN "nok"
			WHEN p.plateforme_image_generique = "" THEN "nok"
			WHEN p.plateforme_image_generique IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_plateforme AS p
			
			
			LEFT OUTER JOIN 2015_article_plateforme AS np
			ON p.id_plateforme = np.id_plateforme

			WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
			
			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
    $result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['plateforme_image_generique_url']]['url']=$data['plateforme_image_generique_url'];
			$json[$data['plateforme_image_generique_url']]['alt']=$data['plateforme_nom_generique'];
		}
	}
	mysql_free_result($data);

	//------------------------//
	
	$requete2 = 'SELECT 
			CONCAT("plateformes","/",p.plateforme_dossier,"/",pvi.plateforme_version_image_nom) AS plateforme_version_image_url,
			p.plateforme_nom_generique,pv.id_plateforme_version

			FROM 2015_plateforme_version_image AS pvi
			
			LEFT OUTER JOIN 2015_plateforme_version AS pv
			ON pvi.id_plateforme_version = pv.id_plateforme_version
			
			LEFT OUTER JOIN 2015_plateforme AS p
			ON p.id_plateforme = pv.id_plateforme
			
			LEFT OUTER JOIN 2015_article_plateforme AS np
			ON p.id_plateforme = np.id_plateforme

			WHERE p.id_plateforme = '.mysql_real_escape_string($id_plateforme).'
			
			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
    $result2 = mysql_query($requete2) or die(mysql_error());
	
	while($data2 = mysql_fetch_array($result2)){
			$json[$data2['plateforme_version_image_url']]['url']=$data2['plateforme_version_image_url'];
			$json[$data2['plateforme_version_image_url']]['alt']=$data2['plateforme_nom_generique'];
	}


	echo json_encode($json);
	mysql_free_result($data2);
	mysql_close();
    	
}
//-------------------plateforme---------------------//




//-------------------constructeur---------------------//
else if(isset($_GET['id_constructeur']) && isset($_GET['id_article'])){
	$id_constructeur = trim(htmlentities(intval($_GET['id_constructeur'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT c.constructeur_image_nom AS constructeur_image,
			c.constructeur_nom,
			CONCAT("constructeurs","/",c.constructeur_image_nom) AS constructeur_image_url,
			c.id_constructeur, nc.id_article,
		
			CASE WHEN c.constructeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN c.constructeur_image_nom = "" THEN "nok"
			WHEN c.constructeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_constructeur AS c
			
			
			LEFT OUTER JOIN 2015_article_constructeur AS nc
			ON c.id_constructeur = nc.id_constructeur

			WHERE c.id_constructeur = '.mysql_real_escape_string($id_constructeur).'
			AND CONCAT("constructeurs","/",c.constructeur_image_nom) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
			AND CONCAT("constructeurs","/",c.constructeur_image_nom) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")

			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_constructeur']]['url']=$data['constructeur_image_url'];
			$json[$data['id_constructeur']]['alt']=$data['constructeur_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}

else if(isset($_GET['id_constructeur']) && !isset($_GET['id_article'])){
	$id_constructeur = trim(htmlentities(intval($_GET['id_constructeur'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT c.constructeur_image_nom AS constructeur_image,
			c.constructeur_nom,
			CONCAT("constructeurs","/",c.constructeur_image_nom) AS constructeur_image_url,
			c.id_constructeur, nc.id_article,
		
			CASE WHEN c.constructeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN c.constructeur_image_nom = "" THEN "nok"
			WHEN c.constructeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_constructeur AS c
			
			
			LEFT OUTER JOIN 2015_article_constructeur AS nc
			ON c.id_constructeur = nc.id_constructeur

			WHERE c.id_constructeur = '.mysql_real_escape_string($id_constructeur).'
			
			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_constructeur']]['url']=$data['constructeur_image_url'];
			$json[$data['id_constructeur']]['alt']=$data['constructeur_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}
//-------------------constructeur---------------------//



//-------------------developpeur---------------------//
else if(isset($_GET['id_developpeur']) && isset($_GET['id_article'])){
	$id_developpeur = trim(htmlentities(intval($_GET['id_developpeur'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT d.developpeur_image_nom AS developpeur_image,
			d.developpeur_nom,
			CONCAT("developpeurs","/",d.developpeur_image_nom) AS developpeur_image_url,
			d.id_developpeur, nd.id_article,
		
			CASE WHEN d.developpeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN d.developpeur_image_nom = "" THEN "nok"
			WHEN d.developpeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_developpeur AS d
			
			
			LEFT OUTER JOIN 2015_article_developpeur AS nd
			ON d.id_developpeur = nd.id_developpeur

			WHERE d.id_developpeur = '.mysql_real_escape_string($id_developpeur).'
			AND CONCAT("developpeurs","/",d.developpeur_image_nom) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
			AND CONCAT("developpeurs","/",d.developpeur_image_nom) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")

			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_developpeur']]['url']=$data['developpeur_image_url'];
			$json[$data['id_developpeur']]['alt']=$data['developpeur_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}

else if(isset($_GET['id_developpeur']) && !isset($_GET['id_article'])){
	$id_developpeur = trim(htmlentities(intval($_GET['id_developpeur'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT d.developpeur_image_nom AS developpeur_image,
			d.developpeur_nom,
			CONCAT("developpeurs","/",d.developpeur_image_nom) AS developpeur_image_url,
			d.id_developpeur, nd.id_article,
		
			CASE WHEN d.developpeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN d.developpeur_image_nom = "" THEN "nok"
			WHEN d.developpeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_developpeur AS d
			
			
			LEFT OUTER JOIN 2015_article_developpeur AS nd
			ON d.id_developpeur = nd.id_developpeur

			WHERE d.id_developpeur = '.mysql_real_escape_string($id_developpeur).'
			
			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_developpeur']]['url']=$data['developpeur_image_url'];
			$json[$data['id_developpeur']]['alt']=$data['developpeur_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}
//-------------------developpeur---------------------//


//-------------------editeur---------------------//

else if(isset($_GET['id_editeur']) && isset($_GET['id_article'])){
	$id_editeur = trim(htmlentities(intval($_GET['id_editeur'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));
	$json = array();
	
	$requete = 'SELECT e.editeur_image_nom AS editeur_image,
			e.editeur_nom,
			CONCAT("editeurs","/",e.editeur_image_nom) AS editeur_image_url,
			e.id_editeur, ne.id_article,
		
			CASE WHEN e.editeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN e.editeur_image_nom = "" THEN "nok"
			WHEN e.editeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_editeur AS e
			
			
			LEFT OUTER JOIN 2015_article_editeur AS ne
			ON e.id_editeur = ne.id_editeur

			WHERE e.id_editeur = '.mysql_real_escape_string($id_editeur).'
			AND CONCAT("editeurs","/",e.editeur_image_nom) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
			AND CONCAT("editeurs","/",e.editeur_image_nom) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")

			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_editeur']]['url']=$data['editeur_image_url'];
			$json[$data['id_editeur']]['alt']=$data['editeur_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}


else if(isset($_GET['id_editeur']) && !isset($_GET['id_article'])){
	$id_editeur = trim(htmlentities(intval($_GET['id_editeur'])));
	$id_article = trim(htmlentities(intval($_GET['id_article'])));

	$json = array();
	
	$requete = 'SELECT e.editeur_image_nom AS editeur_image,
			e.editeur_nom,
			CONCAT("editeurs","/",e.editeur_image_nom) AS editeur_image_url,
			e.id_editeur, ne.id_article,
		
			CASE WHEN e.editeur_image_nom = "nopicture.jpg" THEN "nok"
			WHEN e.editeur_image_nom = "" THEN "nok"
			WHEN e.editeur_image_nom IS NULL THEN "nok"
			ELSE "ok" END AS image

			FROM 2015_editeur AS e
			
			
			LEFT OUTER JOIN 2015_article_editeur AS ne
			ON e.id_editeur = ne.id_editeur

			WHERE e.id_editeur = '.mysql_real_escape_string($id_editeur).'
			
			';
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
	
	while($data = mysql_fetch_array($result)){
		if($data['image']=='ok'){
			$json[$data['id_editeur']]['url']=$data['editeur_image_url'];
			$json[$data['id_editeur']]['alt']=$data['editeur_nom'];
		}
	}

	echo json_encode($json);
	mysql_free_result($data);
	mysql_close();
    	
}
//-------------------editeur---------------------//

//-------------------Jeux---------------------//

else if(isset($_GET['operation'])){
	if($_GET['operation']=='getAllJeuImage'&& !isset($_GET['id_article'])){
		
		$id_jeu_version_plateforme = trim(htmlentities(intval($_GET['id_jeu_version_plateforme'])));

		$json = array();
	
		$requete = 'SELECT DISTINCT jvpi.image_nom, j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique,
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

					WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM  2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'")

					ORDER BY p.plateforme_nom_generique';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			$json[$data['id_image']]['url']='jeux/'.$data['jeu_dossier'].'/pictures/'.$data['image_nom'];
			$json[$data['id_image']]['alt']=$data['categorie_image_nom'].'/'.$data['jeu_nom_generique'];
			$json[$data['id_image']]['plateforme']=$data['plateforme_nom_generique'];

		}
		//-------------------------- on recupére toutes les covers---------------------------//

		$requete = 'SELECT DISTINCT jvr.jeu_region_cover,
		j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique, 
		jvp.id_jeu_version_plateforme,
		CONCAT(\'jeux/\',j.jeu_dossier,\'/covers/\',jvr.jeu_region_cover) AS url,
		CONCAT(p.plateforme_nom_generique,\' \',j.jeu_nom_generique) AS alt,
		
		CASE WHEN jvr.jeu_region_cover = "nopicture.jpg" THEN "nok"
			WHEN jvr.jeu_region_cover = "" THEN "nok"
			WHEN jvr.jeu_region_cover IS NULL THEN "nok"
			ELSE "ok" END AS image
					
		FROM 2015_jeu_version_region AS jvr 
		
		LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
		ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme 
		
		LEFT OUTER JOIN 2015_plateforme AS p 
		ON jvp.id_plateforme = p.id_plateforme 
		
		LEFT OUTER JOIN 2015_jeu AS j 
		ON jvp.id_jeu = j.id_jeu 
		
		WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM 2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'") ORDER BY p.plateforme_nom_generique';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			if($data['image']=="ok"){
			$json[$data['url']]['url']=$data['url'];
			$json[$data['url']]['alt']=$data['alt'];
			$json[$data['url']]['plateforme']=$data['plateforme_nom_generique'];
			}
		}
		
		//-------------------------- on recupére toutes les jaquettes---------------------------//

		$requete = 'SELECT DISTINCT jvr.jeu_region_jaquette,
		j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique, 
		jvp.id_jeu_version_plateforme,
		CONCAT(\'jeux/\',j.jeu_dossier,\'/jaquettes/\',jvr.jeu_region_jaquette) AS url,
		CONCAT(p.plateforme_nom_generique,\' \',j.jeu_nom_generique) AS alt,
			
			
		CASE WHEN jvr.jeu_region_jaquette = "nopicture.jpg" THEN "nok"
			WHEN jvr.jeu_region_jaquette = "" THEN "nok"
			WHEN jvr.jeu_region_jaquette IS NULL THEN "nok"
			ELSE "ok" END AS image
					
		FROM 2015_jeu_version_region AS jvr 
		
		LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
		ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme 
		
		LEFT OUTER JOIN 2015_plateforme AS p 
		ON jvp.id_plateforme = p.id_plateforme 
		
		LEFT OUTER JOIN 2015_jeu AS j 
		ON jvp.id_jeu = j.id_jeu 
		
		WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM 2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'") ORDER BY p.plateforme_nom_generique';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			if($data['image']=="ok"){
			$json[$data['url']]['url']=$data['url'];
			$json[$data['url']]['alt']=$data['alt'];
			$json[$data['url']]['plateforme']=$data['plateforme_nom_generique'];
			}
		}
	}
	else if($_GET['operation']=='getAllJeuImage' && isset($_GET['id_article'])){
		
		$id_jeu_version_plateforme = trim(htmlentities(intval($_GET['id_jeu_version_plateforme'])));
		$id_article = trim(htmlentities(intval($_GET['id_article'])));

		$json = array();
	
		$requete = 'SELECT DISTINCT jvpi.image_nom, j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique,
					jvpi.image_titre, jvpi.id_jeu_version_plateforme_image AS id_image, coalesce(ic.categorie_image_nom,"non renseigné") AS categorie_image_nom, jvp.id_jeu_version_plateforme

					FROM 2015_jeu_version_plateforme AS jvp

					LEFT OUTER JOIN  2015_jeu_version_plateforme_image AS jvpi
					ON jvp.id_jeu_version_plateforme = jvpi.id_jeu_version_plateforme
					
					LEFT OUTER JOIN  2015_plateforme AS p
					ON jvp.id_plateforme = p.id_plateforme

					LEFT OUTER JOIN  2015_jeu AS j
					ON jvp.id_jeu = j.id_jeu

					LEFT OUTER JOIN  2015_categorie_image AS ic
					ON ic.id_categorie_image = jvpi.id_categorie_image

					
					LEFT OUTER JOIN 2015_article_jeu_version_plateforme AS njvp
					ON jvp.id_jeu_version_plateforme = njvp.id_jeu_version_plateforme

					WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM  2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'")
					AND CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
					AND CONCAT("jeux","/",j.jeu_dossier,"/pictures/",jvpi.image_nom) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")
					
					
					AND CONCAT("jeux","/",j.jeu_dossier,"/covers/",jvpi.image_nom) NOT IN (SELECT nimg.url_article_image FROM 2015_article_image AS nimg WHERE nimg.id_article = "'.mysql_real_escape_string($id_article).'")
					AND CONCAT("jeux","/",j.jeu_dossier,"/covers/",jvpi.image_nom) NOT IN (SELECT nillu.url_article_illustration FROM 2015_article_illustration AS nillu WHERE nillu.id_article = "'.mysql_real_escape_string($id_article).'")
					



					ORDER BY p.plateforme_nom_generique';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			$json[$data['id_image']]['url']='jeux/'.$data['jeu_dossier'].'/pictures/'.$data['image_nom'];
			$json[$data['id_image']]['alt']=$data['categorie_image_nom'].'/'.$data['jeu_nom_generique'];
			$json[$data['id_image']]['plateforme']=$data['plateforme_nom_generique'];

		}
		//-------------------------- on recupére toutes les covers---------------------------//

		$requete = 'SELECT DISTINCT jvr.jeu_region_cover,
		j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique, 
		jvp.id_jeu_version_plateforme,
		CONCAT(\'jeux/\',j.jeu_dossier,\'/covers/\',jvr.jeu_region_cover) AS url,
		CONCAT(p.plateforme_nom_generique,\' \',j.jeu_nom_generique) AS alt,
		
		CASE WHEN jvr.jeu_region_cover = "nopicture.jpg" THEN "nok"
			WHEN jvr.jeu_region_cover = "" THEN "nok"
			WHEN jvr.jeu_region_cover IS NULL THEN "nok"
			ELSE "ok" END AS image
					
		FROM 2015_jeu_version_region AS jvr 
		
		LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
		ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme 
		
		LEFT OUTER JOIN 2015_plateforme AS p 
		ON jvp.id_plateforme = p.id_plateforme 
		
		LEFT OUTER JOIN 2015_jeu AS j 
		ON jvp.id_jeu = j.id_jeu 
		
		WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM 2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'") 
		AND CONCAT(\'jeux/\',j.jeu_dossier,\'/covers/\',jvr.jeu_region_cover) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
		AND CONCAT(\'jeux/\',j.jeu_dossier,\'/covers/\',jvr.jeu_region_cover) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")

		
		ORDER BY p.plateforme_nom_generique';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			if($data['image']=="ok"){
			$json[$data['url']]['url']=$data['url'];
			$json[$data['url']]['alt']=$data['alt'];
			$json[$data['url']]['plateforme']=$data['plateforme_nom_generique'];
			}
		}
		
		//-------------------------- on recupére toutes les jaquettes---------------------------//

		$requete = 'SELECT DISTINCT jvr.jeu_region_jaquette,
		j.jeu_dossier,j.jeu_nom_generique,p.plateforme_nom_generique, 
		jvp.id_jeu_version_plateforme,
		CONCAT(\'jeux/\',j.jeu_dossier,\'/jaquettes/\',jvr.jeu_region_jaquette) AS url,
		CONCAT(p.plateforme_nom_generique,\' \',j.jeu_nom_generique) AS alt,
			
			
		CASE WHEN jvr.jeu_region_jaquette = "nopicture.jpg" THEN "nok"
			WHEN jvr.jeu_region_jaquette = "" THEN "nok"
			WHEN jvr.jeu_region_jaquette IS NULL THEN "nok"
			ELSE "ok" END AS image
					
		FROM 2015_jeu_version_region AS jvr 
		
		LEFT OUTER JOIN 2015_jeu_version_plateforme AS jvp 
		ON jvp.id_jeu_version_plateforme = jvr.id_jeu_version_plateforme 
		
		LEFT OUTER JOIN 2015_plateforme AS p 
		ON jvp.id_plateforme = p.id_plateforme 
		
		LEFT OUTER JOIN 2015_jeu AS j 
		ON jvp.id_jeu = j.id_jeu 
		
		WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM 2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'") 
		AND CONCAT(\'jeux/\',j.jeu_dossier,\'/jaquettes/\',jvr.jeu_region_jaquette) NOT IN (SELECT nimg.url_news_image FROM 2015_news_image AS nimg WHERE nimg.id_news = "'.mysql_real_escape_string($id_news).'")
		AND CONCAT(\'jeux/\',j.jeu_dossier,\'/jaquettes/\',jvr.jeu_region_jaquette) NOT IN (SELECT nillu.url_news_illustration FROM 2015_news_illustration AS nillu WHERE nillu.id_news = "'.mysql_real_escape_string($id_news).'")

		
		ORDER BY p.plateforme_nom_generique';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			if($data['image']=="ok"){
			$json[$data['url']]['url']=$data['url'];
			$json[$data['url']]['alt']=$data['alt'];
			$json[$data['url']]['plateforme']=$data['plateforme_nom_generique'];
			}
		}
	}
	else if($_GET['operation']=='getAllJeuVideo' && !isset($_GET['id_article'])){
		
		$id_jeu_version_plateforme = trim(htmlentities(intval($_GET['id_jeu_version_plateforme'])));

		$json = array();
	
		$requete = 'SELECT DISTINCT jvpv.video_url, p.plateforme_nom_generique,
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

					WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM  2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'")

					ORDER BY ic.categorie_video_nom';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			parse_str( parse_url( $data['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
			$youtube_id = $my_array_of_vars['v'];
			$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			$json[$data['id_jeu_version_plateforme_video']]['thumbnail']=$src;
			$json[$data['id_jeu_version_plateforme_video']]['titre']=$data['plateforme_nom_generique'].'   '.$data['categorie_video_nom'].'   '.$data['video_titre'];
			$json[$data['id_jeu_version_plateforme_video']]['url']=$data['video_url'];

		}
	}
	else if($_GET['operation']=='getAllJeuVideo' && isset($_GET['id_article'])){
		
		$id_jeu_version_plateforme = trim(htmlentities(intval($_GET['id_jeu_version_plateforme'])));
		$id_article = trim(htmlentities(intval($_GET['id_article'])));

		$json = array();
	
		$requete = 'SELECT DISTINCT jvpv.video_url, p.plateforme_nom_generique,
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

					WHERE jvp.id_jeu = (SELECT jvp.id_jeu FROM  2015_jeu_version_plateforme AS jvp WHERE jvp.id_jeu_version_plateforme = "'.mysql_real_escape_string($id_jeu_version_plateforme).'")
					AND jvpv.video_url NOT IN (SELECT nv.url_article_video FROM 2015_article_video AS nv WHERE nv.id_article = "'.mysql_real_escape_string($id_article).'")

					ORDER BY ic.categorie_video_nom';
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			parse_str( parse_url( $data['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
			$youtube_id = $my_array_of_vars['v'];
			$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			$json[$data['id_jeu_version_plateforme_video']]['thumbnail']=$src;
			$json[$data['id_jeu_version_plateforme_video']]['titre']=$data['plateforme_nom_generique'].' '.$data['categorie_video_nom'].' '.$data['video_titre'];
			$json[$data['id_jeu_version_plateforme_video']]['url']=$data['video_url'];

		}
	}
	else if($_GET['operation']=='getAllJeuVersionPlateforme'){
		
		$id_jeu_version_plateforme = trim(htmlentities(intval($_GET['id_jeu_version_plateforme'])));

		$json = array();
	
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
					
   		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
    	$result = mysql_query($requete) or die(mysql_error());
	
		while($data = mysql_fetch_array($result)){
			$json[$data['id_jeu_version_plateforme']]['plateforme']=$data['plateforme_nom_generique'];
			$json[$data['id_jeu_version_plateforme']]['jeu_nom_generique']=$data['jeu_nom_generique'];

		}
	}
	
		echo json_encode($json);
		mysql_free_result($data);
		mysql_close();
	
    	
}

//-------------------Jeux---------------------//

?>