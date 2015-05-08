<?php
require_once('mysql_fonctions_plateforme.php');
require_once('dossiers_ressources.php');


/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin plateforme]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createPlateformeGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?plateforme=gestion&page=1&order=plateforme_date_modif">plateformes</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_plateforme.php" method="post" enctype="multipart/form-data">';
	/*
	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="plateforme_name">nom générique: </label>';
	$toReturn .='<input id="plateforme_name" type="text" name="plateforme_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	//-----------select constructeur-----------//
	$toReturn .='<p><label for="id_constructeur">constructeur: </label>';	
	$toReturn .='<select name="id_constructeur" id="id_constructeur">';	
	$toReturn .= '<option value="">--- constructeur ---</option>';
	$result = mysqlSelectAllConstructeurs();
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_constructeur"].'">'.htmlspecialchars(trim($data["constructeur_nom"])).'</option>';
	}
	$toReturn .='</select></p>';
	//-----------select constructeur-----------//
	
	$toReturn .='<p><label for="uploadcover">photo générique: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	
	
	
	$toReturn .='<p><label for="retro">retro: </label> <input type="checkbox" id="retro" name="retro" value="1"/></p>';
	
	$toReturn .='<p><label for="plateforme_descriptif">descriptif: </label><textarea id="plateforme_descriptif" name="plateforme_descriptif"rows="4" cols="50">';
	$toReturn .='</textarea></p>';
	
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_plateforme"/></p>';
	*/
	$toReturn .= '<hr/>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter une plateforme" name="submit_plateforme"/></p>';

	$toReturn .= '<hr/>';
	
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="plateforme_date_modif"';
 	if($_GET['order']=="plateforme_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par dernières modifiées</option>';
  	$toReturn .= '<option value="plateforme_date_creation"';
  	if($_GET['order']=="plateforme_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par dernières créées</option>'; 
 	$toReturn .= '<option value="plateforme_nom_generique"';
 	if($_GET['order']=="plateforme_nom_generique"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par nom</option>';
 	
 	$toReturn .= '<option value="constructeur_nom"';
 	if($_GET['order']=="constructeur_nom"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par constructeur</option>';
 	
	$toReturn .= '</select></p>';
	//-----------filtre de tri-----------//
	$nb_element_par_page=20;
	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='<fieldset>';
	$toReturn .='<table>';
	$toReturn .='<tr>';
    $toReturn .='<th></th>';
    $toReturn .='<th></th>';
    $toReturn .='<th>image générique</th>';
    $toReturn .='<th>nom générique</th>';
    $toReturn .='<th>constructeur</th>';
    $toReturn .='<th colspan=4>versions</th>';
    $toReturn .='</tr>';
	// ------les dev les uns aux dessus des autres------- //
	$result = mysqlSelectAllPlateformesWithPageNumber($_GET['page'],$_GET['order'],$nb_element_par_page);
	$number = 0;
	while($data=mysql_fetch_array($result)) {
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		$resultCountPlateformeVersion = mysqlCountPlateformeVersion($data['id_plateforme']);
		$dataCountPlateformeVersion = mysql_fetch_array($resultCountPlateformeVersion);
		
		$toReturn .= '<tr class="'.$class.' last_line">';
		$toReturn .= '<td class="center delete_item_table" rowspan="'.htmlspecialchars(trim($dataCountPlateformeVersion["rowspan"])).'"><a href="admin_traitement_plateforme.php?submit_plateforme=delete&id_plateforme='.htmlspecialchars(trim($data["id_plateforme"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table" rowspan="'.htmlspecialchars(trim($dataCountPlateformeVersion["rowspan"])).'"><a href="administration.php?plateforme=edit&id_plateforme='.htmlspecialchars(trim($data["id_plateforme"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td class="cell_image_categorie_news" rowspan="'.htmlspecialchars(trim($dataCountPlateformeVersion["rowspan"])).'"><img class="image_categorie_news" src="'.dossier_plateformes().'/'.htmlspecialchars(trim($data["plateforme_image_generique"])).'" alt="logo '.htmlspecialchars(trim($data["constructeur_nom"])).'" /></td>';
   		$toReturn .= '<td rowspan="'.htmlspecialchars(trim($dataCountPlateformeVersion["rowspan"])).'">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</td>';
   		$toReturn .= '<td rowspan="'.htmlspecialchars(trim($dataCountPlateformeVersion["rowspan"])).'">'.htmlspecialchars(trim($data["constructeur_nom"])).'</td>';

 		$toReturn .= '<td  class="center add_item_table" rowspan="'.htmlspecialchars(trim($dataCountPlateformeVersion["rowspan"])).'"><a href="administration.php?plateforme_version=add&id_plateforme='.htmlspecialchars(trim($data["id_plateforme"])).'"><span>ajouter une sous categorie</span></a></td>';
   		
   		
   		//ici il faut afficher le premier élément
 		$resultPremierPlateformeVersion = mysqlSelectPremierPlateformeVersion($data['id_plateforme']);
 		$dataPremierPlateformeVersion = mysql_fetch_array($resultPremierPlateformeVersion);

		if(htmlspecialchars(trim($dataCountPlateformeVersion["count"]))>0){
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_plateforme_version.php?submit_plateforme_version=delete&id_plateforme_version='.htmlspecialchars(trim($dataPremierPlateformeVersion["id_plateforme_version"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?plateforme_version=edit&id_plateforme_version='.htmlspecialchars(trim($dataPremierPlateformeVersion["id_plateforme_version"])).'"><span>modifier</span></a></td>';
		$toReturn .= '<td>'.htmlspecialchars(trim($dataPremierPlateformeVersion["plateforme_version_nom"])).'</td>';
		
		}
		else{
		
		$toReturn .= '<td></td>';
		$toReturn .= '<td></td>';
		$toReturn .= '<td></td>';
		}	
		$toReturn .= '</tr>'; // puis on ferme la ligne
		
		
		//et la on affiche le reste
		$resultPlateformeSuivante = mysqlSelectPlateformeVersionSuivante(htmlspecialchars(trim($dataCountPlateformeVersion["count"])),$data['id_plateforme']);
 		
 		while($dataPlateformeSuivante = mysql_fetch_array($resultPlateformeSuivante)){
 		$toReturn .= '<tr class="'.$class.'">';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_plateforme_version.php?submit_plateforme_version=delete&id_plateforme_version='.htmlspecialchars(trim($dataPlateformeSuivante["id_plateforme_version"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?plateforme_version=edit&id_plateforme_version='.htmlspecialchars(trim($dataPlateformeSuivante["id_plateforme_version"])).'"><span>modifier</span></a></td>';
		$toReturn .= '<td>'.htmlspecialchars(trim($dataPlateformeSuivante["plateforme_version_nom"])).'</td>';
		
		$toReturn .= '</tr>';
 		
 		}
 		$number ++;
   		/*$toReturn .='<fieldset class="fieldset_plateforme">';
		$toReturn .= '<div class="leftdiv"><p><img src="'.dossier_plateformes().'/'.htmlspecialchars(trim($data["plateforme_image_generique"])).'" alt="image '.htmlspecialchars(trim($data["plateforme_nom_generique"])).'" /><p></div>';
		$toReturn .= '<div class="rightdiv">';
		$toReturn .= '<ul><li>nom: <span class="resultat">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</span></li>';
		$toReturn .= '<li>constructeur: <span class="'.htmlspecialchars(trim($data["class_constructeur_resultat"])).'">'.htmlspecialchars(trim($data["constructeur_nom"])).'</span></li>';
		$toReturn .= '<li>retro: <span class="resultat">'.htmlspecialchars(trim($data["retro"])).'</span></li>';
		$toReturn .= '<li>description: <span class="'.htmlspecialchars(trim($data["class_plateforme_resultat"])).'">'.trunque(htmlspecialchars(trim($data["plateforme_description"]))).'</span></li>';
		
		$resultCountVersion = mysqlCountVersionsPlateformeByID($data["id_plateforme"]);
		$dataCountVersion=mysql_fetch_array($resultCountVersion);
		$toReturn .= '<li>nombre de versions: <span class="'.htmlspecialchars(trim($dataCountVersion["class_count_resultat"])).'">'.trunque(htmlspecialchars(trim($dataCountVersion["count"]))).'</span></li>';
		
		$toReturn .= '</ul>';
		$toReturn .= '</div>';
		$toReturn .='<div class="div_buttons">';
		$toReturn .='<a class="style_button" href="administration.php?plateforme=edit&id_plateforme='.htmlspecialchars(trim($data["id_plateforme"])).'">modifier cette plateforme</a>';

		$toReturn .='<a class="style_button" href="admin_traitement_plateforme.php?submit_plateforme=delete&id_plateforme='.htmlspecialchars(trim($data["id_plateforme"])).'">supprimer cette plateforme</a>';
		$toReturn .='</div>';
		$toReturn .='</fieldset>';*/
	}
	// ------les dev les uns aux dessus des autres------- //
	
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	/* ------page------- */
	$resultDev = mysqlSelectAllPlateformes();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?plateforme=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?plateforme=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	/* ------page------- */
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="plateforme"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createPlateformeAddForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?plateforme=gestion&page=1&order=plateforme_date_modif">plateformes</a></span>ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_plateforme.php" method="post" enctype="multipart/form-data">';
	
	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="plateforme_name">nom générique: </label>';
	$toReturn .='<input id="plateforme_name" type="text" name="plateforme_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	//-----------select constructeur-----------//
	$toReturn .='<p><label for="id_constructeur">constructeur: </label>';	
	$toReturn .='<select name="id_constructeur" id="id_constructeur">';	
	$toReturn .= '<option value="">--- constructeur ---</option>';
	$result = mysqlSelectAllConstructeurs();
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_constructeur"].'">'.htmlspecialchars(trim($data["constructeur_nom"])).'</option>';
	}
	$toReturn .='</select></p>';
	//-----------select constructeur-----------//
	
	$toReturn .='<p><label for="uploadcover">photo générique: </label>';
	$toReturn .='<input id="uploadcover" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p></p>';
	
	
	
	$toReturn .='<p><label for="retro">retro: </label> <input type="checkbox" id="retro" name="retro" value="1"/></p>';
	
	$toReturn .='<p><label for="plateforme_descriptif">descriptif: </label><textarea id="plateforme_descriptif" name="plateforme_descriptif"rows="4" cols="50">';
	$toReturn .='</textarea></p>';
	
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_plateforme"/></p>';
	
	
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="plateforme"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createPlateformeEditForm(){
		$result = mysqlSelectPlateformeByID($_GET['id_plateforme']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?plateforme=gestion&page=1&order=plateforme_date_modif">plateformes</a></span><span class="to_edit"><a href="administration.php?plateforme=edit&id_plateforme='.htmlspecialchars(trim($data["id_plateforme"])).'">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</a></span>modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_plateforme.php?&id_plateforme='.htmlspecialchars(trim($data["id_plateforme"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="plateforme_name">nom générique: </label>';
		$toReturn .='<input id="plateforme_name" type="text" name="plateforme_name" value="'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		$toReturn .='<p><label for="id_constructeur">constructeur: </label>';	
		$toReturn .='<select name="id_constructeur" id="id_constructeur">';	
		$toReturn .= '<option value="">--- constructeur ---</option>';
		$result2 = mysqlSelectAllConstructeurs();
		
		while($data2=mysql_fetch_array($result2)) {
   			$toReturn .= '<option value="'.htmlspecialchars(trim($data2["id_constructeur"])).'"';
   			
   			if(htmlspecialchars(trim($data["id_constructeur"]))==htmlspecialchars(trim($data2["id_constructeur"]))){
   			$toReturn .= 'selected="selected"';
   			}
   			$toReturn .='>'.htmlspecialchars(trim($data2["constructeur_nom"])).'';
   			
   			$toReturn .= '</option>';
		}
		$toReturn .='</select></p>';
		
		if(htmlspecialchars(trim($data["plateforme_image_generique"]))=="nopicture.jpg"){
		$toReturn .='</p><p><label for="upload_picture">photo générique: </label>';
		$toReturn .='<input id="upload_picture" type="file" name="image" class="img" /><span class="format_to_respect"> (jpeg, poids max: 3MB)</span></p>';
		}
		else{ 
		$toReturn .='<p><label for="img_picture">photo générique: </label>';
		$toReturn .='<img src="'.dossier_plateformes().'/'.htmlspecialchars(trim($data["plateforme_image_generique_url"])).'" alt="'.htmlspecialchars(trim($data["plateforme_image"])).'" />';
		
		$toReturn .='<a class="style_button img_delete"  href="admin_traitement_plateforme.php?submit_plateforme=delete_plateforme_image&id_plateforme='.$_GET['id_plateforme'].'">supprimer photo</a></p>';
		}
		
		if($data["retro"]){
		$toReturn .='<p><label for="retro">retro: </label> <input type="checkbox"id="retro" name="retro" value="1" checked="checked"/></p>';
		}
		else{
		$toReturn .='<p><label for="retro">retro: </label> <input type="checkbox"id="retro" name="retro" value="1"/></p>';
		}
		
		$toReturn .='<p><label for="plateforme_descriptif">descriptif: </label><textarea id="plateforme_descriptif" name="plateforme_descriptif"rows="4" cols="50">';
		$toReturn .=htmlspecialchars(trim($data["plateforme_description"]));
		$toReturn .='</textarea></p>';
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_plateforme"/></p>';
		
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="plateforme"/>';
		
		//$toReturn .= '<hr/>';
		// --------------- les version de cette plateforme ------------- //
		/*
		$toReturn .='<h4><span class="to_edit">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</span>versions</h4>';
		
		
				$toReturn .='<fieldset id="tableau_version">';

		$resultCount = mysqlCountVersionsPlateformeByID($_GET['id_plateforme']);
		$dataCount=mysql_fetch_array($resultCount);
		if($dataCount['count']>0){
			$resultVersionPlateforme = mysqlSelectAllPlateformeVersions($_GET['id_plateforme']);
			$toReturn .='<table>
					<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>nom la version</th>
					<th>date de lancement</th>
    				<th>fin de production</th>
  					</tr>';
			while($dataVersionPlateforme=mysql_fetch_array($resultVersionPlateforme)) {
			
				$toReturn .='<tr>
				
				<td class="center delete_item_table">
					<a href="admin_traitement_plateforme_version.php?submit_plateforme_version=delete&id_plateforme_version='.htmlspecialchars(trim($dataVersionPlateforme["id_plateforme_version"])).'&id_plateforme='.$_GET['id_plateforme'].'"><span>supprimer cette version</span></a>
				</td>
				
				
				<td class="center edit_item_table">
					<a href="administration.php?plateforme_version=edit&id_plateforme_version='.htmlspecialchars(trim($dataVersionPlateforme["id_plateforme_version"])).'"><span>modifier cette version</span></a>
				</td>
				
				
				<td class="center image_item_table">
					<a href="administration.php?plateforme_version_picture=add&id_plateforme_version='.htmlspecialchars(trim($dataVersionPlateforme["id_plateforme_version"])).'"><span>gérer images pour cette version</span></a>				
				</td>
				
				
				<td>
					'.$dataVersionPlateforme['plateforme_version_nom'].'
				</td>
				<td>
					'.htmlspecialchars(trim($dataVersionPlateforme["date_lancement"])).'
				</td>
				<td>
					'.htmlspecialchars(trim($dataVersionPlateforme["date_fin"])).'
				</td>';
				
				
				
				
			}
		}
		else{
				//$toReturn .= '<ul><li>aucune version pour cette plateforme</li></ul>';
		}
		*/
		
		
		
		//$toReturn .='</table>';
		//$toReturn .='<p><input id="submit" type="submit" value="ajouter version" name="submit_plateforme"/></p>';

		//$toReturn .='</fieldset>';

		$toReturn .= '</form">';
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
