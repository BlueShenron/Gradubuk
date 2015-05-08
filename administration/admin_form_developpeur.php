<?php
require_once('mysql_fonctions_developpeur.php');
require_once('dossiers_ressources.php');

/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin developpeur]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createDeveloppeurGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?developpeur=gestion&page=1&order=developpeur_date_modif">développeurs</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_developpeur.php" method="post" enctype="multipart/form-data">';

	/*$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="developpeur_name">nom: </label>';
	$toReturn .='<input id="developpeur_name" type="text" name="developpeur_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_developpeur"/></p>';
	*/
	$toReturn .= '<hr/>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter un développeur" name="submit_developpeur"/></p>';
	$toReturn .= '<hr/>';
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="developpeur_date_modif"';
 	if($_GET['order']=="developpeur_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="developpeur_date_creation"';
  	if($_GET['order']=="developpeur_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers créés</option>'; 
 	$toReturn .= '<option value="developpeur_nom"';
 	if($_GET['order']=="developpeur_nom"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par nom</option>';
 	
	$toReturn .= '</select></p>';
	//-----------filtre de tri-----------//
	$nb_element_par_page=20;
	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='<fieldset>';
	$toReturn .='<table>';
	$toReturn .='<tr>';
    $toReturn .='<th></th>';
    $toReturn .='<th></th>';
    $toReturn .='<th>logo</th>';
    $toReturn .='<th>développeur</th>';
    $toReturn .='</tr>';
	$result = mysqlSelectAllDeveloppeursWithPageNumber($_GET['page'],$_GET['order'],$nb_element_par_page);
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_developpeur.php?submit_developpeur=delete&id_developpeur='.htmlspecialchars(trim($data["id_developpeur"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?developpeur=edit&id_developpeur='.htmlspecialchars(trim($data["id_developpeur"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td class="cell_image_categorie_news"><img class="image_categorie_news" src="'.dossier_developpeurs().'/'.htmlspecialchars(trim($data["developpeur_logo"])).'" alt="logo '.htmlspecialchars(trim($data["developpeur_nom"])).'" /></td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["developpeur_nom"])).'</td>';
   		 $toReturn .='</tr>';
   		/*$toReturn .='<fieldset class="fieldset_developpeur">';
		$toReturn .= '<div class="leftdiv"><p><img src="'.dossier_developpeurs().'/'.htmlspecialchars(trim($data["developpeur_logo"])).'" alt="logo '.htmlspecialchars(trim($data["developpeur_nom"])).'" /><p></div>';
		$toReturn .= '<div class="rightdiv">';
		$toReturn .= '<ul><li>nom: <span class="resultat">'.htmlspecialchars(trim($data["developpeur_nom"])).'</span></li></ul>';
		$toReturn .= '</div>';
		$toReturn .='<div class="div_buttons">';
		$toReturn .='<a class="style_button" href="administration.php?developpeur=edit&id_developpeur='.htmlspecialchars(trim($data["id_developpeur"])).'">modifier ce développeur</a>';

		$toReturn .='<a class="style_button" href="admin_traitement_developpeur.php?submit_developpeur=delete&id_developpeur='.htmlspecialchars(trim($data["id_developpeur"])).'">supprimer ce développeur</a>';
		$toReturn .='</div>';
		$toReturn .='</fieldset>';*/
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------les dev les uns aux dessus des autres------- //

	/* ------page------- */
	$resultDev = mysqlSelectAllDeveloppeurs();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?developpeur=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?developpeur=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	/* ------page------- */
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="developpeur"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createDeveloppeurAddForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?developpeur=gestion&page=1&order=developpeur_date_modif">développeurs</a></span>ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_developpeur.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="developpeur_name">nom: </label>';
	$toReturn .='<input id="developpeur_name" type="text" name="developpeur_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_developpeur"/></p>';
	
	
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="developpeur"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}

function createDeveloppeurEditForm(){
		$result = mysqlSelectDeveloppeurByID($_GET['id_developpeur']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?developpeur=gestion&page=1&order=developpeur_date_modif">développeurs</a></span><span class="to_edit"><a href="administration.php?developpeur=edit&id_developpeur='.htmlspecialchars(trim($data["id_developpeur"])).'">'.htmlspecialchars(trim($data["developpeur_nom"])).'</a></span>modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_developpeur.php?&id_developpeur='.htmlspecialchars(trim($data["id_developpeur"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="developpeur_name">nom: </label>';
		$toReturn .='<input id="developpeur_name" type="text" name="developpeur_name" value="'.htmlspecialchars(trim($data["developpeur_nom"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		if(htmlspecialchars(trim($data["developpeur_logo"])) == "nopicture.jpg"){
		$toReturn .='</p><p><label for="upload_logo">logo: </label>';
		$toReturn .='<input id="upload_logo" type="file" name="image" class="img" /></p>';
		}
		else{ 
		$toReturn .='<p><label for="img_logo">logo actuel: </label>';
		$toReturn .='<img src="'.dossier_developpeurs().'/'.htmlspecialchars(trim($data["developpeur_logo"])).'" alt="'.htmlspecialchars(trim($data["developpeur_logo"])).'" />';
		
		$toReturn .='<a class="style_button img_delete"  href="admin_traitement_developpeur.php?submit_developpeur=delete_developpeur_logo&id_developpeur='.$_GET['id_developpeur'].'">supprimer logo</a></p>';
		}
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_developpeur"/></p>';
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="developpeur"/>';
		$toReturn .= '</form">';
		return $toReturn;
}
