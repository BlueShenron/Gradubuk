<?php
session_start();
require_once('mysql_fonctions_jeu_version_plateforme_image.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin image_jeu]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//


function createJeuVersionPlateformeImageAddForm(){
	$resultJeuVersion = mysqlSelectVersionsCompletesByjeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
	$dataVersion=mysql_fetch_array($resultJeuVersion);
		
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?jeu=add&page=1&order=jeu_date_modif">jeux</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataVersion['id_jeu'])).'">'.htmlspecialchars(trim($dataVersion['jeu_nom_generique'])).'</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataVersion['id_jeu'])).' #tableau_version">'.htmlspecialchars(trim($dataVersion['plateforme_nom_generique'])).'</a></span>images</h3>';
	//---------------------//
	if($_GET["record"]=="ok"){
				$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	if($_GET["record"]=="nok"){
				$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	//---------------------//
	$toReturn .='<form action="admin_traitement_jeu_version_plateforme_image.php?id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'" method="post" enctype="multipart/form-data">';
	$toReturn .='<fieldset>';	
	$toReturn .='<p>';
    $toReturn .='<label for="image_titre">titre image: </label>';
	$toReturn .='<input id="image_titre" type="text" name="image_titre"/>';
	$toReturn .='</p>';
	$toReturn .='<p><label for="id_categorie_image">categorie image: </label>';	
	$toReturn .='<select name="id_categorie_image" id="id_categorie_image">';	
	$result = mysqlSelectAllImgCategories();
	$toReturn .= '<option value="">-- catégorie --</option>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_image"].'">'.$data["categorie_image_nom"].'</option>';
	}
	$toReturn .='</select></p>';
	
	$toReturn .='<p><label for="image_file">image: </label>';
	$toReturn .='<input id="image_file" type="file" name="image_file" class="img" /><span class="obligatoire"></span></p>';
		
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_image_jeu"/></p>';
	
	//---------------------//
	$toReturn .='<hr/>';
	$toReturn .='<fieldset>';
	$resultImage = mysqlSelectAllImagesByJeuVersionPlateformeId($_GET['id_jeu_version_plateforme']);
	while($dataImage=mysql_fetch_array($resultImage)) {
   		
   		$toReturn .='<p class="plateforme_version_image_to_delete"><input type="checkbox" name="image_to_delete[]" value="'.htmlspecialchars(trim($dataImage["id_jeu_version_plateforme_image"])).'"/><a href="administration.php?jeu_version_plateforme_image=edit&id_jeu_version_plateforme_image='.htmlspecialchars(trim($dataImage["id_jeu_version_plateforme_image"])).'"><img src="'.dossier_jeux().'/'.htmlspecialchars(trim($dataImage["jeu_dossier"])).'/pictures/'.htmlspecialchars(trim($dataImage["image_nom"])).'" alt="'.htmlspecialchars(trim($dataImage["image_nom"])).'" /></a><span> '.htmlspecialchars(trim($dataImage["categorie_image_nom"])).'</span> / <span> '.htmlspecialchars(trim($dataImage["image_titre"])).'</span></p>';
	}
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="supprimer la selection" name="submit_image_jeu"/></p>';
	//---------------------//

	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="jeu"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="edit"/>';
	
	$toReturn .='</form>';
	return $toReturn;
}

function createJeuVersionPlateformeImageEditForm(){
	$resultImage = mysqlSelectVersionsCompletesByjeuVersionPlateformeIdImage($_GET['id_jeu_version_plateforme_image']);
	$dataImage=mysql_fetch_array($resultImage);

	$toReturn .='<h3><span class="to_edit"><a href="administration.php?jeu=add&page=1&order=jeu_date_modif">jeux</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataImage['id_jeu'])).'">'.htmlspecialchars(trim($dataImage['jeu_nom_generique'])).'</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataImage['id_jeu'])).' #tableau_version">'.htmlspecialchars(trim($dataImage['plateforme_nom_generique'])).'</a></span><span class="to_edit"><a href="administration.php?jeu_version_plateforme_image=add&id_jeu_version_plateforme='.htmlspecialchars(trim($dataImage['id_jeu_version_plateforme'])).'">image</a></span>modifier</h3>';
	//---------------------//
	if($_GET["record"]=="ok"){
				$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	if($_GET["record"]=="nok"){
				$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	//---------------------//
	$toReturn .='<form action="admin_traitement_jeu_version_plateforme_image.php?id_jeu_version_plateforme_image='.$_GET['id_jeu_version_plateforme_image'].'" method="post" enctype="multipart/form-data">';
	$toReturn .='<fieldset>';	
	$toReturn .='<p>';
    $toReturn .='<label for="image_titre">titre image: </label>';
	$toReturn .='<input id="image_titre" type="text" name="image_titre" value="'.htmlspecialchars(trim($dataImage['image_titre'])).'"/>';
	$toReturn .='</p>';
	
	$toReturn .='<p><label for="id_categorie_image">categorie image: </label>';	
	$toReturn .='<select name="id_categorie_image" id="id_categorie_image">';	
	$result = mysqlSelectAllImgCategories();
	$toReturn .= '<option value="">-- catégorie --</option>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_image"].'"';
   		 if(htmlspecialchars(trim($data['id_categorie_image'])) == htmlspecialchars(trim($dataImage['id_categorie_image']))){
   			$toReturn .= ' selected ';
   		}

   		$toReturn .= '>'.$data["categorie_image_nom"].'</option>';
	}
	$toReturn .='</select></p>';

	
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_image_jeu"/></p>';
	
	

	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="jeu"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="edit"/>';
	
	
	
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