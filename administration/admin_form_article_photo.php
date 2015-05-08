<?php
require_once('mysql_fonctions_article_photo.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin article]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createArticlePhotoGestionForm(){
	
	$resultArticle =  mysqlSelectArticleByID($_GET['id_article']);
	$dataArticle=mysql_fetch_array($resultArticle);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">articles</span></a>';
	$toReturn .='<span class="to_edit"><a href="#">'.$dataArticle['article_titre'].'</span></a>';

	$toReturn .='<span class="to_edit"><a href="#">photos</span></a>';

	$toReturn .='gérer</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_article_photo.php?id_article='.$_GET['id_article'].'" method="post" enctype="multipart/form-data" >';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter des photos pour cet article" name="submit_article_photo"/></p>';
	$toReturn .='</form>';
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//

	$toReturn .='<form action="admin_traitement_article.php" method="post" enctype="multipart/form-data">';
	// ------les image les uns aux dessus des autres------- //
	$toReturn .='<fieldset>';
	$toReturn .='<table>';
	$toReturn .='<tr>';
    $toReturn .='<th></th>';
    $toReturn .='<th></th>';
    $toReturn .='<th>image</th>';
    $toReturn .='<th>titre</th>';
    $toReturn .='<th>catégorie</th>';
    $toReturn .='</tr>';
	$result = mysqlSelectAllArticlePhoto($_GET['id_article']);
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_article_photo.php?submit_article_photo=delete&id_article_photo='.htmlspecialchars(trim($data["id_article_photo"])).'&id_article='.htmlspecialchars(trim($_GET['id_article'])).'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?article_photo=edit&id_article_photo='.htmlspecialchars(trim($data["id_article_photo"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td class="cell_image_categorie_news"><img class="image_categorie_news" src="'.dossier_articles().'/'.htmlspecialchars(trim($data["article_photo_nom"])).'" alt="logo '.htmlspecialchars(trim($data["id_article_photo"])).'" /></td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["photo_titre"])).'</td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["categorie_image_nom"])).'</td>';

   		 $toReturn .='</tr>';
   		
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&id_article='.$_GET['id_article'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
	$toReturn .='</form>';
	return $toReturn;
	
}
function createArticlePhotoAddForm(){

	$resultArticle =  mysqlSelectArticleByID($_GET['id_article']);
	$dataArticle=mysql_fetch_array($resultArticle);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">articles</span></a>';
	$toReturn .='<span class="to_edit"><a href="administration.php?article_photo=gestion&id_article='.$_GET['id_article'].'">'.$dataArticle['article_titre'].'</span></a>';

	$toReturn .='<span class="to_edit"><a href="#">photos</span></a>';

	$toReturn .='ajouter</h3>';
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_article_photo.php?id_article='.$_GET['id_article'].'" method="post" enctype="multipart/form-data" >';
	
	//---------------------//
	$toReturn .='<fieldset>';	
	$toReturn .='<p>';
    $toReturn .='<label for="photo_titre">titre photo: </label>';
	$toReturn .='<input id="photo_titre" type="text" name="photo_titre"/>';
	$toReturn .='</p>';
	$toReturn .='<p><label for="id_categorie_image">categorie: </label>';	
	$toReturn .='<select name="id_categorie_image" id="id_categorie_image">';	
	$result = mysqlSelectAllImgCategories();
	$toReturn .= '<option value="">-- catégorie --</option>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_image"].'">'.$data["categorie_image_nom"].'</option>';
	}
	$toReturn .='</select></p>';
	
	$toReturn .='<p><label for="photo_file">photo: </label>';
	$toReturn .='<input id="photo_file" type="file" name="photo_file[]" class="img"  multiple/><span class="obligatoire"></span></p>';
		
	$toReturn .='</fieldset>';
	
	//---------------------//
	
	
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_article_photo"/></p>';
	$toReturn .='</form>';
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//

	$toReturn .='<form action="admin_traitement_article.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<input type="hidden" id="admin_operation" value="add&id_article='.$_GET['id_article'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
	$toReturn .='</form>';
	return $toReturn;
}
	
	
	
function createArticlePhotoEditForm(){
	$resultArticlePhoto =  mysqlSelectArticlePhoto($_GET['id_article_photo']);
	$dataArticlePhoto=mysql_fetch_array($resultArticlePhoto);
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?article=gestion&page=1&order=article_date_modif">articles</span></a>';
	$toReturn .='<span class="to_edit"><a href="administration.php?article_photo=gestion&id_article='.$dataArticlePhoto['id_article'].'">'.$dataArticlePhoto['article_titre'].'</span></a>';
	$toReturn .='<span class="to_edit"><a href="#">photos</span></a>';
	$toReturn .='<span class="to_edit"><a href="#">'.$dataArticlePhoto['photo_titre'].'</span></a>';
		
	$toReturn .='modifier</h3>';
	
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_article_photo.php?id_article_photo='.$_GET['id_article_photo'].'&id_article='.$dataArticlePhoto['id_article'].'" method="post" enctype="multipart/form-data" >';
	
	//---------------------//
	$toReturn .='<fieldset>';	
	$toReturn .='<p>';
    $toReturn .='<label for="photo_titre">titre photo: </label>';
	$toReturn .='<input id="photo_titre" type="text" name="photo_titre" value="'.$dataArticlePhoto['photo_titre'].'"/>';
	$toReturn .='</p>';
	$toReturn .='<p><label for="id_categorie_image">categorie: </label>';	
	$toReturn .='<select name="id_categorie_image" id="id_categorie_image">';	
	$result = mysqlSelectAllImgCategories();
	$toReturn .= '<option value="">-- catégorie --</option>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_image"].'"';
   		if($dataArticlePhoto['id_categorie_image'] == $data["id_categorie_image"]){
   			$toReturn .='selected="selected"';
   		}
   		$toReturn .= '>'.$data["categorie_image_nom"].'</option>';
	}
	$toReturn .='</select></p>';
	
	//$toReturn .='<p><label for="photo_file">photo: </label>';
	//$toReturn .='<input id="photo_file" type="file" name="photo_file[]" class="img"  multiple/><span class="obligatoire"></span></p>';
		
	$toReturn .='</fieldset>';
	
	//---------------------//
	
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_article_photo"/></p>';

	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//



	$toReturn .='<input type="hidden" id="admin_operation" value="add&id_article='.$_GET['id_article'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="article"/>';
	$toReturn .='</form>';
	return $toReturn;
}
	


?>