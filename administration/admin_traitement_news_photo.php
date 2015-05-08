<?php
require_once('mysql_fonctions_news_photo.php'); 
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

if (isset($_POST['submit_news_photo']) || isset($_GET['submit_news_photo']) ){
	if($_POST['submit_news_photo']=="ajouter des photos pour cet news"){
		
		header("Location:  administration.php?news_photo=add&id_news=".$_GET['id_news']."");
	}
	if($_POST['submit_news_photo']=="ajouter"){
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
            	move_uploaded_file( $tmpName, "../news/".$image_name); // move to new location perhaps?
            	mysqlInsertNewsPhoto($_GET['id_news'],$image_name,$_POST['photo_titre'],$_POST['id_categorie_image']);
            	$i++;
            	
        	}
    	}
		mysqlUpdateNewsDateModif($_GET['id_news']);
		header("Location:  administration.php?news_photo=gestion&id_news=".$_GET['id_news']."");
		
	}
	if($_POST['submit_news_photo']=="sauvegarder"){
		mysqlUpdateNewsPhoto($_GET['id_news_photo'],$_POST['photo_titre'],$_POST['id_categorie_image']);
		header("Location:  administration.php?news_photo=gestion&id_news=".$_GET['id_news']."&record=ok");

	}
	else if($_GET['submit_news_photo']=="delete"){
		$result = mysqlSelectNewsPhoto($_GET['id_news_photo']);
		$data = mysql_fetch_array($result);
		unlink (dossier_news()."/".trim($data["news_photo_nom"]));
		mysqlDeleteNewsPhoto($_GET['id_news_photo']);
		mysqlUpdateNewsDateModif($_GET['id_news']);
		
		header("Location:  administration.php?news_photo=gestion&id_news=".$_GET['id_news']."&record=ok");

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