<?php
require_once('mysql_fonctions_nombre_joueur.php'); 
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form nombre_joueur]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_nombre_joueur']) || isset($_GET['submit_nombre_joueur']) ){
	if($_POST['submit_nombre_joueur']=="ajouter"){
		if(trim($_POST['nombre_joueur_name']) == ""){
			header("Location:  administration.php?nombre_joueur=add&page=1&order=nombre_joueur_date_modif&record=nok");
		}
		else if(trim($_POST['nombre_joueur_name']) != ""){
			mysqlInsertNombreJoueur($_POST['nombre_joueur_name']);
			header("Location:  administration.php?nombre_joueur=gestion&page=1&order=nombre_joueur_date_modif&record=ok");
		}
	}
	else if($_GET['submit_nombre_joueur']=="delete"){
		mysqlDeleteNombreJoueurByID($_GET['id_nombre_joueur']);
		header("Location:  administration.php?nombre_joueur=gestion&page=1&order=nombre_joueur_date_modif&record=ok");
	}
	else if($_POST['submit_nombre_joueur']=="ajouter un nombre de joueur"){
		header("Location:  administration.php?nombre_joueur=add");
	}
	else if ($_POST['submit_nombre_joueur'] =="sauvegarder"){

			$result = mysqlSelectNombreJoueurByID($_GET['id_nombre_joueur']);
			$data = mysql_fetch_array($result);
			//insertNombreJoueur($_POST['nombre_joueur_name'], $image_name);
			
			if(trim($_POST['nombre_joueur_name']) == "" ){
			header("Location:  administration.php?nombre_joueur=edit&id_nombre_joueur=".$_GET['id_nombre_joueur']."&record=nok");
			}
			else{
			mysqlUpdateNombreJoueur($_POST['nombre_joueur_name'], $_GET['id_nombre_joueur']);
			header("Location:  administration.php?nombre_joueur=gestion&page=1&order=nombre_joueur_date_modif&record=ok");
			}
		
	}
	
}

}
else{
	header("Location:  ../index.php");
}


?>