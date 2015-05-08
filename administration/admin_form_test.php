<?php
require_once('mysql_fonctions_test.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin test]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createTestGestionForm(){
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?test=gestion&page=1&order=test_date_modif">test</span></a>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	
	
	
	
	
	$toReturn .='<hr/>';
	
	
	
	//--------------------//
	//---------------------------form ajouter test--------------------------------//
	$toReturn .='<form action="admin_traitement_test.php" method="post" enctype="multipart/form-data">';

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
			$resultTest = mysqlSelectJeuVersionByPlateformeIdAndJeuId(htmlspecialchars(trim($dataPlateforme["id_plateforme"])),$_GET['id_jeu'] );
			if(mysql_num_rows($resultTest) != 0){
   				$toReturn .= '<option value="'.htmlspecialchars(trim($dataPlateforme["id_plateforme"])).' "disabled>'.htmlspecialchars(trim($dataPlateforme["plateforme_nom_generique"])).'</option>';
   			}
   			else{
   				$toReturn .= '<option value="'.htmlspecialchars(trim($dataPlateforme["id_plateforme"])).'">'.htmlspecialchars(trim($dataPlateforme["plateforme_nom_generique"])).'</option>';
			}			
   			$constructeur_precedent = htmlspecialchars(trim($dataConst['constructeur_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <select id="id_jeu" name="id_jeu">';
	$toReturn .='<option value="">-- jeux --</option>';
	$toReturn .='</select>';
	$toReturn .=' <input id="submit" type="submit" value="créer un test" name="submit_test"/>';

	$toReturn .='</p>';
	$toReturn .='</form>';

	//-----------------------------------------------------------------------------------------------------//
	
	$toReturn .='<hr/>';
	
	//----------------------------form filtre plateforme/jeu----------------------------------------//
	$toReturn .='<form action="admin_traitement_test.php" method="post" enctype="multipart/form-data">';
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
	$toReturn .=' <input id="submit" type="submit" value="ok" name="submit_test"/>';

	$toReturn .='</p>';
	$toReturn .='</form>';
	//--------------------------------form champ de recherche nom jeu------------------------------------//
	$toReturn .='<form action="admin_traitement_test.php" method="post" enctype="multipart/form-data">';
	$toReturn .='</p>';
	$toReturn .='<p>';
	$toReturn .='<input id="jeu_name_search" type="text" name="jeu_name_search"/>';
	$toReturn .=' <input id="submit" type="submit" value="rechercher" name="submit_test"/>';
	$toReturn .='</p>';
	$toReturn .='</form>';
	
	//-----------------------------------------------------------------------------------------------------//

	$toReturn .='<hr/>';
	
	//-----------------------------------------------------------------------------------------------------//
	//----------------------------------form avec les tests--------------------------------------------------//
	//-----------------------------------------------------------------------------------------------------//
	//-----------filtre de tri-----------//
	$toReturn .='<form action="admin_traitement_test.php" method="post" enctype="multipart/form-data">';

	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="test_date_modif"';
 	if($_GET['order']=="test_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par dernières modifiées</option>';
  	
  	$toReturn .= '<option value="test_date_creation"';
  	if($_GET['order']=="test_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par dernières créées</option>'; 
  	
  	$toReturn .= '<option value="jeu_nom_generique"';
  	if($_GET['order']=="jeu_nom_generique"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par ordre alphabétiques</option>'; 

	$toReturn .= '</select></p>';
	////-----------filtre de tri-----------//
	$nb_element_par_page=50;
	
	// -----------------------------tableau par defaut------------------------------ //
	if(!isset($_GET['id_jeu_version_plateforme']) && !isset($_GET['jeu_nom_generique'])){
	$result = mysqlSelectAllTestWithPageNumber($_GET['page'], $_GET['order'], $nb_element_par_page);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
    			<th></th>
    			<th></th>
    			<th></th>
    			<th>jeu</th>
    			<th>plateforme test</th>
    			<th>date de publication</th>
				<th colspan=3>frontpage</th>
 				<th colspan=3>version</th>
  				</tr>';
  				
  	$number = 0;
	while($data=mysql_fetch_array($result)) {
		
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		
		$resultCountTestJeuPlateformeVersion = mysqlCountTestJeuPlateformeVersion($data['id_test']);
		$dataCountTestJeuPlateformeVersion = mysql_fetch_array($resultCountTestJeuPlateformeVersion);
		
   		$toReturn .='<tr class="'.$class.' last_line">';
		
		$toReturn .='<td class="center delete_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_test.php?submit_test=delete&id_test='.htmlspecialchars(trim($data["id_test"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="administration.php?test=edit&id_test='.htmlspecialchars(trim($data["id_test"])).'"><span>modifier</span></a></td>';
		$toReturn .='<td class="center publish_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_test.php?submit_test=publish&id_test='.htmlspecialchars(trim($data["id_test"])).'"><span>publier</span></a></td>';
		$toReturn .='<td  rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["jeu_nom_generique"])).'</span></td>';
		$toReturn .='<td  rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</span></td>';
		$toReturn .='<td rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["test_date_publication"])).'</span></td>';
		
		$resultFrontpage = mysqlCountFrontpage(htmlspecialchars(trim($data["id_test"])));
		$dataFrontpage = mysql_fetch_array($resultFrontpage); 
		
		if($dataFrontpage['count'] == 0){ 
		$toReturn .= '<td class="center add_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'""><a href="administration.php?frontpage_test=add&id_test='.htmlspecialchars(trim($data["id_test"])).'" ><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>supprimer</span></a></td>';
		}
		else{
		$toReturn .= '<td class="center add_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="administration.php?frontpage_test=edit&id_test='.htmlspecialchars(trim($data["id_test"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'" ><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_frontpage_test.php?submit_frontpage_test=delete&id_test='.htmlspecialchars(trim($data["id_test"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'"><span>supprimer</span></a></td>';
		}
		
		$resultPremierTestJeuVersionPlateforme = mysqlSelectPremierTestJeuVersionPlateforme($data['id_test']);
 		$dataPremierTestJeuVersionPlateforme = mysql_fetch_array($resultPremierTestJeuVersionPlateforme);
		if($dataCountTestJeuPlateformeVersion['count']>0){
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_test.php?submit_test_jeu_version_plateforme=delete&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataPremierTestJeuVersionPlateforme["id_test_jeu_version_plateforme"])).'" ><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?test_jeu_version_plateforme=edit&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataPremierTestJeuVersionPlateforme["id_test_jeu_version_plateforme"])).'" ><span>modifier</span></a></td>';
		$toReturn .='<td>'.$dataPremierTestJeuVersionPlateforme['plateforme_nom_generique'].'</td>';
		}
		else{
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		}
		$toReturn .='</tr>';
		
		//et la on affiche le reste
		$resultTestJeuVersionPlateformeSuivant = mysqlSelectTestJeuVersionPlateformeSuivant(htmlspecialchars(trim($dataCountTestJeuPlateformeVersion["count"])),$data['id_test']);
 		
 		while($dataTestJeuVersionPlateformeSuivant = mysql_fetch_array($resultTestJeuVersionPlateformeSuivant)){
 		$toReturn .= '<tr class="'.$class.'">';
		if($dataCountTestJeuPlateformeVersion['count']>0){
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_test.php?submit_test_jeu_version_plateforme=delete&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataTestJeuVersionPlateformeSuivant["id_test_jeu_version_plateforme"])).'" ><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?test_jeu_version_plateforme=edit&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataTestJeuVersionPlateformeSuivant["id_test_jeu_version_plateforme"])).'" ><span>modifier</span></a></td>';
		$toReturn .='<td>'.$dataTestJeuVersionPlateformeSuivant['plateforme_nom_generique'].'</td>';
 		}
 		else{
 		$toReturn .='<td></td>';
 		$toReturn .='<td></td>';
 		$toReturn .='<td></td>';
 		}
 		$toReturn .='</tr>';
 		}
 		$number ++;
 		
	}
	$toReturn .='</table>';
	
	
	
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllTest();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?test=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'#resultat_recherche"> << </a>';
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
		$toReturn .= '<a href="administration.php?test=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	}	
	//-----------------------------------------------------------------------------------------------------//
	else if(isset($_GET['id_jeu_version_plateforme'])){
	$result = mysqlSelectAllTestWithPageNumberAndIdJeuVersionPlateforme($_GET['page'], $_GET['order'], $nb_element_par_page,$_GET['id_jeu_version_plateforme']);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
    			<th></th>
    			<th></th>
    			<th></th>
    			<th>jeu</th>
    			<th>plateforme test</th>
    			<th>date de publication</th>
				<th colspan=3>frontpage</th>
 				<th colspan=3>version</th>
  				</tr>';
  				
  	$number = 0;
	while($data=mysql_fetch_array($result)) {
		
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		
		$resultCountTestJeuPlateformeVersion = mysqlCountTestJeuPlateformeVersion($data['id_test']);
		$dataCountTestJeuPlateformeVersion = mysql_fetch_array($resultCountTestJeuPlateformeVersion);
		
   		$toReturn .='<tr class="'.$class.' last_line">';
		
		$toReturn .='<td class="center delete_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_test.php?submit_test=delete&id_test='.htmlspecialchars(trim($data["id_test"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="administration.php?test=edit&id_test='.htmlspecialchars(trim($data["id_test"])).'"><span>modifier</span></a></td>';
		$toReturn .='<td class="center publish_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_test.php?submit_test=publish&id_test='.htmlspecialchars(trim($data["id_test"])).'"><span>publier</span></a></td>';
		$toReturn .='<td  rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["jeu_nom_generique"])).'</span></td>';
		$toReturn .='<td  rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</span></td>';
		$toReturn .='<td rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["test_date_publication"])).'</span></td>';
		
		$resultFrontpage = mysqlCountFrontpage(htmlspecialchars(trim($data["id_test"])));
		$dataFrontpage = mysql_fetch_array($resultFrontpage); 
		
		if($dataFrontpage['count'] == 0){ 
		$toReturn .= '<td class="center add_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'""><a href="administration.php?frontpage_test=add&id_test='.htmlspecialchars(trim($data["id_test"])).'" ><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>supprimer</span></a></td>';
		}
		else{
		$toReturn .= '<td class="center add_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="administration.php?frontpage_test=edit&id_test='.htmlspecialchars(trim($data["id_test"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'" ><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_frontpage_test.php?submit_frontpage_test=delete&id_test='.htmlspecialchars(trim($data["id_test"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'"><span>supprimer</span></a></td>';
		}
		
		$resultPremierTestJeuVersionPlateforme = mysqlSelectPremierTestJeuVersionPlateforme($data['id_test']);
 		$dataPremierTestJeuVersionPlateforme = mysql_fetch_array($resultPremierTestJeuVersionPlateforme);
		if($dataCountTestJeuPlateformeVersion['count']>0){
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_test.php?submit_test_jeu_version_plateforme=delete&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataPremierTestJeuVersionPlateforme["id_test_jeu_version_plateforme"])).'" ><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?test_jeu_version_plateforme=edit&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataPremierTestJeuVersionPlateforme["id_test_jeu_version_plateforme"])).'" ><span>modifier</span></a></td>';
		$toReturn .='<td>'.$dataPremierTestJeuVersionPlateforme['plateforme_nom_generique'].'</td>';
		}
		else{
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		}
		$toReturn .='</tr>';
		
		//et la on affiche le reste
		$resultTestJeuVersionPlateformeSuivant = mysqlSelectTestJeuVersionPlateformeSuivant(htmlspecialchars(trim($dataCountTestJeuPlateformeVersion["count"])),$data['id_test']);
 		
 		while($dataTestJeuVersionPlateformeSuivant = mysql_fetch_array($resultTestJeuVersionPlateformeSuivant)){
 		$toReturn .= '<tr class="'.$class.'">';
		if($dataCountTestJeuPlateformeVersion['count']>0){
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_test.php?submit_test_jeu_version_plateforme=delete&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataTestJeuVersionPlateformeSuivant["id_test_jeu_version_plateforme"])).'" ><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?test_jeu_version_plateforme=edit&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataTestJeuVersionPlateformeSuivant["id_test_jeu_version_plateforme"])).'" ><span>modifier</span></a></td>';
		$toReturn .='<td>'.$dataTestJeuVersionPlateformeSuivant['plateforme_nom_generique'].'</td>';
 		}
 		else{
 		$toReturn .='<td></td>';
 		$toReturn .='<td></td>';
 		$toReturn .='<td></td>';
 		}
 		$toReturn .='</tr>';
 		}
 		$number ++;
 		
	}
	$toReturn .='</table>';
	
	
	
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllTestIdJeuVersionPlateforme($_GET['id_jeu_version_plateforme']);
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?test=gestion&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'&page='.($_GET['page']-1).'&order='.($_GET['order']).'#resultat_recherche"> << </a>';
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
		$toReturn .= '<a href="administration.php?test=gestion&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'&page='.($_GET['page']+1).'&order='.($_GET['order']).'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&id_jeu_version_plateforme='.$_GET['id_jeu_version_plateforme'].'"/>';
	}
	//------------------------------------------si nom generique renseigné-------------------------------------------------//
	else if(isset($_GET['jeu_nom_generique'])){
	$result = mysqlSelectAllTestWithPageNumberAndJeuNom($_GET['page'], $_GET['order'], $nb_element_par_page,$_GET['jeu_nom_generique']);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
    			<th></th>
    			<th></th>
    			<th></th>
    			<th>jeu</th>
    			<th>plateforme test</th>
    			<th>date de publication</th>
				<th colspan=3>frontpage</th>
 				<th colspan=3>version</th>
  				</tr>';
  				
  	$number = 0;
	while($data=mysql_fetch_array($result)) {
		
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		
		$resultCountTestJeuPlateformeVersion = mysqlCountTestJeuPlateformeVersion($data['id_test']);
		$dataCountTestJeuPlateformeVersion = mysql_fetch_array($resultCountTestJeuPlateformeVersion);
		
   		$toReturn .='<tr class="'.$class.' last_line">';
		
		$toReturn .='<td class="center delete_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_test.php?submit_test=delete&id_test='.htmlspecialchars(trim($data["id_test"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="administration.php?test=edit&id_test='.htmlspecialchars(trim($data["id_test"])).'"><span>modifier</span></a></td>';
		$toReturn .='<td class="center publish_item_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_test.php?submit_test=publish&id_test='.htmlspecialchars(trim($data["id_test"])).'"><span>publier</span></a></td>';
		$toReturn .='<td  rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["jeu_nom_generique"])).'</span></td>';
		$toReturn .='<td  rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</span></td>';
		$toReturn .='<td rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><span>'.htmlspecialchars(trim($data["test_date_publication"])).'</span></td>';
		
		$resultFrontpage = mysqlCountFrontpage(htmlspecialchars(trim($data["id_test"])));
		$dataFrontpage = mysql_fetch_array($resultFrontpage); 
		
		if($dataFrontpage['count'] == 0){ 
		$toReturn .= '<td class="center add_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'""><a href="administration.php?frontpage_test=add&id_test='.htmlspecialchars(trim($data["id_test"])).'" ><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>supprimer</span></a></td>';
		}
		else{
		$toReturn .= '<td class="center add_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="#" class="disabled"><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="administration.php?frontpage_test=edit&id_test='.htmlspecialchars(trim($data["id_test"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'" ><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table" rowspan="'.$dataCountTestJeuPlateformeVersion['rowspan'].'"><a href="admin_traitement_frontpage_test.php?submit_frontpage_test=delete&id_test='.htmlspecialchars(trim($data["id_test"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'"><span>supprimer</span></a></td>';
		}
		
		$resultPremierTestJeuVersionPlateforme = mysqlSelectPremierTestJeuVersionPlateforme($data['id_test']);
 		$dataPremierTestJeuVersionPlateforme = mysql_fetch_array($resultPremierTestJeuVersionPlateforme);
		if($dataCountTestJeuPlateformeVersion['count']>0){
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_test.php?submit_test_jeu_version_plateforme=delete&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataPremierTestJeuVersionPlateforme["id_test_jeu_version_plateforme"])).'" ><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?test_jeu_version_plateforme=edit&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataPremierTestJeuVersionPlateforme["id_test_jeu_version_plateforme"])).'" ><span>modifier</span></a></td>';
		$toReturn .='<td>'.$dataPremierTestJeuVersionPlateforme['plateforme_nom_generique'].'</td>';
		}
		else{
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		}
		$toReturn .='</tr>';
		
		//et la on affiche le reste
		$resultTestJeuVersionPlateformeSuivant = mysqlSelectTestJeuVersionPlateformeSuivant(htmlspecialchars(trim($dataCountTestJeuPlateformeVersion["count"])),$data['id_test']);
 		
 		while($dataTestJeuVersionPlateformeSuivant = mysql_fetch_array($resultTestJeuVersionPlateformeSuivant)){
 		$toReturn .= '<tr class="'.$class.'">';
		if($dataCountTestJeuPlateformeVersion['count']>0){
		$toReturn .='<td class="center delete_item_table"><a href="admin_traitement_test.php?submit_test_jeu_version_plateforme=delete&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataTestJeuVersionPlateformeSuivant["id_test_jeu_version_plateforme"])).'" ><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table"><a href="administration.php?test_jeu_version_plateforme=edit&id_test_jeu_version_plateforme='.htmlspecialchars(trim($dataTestJeuVersionPlateformeSuivant["id_test_jeu_version_plateforme"])).'" ><span>modifier</span></a></td>';
		$toReturn .='<td>'.$dataTestJeuVersionPlateformeSuivant['plateforme_nom_generique'].'</td>';
 		}
 		else{
 		$toReturn .='<td></td>';
 		$toReturn .='<td></td>';
 		$toReturn .='<td></td>';
 		}
 		$toReturn .='</tr>';
 		}
 		$number ++;
 		
	}
	$toReturn .='</table>';
	
	
	
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllTestJeuNom($_GET['jeu_nom_generique']);
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?test=gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'&page='.($_GET['page']-1).'&order='.($_GET['order']).'#resultat_recherche"> << </a>';
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
		$toReturn .= '<a href="administration.php?test=gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'&page='.($_GET['page']+1).'&order='.($_GET['order']).'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'"/>';
	}
	//-----------------------------------------------------------------------------------------------------//
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="test"/>';
	
	$toReturn .='</form>';
	//-----------------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------------//
	return $toReturn;
	
}
function createTestAddForm(){

	$resultJeuVersionPlateforme = mysqlSelectJeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
	$dataJeuVersionPlateforme=mysql_fetch_array($resultJeuVersionPlateforme);
	
	$toReturn .='<h3>
	<span class="to_edit"><a href="administration.php?test=gestion&page=1&order=test_date_modif">test</a></span>
	<span class="to_edit"><a href="#">'.$dataJeuVersionPlateforme['jeu_nom_generique'].'</a></span>
	créer</h3>';
	$toReturn .='<form action="admin_traitement_test.php" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=='ok'){
			$toReturn .='<p id="message_alerte" class="important_vert">ok</p>';
	}
	else if($_GET['record']=='nok'){
			$toReturn .='<p id="message_alerte" class="important_rouge">nok</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text" value="test de '.$dataJeuVersionPlateforme['jeu_nom_generique'].'"/></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataTest['test_date_publication'])).'"/></p></fieldset>';
	//-------------------//
	$toReturn .='<fieldset><legend>test effectué sur:</legend>';
	$resultAllJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($_GET['id_jeu_version_plateforme']);
	while ($dataAllJeuVersionPlateforme=mysql_fetch_array($resultAllJeuVersionPlateforme)){
		
		
		$toReturn .='<p><input type="radio" name="jeu_version_plateforme_test" value="'.$dataAllJeuVersionPlateforme['id_jeu_version_plateforme'].'"';
		if($dataAllJeuVersionPlateforme['id_jeu_version_plateforme']==$_GET['id_jeu_version_plateforme']){
			$toReturn .='checked="checked"';
		}
		$toReturn .='>'.$dataAllJeuVersionPlateforme['plateforme_nom_generique'].'</p>';
	
	
	}
	$toReturn .='</fieldset>';
	//-------------------//

	
	$toReturn .='<fieldset><legend>test valable pour:</legend>';
	$resultAllJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($_GET['id_jeu_version_plateforme']);
	while ($dataAllJeuVersionPlateforme=mysql_fetch_array($resultAllJeuVersionPlateforme)){
		$toReturn .='<p><input type="checkbox" name="liste_jeu_version_plateforme[]" value="'.$dataAllJeuVersionPlateforme['id_jeu_version_plateforme'].'" checked="checked"/>'.$dataAllJeuVersionPlateforme['plateforme_nom_generique'].'</p>';
	}
	$toReturn .='</fieldset>';
	
	
	//--------ckeditor---------//
	$toReturn .='<textarea id="corps_test" name="corps_test">'.htmlspecialchars($dataTest['test_corps']).'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'corps_test\' );
				</script>';
	//--------ckeditor---------//	
	
	
	//-----------------------//
	$toReturn .='<fieldset>';
	$toReturn .='<p><label for="note">note: </label>';
	$toReturn .='<select name="note" id="note">';	
	$toReturn .= '<option value="0">0</option>';
	$toReturn .= '<option value="1">1</option>';
	$toReturn .= '<option value="2">2</option>';
	$toReturn .= '<option value="3">3</option>';
	$toReturn .= '<option value="4">4</option>';
	$toReturn .= '<option value="5">5</option>';
	$toReturn .= '<option value="6">6</option>';
	$toReturn .= '<option value="7">7</option>';
	$toReturn .= '<option value="8">8</option>';
	$toReturn .= '<option value="9">9</option>';
	$toReturn .= '<option value="10">10</option>';
	$toReturn .='</select></p>';
	//-----------------------//
	$toReturn .='<p><label for="plus">les plus: </label>';
	$toReturn .='<textarea id="plus" name="plus"></textarea><span class="format_to_respect"> allez à la ligne entre chaque "plus"</span></p>';
	//-----------------------//
	$toReturn .='<p><label for="moins">les moins: </label>';
	$toReturn .='<textarea id="moins" name="moins"></textarea><span class="format_to_respect"> allez à la ligne entre chaque "moins"</span></p>';
	$toReturn .='</fieldset>';
	//-----------------------//
	
	$toReturn .='<fieldset id="image_fieldset" ><legend>images</legend>';
	$resultJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($_GET['id_jeu_version_plateforme']);
	while($dataJeuVersionPlateforme = mysql_fetch_array($resultJeuVersionPlateforme)){
		$toReturn .='<fieldset><legend>'.$dataJeuVersionPlateforme['plateforme_nom_generique'].'</legend>';
		
		$resultImageJeuVersionPlateforme = mysqlSelectImageJeuVersionPlateforme($dataJeuVersionPlateforme['id_jeu_version_plateforme']);
		while($dataImageJeuVersionPlateforme = mysql_fetch_array($resultImageJeuVersionPlateforme)){
				$toReturn .='<p class="image_illustration_test"><input type="radio" name="image_illustration" value="'.$dataImageJeuVersionPlateforme['url'].'" />';
				$toReturn .='<input type="checkbox" name="test_jeu_version_plateforme_liste_image[]" value="'.$dataImageJeuVersionPlateforme['url'].'"/>';
				$toReturn .='<img src="../'.$dataImageJeuVersionPlateforme['url'].'" alt=""  /></p>';
		}
		
		$toReturn .='</fieldset>';
	}
	$toReturn .='</fieldset>';
	
	$toReturn .='<fieldset id="video_fieldset" ><legend>videos</legend>';
	$resultJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($_GET['id_jeu_version_plateforme']);
	while($dataJeuVersionPlateforme = mysql_fetch_array($resultJeuVersionPlateforme)){
		$toReturn .='<fieldset><legend>'.$dataJeuVersionPlateforme['plateforme_nom_generique'].'</legend>';
		//echo "<<<<>>>>>".$dataJeuVersionPlateforme['id_jeu_version_plateforme'];
		$resultVideoJeuVersionPlateforme = mysqlSelectVideoJeuVersionPlateforme($dataJeuVersionPlateforme['id_jeu_version_plateforme']);
		while($dataVideoJeuVersionPlateforme = mysql_fetch_array($resultVideoJeuVersionPlateforme)){
				parse_str( parse_url( $dataVideoJeuVersionPlateforme['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
				$youtube_id = $my_array_of_vars['v'];
				$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
				
				$toReturn .='<p class="video_illustration_test">';
				$toReturn .='<input type="checkbox" name="test_jeu_version_plateforme_liste_video[]" value="'.$dataVideoJeuVersionPlateforme['video_url'].'"/>';
				$toReturn .='<img src="'.$src.'" alt=""  /></p>';
				
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataVideoJeuVersionPlateforme['video_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataVideoJeuVersionPlateforme['video_url']).'" type="hidden" value="'.$dataVideoJeuVersionPlateforme['video_titre'].'"/>';	

		}
		
		$toReturn .='</fieldset>';
	}
	$toReturn .='</fieldset>';
	
	
	$toReturn .='<p><input id="submit" type="submit" value="créer le test" name="submit_test"/></p>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="test"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
}
	
	
	
function createTestEditForm(){
	$resultTest = mysqlSelectTestByID($_GET['id_test']);
	$dataTest = mysql_fetch_array($resultTest);

	$toReturn .='<h3>
	<span class="to_edit"><a href="administration.php?test=gestion&page=1&order=test_date_modif">test</a></span>
	<span class="to_edit"><a href="#">'.$dataTest['jeu_nom_generique'].'</a></span>
	modifier</h3>';
	
	$toReturn .='<form action="admin_traitement_test.php?id_test='.$_GET['id_test'].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=='ok'){
			$toReturn .='<p id="message_alerte" class="important_vert">ok</p>';
	}
	else if($_GET['record']=='nok'){
			$toReturn .='<p id="message_alerte" class="important_rouge">nok</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text" value="'.htmlspecialchars(trim($dataTest['test_titre'])).'"/></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataTest['test_date_publication_non_formate'])).'"/></p></fieldset>';

	$toReturn .='</fieldset>';
	//-------------------//
	$toReturn .='<fieldset><legend>test effectué sur:</legend>';
	$resultAllJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($dataTest['id_jeu_version_plateforme']);
	while ($dataAllJeuVersionPlateforme=mysql_fetch_array($resultAllJeuVersionPlateforme)){
		
		
		$toReturn .='<p><input type="radio" name="jeu_version_plateforme_test" value="'.$dataAllJeuVersionPlateforme['id_jeu_version_plateforme'].'"';
		if($dataAllJeuVersionPlateforme['id_jeu_version_plateforme']==$dataTest['id_jeu_version_plateforme']){
			$toReturn .='checked="checked"';
		}
		$toReturn .='>'.$dataAllJeuVersionPlateforme['plateforme_nom_generique'].'</p>';
	
	
	}
	$toReturn .='</fieldset>';
	//-------------------//

	
	$toReturn .='<fieldset><legend>test valable pour:</legend>';
	$resultAllJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($dataTest['id_jeu_version_plateforme']);
	while ($dataAllJeuVersionPlateforme=mysql_fetch_array($resultAllJeuVersionPlateforme)){
		$resultTestIsJeuPlateformeVersion = mysqlTestIsJeuPlateformeVersion($dataTest['id_test'],$dataAllJeuVersionPlateforme['id_jeu_version_plateforme']);
		$dataTestIsJeuPlateformeVersion = mysql_fetch_array($resultTestIsJeuPlateformeVersion);
		
		
		$toReturn .='<p><input type="checkbox" name="liste_jeu_version_plateforme[]" value="'.$dataAllJeuVersionPlateforme['id_jeu_version_plateforme'].'"';
		if($dataTestIsJeuPlateformeVersion['count'] != 0){
		$toReturn .='checked="checked"';
		}
		$toReturn .= '/>'.$dataAllJeuVersionPlateforme['plateforme_nom_generique'].'</p>';
	}
	$toReturn .='</fieldset>';
	//--------ckeditor---------//
	$toReturn .='<textarea id="corps_test" name="corps_test">'.htmlspecialchars($dataTest['test_corps']).'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'corps_test\' );
				</script>';
	//--------ckeditor---------//	
	
	
	
	//-----------------------//
	$toReturn .='<fieldset>';
	
	$toReturn .='<p><label for="note">note: </label>';
	$toReturn .='<select name="note" id="note">';	
	$toReturn .= '<option value="0"';
		if(htmlspecialchars($dataTest['test_note']) == 0){
			$toReturn .= 'selected';
		}
	$toReturn .= '>0</option>';
	$toReturn .= '<option value="1"';
			if(htmlspecialchars($dataTest['test_note']) == 1){
			$toReturn .= 'selected';
		}
	$toReturn .= '>1</option>';
	$toReturn .= '<option value="2"';
			if(htmlspecialchars($dataTest['test_note']) == 2){
			$toReturn .= 'selected';
		}
	$toReturn .= '>2</option>';
	$toReturn .= '<option value="3"';
			if(htmlspecialchars($dataTest['test_note']) == 3){
			$toReturn .= 'selected';
		}
	$toReturn .= '>3</option>';
	$toReturn .= '<option value="4"';
			if(htmlspecialchars($dataTest['test_note']) == 4){
			$toReturn .= 'selected';
		}
	$toReturn .= '>4</option>';
	$toReturn .= '<option value="5"';
			if(htmlspecialchars($dataTest['test_note']) == 5){
			$toReturn .= 'selected';
		}
	$toReturn .= '>5</option>';
	$toReturn .= '<option value="6"';
			if(htmlspecialchars($dataTest['test_note']) == 6){
			$toReturn .= 'selected';
		}
	$toReturn .= '>6</option>';
	$toReturn .= '<option value="7"';
			if(htmlspecialchars($dataTest['test_note']) == 7){
			$toReturn .= 'selected';
		}
	$toReturn .= '>7</option>';
	$toReturn .= '<option value="8"';
			if(htmlspecialchars($dataTest['test_note']) == 8){
			$toReturn .= 'selected';
		}
	$toReturn .= '>8</option>';
	$toReturn .= '<option value="9"';
			if(htmlspecialchars($dataTest['test_note']) == 9){
			$toReturn .= 'selected';
		}
	$toReturn .= '>9</option>';
	$toReturn .= '<option value="10"';
			if(htmlspecialchars($dataTest['test_note']) == 10){
			$toReturn .= 'selected';
		}
	$toReturn .= '>10</option>';
	$toReturn .='</select></p>';
	//-----------------------//
	$toReturn .='<p><label for="plus">les plus: </label>';
	$toReturn .='<textarea id="plus" name="plus">'.htmlspecialchars($dataTest['test_plus']).'</textarea><span class="format_to_respect"> allez à la ligne entre chaque "plus"</span></p>';
	//-----------------------//
	$toReturn .='<p><label for="moins">les moins: </label>';
	$toReturn .='<textarea id="moins" name="moins">'.htmlspecialchars($dataTest['test_moins']).'</textarea><span class="format_to_respect"> allez à la ligne entre chaque "moins"</span></p>';
	$toReturn .='</fieldset>';
	//-----------------------//
	

	$toReturn .='<fieldset id="image_fieldset" ><legend>images</legend>';
	
	$resultTest = mysqlSelectIdTestJeuVersionPlateforme($_GET['id_test']);
	$dataTest = mysql_fetch_array($resultTest);
	
	$toReturn .='<fieldset><legend>illustration actuelle</legend>';
	$resultPhotoTest = mysqlSelectPhotoTest($_GET['id_test']);
	while($dataPhotoTest = mysql_fetch_array($resultPhotoTest)){
		
			$toReturn .='<p class="image_illustration_test"><input type="radio" name="image_illustration" value="'.$dataPhotoTest['url'].'"';
			
			$resultIsIllustrationTestJeuVersionPlateforme = mysqlIsIllustrationTestJeuVersionPlateforme($dataPhotoTest['url'],$_GET['id_test'],$dataTest['id_jeu_version_plateforme']);
			$dataIsIllustrationTestJeuVersionPlateforme = mysql_fetch_array($resultIsIllustrationTestJeuVersionPlateforme);
			
			if($dataIsIllustrationTestJeuVersionPlateforme['count']!=0){
					$toReturn .= 'checked';
			}
				
			$toReturn .='/>';
			
			
			
			$toReturn .='<img src="../'.$dataPhotoTest['url'].'" alt=""  /></p>';
	}
	$toReturn .='</fieldset>';
	
	

	
	$resultJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($dataTest['id_jeu_version_plateforme']);
	while($dataJeuVersionPlateforme = mysql_fetch_array($resultJeuVersionPlateforme)){
		$toReturn .='<fieldset><legend>'.$dataJeuVersionPlateforme['plateforme_nom_generique'].'</legend>';
		

		
		
		
		$resultImageJeuVersionPlateforme = mysqlSelectImageJeuVersionPlateforme($dataJeuVersionPlateforme['id_jeu_version_plateforme']);
		while($dataImageJeuVersionPlateforme = mysql_fetch_array($resultImageJeuVersionPlateforme)){
				
				$resultIsIllustrationTestJeuVersionPlateforme = mysqlIsIllustrationTestJeuVersionPlateforme($dataImageJeuVersionPlateforme['url'],$_GET['id_test'],$dataTest['id_jeu_version_plateforme']);
				$dataIsIllustrationTestJeuVersionPlateforme = mysql_fetch_array($resultIsIllustrationTestJeuVersionPlateforme);
				
				$toReturn .='<p class="image_illustration_test"><input type="radio" name="image_illustration" value="'.$dataImageJeuVersionPlateforme['url'].'"';
				
				if($dataIsIllustrationTestJeuVersionPlateforme['count']!=0){
					$toReturn .= 'checked';
				}
				
				$toReturn .='/>';
				
				
				
				$resultIsImageTestJeuVersionPlateforme = mysqlIsImageTestJeuVersionPlateforme($dataImageJeuVersionPlateforme['url'],$_GET['id_test'],$dataTest['id_jeu_version_plateforme']);
				$dataIsImageTestJeuVersionPlateforme = mysql_fetch_array($resultIsImageTestJeuVersionPlateforme);
				
				$toReturn .='<input type="checkbox" name="test_jeu_version_plateforme_liste_image[]" value="'.$dataImageJeuVersionPlateforme['url'].'"';
				
				if($dataIsImageTestJeuVersionPlateforme['count']!=0){
					$toReturn .= ' checked="checked" ';
				}
				
				$toReturn .='/>';
				$toReturn .='<img src="../'.$dataImageJeuVersionPlateforme['url'].'" alt=""  /></p>';
		}
		
		$toReturn .='</fieldset>';
	}
	$toReturn .='</fieldset>';
	
	$toReturn .='<fieldset id="video_fieldset" ><legend>videos</legend>';
	$resultJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($dataTest['id_jeu_version_plateforme']);
	while($dataJeuVersionPlateforme = mysql_fetch_array($resultJeuVersionPlateforme)){
		$toReturn .='<fieldset><legend>'.$dataJeuVersionPlateforme['plateforme_nom_generique'].'</legend>';
		//echo "<<<<>>>>>".$dataJeuVersionPlateforme['id_jeu_version_plateforme'];
		$resultVideoJeuVersionPlateforme = mysqlSelectVideoJeuVersionPlateforme($dataJeuVersionPlateforme['id_jeu_version_plateforme']);
		while($dataVideoJeuVersionPlateforme = mysql_fetch_array($resultVideoJeuVersionPlateforme)){
		
					
				$resultIsVideoTestJeuVersionPlateforme = mysqlIsVideoTestJeuVersionPlateforme($dataVideoJeuVersionPlateforme['video_url'],$_GET['id_test'],$dataTest['id_jeu_version_plateforme']);
				$dataIsVideoTestJeuVersionPlateforme = mysql_fetch_array($resultIsVideoTestJeuVersionPlateforme);
				
				parse_str( parse_url( $dataVideoJeuVersionPlateforme['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
				$youtube_id = $my_array_of_vars['v'];
				$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
				
				$toReturn .='<p class="video_illustration_test">';
				$toReturn .='<input type="checkbox" name="test_jeu_version_plateforme_liste_video[]" value="'.$dataVideoJeuVersionPlateforme['video_url'].'"';
				
				if($dataIsVideoTestJeuVersionPlateforme['count']!=0){
					$toReturn .= ' checked="checked" ';
				}
				
				$toReturn .='/>';
				
				$toReturn .='<img src="'.$src.'" alt=""  /></p>';
				
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataVideoJeuVersionPlateforme['video_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataVideoJeuVersionPlateforme['video_url']).'" type="hidden" value="'.$dataVideoJeuVersionPlateforme['video_titre'].'"/>';	

		}
		
		$toReturn .='</fieldset>';
	}
	$toReturn .='</fieldset>';
	
	
	$toReturn .='<p><input id="submit" type="submit" value="écraser toutes les versions" name="submit_test"/></p>';

	$toReturn .='<input type="hidden" id="id_test" value="'.$_GET['id_test'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="test"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	return $toReturn;
}
	
function createTestJeuVersionPlateformeEditForm(){
	$resultTest = mysqlSelectTestJeuVersionPlateformeByID($_GET['id_test_jeu_version_plateforme']);
	$dataTest = mysql_fetch_array($resultTest);
	
	$toReturn .='<h3>
	<span class="to_edit"><a href="administration.php?test=gestion&page=1&order=test_date_modif">test</a></span>
	<span class="to_edit"><a href="#">'.$dataTest['jeu_nom_generique'].'</a></span>
	<span class="to_edit"><a href="#">'.$dataTest['plateforme_nom_generique'].'</a></span>

	modifier</h3>';
	
	$toReturn .='<form action="admin_traitement_test.php?id_test_jeu_version_plateforme='.$_GET['id_test_jeu_version_plateforme'].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=='ok'){
			$toReturn .='<p id="message_alerte" class="important_vert">ok</p>';
	}
	else if($_GET['record']=='nok'){
			$toReturn .='<p id="message_alerte" class="important_rouge">nok</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text" value="'.htmlspecialchars(trim($dataTest['test_titre'])).'"/></p>';
	$toReturn .='</fieldset>';

	//--------ckeditor---------//
	$toReturn .='<textarea id="corps_test" name="corps_test">'.htmlspecialchars($dataTest['test_corps']).'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'corps_test\' );
				</script>';
	//--------ckeditor---------//	
	
	
	
	//-----------------------//
	$toReturn .='<fieldset>';
	
	$toReturn .='<p><label for="note">note: </label>';
	$toReturn .='<select name="note" id="note">';	
	$toReturn .= '<option value="0"';
		if(htmlspecialchars($dataTest['test_note']) == 0){
			$toReturn .= 'selected';
		}
	$toReturn .= '>0</option>';
	$toReturn .= '<option value="1"';
			if(htmlspecialchars($dataTest['test_note']) == 1){
			$toReturn .= 'selected';
		}
	$toReturn .= '>1</option>';
	$toReturn .= '<option value="2"';
			if(htmlspecialchars($dataTest['test_note']) == 2){
			$toReturn .= 'selected';
		}
	$toReturn .= '>2</option>';
	$toReturn .= '<option value="3"';
			if(htmlspecialchars($dataTest['test_note']) == 3){
			$toReturn .= 'selected';
		}
	$toReturn .= '>3</option>';
	$toReturn .= '<option value="4"';
			if(htmlspecialchars($dataTest['test_note']) == 4){
			$toReturn .= 'selected';
		}
	$toReturn .= '>4</option>';
	$toReturn .= '<option value="5"';
			if(htmlspecialchars($dataTest['test_note']) == 5){
			$toReturn .= 'selected';
		}
	$toReturn .= '>5</option>';
	$toReturn .= '<option value="6"';
			if(htmlspecialchars($dataTest['test_note']) == 6){
			$toReturn .= 'selected';
		}
	$toReturn .= '>6</option>';
	$toReturn .= '<option value="7"';
			if(htmlspecialchars($dataTest['test_note']) == 7){
			$toReturn .= 'selected';
		}
	$toReturn .= '>7</option>';
	$toReturn .= '<option value="8"';
			if(htmlspecialchars($dataTest['test_note']) == 8){
			$toReturn .= 'selected';
		}
	$toReturn .= '>8</option>';
	$toReturn .= '<option value="9"';
			if(htmlspecialchars($dataTest['test_note']) == 9){
			$toReturn .= 'selected';
		}
	$toReturn .= '>9</option>';
	$toReturn .= '<option value="10"';
			if(htmlspecialchars($dataTest['test_note']) == 10){
			$toReturn .= 'selected';
		}
	$toReturn .= '>10</option>';
	$toReturn .='</select></p>';
	//-----------------------//
	$toReturn .='<p><label for="plus">les plus: </label>';
	$toReturn .='<textarea id="plus" name="plus">'.htmlspecialchars($dataTest['test_plus']).'</textarea><span class="format_to_respect"> allez à la ligne entre chaque "plus"</span></p>';
	//-----------------------//
	$toReturn .='<p><label for="moins">les moins: </label>';
	$toReturn .='<textarea id="moins" name="moins">'.htmlspecialchars($dataTest['test_moins']).'</textarea><span class="format_to_respect"> allez à la ligne entre chaque "moins"</span></p>';
	$toReturn .='</fieldset>';
	//-----------------------//
	

	$toReturn .='<fieldset id="image_fieldset" ><legend>images</legend>';
	
	
	
	$toReturn .='<fieldset><legend>illustration actuelle</legend>';
	$resultPhotoTestJeuVersionPlateforme = mysqlSelectPhotoTestJeuVersionPlateforme($_GET['id_test_jeu_version_plateforme']);
	while($dataPhotoTestJeuVersionPlateforme = mysql_fetch_array($resultPhotoTestJeuVersionPlateforme)){
		
			$toReturn .='<p class="image_illustration_test"><input type="radio" name="image_illustration" value="'.$dataPhotoTestJeuVersionPlateforme['url'].'"';
			
			$resultIsIllustrationTestJeuVersionPlateforme = mysqlIsIllustrationTestJeuVersionPlateforme2($dataPhotoTestJeuVersionPlateforme['url'],$_GET['id_test_jeu_version_plateforme']);
			$dataIsIllustrationTestJeuVersionPlateforme = mysql_fetch_array($resultIsIllustrationTestJeuVersionPlateforme);
			
			if($dataIsIllustrationTestJeuVersionPlateforme['count']!=0){
					$toReturn .= 'checked';
			}
				
			$toReturn .='/>';
			
			
			
			$toReturn .='<img src="../'.$dataPhotoTestJeuVersionPlateforme['url'].'" alt=""  /></p>';
	}
	$toReturn .='</fieldset>';
	
	$result = mysqlSelectTestJeuVersionPlateformeByID($_GET['id_test_jeu_version_plateforme']);
	$data = mysql_fetch_array($result);
	
	$resultJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($data['id_jeu_version_plateforme']);
	while($dataJeuVersionPlateforme = mysql_fetch_array($resultJeuVersionPlateforme)){
		$toReturn .='<fieldset><legend>'.$dataJeuVersionPlateforme['plateforme_nom_generique'].'</legend>';




		$resultImageJeuVersionPlateforme = mysqlSelectImageJeuVersionPlateforme($dataJeuVersionPlateforme['id_jeu_version_plateforme']);
		while($dataImageJeuVersionPlateforme = mysql_fetch_array($resultImageJeuVersionPlateforme)){
				
				$resultIsIllustrationTestJeuVersionPlateforme = mysqlIsIllustrationTestJeuVersionPlateforme($dataImageJeuVersionPlateforme['url'],$data['id_test'],$data['id_jeu_version_plateforme']);
				$dataIsIllustrationTestJeuVersionPlateforme = mysql_fetch_array($resultIsIllustrationTestJeuVersionPlateforme);
				
				$toReturn .='<p class="image_illustration_test"><input type="radio" name="image_illustration" value="'.$dataImageJeuVersionPlateforme['url'].'"';
				
				if($dataIsIllustrationTestJeuVersionPlateforme['count']!=0){
					$toReturn .= 'checked';
				}
				
				$toReturn .='/>';
				
				
				
				$resultIsImageTestJeuVersionPlateforme = mysqlIsImageTestJeuVersionPlateforme($dataImageJeuVersionPlateforme['url'],$data['id_test'],$data['id_jeu_version_plateforme']);
				$dataIsImageTestJeuVersionPlateforme = mysql_fetch_array($resultIsImageTestJeuVersionPlateforme);
				
				$toReturn .='<input type="checkbox" name="test_jeu_version_plateforme_liste_image[]" value="'.$dataImageJeuVersionPlateforme['url'].'"';
				
				if($dataIsImageTestJeuVersionPlateforme['count']!=0){
					$toReturn .= ' checked="checked" ';
				}
				
				$toReturn .='/>';
				$toReturn .='<img src="../'.$dataImageJeuVersionPlateforme['url'].'" alt=""  /></p>';
		}
		
		
		
		
		$toReturn .='</fieldset>';
	}
	


	
	$toReturn .='</fieldset>';//fin fieldset image
	
	$toReturn .='<fieldset id="video_fieldset" ><legend>videos</legend>';
	
	
	$result = mysqlSelectTestJeuVersionPlateformeByID($_GET['id_test_jeu_version_plateforme']);
	$data = mysql_fetch_array($result);
	
	$resultJeuVersionPlateforme = mysqlSelectAllJeuVersionPlateforme($data['id_jeu_version_plateforme']);
	while($dataJeuVersionPlateforme = mysql_fetch_array($resultJeuVersionPlateforme)){
		$toReturn .='<fieldset><legend>'.$dataJeuVersionPlateforme['plateforme_nom_generique'].'</legend>';
		//echo "<<<<>>>>>".$dataJeuVersionPlateforme['id_jeu_version_plateforme'];
		$resultVideoJeuVersionPlateforme = mysqlSelectVideoJeuVersionPlateforme($dataJeuVersionPlateforme['id_jeu_version_plateforme']);
		while($dataVideoJeuVersionPlateforme = mysql_fetch_array($resultVideoJeuVersionPlateforme)){
		
					
				$resultIsVideoTestJeuVersionPlateforme = mysqlIsVideoTestJeuVersionPlateforme($dataVideoJeuVersionPlateforme['video_url'],$data['id_test'],$data['id_jeu_version_plateforme']);
				$dataIsVideoTestJeuVersionPlateforme = mysql_fetch_array($resultIsVideoTestJeuVersionPlateforme);
				
				parse_str( parse_url( $dataVideoJeuVersionPlateforme['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
				$youtube_id = $my_array_of_vars['v'];
				$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
				
				$toReturn .='<p class="video_illustration_test">';
				$toReturn .='<input type="checkbox" name="test_jeu_version_plateforme_liste_video[]" value="'.$dataVideoJeuVersionPlateforme['video_url'].'"';
				
				if($dataIsVideoTestJeuVersionPlateforme['count']!=0){
					$toReturn .= ' checked="checked" ';
				}
				
				$toReturn .='/>';
				
				$toReturn .='<img src="'.$src.'" alt=""  /></p>';
				
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataVideoJeuVersionPlateforme['video_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataVideoJeuVersionPlateforme['video_url']).'" type="hidden" value="'.$dataVideoJeuVersionPlateforme['video_titre'].'"/>';	

		}
		
		$toReturn .='</fieldset>';
	}
	
	
	
	
	$toReturn .='</fieldset>';
	
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_test"/></p>';

	$toReturn .='<input type="hidden" id="id_test" value="'.$_GET['id_test'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="test"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
}


function deleteTousCaracteresSpeciaux($chaine)
{    
    
    $accents = Array("/é/", "/è/", "/ê/","/ë/", "/ç/", "/à/", "/â/","/á/","/ä/","/ã/","/å/", "/î/", "/ï/", "/í/", "/ì/", "/ù/", "/ô/", "/ò/", "/ó/", "/ö/");
    $sans = Array("e", "e", "e", "e", "c", "a", "a","a", "a","a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
    
    $chaine = preg_replace($accents, $sans,$chaine);  
    $chaine = preg_replace('#[^A-Za-z0-9]#','_',$chaine);
	   
    return $chaine; 
}


?>