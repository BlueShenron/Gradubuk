<?php
require_once('images_functions.php'); 
require_once('mysql_fonctions_plateforme_version.php'); 
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

if (isset($_POST['submit_plateforme_version']) || isset($_GET['submit_plateforme_version']) ){
	if($_POST['submit_plateforme_version']=="ajouter"){
		if(trim($_POST['plateforme_version_name']) == ""){
			header("Location:  administration.php?plateforme_version=add&id_plateforme=".$_POST['id_plateforme']."&page=1&order=plateforme_version_date_modif&record=nok");
		}
		else if(trim($_POST['plateforme_version_name']) != ""){
			mysqlInsertPlateformeVersion($_POST['id_plateforme'],$_POST['plateforme_version_name'],$_POST['plateforme_version_descriptif'],$_POST['date_lancement'],$_POST['date_fin']);
			header("Location:  administration.php?plateforme=gestion&page=1&order=plateforme_date_modif&record=ok");
		}
	}
	if($_GET['submit_plateforme_version']=="delete"){
		//echo'iii';
			$result = mysqlSelectAllPlateformeVersionImages($_GET['id_plateforme_version']);
			while($data=mysql_fetch_array($result)) {
				//echo '....'.dossier_plateformes()."/".htmlspecialchars(trim($data["plateforme_dossier"]))."/".htmlspecialchars(trim($data["plateforme_version_image_nom"]));
				unlink (dossier_plateformes()."/".htmlspecialchars(trim($data["plateforme_dossier"]))."/".htmlspecialchars(trim($data["plateforme_version_image_nom"])));
				mysqlDeletePlateformeVersionImageByID(htmlspecialchars(trim($data["id_plateforme_version_image"])));
			}
			mysqlDeletePlateformeVersionByID($_GET['id_plateforme_version']);
			header("Location:  administration.php?plateforme=gestion&page=1&order=plateforme_date_modif&record=ok");
	}
	else if ($_POST['submit_plateforme_version'] =="sauvegarder"){
			
			if(trim($_POST['plateforme_version_name']) == "" ){
			header("Location:  administration.php?plateforme_version=edit&id_plateforme_version=".$_POST['id_plateforme_version']."&record=nok");
			}
			else{	
			mysqlUpdatePlateformeVersion($_POST['id_plateforme_version'],$_POST['plateforme_version_name'],$_POST['plateforme_version_descriptif'],$_POST['date_lancement'],$_POST['date_fin']);
			//header("Location:  administration.php?plateforme_version=edit&id_plateforme_version=".$_POST['id_plateforme_version']."&record=ok");
			$result = mysqlSelectPlateformeVersionByID($_POST['id_plateforme_version']);
			$data = mysql_fetch_array($result);
			header("Location:  administration.php?plateforme=gestion&page=1&order=plateforme_date_modif&record=ok");

			}
	}
	else if ($_POST['submit_plateforme_version'] =="gérer les images"){
			
			header("Location:  administration.php?plateforme_version_picture=add&id_plateforme_version=".$_POST['id_plateforme_version']."");
			

	}
		
	else if($_GET['submit_plateforme_version'] == "picture"){
			
			header("Location:  administration.php?version_plateforme=add&id_plateforme=".$_GET['id_plateforme']."");
	}	
}
else if (isset($_POST['submit_plateforme_version_image'])){
	if (($_POST['submit_plateforme_version_image']) == "ajouter"){
			
			

			if(!testFormatPlateformeVersionPicture()){
				
			header("Location:  administration.php?plateforme_version_picture=add&id_plateforme_version=".$_POST['id_plateforme_version']."&record=nok");
			
			
			}
			else if(testFormatPlateformeVersionPicture()){
				
				if(($_FILES["image"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
					
					header("Location:  administration.php?plateforme_version_picture=add&id_plateforme_version=".$_POST['id_plateforme_version']."&record=nok");

 				}
				else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.	
					$result = mysqlSelectPlateformeVersionByID($_POST['id_plateforme_version']);
					$data = mysql_fetch_array($result);
					$image_name = plateformeVersionPictureUpload($data['plateforme_version_nom'],htmlspecialchars(trim($data['plateforme_dossier']))); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
					
					mysqlInsertPlateformeVersionImage($_POST['id_plateforme_version'],$image_name);
				}
				header("Location:  administration.php?plateforme_version_picture=add&id_plateforme_version=".$_POST['id_plateforme_version']."&record=ok");
			}
	}
	else if (($_POST['submit_plateforme_version_image']) == "supprimer la selection"){
		if($_POST['image_to_delete']){
		foreach($_POST['image_to_delete'] as $valeur)
		{
			//echo '>>>'.$_POST['id_plateforme_version'].'<<<';
   			$result = mysqlSelectAllPlateformeVersionImage($valeur);
			$data = mysql_fetch_array($result);
			//echo dossier_plateformes()."/".htmlspecialchars(trim($data["plateforme_dossier"]))."/".htmlspecialchars(trim($data["plateforme_version_image_nom"]));
			unlink (dossier_plateformes()."/".htmlspecialchars(trim($data["plateforme_dossier"]))."/".htmlspecialchars(trim($data["plateforme_version_image_nom"])));
			
   			mysqlDeletePlateformeVersionImageByID($valeur);
   			header("Location:  administration.php?plateforme_version_picture=add&id_plateforme_version=".$_POST['id_plateforme_version']."&record=ok");

   			
		}
		}
		else{
			header("Location:  administration.php?plateforme_version_picture=add&id_plateforme_version=".$_POST['id_plateforme_version']."&record=ok");
		}
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
function testFormatPlateformeVersionPicture(){

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
        	if ((($file_ext=="jpg") ||($file_ext=="jpeg") ) && ($userfile_size < $max_file)) {  
            	
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
function plateformeVersionPictureUpload($nom_dev,$plateforme_dossier){

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

    if(testFormatPlateformeVersionPicture()){
           	//tout est ok, on peut uploader le fichier
            move_uploaded_file($userfile_tmp, $image_location);  
            chmod ($image_location, 0777);  
                
            $width = getWidth($image_location);  
            $height = getHeight($image_location);
              //echo $width.'>>>>'.$max_width.'<<<<' ; 
            //Scale the image if it is greater than the width set above  
            if ($width > $max_width){  
            
                $scale = $max_width/$width;  
              
                $uploaded = resizeImage($image_location,$width,$height,$scale); 
                
            }
            else{  
            
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