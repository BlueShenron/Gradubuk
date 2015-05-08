<?php

require 'images_functions.php'; 
require_once('mysql_fonctions_jeu_version_plateforme_image.php'); 
require_once('dossiers_ressources.php');
require_once('authentification.php');
session_start();


/*----------------------------------------------------------------------------------------*/
/* -----------------------------------[fonctions image_jeu]------------------------ */
/*----------------------------------------------------------------------------------------*/
if(getGroupe()=='admin'){

if(isset($_GET['submit_image_jeu']) || isset($_POST['submit_image_jeu'])){
	if($_POST['submit_image_jeu']=="ajouter"){
		
		if(!testFormatPicture()){
			//echo'iiii';
			header("Location:  administration.php?jeu_version_plateforme_image=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=nok");

		}
		else{
			//echo'ooo';
			if(($_FILES["image_file"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
				//$cover_name = "ressources/nopicture.jpg"; //si pas de fichier on assigne un fichier par default
				//echo '1';
				header("Location:  administration.php?jeu_version_plateforme_image=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=nok");
			}
			else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
				//$cover_name = 'jeux/'.$dataJeu['jeu_dossier'].'/covers/'.coverPictureUpload($dataJeu['jeu_dossier']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
				//echo '2';
				$result=mysqlSelectVersionsCompletesByjeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
				$data=mysql_fetch_array($result);
				//echo '>>'.$_POST['id_img_categorie'];
				if($_POST['id_categorie_image']!= NULL){
				$resultImgCategorie=mysqlSelectImgCategoriesById($_POST['id_categorie_image']);
				$dataImgCategorie=mysql_fetch_array($resultImgCategorie);
				$dataImageCategorie = htmlspecialchars(trim($dataImgCategorie['categorie_image_nom']));
				}
				else
				{
				$dataImageCategorie = "";
				}
				
				$image_name = pictureUpload(htmlspecialchars(trim($data['jeu_nom_generique'])), $dataImageCategorie, htmlspecialchars(trim($data['jeu_dossier'])));
				$id= mysqlInsertImageJeuVersionPlateforme($_GET['id_jeu_version_plateforme'],$image_name, $_POST['id_categorie_image'], $_POST['image_titre']);
				header("Location:  administration.php?jeu_version_plateforme_image=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=ok");
			}
		
		}
	}
	else if (($_POST['submit_image_jeu']) == "supprimer la selection"){
		if($_POST['image_to_delete']){
		foreach($_POST['image_to_delete'] as $valeur)
		{
   			$result = mysqlSelectJeuVersionPlateformeImage($valeur);
			$data = mysql_fetch_array($result);
			unlink (dossier_jeux()."/".htmlspecialchars(trim($data["jeu_dossier"]))."/pictures/".htmlspecialchars(trim($data["image_nom"])));
			
   			mysqlDeleteJeuVersionPlateformeImageByID($valeur);
			header("Location:  administration.php?jeu_version_plateforme_image=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=ok");

   			
		}
		}
		else{
			header("Location:  administration.php?jeu_version_plateforme_image=add&id_jeu_version_plateforme=".$_GET['id_jeu_version_plateforme']."&record=ok");
		}
	}
	else if (($_POST['submit_image_jeu']) == "sauvegarder"){
		mysqUpdateJeuVersionPlateformeImageIdImage($_GET['id_jeu_version_plateforme_image'], $_POST['image_titre'], $_POST['id_categorie_image']);
		header("Location:  administration.php?jeu_version_plateforme_image=edit&id_jeu_version_plateforme_image=".$_GET['id_jeu_version_plateforme_image']."&record=ok");
		
	}
}

}
else{
	header("Location:  ../index.php");
}

/*--------------------------------------*/
function testFormatPicture(){

		$max_file = "3000000";
		//on recupère les données du fichier 
   		//la taille du fichier
   	 	$userfile_size = $_FILES["image_file"]["size"];  
   	 	//l'extension du fichier
   	 	$filename = basename($_FILES["image_file"]["name"]);  
   	 	
   		$file_ext = substr($filename, strrpos($filename, ".") + 1);  
	    if((!empty($_FILES["image_file"])) && ($_FILES["image_file"]["error"] == 0)) {
	    
    	//si l'extension et la taille sont  valide : true
        	if ((($file_ext=="jpg") ||($file_ext=="jpeg") )&&($userfile_size < $max_file)) {  
				//le fichier n'est ni jpg ni bonne taille
            	return true;
        	} 
       		//si ils sont pas valides on renvoie "false"
        	else{ 
       			return false;
        	} 
    	}
    	//aucun fichier uploader? ça me va! on renvoie "true" on mettra une image par defaut
    	else if($_FILES["image_file"]["error"] == 4){
			return true;
		}
		
}

/*--------------------------------------*/
//fonction d'upload de l'image de la cover
function pictureUpload($jeu_nom_generique, $image_categorie, $jeu_dossier){

	$max_file = "3000000"; // on permet une taille de fichier allant jusque approx 1MB
	$max_width = "800";
	$upload_dir_pictures = dossier_jeux().'/'.$jeu_dossier.'/pictures'; 	// The directory for the images to be saved in
	$upload_path_pictures = $upload_dir_pictures."/";// The path to where the image will be saved

	//Image Locations
	$image_name = deleteTousCaracteresSpeciaux($jeu_nom_generique).'_'.deleteTousCaracteresSpeciaux($image_categorie).'_'.time().'.jpg';
	$image_location = $upload_path_pictures.$image_name;

	//on recupère les données du fichier 
	//le nom du fichier
    $userfile_name = $_FILES["image_file"]["name"];  
    //le nom du fichier temporaire
    $userfile_tmp = $_FILES["image_file"]["tmp_name"];  
    //la taille du fichier
    $userfile_size = $_FILES["image_file"]["size"];  
    //le nom du fichier path exclus
    $filename = basename($_FILES["image_file"]["name"]);  
    //l'extension du fichier
    $file_ext = substr($filename, strrpos($filename, ".") + 1);  

    if(testFormatPicture()){
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


?>