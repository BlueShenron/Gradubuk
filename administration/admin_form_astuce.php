<?php
//require_once('mysql_fonctions_astuce.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin astuce]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createAstuceGestionForm(){
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?astuce=gestion&page=1&order=astuce_date_modif">astuces</span></a>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}

	$toReturn .='<hr/>';
	//---------------------------form ajouter astuce--------------------------------//
	$toReturn .='<form action="admin_traitement_astuce.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p><select name="plateforme" id="plateforme">';	
	$toReturn .= '<option value="">-- plateformes --</option>';
	$resultPlateforme = mysqlSelectAllPlateformesByConstructeur();
	$constructeur_precedent = "";

	while($dataPlateforme=mysql_fetch_array($resultPlateforme)) {
		$resultConst = mysqlSelectConstructeursByID(htmlspecialchars(trim($dataPlateforme['id_constructeur'])));
		$dataConst =mysql_fetch_array($resultConst);
		if(htmlspecialchars(trim($dataConst['constructeur_nom']))!= $constructeur_precedent){
			if($constructeur_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($dataConst['constructeur_nom'])).'">';
			}
			
   				$toReturn .= '<option value="'.htmlspecialchars(trim($dataPlateforme["id_plateforme"])).'">'.htmlspecialchars(trim($dataPlateforme["plateforme_nom_generique"])).'</option>';
						
   			$constructeur_precedent = htmlspecialchars(trim($dataConst['constructeur_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <select id="id_jeu" name="id_jeu">';
	$toReturn .='<option value="">-- jeux --</option>';
	$toReturn .='</select>';
	$toReturn .=' <input id="submit" type="submit" value="créer une astuce" name="submit_astuce"/>';

	$toReturn .='</p>';
	$toReturn .='</form>';
	//--------------------------------------------------------------------//

	$toReturn .='<hr/>';

	//----------------------------form filtre plateforme/jeu----------------------------------------//
	$toReturn .='<form action="admin_traitement_astuce.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p><select name="plateforme_search" id="plateforme_search">';	
	$toReturn .= '<option value="">-- plateformes --</option>';
	$resultPlateforme = mysqlSelectAllPlateformesByConstructeur();
	$constructeur_precedent = "";

	while($dataPlateforme=mysql_fetch_array($resultPlateforme)) {
		$resultConst = mysqlSelectConstructeursByID(htmlspecialchars(trim($dataPlateforme['id_constructeur'])));
		$dataConst =mysql_fetch_array($resultConst);
		if(htmlspecialchars(trim($dataConst['constructeur_nom']))!= $constructeur_precedent){
			if($constructeur_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($dataConst['constructeur_nom'])).'">';
			}
			
   				$toReturn .= '<option value="'.htmlspecialchars(trim($dataPlateforme["id_plateforme"])).'">'.htmlspecialchars(trim($dataPlateforme["plateforme_nom_generique"])).'</option>';
						
   			$constructeur_precedent = htmlspecialchars(trim($dataConst['constructeur_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <select id="id_jeu_search" name="id_jeu_search">';
	$toReturn .='<option value="">-- jeux --</option>';
	$toReturn .='</select>';
	$toReturn .=' <input id="submit" type="submit" value="ok" name="submit_astuce"/>';

	$toReturn .='</p>';
	$toReturn .='</form>';
	//--------------------------------form champ de recherche nom jeu------------------------------------//
	$toReturn .='<form action="admin_traitement_astuce.php" method="post" enctype="multipart/form-data">';
	$toReturn .='</p>';
	$toReturn .='<p>';
	$toReturn .='<input id="jeu_name_search" type="text" name="jeu_name_search"/>';
	$toReturn .=' <input id="submit" type="submit" value="rechercher" name="submit_astuce"/>';
	$toReturn .='</p>';
	$toReturn .='</form>';
	
	$toReturn .='<hr/>';

	//---------------------------------------------------------------------------------------------//
	//------------------------------form + tableau des astuce--------------------------------------//
	//---------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_astuce.php" method="post" enctype="multipart/form-data">';
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="astuce_date_modif"';
 	if($_GET['order']=="astuce_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par dernières modifiées</option>';
  	
  	$toReturn .= '<option value="astuce_date_creation"';
  	if($_GET['order']=="astuce_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par dernières créées</option>'; 
	$toReturn .= '</select></p>';
	//--------------------------------------------------------------------//
	$nb_element_par_page=10;
	//-----------------------------par defaut---------------------------------------//
	if(!isset($_GET['id_jeu_version_plateforme']) && !isset($_GET['jeu_nom_generique'])){
	$result = mysqlSelectAllAstuceWithPageNumber($_GET['page'], $_GET['order'], $nb_element_par_page);
	$toReturn .='<fieldset id="resultat_recherche"/>';
	$toReturn .='<table>';
	$toReturn .='<tr>
    			<th></th>
    			<th></th>
    			<th></th>
    			<th>jeu</th>
    			<th>plateforme</th>
    			<th>titre astuce</th>
				
				<th>date création</th>
				<th>date publication</th>
				<th>rédateur</th>
				<th>correcteur</th>
  				</tr>';
  				
  
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_astuce.php?submit_astuce=delete&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?astuce=edit&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>modifier</span></a></td>';
		$toReturn .='<td class="center publish_item_table"><a href="admin_traitement_astuce.php?submit_astuce=publish&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>publier</span></a></td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['jeu_nom_generique'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['plateforme_nom_generique'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_titre'])).'</td>';
		
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_date_creation'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_date_publication'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['membre_createur'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['pseudo_correcteur'])).'</td>';
		
		$toReturn .='</tr>';
 		
	}
	$toReturn .='</table>';
	
	
	
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllAstuce();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?astuce=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'#resultat_recherche"> << </a>';
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
		$toReturn .= '<a href="administration.php?astuce=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';

	}
	//---------------------------si un id de jeu version plateforme est selectionné-----------------------------------------//
	else if(isset($_GET['id_jeu_version_plateforme'])){
	$resultJeu = mysqlSelectJeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
	$dataJeu=mysql_fetch_array($resultJeu);
	
	$resultCount = mysqlSelectCountAllAstuceWithIdJeuVersionPlateforme($_GET['id_jeu_version_plateforme']);
	$dataCount=mysql_fetch_array($resultCount);
	
	$toReturn .= '<p  class="resultat_recherche">résultat(s) pour "'.$dataJeu['jeu_nom_generique'].' sur '.$dataJeu['plateforme_nom_generique'].'": <span>'.$dataCount['count'].'</span></p>';
	
	// ------les dev les uns aux dessus des autres------- //
	$result = mysqlSelectAllAstuceWithPageNumberAndJeuVersionPlateformeId($_GET['page'], $_GET['order'], $nb_element_par_page,$_GET['id_jeu_version_plateforme']);
	$toReturn .='<fieldset id="resultat_recherche"/>';
	$toReturn .='<table>';
	$toReturn .='<tr>
    			<th></th>
    			<th></th>
    			<th></th>
    			<th>jeu</th>
    			<th>plateforme</th>
    			<th>titre astuce</th>
				
				<th>date création</th>
				<th>date publication</th>
				<th>rédateur</th>
				<th>correcteur</th>
  				</tr>';
  				
  
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_astuce.php?submit_astuce=delete&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?astuce=edit&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>modifier</span></a></td>';
		$toReturn .='<td class="center publish_item_table"><a href="admin_traitement_astuce.php?submit_astuce=publish&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>publier</span></a></td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['jeu_nom_generique'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['plateforme_nom_generique'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_titre'])).'</td>';
		
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_date_creation'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_date_publication'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['membre_createur'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['pseudo_correcteur'])).'</td>';
		
		$toReturn .='</tr>';
 		
	}
	$toReturn .='</table>';
	
	
	
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllAstuceWithJeuVersionPlateformeId($_GET['id_jeu_version_plateforme']);
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?astuce=gestion&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'&page='.($_GET['page']-1).'&order='.($_GET['order']).'#resultat_recherche"> << </a>';
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
		$toReturn .= '<a href="administration.php?astuce=gestion&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'&page='.($_GET['page']+1).'&order='.($_GET['order']).'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'"/>';
	}	
	//------------------------------si un nom générique est renseigné--------------------------------------//
	else if(isset($_GET['jeu_nom_generique'])){
	
	
	$resultCount = mysqlSelectCountAllAstuceWithJeuNom($_GET['jeu_nom_generique']);
	$dataCount=mysql_fetch_array($resultCount);
	
	$toReturn .= '<p  class="resultat_recherche">résultat(s) pour "'.$_GET['jeu_nom_generique'].': <span>'.$dataCount['count'].'</span></p>';
	
	// ------les dev les uns aux dessus des autres------- //
	$result = mysqlSelectAllAstuceWithPageNumberAndJeuNom($_GET['page'], $_GET['order'], $nb_element_par_page,$_GET['jeu_nom_generique']);
	$toReturn .='<fieldset id="resultat_recherche"/>';
	$toReturn .='<table>';
	$toReturn .='<tr>
    			<th></th>
    			<th></th>
    			<th></th>
    			<th>jeu</th>
    			<th>plateforme</th>
    			<th>titre astuce</th>
				
				<th>date création</th>
				<th>date publication</th>
				<th>rédateur</th>
				<th>correcteur</th>
  				</tr>';
  				
  
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_astuce.php?submit_astuce=delete&jeu_nom_generique='.$_GET['jeu_nom_generique'].'&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?astuce=edit&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>modifier</span></a></td>';
		$toReturn .='<td class="center publish_item_table"><a href="admin_traitement_astuce.php?submit_astuce=publish&jeu_nom_generique='.$_GET['jeu_nom_generique'].'&id_astuce='.htmlspecialchars(trim($data["id_astuce"])).'&order='.$_GET['order'].'"><span>publier</span></a></td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['jeu_nom_generique'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['plateforme_nom_generique'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_titre'])).'</td>';
		
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_date_creation'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['astuce_date_publication'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['membre_createur'])).'</td>';
		$toReturn .='<td>'.htmlspecialchars(trim($data['pseudo_correcteur'])).'</td>';
		
		$toReturn .='</tr>';
 		
	}
	$toReturn .='</table>';
	
	
	
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllAstuceWithJeuNom($_GET['jeu_nom_generique']);
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?astuce=gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'&page='.($_GET['page']-1).'&order='.($_GET['order']).'#resultat_recherche"> << </a>';
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
		$toReturn .= '<a href="administration.php?astuce=gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'&page='.($_GET['page']+1).'&order='.($_GET['order']).'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'"/>';
	}	
	//---------------------------------------------------------------------------------------------//

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="astuce"/>';
	$toReturn .='</form>';
	//---------------------------------------------------------------------------------------------//
	//---------------------------------------------------------------------------------------------//
	//---------------------------------------------------------------------------------------------//
	return $toReturn;
	
}
function createAstuceAddForm(){
	$resultJeuVersionPlateforme = mysqlSelectJeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
	$dataJeuVersionPlateforme=mysql_fetch_array($resultJeuVersionPlateforme);
	
	$toReturn .='<h3>
	<span class="to_edit"><a href="administration.php?astuce=gestion&page=1&order=astuce_date_modif">Astuces</a></span>
	<span class="to_edit"><a href="#">'.htmlspecialchars(trim($dataJeuVersionPlateforme['jeu_nom_generique'])).'</a></span>
	<span class="to_edit"><a href="#">'.htmlspecialchars(trim($dataJeuVersionPlateforme['plateforme_nom_generique'])).'</a></span>
	créer</h3>';
	$toReturn .='<form action="admin_traitement_astuce.php?id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">echec</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">succes</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	//-----------------------//
	$toReturn .='<p><label for="astuce">astuce: </label>';
	$toReturn .='<textarea id="astuce" name="astuce"></textarea>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataTest['test_date_publication'])).'"/></p>';

	//-----------------------//
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="créer" name="submit_astuce"/></p>';
	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="astuce"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
}
function createAstuceEditForm(){
	$resultAstuce = mysqlSelectAstuceByID($_GET['id_astuce']);
	$dataAstuce=mysql_fetch_array($resultAstuce);
	
	$toReturn .='<h3>
	<span class="to_edit"><a href="administration.php?astuce=gestion&page=1&order=astuce_date_modif">Astuces</a></span>
	<span class="to_edit"><a href="#">'.htmlspecialchars(trim($dataAstuce['jeu_nom_generique'])).'</a></span>
	<span class="to_edit"><a href="#">'.htmlspecialchars(trim($dataAstuce['plateforme_nom_generique'])).'</a></span>
	modifier</h3>';
	$toReturn .='<form action="admin_traitement_astuce.php?id_astuce='.$_GET['id_astuce'].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">echec</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">succes</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text" value="'.htmlspecialchars(trim($dataAstuce['astuce_titre'])).'"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	
	//-----------------------//
	$toReturn .='<p><label for="astuce">astuce: </label>';
	$toReturn .='<textarea id="astuce" name="astuce">'.htmlspecialchars(trim($dataAstuce['astuce'])).'</textarea>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataAstuce['astuce_date_publication'])).'"/></p>';

	//-----------------------//
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_astuce"/></p>';
	
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="astuce"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
}

?>