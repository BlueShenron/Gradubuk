<?php
require_once('mysql_fonctions_article.php'); 
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

if (isset($_POST['submit_article']) || isset($_GET['submit_article']) ){
	if($_POST['submit_article']=="créer un article"){
		
		header("Location:  administration.php?article=add");
	}
	if($_POST['submit_article']=="créer article"){
		$id = mysqlInsertArticle($_POST['titre'],$_POST['corps_article'],$_POST['date_publication']);
		foreach($_POST['article_liste_image'] as $value){
			mysqlInsertArticleImage($id, $value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)],$_POST['alt_'.deleteALLCaracteresSpeciaux($value)]);
		}
		foreach($_POST['article_liste_video'] as $value){
			//echo '>>>'.$id.'>>>'.$value;
			 mysqlInsertArticleVideo($id,$value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)]);
		}
		if($_POST['image_illustration']){
			mysqlInsertArticleIllustration($id,$_POST['image_illustration'],$_POST['titre_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])],$_POST['alt_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])]);

		}
		foreach($_POST['liste_categorie_news'] as $value){
			 mysqlInsertArticleSousCategorieArticle($id,$value);
		}
		foreach($_POST['liste_plateforme_article'] as $value){
			 mysqlInsertArticlePlateforme($id,$value);
		}
		foreach($_POST['liste_constructeur_article'] as $value){
			 mysqlInsertArticleConstructeur($id,$value);
		}
		foreach($_POST['liste_developpeur_article'] as $value){
			 mysqlInsertArticleDeveloppeur($id,$value);
		}
		foreach($_POST['liste_editeur_article'] as $value){
			 mysqlInsertArticleEditeur($id,$value);
		}
		foreach($_POST['liste_jeu_version_plateforme_article'] as $value){
			 mysqlInsertArticleJeuVersionPlateforme($id,$value);
		}
		
		
		$data = getimagesize('../'.$_POST['image_illustration']);
		$width = $data[0];
		$height = $data[1];
		//echo ">>>> ".$width/$height;
		
		if(round($width/$height, 2) != 1.78 && $_POST['image_illustration']){
			$_SESSION['url_fichier'] =  $_POST['image_illustration'];
			$_SESSION['id_article'] =  $id;
			$_SESSION['titre'] = $_POST['titre'];
			header("Location:  article_illustration_crop.php");
		}
		else{
			header("Location:  administration.php?article=gestion&page=1&order=article_date_modif");
		}
		//header("Location:  administration.php?article=gestion&page=1&order=article_date_modif");
	}
	if($_POST['submit_article']=="sauvegarder"){
		
		mysqlUpdateArticle($_GET['id_article'], $_POST['titre'],$_POST['corps_article'],$_POST['date_publication']);
	
		$result = mysqlSelectArticleByID($_GET['id_article']);
		$data = mysql_fetch_array($result);
		mysqlUpdateFrontpagePublicationDate($_GET['id_article'],$data['article_date_publication_non_formate']);
		
		mysqlDeleteArticleImage($_GET['id_article']);
		mysqlDeleteArticleVideo($_GET['id_article']);
		mysqlDeleteArticleIllustration($_GET['id_article']);
		mysqlDeleteArticleSousCategorieArticle($_GET['id_article']);
		mysqlDeleteArticlePlateforme($_GET['id_article']);
		mysqlDeleteArticleConstructeur($_GET['id_article']);
		mysqlDeleteArticleDeveloppeur($_GET['id_article']);
		mysqlDeleteArticleEditeur($_GET['id_article']);

		mysqlDeleteArticleJeuVersionPlateforme($_GET['id_article']);
		
		
		foreach($_POST['article_liste_image'] as $value){
			//echo $value;
			//echo $_POST['titre_'.deleteALLCaracteresSpeciaux($value)];
			 mysqlInsertArticleImage($_GET['id_article'], $value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)],$_POST['alt_'.deleteALLCaracteresSpeciaux($value)]);
		}
		foreach($_POST['article_liste_video'] as $value){
			 mysqlInsertArticleVideo($_GET['id_article'],$value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)]);
		}
		if($_POST['image_illustration']){
			mysqlInsertArticleIllustration($_GET['id_article'],$_POST['image_illustration'],$_POST['titre_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])],$_POST['alt_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])]);
			mysqlUpdateFrontpageImageUrl($_GET['id_article'],$_POST['image_illustration']);
		}
		foreach($_POST['liste_categorie_news'] as $value){
			 mysqlInsertArticleSousCategorieArticle($_GET['id_article'],$value);
		}
		foreach($_POST['liste_plateforme_article'] as $value){
			 mysqlInsertArticlePlateforme($_GET['id_article'],$value);
		}
		foreach($_POST['liste_constructeur_article'] as $value){
			 mysqlInsertArticleConstructeur($_GET['id_article'],$value);
		}
		foreach($_POST['liste_developpeur_article'] as $value){
			 mysqlInsertArticleDeveloppeur($_GET['id_article'],$value);
		}
		foreach($_POST['liste_editeur_article'] as $value){
			 mysqlInsertArticleEditeur($_GET['id_article'],$value);
		}
		foreach($_POST['liste_jeu_version_plateforme_article'] as $value){
			 mysqlInsertArticleJeuVersionPlateforme($_GET['id_article'],$value);
		}
		
		
		$data = getimagesize('../'.$_POST['image_illustration']);
		$width = $data[0];
		$height = $data[1];
		//echo ">>>> ".$width/$height;
		
		if(round($width/$height, 2) != 1.78 && $_POST['image_illustration']){
		//echo ">>>> ".round($width/$height, 2);
			$_SESSION['url_fichier'] =  $_POST['image_illustration'];
			$_SESSION['id_article'] =  $_GET['id_article'];
			$_SESSION['titre'] = $_POST['titre'];
			header("Location:  article_illustration_crop.php");
		}
		else{
			header("Location:  administration.php?article=gestion&page=1&order=article_date_modif");
		}
		//header("Location:  administration.php?article=gestion&page=1&order=article_date_modif");
		
		
		//header("Location:  administration.php?article=gestion&page=1&order=article_date_modif&record=ok");

	}
	else if($_GET['submit_article']=="delete"){
	
		$resultFrontpage = mysqlSelectFrontpage($_GET['id_article']);
		$dataFrontpage=mysql_fetch_array($resultFrontpage);
		//echo '>>>'.$dataFrontpage['frontpage_image_nom'];
		//unlink (dossier_frontpages()."/".trim($dataFrontpage['frontpage_image_nom']));
		mysqlDeleteFrontpage($dataFrontpage['id_frontpage']);
		
		
		$resultArticlePhoto = mysqlSelectAllArticlePhoto($_GET['id_article']);
		while($dataArticlePhoto=mysql_fetch_array($resultArticlePhoto)){
			unlink (dossier_articles()."/".trim($dataArticlePhoto['article_photo_nom']));
			
			
		}
		
		mysqlDeleteArticle($_GET['id_article']);
		mysqlDeleteArticleImageOrpheline();
		mysqlDeleteArticleVideoOrpheline();
		mysqlDeleteArticleIllustrationOrpheline();
		mysqlDeleteArticleSousCategorieArticleOrpheline();
		mysqlDeleteArticlePlateformeOrpheline();
		mysqlDeleteArticleConstructeurOrpheline();
		mysqlDeleteArticleDeveloppeurOrpheline();
		mysqlDeleteArticleEditeurOrpheline();
		mysqlDeleteArticleJeuVersionPlateformeOrpheline();
		mysqlDeleteArticlePhotoOrpheline();
		header("Location:  administration.php?article=gestion&page=1&order=article_date_modif&record=ok");

	}
	
	else if($_GET['submit_article']=="publish"){
		mysqlUpdateDatePublicationArticle($_GET['id_article']);
		
		$result = mysqlSelectArticleByID($_GET['id_article']);
		$data = mysql_fetch_array($result);
		mysqlUpdateFrontpagePublicationDate($_GET['id_article'],$data['article_date_publication_non_formate']);
		header("Location:  administration.php?article=gestion&page=1&order=article_date_modif&record=ok");

	}
	else if($_POST['submit_article']=="ok"){
			if(trim($_POST['categorie_news_search'])!=""){
				header("Location:  administration.php?article=gestion&id_sous_categorie_news=".trim($_POST['categorie_news_search'])."&page=1&order=article_date_modif#resultat_recherche");
			}
			else{
				header("Location:  administration.php?article=gestion&page=1&order=article_date_modif");
			}
	}


}

}
else{
	header("Location:  ../index.php");
}

function deleteALLCaracteresSpeciaux($chaine)
{    
    
    $accents = Array("/é/", "/è/", "/ê/","/ë/", "/ç/", "/à/", "/â/","/á/","/ä/","/ã/","/å/", "/î/", "/ï/", "/í/", "/ì/", "/ù/", "/ô/", "/ò/", "/ó/", "/ö/");
    $sans = Array("e", "e", "e", "e", "c", "a", "a","a", "a","a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
    
    $chaine = preg_replace($accents, $sans,$chaine);  
    $chaine = preg_replace('#[^A-Za-z0-9]#','_',$chaine);
	   
    return $chaine; 
}
?>