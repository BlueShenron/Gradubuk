<?php
require_once('mysql_fonctions_news.php'); 
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

if (isset($_POST['submit_news']) || isset($_GET['submit_news']) ){
	if($_POST['submit_news']=="créer un news"){
		
		header("Location:  administration.php?news=add");
	}
	if($_POST['submit_news']=="créer news"){
		$id = mysqlInsertNews($_POST['titre'],$_POST['corps_news'],$_POST['date_publication']);
		foreach($_POST['news_liste_image'] as $value){
			mysqlInsertNewsImage($id, $value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)],$_POST['alt_'.deleteALLCaracteresSpeciaux($value)]);
		}
		foreach($_POST['news_liste_video'] as $value){
			//echo '>>>'.$id.'>>>'.$value;
			 mysqlInsertNewsVideo($id,$value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)]);
		}
		if($_POST['image_illustration']){
			mysqlInsertNewsIllustration($id,$_POST['image_illustration'],$_POST['titre_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])],$_POST['alt_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])]);

		}
		foreach($_POST['liste_categorie_news'] as $value){
			 mysqlInsertNewsSousCategorieNews($id,$value);
		}
		foreach($_POST['liste_plateforme_news'] as $value){
			 mysqlInsertNewsPlateforme($id,$value);
		}
		foreach($_POST['liste_constructeur_news'] as $value){
			 mysqlInsertNewsConstructeur($id,$value);
		}
		foreach($_POST['liste_developpeur_news'] as $value){
			 mysqlInsertNewsDeveloppeur($id,$value);
		}
		foreach($_POST['liste_editeur_news'] as $value){
			 mysqlInsertNewsEditeur($id,$value);
		}
		foreach($_POST['liste_jeu_version_plateforme_news'] as $value){
			 mysqlInsertNewsJeuVersionPlateforme($id,$value);
		}
		
		
		$data = getimagesize('../'.$_POST['image_illustration']);
		$width = $data[0];
		$height = $data[1];
		//echo ">>>> ".$width/$height;
		
		if(round($width/$height, 2) != 1.78 && $_POST['image_illustration']){
			$_SESSION['url_fichier'] =  $_POST['image_illustration'];
			$_SESSION['id_news'] =  $id;
			$_SESSION['titre'] = $_POST['titre'];
			header("Location:  news_illustration_crop.php");
		}
		else{
			header("Location:  administration.php?news=gestion&page=1&order=news_date_modif");
		}
		//header("Location:  administration.php?news=gestion&page=1&order=news_date_modif");
	}
	if($_POST['submit_news']=="sauvegarder"){
		
		mysqlUpdateNews($_GET['id_news'], $_POST['titre'],$_POST['corps_news'],$_POST['date_publication']);
	
		$result = mysqlSelectNewsByID($_GET['id_news']);
		$data = mysql_fetch_array($result);
		mysqlUpdateFrontpagePublicationDate($_GET['id_news'],$data['news_date_publication_non_formate']);
		
		mysqlDeleteNewsImage($_GET['id_news']);
		mysqlDeleteNewsVideo($_GET['id_news']);
		mysqlDeleteNewsIllustration($_GET['id_news']);
		mysqlDeleteNewsSousCategorieNews($_GET['id_news']);
		mysqlDeleteNewsPlateforme($_GET['id_news']);
		mysqlDeleteNewsConstructeur($_GET['id_news']);
		mysqlDeleteNewsDeveloppeur($_GET['id_news']);
		mysqlDeleteNewsEditeur($_GET['id_news']);

		mysqlDeleteNewsJeuVersionPlateforme($_GET['id_news']);
		
		
		foreach($_POST['news_liste_image'] as $value){
			//echo $value;
			//echo $_POST['titre_'.deleteALLCaracteresSpeciaux($value)];
			 mysqlInsertNewsImage($_GET['id_news'], $value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)],$_POST['alt_'.deleteALLCaracteresSpeciaux($value)]);
		}
		foreach($_POST['news_liste_video'] as $value){
			 mysqlInsertNewsVideo($_GET['id_news'],$value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)]);
		}
		if($_POST['image_illustration']){
			mysqlInsertNewsIllustration($_GET['id_news'],$_POST['image_illustration'],$_POST['titre_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])],$_POST['alt_'.deleteALLCaracteresSpeciaux($_POST['image_illustration'])]);
			mysqlUpdateFrontpageImageUrl($_GET['id_news'],$_POST['image_illustration']);
		}
		foreach($_POST['liste_categorie_news'] as $value){
			 mysqlInsertNewsSousCategorieNews($_GET['id_news'],$value);
		}
		foreach($_POST['liste_plateforme_news'] as $value){
			 mysqlInsertNewsPlateforme($_GET['id_news'],$value);
		}
		foreach($_POST['liste_constructeur_news'] as $value){
			 mysqlInsertNewsConstructeur($_GET['id_news'],$value);
		}
		foreach($_POST['liste_developpeur_news'] as $value){
			 mysqlInsertNewsDeveloppeur($_GET['id_news'],$value);
		}
		foreach($_POST['liste_editeur_news'] as $value){
			 mysqlInsertNewsEditeur($_GET['id_news'],$value);
		}
		foreach($_POST['liste_jeu_version_plateforme_news'] as $value){
			 mysqlInsertNewsJeuVersionPlateforme($_GET['id_news'],$value);
		}
		
		
		$data = getimagesize('../'.$_POST['image_illustration']);
		$width = $data[0];
		$height = $data[1];
		//echo ">>>> ".$width/$height;
		
		if(round($width/$height, 2) != 1.78 && $_POST['image_illustration']){
		//echo ">>>> ".round($width/$height, 2);
			$_SESSION['url_fichier'] =  $_POST['image_illustration'];
			$_SESSION['id_news'] =  $_GET['id_news'];
			$_SESSION['titre'] = $_POST['titre'];
			header("Location:  news_illustration_crop.php");
		}
		else{
			header("Location:  administration.php?news=gestion&page=1&order=news_date_modif");
		}
		//header("Location:  administration.php?news=gestion&page=1&order=news_date_modif");
		
		
		//header("Location:  administration.php?news=gestion&page=1&order=news_date_modif&record=ok");

	}
	else if($_GET['submit_news']=="delete"){
	
		$resultFrontpage = mysqlSelectFrontpage($_GET['id_news']);
		$dataFrontpage=mysql_fetch_array($resultFrontpage);
		//echo '>>>'.$dataFrontpage['frontpage_image_nom'];
		//unlink (dossier_frontpages()."/".trim($dataFrontpage['frontpage_image_nom']));
		mysqlDeleteFrontpage($dataFrontpage['id_frontpage']);
		
		
		$resultNewsPhoto = mysqlSelectAllNewsPhoto($_GET['id_news']);
		while($dataNewsPhoto=mysql_fetch_array($resultNewsPhoto)){
			unlink (dossier_news()."/".trim($dataNewsPhoto['news_photo_nom']));
			
			
		}
		
		mysqlDeleteNews($_GET['id_news']);
		mysqlDeleteNewsImageOrpheline();
		mysqlDeleteNewsVideoOrpheline();
		mysqlDeleteNewsIllustrationOrpheline();
		mysqlDeleteNewsSousCategorieNewsOrpheline();
		mysqlDeleteNewsPlateformeOrpheline();
		mysqlDeleteNewsConstructeurOrpheline();
		mysqlDeleteNewsDeveloppeurOrpheline();
		mysqlDeleteNewsEditeurOrpheline();
		mysqlDeleteNewsJeuVersionPlateformeOrpheline();
		mysqlDeleteNewsPhotoOrpheline();
		header("Location:  administration.php?news=gestion&page=1&order=news_date_modif&record=ok");

	}
	
	else if($_GET['submit_news']=="publish"){
		mysqlUpdateDatePublicationNews($_GET['id_news']);
		
		$result = mysqlSelectNewsByID($_GET['id_news']);
		$data = mysql_fetch_array($result);
		mysqlUpdateFrontpagePublicationDate($_GET['id_news'],$data['news_date_publication_non_formate']);
		header("Location:  administration.php?news=gestion&page=1&order=news_date_modif&record=ok");

	}
	else if($_POST['submit_news']=="ok"){
			if(trim($_POST['categorie_news_search'])!=""){
				header("Location:  administration.php?news=gestion&id_sous_categorie_news=".trim($_POST['categorie_news_search'])."&page=1&order=news_date_modif#resultat_recherche");
			}
			else{
				header("Location:  administration.php?news=gestion&page=1&order=news_date_modif");
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