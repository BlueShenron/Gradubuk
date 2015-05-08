<?php
require_once('mysql_fonctions_categorie_image.php');


/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin categorie_image]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createCategorieImageGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_image=gestion&page=1&order=categorie_image_date_modif">catégories images</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_categorie_image.php" method="post" enctype="multipart/form-data">';

	/*$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="categorie_image_name">nom: </label>';
	$toReturn .='<input id="categorie_image_name" type="text" name="categorie_image_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_categorie_image"/></p>';
	*/
	$toReturn .= '<hr/>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter une catégorie" name="submit_categorie_image"/></p>';
	$toReturn .= '<hr/>';
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="categorie_image_date_modif"';
 	if($_GET['order']=="categorie_image_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="categorie_image_date_creation"';
  	if($_GET['order']=="categorie_image_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers créés</option>'; 
 	$toReturn .= '<option value="categorie_image_nom"';
 	if($_GET['order']=="categorie_image_nom"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par nom</option>';
 	
	$toReturn .= '</select></p>';
	//-----------filtre de tri-----------//
	$nb_element_par_page=50;
	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='<fieldset>';
	$toReturn .='<table>';
	$toReturn .='<tr>';
    $toReturn .='<th></th>';
    $toReturn .='<th></th>';
   
    $toReturn .='<th>catégorie images</th>';
    $toReturn .='</tr>';
	$result = mysqlSelectAllCategorieImagesWithPageNumber($_GET['page'],$_GET['order'],$nb_element_par_page);
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_categorie_image.php?submit_categorie_image=delete&id_categorie_image='.htmlspecialchars(trim($data["id_categorie_image"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?categorie_image=edit&id_categorie_image='.htmlspecialchars(trim($data["id_categorie_image"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["categorie_image_nom"])).'</td>';
   		 $toReturn .='</tr>';
   		/*$toReturn .='<fieldset class="fieldset_categorie_image">';
		$toReturn .= '<div class="leftdiv"><p><img src="'.dossier_categorie_images().'/'.htmlspecialchars(trim($data["categorie_image_logo"])).'" alt="logo '.htmlspecialchars(trim($data["categorie_image_nom"])).'" /><p></div>';
		$toReturn .= '<div class="rightdiv">';
		$toReturn .= '<ul><li>nom: <span class="resultat">'.htmlspecialchars(trim($data["categorie_image_nom"])).'</span></li></ul>';
		$toReturn .= '</div>';
		$toReturn .='<div class="div_buttons">';
		$toReturn .='<a class="style_button" href="administration.php?categorie_image=edit&id_categorie_image='.htmlspecialchars(trim($data["id_categorie_image"])).'">modifier ce categorie_image</a>';

		$toReturn .='<a class="style_button" href="admin_traitement_categorie_image.php?submit_categorie_image=delete&id_categorie_image='.htmlspecialchars(trim($data["id_categorie_image"])).'">supprimer ce categorie_image</a>';
		$toReturn .='</div>';
		$toReturn .='</fieldset>';*/
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------les dev les uns aux dessus des autres------- //

	/* ------page------- */
	$resultDev = mysqlSelectAllCategorieImages();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?categorie_image=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?categorie_image=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	/* ------page------- */
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="categorie_image"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createCategorieImageAddForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_image=gestion&page=1&order=categorie_image_date_modif">catégories images</a></span>ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_categorie_image.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="categorie_image_name">catégorie: </label>';
	$toReturn .='<input id="categorie_image_name" type="text" name="categorie_image_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_categorie_image"/></p>';
	
	
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="categorie_image"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}

function createCategorieImageEditForm(){
		$result = mysqlSelectCategorieImageByID($_GET['id_categorie_image']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_image=gestion&page=1&order=categorie_image_date_modif">catégories image</a></span><span class="to_edit"><a href="administration.php?categorie_image=edit&id_categorie_image='.htmlspecialchars(trim($data["id_categorie_image"])).'">'.htmlspecialchars(trim($data["categorie_image_nom"])).'</a></span>modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_categorie_image.php?&id_categorie_image='.htmlspecialchars(trim($data["id_categorie_image"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="categorie_image_name">catégorie: </label>';
		$toReturn .='<input id="categorie_image_name" type="text" name="categorie_image_name" value="'.htmlspecialchars(trim($data["categorie_image_nom"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_categorie_image"/></p>';
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="categorie_image"/>';
		$toReturn .= '</form">';
		return $toReturn;
}
