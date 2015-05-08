<?php

require_once('mysql_fonctions_jeu.php');
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
							//[formjeu]//
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//

function createJeuGestionForm(){	

	
	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?jeu=gestion&page=1&order=jeu_date_modif">jeux</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}

	$toReturn .='<hr/>';
	//--------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_jeu.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p><input id="submit" type="submit" value="créer une fiche de jeu" name="submit_jeu"/></p>';
	$toReturn .='</form>';
	//--------------------------------------------------------------------//

	$toReturn .='<hr/>';

	
	//--------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_jeu.php" method="post" enctype="multipart/form-data">';

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
	$toReturn .=' <input id="submit" type="submit" value="ok" name="submit_jeu"/>';
	$toReturn .='</form>';
	//--------------------------------------------------------------------//
	

	//--------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_jeu.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p><select name="plateforme_select" id="plateforme_select">';	
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

	$toReturn .=' <input id="submit" type="submit" value="ok" name="submit_plateforme"/>';
	$toReturn .='</p>';
	$toReturn .='</form>';
	//--------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_jeu.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p>';
	$toReturn .='<input id="jeu_name_search" type="text" name="jeu_name_search"/>';
	$toReturn .=' <input id="submit" type="submit" value="rechercher" name="submit_jeu"/>';
	$toReturn .='</p>';
	$toReturn .='</form>';
	//--------------------------------------------------------------------//
	
	
	$toReturn .= '<hr/>';
	
	//--------------------------------------------------------------------//
	//-------------------------tableau de resultat------------------------//
	//--------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_jeu.php" method="post" enctype="multipart/form-data">';

	$toReturn .= '<p><select id="order" name="order">';
	$toReturn .= '<option value="jeu_date_modif">---</option>';
  	$toReturn .= '<option value="jeu_date_modif"';
 	if($_GET['order']=="jeu_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="jeu_date_creation"';
  	if($_GET['order']=="jeu_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers créés</option>'; 
 	
 	
  	$toReturn .= '<option value="jeu_nom_generique"';
  	if($_GET['order']=="jeu_nom_generique"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par ordre alphabétiques</option>'; 
	$toReturn .= '</select></p>';
	
	//--------------------------------------------------------------------//
	
	$nb_element_par_page=50;
	
	//-------------------- page gestion par defaut--------------------------//
	if(!isset($_GET['jeu_nom_generique']) && !isset($_GET['id_plateforme']) && !isset($_GET['id_jeu'])){
	
	
	$result = mysqlSelectAllJeuxWithPageNumber($_GET['page'],$_GET['order'],$nb_element_par_page);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
				<th rowspan=2></th>
				<th rowspan=2></th>
    			<th rowspan=2>jeu</th>
    			<th rowspan=2>développeur</th>
    			<th colspan=4>versions</th>
    			
  				</tr>';
  				
  	$toReturn .='<tr>
  
				<th>plateforme</th>
				<th>pal</th>
    			<th>jp</th>
    			<th>us</th>
    			
  				</tr>';
	$number = 0;
	while($data=mysql_fetch_array($result)) {
	
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		
		$resultCountJeuVersionPlateforme = mysqlCountJeuVersionPlateforme($data['id_jeu']);
		$dataCountJeuVersionPlateforme = mysql_fetch_array($resultCountJeuVersionPlateforme);
		
		$toReturn .='<tr class="'.$class.' last_line">';
		$toReturn .='<td class="center delete_item_table" rowspan="'.$dataCountJeuVersionPlateforme['rowspan'].'"><a href="admin_traitement_jeu.php?submit_jeu=delete&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'&id_plateforme='.$_GET['id_plateforme'].'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table" rowspan="'.$dataCountJeuVersionPlateforme['rowspan'].'"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'"><span>modifier</span></a></td>';
		
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['rowspan'].'">'.$data['jeu_nom_generique'].'</td>';
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['rowspan'].'">'.$data['developpeur_nom'].'</td>';
		
		//------------------on affiche la premiere ligne----------------//
		$resultPremierJeuVersionPlateforme = mysqlSelectPremierJeuVersionPlateforme($data['id_jeu']);
 		$dataPremierJeuVersionPlateforme = mysql_fetch_array($resultPremierJeuVersionPlateforme);
 		
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataPremierJeuVersionPlateforme["plateforme_nom_generique"])).'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		}
		else{
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		}
		$toReturn .='</tr>';
		
		//------------------on affiche les autres lignes----------------//
		$resultJeuVersionPlateformeSuivant = mysqlSelectJeuVersionPlateformeSuivant(htmlspecialchars(trim($dataCountJeuVersionPlateforme["count"])),$data['id_jeu']);
 		
 		while($dataJeuVersionPlateformeSuivant = mysql_fetch_array($resultJeuVersionPlateformeSuivant)){
 		$toReturn .= '<tr class="'.$class.'">';
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataJeuVersionPlateformeSuivant["plateforme_nom_generique"])).'</span></td>';

		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
 		}
 		else{
		$toReturn .='<td></td>';
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


	/* ------page------- */
	$resultDev = mysqlSelectAllJeux();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	/* ------page------- */
	}
	//-------------------- fin page gestion par defaut--------------------------//



	//-------------------- page gestion si nom jeu renseigné--------------------------//
	else if($_GET['jeu_nom_generique']){
	

	$resultCount = mysqlSelectCountAllJeuxWithName($_GET['jeu_nom_generique']);
	$dataCount=mysql_fetch_array($resultCount);
	
	$toReturn .= '<p  class="resultat_recherche">résultat(s) pour "'.$_GET['jeu_nom_generique'].'": <span>'.$dataCount['count'].'</span></p>';
	$result = mysqlSelectAllJeuxWithNameAndWithPageNumber($_GET['page'],$_GET['jeu_nom_generique'],$nb_element_par_page,$_GET['order']);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
				<th rowspan=2></th>
				<th rowspan=2></th>
    			<th rowspan=2>jeu</th>
    			<th rowspan=2>developpeur</th>
    			<th colspan=4>versions</th>
    			
  				</tr>';
  				
  	$toReturn .='<tr>
  
				<th>plateforme</th>
				<th>pal</th>
    			<th>jp</th>
    			<th>us</th>
    			
  				</tr>';
	$number = 0;
	while($data=mysql_fetch_array($result)) {
	
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		
		$resultCountJeuVersionPlateforme = mysqlCountJeuVersionPlateforme($data['id_jeu']);
		$dataCountJeuVersionPlateforme = mysql_fetch_array($resultCountJeuVersionPlateforme);
		
		$toReturn .='<tr class="'.$class.' last_line">';
		$toReturn .='<td class="center delete_item_table" rowspan="'.$dataCountJeuVersionPlateforme['count'].'"><a href="admin_traitement_jeu.php?submit_jeu=delete&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'&id_plateforme='.$_GET['id_plateforme'].'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table" rowspan="'.$dataCountJeuVersionPlateforme['count'].'"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'"><span>modifier</span></a></td>';
		
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['count'].'">'.$data['jeu_nom_generique'].'</td>';
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['count'].'">'.$data['developpeur_nom'].'</td>';
		
		//------------------on affiche la premiere ligne----------------//
		$resultPremierJeuVersionPlateforme = mysqlSelectPremierJeuVersionPlateforme($data['id_jeu']);
 		$dataPremierJeuVersionPlateforme = mysql_fetch_array($resultPremierJeuVersionPlateforme);
 		
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataPremierJeuVersionPlateforme["plateforme_nom_generique"])).'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		}
		else{
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		}
		$toReturn .='</tr>';
		
		//------------------on affiche les autres lignes----------------//
		$resultJeuVersionPlateformeSuivant = mysqlSelectJeuVersionPlateformeSuivant(htmlspecialchars(trim($dataCountJeuVersionPlateforme["count"])),$data['id_jeu']);
 		
 		while($dataJeuVersionPlateformeSuivant = mysql_fetch_array($resultJeuVersionPlateformeSuivant)){
 		$toReturn .= '<tr class="'.$class.'">';
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataJeuVersionPlateformeSuivant["plateforme_nom_generique"])).'</span></td>';

		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
 		}
 		else{
		$toReturn .='<td></td>';
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
	

	// ------page------- /
	
	$resultCount = mysqlSelectCountAllJeuxWithName($_GET['jeu_nom_generique']);
	$dataCount=mysql_fetch_array($resultCount);
	$toReturn .='<input type="hidden" id="jeu_nom_generique_search" value="'.$_GET['jeu_nom_generique'].'"/>';

	$nbElements = $dataCount['count'];
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']-1).'&jeu_nom_generique='.$_GET['jeu_nom_generique'].'#resultat_recherche"> << </a>';
	}
	$toReturn .='<select name="page" class="page_selector_jeu_nom_generique_search">';
	for($i = 1; $i <= ceil($nbElements/$nb_element_par_page); $i++){
		$toReturn .= '<option value="'.$i.'"';
		if($i == $_GET['page']){
			$toReturn .= 'selected="selected"';
		}
		$toReturn .= '>'.$i.'</option>';
	}
	$toReturn .='</select>';
	if($_GET['page']!=ceil($nbElements/$nb_element_par_page)){
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']+1).'&jeu_nom_generique='.$_GET['jeu_nom_generique'].'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'"/>';
	
	}
	//-------------------- fin page gestion si nom jeu renseigné--------------------------//

	
	//-------------------- page gestion si plateforme renseigné--------------------------//

	else if($_GET['id_plateforme']){
	

	$resultCount = mysqlSelectCountAllJeuxWithPlateforme($_GET['id_plateforme']);
	$dataCount=mysql_fetch_array($resultCount);
	
	$toReturn .= '<p  class="resultat_recherche">résultat(s) pour "'.$dataCount['plateforme_nom_generique'].'": <span>'.$dataCount['count'].'</span></p>';
	$result = mysqlSelectAllJeuxWithPlateformeAndWithPageNumber($_GET['page'],$_GET['id_plateforme'],$nb_element_par_page,$_GET['order']);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
				<th rowspan=2></th>
				<th rowspan=2></th>
    			<th rowspan=2>jeu</th>
    			<th rowspan=2>developpeur</th>
    			<th colspan=4>versions</th>
    			
  				</tr>';
  				
  	$toReturn .='<tr>
  
				<th>plateforme</th>
				<th>pal</th>
    			<th>jp</th>
    			<th>us</th>
    			
  				</tr>';
	$number = 0;
	while($data=mysql_fetch_array($result)) {
	
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		
		$resultCountJeuVersionPlateforme = mysqlCountJeuVersionPlateforme($data['id_jeu']);
		$dataCountJeuVersionPlateforme = mysql_fetch_array($resultCountJeuVersionPlateforme);
		
		$toReturn .='<tr class="'.$class.' last_line">';
		$toReturn .='<td class="center delete_item_table" rowspan="'.$dataCountJeuVersionPlateforme['count'].'"><a href="admin_traitement_jeu.php?submit_jeu=delete&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'&id_plateforme='.$_GET['id_plateforme'].'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table" rowspan="'.$dataCountJeuVersionPlateforme['count'].'"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'"><span>modifier</span></a></td>';
		
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['count'].'">'.$data['jeu_nom_generique'].'</td>';
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['count'].'">'.$data['developpeur_nom'].'</td>';
		
		//------------------on affiche la premiere ligne----------------//
		$resultPremierJeuVersionPlateforme = mysqlSelectPremierJeuVersionPlateforme($data['id_jeu']);
 		$dataPremierJeuVersionPlateforme = mysql_fetch_array($resultPremierJeuVersionPlateforme);
 		
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataPremierJeuVersionPlateforme["plateforme_nom_generique"])).'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		}
		else{
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		}
		$toReturn .='</tr>';
		
		//------------------on affiche les autres lignes----------------//
		$resultJeuVersionPlateformeSuivant = mysqlSelectJeuVersionPlateformeSuivant(htmlspecialchars(trim($dataCountJeuVersionPlateforme["count"])),$data['id_jeu']);
 		
 		while($dataJeuVersionPlateformeSuivant = mysql_fetch_array($resultJeuVersionPlateformeSuivant)){
 		$toReturn .= '<tr class="'.$class.'">';
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataJeuVersionPlateformeSuivant["plateforme_nom_generique"])).'</span></td>';

		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
 		}
 		else{
		$toReturn .='<td></td>';
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

	// ------page------- /
	
	$resultCount = mysqlSelectCountAllJeuxWithPlateforme($_GET['id_plateforme']);
	$dataCount=mysql_fetch_array($resultCount);
	$toReturn .='<input type="hidden" id="jeu_nom_generique_search" value="'.$_GET['jeu_nom_generique'].'"/>';

	$nbElements = $dataCount['count'];
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']-1).'&jeu_nom_generique='.$_GET['jeu_nom_generique'].'#resultat_recherche"> << </a>';
	}
	$toReturn .='<select name="page" class="page_selector_jeu_nom_generique_search">';
	for($i = 1; $i <= ceil($nbElements/$nb_element_par_page); $i++){
		$toReturn .= '<option value="'.$i.'"';
		if($i == $_GET['page']){
			$toReturn .= 'selected="selected"';
		}
		$toReturn .= '>'.$i.'</option>';
	}
	$toReturn .='</select>';
	if($_GET['page']!=ceil($nbElements/$nb_element_par_page)){
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']+1).'&jeu_nom_generique='.$_GET['jeu_nom_generique'].'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&id_plateforme='.$_GET['id_plateforme'].'"/>';
	
	}
	//-------------------- page gestion si plateforme renseigné--------------------------//

	//-------------------- page gestion si id_jeu renseigné--------------------------//
	else if($_GET['id_jeu']){
	

	$resultCount = mysqlSelectCountAllJeuxWithID(htmlspecialchars(trim($_GET['id_jeu'])));
	$dataCount=mysql_fetch_array($resultCount);
	
	$result = mysqlSelectJeuByID(htmlspecialchars(trim($_GET['id_jeu'])));
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
				<th rowspan=2></th>
				<th rowspan=2></th>
    			<th rowspan=2>jeu</th>
    			<th rowspan=2>developpeur</th>
    			<th colspan=4>versions</th>
    			
  				</tr>';
  				
  	$toReturn .='<tr>
  
				<th>plateforme</th>
				<th>pal</th>
    			<th>jp</th>
    			<th>us</th>
    			
  				</tr>';
	$number = 0;
	while($data=mysql_fetch_array($result)) {
	
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		
		$resultCountJeuVersionPlateforme = mysqlCountJeuVersionPlateforme($data['id_jeu']);
		$dataCountJeuVersionPlateforme = mysql_fetch_array($resultCountJeuVersionPlateforme);
		
		$toReturn .='<tr class="'.$class.' last_line">';
		$toReturn .='<td class="center delete_item_table" rowspan="'.$dataCountJeuVersionPlateforme['count'].'"><a href="admin_traitement_jeu.php?submit_jeu=delete&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'&id_plateforme='.$_GET['id_plateforme'].'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .='<td class="center edit_item_table" rowspan="'.$dataCountJeuVersionPlateforme['count'].'"><a href="administration.php?jeu=edit&id_jeu='.htmlspecialchars(trim($data["id_jeu"])).'"><span>modifier</span></a></td>';
		
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['count'].'">'.$data['jeu_nom_generique'].'</td>';
		$toReturn .='<td rowspan="'.$dataCountJeuVersionPlateforme['count'].'">'.$data['developpeur_nom'].'</td>';
		
		//------------------on affiche la premiere ligne----------------//
		$resultPremierJeuVersionPlateforme = mysqlSelectPremierJeuVersionPlateforme($data['id_jeu']);
 		$dataPremierJeuVersionPlateforme = mysql_fetch_array($resultPremierJeuVersionPlateforme);
 		
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataPremierJeuVersionPlateforme["plateforme_nom_generique"])).'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataPremierJeuVersionPlateforme['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		}
		else{
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		$toReturn .='<td></td>';
		}
		$toReturn .='</tr>';
		
		//------------------on affiche les autres lignes----------------//
		$resultJeuVersionPlateformeSuivant = mysqlSelectJeuVersionPlateformeSuivant(htmlspecialchars(trim($dataCountJeuVersionPlateforme["count"])),$data['id_jeu']);
 		
 		while($dataJeuVersionPlateformeSuivant = mysql_fetch_array($resultJeuVersionPlateformeSuivant)){
 		$toReturn .= '<tr class="'.$class.'">';
		if($dataCountJeuVersionPlateforme['count']>0){
		$toReturn .='<td><span>'.htmlspecialchars(trim($dataJeuVersionPlateformeSuivant["plateforme_nom_generique"])).'</span></td>';

		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'pal');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'jp');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
		
		$resultIsRegionJeuVersionPlateforme = mysqlIsRegionJeuVersionPlateforme($dataJeuVersionPlateformeSuivant['id_jeu_version_plateforme'],'us');
		$dataIsRegionJeuVersionPlateforme = mysql_fetch_array($resultIsRegionJeuVersionPlateforme);
		$toReturn .='<td class="'.$dataIsRegionJeuVersionPlateforme['class'].'"><span>'.$dataIsRegionJeuVersionPlateforme['count'].'</span></td>';
 		}
 		else{
		$toReturn .='<td></td>';
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
	

	// ------page------- /
	
	$resultCount = mysqlSelectCountAllJeuxWithName($_GET['jeu_nom_generique']);
	$dataCount=mysql_fetch_array($resultCount);
	$toReturn .='<input type="hidden" id="jeu_nom_generique_search" value="'.$_GET['jeu_nom_generique'].'"/>';

	$nbElements = $dataCount['count'];
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']-1).'&jeu_nom_generique='.$_GET['jeu_nom_generique'].'#resultat_recherche"> << </a>';
	}
	$toReturn .='<select name="page" class="page_selector_jeu_nom_generique_search">';
	for($i = 1; $i <= ceil($nbElements/$nb_element_par_page); $i++){
		$toReturn .= '<option value="'.$i.'"';
		if($i == $_GET['page']){
			$toReturn .= 'selected="selected"';
		}
		$toReturn .= '>'.$i.'</option>';
	}
	$toReturn .='</select>';
	if($_GET['page']!=ceil($nbElements/$nb_element_par_page)){
		$toReturn .= '<a href="administration.php?jeu=gestion&page='.($_GET['page']+1).'&jeu_nom_generique='.$_GET['jeu_nom_generique'].'#resultat_recherche"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&jeu_nom_generique='.$_GET['jeu_nom_generique'].'"/>';
	
	}
	//--------------------fin page gestion si id jeu renseigné--------------------------//
	
	
	
	
		
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="jeu"/>';
	
		

	$toReturn .='</form>';
		
	

	
	return $toReturn;
}
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
							//[formjeu]//
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
function createJeuAddForm(){
	$toReturn = '';
	$toReturn .='<h3>
	<span class="to_edit"><a href="administration.php?jeu=gestion&page=1&order=jeu_date_modif">jeux</a></span>
	ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}

	$toReturn .='<form action="admin_traitement_jeu.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	//---------------------//
	$toReturn .='<p>';
    $toReturn .='<label for="jeu_nom_generique">nom générique: </label>';
	$toReturn .='<input id="jeu_nom_generique" type="text" name="jeu_nom_generique"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	//---------------------//
	$toReturn .='<p><label for="id_genre">genre: </label>';
	$toReturn .='<select name="id_genre" id="id_genre">';
	$toReturn .='<option value="NULL"">-- genre --</option>'; 	
	$resultGenre = mysqlSelectAllGenres();
	while($dataGenre=mysql_fetch_array($resultGenre)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($dataGenre["id_genre"])).'">'.htmlspecialchars(trim($dataGenre["genre_nom"])).'</option>'; 
	}
	$toReturn .='</select></p>';
	//---------------------//
	$toReturn .= '<p><label for="developpeur_name">développeur :</label>';
	$toReturn .= '<input list="developpeur" type="text" id="developpeur_name" name="developpeur_name">';
	$toReturn .= '<datalist id="developpeur">';
	$resultDev = mysqlSelectAllDeveloppeurs();
	while($dataDev=mysql_fetch_array($resultDev)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($dataDev["developpeur_nom"])).'"></option>';
	}
	$toReturn .= '</datalist></p>';
	//---------------------//
	$toReturn .='<p><label for="id_nombre_joueur_offline">nb de joueurs offline: </label>';
	$toReturn .='<select name="id_nombre_joueur_offline" id="id_nombre_joueur_offline">';	
	$toReturn .='<option value="NULL">-- nb de joueurs offline --</option>';
	$result = mysqlSelectAllNbJoueurs();
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($data["id_nombre_joueur"])).'"';
   		$toReturn .= '>';
   		$toReturn .= htmlspecialchars(trim($data["nombre_joueur_nom"])).'</option>'; 
	}
	$toReturn .='</select></p>';
	//---------------------//
	//---------------------//
	$toReturn .='<p><label for="id_nombre_joueur_online">nb de joueurs online: </label>';
	$toReturn .='<select name="id_nombre_joueur_online" id="id_nombre_joueur_online">';
	$toReturn .='<option value="NULL">-- pas de mode online --</option>';	
	$result = mysqlSelectAllNbJoueurs();
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($data["id_nombre_joueur"])).'"';
   		$toReturn .= '>';
   		$toReturn .= htmlspecialchars(trim($data["nombre_joueur_nom"])).'</option>'; 
	}
	$toReturn .='</select></p>';
	//---------------------//
	$toReturn .='<p> <label for="jeu_descriptif">descriptif: </label>';
	$toReturn .='<textarea id ="jeu_descriptif" name="jeu_descriptif"rows="4" cols="50">';
	$toReturn .='</textarea></p>';
	//---------------------//
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_jeu"/></p>';
	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="jeu"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="edit"/>';
		

	$toReturn .='</form>';
	return $toReturn;
}

