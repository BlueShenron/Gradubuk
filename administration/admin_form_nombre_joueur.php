<?php
require_once('mysql_fonctions_nombre_joueur.php');


/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin nombre_joueur]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createNombreJoueurGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?nombre_joueur=gestion&page=1&order=nombre_joueur_date_modif">nombres de joueurs</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_nombre_joueur.php" method="post" enctype="multipart/form-data">';

	/*$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="nombre_joueur_name">nom: </label>';
	$toReturn .='<input id="nombre_joueur_name" type="text" name="nombre_joueur_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="uploadcover">logo: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_nombre_joueur"/></p>';
	*/
	$toReturn .= '<hr/>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter un nombre de joueur" name="submit_nombre_joueur"/></p>';
	$toReturn .= '<hr/>';
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="nombre_joueur_date_modif"';
 	if($_GET['order']=="nombre_joueur_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="nombre_joueur_date_creation"';
  	if($_GET['order']=="nombre_joueur_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers créés</option>'; 
 	$toReturn .= '<option value="nombre_joueur_nom"';
 	if($_GET['order']=="nombre_joueur_nom"){
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
   
    $toReturn .='<th>nombre de joueurs</th>';
    $toReturn .='</tr>';
	$result = mysqlSelectAllNombreJoueursWithPageNumber($_GET['page'],$_GET['order'],$nb_element_par_page);
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_nombre_joueur.php?submit_nombre_joueur=delete&id_nombre_joueur='.htmlspecialchars(trim($data["id_nombre_joueur"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?nombre_joueur=edit&id_nombre_joueur='.htmlspecialchars(trim($data["id_nombre_joueur"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["nombre_joueur_nom"])).'</td>';
   		 $toReturn .='</tr>';
   		/*$toReturn .='<fieldset class="fieldset_nombre_joueur">';
		$toReturn .= '<div class="leftdiv"><p><img src="'.dossier_nombre_joueurs().'/'.htmlspecialchars(trim($data["nombre_joueur_logo"])).'" alt="logo '.htmlspecialchars(trim($data["nombre_joueur_nom"])).'" /><p></div>';
		$toReturn .= '<div class="rightdiv">';
		$toReturn .= '<ul><li>nom: <span class="resultat">'.htmlspecialchars(trim($data["nombre_joueur_nom"])).'</span></li></ul>';
		$toReturn .= '</div>';
		$toReturn .='<div class="div_buttons">';
		$toReturn .='<a class="style_button" href="administration.php?nombre_joueur=edit&id_nombre_joueur='.htmlspecialchars(trim($data["id_nombre_joueur"])).'">modifier ce nombre_joueur</a>';

		$toReturn .='<a class="style_button" href="admin_traitement_nombre_joueur.php?submit_nombre_joueur=delete&id_nombre_joueur='.htmlspecialchars(trim($data["id_nombre_joueur"])).'">supprimer ce nombre_joueur</a>';
		$toReturn .='</div>';
		$toReturn .='</fieldset>';*/
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------les dev les uns aux dessus des autres------- //

	/* ------page------- */
	$resultDev = mysqlSelectAllNombreJoueurs();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?nombre_joueur=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?nombre_joueur=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	/* ------page------- */
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="nombre_joueur"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createNombreJoueurAddForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?nombre_joueur=gestion&page=1&order=nombre_joueur_date_modif">nombres de joueurs</a></span>ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_nombre_joueur.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="nombre_joueur_name">nombre de joueur: </label>';
	$toReturn .='<input id="nombre_joueur_name" type="text" name="nombre_joueur_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_nombre_joueur"/></p>';
	
	
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="nombre_joueur"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}

function createNombreJoueurEditForm(){
		$result = mysqlSelectNombreJoueurByID($_GET['id_nombre_joueur']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?nombre_joueur=gestion&page=1&order=nombre_joueur_date_modif">nombres de joueurs</a></span><span class="to_edit"><a href="administration.php?nombre_joueur=edit&id_nombre_joueur='.htmlspecialchars(trim($data["id_nombre_joueur"])).'">'.htmlspecialchars(trim($data["nombre_joueur_nom"])).'</a></span>modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_nombre_joueur.php?&id_nombre_joueur='.htmlspecialchars(trim($data["id_nombre_joueur"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="nombre_joueur_name">nombre de joueur: </label>';
		$toReturn .='<input id="nombre_joueur_name" type="text" name="nombre_joueur_name" value="'.htmlspecialchars(trim($data["nombre_joueur_nom"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_nombre_joueur"/></p>';
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="nombre_joueur"/>';
		$toReturn .= '</form">';
		return $toReturn;
}
