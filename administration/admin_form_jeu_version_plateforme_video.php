<?php
session_start();
require_once('mysql_fonctions_jeu_version_plateforme_video.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin video_jeu]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//


function createJeuVersionPlateformeVideoAddForm(){
	$resultJeuVersion = mysqlSelectVersionsCompletesByjeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
	$dataVersion=mysql_fetch_array($resultJeuVersion);
		
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?jeu=add&page=1&order=jeu_date_modif">jeux</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataVersion['id_jeu'])).'">'.htmlspecialchars(trim($dataVersion['jeu_nom_generique'])).'</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataVersion['id_jeu'])).' #tableau_version">'.htmlspecialchars(trim($dataVersion['plateforme_nom_generique'])).'</a></span>vidéos</h3>';
	//---------------------//
	if($_GET["record"]=="ok"){
				$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	if($_GET["record"]=="nok"){
				$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	//---------------------//
	$toReturn .='<form action="admin_traitement_jeu_version_plateforme_video.php?id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'" method="post" enctype="multipart/form-data">';
	$toReturn .='<fieldset>';	
	$toReturn .='<p>';
    $toReturn .='<label for="video_titre">titre video: </label>';
	$toReturn .='<input id="video_titre" type="text" name="video_titre"/>';
	$toReturn .='</p>';
	$toReturn .='<p><label for="id_categorie_video">categorie video: </label>';	
	$toReturn .='<select name="id_categorie_video" id="id_categorie_video">';	
	$result = mysqlSelectAllVideoCategories();
	$toReturn .= '<option value="">-- catégorie --</option>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_video"].'">'.$data["categorie_video_nom"].'</option>';
	}
	$toReturn .='</select></p>';
	$toReturn .='<p>';
    $toReturn .='<label for="video_url">url video: </label>';
	$toReturn .='<input id="video_url" type="text" name="video_url"/>';
	$toReturn .='</p>';
		
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_video_jeu"/></p>';
	
	//---------------------//
	$toReturn .='<hr/>';
	$toReturn .='<fieldset>';
	$resultVideo = mysqlSelectAllVideosByJeuVersionPlateformeId($_GET['id_jeu_version_plateforme']);
	while($dataVideo=mysql_fetch_array($resultVideo)) {
   		parse_str( parse_url( $dataVideo["video_url"], PHP_URL_QUERY ), $my_array_of_vars );
		$youtube_id = $my_array_of_vars['v'];
		
   		$toReturn .='<p class="plateforme_version_video_to_delete"><input type="checkbox" name="video_to_delete[]" value="'.htmlspecialchars(trim($dataVideo["id_jeu_version_plateforme_video"])).'"/><a href="administration.php?jeu_version_plateforme_video=edit&id_jeu_version_plateforme_video='.htmlspecialchars(trim($dataVideo["id_jeu_version_plateforme_video"])).'"><img src="http://img.youtube.com/vi/'.$youtube_id.'/0.jpg" alt="'.htmlspecialchars(trim($dataVideo["video_url"])).'" /></a><span> '.htmlspecialchars(trim($dataVideo["categorie_video_nom"])).'</span> / <span> '.htmlspecialchars(trim($dataVideo["video_titre"])).'</span></p>';
	}
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="supprimer la selection" name="submit_video_jeu"/></p>';
	//---------------------//

	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="jeu"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="edit"/>';
	
	$toReturn .='</form>';
	return $toReturn;
}

function createJeuVersionPlateformeVideoEditForm(){
	$resultVideo = mysqlSelectVersionsCompletesByjeuVersionPlateformeIdVideo($_GET['id_jeu_version_plateforme_video']);
	$dataVideo=mysql_fetch_array($resultVideo);

	$toReturn .='<h3><span class="to_edit"><a href="administration.php?jeu=add&page=1&order=jeu_date_modif">jeux</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataVideo['id_jeu'])).'">'.htmlspecialchars(trim($dataVideo['jeu_nom_generique'])).'</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($dataVideo['id_jeu'])).' #tableau_version">'.htmlspecialchars(trim($dataVideo['plateforme_nom_generique'])).'</a></span><span class="to_edit"><a href="administration.php?jeu_version_plateforme_video=add&id_jeu_version_plateforme='.htmlspecialchars(trim($dataVideo['id_jeu_version_plateforme'])).'">vidéos</a></span>modifier</h3>';
	//---------------------//
	if($_GET["record"]=="ok"){
				$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	if($_GET["record"]=="nok"){
				$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	//---------------------//
	$toReturn .='<form action="admin_traitement_jeu_version_plateforme_video.php?id_jeu_version_plateforme_video='.$_GET['id_jeu_version_plateforme_video'].'" method="post" enctype="multipart/form-data">';
	$toReturn .='<fieldset>';	
	$toReturn .='<p>';
    $toReturn .='<label for="video_titre">titre video: </label>';
	$toReturn .='<input id="video_titre" type="text" name="video_titre" value="'.htmlspecialchars(trim($dataVideo['video_titre'])).'"/>';
	$toReturn .='</p>';
	
	$toReturn .='<p><label for="id_categorie_video">categorie video: </label>';	
	$toReturn .='<select name="id_categorie_video" id="id_categorie_video">';	
	$result = mysqlSelectAllVideoCategories();
	$toReturn .= '<option value="">-- catégorie --</option>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_video"].'"';
   		 if(htmlspecialchars(trim($data['id_categorie_video'])) == htmlspecialchars(trim($dataVideo['id_categorie_video']))){
   			$toReturn .= ' selected ';
   		}

   		$toReturn .= '>'.$data["categorie_video_nom"].'</option>';
	}
	$toReturn .='</select></p>';

	
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_video_jeu"/></p>';
	
	

	
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