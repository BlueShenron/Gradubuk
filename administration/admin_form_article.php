<?php
require_once('mysql_fonctions_article.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin article]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createArticleGestionForm(){
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">articles</span></a>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_article.php" method="post" enctype="multipart/form-data">';
	$toReturn .='<p><input id="submit" type="submit" value="créer un article" name="submit_article"/></p>';
	$toReturn .='</form>';
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//

	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_article.php" method="post" enctype="multipart/form-data">';
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
	$toReturn .=' <input id="submit" type="submit" value="ok" name="submit_article"/>';

	$toReturn .='</p>';
	$toReturn .='</form>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<hr/>';

	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_article.php" method="post" enctype="multipart/form-data">';
	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="article_date_modif"';
 	if($_GET['order']=="article_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par dernières modifiées</option>';
  	
  	$toReturn .= '<option value="article_date_creation"';
  	if($_GET['order']=="article_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par dernières créées</option>'; 

	$toReturn .= '</select></p>';
	////-----------filtre de tri-----------//
	$nb_element_par_page=20;
	//------------------------------------------------------------------------------------------------//

	if(!isset($_GET['id_sous_categorie_news'])){
	$result = mysqlSelectAllArticleWithPageNumber($_GET['page'], $_GET['order'], $nb_element_par_page);
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
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_article.php?submit_article=delete&id_article='.htmlspecialchars(trim($data["id_article"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?article=edit&id_article='.htmlspecialchars(trim($data["id_article"])).'"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center publish_item_table"><a href="admin_traitement_article.php?submit_article=publish&id_article='.htmlspecialchars(trim($data["id_article"])).'"><span>publier</span></a></td>';
						
		$toReturn .= '<td class="center image_item_table"><a href="administration.php?article_photo=gestion&id_article='.htmlspecialchars(trim($data["id_article"])).'"><span>gérer les images</span></a></td>';
		$toReturn .= '<td><span><a href="../articles.php?id_article='.htmlspecialchars(trim($data["id_article"])).'">'.htmlspecialchars(trim($data["article_titre"])).'</a></span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["article_date_creation"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["article_date_publication"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo_correcteur"])).'</span></td>';
		
		$resultFrontpage = mysqlCountFrontpage(htmlspecialchars(trim($data["id_article"])));
		$dataFrontpage = mysql_fetch_array($resultFrontpage); 
		
		if($dataFrontpage['count'] == 0){ 
		$toReturn .= '<td class="center add_frontpage_table"><a href="administration.php?frontpage_article=add&id_article='.htmlspecialchars(trim($data["id_article"])).'" ><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="#" class="disabled"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="#" class="disabled"><span>supprimer</span></a></td>';
		}
		else{
		$toReturn .= '<td class="center add_frontpage_table"><a href="#" class="disabled"><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="administration.php?frontpage_article=edit&id_article='.htmlspecialchars(trim($data["id_article"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'" ><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="admin_traitement_frontpage_article.php?submit_frontpage=delete&id_article='.htmlspecialchars(trim($data["id_article"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'"><span>supprimer</span></a></td>';
		}
		
		$toReturn .='</tr>';
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllArticle();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?article=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?article=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	}
	//------------------------------------------------------------------------------------------------//
	if(isset($_GET['id_sous_categorie_news'])){
	
	$resultCount = mysqlSelectCountArticleIdSousCategorieNews($_GET['id_sous_categorie_news']);
	$dataCount=mysql_fetch_array($resultCount);
	$toReturn .= '<p  class="resultat_recherche">résultat(s) pour "'.$dataCount['sous_categorie_news_nom'].'": <span>'.$dataCount['count'].'</span></p>';

	
	$result = mysqlSelectAllArticleWithPageNumberIdSousCategorieNews($_GET['page'], $_GET['order'], $nb_element_par_page,$_GET['id_sous_categorie_news']);
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
		$toReturn .= '<td class="center"><input type="checkbox" name="article[]" value="'.htmlspecialchars(trim($data["id_article"])).'"/></td>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_article.php?submit_article=delete&id_article='.htmlspecialchars(trim($data["id_article"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?article=edit&id_article='.htmlspecialchars(trim($data["id_article"])).'"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center publish_item_table"><a href="admin_traitement_article.php?submit_article=publish&id_article='.htmlspecialchars(trim($data["id_article"])).'"><span>publier</span></a></td>';
		//$toReturn .= '<td class="center frontpage_item_table"><a href="administration.php?frontpage_article=edit&id_article='.htmlspecialchars(trim($data["id_article"])).'"><span>frontpage</span></a></td>';


		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["article_titre"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["article_date_creation"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["article_date_publication"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo_correcteur"])).'</span></td>';
		
		$resultFrontpage = mysqlCountFrontpage(htmlspecialchars(trim($data["id_article"])));
		$dataFrontpage = mysql_fetch_array($resultFrontpage); 
		
		if($dataFrontpage['count'] == 0){ 
		$toReturn .= '<td class="center add_frontpage_table"><a href="administration.php?frontpage_article=add&id_article='.htmlspecialchars(trim($data["id_article"])).'" ><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="#" class="disabled"><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="#" class="disabled"><span>supprimer</span></a></td>';
		}
		else{
		$toReturn .= '<td class="center add_frontpage_table"><a href="#" class="disabled"><span>créer</span></a></td>';
		$toReturn .= '<td class="center edit_frontpage_table"><a href="administration.php?frontpage_article=edit&id_article='.htmlspecialchars(trim($data["id_article"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'" ><span>modifier</span></a></td>';
		$toReturn .= '<td class="center delete_frontpage_table"><a href="admin_traitement_frontpage_article.php?submit_frontpage=delete&id_article='.htmlspecialchars(trim($data["id_article"])).'&id_frontpage='.htmlspecialchars(trim($dataFrontpage["id_frontpage"])).'"><span>supprimer</span></a></td>';
		}
		
		$toReturn .='</tr>';
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------page------- //
	$resultDev = mysqlSelectAllArticleIdSousCategorieNews($_GET['id_sous_categorie_news']);
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?article=gestion&id_sous_categorie_news='.$_GET['id_sous_categorie_news'].'&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?article=gestion&id_sous_categorie_news='.$_GET['id_sous_categorie_news'].'&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&id_sous_categorie_news='.$_GET['id_sous_categorie_news'].'"/>';
	}
	//------------------------------------------------------------------------------------------------//

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
	$toReturn .='</form>';
	return $toReturn;
	
}
function createArticleAddForm(){

	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">articles</span></a>créer</h3>';
	$toReturn .='<form action="admin_traitement_article.php" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=='ok'){
			$toReturn .='<p id="message_alerte" class="important_vert">ok</p>';
	}
	else if($_GET['record']=='nok'){
			$toReturn .='<p id="message_alerte" class="important_rouge">nok</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text"/></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataArticle['article_date_publication'])).'"/></p></fieldset>';

	//--------ckeditor---------//
	$toReturn .='<textarea id="corps_article" name="corps_article">'.htmlspecialchars($dataArticle['article_corps']).'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'corps_article\' );
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
	
	
	$toReturn .='<p><input id="submit" type="submit" value="créer article" name="submit_article"/></p>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
}
	
	
	
function createArticleEditForm(){
	$resultArticle = mysqlSelectArticleByID($_GET['id_article']);
	$dataArticle = mysql_fetch_array($resultArticle);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">articles</span></a>modifier</h3>';
	$toReturn .='<form action="admin_traitement_article.php?id_article='.$_GET['id_article'].'" method="post" enctype="multipart/form-data">';
	
	if($_GET['record']=='ok'){
			$toReturn .='<p id="message_alerte" class="important_vert">ok</p>';
	}
	else if($_GET['record']=='nok'){
			$toReturn .='<p id="message_alerte" class="important_rouge">nok</p>';
	}
	
	$toReturn .='<fieldset><p><label for="titre">titre: </label><input id="titre" name="titre" type="text" value="'.htmlspecialchars(trim($dataArticle['article_titre'])).'"/></p>';
	$toReturn .='<p><label for="date_publication">date publication: </label><input id="date_publication" name="date_publication" class="date_picker_avec_heure" type="text" value="'.htmlspecialchars(trim($dataArticle['article_date_publication_non_formate'])).'"/></p></fieldset>';

	//--------ckeditor---------//
	$toReturn .='<textarea id="corps_article" name="corps_article">'.htmlspecialchars($dataArticle['article_corps']).'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( \'corps_article\' );
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
	$resultArticleCategorie = mysqlSelectArticleSousCategorieArticle($_GET['id_article']);
	while($dataArticleCategorie = mysql_fetch_array($resultArticleCategorie)){
		$toReturn .='<p><input type="radio" name="liste_categorie_news[]" value="'.$dataArticleCategorie['id_sous_categorie_news'].'" checked="checked"/>'.$dataArticleCategorie['sous_categorie_news_nom'].'</p>';
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
	
	$resultArticlePlateformes = mysqlSelectArticlePlateformes($_GET['id_article']);
	while($dataArticlePlateforme = mysql_fetch_array($resultArticlePlateformes)){
		$toReturn .='<p><input type="checkbox" name="liste_plateforme_article[]" value="'.$dataArticlePlateforme['id_plateforme'].'" checked="checked"/>'.$dataArticlePlateforme['plateforme_nom_generique'].'</p>';
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
	
	$resultArticleConstructeurs = mysqlSelectArticleConstructeurs($_GET['id_article']);
	while($dataArticleConstructeurs = mysql_fetch_array($resultArticleConstructeurs)){
		$toReturn .='<p><input type="checkbox" name="liste_constructeur_article[]" value="'.$dataArticleConstructeurs['id_constructeur'].'" checked="checked"/>'.$dataArticleConstructeurs['constructeur_nom'].'</p>';
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
	
	$resultArticleDeveloppeurs = mysqlSelectArticleDeveloppeur($_GET['id_article']);
	while($dataArticleDeveloppeurs = mysql_fetch_array($resultArticleDeveloppeurs)){
		$toReturn .='<p><input type="checkbox" name="liste_developpeur_article[]" value="'.$dataArticleDeveloppeurs['id_developpeur'].'" checked="checked"/>'.$dataArticleDeveloppeurs['developpeur_nom'].'</p>';
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
	
	$resultArticleEditeurs = mysqlSelectArticleEditeur($_GET['id_article']);
	while($dataArticleEditeurs = mysql_fetch_array($resultArticleEditeurs)){
		$toReturn .='<p><input type="checkbox" name="liste_editeur_article[]" value="'.$dataArticleEditeurs['id_editeur'].'" checked="checked"/>'.$dataArticleEditeurs['editeur_nom'].'</p>';
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
	

	
	$resultJeuxId = mysqlSelectJeuxIdWithArticleId($_GET['id_article']);
	while($dataJeuxId = mysql_fetch_array($resultJeuxId)){
		$resultJeuxVersionsPlateformes = mysqlSelectVersionsPlateformesByJeuID($dataJeuxId['id_jeu']);
		while($dataJeuxVersionsPlateformes = mysql_fetch_array($resultJeuxVersionsPlateformes)){
				$toReturn .='<p><input type="checkbox" name="liste_jeu_version_plateforme_article[]" value="'.$dataJeuxVersionsPlateformes['id_jeu_version_plateforme'].'"';
				$result = mysqlCheckJeuVersionPlateforme($dataJeuxVersionsPlateformes['id_jeu_version_plateforme'], $_GET['id_article']);
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
	
	//on affiche d'abord toutes les images liées à la article. si l'une d'elle est l'image d'illustraiton on coche son bouton radio
	$resultAllImageNew = mysqlSelectAllImageArticle($_GET['id_article']);
	while($dataAllImageArticle = mysql_fetch_array($resultAllImageNew)){

			$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataAllImageArticle['url_article_image'].'" ';
			
			$resultIsIllustration = mysqlIsThisImageIllustrationOfTheArticle($_GET['id_article'],$dataAllImageArticle['url_article_image']);
			$dataIsIllustration = mysql_fetch_array($resultIsIllustration);

			if($dataIsIllustration['result']=='true'){
			
			$toReturn .= ' checked="checked" ';
			}
			
			$toReturn .='/>';
			$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataAllImageArticle['url_article_image'].'" checked="checked"/>';
			$toReturn .='<img src="../'.$dataAllImageArticle['url_article_image'].'" alt=""  /></p>';	
			$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" type="hidden" value="'.$dataAllImageArticle['image_titre'].'"/>';	
			$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" type="hidden" value="'.$dataAllImageArticle['image_alt'].'"/>';	
			
	}
	
	//il est possible que l'image d'illustration ne soit pas l'une d'elle dans ce cas on l'affiche, on ne coche pas sa checkbox par contre
	$resultIllustationArticleThatIsNotImage = mysqlSelectIllustationArticleThatIsNotImage($_GET['id_article']);
	while($dataIllustationArticleThatIsNotImage = mysql_fetch_array($resultIllustationArticleThatIsNotImage)){
					$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataIllustationArticleThatIsNotImage['url_article_illustration'].'" checked="checked"/>';
					$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataIllustationArticleThatIsNotImage['url_article_illustration'].'"/>';
					$toReturn .='<img src="../'.$dataIllustationArticleThatIsNotImage['url_article_illustration'].'" alt=""  /></p>';	

					$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" type="hidden" value="'.$dataIllustationArticleThatIsNotImage['image_titre'].'"/>';	
					$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" type="hidden" value="'.$dataIllustationArticleThatIsNotImage['image_titre'].'"/>';	
				
	}
	//on affiche maintenant les photos de l'article
	$resultAllArticlePhotoNotInArticle = mysqlSelectAllArticlePhotoNotInArticle($_GET['id_article']);// on selectionne tous les developpeurs liés à la article
	
	while($dataAllArticlePhotoNotInArticle = mysql_fetch_array($resultAllArticlePhotoNotInArticle)){
			
				$toReturn .='<p class="image_illustration_article">';
				$toReturn .='<input type="radio" name="image_illustration" value="'.$dataAllArticlePhotoNotInArticle['photo_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataAllArticlePhotoNotInArticle['photo_url'].'"/>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataAllArticlePhotoNotInArticle['photo_url'].'" alt=""  /></td>';	
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" type="hidden" value="'.$dataAllArticlePhotoNotInArticle['photo_titre'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" type="hidden" value="'.$dataAllArticlePhotoNotInArticle['photo_titre'].'"/>';	
				$toReturn .='</p>';
				
			
			
	}
	//on affiche maintenant les images developpeur qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultDeveloppeurArticle = mysqlSelectArticleDeveloppeur($_GET['id_article']);// on selectionne tous les developpeurs liés à la article
	while($dataDeveloppeurArticle = mysql_fetch_array($resultDeveloppeurArticle)){
			$resultDeveloppeurImageThatIsNotAlReadyInArticle = mysqlSelectDeveloppeurImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataDeveloppeurArticle['id_developpeur']);
			while($dataDeveloppeurImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultDeveloppeurImageThatIsNotAlReadyInArticle)){
				$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_nom'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images éditeur qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultEditeurArticle = mysqlSelectArticleEditeur($_GET['id_article']);// on selectionne tous les éditeurs liés à la article
	while($dataEditeurArticle = mysql_fetch_array($resultEditeurArticle)){
			$resultEditeurImageThatIsNotAlReadyInArticle = mysqlSelectEditeurImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataEditeurArticle['id_editeur']);
			while($dataEditeurImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultEditeurImageThatIsNotAlReadyInArticle)){
				$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_nom'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images constructeur qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultConstructeurArticle = mysqlSelectArticleConstructeur($_GET['id_article']);// on selectionne tous les constructeurs liés à la article
	while($dataConstructeurArticle = mysql_fetch_array($resultConstructeurArticle)){
			$resultConstructeurImageThatIsNotAlReadyInArticle = mysqlSelectConstructeurImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataConstructeurArticle['id_constructeur']);
			while($dataConstructeurImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultConstructeurImageThatIsNotAlReadyInArticle)){
				$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_nom'].'"/>';	
				
			}
	}
	
	
	//on affiche maintenant les images plateformes qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultPlateformeArticle = mysqlSelectArticlePlateforme($_GET['id_article']);// on selectionne tous les plateformes liés à la article
	while($dataPlateformeArticle = mysql_fetch_array($resultPlateformeArticle)){
			$resultPlateformeImageThatIsNotAlReadyInArticle = mysqlSelectPlateformeImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataPlateformeArticle['id_plateforme']);
			while($dataPlateformeImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultPlateformeImageThatIsNotAlReadyInArticle)){
				$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images version plateformes qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultPlateformeArticle = mysqlSelectArticlePlateforme($_GET['id_article']);// on selectionne tous les plateformes liés à la article
	while($dataPlateformeArticle = mysql_fetch_array($resultPlateformeArticle)){
			
			$resultPlateformeVersionImageThatIsNotAlReadyInArticle = mysqlSelectPlateformeVersionImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataPlateformeArticle['id_plateforme']);
			while($dataPlateformeVersionImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultPlateformeVersionImageThatIsNotAlReadyInArticle)){
				$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_version_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_version_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_version_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" type="hidden" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images categorie_news qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultCategorieArticle = mysqlSelectArticleCategorie($_GET['id_article']);// on selectionne tous les categorie liés à la article
	while($dataCategorieArticle = mysql_fetch_array($resultCategorieArticle)){
			$resultCategorieImageThatIsNotAlReadyInArticle = mysqlSelectCategorieArticleImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataCategorieArticle['id_sous_categorie_news']);
			while($dataCategorieImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultCategorieImageThatIsNotAlReadyInArticle)){
				$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_article_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_article_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_article_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_article_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_article_image_url']).'" type="hidden" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_article_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_article_image_url']).'" type="hidden" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_nom'].'"/>';	
				
			}
	}
	
	//on affiche maintenant les images jeux qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultJeuxArticle = mysqlSelectArticleJeux($_GET['id_article']);// on selectionne tous les constructeurs liés à la article
	while($dataJeuxArticle = mysql_fetch_array($resultJeuxArticle)){
			
			
			$resultJeuxImageThatIsNotAlReadyInArticle = mysqlSelectJeuxImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataJeuxArticle['id_jeu']);
			while($dataJeuxImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultJeuxImageThatIsNotAlReadyInArticle)){
				$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url'].'" />';
				$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url'].'"/>';
				$toReturn .='<img src="../'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" type="hidden" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" type="hidden" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_nom'].'"/>';	
				
			}
			
			$resultJeuxCoverThatIsNotAlReadyInArticle = mysqlSelectJeuxCoverThatIsNotAlReadyInArticle($_GET['id_article'],$dataJeuxNews['id_jeu']);
			while($dataJeuxCoverThatIsNotAlReadyInArticle = mysql_fetch_array($resultJeuxCoverThatIsNotAlReadyInArticle)){
				if($dataJeuxCoverThatIsNotAlReadyInArticle['image']=='ok'){
				$toReturn .='<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'.$dataJeuxCoverThatIsNotAlReadyInArticle['url'].'" />';
				$toReturn .='<input type="checkbox" name="news_liste_image[]" value="'.$dataJeuxCoverThatIsNotAlReadyInArticle['url'].'"/>';
				$toReturn .='<img src="../'.$dataJeuxCoverThatIsNotAlReadyInArticle['url'].'" alt=""  /></p>';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" type="hidden" value="cover '.$dataJeuxCoverThatIsNotAlReadyInArticle['jeu_nom'].'"/>';	
				$toReturn .='<input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" type="hidden" value="cover '.$dataJeuxCoverThatIsNotAlReadyInArticle['jeu_nom'].'"/>';	
				
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
    
    
    //on affiche d'abord toutes les images liées à la article. si l'une d'elle est l'image d'illustraiton on coche son bouton radio
	$resultAllImageArticle = mysqlSelectAllImageArticle($_GET['id_article']);
	while($dataAllImageArticle = mysql_fetch_array($resultAllImageArticle)){

			$toReturn .='<tr>';
			$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataAllImageArticle['url_article_image'].'"';

			$resultIsIllustration = mysqlIsThisImageIllustrationOfTheArticle($_GET['id_article'],$dataAllImageArticle['url_article_image']);
			$dataIsIllustration = mysql_fetch_array($resultIsIllustration);

			if($dataIsIllustration['result']=='true'){
			
			$toReturn .= ' checked="checked" ';
			}
			
			$toReturn .='/></td>';
			$toReturn .='<td><input type="checkbox" name="article_liste_image[]"  value="'.$dataAllImageArticle['url_article_image'].'" checked="checked"/></td>';
			$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataAllImageArticle['url_article_image'].'" alt=""  /></td>';	
			$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" type="text" value="'.$dataAllImageArticle['image_titre'].'"/></td>';	
			$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllImageArticle['url_article_image']).'" type="text" value="'.$dataAllImageArticle['image_alt'].'"/></td>';	
			$toReturn .='</tr>';

	}
	//il est possible que l'image d'illustration ne soit pas l'une d'elle dans ce cas on l'affiche, on ne coche pas sa checkbox par contre
	$resultIllustationArticleThatIsNotImage = mysqlSelectIllustationArticleThatIsNotImage($_GET['id_article']);
	while($dataIllustationArticleThatIsNotImage = mysql_fetch_array($resultIllustationArticleThatIsNotImage)){
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataIllustationArticleThatIsNotImage['url_article_illustration'].'" checked="checked"/></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataIllustationArticleThatIsNotImage['url_article_illustration'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataIllustationArticleThatIsNotImage['url_article_illustration'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" type="text" value="'.$dataIllustationArticleThatIsNotImage['image_titre'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataIllustationArticleThatIsNotImage['url_article_illustration']).'" type="text" value="'.$dataIllustationArticleThatIsNotImage['image_titre'].'"/></td>';	
				$toReturn .='</tr>';
				
	}
	
	//on affiche maintenant les photos de l'article
	$resultAllArticlePhotoNotInArticle = mysqlSelectAllArticlePhotoNotInArticle($_GET['id_article']);// on selectionne tous les developpeurs liés à la article
	
	while($dataAllArticlePhotoNotInArticle = mysql_fetch_array($resultAllArticlePhotoNotInArticle)){
			
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataAllArticlePhotoNotInArticle['photo_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataAllArticlePhotoNotInArticle['photo_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataAllArticlePhotoNotInArticle['photo_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" type="text" value="'.$dataAllArticlePhotoNotInArticle['photo_titre'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataAllArticlePhotoNotInArticle['photo_url']).'" type="text" value="'.$dataAllArticlePhotoNotInArticle['photo_titre'].'"/></td>';	
				$toReturn .='</tr>';
			
			
	}
	
	//on affiche maintenant les images developpeur qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultDeveloppeurArticle = mysqlSelectArticleDeveloppeur($_GET['id_article']);// on selectionne tous les developpeurs liés à la article
	
	while($dataDeveloppeurArticle = mysql_fetch_array($resultDeveloppeurArticle)){
			
			$resultDeveloppeurImageThatIsNotAlReadyInArticle = mysqlSelectDeveloppeurImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataDeveloppeurArticle['id_developpeur']);
			while($dataDeveloppeurImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultDeveloppeurImageThatIsNotAlReadyInArticle)){
				
				//$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataDeveloppeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataDeveloppeurImageThatIsNotAlReadyInArticle['developpeur_nom'].'"/></td>';	
				$toReturn .='</tr>';
				

			}
	}
    //on affiche maintenant les images editeur qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultEditeurArticle = mysqlSelectArticleEditeur($_GET['id_article']);// on selectionne tous les editeurs liés à la article
	
	while($dataEditeurArticle = mysql_fetch_array($resultEditeurArticle)){
			
			$resultEditeurImageThatIsNotAlReadyInArticle = mysqlSelectEditeurImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataEditeurArticle['id_editeur']);
			while($dataEditeurImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultEditeurImageThatIsNotAlReadyInArticle)){
				
				//$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataEditeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataEditeurImageThatIsNotAlReadyInArticle['editeur_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
    //on affiche maintenant les images constructeur qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultConstructeurArticle = mysqlSelectArticleConstructeur($_GET['id_article']);// on selectionne tous les constructeurs liés à la article
	
	while($dataConstructeurArticle = mysql_fetch_array($resultConstructeurArticle)){
			
			$resultConstructeurImageThatIsNotAlReadyInArticle = mysqlSelectConstructeurImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataConstructeurArticle['id_constructeur']);
			while($dataConstructeurImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultConstructeurImageThatIsNotAlReadyInArticle)){
				
				//$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataConstructeurImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataConstructeurImageThatIsNotAlReadyInArticle['constructeur_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	
		//on affiche maintenant les images plateformes qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultPlateformeArticle = mysqlSelectArticlePlateforme($_GET['id_article']);// on selectionne tous les plateformes liés à la article
	
	while($dataPlateformeArticle = mysql_fetch_array($resultPlateformeArticle)){
			
			$resultPlateformeImageThatIsNotAlReadyInArticle = mysqlSelectPlateformeImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataPlateformeArticle['id_plateforme']);
			while($dataPlateformeImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultPlateformeImageThatIsNotAlReadyInArticle)){
				
				//$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataPlateformeImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	
	//on affiche maintenant les images version plateformes qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultPlateformeArticle = mysqlSelectArticlePlateforme($_GET['id_article']);// on selectionne tous les plateformes liés à la article
	
	while($dataPlateformeArticle = mysql_fetch_array($resultPlateformeArticle)){
			
			$resultPlateformeVersionImageThatIsNotAlReadyInArticle = mysqlSelectPlateformeVersionImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataPlateformeArticle['id_plateforme']);
			while($dataPlateformeVersionImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultPlateformeVersionImageThatIsNotAlReadyInArticle)){
				
				//$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_version_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataPlateformeVersionImageThatIsNotAlReadyInArticle['url_article_image']).'" type="text" value="'.$dataPlateformeVersionImageThatIsNotAlReadyInArticle['plateforme_nom_generique'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	

	
	    //on affiche maintenant les images constructeur qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultCategorieArticle = mysqlSelectArticleCategorie($_GET['id_article']);// on selectionne tous les categories liés à la article
	
	while($dataCategorieArticle = mysql_fetch_array($resultCategorieArticle)){
			
			$resultCategorieImageThatIsNotAlReadyInArticle = mysqlSelectCategorieArticleImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataCategorieArticle['id_sous_categorie_news']);
			while($dataCategorieImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultCategorieImageThatIsNotAlReadyInArticle)){
				
				//$toReturn .='<p class="image_illustration_article"><input type="radio" name="image_illustration" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['categorie_image_url'].'" />';
				//$toReturn .='<input type="checkbox" name="article_liste_image[]" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['categorie_image_url'].'"/>';
				//$toReturn .='<img src="../'.$dataCategorieImageThatIsNotAlReadyInArticle['categorie_image_url'].'" alt=""  /></p>';
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_image_url']).'" type="text" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_image_url']).'" type="text" value="'.$dataCategorieImageThatIsNotAlReadyInArticle['sous_categorie_news_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
	}
	
	
		//on affiche maintenant les images jeux qui n'existe pas dnas la table article_image, ces image sont décochées
	$resultJeuxArticle = mysqlSelectArticleJeux($_GET['id_article']);// on selectionne tous les categories liés à la article
	while($dataJeuxArticle = mysql_fetch_array($resultJeuxArticle)){
			
			
			$resultJeuxImageThatIsNotAlReadyInArticle = mysqlSelectJeuxImageThatIsNotAlReadyInArticle($_GET['id_article'],$dataJeuxArticle['id_jeu']);
			while($dataJeuxImageThatIsNotAlReadyInArticle = mysql_fetch_array($resultJeuxImageThatIsNotAlReadyInArticle)){
				
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" type="text" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxImageThatIsNotAlReadyInArticle['jeu_image_url']).'" type="text" value="'.$dataJeuxImageThatIsNotAlReadyInArticle['jeu_nom'].'"/></td>';	
				$toReturn .='</tr>';
			
			}
			
			$resultJeuxCoverThatIsNotAlReadyInArticle = mysqlSelectJeuxCoverThatIsNotAlReadyInArticle($_GET['id_article'],$dataJeuxNews['id_jeu']);
			while($dataJeuxCoverThatIsNotAlReadyInArticle = mysql_fetch_array($resultJeuxCoverThatIsNotAlReadyInArticle)){
				if($dataJeuxCoverThatIsNotAlReadyInArticle['image']=='ok'){
				
				$toReturn .='<tr>';
				$toReturn .='<td><input type="radio" name="image_illustration" value="'.$dataJeuxCoverThatIsNotAlReadyInArticle['url'].'" /></td>';
				$toReturn .='<td><input type="checkbox" name="article_liste_image[]" value="'.$dataJeuxCoverThatIsNotAlReadyInArticle['url'].'"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="../'.$dataJeuxCoverThatIsNotAlReadyInArticle['url'].'" alt=""  /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" type="text" value="cover '.$dataJeuxCoverThatIsNotAlReadyInArticle['jeu_nom'].'"/></td>';	
				$toReturn .='<td><input id="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" name="alt_'.deleteTousCaracteresSpeciaux($dataJeuxCoverThatIsNotAlReadyInArticle['url']).'" type="text" value="cover '.$dataJeuxCoverThatIsNotAlReadyInArticle['jeu_nom'].'"/></td>';	
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
    
    
	//on affiche d'abord toutes les video liées à la article. 
	$resultAllVideoNew = mysqlSelectAllVideoArticle($_GET['id_article']);
	while($dataAllVideoArticle = mysql_fetch_array($resultAllVideoNew)){
			parse_str( parse_url( $dataAllVideoArticle['url_article_video'], PHP_URL_QUERY ), $my_array_of_vars );
			$youtube_id = $my_array_of_vars['v'];
			$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			

			$toReturn .='<td><input type="checkbox" name="article_liste_video[]" value="'.$dataAllVideoArticle['url_article_video'].'" checked="checked"/></td>';
			$toReturn .='<td class="cell_image_categorie_news"><img src="'.$src.'" alt=""   /></td>';	
			$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoArticle['url_article_video']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoArticle['url_article_video']).'" type="text" value="'.$dataAllImageArticle['video_titre'].'"/></td>';	
			$toReturn .='</tr>';
	}
    
    
    //on affiche maintenant les video qui n'existe pas dnas la table article_video, ces video sont décochées
	$resultJeuxArticle = mysqlSelectArticleJeux($_GET['id_article']);// on selectionne tous les plateformes liés à la article
	while($dataJeuxArticle = mysql_fetch_array($resultJeuxArticle)){	
			$resultJeuxVideoThatIsNotAlReadyInArticle = mysqlSelectJeuxVideoThatIsNotAlReadyInArticle($_GET['id_article'],$dataJeuxArticle['id_jeu']);
			while($dataJeuxVideoThatIsNotAlReadyInArticle = mysql_fetch_array($resultJeuxVideoThatIsNotAlReadyInArticle)){
				parse_str( parse_url( $dataJeuxVideoThatIsNotAlReadyInArticle['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
				$youtube_id = $my_array_of_vars['v'];
				$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			

				$toReturn .='<td><input type="checkbox" name="article_liste_video[]" value="'.$dataJeuxVideoThatIsNotAlReadyInArticle['video_url'].'" checked="checked"/></td>';
				$toReturn .='<td class="cell_image_categorie_news"><img src="'.$src.'" alt=""   /></td>';	
				$toReturn .='<td><input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInArticle['video_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInArticle['video_url']).'" type="text" value="'.$dataJeuxVideoThatIsNotAlReadyInArticle['video_titre'].'"/></td>';	
				$toReturn .='</tr>';
			}
	}


    
	$toReturn .='</table>';
	
	$toReturn .='</fieldset>';
	*/
	


	
	
	
	$toReturn .='<fieldset id="video_fieldset" ><legend>videos</legend>';
	
	//on affiche d'abord toutes les video liées à la article. 
	$resultAllVideoNew = mysqlSelectAllVideoArticle($_GET['id_article']);
	while($dataAllVideoArticle = mysql_fetch_array($resultAllVideoNew)){
			parse_str( parse_url( $dataAllVideoArticle['url_article_video'], PHP_URL_QUERY ), $my_array_of_vars );
			$youtube_id = $my_array_of_vars['v'];
			$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			
			$toReturn .='<p class="image_illustration_article">';
			$toReturn .='<input type="checkbox" name="article_liste_video[]" value="'.$dataAllVideoArticle['url_article_video'].'" checked="checked"/>';
			$toReturn .='<img src="'.$src.'" alt=""  />';
			$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoArticle['url_article_video']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataAllVideoArticle['url_article_video']).'" type="hidden" value="'.$dataAllVideoArticle['video_titre'].'"/></td>';	

			$toReturn .='</p>';	
	}
	
	//on affiche maintenant les video qui n'existe pas dnas la table article_video, ces video sont décochées
	$resultJeuxArticle = mysqlSelectArticleJeux($_GET['id_article']);// on selectionne tous les plateformes liés à la article
	while($dataJeuxArticle = mysql_fetch_array($resultJeuxArticle)){	
			$resultJeuxVideoThatIsNotAlReadyInArticle = mysqlSelectJeuxVideoThatIsNotAlReadyInArticle($_GET['id_article'],$dataJeuxArticle['id_jeu']);
			while($dataJeuxVideoThatIsNotAlReadyInArticle = mysql_fetch_array($resultJeuxVideoThatIsNotAlReadyInArticle)){
				parse_str( parse_url( $dataJeuxVideoThatIsNotAlReadyInArticle['video_url'], PHP_URL_QUERY ), $my_array_of_vars );
				$youtube_id = $my_array_of_vars['v'];
				$src='http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
			
				$toReturn .='<p class="image_illustration_article">';
				$toReturn .='<input type="checkbox" name="article_liste_video[]" value="'.$dataJeuxVideoThatIsNotAlReadyInArticle['video_url'].'"/>';
				$toReturn .='<img src="'.$src.'" alt=""  />';
				$toReturn .='<input id="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInArticle['video_url']).'" name="titre_'.deleteTousCaracteresSpeciaux($dataJeuxVideoThatIsNotAlReadyInArticle['video_url']).'" type="hidden" value="'.$dataJeuxVideoThatIsNotAlReadyInArticle['video_titre'].'"/>';	

				$toReturn .='</p>';	
			}
	}
	
	
	
	$toReturn .='</fieldset>';
	
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_article"/></p>';

	$toReturn .='<input type="hidden" id="id_article" value="'.$_GET['id_article'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
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