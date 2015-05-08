<?php

require_once('mysql_fonctions_jeu_version_plateforme_video.php'); 
require_once('authentification.php');
session_start();


/*----------------------------------------------------------------------------------------*/
/* -----------------------------------[fonctions video_jeu]------------------------ */
/*----------------------------------------------------------------------------------------*/
if(getGroupe()=='admin'){

if(isset($_GET['submit_video_jeu']) || isset($_POST['submit_video_jeu'])){
	if($_POST['submit_video_jeu']=="ajouter"){
				if(trim($_POST['video_url'])=="" || trim($_POST['video_titre'])==""){
				header("Location:  administration.php?jeu_version_plateforme_video=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=nok");

				}
				else{
				$result=mysqlSelectVersionsCompletesByjeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
				$data=mysql_fetch_array($result);
				$id= mysqlInsertVideoJeuVersionPlateforme($_GET['id_jeu_version_plateforme'],$_POST['video_url'], $_POST['id_categorie_video'], $_POST['video_titre']);
				header("Location:  administration.php?jeu_version_plateforme_video=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=ok");
				}		
	
	}
	else if (($_POST['submit_video_jeu']) == "supprimer la selection"){
		if($_POST['video_to_delete']){
		foreach($_POST['video_to_delete'] as $valeur)
		{
   			mysqlDeleteJeuVersionPlateformeVideoByID($valeur);
			header("Location:  administration.php?jeu_version_plateforme_video=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=ok");
		}
		}
		else{
			header("Location:  administration.php?jeu_version_plateforme_video=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=ok");
		}
	}
	else if (($_POST['submit_video_jeu']) == "sauvegarder"){
		mysqUpdateJeuVersionPlateformeVideoIdVideo($_GET['id_jeu_version_plateforme_video'], $_POST['video_titre'], $_POST['id_categorie_video']);
		header("Location:  administration.php?jeu_version_plateforme_video=edit&id_jeu_version_plateforme_video=".$_GET['id_jeu_version_plateforme_video']."&record=ok");
		
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