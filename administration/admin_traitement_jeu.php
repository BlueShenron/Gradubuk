<?php

require_once('mysql_fonctions_jeu.php'); 
require_once('dossiers_ressources.php');
require_once('authentification.php');
session_start();

//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------[test submit form jeu]-------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_jeu']) || isset($_GET['submit_jeu'])|| isset($_POST['submit_plateforme'])){
	if($_POST['submit_jeu']=="ajouter"){
		if(trim($_POST['jeu_nom_generique']) == ""){
			header("Location:  administration.php?jeu=add&page=1&order=jeu_date_modif&record=nok");
		}
		else{
		
			$jeu_dossier = trim(deleteTousCaracteresSpeciaux($_POST['jeu_nom_generique']).'_'.time());
			mkdir(dossier_jeux()."/".$jeu_dossier);
			mkdir(dossier_jeux()."/".$jeu_dossier."/covers");
			mkdir(dossier_jeux()."/".$jeu_dossier."/jaquettes");
			mkdir(dossier_jeux()."/".$jeu_dossier."/pictures");
			//---------------------//
			if(trim($_POST['developpeur_name']) != ""){
				$result = mysqlSelectDeveloppeurIDByName(trim($_POST['developpeur_name']));
				$data = mysql_fetch_array($result);
				//le develeoppeur n'existe pas encore en BDD alors il faut d'abord l'enregistrer
				if((mysql_num_rows($result) == 0) && trim($_POST['developpeur_name']) != ""){
					$id_dev = mysqlInsertDeveloppeur(trim($_POST['developpeur_name']));
					//mysqlInsertDeveloppeurImage($id_dev,'');
				}
				//le developpeur existe en BDD
				else{
					$id_dev = $data['id_developpeur'];
				}
				//mysqlInsertJeu($id_developpeur, $id_genre, $jeu_name, $jeu_descriptif, $id_nb_joueurs_offline, $online, $id_nb_joueurs_online)
				$id = mysqlInsertJeu($id_dev ,$_POST['id_genre'],trim($_POST['jeu_nom_generique']),trim($_POST['jeu_descriptif']), $_POST['id_nombre_joueur_offline'],$_POST['id_nombre_joueur_online'],$jeu_dossier);
				header("Location:  administration.php?jeu=gestion&page=1&order=jeu_date_modif&record=ok#resultat_recherche");
			}
			else{
				$id = mysqlInsertJeu(NULL ,$_POST['id_genre'],trim($_POST['jeu_nom_generique']),trim($_POST['jeu_descriptif']), $_POST['id_nombre_joueur_offline'],$_POST['id_nombre_joueur_online'],$jeu_dossier);
				header("Location:  administration.php?jeu=gestion&page=1&order=jeu_date_modif&record=ok#resultat_recherche");
			}
			//---------------------//
		}
	}
	else if($_GET['submit_jeu']=="delete"){
		
		$result = mysqlSelectJeuByID($_GET['id_jeu']);
		$data = mysql_fetch_array($result);
		if($data['jeu_dossier']){
		rrmdir(dossier_jeux()."/".$data['jeu_dossier']);
		}
		mysqlDeleteJeu($_GET['id_jeu']);
		mysqlDeleteJeuVersionPlateformeOrpheline();
		mysqlDeleteJeuVersionPlateformeImageOrpheline();
		mysqlDeleteJeuVersionPlateformeVideoOrpheline();
		mysqlDeleteJeuVersionRegionOrpheline();
		mysqlDeletePegiOrpheline();
		mysqlDeleteEsrbOrpheline();
		mysqlDeleteCeroOrpheline();
		header("Location:  administration.php?jeu=gestion&page=1&order=".$_GET['order']."&record=ok#resultat_recherche");
	}
	else if($_POST['submit_jeu']=="sauvegarder"){
		if(trim($_POST['jeu_nom_generique']) == ""){
			header("Location:  administration.php?jeu=edit&id_jeu=".$_GET["id_jeu"]."&record=nok");
		}
		else{
			$result = mysqlSelectDeveloppeurIDByName(trim($_POST['developpeur_name']));
			$data = mysql_fetch_array($result);
			//le develeoppeur n'existe pas encore en BDD alors il faut d'abord l'enregistrer
			if((mysql_num_rows($result) == 0) && trim($_POST['developpeur_name']) != ""){
				$id_dev = mysqlInsertDeveloppeur(trim($_POST['developpeur_name']));
				//mysqlInsertDeveloppeurImage($id_dev,'');
			}
			//le developpeur existe en BDD
			else{
				$id_dev = $data['id_developpeur'];
			}
				
			mysqlUpdateJeu($_GET["id_jeu"], $id_dev,$_POST['id_genre'],$_POST['jeu_nom_generique'],$_POST['jeu_descriptif'],$_POST['id_nombre_joueur_offline'],$_POST['id_nombre_joueur_online']);
			header("Location:  administration.php?jeu=gestion&page=1&order=jeu_date_modif&record=ok#resultat_recherche");
		}
	}
	else if($_POST['submit_jeu']=="créer une fiche de jeu"){
			
		header("Location: administration.php?jeu=add");
			
	}
	else if($_POST['submit_jeu']=="ajouter version"){
			if($_POST['id_plateforme']==""){
				header("Location: administration.php?jeu=edit&id_jeu=".$_GET['id_jeu']."&record=nok#resultat_recherche");
			}
			else{
				$id_jeu_version_plateforme = mysqlInsertJeuVersionPlateforme($_GET['id_jeu'], $_POST['id_plateforme']);
				mysqlUpdateJeuDate($_GET['id_jeu']);
				header("Location: administration.php?jeu=edit&id_jeu=".$_GET['id_jeu']."&record=ok#resultat_recherche");
			}
	}
	else if($_POST['submit_jeu']=="ok"){	
		if(trim($_POST["id_jeu"]) != ""){
			$result = mysqlSelectJeuIdByJeuVersionPlateformeID($_POST["id_jeu"]);
			$data =  mysql_fetch_array($result);
			header("Location:  administration.php?jeu=gestion&id_jeu=".trim($data["id_jeu"])."&page=1&order=jeu_date_modif#resultat_recherche");
		}
		else{
			header("Location:  administration.php?jeu=gestion&page=1&order=jeu_date_modif#resultat_recherche");

		}
		
	}
	else if($_POST['submit_plateforme']=="ok"){	
		if(trim($_POST['submit_plateforme']) != ""){
			header("Location:  administration.php?jeu=gestion&page=1&id_plateforme=".trim($_POST['plateforme_select'])."&order=jeu_date_modif#resultat_recherche");
		}
		else{
			header("Location:  administration.php?jeu=gestion&page=1&order=jeu_date_modif&record=nok");

		}
	}
	else if($_POST['submit_jeu']=="rechercher"){
		if(trim($_POST['jeu_name_search']) != ""){
			header("Location:  administration.php?jeu=gestion&page=1&jeu_nom_generique=".trim($_POST['jeu_name_search'])."&order=jeu_date_modif#resultat_recherche");
		}
		else{
			header("Location:  administration.php?jeu=gestion&page=1&order=jeu_date_modif#resultat_recherche");
		}
	}



}


}
else{
	header("Location:  ../index.php");
}


//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
function deleteTousCaracteresSpeciaux($chaine)
{    
    
    $accents = Array("/é/", "/è/", "/ê/","/ë/", "/ç/", "/à/", "/â/","/á/","/ä/","/ã/","/å/", "/î/", "/ï/", "/í/", "/ì/", "/ù/", "/ô/", "/ò/", "/ó/", "/ö/");
    $sans = Array("e", "e", "e", "e", "c", "a", "a","a", "a","a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
    
    $chaine = preg_replace($accents, $sans,$chaine);  
    $chaine = preg_replace('#[^A-Za-z0-9]#','_',$chaine);
	   
    return $chaine; 
}


 


function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
} 

?>