<?php
require_once('mysql_files/mysql_fonctions_news.php');
require_once('paginate.php');

function createDivPub(){
return ('<div id="pub" class="bloc_right_bar">
		<p>PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB </p>
		</div>');
}

function createDivNewsWithIdNews($id_news){
$resultNews = mysqlSelectNewsById($id_news);
$dataNews = mysql_fetch_array($resultNews);
return ('<div id="news" class="bloc_left_bar">
		<h2>'.$dataNews['news_titre'].'</h2>
		<hr/>
		<p class="byline">par <a href="#">'.$dataNews['pseudo'].'</a>, '.$dataNews['news_date_publication'].'</p>
		
		<img class="image_illustration_news" src="'.$dataNews['url_news_illustration'].'"/>
		'.$dataNews['news_corps'].'
		</div>');
}
function createDivAllNewsWithPageNumber($page,$nbElementParPage){
if(!isset($page)){
	$page = 1;
}
$toReturn .= '<div id="news_preview" class="bloc_left_bar">';
$nb_element_par_page = 10;
$resultNews = mysqlSelectNewsWithPageNumber($page,$nb_element_par_page);
while($dataNews = mysql_fetch_array($resultNews)){
	$toReturn .= '<div class="news_preview_left_div">';
	$toReturn .= '<a href="news.php?id_news='.$dataNews['id_news'].'"><img class="image_illustration_news" src="'.$dataNews['url_news_illustration'].'"/></a>';
	$toReturn .= '</div>';
	$toReturn .= '<div class="news_preview_right_div">';
	$toReturn .= '<h2><a href="news.php?id_news='.$dataNews['id_news'].'">'.$dataNews['news_titre'].'</a></h2>';
	$toReturn .= '<p class="byline">par <a href="#">'.$dataNews['pseudo'].'</a>, '.$dataNews['news_date_publication'].'</p>';

	$toReturn .= '</div>';
	$toReturn .= '<hr class="news_separator"/>';
}

/* ------page------- */
	$resultCountNews = mysqlCountAllNews();
	$resultCountNews = mysql_fetch_array($resultCountNews);
	$nbElements = $resultCountNews['count'];
	
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
	

	$toReturn .= paginate('news.php', '?page=', $nbPages, $current);
	
/* ------page------- */

$toReturn .= '</div>'; 
return $toReturn;
}
?>