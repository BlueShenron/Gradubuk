<?php
require_once('mysql_fonctions_partenaire.php');
require_once('dossiers_ressources.php');

/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin partenaire]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createPartenaireGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?partenaire=gestion&page=1&order=partenaire_date_modif">Partenaires</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_partenaire.php" method="post" enctype="multipart/form-data">';

	/*$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="partenaire_name">nom: </label>';
	$toReturn .='<input id="partenaire_name" type="text" name="partenaire_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	$toReturn .='<p>';
    $toReturn .='<label for="partenaire_url">url: </label>';
	$toReturn .='<input id="partenaire_url" type="text" name="partenaire_url"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';*/
	
	$toReturn .= '<hr/>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter un partenaire" name="submit_partenaire"/></p>';
	
	$toReturn .= '<hr/>';
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="partenaire_date_modif"';
 	if($_GET['order']=="partenaire_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="partenaire_date_creation"';
  	if($_GET['order']=="partenaire_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers créés</option>'; 
 	$toReturn .= '<option value="partenaire_nom"';
 	if($_GET['order']=="partenaire_nom"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par nom</option>';
 	
	$toReturn .= '</select></p>';
	//-----------filtre de tri-----------//
	$nb_element_par_page=10;
	// ------les dev les uns aux dessus des autres------- //
	$result = mysqlSelectAllPartenairesWithPageNumber($_GET['page'],$_GET['order'],$nb_element_par_page);
	$toReturn .='<fieldset>';
	$toReturn .='<table>';
	$toReturn .='<tr>';
    $toReturn .='<th></th>';
    $toReturn .='<th></th>';
   	$toReturn .='<th>logo</th>';
    $toReturn .='<th>partenaire</th>';
    $toReturn .='<th>url</th>';
    $toReturn .='<th>url test</th>';
    $toReturn .='</tr>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_partenaire.php?submit_partenaire=delete&id_partenaire='.htmlspecialchars(trim($data["id_partenaire"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?partenaire=edit&id_partenaire='.htmlspecialchars(trim($data["id_partenaire"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td class="cell_image_categorie_news"><img  class="image_categorie_news" src="'.dossier_partenaires().'/'.htmlspecialchars(trim($data["partenaire_logo"])).'" alt="logo '.htmlspecialchars(trim($data["partenaire_nom"])).'" /></td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["partenaire_nom"])).'</td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["partenaire_url"])).'</td>';
   		$toReturn .= '<td><a href="'.htmlspecialchars(trim($data["partenaire_url"])).'"  target="_blank">'.htmlspecialchars(trim($data["partenaire_nom"])).'</a></td>';
   		 $toReturn .='</tr>';
   		/*$toReturn .='<fieldset class="fieldset_partenaire">';
		$toReturn .= '<div class="leftdiv"><p><img src="'.dossier_partenaires().'/'.htmlspecialchars(trim($data["partenaire_logo"])).'" alt="logo '.htmlspecialchars(trim($data["partenaire_nom"])).'" /><p></div>';
		$toReturn .= '<div class="rightdiv">';
		$toReturn .= '<ul><li>nom: <span class="resultat">'.htmlspecialchars(trim($data["partenaire_nom"])).'</span></li>';
		$toReturn .= '<li>url: <span class="resultat">'.htmlspecialchars(trim($data["partenaire_url"])).'</span></li>';
		$toReturn .= '<li><a href="'.htmlspecialchars(trim($data["partenaire_url"])).'"  target="_blank">test url</a></li>';

		$toReturn .= '</ul>';
		$toReturn .= '</div>';
		$toReturn .='<div class="div_buttons">';
		$toReturn .='<a class="style_button" href="administration.php?partenaire=edit&id_partenaire='.htmlspecialchars(trim($data["id_partenaire"])).'">modifier ce Partenaire</a>';

		$toReturn .='<a class="style_button" href="admin_traitement_partenaire.php?submit_partenaire=delete&id_partenaire='.htmlspecialchars(trim($data["id_partenaire"])).'">supprimer ce Partenaire</a>';
		$toReturn .='</div>';
		$toReturn .='</fieldset>';*/
	}
	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	/* ------page------- */
	$resultDev = mysqlSelectAllPartenaires();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?partenaire=add&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?partenaire=add&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	/* ------page------- */
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="partenaire"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createPartenaireAddForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?partenaire=gestion&page=1&order=partenaire_date_modif">Partenaires</a></span>ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_partenaire.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="partenaire_name">nom: </label>';
	$toReturn .='<input id="partenaire_name" type="text" name="partenaire_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	$toReturn .='<p>';
    $toReturn .='<label for="partenaire_url">url: </label>';
	$toReturn .='<input id="partenaire_url" type="text" name="partenaire_url"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';
	
	
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_partenaire"/></p>';
	
	

	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="partenaire"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createPartenaireEditForm(){
		$result = mysqlSelectPartenaireByID($_GET['id_partenaire']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?partenaire=gestion&page=1&order=partenaire_date_modif">Partenaires</a></span><span class="to_edit"><a href="administration.php?partenaire=edit&id_partenaire='.htmlspecialchars(trim($data["id_partenaire"])).'">'.htmlspecialchars(trim($data["partenaire_nom"])).'</a></span>modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_partenaire.php?&id_partenaire='.htmlspecialchars(trim($data["id_partenaire"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="partenaire_name">nom: </label>';
		$toReturn .='<input id="partenaire_name" type="text" name="partenaire_name" value="'.htmlspecialchars(trim($data["partenaire_nom"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		
		$toReturn .='<p>';
  		  $toReturn .='<label for="partenaire_url">url: </label>';
			$toReturn .='<input id="partenaire_url" type="text" name="partenaire_url" value="'.htmlspecialchars(trim($data["partenaire_url"])).'"/>';
		$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
		if(htmlspecialchars(trim($data["partenaire_logo"])) == "nopicture.jpg"){
		$toReturn .='</p><p><label for="upload_logo">logo: </label>';
		$toReturn .='<input id="upload_logo" type="file" name="image" class="img" /></p>';
		}
		else{ 
		$toReturn .='<p><label for="img_logo">logo actuel: </label>';
		$toReturn .='<img src="'.dossier_partenaires().'/'.htmlspecialchars(trim($data["partenaire_logo"])).'" alt="'.htmlspecialchars(trim($data["partenaire_logo"])).'" />';
		
		$toReturn .='<a class="style_button img_delete"  href="admin_traitement_partenaire.php?submit_partenaire=delete_partenaire_logo&id_partenaire='.$_GET['id_partenaire'].'">supprimer logo</a></p>';
		}
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_partenaire"/></p>';
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="partenaire"/>';
		$toReturn .= '</form">';
		return $toReturn;
}
