<?php
require_once('mysql_fonctions_test.php'); 
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

if (isset($_POST['submit_test']) || isset($_GET['submit_test']) ){
	if($_POST['submit_test']=="créer un test"){
	
		
		header("Location:  administration.php?test=add&id_jeu_version_plateforme=".$_POST['id_jeu']."");
	}
	else if($_POST['submit_test']=="créer le test"){

		$id = mysqlInsertTest($_POST['jeu_version_plateforme_test'],$_POST['date_publication']);
		
		foreach($_POST['liste_jeu_version_plateforme'] as $value){
		$id_test_jeu_version_plateforme = mysqlInsertTestJeuVersionPlateforme($id,$value,$_POST['titre'],$_POST['corps_test'],$_POST['note'],$_POST['plus'],$_POST['moins']);
				//echo '>>>  '.$id_test_jeu_version_plateforme.' <<<';
				foreach($_POST['test_jeu_version_plateforme_liste_image'] as $value){
					//echo '>>>'.$id_test_jeu_version_plateforme.'>>>'.$value;
					mysqlInsertTestJeuVersionPlateformeImage($id_test_jeu_version_plateforme, $value,$_POST['titre'],$_POST['titre']);
				}
				foreach($_POST['test_jeu_version_plateforme_liste_video'] as $value){
					//echo '>>>'.$id_test_jeu_version_plateforme.'>>>'.$value;
				 	mysqlInsertTestJeuVersionPlateformeVideo($id_test_jeu_version_plateforme,$value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)]);
				}
				if($_POST['image_illustration']){
					mysqlInsertTestJeuVersionPlateformeIllustration($id_test_jeu_version_plateforme,$_POST['image_illustration'],$_POST['titre'],$_POST['titre']);
				}
		}
		
		
		$data = getimagesize('../'.$_POST['image_illustration']);
		$width = $data[0];
		$height = $data[1];
		//echo ">>>> ".$width/$height;
		
		if(round($width/$height, 2) != 1.78 && $_POST['image_illustration']){
			$_SESSION['url_fichier'] =  $_POST['image_illustration'];
			$_SESSION['id_test'] =  $id;
			$_SESSION['titre'] = $_POST['titre'];
			header("Location:  test_illustration_crop.php");
		}
		else{
			header("Location:  administration.php?test=gestion&page=1&order=test_date_modif");
		}
		
		
		//header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");
	}
	else if($_POST['submit_test']=="écraser toutes les versions"){
		
		mysqlUpdateTest($_GET['id_test'],$_POST['date_publication'],$_POST['jeu_version_plateforme_test']);
		
		mysqlDeleteTestJeuVersionPlateformeByTest($_GET['id_test']);
		
		/*foreach($_POST['liste_jeu_version_plateforme'] as $value){
		mysqlInsertTestJeuVersionPlateforme($_GET['id_test'],$value,$_POST['titre'],$_POST['corps_test'],$_POST['note'],$_POST['plus'],$_POST['moins']);
		}
		
		header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");*/
		
		
		foreach($_POST['liste_jeu_version_plateforme'] as $value){
		$id_test_jeu_version_plateforme = mysqlInsertTestJeuVersionPlateforme($_GET['id_test'],$value,$_POST['titre'],$_POST['corps_test'],$_POST['note'],$_POST['plus'],$_POST['moins']);
				//echo '>>>  '.$id_test_jeu_version_plateforme.' <<<';
				foreach($_POST['test_jeu_version_plateforme_liste_image'] as $value){
					//echo '>>>'.$id_test_jeu_version_plateforme.'>>>'.$value;
					mysqlInsertTestJeuVersionPlateformeImage($id_test_jeu_version_plateforme, $value,$_POST['titre'],$_POST['titre']);
				}
				foreach($_POST['test_jeu_version_plateforme_liste_video'] as $value){
					//echo '>>>'.$id_test_jeu_version_plateforme.'>>>'.$value;
				 	mysqlInsertTestJeuVersionPlateformeVideo($id_test_jeu_version_plateforme,$value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)]);
				}
				if($_POST['image_illustration']){
					mysqlInsertTestJeuVersionPlateformeIllustration($id_test_jeu_version_plateforme,$_POST['image_illustration'],$_POST['titre'],$_POST['titre']);
				}
				mysqlDeleteTestJeuVersionPlateformePhoto($id_test_jeu_version_plateforme);
				mysqlInsertTestJeuVersionPlateformePhoto($id_test_jeu_version_plateforme,recupNomFichier($_POST['image_illustration']),$_POST['titre'],$_POST['titre']);
		}
		
		
		$data = getimagesize('../'.$_POST['image_illustration']);
		$width = $data[0];
		$height = $data[1];
		//echo ">>>> ".$width/$height;
		
		if(round($width/$height, 2) != 1.78 && $_POST['image_illustration']){
			$_SESSION['url_fichier'] =  $_POST['image_illustration'];
			$_SESSION['id_test'] =  $_GET['id_test'];
			$_SESSION['titre'] = $_POST['titre'];
			header("Location:  test_illustration_crop.php");
		}
		else{
			
			
			
			header("Location:  administration.php?test=gestion&page=1&order=test_date_modif");
		}
		
	}
	else if($_POST['submit_test']=="sauvegarder"  && isset($_GET['id_test'])){
		$result = mysqlSelectTestJeuVersionPlateforme($_GET['id_test']);
		$data = mysql_fetch_array($result);
		
		foreach($_POST['liste_jeu_version_plateforme'] as $value){
		mysqlInsertTestJeuVersionPlateforme($_GET['id_test'],$value,$data['test_titre'],$data['test_corps'],$data['test_note'],$data['test_plus'],$data['test_moins']);
		}
		mysqlUpdateTest($_GET['id_test'],$_POST['date_publication'],$_POST['jeu_version_plateforme_test']);
		header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");

	}
	else if($_POST['submit_test']=="sauvegarder" && isset($_GET['id_test_jeu_version_plateforme'])){
		
		mysqlUpdateTestJeuVersionPlateformeByTest($_GET['id_test_jeu_version_plateforme'],$_POST['titre'],$_POST['corps_test'],$_POST['note'],$_POST['plus'],$_POST['moins']);
		
		mysqlDeleteTestJeuVersionPlateformeImage($_GET['id_test_jeu_version_plateforme']);
		mysqlDeleteTestJeuVersionPlateformeVideo($_GET['id_test_jeu_version_plateforme']);
		mysqlDeleteTestJeuVersionPlateformeIllustration($_GET['id_test_jeu_version_plateforme']);
		
		foreach($_POST['test_jeu_version_plateforme_liste_image'] as $value){
					//echo '>>>'.$id_test_jeu_version_plateforme.'>>>'.$value;
					mysqlInsertTestJeuVersionPlateformeImage($_GET['id_test_jeu_version_plateforme'], $value,$_POST['titre'],$_POST['titre']);
		}
		foreach($_POST['test_jeu_version_plateforme_liste_video'] as $value){
					//echo '>>>'.$id_test_jeu_version_plateforme.'>>>'.$value;
				 	mysqlInsertTestJeuVersionPlateformeVideo($_GET['id_test_jeu_version_plateforme'],$value,$_POST['titre_'.deleteALLCaracteresSpeciaux($value)]);
		}
		if($_POST['image_illustration']){
				mysqlInsertTestJeuVersionPlateformeIllustration($_GET['id_test_jeu_version_plateforme'],$_POST['image_illustration'],$_POST['titre'],$_POST['titre']);
		}
		mysqlDeleteTestJeuVersionPlateformePhoto($_GET['id_test_jeu_version_plateforme']);
		mysqlInsertTestJeuVersionPlateformePhoto($_GET['id_test_jeu_version_plateforme'],recupNomFichier($_POST['image_illustration']),$_POST['titre'],$_POST['titre']);
		
		
		$result = mysqlSelectTestJeuVersionPlateformeByID($_GET['id_test_jeu_version_plateforme']);
		$data = mysql_fetch_array($result);
		mysqlUpdateTestDate($data['id_test']);
		//header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");
		
		
		$data = getimagesize('../'.$_POST['image_illustration']);
		$width = $data[0];
		$height = $data[1];
		//echo ">>>> ".$width/$height;
		
		if(round($width/$height, 2) != 1.78 && $_POST['image_illustration']){
			$_SESSION['url_fichier'] =  $_POST['image_illustration'];
			$_SESSION['id_test_jeu_version_plateforme'] =  $_GET['id_test_jeu_version_plateforme'];
			$_SESSION['titre'] = $_POST['titre'];
			header("Location:  test_illustration_crop.php");
		}
		else{

			header("Location:  administration.php?test=gestion&page=1&order=test_date_modif");
		}

	}
	else if($_GET['submit_test']=="delete"){
		
		$resultFrontpage = mysqlSelectFrontpage($_GET['id_test']);
		$dataFrontpage=mysql_fetch_array($resultFrontpage);
		//echo '>>>'.$dataFrontpage['frontpage_image_nom'];
		unlink (dossier_frontpages()."/".trim($dataFrontpage['frontpage_image_nom']));
		mysqlDeleteFrontpage($dataFrontpage['id_frontpage']);
		
		mysqlDeleteTestJeuVersionPlateformeByTest($_GET['id_test']);
		
		mysqlDeleteTest($_GET['id_test']);
		
		
		header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");

	}
	else if($_GET['submit_test']=="publish"){	
		mysqlUpdateDatePublicationTest($_GET['id_test']);
		
		$result = mysqlSelectTestByID($_GET['id_test']);
		$data = mysql_fetch_array($result);
		mysqlUpdateFrontpagePublicationDate($_GET['id_test'],$data['test_date_publication_non_formate']);
		
		header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok#resultat_recherche");
	}
	else if($_POST['submit_test']=="ok"){
			if(trim($_POST['id_jeu_search'])!=""){
				header("Location:  administration.php?test=gestion&id_jeu_version_plateforme=".trim($_POST['id_jeu_search'])."&page=1&order=test_date_modif#resultat_recherche");
			}
			else{
				header("Location:  administration.php?test=gestion&page=1&order=test_date_modif#resultat_recherche");
			}
		}
	else if($_POST['submit_test']=="rechercher"){
			
			if(trim($_POST['jeu_name_search'])!=""){
				header("Location:  administration.php?test=gestion&jeu_nom_generique=".trim($_POST['jeu_name_search'])."&page=1&order=test_date_modif#resultat_recherche");
			}
			else{
				header("Location:  administration.php?test=gestion&page=1&order=test_date_modif#resultat_recherche");
			}
	}

}
else if (isset($_POST['submit_test_jeu_version_plateforme']) || isset($_GET['submit_test_jeu_version_plateforme']) ){
	mysqlDeleteTestJeuVersionPlateforme($_GET['id_test_jeu_version_plateforme']);
	header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok#resultat_recherche");
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
function recupNomFichier($elements_url){
$elements_url = explode('/', $elements_url);

// On compte le nombre d'entrées:
$nombre_elements = count($elements_url);

// On récupère le nom du membre:
$nomfichier = $elements_url[$nombre_elements-1];

// On affiche le nom du membre:
return $nomfichier;
}

?>