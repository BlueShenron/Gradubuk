<?php
require_once('dossiers_ressources.php');

require_once('mysql_fonctions_jeu_version_region.php');
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
							//[formjeu]//
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//

function createJeuVersionRegionEditForm(){	

	$resultJeuVersionRegion =  mysqlSelectJeuRegion($_GET['id_jeu_version_region']);
	$dataJeuVersionRegion = mysql_fetch_array($resultJeuVersionRegion);
	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?jeu=gestion&page=1&order=jeu_date_modif">jeux</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.$dataJeuVersionRegion['id_jeu'].'">'.$dataJeuVersionRegion['jeu_nom_generique'].'</a></span><span class="to_edit"><a href="administration.php?jeu=edit&id_jeu='.$dataJeuVersionRegion['id_jeu'].'">'.$dataJeuVersionRegion['plateforme_nom_generique'].'</a></span><span class="to_edit"><a href="#">'.$dataJeuVersionRegion['jeu_region'].'</a></span>modifier région</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_jeu_version_region.php?id_jeu_version_region='.htmlspecialchars(trim($dataJeuVersionRegion['id_jeu_version_region'])).'" method="post" enctype="multipart/form-data">';

	//----------------------//
	$toReturn .='<fieldset>';
	//----------------------//
	$toReturn .='<p>';
	$toReturn .='<label for="jeu_region_nom">nom de la version: </label>';
	$toReturn .='<input id="jeu_region_nom" type="text" name="jeu_region_nom" value="'.htmlspecialchars(trim($dataJeuVersionRegion['jeu_region_nom'])).'"/><span class="format_to_respect"> (nom du jeu en VO)</span>';
	$toReturn .='</p>';
	//----------------------//
	//----------------------//
	$toReturn .='<p><label for="date_sortie">date de sortie: </label><input id="date_sortie" class="date_picker" name="date_sortie" type="text" value="'.htmlspecialchars(trim($dataJeuVersionRegion['jeu_date_sortie'])).'"/></p>';
	//----------------------//
	//----------------------//
	$toReturn .= '<p><label for="editeur_name">éditeur :</label>';
	$toReturn .= '<input list="editeur" type="text" id="editeur_name" name="editeur_name" value="'.htmlspecialchars(trim($dataJeuVersionRegion['editeur_nom'])).'">';
	$toReturn .= '<datalist id="editeur">';
	$resultEditeur = mysqlSelectAllEditeurs();
	while($dataEditeur=mysql_fetch_array($resultEditeur)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($dataEditeur["editeur_nom"])).'"></option>';
	}
	$toReturn .= '</datalist></p>';
	//-----------------------//
	
	
	//-----------------------//
	if($dataJeuVersionRegion['jeu_region']=="pal"){
		$toReturn .= '<fieldset id="fieldset_pal">';
		$toReturn .= '<div>';
   		$toReturn .= '<ul id="pegi_age_list">';
		$toReturn .= '<li id="li_pegi_3"><input type="radio" name="classification_pegi[]" id="pegi_3" value="pegi_3"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_3']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .='/><label for="pegi_3">Pegi 3</label></li>';
		$toReturn .= '<li id="li_pegi_4"><input type="radio" name="classification_pegi[]" id="pegi_4" value="pegi_4"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_4']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .='/><label for="pegi_4">Pegi 4</label></li>';
		$toReturn .= '<li id="li_pegi_6"><input type="radio" name="classification_pegi[]" id="pegi_6" value="pegi_6"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_6']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .='/><label for="pegi_6">Pegi 6</label></li>';
		$toReturn .= '<li id="li_pegi_7"><input type="radio" name="classification_pegi[]" id="pegi_7" value="pegi_7"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_7']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .='/><label for="pegi_7">Pegi 7</label></li>';
		$toReturn .= '<li id="li_pegi_12"><input type="radio" name="classification_pegi[]" id="pegi_12" value="pegi_12"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_12']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .='/><label for="pegi_12">Pegi 12</label></li>';
		$toReturn .= '<li id="li_pegi_16"><input type="radio" name="classification_pegi[]" id="pegi_16" value="pegi_16"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_16']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .='/><label for="pegi_16">Pegi 16</label></li>';
		$toReturn .= '<li id="li_pegi_18"><input type="radio" name="classification_pegi[]" id="pegi_18" value="pegi_18"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_18']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .='/><label for="pegi_18">Pegi 18</label></li>';
		$toReturn .= '</ul>';
		$toReturn .= '</div>';
		$toReturn .= '<div>';
		$toReturn .= '<ul id="pegi_descripteur_list">';
		$toReturn .= '<li id="li_pegi_langage"><input type="checkbox" name="classification_pegi[]" id="prg_langage" value="pegi_langage"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_langage']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="langage">Langage Grossier</label></li>';
		$toReturn .= '<li id="li_pegi_discrimination"><input type="checkbox" name="classification_pegi[]" id="pegi_discrimination" value="pegi_discrimination"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_discrimination']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="discrimination">Discrimination</label></li>';
		$toReturn .= '<li id="li_pegi_drogue"><input type="checkbox" name="classification_pegi[]" id="pegi_drogue" value="pegi_drogue"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_drogue']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="drogue">Drogue</label></li>';
		$toReturn .= '<li id="li_pegi_peur"><input type="checkbox" name="classification_pegi[]" id="pegi_peur" value="pegi_peur"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_peur']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="peur">Peur</label></li>';
		$toReturn .= '<li id="li_pegi_jeux_hasard"><input type="checkbox" name="classification_pegi[]" id="pegi_jeux_hasard" value="pegi_jeux_hasard"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_jeux_hasard']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="jeux_hasard">Jeux Hasard</label></li>';
		$toReturn .= '<li id="li_pegi_sex"><input type="checkbox" name="classification_pegi[]" id="pegi_sexe" value="pegi_sexe"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_sexe']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="sexe">Sexe</label></li>';
		$toReturn .= '<li id="li_pegi_violence"><input type="checkbox" name="classification_pegi[]" id="pegi_violence" value="pegi_violence"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_violence']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="violence">Violence</label></li>';
		$toReturn .= '<li id="li_pegi_online"><input type="checkbox" name="classification_pegi[]" id="pegi_internet" value="pegi_internet"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['pegi_internet']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="internet">Online</label></li>';
		$toReturn .= '</ul>';
		$toReturn .= '</div>';
  		$toReturn .= '</fieldset>';
  	}
  	else if($dataJeuVersionRegion['jeu_region']=="jp"){
  		$toReturn .= '<fieldset id="fieldset_jp">';
   		$toReturn .= '<div>';
   		$toReturn .= '<ul id="cero_age_list">';
		$toReturn .= '<li id="li_cero_a"><input type="checkbox" name="classification_cero[]" id="cero_a" value="cero_a"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['cero_a']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="cero_a">Cero a</label></li>';
		$toReturn .= '<li id="li_cero_b"><input type="checkbox" name="classification_cero[]" id="cero_b" value="cero_b"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['cero_b']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="cero_b">Cero b</label></li>';
		$toReturn .= '<li id="li_cero_c"><input type="checkbox" name="classification_cero[]" id="cero_c" value="cero_c"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['cero_c']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="cero_c">Cero c</label></li>';
		$toReturn .= '<li id="li_cero_d"><input type="checkbox" name="classification_cero[]" id="cero_d" value="cero_d"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['cero_d']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="cero_d">Cero d</label></li>';
		$toReturn .= '<li id="li_cero_z"><input type="checkbox" name="classification_cero[]" id="cero_z" value="cero_z"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['cero_z']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="cero_z">Cero z</label></li>';
		$toReturn .= '</ul>';
		$toReturn .= '</div>';	

  		$toReturn .= '</fieldset>';
  	}
	else if($dataJeuVersionRegion['jeu_region']=="us"){
		$toReturn .= '<fieldset id="fieldset_us">';
		$toReturn .= '<div>';
		$toReturn .= '<ul id="esrb_descripteur_list">';
		$toReturn .= '<li id="li_esrb_c"><input type="checkbox" name="classification_esrb[]" id="esrb_c" value="esrb_c"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_c']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_romance">Early Childhood</label></li>';
		$toReturn .= '<li id="li_esrb_e"><input type="checkbox" name="classification_esrb[]" id="esrb_e" value="esrb_e"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_e']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_sexe">Kids to Adults</label></li>';
		$toReturn .= '<li id="li_esrb_e10"><input type="checkbox" name="classification_esrb[]" id="esrb_e10" value="esrb_e10"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_e10']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_violence">Everyone 10+</label></li>';
		$toReturn .= '<li id="li_esrb_t"><input type="checkbox" name="classification_esrb[]" id="esrb_t" value="esrb_t"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_t']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_horreur">Teen</label></li>';
		$toReturn .= '<li id="li_esrb_m"><input type="checkbox" name="classification_esrb[]" id="esrb_m" value="esrb_m"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_m']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_argent">Mature 17+</label></li>';
		$toReturn .= '<li id="li_esrb_a"><input type="checkbox" name="classification_esrb[]" id="esrb_a" value="esrb_a"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_a']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_crime">Adults Only</label></li>';
		$toReturn .= '<li id="li_esrb_info"><input type="checkbox" name="classification_esrb[]" id="esrb_info" value="esrb_info"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_info']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_alcool">Shares Info </label></li>';
		$toReturn .= '<li id="li_esrb_location"><input type="checkbox" name="classification_esrb[]" id="esrb_location" value="esrb_location"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_location']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_drogue">Shares Location</label></li>';
		$toReturn .= '<li id="li_esrb_interact"><input type="checkbox" name="classification_esrb[]" id="esrb_interact" value="esrb_interact"';
		if(htmlspecialchars(trim($dataJeuVersionRegion['esrb_interact']))){
		$toReturn .= 'checked="checked"';
		}
		$toReturn .= '/><label for="esrb_langage">Users Interact </label></li>';
		$toReturn .= '</ul>';
		$toReturn .= '</div>';
  		$toReturn .= '</fieldset>';
	
	}
	/*-----------------------*/
	
	//-----------------------//
	if(htmlspecialchars(trim($dataJeuVersionRegion['jeu_region_cover']))=='nopicture'){
		//echo $dataJeuVersionRegion['jeu_region_cover'];
		$toReturn .='<p><label for="upload_cover">cover: </label>';
		$toReturn .='<input id="upload_cover" type="file" name="cover_file" class="img" /></p>';
	}
	else{
		//echo $dataJeuVersionRegion['jeu_region_cover'];
		$toReturn .= '<p><label for="id_cover_img">cover: </label><img id="id_cover_img" src="'.dossier_jeux().'/'.$dataJeuVersionRegion["jeu_dossier"].'/covers/'.htmlspecialchars(trim($dataJeuVersionRegion["jeu_region_cover"])).'" alt="cover '.htmlspecialchars(trim($data["jeu_nom_region"])).'" />';
		$toReturn .='<a class="style_button img_delete" href="admin_traitement_jeu_version_region.php?submit_jeu_version_region=delete_cover&id_jeu_version_region='.$_GET['id_jeu_version_region'].'">supprimer cover</a></p>';
	}
		//-----------------------//
		//-----------------------//
	if(htmlspecialchars(trim($dataJeuVersionRegion['jeu_region_jaquette']))=='nopicture'){
		$toReturn .='<p><label for="upload_jaquette">jaquette: </label>';
		$toReturn .='<input id="upload_jaquette" type="file" name="jaquette_file" class="img" /></p>';
	}
	else{
		$toReturn .= '<p><label for="id_jaquette_img">jaquette: </label><img id="id_jaquette_img"src="'.dossier_jeux().'/'.$dataJeuVersionRegion["jeu_dossier"].'/jaquettes/'.htmlspecialchars(trim($dataJeuVersionRegion["jeu_region_jaquette"])).'" alt="jaquette '.htmlspecialchars(trim($data["jeu_nom_region"])).'" />';
		$toReturn .='<a class="style_button img_delete" href="admin_traitement_jeu_version_region.php?submit_jeu_version_region=delete_jaquette&id_jeu_version_region='.$_GET['id_jeu_version_region'].'">supprimer jaquette</a></p>';
	}
	
	
	
	
	$toReturn .='</fieldset>';


		
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="jeu"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_jeu_version_region"/></p>';


	$toReturn .='</form>';
		
	

	
	return $toReturn;
}

//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
							//[formjeu]//
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
?>