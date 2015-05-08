<?php
require_once('mysql_fonctions_genre.php'); 
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form genre]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_genre']) || isset($_GET['submit_genre']) ){
	if($_POST['submit_genre']=="ajouter"){
		if(trim($_POST['genre_name']) == ""){
			header("Location:  administration.php?genre=add&page=1&order=genre_date_modif&record=nok");
		}
		else if(trim($_POST['genre_name']) != ""){
			mysqlInsertGenre($_POST['genre_name']);
			header("Location:  administration.php?genre=gestion&page=1&order=genre_date_modif&record=ok");
		}
	}
	else if($_GET['submit_genre']=="delete"){
		mysqlDeleteGenreByID($_GET['id_genre']);
		header("Location:  administration.php?genre=gestion&page=1&order=genre_date_modif&record=ok");
	}
	else if($_POST['submit_genre']=="ajouter un genre"){
		header("Location:  administration.php?genre=add");
	}
	else if ($_POST['submit_genre'] =="sauvegarder"){

			$result = mysqlSelectGenreByID($_GET['id_genre']);
			$data = mysql_fetch_array($result);
			//insertGenre($_POST['genre_name'], $image_name);
			
			if(trim($_POST['genre_name']) == "" ){
			header("Location:  administration.php?genre=edit&id_genre=".$_GET['id_genre']."&record=nok");
			}
			else{
			mysqlUpdateGenre($_POST['genre_name'], $_GET['id_genre']);
			header("Location:  administration.php?genre=gestion&page=1&order=genre_date_modif&record=ok");
			}
		
	}
	
}

}
else{
	header("Location:  ../index.php");
}


?>