<?php
require_once('mysql_fonctions_categorie_news.php'); 
require_once('authentification.php');
require_once('dossiers_ressources.php');

session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form categorie_news]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_categorie_news']) || isset($_GET['submit_categorie_news']) ){
	if($_POST['submit_categorie_news']=="ajouter"){
		if(trim($_POST['categorie_news_name']) == ""){
			header("Location:  administration.php?categorie_news=add&page=1&order=categorie_news_date_modif&record=nok");
		}
		else if(trim($_POST['categorie_news_name']) != ""){
			mysqlInsertCategorieNews($_POST['categorie_news_name']);
			header("Location:  administration.php?categorie_news=gestion&page=1&order=categorie_news_date_modif&record=ok");
		}
	}
	else if($_POST['submit_categorie_news']=="ajouter une catégorie"){
	
		header("Location:  administration.php?categorie_news=add");
	}
	else if($_GET['submit_categorie_news']=="delete"){
		$resultSousCategorie = mysqlSelectSousCategorie($_GET['id_categorie_news']);
		
		while($dataSousCategorie = mysql_fetch_array($resultSousCategorie)){
			if($dataSousCategorie['sous_categorie_news_logo']!="nopicture.jpg"){
				unlink (dossier_categories_news()."/".htmlspecialchars(trim($dataSousCategorie["sous_categorie_news_logo"])));
			}
			mysqlDeleteSousCategorieNewsByID($dataSousCategorie['id_sous_categorie_news']);
		}
		mysqlDeleteCategorieNewsByID($_GET['id_categorie_news']);
		mysqlDeleteNewsSousCategorieNewsSousCategorieNewsOrpheline();
		header("Location:  administration.php?categorie_news=gestion&page=1&order=categorie_news_date_modif&record=ok");
	}
	else if ($_POST['submit_categorie_news'] =="sauvegarder"){

			$result = mysqlSelectCategorieNewsByID($_GET['id_categorie_news']);
			$data = mysql_fetch_array($result);
			//insertCategorieNews($_POST['categorie_news_name'], $image_name);
			
			if(trim($_POST['categorie_news_name']) == "" ){
			header("Location:  administration.php?categorie_news=edit&id_categorie_news=".$_GET['id_categorie_news']."&categorie_news_edit=nok");
			}
			else{
			mysqlUpdateCategorieNews($_POST['categorie_news_name'], $_GET['id_categorie_news']);
			header("Location:  administration.php?categorie_news=gestion&page=1&order=categorie_news_date_modif&record=ok");
			}
		
	}
	
}

}
else{
	header("Location:  ../index.php");
}


?>