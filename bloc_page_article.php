<?php
require_once('mysql_files/mysql_fonctions_article.php');
require_once('paginate.php');

function createDivPub(){
return ('<div id="pub" class="bloc_right_bar">
		<p>PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB </p>
		</div>');
}

function createDivArticleWithIdArticle($id_article){
$resultArticle = mysqlSelectArticleById($id_article);
$dataArticle = mysql_fetch_array($resultArticle);
return ('<div id="article" class="bloc_left_bar">
		<h2>'.$dataArticle['article_titre'].'</h2>
		<hr/>
		<p class="byline">par <a href="#">'.$dataArticle['pseudo'].'</a>, '.$dataArticle['article_date_publication'].'</p>
		
		<img class="image_illustration_article" src="'.$dataArticle['url_article_illustration'].'"/>
		'.$dataArticle['article_corps'].'
		</div>');
}
function createDivAllArticleWithPageNumber($page,$nbElementParPage){
if(!isset($page)){
	$page = 1;
}
$toReturn .= '<div id="article_preview" class="bloc_left_bar">';
$nb_element_par_page = 10;
$resultArticle = mysqlSelectArticleWithPageNumber($page,$nb_element_par_page);
while($dataArticle = mysql_fetch_array($resultArticle)){
	$toReturn .= '<div class="article_preview_left_div">';
	$toReturn .= '<a href="articles.php?id_article='.$dataArticle['id_article'].'"><img class="image_illustration_article" src="'.$dataArticle['url_article_illustration'].'"/></a>';
	$toReturn .= '</div>';
	$toReturn .= '<div class="article_preview_right_div">';
	$toReturn .= '<h2><a href="articles.php?id_article='.$dataArticle['id_article'].'">'.$dataArticle['article_titre'].'</a></h2>';
	$toReturn .= '<p class="byline">par <a href="#">'.$dataArticle['pseudo'].'</a>, '.$dataArticle['article_date_publication'].'</p>';

	$toReturn .= '</div>';
	$toReturn .= '<hr class="article_separator"/>';
}

/* ------page------- */
	$resultCountArticles = mysqlCountAllArticles();
	$resultCountArticles = mysql_fetch_array($resultCountArticles);
	$nbElements = $resultCountArticles['count'];
	
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
	

	$toReturn .= paginate('articles.php', '?page=', $nbPages, $current);
	
/* ------page------- */

$toReturn .= '</div>'; 
return $toReturn;
}
?>