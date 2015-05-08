<?php
require_once('mysql_fonctions_frontpage_news.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin frontpage]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//


function createFrontpageNewsAddForm(){
	
	$resultNews = mysqlSelectNewsByID($_GET["id_news"]);
	$dataNews = mysql_fetch_array($resultNews);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a><span class="to_edit"><a href="#">frontpage</span></a>créer</h3>';
	$toReturn .='<form action="admin_traitement_frontpage_news.php?id_news='.$_GET["id_news"].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	$toReturn .='<fieldset>';
	//---------------------//
	$toReturn .='<p>';
    $toReturn .='<label for="frontpage_titre">titre: </label>';
	$toReturn .='<input id="frontpage_titre" type="text" name="frontpage_titre" value="'.htmlspecialchars($dataNews['news_titre']).'"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	//---------------------//
	//---------------------//
	$toReturn .='<p>';
    $toReturn .='<label for="frontpage_sous_titre">sous titre: </label>';
	$toReturn .='<input id="frontpage_sous_titre" type="text" name="frontpage_sous_titre"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	//---------------------//
	//$toReturn .='<p><label for="image_frontpage">image frontpage: </label>';
	//$toReturn .='<input id="image_frontpage" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span><span class="obligatoire"><span>obligatoire</span></span></p>';
	//---------------------//
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="créer" name="submit_frontpage"/></p>';
	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
	
	$toReturn .= '</form>';

	return $toReturn;
}
	
	
	
function createFrontpageNewsEditForm(){
	$resultFrontpage = mysqlSelectFrontpageByID($_GET["id_frontpage"]);
	$dataFrontpage = mysql_fetch_array($resultFrontpage);
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a><span class="to_edit"><a href="#">frontpage</span></a>modifier</h3>';
	$toReturn .='<form action="admin_traitement_frontpage_news.php?id_news='.$_GET["id_news"].'&id_frontpage='.$_GET["id_frontpage"].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	$toReturn .='<fieldset>';
	//---------------------//
	$toReturn .='<p>';
    $toReturn .='<label for="frontpage_titre">titre: </label>';
	$toReturn .='<input id="frontpage_titre" type="text" name="frontpage_titre" value="'.htmlspecialchars($dataFrontpage['frontpage_titre']).'"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	//---------------------//
	//---------------------//
	$toReturn .='<p>';
    $toReturn .='<label for="frontpage_sous_titre">sous titre: </label>';
	$toReturn .='<input id="frontpage_sous_titre" type="text" name="frontpage_sous_titre" value="'.htmlspecialchars($dataFrontpage['frontpage_sous_titre']).'"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	//---------------------//
	//$toReturn .='<p><label for="image_actuelle">image actuelle: </label>';
	//$toReturn .='<img src="'.dossier_frontpages().'/'.htmlspecialchars(trim($dataFrontpage["frontpage_image_nom"])).'" alt="'.htmlspecialchars(trim($dataFrontpage["frontpage_titre"])).'" />';
	//---------------------//
	//$toReturn .='<p><label for="image_frontpage">nouvelle image: </label>';
	//$toReturn .='<input id="image_frontpage" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p>';
	//---------------------//
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_frontpage"/></p>';
	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
	
	$toReturn .= '</form>';
	return $toReturn;
}
	


?>