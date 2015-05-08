<?php
require_once('mysql_files/mysql_fonctions_test.php');
require_once('paginate.php');

function createDivPub(){
return ('<div id="pub" class="bloc_right_bar">
		<p>PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB </p>
		</div>');
}

function createDivTestWithIdTest($id_test){
$resultTest = mysqlSelectTestById($id_test);
$dataTest = mysql_fetch_array($resultTest);
return ('<div id="test" class="bloc_left_bar">
		<h2>'.$dataTest['test_titre'].'</h2>
		<hr/>
		<p class="byline">par <a href="#">'.$dataTest['pseudo'].'</a>, '.$dataTest['test_date_publication'].'</p>
		
		<img class="image_illustration_test" src="'.$dataTest['url_test_jeu_version_plateforme_illustration'].'"/>
		'.$dataTest['test_corps'].'
		</div>');
}
function createDivAllTestWithPageNumber($page,$nbElementParPage){
if(!isset($page)){
	$page = 1;
}
$toReturn .= '<div id="test_preview" class="bloc_left_bar">';
$nb_element_par_page = 10;
$resultTest = mysqlSelectTestWithPageNumber($page,$nb_element_par_page);
while($dataTest = mysql_fetch_array($resultTest)){
	$toReturn .= '<div class="test_preview_left_div">';
	$toReturn .= '<a href="tests.php?id_test='.$dataTest['id_test'].'"><img class="image_illustration_test" src="'.$dataTest['url_test_jeu_version_plateforme_illustration'].'"/></a>';
	$toReturn .= '</div>';
	$toReturn .= '<div class="test_preview_right_div">';
	$toReturn .= '<h2><a href="tests.php?id_test='.$dataTest['id_test'].'">'.$dataTest['test_titre'].'</a></h2>';
	$toReturn .= '<p class="byline">par <a href="#">'.$dataTest['pseudo'].'</a>, '.$dataTest['test_date_publication'].'</p>';

	$toReturn .= '</div>';
	$toReturn .= '<hr class="test_separator"/>';
}

/* ------page------- */
	$resultCountTests = mysqlCountAllTests();
	$resultCountTests = mysql_fetch_array($resultCountTests);
	$nbElements = $resultCountTests['count'];
	
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
	

	$toReturn .= paginate('tests.php', '?page=', $nbPages, $current);
	
/* ------page------- */

$toReturn .= '</div>'; 
return $toReturn;
}
?>