<?php
require_once('mysql_fonctions_frontpage_article.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin frontpage]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//


function createFrontpageArticleAddForm(){
	
	$resultArticle = mysqlSelectArticleByID($_GET["id_article"]);
	$dataArticle = mysql_fetch_array($resultArticle);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">article</span></a><span class="to_edit"><a href="#">frontpage</span></a>créer</h3>';
	$toReturn .='<form action="admin_traitement_frontpage_article.php?id_article='.$_GET["id_article"].'" method="post" enctype="multipart/form-data">';
	
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
	$toReturn .='<input id="frontpage_titre" type="text" name="frontpage_titre" value="'.htmlspecialchars($dataArticle['article_titre']).'"/>';
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
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
	
	$toReturn .= '</form>';

	return $toReturn;
}
	
	
	
function createFrontpageArticleEditForm(){
	$resultFrontpage = mysqlSelectFrontpageByID($_GET["id_frontpage"]);
	$dataFrontpage = mysql_fetch_array($resultFrontpage);
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">article</span></a><span class="to_edit"><a href="#">frontpage</span></a>modifier</h3>';
	$toReturn .='<form action="admin_traitement_frontpage_article.php?id_article='.$_GET["id_article"].'&id_frontpage='.$_GET["id_frontpage"].'" method="post" enctype="multipart/form-data">';
	
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
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
	
	$toReturn .= '</form>';
	return $toReturn;
}
	


?>