//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
							//[formjeu]//
//----------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------//
function createJeuEditForm(){
	$result = mysqlSelectJeuByID($_GET["id_jeu"]);
	$data = mysql_fetch_array($result);
	$toReturn = '';
	$toReturn .='<h3>';
	$toReturn .='<span class="to_edit"><a href="administration.php?jeu=gestion&page=1&order=jeu_date_modif">jeux</a></span>';
	$toReturn .='<span class="to_edit"><a href="administration.php?jeu=gestion&page=1&order=jeu_date_modif">modifier</a></span>';
	$toReturn .= htmlspecialchars(trim($data["jeu_nom_generique"]));
	$toReturn .='</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_jeu.php?id_jeu='.$_GET["id_jeu"].'" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	//---------------------//
	$toReturn .='<p>';
    $toReturn .='<label for="jeu_nom_generique">nom générique: </label>';
	$toReturn .='<input id="jeu_nom_generique" type="text" name="jeu_nom_generique" value="'.htmlspecialchars(trim($data["jeu_nom_generique"])).'"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	//---------------------//
	$toReturn .='<p><label for="id_genre">genre: </label>';
	$toReturn .='<select name="id_genre" id="id_genre">';	
	$toReturn .='<option value="NULL"">-- genre --</option>'; 
	$resultGenre = mysqlSelectAllGenres();
	while($dataGenre=mysql_fetch_array($resultGenre)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($dataGenre["id_genre"])).'"';
   		if(htmlspecialchars(trim($dataGenre["id_genre"])) == htmlspecialchars(trim($data["id_genre"]))){
   			$toReturn .= 'selected="selected"';
   		}
   		$toReturn .= '>';
   		$toReturn .= htmlspecialchars(trim($dataGenre["genre_nom"])).'</option>'; 
	}
	$toReturn .='</select></p>';
	//---------------------//
	$toReturn .= '<p><label for="developpeur_name">développeur :</label>';
	$toReturn .= '<input list="developpeur" type="text" id="developpeur_name" name="developpeur_name" value="'.htmlspecialchars(trim($data["developpeur_nom"])).'">';
	$toReturn .= '<datalist id="developpeur">';
	$resultDev = mysqlSelectAllDeveloppeurs();
	while($dataDev=mysql_fetch_array($resultDev)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($dataDev["developpeur_nom"])).'"></option>';
	}
	$toReturn .= '</datalist></p>';
	//---------------------//
	$toReturn .='<p><label for="id_nombre_joueur_offline">nb de joueurs offline: </label>';
	$toReturn .='<select name="id_nombre_joueur_offline" id="id_nombre_joueur_offline">';	
	$toReturn .='<option value="NULL">-- nb de joueurs offline --</option>';
	$resultNbJoueur = mysqlSelectAllNbJoueurs();
	while($dataNbJoueur=mysql_fetch_array($resultNbJoueur)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($dataNbJoueur["id_nombre_joueur"])).'"';
   		if(htmlspecialchars(trim($dataNbJoueur["id_nombre_joueur"])) == htmlspecialchars(trim($data["id_nbj_offline"]))){
   				$toReturn .= 'selected="selected"';
   		}
   		$toReturn .= '>';
   		$toReturn .= htmlspecialchars(trim($dataNbJoueur["nombre_joueur_nom"])).'</option>'; 
   	}
	$toReturn .='</select></p>';
	//---------------------//
	//---------------------//
	$toReturn .='<p><label for="id_nombre_joueur_online">nb de joueurs online: </label>';
	$toReturn .='<select name="id_nombre_joueur_online" id="id_nombre_joueur_online">';	
	$toReturn .='<option value="NULL">-- nb de joueurs online --</option>';
	$resultNbJoueur = mysqlSelectAllNbJoueurs();
	while($dataNbJoueur=mysql_fetch_array($resultNbJoueur)) {
   		$toReturn .= '<option value="'.htmlspecialchars(trim($dataNbJoueur["id_nombre_joueur"])).'"';
   		if(htmlspecialchars(trim($dataNbJoueur["id_nombre_joueur"])) == htmlspecialchars(trim($data["id_nbj_online"]))){
   				$toReturn .= 'selected="selected"';
   		}
   		$toReturn .= '>';
   		$toReturn .= htmlspecialchars(trim($dataNbJoueur["nombre_joueur_nom"])).'</option>'; 
   	}
	$toReturn .='</select></p>';
	//---------------------//
	$toReturn .='<p> <label for="jeu_descriptif">descriptif: </label>';
	$toReturn .='<textarea id ="jeu_descriptif" name="jeu_descriptif"rows="4" cols="50">';
	$toReturn .= htmlspecialchars(trim($data["jeu_descriptif"]));
	$toReturn .='</textarea></p>';
	//---------------------//
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_jeu"/></p>';
	
	$toReturn .= '<hr/>';

	//---------------------//

	
	
	$toReturn .='<fieldset id="tableau_version">';
	
	$resultCountJeuVersionPlateforme = mysqlCountJeuVersionPlateformeByJeuID($_GET['id_jeu']);
	$dataCountVersionPlateforme=mysql_fetch_array($resultCountJeuVersionPlateforme);
	
	if($dataCountVersionPlateforme['count']>0){
		$plateforme_precedent = "";
			
		$toReturn .='<table>
					<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>plateforme</th>
					<th colspan="3">pal</th>
    				<th colspan="3">jp</th>
    				<th colspan="3">us</th>
  					</tr>';
	
		$resultJeuVersionPlateforme = mysqlSelectJeuVersionPlateformeByJeuID($data['id_jeu']);
		while($dataVersionPlateforme=mysql_fetch_array($resultJeuVersionPlateforme)) {
			
				$toReturn .='<tr>
				
				<td class="center delete_item_table">
					<a href="admin_traitement_jeu_version_plateforme.php?submit_jeu_version_plateforme=delete&id_jeu_version_plateforme='.$dataVersionPlateforme['id_jeu_version_plateforme'].'&id_jeu='.$data['id_jeu'].'"><span>supprimer</span></a>
				</td>
				
				<td class="center image_item_table">
					<a href="administration.php?jeu_version_plateforme_image=add&id_jeu_version_plateforme='.$dataVersionPlateforme['id_jeu_version_plateforme'].'"><span>gérer les images</span></a>
				</td>
				
				<td class="center video_item_table">
					<a href="administration.php?jeu_version_plateforme_video=add&id_jeu_version_plateforme='.$dataVersionPlateforme['id_jeu_version_plateforme'].'"><span>gérer les videos</span></a>
				</td>
				
				<td>
					'.$dataVersionPlateforme['plateforme_nom_generique'].'
				</td>';
				
				$resultCountJeuVersionRegion = mysqlCountJeuVersionRegionByJeuVersionPlateformeIDAndRegion($dataVersionPlateforme['id_jeu_version_plateforme'],'pal');
				$dataCountVersionPlateforme=mysql_fetch_array($resultCountJeuVersionRegion);
				if($dataCountVersionPlateforme['count']!=0){
					$toReturn .='
					<td class="center add_item_table">
					<a href="#" class="disabled"><span>ajouter</span></a>
					</td>
					
					<td class="center edit_item_table">
					<a href="administration.php?jeu_version_region=edit&id_jeu_version_region='.$dataCountVersionPlateforme['id_jeu_version_region'].'"><span>modifier</span></a>
					</td>
					
					<td class="center delete_item_table">
					<a href="admin_traitement_jeu_version_region.php?submit_jeu_version_region=delete&id_jeu_version_region='.$dataCountVersionPlateforme['id_jeu_version_region'].'&id_jeu='.$data['id_jeu'].'"><span>supprimer</span></a>
					</td>
					';
				}
				else{
					$toReturn .='
					<td class="center add_item_table">
					<a href="admin_traitement_jeu_version_plateforme.php?submit_jeu_version_plateforme=add_region&region=pal&id_jeu_version_plateforme='.$dataVersionPlateforme['id_jeu_version_plateforme'].'&id_jeu='.$data['id_jeu'].'"><span>ajouter</span></a>
					</td>
					
					<td class="center edit_item_table">
					<a href="#" class="disabled"><span>modifier</span></a>
					</td>
					
					<td class="center delete_item_table">
					<a href="#" class="disabled"><span>ajouter</span></a>
					</td>
					';
				}
				
				
				$resultCountJeuVersionRegion = mysqlCountJeuVersionRegionByJeuVersionPlateformeIDAndRegion($dataVersionPlateforme['id_jeu_version_plateforme'],'jp');
				$dataCountVersionPlateforme=mysql_fetch_array($resultCountJeuVersionRegion);
				if($dataCountVersionPlateforme['count']!=0){
					$toReturn .='
					<td class="center add_item_table">
					<a href="#" class="disabled"><span>ajouter</span></a>
					</td>
					
					<td class="center edit_item_table">
					<a href="administration.php?jeu_version_region=edit&id_jeu_version_region='.$dataCountVersionPlateforme['id_jeu_version_region'].'"><span>modifier</span></a>
					</td>
					
					<td class="center delete_item_table">
					<a href="admin_traitement_jeu_version_region.php?submit_jeu_version_region=delete&id_jeu_version_region='.$dataCountVersionPlateforme['id_jeu_version_region'].'&id_jeu='.$data['id_jeu'].'"><span>supprimer</span></a>
					</td>
					';
				}
				else{
					$toReturn .='
					<td class="center add_item_table">
					<a href="admin_traitement_jeu_version_plateforme.php?submit_jeu_version_plateforme=add_region&region=jp&id_jeu_version_plateforme='.$dataVersionPlateforme['id_jeu_version_plateforme'].'&id_jeu='.$data['id_jeu'].'"><span>ajouter</span></a>
					</td>
					
					<td class="center edit_item_table">
					<a href="#" class="disabled"><span>modifier</span></a>
					</td>
					
					<td class="center delete_item_table">
					<a href="#" class="disabled"><span>ajouter</span></a>
					</td>
					';
				}
				
				$resultCountJeuVersionRegion = mysqlCountJeuVersionRegionByJeuVersionPlateformeIDAndRegion($dataVersionPlateforme['id_jeu_version_plateforme'],'us');
				$dataCountVersionPlateforme=mysql_fetch_array($resultCountJeuVersionRegion);
				if($dataCountVersionPlateforme['count']!=0){
					$toReturn .='
					<td class="center add_item_table">
					<a href="#" class="disabled"><span>ajouter</span></a>
					</td>
					
					<td class="center edit_item_table">
					<a href="administration.php?jeu_version_region=edit&id_jeu_version_region='.$dataCountVersionPlateforme['id_jeu_version_region'].'"><span>modifier</span></a>
					</td>
					
					<td class="center delete_item_table">
					<a href="admin_traitement_jeu_version_region.php?submit_jeu_version_region=delete&id_jeu_version_region='.$dataCountVersionPlateforme['id_jeu_version_region'].'&id_jeu='.$data['id_jeu'].'"><span>supprimer</span></a>
					</td>
					';
				}
				else{
					$toReturn .='
					<td class="center add_item_table">
					<a href="admin_traitement_jeu_version_plateforme.php?submit_jeu_version_plateforme=add_region&region=us&id_jeu_version_plateforme='.$dataVersionPlateforme['id_jeu_version_plateforme'].'&id_jeu='.$data['id_jeu'].'"><span>ajouter</span></a>
					</td>
					
					<td class="center edit_item_table">
					<a href="#" class="disabled"><span>modifier</span></a>
					</td>
					
					<td class="center delete_item_table">
					<a href="#" class="disabled"><span>ajouter</span></a>
					</td>
					';
				}
				$toReturn .='</tr>';
		}
	}
	
	$toReturn .='</table>';
	//----------------------//
	$toReturn .='<p>';
	$toReturn .='<select name="id_plateforme" id="id_plateforme">';	
	$toReturn .= '<option value="">-- plateforme --</option>';

	$result = mysqlSelectAllPlateformesByConstructeur();
	$constructeur_precedent = "";
		
	while($data=mysql_fetch_array($result)) {
			$resultConstructeur = mysqlSelectConstructeursByID(htmlspecialchars(trim($data['id_constructeur'])));
			$dataConstructeur =mysql_fetch_array($resultConstructeur);
			if(htmlspecialchars(trim($dataConstructeur['constructeur_nom']))!= $constructeur_precedent){
				if($constructeur_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($dataConstructeur['constructeur_nom'])).'">';
			}
			$resultTest = mysqlSelectJeuVersionByPlateformeIdAndJeuId(htmlspecialchars(trim($data["id_plateforme"])),$_GET['id_jeu'] );
			if(mysql_num_rows($resultTest) != 0){
   				$toReturn .= '<option value="'.htmlspecialchars(trim($data["id_plateforme"])).' "disabled>'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</option>';
   			}
   			else{
   				$toReturn .= '<option value="'.htmlspecialchars(trim($data["id_plateforme"])).'">'.htmlspecialchars(trim($data["plateforme_nom_generique"])).'</option>';
			}			
   			$constructeur_precedent = htmlspecialchars(trim($dataConstructeur['constructeur_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .='&emsp;<input id="submit" type="submit" value="ajouter version" name="submit_jeu"/>';

	$toReturn .='</p>';
	$toReturn .='</fieldset>';
	//--------------------//
	//---------------------//
	
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