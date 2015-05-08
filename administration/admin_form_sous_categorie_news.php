<?php
require_once('mysql_fonctions_sous_categorie_news.php');
require_once('dossiers_ressources.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin sous_categorie_news]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createSousCategorieNewsAddForm(){
	$resultNews = mysqlSelectCategorieNewsByID($_GET['id_categorie_news']);
	$dataNews=mysql_fetch_array($resultNews);
	
	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_news=add&page=1&order=categorie_news_date_modif">catégories news</a></span><span class="to_edit"><a href="administration.php?categorie_news=add&page=1&order=categorie_news_date_modif">'.htmlspecialchars(trim($dataNews["categorie_news_nom"])).'</a></span>ajouter une sous-catégorie</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_sous_categorie_news.php?id_categorie_news='.$_GET['id_categorie_news'].'" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="sous_categorie_news_name">nom: </label>';
	$toReturn .='<input id="sous_categorie_news_name" type="text" name="sous_categorie_news_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="uploadcover">image: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	
	//-----------select constructeur-----------//
	/*$toReturn .='<p><label for="id_categorie_news">famille: </label>';	
	$toReturn .='<select name="id_categorie_news" id="id_categorie_news">';	
	$toReturn .= '<option value="">--- famille ---</option>';
	$result = mysqlSelectAllCategorieNews();
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_news"].'">'.htmlspecialchars(trim($data["categorie_news_nom"])).'</option>';
	}
	$toReturn .='</select></p>';*/
	//-----------select constructeur-----------//
	
	
	
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_sous_categorie_news"/></p>';
	
	

	
	//$toReturn .= '<hr/>';
	//-----------filtre de tri-----------//
	/*$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="sous_categorie_news_date_modif"';
 	if($_GET['order']=="sous_categorie_news_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="sous_categorie_news_date_creation"';
  	if($_GET['order']=="sous_categorie_news_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers créés</option>'; 
 	$toReturn .= '<option value="sous_categorie_news_nom"';
 	if($_GET['order']=="sous_categorie_news_nom"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par nom</option>';
 	
	$toReturn .= '</select></p>';*/
	//-----------filtre de tri-----------//
	$nb_element_par_page=10;
	// ------les dev les uns aux dessus des autres------- //
	/*$result = mysqlSelectAllSousCategorieNews();
	while($data=mysql_fetch_array($result)) {
   		$toReturn .='<fieldset class="fieldset_sous_categorie_news">';
		$toReturn .= '<div class="leftdiv"><p><img src="'.dossier_categories_news().'/'.htmlspecialchars(trim($data["sous_categorie_news_logo"])).'" alt="logo '.htmlspecialchars(trim($data["sous_categorie_news_nom"])).'" /><p></div>';
		$toReturn .= '<div class="rightdiv">';
		$toReturn .= '<ul><li>nom: <span class="resultat">'.htmlspecialchars(trim($data["sous_categorie_news_nom"])).'</span></li></ul>';
		$toReturn .= '</div>';
		$toReturn .='<div class="div_buttons">';
		$toReturn .='<a class="style_button" href="administration.php?sous_categorie_news=edit&id_sous_categorie_news='.htmlspecialchars(trim($data["id_sous_categorie_news"])).'">modifier ce categorie news</a>';

		$toReturn .='<a class="style_button" href="admin_traitement_sous_categorie_news.php?submit_sous_categorie_news=delete&id_sous_categorie_news='.htmlspecialchars(trim($data["id_sous_categorie_news"])).'">supprimer ce categorie news</a>';
		$toReturn .='</div>';
		$toReturn .='</fieldset>';
	}*/
	// ------les dev les uns aux dessus des autres------- //

	// ------page------- //
	/*$resultDev = mysqlSelectAllSousCategorieNews();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?sous_categorie_news=add&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
	}
	$toReturn .='<select name="page" class="page_selector">';
	for($i = 1; $i <= ceil($nbElements/$nb_element_par_page); $i++){
		$toReturn .= '<option value="'.$i.'"';
		if($i == $_GET['page']){
			$toReturn .= 'selected="selected"';
		}
		$toReturn .= '>'.$i.'</option>';
	}
	$toReturn .='</select>';
	if($_GET['page']!=ceil($nbElements/$nb_element_par_page)){
		$toReturn .= '<a href="administration.php?sous_categorie_news=add&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}*/
	// ------page------- //
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="sous_categorie_news"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}

function createSousCategorieNewsEditForm(){
		$result = mysqlSelectSousCategorieNewsByID($_GET['id_sous_categorie_news']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_news=add">'.htmlspecialchars(trim($data["categorie_news_nom"])).'</a></span>
		<span class="to_edit"><a href="administration.php?categorie_news=add">'.htmlspecialchars(trim($data["sous_categorie_news_nom"])).'</a></span>
		modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_sous_categorie_news.php?&id_sous_categorie_news='.htmlspecialchars(trim($data["id_sous_categorie_news"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="sous_categorie_news_name">nom: </label>';
		$toReturn .='<input id="sous_categorie_news_name" type="text" name="sous_categorie_news_name" value="'.htmlspecialchars(trim($data["sous_categorie_news_nom"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		if(htmlspecialchars(trim($data["sous_categorie_news_logo"])) == "nopicture.jpg"){
		$toReturn .='</p><p><label for="upload_logo">image: </label>';
		$toReturn .='<input id="upload_logo" type="file" name="image" class="img" /></p>';
		}
		else{ 
		$toReturn .='<p><label for="img_logo">logo actuel: </label>';
		$toReturn .='<img src="'.dossier_categories_news().'/'.htmlspecialchars(trim($data["sous_categorie_news_logo"])).'" alt="'.htmlspecialchars(trim($data["sous_categorie_news_logo"])).'" />';
		
		$toReturn .='<a class="style_button img_delete"  href="admin_traitement_sous_categorie_news.php?submit_sous_categorie_news=delete_sous_categorie_news_logo&id_sous_categorie_news='.$_GET['id_sous_categorie_news'].'">supprimer logo</a></p>';
		}
		
		
		$toReturn .='<p><label for="id_categorie_news">famille: </label>';	
		$toReturn .='<select name="id_categorie_news" id="id_categorie_news">';	
		$toReturn .= '<option value="">--- famille ---</option>';
		$result2 = mysqlSelectAllCategorieNews();
		
		while($data2=mysql_fetch_array($result2)) {
   			$toReturn .= '<option value="'.htmlspecialchars(trim($data2["id_categorie_news"])).'"';
   			
   			if(htmlspecialchars(trim($data["id_categorie_news"]))==htmlspecialchars(trim($data2["id_categorie_news"]))){
   			$toReturn .= 'selected="selected"';
   			}
   			$toReturn .='>'.htmlspecialchars(trim($data2["categorie_news_nom"])).'';
   			
   			$toReturn .= '</option>';
		}
		$toReturn .='</select></p>';
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_sous_categorie_news"/></p>';
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="sous_categorie_news"/>';
		$toReturn .= '</form">';
		return $toReturn;
}
