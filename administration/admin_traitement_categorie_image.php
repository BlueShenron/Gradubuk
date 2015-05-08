<?php
require_once('mysql_fonctions_categorie_image.php'); 
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form categorie_image]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_categorie_image']) || isset($_GET['submit_categorie_image']) ){
	if($_POST['submit_categorie_image']=="ajouter"){
		if(trim($_POST['categorie_image_name']) == ""){
			header("Location:  administration.php?categorie_image=add&page=1&order=categorie_image_date_modif&record=nok");
		}
		else if(trim($_POST['categorie_image_name']) != ""){
			mysqlInsertCategorieImage($_POST['categorie_image_name']);
			header("Location:  administration.php?categorie_image=gestion&page=1&order=categorie_image_date_modif&record=ok");
		}
	}
	else if($_GET['submit_categorie_image']=="delete"){
		mysqlDeleteCategorieImageByID($_GET['id_categorie_image']);
		header("Location:  administration.php?categorie_image=gestion&page=1&order=categorie_image_date_modif&record=ok");
	}
	else if($_POST['submit_categorie_image']=="ajouter une catégorie"){
		header("Location:  administration.php?categorie_image=add");
	}
	else if ($_POST['submit_categorie_image'] =="sauvegarder"){

			$result = mysqlSelectCategorieImageByID($_GET['id_categorie_image']);
			$data = mysql_fetch_array($result);
			//insertCategorieImage($_POST['categorie_image_name'], $image_name);
			
			if(trim($_POST['categorie_image_name']) == "" ){
			header("Location:  administration.php?categorie_image=edit&id_categorie_image=".$_GET['id_categorie_image']."&record=nok");
			}
			else{
			mysqlUpdateCategorieImage($_POST['categorie_image_name'], $_GET['id_categorie_image']);
			header("Location:  administration.php?categorie_image=gestion&page=1&order=categorie_image_date_modif&record=ok");
			}
		
	}
	
}

}
else{
	header("Location:  ../index.php");
}


?>