<?php
require_once('mysql_files/mysql_fonctions_jeu.php');
require_once('paginate.php');

function createDivPub(){
return ('<div id="pub" class="bloc_right_bar">
		<p>PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB </p>
		</div>');
}

function createDivFicheJeuWithIdJeu($id_jeu_version_plateforme,$jeu_region){
$resultJeuVersionPlateforme = mysqlSelectJeuVersionPlateformeById($id_jeu_version_plateforme,$jeu_region);
$dataJeuVersionPlateforme = mysql_fetch_array($resultJeuVersionPlateforme);

	$toReturn .= '<div id="jeu_preview" class="bloc_left_bar">';
	$toReturn .= '<div class="jeu_preview_left_div">';
	$toReturn .= '<a href="jeux.php?id_jeu_version_plateforme='.$dataJeuVersionPlateforme['id_jeu_version_plateforme'].'&jeu_region='.$dataJeuVersionPlateforme['jeu_region'].'"><img class="image_illustration_jeu" src="'.$dataJeuVersionPlateforme['url'].'"/></a>';
	$toReturn .= '</div>';
	$toReturn .= '<div class="jeu_preview_right_div">';
	$toReturn .= '<h2><a href="jeux.php?id_jeu_version_plateforme='.$dataJeuVersionPlateforme['id_jeu_version_plateforme'].'&jeu_region='.$dataJeuVersionPlateforme['jeu_region'].'">'.$dataJeuVersionPlateforme['jeu_nom_generique'].'</a></h2>';
	$toReturn .= '<ul>';
	$toReturn .= '<li>plateforme:<em> '.$dataJeuVersionPlateforme['plateforme_nom_generique'].'</em></li>';
	$toReturn .= '<li>genre:<em> '.$dataJeuVersionPlateforme['genre_nom'].'</em></li>';
	$toReturn .= '<li>développeur:<em> '.$dataJeuVersionPlateforme['developpeur_nom'].'</em></li>';
	$toReturn .= '<li>éditeur:<em> '.$dataJeuVersionPlateforme['editeur_nom'].'</em></li>';
	$toReturn .= '</ul>';
	$toReturn .= '</div>';
		$toReturn .= '<hr class="fin_bloc"/>';

	$toReturn .= '</div>';
	
return $toReturn;

}

function createDivTestJeu($id_jeu_version_plateforme){
$resultTestJeuVersionPlateforme = mysqlSelectTestJeuVersionPlateforme($id_jeu_version_plateforme);
while($dataTestJeuVersionPlateforme = mysql_fetch_array($resultTestJeuVersionPlateforme)){
if($dataTestJeuVersionPlateforme['test_date_publication'] == "test ok"){
	$toReturn .= '<div id="jeu_preview_test" class="bloc_left_bar">';
	$toReturn .= '<div class="jeu_preview_left_div">';
	$toReturn .= '<div class="note note'.$dataTestJeuVersionPlateforme['test_note'].'"><span>'.$dataTestJeuVersionPlateforme['test_note'].'</span></div>';
	$toReturn .= '</div>';
	$toReturn .= '<div class="jeu_preview_right_div">';
	$toReturn .= '<p>';
	$toReturn .= tronque(strip_tags($dataTestJeuVersionPlateforme['test_corps']),250). ' <a href="tests.php?id_test_jeu_version_plateforme='.$dataTestJeuVersionPlateforme['id_test_jeu_version_plateforme'].'">lire le test</a>';
	$toReturn .= '</p>';
	$toReturn .= '</div>';
		$toReturn .= '<hr class="fin_bloc"/>';

	$toReturn .= '</div>';
}
}	
return $toReturn;

}



function createDivAllJeuWithPageNumber($page,$nbElementParPage){
if(!isset($page)){
	$page = 1;
}
$toReturn .= '<div id="jeu_preview" class="bloc_left_bar">';
$nb_element_par_page = 10;
$resultJeu = mysqlSelectJeuWithPageNumber($page,$nb_element_par_page);
while($dataJeu = mysql_fetch_array($resultJeu)){
	

	$toReturn .= '<div class="jeu_preview_left_div">';
	$toReturn .= '<a href="jeux.php?id_jeu_version_plateforme='.$dataJeu['id_jeu_version_plateforme'].'&jeu_region='.$dataJeu['jeu_region'].'"><img class="image_illustration_jeu" src="'.$dataJeu['url'].'"/></a>';
	$toReturn .= '</div>';
	$toReturn .= '<div class="jeu_preview_right_div">';
	$toReturn .= '<h2><a href="jeux.php?id_jeu_version_plateforme='.$dataJeu['id_jeu_version_plateforme'].'&jeu_region='.$dataJeu['jeu_region'].'">'.$dataJeu['jeu_nom_generique'].'</a></h2>';
	$toReturn .= '<ul>';
	$toReturn .= '<li>plateforme:<em> '.$dataJeu['plateforme_nom_generique'].'</em></li>';
	$toReturn .= '<li>genre:<em> '.$dataJeu['genre_nom'].'</em></li>';
	$toReturn .= '<li>développeur:<em> '.$dataJeu['developpeur_nom'].'</em></li>';
	$toReturn .= '<li>test:<em> ';
	if($dataJeu['test_date_publication'] == "test ok"){
		if($dataJeu['id_test_jeu_version_plateforme'] != "aucun test"){
			$toReturn .= '<a href=tests.php?id_test='.$dataJeu['id_test_jeu_version_plateforme'].'>voir le test</a>';
		}
		else{
			$toReturn .= $dataJeu['id_test_jeu_version_plateforme'];
		}
	}
	else{
		$toReturn .= "aucun test";
	}
	$toReturn .= '</em></li>';
	$toReturn .= '</ul>';
	$toReturn .= '</div>';
	$toReturn .= '<hr class="jeu_separator"/>';
}

/* ------page------- */
	$resultCountJeux = mysqlCountAllJeux();
	$resultCountJeux = mysql_fetch_array($resultCountJeux);
	$nbElements = $resultCountJeux['count'];
	
	$nbPages = ceil($nbElements/$nb_element_par_page); // calcul du nombre de pages $nbPages (on arrondit à l'entier supérieur avec la fonction ceil())

	// Récupération du numéro de la page courante depuis l'URL avec la méthode GET
	// S'il s'agit d'un nombre on traite, sinon on garde la valeur par défaut : 1
	$current = 1;
	if (isset($_GET['page']) && is_numeric($_GET['page'])) {
		$page = intval($_GET['page']);
		if ($page >= 1 && $page <= $nbPages) {
			// cas normal
			$current=$page;
		} else if ($page < 1) {
			// cas où le numéro de page est inférieure 1 : on affecte 1 à la page courante
			$current=1;
		} else {
			//cas où le numéro de page est supérieur au nombre total de pages : on affecte le numéro de la dernière page à la page courante
			$current = $nbPages;
		}
	}
	

	$toReturn .= paginate('jeux.php', '?page=', $nbPages, $current);
	
/* ------page------- */

$toReturn .= '</div>'; 
return $toReturn;
}



function tronque($chaine, $longueur = 500) 
{
 
	if (empty ($chaine)) 
	{ 
		return ""; 
	}
	elseif (strlen ($chaine) < $longueur) 
	{ 
		return $chaine; 
	}
	elseif (preg_match ("/(.{1,$longueur})\s./ms", $chaine, $match)) 
	{ 
		return $match [1] . " [...] "; 
	}
	else 
	{ 
		return substr ($chaine, 0, $longueur) . " [...] "; 
	}
}
?>