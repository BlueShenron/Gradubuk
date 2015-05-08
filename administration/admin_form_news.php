<?php
require_once('mysql_fonctions_news.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin news]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createNewsGestionForm(){
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_news.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p><input id="submit" type="submit" value="créer un news" name="submit_news"/></p>';
	$toReturn .='</form>';
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//

	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_news.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p>';
	$toReturn .='<select name="categorie_news_search" id="categorie_news_search">';	
	$toReturn .= '<option value="">-- catégories --</option>';
	$result = mysqlSelectAllSousCategorieByCategorie();
	$categorie_precedent = "";
	while($data=mysql_fetch_array($result)) {
		if(htmlspecialchars(trim($data['categorie_news_nom']))!= $categorie_precedent){
			if($categorie_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($data['categorie_news_nom'])).'">';
			}
   			$toReturn .= '<option value="'.htmlspecialchars(trim($data["id_sous_categorie_news"])).'">'.htmlspecialchars(trim($data["sous_categorie_news_nom"])).'</option>';				
   		$categorie_precedent = htmlspecialchars(trim($data['categorie_news_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <input id="submit" type="submit" value="ok" name="submit_news"/>';

	$toReturn .='</p>';
	$toReturn .='</form>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<hr/>';

	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_news.php" method="post" enctype="multipart/form-data">';
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="news_date_modif"';
 	if($_GET['order']=="news_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par dernières modifiées</option>';
  	
  	$toReturn .= '<option value="news_date_creation"';
  	if($_GET['order']=="news_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par dernières créées</option>'; 

	$toReturn .= '</select></p>';
	////-----------filtre de tri-----------//
	$nb_element_par_page=20;
	//------------------------------------------------------------------------------------------------//

	if(!isset($_GET['id_sous_categorie_news'])){
	$result = mysqlSelectAllNewsWithPageNumber($_GET['page'], $_GET['order'], $nb_element_par_page);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
				<th></th>
    			<th></th>
    			<th></th>
    			<th></th>
    			
    			<th>titre</th>
    			<th>date de création</th>
    			<th>date de publication</th>
    			<th>rédacteur</th>
    			<th>correcteur</th>
    			
    			<th colspan=3>frontpage</th>
  				</tr>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_news.php?submit_news=delete&id_news='.htmlspecialchars(trim($data["id_news"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?news=edit&id_news='.htmlspecialchars(trim($data["id_news"])).'"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center publish_item_table"><a href="admin_traitement_news.php?submit_news=publish&id_news='.htmlspecialchars(trim($data["id_news"])).'"><span>publier</span></a></td>';
						
		$toReturn .= '<td class="center image_item_table"><a href="administration.php?news_photo=gestion&id_news='.htmlspecialchars(trim($data["id_news"])).'"><span>gérer les images</span></a></td>';
		$toReturn .= '<td><span><a href="../news.php?id_news='.htmlspecialchars(trim($data["id_news"])).'">'.htmlspecialchars(trim($data["news_titre"])).'</a></span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["news_date_creation"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["news_date_publication"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo_correcteur"])).'</span></td>';
		
		$resultFrontpage = mysqlCountFrontpage(htmlspecialchars(trim($data["id_news"])));
		$dataFrontpage = mysql_fetch_array($resultFrontpage); 
		
		if($dataFrontpage['count'] == 0){ 
		$toReturn .= '<td class="center add_frontpage_table"><a href="administration.php?frontpage_news=add&id_news='.htmlspecialchars(trim($data["id_news"])).'" ><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="#" class="disabled"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="#" class="disabled"><span>supprimer</span></a></td>';
		}
		else{
		$toReturn .= '<td class="center add_frontpage_table"><a href="#" class="disabled"><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="administration.php?frontpage_news=edit&id_news='.htmlspecialchars(trim($data["id_news"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'" ><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="admin_traitement_frontpage_news.php?submit_frontpage=delete&id_news='.htmlspecialchars(trim($data["id_news"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'"><span>supprimer</span></a></td>';
		}
		
		$toReturn .='</tr>';
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllNews();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?news=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?news=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	}
	//------------------------------------------------------------------------------------------------//
	if(isset($_GET['id_sous_categorie_news'])){
	
	$resultCount = mysqlSelectCountNewsIdSousCategorieNews($_GET['id_sous_categorie_news']);
	$dataCount=mysql_fetch_array($resultCount);
	$toReturn .= '<p  class="resultat_recherche">résultat(s) pour "'.$dataCount['sous_categorie_news_nom'].'": <span>'.$dataCount['count'].'</span></p>';

	
	$result = mysqlSelectAllNewsWithPageNumberIdSousCategorieNews($_GET['page'], $_GET['order'], $nb_element_par_page,$_GET['id_sous_categorie_news']);
	$toReturn .='<fieldset id="resultat_recherche">';
	$toReturn .='<table>';
	$toReturn .='<tr>
				<th class="center" ><input id="select_all" type="checkbox"/></th>
    			<th></th>
    			<th></th>
    			<th></th>
    			
    			<th>titre</th>
    			<th>date de création</th>
    			<th>date de publication</th>
    			<th>rédacteur</th>
    			<th>correcteur</th>
    			
    			<th colspan=3>frontpage</th>
  				</tr>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .='<tr>';
		$toReturn .= '<td class="center"><input type="checkbox" name="news[]" value="'.htmlspecialchars(trim($data["id_news"])).'"/></td>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_news.php?submit_news=delete&id_news='.htmlspecialchars(trim($data["id_news"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?news=edit&id_news='.htmlspecialchars(trim($data["id_news"])).'"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center publish_item_table"><a href="admin_traitement_news.php?submit_news=publish&id_news='.htmlspecialchars(trim($data["id_news"])).'"><span>publier</span></a></td>';
		//$toReturn .= '<td class="center frontpage_item_table"><a href="administration.php?frontpage_news=edit&id_news='.htmlspecialchars(trim($data["id_news"])).'"><span>frontpage</span></a></td>';


		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["news_titre"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["news_date_creation"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["news_date_publication"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo_correcteur"])).'</span></td>';
		
		$resultFrontpage = mysqlCountFrontpage(htmlspecialchars(trim($data["id_news"])));
		$dataFrontpage = mysql_fetch_array($resultFrontpage); 
		
		if($dataFrontpage['count'] == 0){ 
		$toReturn .= '<td class="center add_frontpage_table"><a href="administration.php?frontpage_news=add&id_news='.htmlspecialchars(trim($data["id_news"])).'" ><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="#" class="disabled"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="#" class="disabled"><span>supprimer</span></a></td>';
		}
		else{
		$toReturn .= '<td class="center add_frontpage_table"><a href="#" class="disabled"><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="administration.php?frontpage_news=edit&id_news='.htmlspecialchars(trim($data["id_news"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'" ><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="admin_traitement_frontpage_news.php?submit_frontpage=delete&id_news='.htmlspecialchars(trim($data["id_news"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'"><span>supprimer</span></a></td>';
		}
		
		$toReturn .='</tr>';
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllNewsIdSousCategorieNews($_GET['id_sous_categorie_news']);
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?news=gestion&id_sous_categorie_news='.$_GET['id_sous_categorie_news'].'&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?news=gestion&id_sous_categorie_news='.$_GET['id_sous_categorie_news'].'&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&id_sous_categorie_news='.$_GET['id_sous_categorie_news'].'"/>';
	}
	//------------------------------------------------------------------------------------------------//

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
	$toReturn .='</form>';
	return $toReturn;
	
}
function createNewsAddForm(){

	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a>créer</h3>';
	$toReturn .='<form action="admin_traitement_news.php" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=='ok'){
			$toReturn .='<p id="message_alerte" class="important_vert">ok</p>';
	}
	else if($_GET['record']=='nok'){
			$toReturn .='<p id="message_alerte" class="important_rouge">nok</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text"/></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataNews['news_date_publication'])).'"/></p></fieldset>';

	//--------ckeditor---------//
	$toReturn .='<textarea id="corps_news" name="corps_news">'.htmlspecialchars($dataNews['news_corps']).'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'corps_news\' );
				</script>';
	//--------ckeditor---------//	
	
	
	
	//--------categorie---------//
	$toReturn .='<fieldset id="liste_categorie"><legend>catégories</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="categorie_news_list" id="categorie_news_list">';	
	$toReturn .= '<option value="">-- catégories --</option>';
	$result = mysqlSelectAllSousCategorieByCategorie();
	$categorie_precedent = "";
	while($data=mysql_fetch_array($result)) {
		if(htmlspecialchars(trim($data['categorie_news_nom']))!= $categorie_precedent){
			if($categorie_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($data['categorie_news_nom'])).'">';
			}
   			$toReturn .= '<option value="'.htmlspecialchars(trim($data["id_sous_categorie_news"])).'">'.htmlspecialchars(trim($data["sous_categorie_news_nom"])).'</option>';				
   		$categorie_precedent = htmlspecialchars(trim($data['categorie_news_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_categorie" href="#liste_categorie">ajouter la catégorie à la liste</a>';

	$toReturn .='</p>';
	$toReturn .='</fieldset>';
	//--------categorie---------//

	//--------plateforme---------//
	$toReturn .='<fieldset id="liste_plateforme"><legend>plateformes</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="plateforme_list" id="plateforme_list">';	
	$toReturn .= '<option value="">-- plateformes --</option>';
	$resultPlateforme = mysqlSelectAllPlateformesByConstructeur();
	$constructeur_precedent = "";
	while($dataPlateforme=mysql_fetch_array($resultPlateforme)) {
		$resultConstructeur = mysqlSelectConstructeursByID(htmlspecialchars(trim($dataPlateforme['id_constructeur'])));
		$dataConstructeur =mysql_fetch_array($resultConstructeur);
		if(htmlspecialchars(trim($dataConstructeur['constructeur_nom']))!= $constructeur_precedent){
			if($constructeur_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($dataConstructeur['constructeur_nom'])).'">';
			}
		
   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataPlateforme["id_plateforme"])).'">'.htmlspecialchars(trim($dataPlateforme["plateforme_nom_generique"])).'</option>';
					
   		$constructeur_precedent = htmlspecialchars(trim($dataConstructeur['constructeur_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_plateforme" href="#liste_plateforme">ajouter la plateforme à la liste</a>';
	$toReturn .='</p>';
	$toReturn .='</fieldset>';
	//--------plateforme---------//
	
	//--------constructeur---------//
	$toReturn .='<fieldset id="liste_constructeur"><legend>constructeurs</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="constructeur_list" id="constructeur_list">';	
	$toReturn .= '<option value="">-- constructeurs --</option>';
	$resultConstructeur = mysqlSelectAllConstructeurs();
	while($dataConstructeur=mysql_fetch_array($resultConstructeur)) {
		   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataConstructeur["id_constructeur"])).'">'.htmlspecialchars(trim($dataConstructeur["constructeur_nom"])).'</option>';
	}
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_constructeur" href="#liste_constructeur">ajouter le constructeur à la liste</a>';
	$toReturn .='</p>';
	$toReturn .='</fieldset>';
	//--------constructeur---------//
	
	//--------developpeur---------//
	$toReturn .='<fieldset id="liste_developpeur"><legend>developpeurs</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="developpeur_list" id="developpeur_list">';	
	$toReturn .= '<option value="">-- developpeurs --</option>';
	$resultDeveloppeur = mysqlSelectAllDeveloppeurs();
	while($dataDeveloppeur=mysql_fetch_array($resultDeveloppeur)) {
		   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataDeveloppeur["id_developpeur"])).'">'.htmlspecialchars(trim($dataDeveloppeur["developpeur_nom"])).'</option>';
	}
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_developpeur" href="#liste_developpeur">ajouter le developpeur à la liste</a>';
	$toReturn .='</p>';
	$toReturn .='</fieldset>';
	//--------developpeur---------//
	
	//--------éditeur---------//
	$toReturn .='<fieldset id="liste_editeur"><legend>éditeurs</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="editeur_list" id="editeur_list">';	
	$toReturn .= '<option value="">-- éditeurs --</option>';
	$resultEditeur = mysqlSelectAllEditeurs();
	while($dataEditeur=mysql_fetch_array($resultEditeur)) {
		   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataEditeur["id_editeur"])).'">'.htmlspecialchars(trim($dataEditeur["editeur_nom"])).'</option>';
	}
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_editeur" href="#liste_editeur">ajouter l\'éditeur à la liste</a>';
	$toReturn .='</p>';
	$toReturn .='</fieldset>';
	//--------éditeur--------//
	

	//-------jeux---------//
	$toReturn .='<fieldset id="liste_jeu"><legend>jeux</legend>';
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
	$toReturn .=' <a class="style_button" id="add_jeu" href="#liste_jeu">ajouter le jeu à la liste</a>';

	$toReturn .='</p>';
	$toReturn .='</fieldset>';
	//-------jeux---------//

	$toReturn .='<fieldset id="image_fieldset"><legend>images</legend>';
	//
	
	//
	$toReturn .='</fieldset>';
	
	$toReturn .='<fieldset id="video_fieldset"><legend>videos</legend>';
	
	
	
	$toReturn .='</fieldset>';
	
	
	$toReturn .='<p><input id="submit" type="submit" value="créer news" name="submit_news"/></p>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
}
	
	
	
function createNewsEditForm(){
	$resultNews = mysqlSelectNewsByID($_GET['id_news']);
	$dataNews = mysql_fetch_array($resultNews);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a>modifier</h3>';
	$toReturn .='<form action="admin_traitement_news.php?id_news='.$_GET['id_news'].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=='ok'){
			$toReturn .='<p id="message_alerte" class="important_vert">ok</p>';
	}
	else if($_GET['record']=='nok'){
			$toReturn .='<p id="message_alerte" class="important_rouge">nok</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text" value="'.htmlspecialchars(trim($dataNews['news_titre'])).'"/></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataNews['news_date_publication_non_formate'])).'"/></p></fieldset>';

	//--------ckeditor---------//
	$toReturn .='<textarea id="corps_news" name="corps_news">'.htmlspecialchars($dataNews['news_corps']).'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'corps_news\' );
				</script>';
	//--------ckeditor---------//	
	
	
	
	//--------categorie---------//
	$toReturn .='<fieldset id="liste_categorie"><legend>catégories</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="categorie_news_list" id="categorie_news_list">';	
	$toReturn .= '<option value="">-- catégories --</option>';
	$result = mysqlSelectAllSousCategorieByCategorie();
	$categorie_precedent = "";
	while($data=mysql_fetch_array($result)) {
		if(htmlspecialchars(trim($data['categorie_news_nom']))!= $categorie_precedent){
			if($categorie_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($data['categorie_news_nom'])).'">';
			}
   			$toReturn .= '<option value="'.htmlspecialchars(trim($data["id_sous_categorie_news"])).'">'.htmlspecialchars(trim($data["sous_categorie_news_nom"])).'</option>';				
   		$categorie_precedent = htmlspecialchars(trim($data['categorie_news_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_categorie" href="#liste_categorie">ajouter la catégorie à la liste</a>';

	$toReturn .='</p>';
	
	//-------------------// ici on insert les catégories déjà selectionnées
	$resultNewsCategorie = mysqlSelectNewsSousCategorieNews($_GET['id_news']);
	while($dataNewsCategorie = mysql_fetch_array($resultNewsCategorie)){
		$toReturn .='<p><input type="checkbox" name="liste_categorie_news[]" value="'.$dataNewsCategorie['id_sous_categorie_news'].'" checked="checked"/>'.$dataNewsCategorie['sous_categorie_news_nom'].'</p>';
		//$toReturn .='1';
	}

	//-------------------//
	$toReturn .='</fieldset>';
	//--------categorie---------//

	//--------plateforme---------//
	$toReturn .='<fieldset id="liste_plateforme"><legend>plateformes</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="plateforme_list" id="plateforme_list">';	
	$toReturn .= '<option value="">-- plateformes --</option>';
	$resultPlateforme = mysqlSelectAllPlateformesByConstructeur();
	$constructeur_precedent = "";
	while($dataPlateforme=mysql_fetch_array($resultPlateforme)) {
		$resultConstructeur = mysqlSelectConstructeursByID(htmlspecialchars(trim($dataPlateforme['id_constructeur'])));
		$dataConstructeur =mysql_fetch_array($resultConstructeur);
		if(htmlspecialchars(trim($dataConstructeur['constructeur_nom']))!= $constructeur_precedent){
			if($constructeur_precedent != ""){$toReturn .='</optgroup>';}
				$toReturn .='<optgroup label="'.htmlspecialchars(trim($dataConstructeur['constructeur_nom'])).'">';
			}
		
   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataPlateforme["id_plateforme"])).'">'.htmlspecialchars(trim($dataPlateforme["plateforme_nom_generique"])).'</option>';
					
   		$constructeur_precedent = htmlspecialchars(trim($dataConstructeur['constructeur_nom']));
	}
	$toReturn .='</optgroup>';
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_plateforme" href="#liste_plateforme">ajouter la plateforme à la liste</a>';
	$toReturn .='</p>';
	//-------------------// ici on insert les plateformes déjà selectionnées
	
	$resultNewsPlateformes = mysqlSelectNewsPlateformes($_GET['id_news']);
	while($dataNewsPlateforme = mysql_fetch_array($resultNewsPlateformes)){
		$toReturn .='<p><input type="checkbox" name="liste_plateforme_news[]" value="'.$dataNewsPlateforme['id_plateforme'].'" checked="checked"/>'.$dataNewsPlateforme['plateforme_nom_generique'].'</p>';
		//$toReturn .='1';
	}
	$toReturn .='</fieldset>';
	//--------plateforme---------//
	
	//--------constructeur---------//
	$toReturn .='<fieldset id="liste_constructeur"><legend>constructeurs</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="constructeur_list" id="constructeur_list">';	
	$toReturn .= '<option value="">-- constructeurs --</option>';
	$resultConstructeur = mysqlSelectAllConstructeurs();
	while($dataConstructeur=mysql_fetch_array($resultConstructeur)) {
		   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataConstructeur["id_constructeur"])).'">'.htmlspecialchars(trim($dataConstructeur["constructeur_nom"])).'</option>';
	}
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_constructeur" href="#liste_constructeur">ajouter le constructeur à la liste</a>';
	$toReturn .='</p>';
	//-------------------// ici on insert les construteurs déjà selectionnées
	
	$resultNewsConstructeurs = mysqlSelectNewsConstructeurs($_GET['id_news']);
	while($dataNewsConstructeurs = mysql_fetch_array($resultNewsConstructeurs)){
		$toReturn .='<p><input type="checkbox" name="liste_constructeur_news[]" value="'.$dataNewsConstructeurs['id_constructeur'].'" checked="checked"/>'.$dataNewsConstructeurs['constructeur_nom'].'</p>';
		//$toReturn .='1';
	}

	//-------------------//
	$toReturn .='</fieldset>';
	//--------constructeur---------//
	
	//--------developpeur---------//
	$toReturn .='<fieldset id="liste_developpeur"><legend>developpeurs</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="developpeur_list" id="developpeur_list">';	
	$toReturn .= '<option value="">-- developpeurs --</option>';
	$resultDeveloppeur = mysqlSelectAllDeveloppeurs();
	while($dataDeveloppeur=mysql_fetch_array($resultDeveloppeur)) {
		   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataDeveloppeur["id_developpeur"])).'">'.htmlspecialchars(trim($dataDeveloppeur["developpeur_nom"])).'</option>';
	}
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_developpeur" href="#liste_developpeur">ajouter le developpeur à la liste</a>';
	$toReturn .='</p>';
	//-------------------// ici on insert les développeurs déjà selectionnées
	
	$resultNewsDeveloppeurs = mysqlSelectNewsDeveloppeur($_GET['id_news']);
	while($dataNewsDeveloppeurs = mysql_fetch_array($resultNewsDeveloppeurs)){
		$toReturn .='<p><input type="checkbox" name="liste_developpeur_news[]" value="'.$dataNewsDeveloppeurs['id_developpeur'].'" checked="checked"/>'.$dataNewsDeveloppeurs['developpeur_nom'].'</p>';
		//$toReturn .='1';
	}
	
	
	//-------------------//
	$toReturn .='</fieldset>';
	//--------developpeur---------//
	
	//--------editeur---------//
	$toReturn .='<fieldset id="liste_editeur"><legend>éditeurs</legend>';
	$toReturn .='<p>';
	$toReturn .='<select name="editeur_list" id="editeur_list">';	
	$toReturn .= '<option value="">-- éditeurs --</option>';
	$resultEditeur = mysqlSelectAllEditeurs();
	while($dataEditeur=mysql_fetch_array($resultEditeur)) {
		   			$toReturn .= '<option value="'.htmlspecialchars(trim($dataEditeur["id_editeur"])).'">'.htmlspecialchars(trim($dataEditeur["editeur_nom"])).'</option>';
	}
	$toReturn .='</select>';
	$toReturn .=' <a class="style_button" id="add_editeur" href="#liste_editeur">ajouter l\'éditeur à la liste</a>';
	$toReturn .='</p>';
	//-------------------// ici on insert les éditeur déjà selectionnées
	
	$resultNewsEditeurs = mysqlSelectNewsEditeur($_GET['id_news']);
	while($dataNewsEditeurs = mysql_fetch_array($resultNewsEditeurs)){
		$toReturn .='<p><input type="checkbox" name="liste_editeur_news[]" value="'.$dataNewsEditeurs['id_editeur'].'" checked="checked"/>'.$dataNewsEditeurs['editeur_nom'].'</p>';
		//$toReturn .='1';
	}
	
	
	//-------------------//
	$toReturn .='</fieldset>';
	//--------editeur---------//
	

	//-------jeux---------//
	$toReturn .='<fieldset id="liste_jeu"><legend>jeux</legend>';
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
	$toReturn .=' <a class="style_button" id="add_jeu" href="#liste_jeu">ajouter le jeu à la liste</a>';

	$toReturn .='</p>';
	
	//-------------------// ici on insert les jeux déjà selectionnées
	

	
	$resultJeuxId = mysqlSelectJeuxIdWithNewsId($_GET['id_news']);
	while($dataJeuxId = mysql_fetch_array($resultJeuxId)){
		$resultJeuxVersionsPlateformes = mysqlSelectVersionsPlateformesByJeuID($dataJeuxId['id_jeu']);
		while($dataJeuxVersionsPlateformes = mysql_fetch_array($resultJeuxVersionsPlateformes)){
				$toReturn .='<p><input type="checkbox" name="liste_jeu_version_plateforme_news[]" value="'.$dataJeuxVersionsPlateformes['id_jeu_version_plateforme'].'"';
				$result = mysqlCheckJeuVersionPlateforme($dataJeuxVersionsPlateformes['id_jeu_version_plateforme'], $_GET['id_news']);
				$data = mysql_fetch_array($result);
				if($data['nbelements'] != 0){
				$toReturn .= 'checked="checked"';
				}
				
				$toReturn .='/>'.$dataJeuxVersionsPlateformes['plateforme_nom_generique'].' / '.$dataJeuxVersionsPlateformes['jeu_nom_generique'].'</p>';	
		}
	}
	
	
	
	
	//-------------------//
	$toReturn .='</fieldset>';
	//-------jeux---------//
	
	$toReturn .='<fieldset id="image_fieldset" ><legend>images</legend>';
	
	//on affiche d'abord toutes les images liées à la news. si l'une d'elle est l'image d'illustraiton on coche son bouton radio
	$resultAllImageNew = mysqlSelectAllImageNews($_GET['id_news']);
	while($dataAllImageNews = mysql_fetch_array($resultAllImageNew)){

			$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataAllImageNews['url_news_image'].'" ';
			
			$resultIsIllustration = mysqlIsThisImageIllustrationOfTheNews($_GET['id_news'],$dataAllImageNews['url_news_image']);
			$dataIsIllustration = mysql_fetch_array($resultIsIllustration);

			if($dataIsIllustration['result']=='true'){
			
			$toReturn .= ' checked="checked" ';
			}
			
			$toReturn .='/>';
			$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataAllImageNews['url_news_image'].'" checked="checked"/>';
			$toReturn .='<img src="../'.$dataAllImageNews['url_news_image'].'" alt=""  /></p>';	
			$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" type="hidden" value="'.$dataAllImageNews['image_titre'].'"/>';	
			$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" type="hidden" value="'.$dataAllImageNews['image_alt'].'"/>';	
			
	}
	
	//il est possible que l'image d'illustration ne soit pas l'une d'elle dans ce cas on l'affiche, on ne coche pas sa checkbox par contre
	$resultIllustationNewsThatIsNotImage = mysqlSelectIllustationNewsThatIsNotImage($_GET['id_news']);
	while($dataIllustationNewsThatIsNotImage = mysql_fetch_array($resultIllustationNewsThatIsNotImage)){
					$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataIllustationNewsThatIsNotImage['url_news_illustration'].'" checked="checked"/>';
					$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataIllustationNewsThatIsNotImage['url_news_illustration'].'"/>';
					$toReturn .='<img src="../'.$dataIllustationNewsThatIsNotImage['url_news_illustration'].'" alt=""  /></p>';	

					$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" type="hidden" value="'.$dataIllustationNewsThatIsNotImage['image_titre'].'"/>';	
					$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" type="hidden" value="'.$dataIllustationNewsThatIsNotImage['image_titre'].'"/>';	
				
	}
	//on affiche maintenant les photos de l'news
	$resultAllNewsPhotoNotInNews = mysqlSelectAllNewsPhotoNotInNews($_GET['id_news']);// on selectionne tous les developpeurs liés à la news
	
	while($dataAllNewsPhotoNotInNews = mysql_fetch_array($resultAllNewsPhotoNotInNews)){
			
				$toReturn .='<p class="image_illustration_news">';
				$toReturn .='<input type="radio" name="image_illustration" value="'.$dataAllNewsPhotoNotInNews['photo_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataAllNewsPhotoNotInNews['photo_url'].'"/>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataAllNewsPhotoNotInNews['photo_url'].'" alt=""  /></td>';	
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" type="hidden" value="'.$dataAllNewsPhotoNotInNews['photo_titre'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" type="hidden" value="'.$dataAllNewsPhotoNotInNews['photo_titre'].'"/>';	
				$toReturn .='</p>';
				
			
			
	}
	//on affiche maintenant les images developpeur qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultDeveloppeurNews = mysqlSelectNewsDeveloppeur($_GET['id_news']);// on selectionne tous les developpeurs liés à la news
	while($dataDeveloppeurNews = mysql_fetch_array($resultDeveloppeurNews)){
			$resultDeveloppeurImageThatIsNotAlReadyInNews = mysqlSelectDeveloppeurImageThatIsNotAlReadyInNews($_GET['id_news'],$dataDeveloppeurNews['id_developpeur']);
			while($dataDeveloppeurImageThatIsNotAlReadyInNews = mysql_fetch_array($resultDeveloppeurImageThatIsNotAlReadyInNews)){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_nom'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images éditeur qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultEditeurNews = mysqlSelectNewsEditeur($_GET['id_news']);// on selectionne tous les éditeurs liés à la news
	while($dataEditeurNews = mysql_fetch_array($resultEditeurNews)){
			$resultEditeurImageThatIsNotAlReadyInNews = mysqlSelectEditeurImageThatIsNotAlReadyInNews($_GET['id_news'],$dataEditeurNews['id_editeur']);
			while($dataEditeurImageThatIsNotAlReadyInNews = mysql_fetch_array($resultEditeurImageThatIsNotAlReadyInNews)){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_nom'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images constructeur qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultConstructeurNews = mysqlSelectNewsConstructeur($_GET['id_news']);// on selectionne tous les constructeurs liés à la news
	while($dataConstructeurNews = mysql_fetch_array($resultConstructeurNews)){
			$resultConstructeurImageThatIsNotAlReadyInNews = mysqlSelectConstructeurImageThatIsNotAlReadyInNews($_GET['id_news'],$dataConstructeurNews['id_constructeur']);
			while($dataConstructeurImageThatIsNotAlReadyInNews = mysql_fetch_array($resultConstructeurImageThatIsNotAlReadyInNews)){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_nom'].'"/>';	
				
			}
	}
	
	
	//on affiche maintenant les images plateformes qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultPlateformeNews = mysqlSelectNewsPlateforme($_GET['id_news']);// on selectionne tous les plateformes liés à la news
	while($dataPlateformeNews = mysql_fetch_array($resultPlateformeNews)){
			$resultPlateformeImageThatIsNotAlReadyInNews = mysqlSelectPlateformeImageThatIsNotAlReadyInNews($_GET['id_news'],$dataPlateformeNews['id_plateforme']);
			while($dataPlateformeImageThatIsNotAlReadyInNews = mysql_fetch_array($resultPlateformeImageThatIsNotAlReadyInNews)){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images version plateformes qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultPlateformeNews = mysqlSelectNewsPlateforme($_GET['id_news']);// on selectionne tous les plateformes liés à la news
	while($dataPlateformeNews = mysql_fetch_array($resultPlateformeNews)){
			
			$resultPlateformeVersionImageThatIsNotAlReadyInNews = mysqlSelectPlateformeVersionImageThatIsNotAlReadyInNews($_GET['id_news'],$dataPlateformeNews['id_plateforme']);
			while($dataPlateformeVersionImageThatIsNotAlReadyInNews = mysql_fetch_array($resultPlateformeVersionImageThatIsNotAlReadyInNews)){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_version_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_version_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_version_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" type="hidden" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images categorie_news qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultCategorieNews = mysqlSelectNewsCategorie($_GET['id_news']);// on selectionne tous les categorie liés à la news
	while($dataCategorieNews = mysql_fetch_array($resultCategorieNews)){
			$resultCategorieImageThatIsNotAlReadyInNews = mysqlSelectCategorieNewsImageThatIsNotAlReadyInNews($_GET['id_news'],$dataCategorieNews['id_sous_categorie_news']);
			while($dataCategorieImageThatIsNotAlReadyInNews = mysql_fetch_array($resultCategorieImageThatIsNotAlReadyInNews)){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataCategorieImageThatIsNotAlReadyInNews['categorie_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" type="hidden" value="'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" type="hidden" value="'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_nom'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images jeux qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultJeuxNews = mysqlSelectNewsJeux($_GET['id_news']);// on selectionne tous les constructeurs liés à la news
	while($dataJeuxNews = mysql_fetch_array($resultJeuxNews)){
			
			
			$resultJeuxImageThatIsNotAlReadyInNews = mysqlSelectJeuxImageThatIsNotAlReadyInNews($_GET['id_news'],$dataJeuxNews['id_jeu']);
			while($dataJeuxImageThatIsNotAlReadyInNews = mysql_fetch_array($resultJeuxImageThatIsNotAlReadyInNews)){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" type="hidden" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" type="hidden" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_nom'].'"/>';	
				
			}
			
			$resultJeuxCoverThatIsNotAlReadyInNews = mysqlSelectJeuxCoverThatIsNotAlReadyInNews($_GET['id_news'],$dataJeuxNews['id_jeu']);
			while($dataJeuxCoverThatIsNotAlReadyInNews = mysql_fetch_array($resultJeuxCoverThatIsNotAlReadyInNews)){
				if($dataJeuxCoverThatIsNotAlReadyInNews['image']=='ok'){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataJeuxCoverThatIsNotAlReadyInNews['url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataJeuxCoverThatIsNotAlReadyInNews['url'].'"/>';
				$toReturn .='<img src="../'.$dataJeuxCoverThatIsNotAlReadyInNews['url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" type="hidden" value="cover '.$dataJeuxCoverThatIsNotAlReadyInNews['jeu_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" type="hidden" value="cover '.$dataJeuxCoverThatIsNotAlReadyInNews['jeu_nom'].'"/>';	
				
				}
			}
			

			
	}
	$toReturn .='</fieldset>';
	/*
	$toReturn .='<fieldset ><legend>images</legend>';
	//
	$toReturn .='<table id="image_fieldset">';
	$toReturn .='<tr>';
    $toReturn .='<th></th>';
    $toReturn .='<th></th>';
    
    $toReturn .='<th>image</th>';
    $toReturn .='<th>titre</th>';
	$toReturn .='<th>alt</th>';
    $toReturn .='</tr>';
    
    
    //on affiche d'abord toutes les images liées à la news. si l'une d'elle est l'image d'illustraiton on coche son bouton radio
	$resultAllImageNews = mysqlSelectAllImageNews($_GET['id_news']);
	while($dataAllImageNews = mysql_fetch_array($resultAllImageNews)){

			$toReturn .='<tr>';
			$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataAllImageNews['url_news_image'].'"';

			$resultIsIllustration = mysqlIsThisImageIllustrationOfTheNews($_GET['id_news'],$dataAllImageNews['url_news_image']);
			$dataIsIllustration = mysql_fetch_array($resultIsIllustration);

			if($dataIsIllustration['result']=='true'){
			
			$toReturn .= ' checked="checked" ';
			}
			
			$toReturn .='/></td>';
			$toReturn .='<td><input type="checkbox" name="news_liste_image[]"  value="'.$dataAllImageNews['url_news_image'].'" checked="checked"/></td>';
			$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataAllImageNews['url_news_image'].'" alt=""  /></td>';	
			$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" type="text" value="'.$dataAllImageNews['image_titre'].'"/></td>';	
			$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllImageNews['url_news_image']).'" type="text" value="'.$dataAllImageNews['image_alt'].'"/></td>';	
			$toReturn .='</tr>';

	}
	//il est possible que l'image d'illustration ne soit pas l'une d'elle dans ce cas on l'affiche, on ne coche pas sa checkbox par contre
	$resultIllustationNewsThatIsNotImage = mysqlSelectIllustationNewsThatIsNotImage($_GET['id_news']);
	while($dataIllustationNewsThatIsNotImage = mysql_fetch_array($resultIllustationNewsThatIsNotImage)){
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataIllustationNewsThatIsNotImage['url_news_illustration'].'" checked="checked"/></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataIllustationNewsThatIsNotImage['url_news_illustration'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataIllustationNewsThatIsNotImage['url_news_illustration'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" type="text" value="'.$dataIllustationNewsThatIsNotImage['image_titre'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataIllustationNewsThatIsNotImage['url_news_illustration']).'" type="text" value="'.$dataIllustationNewsThatIsNotImage['image_titre'].'"/></td>';	
				$toReturn .='</tr>';
				
	}
	
	//on affiche maintenant les photos de l'news
	$resultAllNewsPhotoNotInNews = mysqlSelectAllNewsPhotoNotInNews($_GET['id_news']);// on selectionne tous les developpeurs liés à la news
	
	while($dataAllNewsPhotoNotInNews = mysql_fetch_array($resultAllNewsPhotoNotInNews)){
			
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataAllNewsPhotoNotInNews['photo_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataAllNewsPhotoNotInNews['photo_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataAllNewsPhotoNotInNews['photo_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" type="text" value="'.$dataAllNewsPhotoNotInNews['photo_titre'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllNewsPhotoNotInNews['photo_url']).'" type="text" value="'.$dataAllNewsPhotoNotInNews['photo_titre'].'"/></td>';	
				$toReturn .='</tr>';
			
			
	}
	
	//on affiche maintenant les images developpeur qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultDeveloppeurNews = mysqlSelectNewsDeveloppeur($_GET['id_news']);// on selectionne tous les developpeurs liés à la news
	
	while($dataDeveloppeurNews = mysql_fetch_array($resultDeveloppeurNews)){
			
			$resultDeveloppeurImageThatIsNotAlReadyInNews = mysqlSelectDeveloppeurImageThatIsNotAlReadyInNews($_GET['id_news'],$dataDeveloppeurNews['id_developpeur']);
			while($dataDeveloppeurImageThatIsNotAlReadyInNews = mysql_fetch_array($resultDeveloppeurImageThatIsNotAlReadyInNews)){
				
				//$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataDeveloppeurImageThatIsNotAlReadyInNews['developpeur_nom'].'"/></td>';	
				$toReturn .='</tr>';
				

			}
	}
    //on affiche maintenant les images editeur qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultEditeurNews = mysqlSelectNewsEditeur($_GET['id_news']);// on selectionne tous les editeurs liés à la news
	
	while($dataEditeurNews = mysql_fetch_array($resultEditeurNews)){
			
			$resultEditeurImageThatIsNotAlReadyInNews = mysqlSelectEditeurImageThatIsNotAlReadyInNews($_GET['id_news'],$dataEditeurNews['id_editeur']);
			while($dataEditeurImageThatIsNotAlReadyInNews = mysql_fetch_array($resultEditeurImageThatIsNotAlReadyInNews)){
				
				//$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataEditeurImageThatIsNotAlReadyInNews['editeur_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
    //on affiche maintenant les images constructeur qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultConstructeurNews = mysqlSelectNewsConstructeur($_GET['id_news']);// on selectionne tous les constructeurs liés à la news
	
	while($dataConstructeurNews = mysql_fetch_array($resultConstructeurNews)){
			
			$resultConstructeurImageThatIsNotAlReadyInNews = mysqlSelectConstructeurImageThatIsNotAlReadyInNews($_GET['id_news'],$dataConstructeurNews['id_constructeur']);
			while($dataConstructeurImageThatIsNotAlReadyInNews = mysql_fetch_array($resultConstructeurImageThatIsNotAlReadyInNews)){
				
				//$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataConstructeurImageThatIsNotAlReadyInNews['constructeur_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	
		//on affiche maintenant les images plateformes qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultPlateformeNews = mysqlSelectNewsPlateforme($_GET['id_news']);// on selectionne tous les plateformes liés à la news
	
	while($dataPlateformeNews = mysql_fetch_array($resultPlateformeNews)){
			
			$resultPlateformeImageThatIsNotAlReadyInNews = mysqlSelectPlateformeImageThatIsNotAlReadyInNews($_GET['id_news'],$dataPlateformeNews['id_plateforme']);
			while($dataPlateformeImageThatIsNotAlReadyInNews = mysql_fetch_array($resultPlateformeImageThatIsNotAlReadyInNews)){
				
				//$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataPlateformeImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	
	//on affiche maintenant les images version plateformes qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultPlateformeNews = mysqlSelectNewsPlateforme($_GET['id_news']);// on selectionne tous les plateformes liés à la news
	
	while($dataPlateformeNews = mysql_fetch_array($resultPlateformeNews)){
			
			$resultPlateformeVersionImageThatIsNotAlReadyInNews = mysqlSelectPlateformeVersionImageThatIsNotAlReadyInNews($_GET['id_news'],$dataPlateformeNews['id_plateforme']);
			while($dataPlateformeVersionImageThatIsNotAlReadyInNews = mysql_fetch_array($resultPlateformeVersionImageThatIsNotAlReadyInNews)){
				
				//$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_version_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInNews['url_news_image']).'" type="text" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInNews['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	

	
	    //on affiche maintenant les images constructeur qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultCategorieNews = mysqlSelectNewsCategorie($_GET['id_news']);// on selectionne tous les categories liés à la news
	
	while($dataCategorieNews = mysql_fetch_array($resultCategorieNews)){
			
			$resultCategorieImageThatIsNotAlReadyInNews = mysqlSelectCategorieNewsImageThatIsNotAlReadyInNews($_GET['id_news'],$dataCategorieNews['id_sous_categorie_news']);
			while($dataCategorieImageThatIsNotAlReadyInNews = mysql_fetch_array($resultCategorieImageThatIsNotAlReadyInNews)){
				
				//$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataCategorieImageThatIsNotAlReadyInNews['categorie_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataCategorieImageThatIsNotAlReadyInNews['categorie_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataCategorieImageThatIsNotAlReadyInNews['categorie_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" type="text" value="'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_image_url']).'" type="text" value="'.$dataCategorieImageThatIsNotAlReadyInNews['sous_categorie_news_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	
	
		//on affiche maintenant les images jeux qui n'existe pas dnas la table news_image, ces image sont décochées
	$resultJeuxNews = mysqlSelectNewsJeux($_GET['id_news']);// on selectionne tous les categories liés à la news
	while($dataJeuxNews = mysql_fetch_array($resultJeuxNews)){
			
			
			$resultJeuxImageThatIsNotAlReadyInNews = mysqlSelectJeuxImageThatIsNotAlReadyInNews($_GET['id_news'],$dataJeuxNews['id_jeu']);
			while($dataJeuxImageThatIsNotAlReadyInNews = mysql_fetch_array($resultJeuxImageThatIsNotAlReadyInNews)){
				
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" type="text" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInNews['jeu_image_url']).'" type="text" value="'.$dataJeuxImageThatIsNotAlReadyInNews['jeu_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
			
			$resultJeuxCoverThatIsNotAlReadyInNews = mysqlSelectJeuxCoverThatIsNotAlReadyInNews($_GET['id_news'],$dataJeuxNews['id_jeu']);
			while($dataJeuxCoverThatIsNotAlReadyInNews = mysql_fetch_array($resultJeuxCoverThatIsNotAlReadyInNews)){
				if($dataJeuxCoverThatIsNotAlReadyInNews['image']=='ok'){
				
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataJeuxCoverThatIsNotAlReadyInNews['url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="news_liste_image[]" value="'.$dataJeuxCoverThatIsNotAlReadyInNews['url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataJeuxCoverThatIsNotAlReadyInNews['url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" type="text" value="cover '.$dataJeuxCoverThatIsNotAlReadyInNews['jeu_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInNews['url']).'" type="text" value="cover '.$dataJeuxCoverThatIsNotAlReadyInNews['jeu_nom'].'"/></td>';	
				$toReturn .='</tr>';
				
				
				}
			}
			

			
	}

	$toReturn .='</table>';
	//
	$toReturn .='</fieldset>';
	*/
	/*
	$toReturn .='<fieldset ><legend>videos</legend>';
	
	$toReturn .='<table id="video_fieldset">';
	$toReturn .='<tr>';
    $toReturn .='<th></th>';
   
    
    $toReturn .='<th>image</th>';
    $toReturn .='<th>titre</th>';
	
    $toReturn .='</tr>';
    
    
	//on affiche d'abord toutes les video liées à la news. 
	$resultAllVideoNew = mysqlSelectAllVideoNews($_GET['id_news']);
	while($dataAllVideoNews = mysql_fetch_array($resultAllVideoNew)){
			parse_str( parse_url( $dataAllVideoNews['url_news_video'], PHP_URL_QUERY ), $my_array_of_vars );
			$youtube_id = $my_array_of_vars['v'];
			$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			

			$toReturn .='<td><input type="checkbox" name="news_liste_video[]" value="'.$dataAllVideoNews['url_news_video'].'" checked="checked"/></td>';
			$toReturn .='<td class="cell_image_categorie_news"><img src="'.$src.'" alt=""   /></td>';	
			$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoNews['url_news_video']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoNews['url_news_video']).'" type="text" value="'.$dataAllImageNews['video_titre'].'"/></td>';	
			$toReturn .='</tr>';
	}
    
    
    //on affiche maintenant les video qui n'existe pas dnas la table news_video, ces video sont décochées
	$resultJeuxNews = mysqlSelectNewsJeux($_GET['id_news']);// on selectionne tous les plateformes liés à la news
	while($dataJeuxNews = mysql_fetch_array($resultJeuxNews)){	
			$resultJeuxVideoThatIsNotAlReadyInNews = mysqlSelectJeuxVideoThatIsNotAlReadyInNews($_GET['id_news'],$dataJeuxNews['id_jeu']);
			while($dataJeuxVideoThatIsNotAlReadyInNews = mysql_fetch_array($resultJeuxVideoThatIsNotAlReadyInNews)){
				parse_str( parse_url( $dataJeuxVideoThatIsNotAlReadyInNews['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
				$youtube_id = $my_array_of_vars['v'];
				$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			

				$toReturn .='<td><input type="checkbox" name="news_liste_video[]" value="'.$dataJeuxVideoThatIsNotAlReadyInNews['video_url'].'" checked="checked"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="'.$src.'" alt=""   /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInNews['video_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInNews['video_url']).'" type="text" value="'.$dataJeuxVideoThatIsNotAlReadyInNews['video_titre'].'"/></td>';	
				$toReturn .='</tr>';
			}
	}


    
	$toReturn .='</table>';
	
	$toReturn .='</fieldset>';
	*/
	


	
	
	
	$toReturn .='<fieldset id="video_fieldset" ><legend>videos</legend>';
	
	//on affiche d'abord toutes les video liées à la news. 
	$resultAllVideoNew = mysqlSelectAllVideoNews($_GET['id_news']);
	while($dataAllVideoNews = mysql_fetch_array($resultAllVideoNew)){
			parse_str( parse_url( $dataAllVideoNews['url_news_video'], PHP_URL_QUERY ), $my_array_of_vars );
			$youtube_id = $my_array_of_vars['v'];
			$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			
			$toReturn .='<p class="image_illustration_news">';
			$toReturn .='<input type="checkbox" name="news_liste_video[]" value="'.$dataAllVideoNews['url_news_video'].'" checked="checked"/>';
			$toReturn .='<img src="'.$src.'" alt=""  />';
			$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoNews['url_news_video']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoNews['url_news_video']).'" type="hidden" value="'.$dataAllVideoNews['video_titre'].'"/></td>';	

			$toReturn .='</p>';	
	}
	
	//on affiche maintenant les video qui n'existe pas dnas la table news_video, ces video sont décochées
	$resultJeuxNews = mysqlSelectNewsJeux($_GET['id_news']);// on selectionne tous les plateformes liés à la news
	while($dataJeuxNews = mysql_fetch_array($resultJeuxNews)){	
			$resultJeuxVideoThatIsNotAlReadyInNews = mysqlSelectJeuxVideoThatIsNotAlReadyInNews($_GET['id_news'],$dataJeuxNews['id_jeu']);
			while($dataJeuxVideoThatIsNotAlReadyInNews = mysql_fetch_array($resultJeuxVideoThatIsNotAlReadyInNews)){
				parse_str( parse_url( $dataJeuxVideoThatIsNotAlReadyInNews['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
				$youtube_id = $my_array_of_vars['v'];
				$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			
				$toReturn .='<p class="image_illustration_news">';
				$toReturn .='<input type="checkbox" name="news_liste_video[]" value="'.$dataJeuxVideoThatIsNotAlReadyInNews['video_url'].'"/>';
				$toReturn .='<img src="'.$src.'" alt=""  />';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInNews['video_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInNews['video_url']).'" type="hidden" value="'.$dataJeuxVideoThatIsNotAlReadyInNews['video_titre'].'"/>';	

				$toReturn .='</p>';	
			}
	}
	
	
	
	$toReturn .='</fieldset>';
	
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_news"/></p>';

	$toReturn .='<input type="hidden" id="id_news" value="'.$_GET['id_news'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
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