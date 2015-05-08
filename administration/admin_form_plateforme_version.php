<?php
require_once('mysql_fonctions_plateforme_version.php');
require_once('dossiers_ressources.php');

/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin plateforme]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createPlateformeVersionAddForm(){
	
	$result = mysqlSelectPlateformeByID($_GET['id_plateforme']);
	$data = mysql_fetch_array($result);
		
	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?plateforme=gestion&page=1&order=plateforme_date_modif">plateformes</a></span><span class="to_edit"><a href="administration.php?plateforme=edit&id_plateforme='.$_GET['id_plateforme'].'">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</a></span>ajouter version</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_plateforme_version.php" method="post" enctype="multipart/form-data">';
	
	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="plateforme_version_name">nom version: </label>';
	$toReturn .='<input id="plateforme_version_name" type="text" name="plateforme_version_name" "/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	$toReturn .='<p><label for="date_lancement">date de lancement: </label><input id="date_lancement" class="date_picker" name="date_lancement" type="text" /></p>';
	$toReturn .='<p><label for="date_fin">date de fin de production: </label><input id="date_fin" class="date_picker"  name="date_fin" type="text" /></p>';


	$toReturn .='<p><label for="plateforme_version_descriptif">descriptif: </label><textarea id="plateforme_version_descriptif" name="plateforme_version_descriptif"rows="4" cols="50">';
	$toReturn .='</textarea></p>';
	
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_plateforme_version"/></p>';
	
	

	
	$toReturn .='<input type="hidden" id="id_plateforme" name="id_plateforme" value="'.$_GET['id_plateforme'].'"/>';
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="plateforme_version"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}

function createPlateformeVersionEditForm(){

	$result = mysqlSelectPlateformeVersionByID($_GET['id_plateforme_version']);
	$data = mysql_fetch_array($result);
		
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?plateforme=add&page=1&order=plateforme_date_modif">plateformes</a></span><span class="to_edit"><a href="administration.php?plateforme=edit&id_plateforme='.htmlspecialchars(trim($data['id_plateforme'])).'">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</a></span><span class="to_edit"><a href="administration.php?plateforme_version=edit&id_plateforme_version='.$_GET['id_plateforme_version'].'">'.htmlspecialchars(trim($data["plateforme_version_nom"])).'</a></span>modifier version</h3>';

	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_plateforme_version.php" method="post" enctype="multipart/form-data">';
	
	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="plateforme_version_name">nom version: </label>';
	$toReturn .='<input id="plateforme_version_name" type="text" name="plateforme_version_name" value="'.htmlspecialchars(trim($data['plateforme_version_nom'])).'" "/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	$toReturn .='<p><label for="date_lancement">date de lancement: </label><input id="date_lancement" class="date_picker" name="date_lancement" type="text" value="'.htmlspecialchars(trim($data['date_lancement'])).'"/></p>';
	$toReturn .='<p><label for="date_fin">date de fin de production: </label><input id="date_fin" class="date_picker"  name="date_fin" type="text"  value="'.htmlspecialchars(trim($data['date_fin'])).'"/></p>';


	$toReturn .='<p><label for="plateforme_version_descriptif">descriptif: </label><textarea id="plateforme_version_descriptif" name="plateforme_version_descriptif"rows="4" cols="50">';
	$toReturn .=htmlspecialchars(trim($data['plateforme_version_description']));
	$toReturn .='</textarea></p>';
	
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_plateforme_version"/>';
	$toReturn .='<input id="submit" type="submit" value="gérer les images" name="submit_plateforme_version"/></p>';
	
	$toReturn .='<input type="hidden" id="id_plateforme_version" name="id_plateforme_version" value="'.$_GET['id_plateforme_version'].'"/>';
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="plateforme_version"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
}

function createPlateformeVersionPictureAddForm(){
	$result = mysqlSelectPlateformeVersionByID($_GET['id_plateforme_version']);
	$data = mysql_fetch_array($result);
		
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?plateforme=add&page=1&order=plateforme_date_modif">plateformes</a></span><span class="to_edit"><a href="administration.php?plateforme=edit&id_plateforme='.htmlspecialchars(trim($data['id_plateforme'])).'">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</a></span><span class="to_edit"><a href="administration.php?plateforme_version_picture=add&id_plateforme_version='.$_GET['id_plateforme_version'].'">'.htmlspecialchars(trim($data["plateforme_version_nom"])).'</a></span>images</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_plateforme_version.php" method="post" enctype="multipart/form-data">';
	
	$toReturn .='<fieldset>';
	$toReturn .='</p><p><label for="upload_picture">image: </label>';
	$toReturn .='<input id="upload_picture" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_plateforme_version_image"/></p>';
	
	
	$toReturn .='<hr/>';
	$toReturn .='<fieldset>';
	$result = mysqlSelectAllPlateformeVersionImages($_GET['id_plateforme_version']);
	while($data=mysql_fetch_array($result)) {
   		$toReturn .='<p class="plateforme_version_image_to_delete"><input type="checkbox" name="image_to_delete[]" value="'.htmlspecialchars(trim($data["id_plateforme_version_image"])).'"/><img src="'.dossier_plateformes().'/'.htmlspecialchars(trim($data["plateforme_dossier"])).'/'.htmlspecialchars(trim($data["plateforme_version_image_nom"])).'" alt="'.htmlspecialchars(trim($data["plateforme_version_nom"])).'" /></p>';
	}
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="supprimer la selection" name="submit_plateforme_version_image"/></p>';

	$toReturn .='<input type="hidden" id="id_plateforme_version" name="id_plateforme_version" value="'.$_GET['id_plateforme_version'].'"/>';
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="plateforme_version"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';

	
	return $toReturn;
}

function trunque($str, $nb = 75) {
	if (strlen($str) > $nb) {
		$str = substr($str, 0, $nb);
		$position_espace = strrpos($str, " ");
		$texte = substr($str, 0, $position_espace); 
		$str = $texte." [&hellip;]";
	}
	return $str;
}
?>
