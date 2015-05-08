<?php
require_once('mysql_fonctions_constructeur.php');
require_once('dossiers_ressources.php');

/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin constructeur]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createConstructeurGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?constructeur=gestion&page=1&order=constructeur_date_modif">constructeurs</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_constructeur.php" method="post" enctype="multipart/form-data">';

	/*$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="constructeur_name">nom: </label>';
	$toReturn .='<input id="constructeur_name" type="text" name="constructeur_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_constructeur"/></p>';
	*/
	$toReturn .= '<hr/>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter un constructeur" name="submit_constructeur"/></p>';
	$toReturn .= '<hr/>';
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="constructeur_date_modif"';
 	if($_GET['order']=="constructeur_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="constructeur_date_creation"';
  	if($_GET['order']=="constructeur_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers créés</option>'; 
 	$toReturn .= '<option value="constructeur_nom"';
 	if($_GET['order']=="constructeur_nom"){
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
    $toReturn .='<th>constructeur</th>';
    $toReturn .='</tr>';
	$result = mysqlSelectAllConstructeursWithPageNumber($_GET['page'],$_GET['order'],$nb_element_par_page);
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_constructeur.php?submit_constructeur=delete&id_constructeur='.htmlspecialchars(trim($data["id_constructeur"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?constructeur=edit&id_constructeur='.htmlspecialchars(trim($data["id_constructeur"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td class="cell_image_categorie_news"><img class="image_categorie_news" src="'.dossier_constructeurs().'/'.htmlspecialchars(trim($data["constructeur_logo"])).'" alt="logo '.htmlspecialchars(trim($data["constructeur_nom"])).'" /></td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["constructeur_nom"])).'</td>';
   		 $toReturn .='</tr>';
   		/*$toReturn .='<fieldset class="fieldset_constructeur">';
		$toReturn .= '<div class="leftdiv"><p><img src="'.dossier_constructeurs().'/'.htmlspecialchars(trim($data["constructeur_logo"])).'" alt="logo '.htmlspecialchars(trim($data["constructeur_nom"])).'" /><p></div>';
		$toReturn .= '<div class="rightdiv">';
		$toReturn .= '<ul><li>nom: <span class="resultat">'.htmlspecialchars(trim($data["constructeur_nom"])).'</span></li></ul>';
		$toReturn .= '</div>';
		$toReturn .='<div class="div_buttons">';
		$toReturn .='<a class="style_button" href="administration.php?constructeur=edit&id_constructeur='.htmlspecialchars(trim($data["id_constructeur"])).'">modifier ce constructeur</a>';

		$toReturn .='<a class="style_button" href="admin_traitement_constructeur.php?submit_constructeur=delete&id_constructeur='.htmlspecialchars(trim($data["id_constructeur"])).'">supprimer ce constructeur</a>';
		$toReturn .='</div>';
		$toReturn .='</fieldset>';*/
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------les dev les uns aux dessus des autres------- //

	/* ------page------- */
	$resultDev = mysqlSelectAllConstructeurs();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?constructeur=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?constructeur=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	/* ------page------- */
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="constructeur"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createConstructeurAddForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?constructeur=gestion&page=1&order=constructeur_date_modif">constructeurs</a></span>ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_constructeur.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="constructeur_name">nom: </label>';
	$toReturn .='<input id="constructeur_name" type="text" name="constructeur_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_constructeur"/></p>';
	
	
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="constructeur"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}

function createConstructeurEditForm(){
		$result = mysqlSelectConstructeurByID($_GET['id_constructeur']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?constructeur=gestion&page=1&order=constructeur_date_modif">constructeurs</a></span><span class="to_edit"><a href="administration.php?constructeur=edit&id_constructeur='.htmlspecialchars(trim($data["id_constructeur"])).'">'.htmlspecialchars(trim($data["constructeur_nom"])).'</a></span>modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_constructeur.php?&id_constructeur='.htmlspecialchars(trim($data["id_constructeur"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="constructeur_name">nom: </label>';
		$toReturn .='<input id="constructeur_name" type="text" name="constructeur_name" value="'.htmlspecialchars(trim($data["constructeur_nom"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		if(htmlspecialchars(trim($data["constructeur_logo"])) == "nopicture.jpg"){
		$toReturn .='</p><p><label for="upload_logo">logo: </label>';
		$toReturn .='<input id="upload_logo" type="file" name="image" class="img" /></p>';
		}
		else{ 
		$toReturn .='<p><label for="img_logo">logo actuel: </label>';
		$toReturn .='<img src="'.dossier_constructeurs().'/'.htmlspecialchars(trim($data["constructeur_logo"])).'" alt="'.htmlspecialchars(trim($data["constructeur_logo"])).'" />';
		
		$toReturn .='<a class="style_button img_delete"  href="admin_traitement_constructeur.php?submit_constructeur=delete_constructeur_logo&id_constructeur='.$_GET['id_constructeur'].'">supprimer logo</a></p>';
		}
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_constructeur"/></p>';
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="constructeur"/>';
		$toReturn .= '</form">';
		return $toReturn;
}
