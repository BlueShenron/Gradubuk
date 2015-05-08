<?php
require_once('mysql_fonctions_frontpage_test.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin frontpage]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//


function createFrontpageTestAddForm(){

	$resultTest = mysqlSelectTestByID($_GET["id_test"]);
	$dataTest = mysql_fetch_array($resultTest);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?test=gestion&page=1&order=test_date_modif">test</span></a><span class="to_edit"><a href="#">frontpage</span></a>créer</h3>';
	$toReturn .='<form action="admin_traitement_frontpage_test.php?id_test='.$_GET["id_test"].'" method="post" enctype="multipart/form-data">';
	
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
	$toReturn .='<input id="frontpage_titre" type="text" name="frontpage_titre" value="'.htmlspecialchars($dataTest['test_titre']).'"/>';
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
	$toReturn .='<p><input id="submit" type="submit" value="créer" name="submit_frontpage_test"/></p>';
	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="test"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .= '</form>';

	return $toReturn;
}
	
	
	
function createFrontpageTestEditForm(){
	$resultFrontpage = mysqlSelectFrontpageByID($_GET["id_frontpage"]);
	$dataFrontpage = mysql_fetch_array($resultFrontpage);
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?test=gestion&page=1&order=test_date_modif">test</span></a><span class="to_edit"><a href="#">frontpage</span></a>modifier</h3>';
	$toReturn .='<form action="admin_traitement_frontpage_test.php?id_test='.$_GET["id_test"].'&id_frontpage='.$_GET["id_frontpage"].'" method="post" enctype="multipart/form-data">';
	
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
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_frontpage_test"/></p>';
	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="test"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .= '</form>';
	return $toReturn;
}
	


?>