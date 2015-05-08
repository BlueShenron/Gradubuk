<?php
require_once('mysql_fonctions_frontpage_article.php'); 
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
			header("Location:  administration.php?frontpage_article=add&id_article=".$_GET['id_article']."&record=nok");
		}
		else if(trim($_POST['frontpage_titre']) != "" && trim($_POST['frontpage_sous_titre']) !="" ){
			$resultArticle = mysqlSelectArticleByID($_GET['id_article']);
			$dataArticle=mysql_fetch_array($resultArticle);
			$id = mysqlInsertFrontpage($_POST['frontpage_titre'],$_POST['frontpage_sous_titre'],$_GET['id_article'],$dataArticle['article_date_publication'],$dataArticle['url_article_illustration']);
			mysqlUpdateArticle($_GET['id_article']);
			header("Location:  administration.php?article=gestion&page=1&order=article_date_modif&record=ok");
		}
	}
	else if($_GET['submit_frontpage']=="delete"){
		mysqlDeleteFrontpage($_GET['id_frontpage']);
		mysqlUpdateArticle($_GET['id_article']);
		header("Location:  administration.php?article=gestion&page=1&order=article_date_modif&record=ok");
	}
	else if($_POST['submit_frontpage']=="sauvegarder"){
		if(trim($_POST['frontpage_titre']) == ""  || trim($_POST['frontpage_sous_titre']) == ""){
			header("Location:  administration.php?frontpage_article=edit&id_article=".$_GET['id_article']."&id_frontpage=".$_GET['id_frontpage']."&record=nok");
		}
		else if(trim($_POST['frontpage_titre']) != "" && trim($_POST['frontpage_sous_titre']) != ""){
			
			$resultArticle = mysqlSelectArticleByID($_GET['id_article']);
			$dataArticle=mysql_fetch_array($resultArticle);
			
			$id = mysqlUpdateFrontpage($_GET['id_frontpage'],$_POST['frontpage_titre'],$_POST['frontpage_sous_titre']);
			mysqlUpdateArticle($_GET['id_article']);
			header("Location:  administration.php?article=gestion&page=1&order=article_date_modif&record=ok");
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