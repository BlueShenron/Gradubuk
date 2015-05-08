<?php
require_once('mysql_fonctions_astuce.php'); 
require_once('authentification.php');
require_once('dossiers_ressources.php');

session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form membre]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

	if (isset($_POST['submit_astuce']) || isset($_GET['submit_astuce']) ){
		if($_POST['submit_astuce']=="créer une astuce"){
			header("Location:  administration.php?astuce=add&id_jeu_version_plateforme=".$_POST['id_jeu']."");
		}
		else if($_POST['submit_astuce']=="créer"){
			if(trim($_POST['titre'])!="" && trim($_POST['astuce'])!=""){
			mysqlInsertAstuce($_GET['id_jeu_version_plateforme'],$_POST['titre'],$_POST['astuce'],$_POST['date_publication']);
			header("Location:  administration.php?astuce=gestion&page=1&order=astuce_date_modif&record=ok#resultat_recherche");
			}
			else{
			header("Location:  administration.php?astuce=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=nok");

			}
		}
		else if($_GET['submit_astuce']=="delete"){
			
			mysqlDeleteAstuce($_GET['id_astuce']);
			if(isset($_GET['id_jeu_version_plateforme'])){
				header("Location:  administration.php?astuce=gestion&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&page=1&order=".$_GET['order']."&record=ok#resultat_recherche");
			}
			else if(isset($_GET['jeu_nom_generique'])){
				header("Location:  administration.php?astuce=gestion&jeu_nom_generique=".$_GET['jeu_nom_generique']."&page=1&order=".$_GET['order']."&record=ok#resultat_recherche");
			}
			else{
				header("Location:  administration.php?astuce=gestion&page=1&order=".$_GET['order']."&record=ok#resultat_recherche");
			}
		}
		else if($_POST['submit_astuce']=="sauvegarder"){
			if(trim($_POST['titre'])!="" && trim($_POST['astuce'])!=""){
			mysqlUpdateAstuce($_GET['id_astuce'],$_POST['titre'],$_POST['astuce'],$_POST['date_publication']);
			header("Location:  administration.php?astuce=gestion&page=1&order=astuce_date_modif&record=ok#resultat_recherche");
			}
			else{
			header("Location:  administration.php?astuce=edit&id_astuce=".$_GET['id_astuce']."&record=nok#resultat_recherche");

			}
		}
		else if($_GET['submit_astuce']=="publish"){
			mysqlUpdateAstucePublishDate($_GET['id_astuce']);
			if(isset($_GET['id_jeu_version_plateforme'])){
				header("Location:  administration.php?astuce=gestion&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&page=1&order=".$_GET['order']."&record=ok#resultat_recherche");
			}
			else if(isset($_GET['jeu_nom_generique'])){
				header("Location:  administration.php?astuce=gestion&jeu_nom_generique=".$_GET['jeu_nom_generique']."&page=1&order=".$_GET['order']."&record=ok#resultat_recherche");
			}
			else{
				header("Location:  administration.php?astuce=gestion&page=1&order=".$_GET['order']."&record=ok#resultat_recherche");
			}
		}
		else if($_POST['submit_astuce']=="ok"){
			if(trim($_POST['id_jeu_search'])!=""){
				header("Location:  administration.php?astuce=gestion&id_jeu_version_plateforme=".trim($_POST['id_jeu_search'])."&page=1&order=astuce_date_modif#resultat_recherche");
			}
			else{
				header("Location:  administration.php?astuce=gestion&page=1&order=astuce_date_modif");
			}
		}
		else if($_POST['submit_astuce']=="rechercher"){
			
			if(trim($_POST['jeu_name_search'])!=""){
				header("Location:  administration.php?astuce=gestion&jeu_nom_generique=".trim($_POST['jeu_name_search'])."&page=1&order=astuce_date_modif#resultat_recherche");
			}
			else{
				header("Location:  administration.php?astuce=gestion&page=1&order=astuce_date_modif");
			}
		}
		
	}
}
else{
	header("Location:  ../index.php");
}


?>