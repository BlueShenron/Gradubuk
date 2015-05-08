<?php
require_once('mysql_fonctions_news_photo.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin news]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createNewsPhotoGestionForm(){
	
	$resultNews =  mysqlSelectNewsByID($_GET['id_news']);
	$dataNews=mysql_fetch_array($resultNews);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a>';
	$toReturn .='<span class="to_edit"><a href="#">'.$dataNews['news_titre'].'</span></a>';

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
	$toReturn .='<form action="admin_traitement_news_photo.php?id_news='.$_GET['id_news'].'" method="post" enctype="multipart/form-data" >';
	$toReturn .='<p><input id="submit" type="submit" value="ajouter des photos pour cet news" name="submit_news_photo"/></p>';
	$toReturn .='</form>';
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//

	$toReturn .='<form action="admin_traitement_news.php" method="post" enctype="multipart/form-data">';
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
	$result = mysqlSelectAllNewsPhoto($_GET['id_news']);
	while($data=mysql_fetch_array($result)) {
		$toReturn .='<tr>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_news_photo.php?submit_news_photo=delete&id_news_photo='.htmlspecialchars(trim($data["id_news_photo"])).'&id_news='.htmlspecialchars(trim($_GET['id_news'])).'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="administration.php?news_photo=edit&id_news_photo='.htmlspecialchars(trim($data["id_news_photo"])).'"><span>modifier</span></a></td>';
   		$toReturn .= '<td class="cell_image_categorie_news"><img class="image_categorie_news" src="'.dossier_news().'/'.htmlspecialchars(trim($data["news_photo_nom"])).'" alt="logo '.htmlspecialchars(trim($data["id_news_photo"])).'" /></td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["photo_titre"])).'</td>';
   		$toReturn .= '<td>'.htmlspecialchars(trim($data["categorie_image_nom"])).'</td>';

   		 $toReturn .='</tr>';
   		
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion&id_news='.$_GET['id_news'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
	$toReturn .='</form>';
	return $toReturn;
	
}
function createNewsPhotoAddForm(){

	$resultNews =  mysqlSelectNewsByID($_GET['id_news']);
	$dataNews=mysql_fetch_array($resultNews);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a>';
	$toReturn .='<span class="to_edit"><a href="administration.php?news_photo=gestion&id_news='.$_GET['id_news'].'">'.$dataNews['news_titre'].'</span></a>';

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
	$toReturn .='<form action="admin_traitement_news_photo.php?id_news='.$_GET['id_news'].'" method="post" enctype="multipart/form-data" >';
	
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
	
	
	$toReturn .='<p><input id="submit" type="submit" value="ajouter" name="submit_news_photo"/></p>';
	$toReturn .='</form>';
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//

	$toReturn .='<form action="admin_traitement_news.php" method="post" enctype="multipart/form-data">';

	$toReturn .='<input type="hidden" id="admin_operation" value="add&id_news='.$_GET['id_news'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
	$toReturn .='</form>';
	return $toReturn;
}
	
	
	
function createNewsPhotoEditForm(){
	$resultNewsPhoto =  mysqlSelectNewsPhoto($_GET['id_news_photo']);
	$dataNewsPhoto=mysql_fetch_array($resultNewsPhoto);
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?news=gestion&page=1&order=news_date_modif">news</span></a>';
	$toReturn .='<span class="to_edit"><a href="administration.php?news_photo=gestion&id_news='.$dataNewsPhoto['id_news'].'">'.$dataNewsPhoto['news_titre'].'</span></a>';
	$toReturn .='<span class="to_edit"><a href="#">photos</span></a>';
	$toReturn .='<span class="to_edit"><a href="#">'.$dataNewsPhoto['photo_titre'].'</span></a>';
		
	$toReturn .='modifier</h3>';
	
	
	if($_GET['record']=="nok"){
		$toReturn .='<p class="message_alerte important_rouge">not ok</p>';
	}
	else if($_GET['record']=="ok"){
		$toReturn .='<p class="message_alerte important_vert">ok</p>';
	}
	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//
	$toReturn .='<form action="admin_traitement_news_photo.php?id_news_photo='.$_GET['id_news_photo'].'&id_news='.$dataNewsPhoto['id_news'].'" method="post" enctype="multipart/form-data" >';
	
	//---------------------//
	$toReturn .='<fieldset>';	
	$toReturn .='<p>';
    $toReturn .='<label for="photo_titre">titre photo: </label>';
	$toReturn .='<input id="photo_titre" type="text" name="photo_titre" value="'.$dataNewsPhoto['photo_titre'].'"/>';
	$toReturn .='</p>';
	$toReturn .='<p><label for="id_categorie_image">categorie: </label>';	
	$toReturn .='<select name="id_categorie_image" id="id_categorie_image">';	
	$result = mysqlSelectAllImgCategories();
	$toReturn .= '<option value="">-- catégorie --</option>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .= '<option value="'.$data["id_categorie_image"].'"';
   		if($dataNewsPhoto['id_categorie_image'] == $data["id_categorie_image"]){
   			$toReturn .='selected="selected"';
   		}
   		$toReturn .= '>'.$data["categorie_image_nom"].'</option>';
	}
	$toReturn .='</select></p>';
	
	//$toReturn .='<p><label for="photo_file">photo: </label>';
	//$toReturn .='<input id="photo_file" type="file" name="photo_file[]" class="img"  multiple/><span class="obligatoire"></span></p>';
		
	$toReturn .='</fieldset>';
	
	//---------------------//
	
	
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_news_photo"/></p>';

	$toReturn .='<hr/>';
	//------------------------------------------------------------------------------------------------//



	$toReturn .='<input type="hidden" id="admin_operation" value="add&id_news='.$_GET['id_news'].'"/>';

	$toReturn .='<input type="hidden" id="admin" value="classique"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="news"/>';
	$toReturn .='</form>';
	return $toReturn;
}
	


?>