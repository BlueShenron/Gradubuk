<?php
require_once('mysql_fonctions_article_photo.php'); 
require_once('authentification.php');
require_once('dossiers_ressources.php');
require_once('images_functions.php'); 
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form membre]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_article_photo']) || isset($_GET['submit_article_photo']) ){
	if($_POST['submit_article_photo']=="ajouter des photos pour cet article"){
		
		header("Location:  administration.php?article_photo=add&id_article=".$_GET['id_article']."");
	}
	if($_POST['submit_article_photo']=="ajouter"){
		$i = 0;
		foreach( $_FILES[ 'photo_file' ][ 'tmp_name' ] as $index => $tmpName ) {
			if( !empty( $_FILES[ 'image' ][ 'error' ][ $index ] ) ){
           		// some error occured with the file in index $index
           	 	// yield an error here
            	echo 'nok';
				return false; // return false also immediately perhaps??
        	}
        	if( !empty( $tmpName ) && is_uploaded_file( $tmpName ) ){
            	// the path to the actual uploaded file is in $_FILES[ 'image' ][ 'tmp_name' ][ $index ]
            	// do something with it:
            	$image_name = deleteTousCaracteresSpeciaux($_POST['photo_titre']).'_'.$i.'_'.nameimage();
            	move_uploaded_file( $tmpName, "../articles/".$image_name); // move to new location perhaps?
            	mysqlInsertArticlePhoto($_GET['id_article'],$image_name,$_POST['photo_titre'],$_POST['id_categorie_image']);
            	$i++;
            	
        	}
    	}
		mysqlUpdateArticleDateModif($_GET['id_article']);
		header("Location:  administration.php?article_photo=gestion&id_article=".$_GET['id_article']."");
		
	}
	if($_POST['submit_article_photo']=="sauvegarder"){
		mysqlUpdateArticlePhoto($_GET['id_article_photo'],$_POST['photo_titre'],$_POST['id_categorie_image']);
		header("Location:  administration.php?article_photo=gestion&id_article=".$_GET['id_article']."&record=ok");

	}
	else if($_GET['submit_article_photo']=="delete"){
		$result = mysqlSelectArticlePhoto($_GET['id_article_photo']);
		$data = mysql_fetch_array($result);
		unlink (dossier_articles()."/".trim($data["article_photo_nom"]));
		mysqlDeleteArticlePhoto($_GET['id_article_photo']);
		mysqlUpdateArticleDateModif($_GET['id_article']);
		
		header("Location:  administration.php?article_photo=gestion&id_article=".$_GET['id_article']."&record=ok");

	}
	
	

}

}
else{
	header("Location:  ../index.php");
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