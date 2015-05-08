<?php
require_once('mysql_fonctions_categorie_news.php');
require_once('dossiers_ressources.php');

/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
							/*[form admin categorie_news]*/
/*------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/
function createCategorieNewsGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_news=gestion&page=1&order=categorie_news_date_modif">Catégories News</a></span>gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_categorie_news.php" method="post" enctype="multipart/form-data">';

	/*$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="categorie_news_name">nom: </label>';
	$toReturn .='<input id="categorie_news_name" type="text" name="categorie_news_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_categorie_news"/></p>';
	*/
	$toReturn .= '<hr/>';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter une catégorie" name="submit_categorie_news"/></p>';
	$toReturn .= '<hr/>';
	//-----------filtre de tri-----------//
	/*$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="categorie_news_date_modif"';
 	if($_GET['order']=="categorie_news_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par dernières modifiées</option>';
  	$toReturn .= '<option value="categorie_news_date_creation"';
  	if($_GET['order']=="categorie_news_date_creation"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par dernières créées</option>'; 
 	$toReturn .= '<option value="categorie_news_nom"';
 	if($_GET['order']=="categorie_news_nom"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par nom</option>';
 	
	$toReturn .= '</select></p>';*/
	//-----------filtre de tri-----------//
	//$nb_element_par_page=10;
	// ------les dev les uns aux dessus des autres------- //
	
	$toReturn .='<fieldset id="tableau_version">';
	$toReturn .='<table id="tableau_categorie_news">
					<tr>
					<th></th>
					<th></th>
					
					<th>catégorie</th>
					
					<th colspan=5>sous catégories</th>
    				
  					</tr>';
  					
  	$number = 0;
	$resultCategorieNews = mysqlSelectAllCategorieNews();
	while($dataCategorieNews=mysql_fetch_array($resultCategorieNews)) {
	
		
		if ($number % 2 == 0) {
 		$class = "table_even";
		}
		else{
		$class = "table_odd";
		}
		$resultCountSousCategorie = mysqlCountSousCategorie($dataCategorieNews['id_categorie_news']);
		$dataCountSousCategorie = mysql_fetch_array($resultCountSousCategorie);

		
		$toReturn .= '<tr class="'.$class.' last_line">';
		$toReturn .= '<td class="center delete_item_table " rowspan="'.htmlspecialchars(trim($dataCountSousCategorie["rowspan"])).'"><a href="admin_traitement_categorie_news.php?submit_categorie_news=delete&id_categorie_news='.htmlspecialchars(trim($dataCategorieNews["id_categorie_news"])).'"><span>supprimer cette categorie news</span></a></td>';
		$toReturn .= '<td  class="center edit_item_table" rowspan="'.htmlspecialchars(trim($dataCountSousCategorie["rowspan"])).'"><a href="administration.php?categorie_news=edit&id_categorie_news='.htmlspecialchars(trim($dataCategorieNews["id_categorie_news"])).'"><span>modifier cette famille categorie news</span></a></td>';
		$toReturn .= '<td  rowspan="'.htmlspecialchars(trim($dataCountSousCategorie["rowspan"])).'">'.htmlspecialchars(trim($dataCategorieNews["categorie_news_nom"])).'</td>';
 		$toReturn .= '<td  class="center add_item_table" rowspan="'.htmlspecialchars(trim($dataCountSousCategorie["rowspan"])).'"><a href="administration.php?sous_categorie_news=add&id_categorie_news='.htmlspecialchars(trim($dataCategorieNews["id_categorie_news"])).'"><span>ajouter une sous categorie</span></a></td>';

 		
 		
 		
 		//ici il faut afficher le premier élément
 		$resultPremierSousCategorie = mysqlSelectPremierSousCategorieNews($dataCategorieNews['id_categorie_news']);
 		$dataPremierSousCategorie = mysql_fetch_array($resultPremierSousCategorie);

		if(htmlspecialchars(trim($dataCountSousCategorie["count"]))>0){
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_sous_categorie_news.php?submit_sous_categorie_news=delete&id_sous_categorie_news='.htmlspecialchars(trim($dataPremierSousCategorie["id_sous_categorie_news"])).'"><span>supprimer cette sous categorie news</span></a></td>';
		$toReturn .= '<td  class="center edit_item_table"><a href="administration.php?sous_categorie_news=edit&id_sous_categorie_news='.htmlspecialchars(trim($dataPremierSousCategorie["id_sous_categorie_news"])).'"><span>modifier cette sous categorie news</span></a></td>';
		$toReturn .= '<td class="cell_image_categorie_news"><img class="image_categorie_news" src="'.dossier_categories_news()."/".htmlspecialchars(trim($dataPremierSousCategorie["sous_categorie_news_logo"])).'"/></td>';
 		$toReturn .= '<td>'.htmlspecialchars(trim($dataPremierSousCategorie["sous_categorie_news_nom"])).'</td>';
		}
		else{
		$toReturn .= '<td></td>';
		$toReturn .= '<td></td>';
		$toReturn .= '<td></td>';
		$toReturn .= '<td></td>';
		}	
		$toReturn .= '</tr>'; // puis on ferme la ligne
		
		
		//et la on affiche le reste
		$resultSousCategorieSuivante = mysqlSelectSousCategorieNewsSuivante(htmlspecialchars(trim($dataCountSousCategorie["count"])),$dataCategorieNews['id_categorie_news']);
 		
 		while($dataSousCategorieSuivante = mysql_fetch_array($resultSousCategorieSuivante)){
 		$toReturn .= '<tr class="'.$class.'">';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_sous_categorie_news.php?submit_sous_categorie_news=delete&id_sous_categorie_news='.htmlspecialchars(trim($dataSousCategorieSuivante["id_sous_categorie_news"])).'"><span>supprimer cette categorie news</span></a></td>';
		$toReturn .= '<td  class="center edit_item_table"><a href="administration.php?sous_categorie_news=edit&id_sous_categorie_news='.htmlspecialchars(trim($dataSousCategorieSuivante["id_sous_categorie_news"])).'"><span>modifier cette sous categorie news</span></a></td>';
		$toReturn .= '<td class="cell_image_categorie_news" ><img class="image_categorie_news" src="'.dossier_categories_news()."/".htmlspecialchars(trim($dataSousCategorieSuivante["sous_categorie_news_logo"])).'"/></td>';

 		$toReturn .= '<td>'.htmlspecialchars(trim($dataSousCategorieSuivante["sous_categorie_news_nom"])).'</td>
 		</tr>';
 		}
 		
 		$number ++;
		
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	/* ------page------- */
	/*$resultDev = mysqlSelectAllCategorieNews();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?categorie_news=add&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
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
		$toReturn .= '<a href="administration.php?categorie_news=add&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}*/
	/* ------page------- */
	
	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="categorie_news"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createCategorieNewsAddForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_news=gestion&page=1&order=categorie_news_date_modif">Catégories News</a></span>ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">vérifier la validité des champs obligatoires</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
	
	$toReturn .='<form action="admin_traitement_categorie_news.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	$toReturn .='<p>';
    $toReturn .='<label for="categorie_news_name">nom: </label>';
	$toReturn .='<input id="categorie_news_name" type="text" name="categorie_news_name"/>';
	$toReturn .='<span class="obligatoire"><span>obligatoire</span></span></p>';
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_categorie_news"/></p>';
	
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="categorie_news"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="add"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}
function createCategorieNewsEditForm(){
		$result = mysqlSelectCategorieNewsByID($_GET['id_categorie_news']);
		$data = mysql_fetch_array($result);
		
		$toReturn .='<h3><span class="to_edit"><a href="administration.php?categorie_news=gestion&page=1&order=categorie_news_date_modif">categories news</a></span><span class="to_edit"><a href="administration.php?categorie_news=add&page=1&order=categorie_news_date_modif">'.htmlspecialchars(trim($data["categorie_news_nom"])).'</a></span>modifier</h3>';

		if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
		}
		
		$toReturn .= '<form action="admin_traitement_categorie_news.php?&id_categorie_news='.htmlspecialchars(trim($data["id_categorie_news"])).'" method="post" enctype="multipart/form-data">';
		$toReturn .='<fieldset>';
	
		$toReturn .='<p><label for="categorie_news_name">nom: </label>';
		$toReturn .='<input id="categorie_news_name" type="text" name="categorie_news_name" value="'.htmlspecialchars(trim($data["categorie_news_nom"])).'"/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
		
		
		$toReturn .='</fieldset>';
		$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_categorie_news"/></p>';
		$toReturn .='<input type="hidden" id="admin" value="advance"/>';
		$toReturn .='<input type="hidden" id="admin_rubrique" value="categorie_news"/>';
		$toReturn .= '</form">';
		return $toReturn;
}

?>