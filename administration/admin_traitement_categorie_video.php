<?php
require_once('mysql_fonctions_categorie_video.php'); 
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form categorie_video]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_categorie_video']) || isset($_GET['submit_categorie_video']) ){
	if($_POST['submit_categorie_video']=="ajouter"){
		if(trim($_POST['categorie_video_name']) == ""){
			header("Location:  administration.php?categorie_video=add&page=1&order=categorie_video_date_modif&record=nok");
		}
		else if(trim($_POST['categorie_video_name']) != ""){
			mysqlInsertCategorieVideo($_POST['categorie_video_name']);
			header("Location:  administration.php?categorie_video=gestion&page=1&order=categorie_video_date_modif&record=ok");
		}
	}
	else if($_GET['submit_categorie_video']=="delete"){
		mysqlDeleteCategorieVideoByID($_GET['id_categorie_video']);
		header("Location:  administration.php?categorie_video=gestion&page=1&order=categorie_video_date_modif&record=ok");
	}
	else if($_POST['submit_categorie_video']=="ajouter une catégorie"){
		header("Location:  administration.php?categorie_video=add");
	}
	else if ($_POST['submit_categorie_video'] =="sauvegarder"){

			$result = mysqlSelectCategorieVideoByID($_GET['id_categorie_video']);
			$data = mysql_fetch_array($result);
			//insertCategorieVideo($_POST['categorie_video_name'], $image_name);
			
			if(trim($_POST['categorie_video_name']) == "" ){
			header("Location:  administration.php?categorie_video=edit&id_categorie_video=".$_GET['id_categorie_video']."&record=nok");
			}
			else{
			mysqlUpdateCategorieVideo($_POST['categorie_video_name'], $_GET['id_categorie_video']);
			header("Location:  administration.php?categorie_video=gestion&page=1&order=categorie_video_date_modif&record=ok");
			}
		
	}
	
}

}
else{
	header("Location:  ../index.php");
}


?>