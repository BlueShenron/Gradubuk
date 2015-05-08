<?php
require_once('images_functions.php'); 
require_once('mysql_fonctions_plateforme.php'); 
require_once('dossiers_ressources.php');
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form plateforme]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_plateforme']) || isset($_GET['submit_plateforme']) ){
	if($_POST['submit_plateforme']=="ajouter"){
		if(trim($_POST['plateforme_name']) == ""  ||  !testFormatPlateformepicture()){
			header("Location:  administration.php?plateforme=add&page=1&order=plateforme_date_modif&record=nok");
		}
		else if(trim($_POST['plateforme_name']) != "" && testFormatPlateformepicture()){
		
			$plateforme_dossier = trim(deleteTousCaracteresSpeciaux($_POST['plateforme_name']).'_'.time());
			
			mkdir(dossier_plateformes().'/'.$plateforme_dossier);
			
			if(($_FILES["image"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
					$image_name = NULL; //si pas de fichier on assigne un fichier par default
			}
			else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
					$image_name = plateformepictureUpload($_POST['plateforme_name'],$plateforme_dossier); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
			}
			$id = mysqlInsertPlateforme($_POST['id_constructeur'],$_POST['plateforme_name'],$_POST['plateforme_descriptif'],$_POST['retro'],$plateforme_dossier,$image_name);

			header("Location:  administration.php?plateforme=gestion&page=1&order=plateforme_date_modif&record=ok");
		}
	}
	else if($_POST['submit_plateforme']=="ajouter une plateforme"){

		header("Location:  administration.php?plateforme=add");
	}
	else if($_GET['submit_plateforme']=="delete"){
	
		
		
		$result = mysqlSelectPlateformeByID($_GET['id_plateforme']);
		$data = mysql_fetch_array($result);
		//echo dossier_plateformes().'/'.$data['plateforme_dossier'];
		if($data['plateforme_image_generique
		']!="nopicture.jpg"){
		rrmdir(dossier_plateformes().'/'.$data['plateforme_dossier']);
		}
		mysqlDeletePlateformeByID($_GET['id_plateforme']);
		mysqlDeletePlateformeVersionsOrphelines();
		mysqlDeletePlateformeVersionImagesOrphelines();
		
		header("Location:  administration.php?plateforme=gestion&page=1&order=plateforme_date_modif&record=ok");
	}
	else if ($_POST['submit_plateforme'] =="sauvegarder"){

		if ($_FILES["image"]){

			if(trim($_POST['plateforme_name']) == ""  ||  !testFormatPlateformepicture()){
			header("Location:  administration.php?plateforme=edit&id_plateforme=".$_GET['id_plateforme']."&record=nok");
			}
			else if(trim($_POST['plateforme_name']) != "" && testFormatPlateformepicture()){
	
			if(($_FILES["image"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
					$image_name = NULL; //si pas de fichier on assigne un fichier par default
			}
			else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
					$result = mysqlSelectPlateformeByID($_GET['id_plateforme']);
					$data = mysql_fetch_array($result);
					$image_name = plateformepictureUpload($_POST['plateforme_name'],htmlspecialchars(trim($data['plateforme_dossier']))); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD

					//mysqlUpdatePlateformeImage($_GET['id_plateforme'], $image_name);
			
			}
			mysqlUpdatePlateforme($_GET['id_plateforme'],$_POST['id_constructeur'],$_POST['plateforme_name'],$_POST['plateforme_descriptif'],$_POST['retro'],$image_name);
			header("Location:  administration.php?plateforme=gestion&page=1&order=plateforme_date_modif&record=ok");			}
		}	
		else{
			$result = mysqlSelectPlateformeByID($_GET['id_plateforme']);
			$data = mysql_fetch_array($result);
			//insertPlateforme($_POST['plateforme_name'], $image_name);
			
			if(trim($_POST['plateforme_name']) == "" ){
			header("Location:  administration.php?plateforme=edit&id_plateforme=".$_GET['id_plateforme']."&record=nok");
			}
			else{	
			mysqlUpdatePlateforme($_GET['id_plateforme'],$_POST['id_constructeur'],$_POST['plateforme_name'],$_POST['plateforme_descriptif'],$_POST['retro'],$data['plateforme_image_generique']);
			header("Location:  administration.php?plateforme=gestion&page=1&order=plateforme_date_modif&record=ok");
			}
		}
	}
	else if($_GET['submit_plateforme'] == "delete_plateforme_image"){
			$result = mysqlSelectPlateformeByID($_GET['id_plateforme']);
			$data = mysql_fetch_array($result);
			if($data['plateforme_image_generique']!="nopicture.jpg"){
				unlink (dossier_plateformes()."/".htmlspecialchars(trim($data["plateforme_dossier"]))."/".htmlspecialchars(trim($data["plateforme_image_generique"])));
			}
			mysqlUpdatePlateforme($data['id_plateforme'],$data['id_constructeur'],$data['plateforme_nom_generique'],$data['plateforme_description'],$data['retro'],'');
			header("Location:  administration.php?plateforme=edit&id_plateforme=".$_GET['id_plateforme']."&record=ok");


	}	
	else if($_POST['submit_plateforme'] == "ajouter version"){
			header("Location:  administration.php?plateforme_version=add&id_plateforme=".$_GET['id_plateforme']."&page=1&order=plateforme_version_date_modif");
	}	
}

}
else{
	header("Location:  ../index.php");
}
//----------------------------------------------------------------------------------------//
// -----------------------------------[fonctions picture plateforme]------------------------ //
//----------------------------------------------------------------------------------------//
//function qui test la validité du fichier cover
function testFormatPlateformepicture(){

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

		$max_file = 3*MB;
		//on recupère les données du fichier 
   		//la taille du fichier
   		
   	 	$userfile_size = $_FILES["image"]["size"];  
   	 	//l'extension du fichier
   	 	
   	 	$filename = basename($_FILES["image"]["name"]);  
   	 	
   		$file_ext = substr($filename, strrpos($filename, ".") + 1);  
	    
	    if((!empty($_FILES["image"])) && ($_FILES["image"]["error"] == 0)) {
	    
    	//si l'extension et la taille sont  valide : true
        	if ((($file_ext=="jpg") ||($file_ext=="jpeg") )&&($userfile_size < $max_file)) {  
            	return true;
        	} 
       		//si ils sont pas valides on renvoie "false"
        	else{ 
        	
       			return false;
        	} 
    	}
    	//aucun fichier uploader? ça me va! on renvoie "true" on mettra une image par defaut
    	else if($_FILES["image"]["error"] == 4){
			return true;
		}
		
}

//--------------------------------------//
//fonction d'upload de l'image de la cover
function plateformepictureUpload($nom_dev,$plateforme_dossier){

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

	$max_file = 3*MB;
	$max_width = "300";
	$upload_path_pictures = dossier_plateformes()."/".$plateforme_dossier."/";// The path to where the image will be saved

	//Image Locations
	$image_name = deleteTousCaracteresSpeciaux($nom_dev).'_'.nameimage();
	$image_location = $upload_path_pictures.$image_name;

	//on recupère les données du fichier 
	//le nom du fichier
    $userfile_name = $_FILES["image"]["name"];  
    //le nom du fichier temporaire
    $userfile_tmp = $_FILES["image"]["tmp_name"];  
    //la taille du fichier
    $userfile_size = $_FILES["image"]["size"];  
    //le nom du fichier path exclus
    $filename = basename($_FILES["image"]["name"]);  
    //l'extension du fichier
    $file_ext = substr($filename, strrpos($filename, ".") + 1);  

    if(testFormatPlateformepicture()){
           	//tout est ok, on peut uploader le fichier
            move_uploaded_file($userfile_tmp, $image_location);  
            chmod ($image_location, 0777);  
            $width = getWidth($image_location);  
            $height = getHeight($image_location);  
            //Scale the image if it is greater than the width set above  
            if ($width > $max_width){  
                $scale = $max_width/$width;  
                $uploaded = resizeImage($image_location,$width,$height,$scale);  
            }else{  
                $scale = 1;  
                $uploaded = resizeImage($image_location,$width,$height,$scale);  
            } 
    }
    return $image_name;
}

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