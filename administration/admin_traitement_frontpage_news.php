<?php
require_once('mysql_fonctions_frontpage_news.php'); 
require_once('authentification.php');

require_once('images_functions.php'); 
require_once('dossiers_ressources.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form membre]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_frontpage']) || isset($_GET['submit_frontpage']) ){
	if($_POST['submit_frontpage']=="créer"){
		if(trim($_POST['frontpage_titre']) == ""  || trim($_POST['frontpage_sous_titre']) == "" ){
			//echo '>>'.trim($_POST['frontpage_titre']).'<<>>'.trim($_POST['frontpage_sous_titre']).'<<';
			header("Location:  administration.php?frontpage_news=add&id_news=".$_GET['id_news']."&record=nok");
		}
		else if(trim($_POST['frontpage_titre']) != "" && trim($_POST['frontpage_sous_titre']) !="" ){
			$resultNews = mysqlSelectNewsByID($_GET['id_news']);
			$dataNews=mysql_fetch_array($resultNews);
			$id = mysqlInsertFrontpage($_POST['frontpage_titre'],$_POST['frontpage_sous_titre'],$_GET['id_news'],$dataNews['news_date_publication'],$dataNews['url_news_illustration']);
			mysqlUpdateNews($_GET['id_news']);
			header("Location:  administration.php?news=gestion&page=1&order=news_date_modif&record=ok");
		}
	}
	else if($_GET['submit_frontpage']=="delete"){
		mysqlDeleteFrontpage($_GET['id_frontpage']);
		mysqlUpdateNews($_GET['id_news']);
		header("Location:  administration.php?news=gestion&page=1&order=news_date_modif&record=ok");
	}
	else if($_POST['submit_frontpage']=="sauvegarder"){
		if(trim($_POST['frontpage_titre']) == ""  || trim($_POST['frontpage_sous_titre']) == ""){
			header("Location:  administration.php?frontpage_news=edit&id_news=".$_GET['id_news']."&id_frontpage=".$_GET['id_frontpage']."&record=nok");
		}
		else if(trim($_POST['frontpage_titre']) != "" && trim($_POST['frontpage_sous_titre']) != ""){
			
			$resultNews = mysqlSelectNewsByID($_GET['id_news']);
			$dataNews=mysql_fetch_array($resultNews);
			
			$id = mysqlUpdateFrontpage($_GET['id_frontpage'],$_POST['frontpage_titre'],$_POST['frontpage_sous_titre']);
			mysqlUpdateNews($_GET['id_news']);
			header("Location:  administration.php?news=gestion&page=1&order=news_date_modif&record=ok");
		}
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