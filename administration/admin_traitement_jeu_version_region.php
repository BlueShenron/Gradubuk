<?php
require_once('dossiers_ressources.php');
require_once('authentification.php');
require_once('mysql_fonctions_jeu_version_region.php');
require 'images_functions.php'; 

session_start();

//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------[test submit form jeu]-------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){


if (isset($_POST['submit_jeu_version_region']) || isset($_GET['submit_jeu_version_region']) ){
	
	
	if($_GET['submit_jeu_version_region']=="delete"){
		$result = mysqlSelectJeuRegion($_GET['id_jeu_version_region']);
		$data = mysql_fetch_array($result);
		if($data["jeu_region_cover"]){
		unlink (dossier_jeux().'/'.$data["jeu_dossier"].'/covers/'.trim($data["jeu_region_cover"]));
		}
		
		if($data["jeu_region_jaquette"]){
		unlink (dossier_jeux().'/'.$data["jeu_dossier"].'/jaquettes/'.trim($data["jeu_region_jaquette"]));
		}
		
		mysqlDeleteJeuVersionRegionByID($_GET['id_jeu_version_region']);
		mysqlDeletePegiOrpheline();
		mysqlDeleteCeroOrpheline();
		mysqlDeleteEsrbOrpheline();
		
		mysqlUpdateJeuDate($data['id_jeu']);

		header("Location:  administration.php?jeu=edit&id_jeu=".$_GET["id_jeu"]."&record=ok#tableau_version");		
	}
	else if($_POST['submit_jeu_version_region']=="sauvegarder"){
		
		$cover_file_upload = true;
		$jaquette_file_upload = true;
		$cover_file_format = true;
		$jaquette_file_format = true;
		
		if($_FILES["cover_file"]){
		$cover_file_format = testFormatCoverPicture();
		}
		else{
		$cover_file_upload = false;
		}
		
		if($_FILES["jaquette_file"]){
		$jaquette_file_format = testFormatJaquettePicture();
		}
		else{
		$jaquette_file_upload = false;
		}

			if(!$cover_file_format || !$jaquette_file_format){
				header("Location:  administration.php?jeu_version_region=edit&id_jeu_version_region=".$_GET["id_jeu_version_region"]."&record=nok");
			}
			else{
				
				$resultJeuRegion = mysqlSelectJeuRegion($_GET['id_jeu_version_region']);
				$dataJeuRegion = mysql_fetch_array($resultJeuRegion);
				
				if($cover_file_upload){
					if(($_FILES["cover_file"]["error"] == 4)){
						$cover_name = "";
					}
					else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
						
						$cover_name = coverPictureUpload($dataJeuRegion['plateforme_nom_generique'],$dataJeuRegion['jeu_region'],$dataJeuRegion['jeu_dossier']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
					}
				}
				else{
					$cover_name = $dataJeuRegion['jeu_region_cover'];
				}
				
				
				if($jaquette_file_upload){
					if(($_FILES["jaquette_file"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
						$jaquette_name = ""; //si pas de fichier on assigne un fichier par default
					}
					else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
						$jaquette_name = jaquettePictureUpload($dataJeuRegion['plateforme_nom_generique'],$dataJeuRegion['jeu_region'],$dataJeuRegion['jeu_dossier']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
					}
				}
				else{
					$jaquette_name = $dataJeuRegion['jeu_region_jaquette'];
				}
				
				$resultEditeur = mysqlSelectEditeurIDByName(trim($_POST['editeur_name']));
				$dataEditeur = mysql_fetch_array($resultEditeur);
				//le editeur n'existe pas encore en BDD alors il faut d'abord l'enregistrer
				if((mysql_num_rows($resultEditeur) == 0) && trim($_POST['editeur_name']) != ""){
					$id_editeur = mysqlInsertEditeur(trim($_POST['editeur_name']));
					//mysqlInsertEditeurImage($id_editeur,'');
				}
				//le editeur existe en BDD
				else{
					$id_editeur = $dataEditeur['id_editeur'];
				}
				
				//-------------------------------------//
				if( $dataJeuRegion['jeu_region'] == "pal"){
					resetPegi($_GET['id_jeu_version_region']);
					foreach($_POST['classification_pegi'] as $val){
    					updatePegi($_GET['id_jeu_version_region'], $val, "1");
 					}
				}
				else if( $dataJeuRegion['jeu_region'] == "jp"){
					resetCero($_GET['id_jeu_version_region']);
					foreach($_POST['classification_cero'] as $val){
    					updateCero($_GET['id_jeu_version_region'], $val, "1");
 					}
				}
				else if( $dataJeuRegion['jeu_region'] == "us"){
					resetEsrb($_GET['id_jeu_version_region']);
					foreach($_POST['classification_esrb'] as $val){
    					updateEsrb($_GET['id_jeu_version_region'], $val, "1");
 					}
				}
				
				
 				//mysqlUpdateJeuVersionRegion($id_jeu_version_region, $jeu_nom_region, $jeu_region, $jeu_date_sortie, $jeu_cover_file_url_url, $jeu_jaquette_file_url, $id_editeur){
				mysqlUpdateJeuVersionRegion($_GET['id_jeu_version_region'], $_POST['jeu_region_nom'],  $dataJeuRegion['jeu_region'],  $_POST['date_sortie'], $cover_name, $jaquette_name, $id_editeur);

 				
				
				//$result = mysqlSelectJeuIdByJeuVersionRegionId($_POST['id_jeu_version_region']);
				//$data = mysql_fetch_array($result);
				mysqlUpdateJeuDate($dataJeuRegion['id_jeu']);
				
				header("Location:  administration.php?jeu_version_region=edit&id_jeu_version_region=".$_GET["id_jeu_version_region"]."&record=ok");
				
			}


	}
	else if($_GET['submit_jeu_version_region']=="delete_cover"){
		
		$result = mysqlSelectJeuRegion($_GET['id_jeu_version_region']);
		$data = mysql_fetch_array($result);
		if($data["jeu_region_cover"]){
		unlink (dossier_jeux().'/'.$data["jeu_dossier"].'/covers/'.trim($data["jeu_region_cover"]));
		}

		mysqlUpdateJeuVersionRegion($_GET['id_jeu_version_region'], $data['jeu_region_nom'],  $data['jeu_region'],  $data['date_sortie'], '', $data['jeu_region_jaquette'], $data['id_editeur']);
		
		mysqlUpdateJeuDate($data['id_jeu']);
		
		header("Location:  administration.php?jeu_version_region=edit&id_jeu_version_region=".$_GET["id_jeu_version_region"]."&record=ok");
	}
	else if($_GET['submit_jeu_version_region']=="delete_jaquette"){
		$result = mysqlSelectJeuRegion($_GET['id_jeu_version_region']);
		$data = mysql_fetch_array($result);
		if($data["jeu_region_jaquette"]){
		unlink (dossier_jeux().'/'.$data["jeu_dossier"].'/jaquettes/'.trim($data["jeu_region_jaquette"]));
		}
		mysqlUpdateJeuVersionRegion($_GET['id_jeu_version_region'], $data['jeu_region_nom'],  $data['jeu_region'],  $data['date_sortie'],$data['jeu_region_cover'], '', $data['id_editeur']);
		
		mysqlUpdateJeuDate($data['id_jeu']);

		
		header("Location:  administration.php?jeu_version_region=edit&id_jeu_version_region=".$_GET["id_jeu_version_region"]."&record=ok");	}
}

}
else{
	header("Location:  ../index.php");
}



/*----------------------------------------------------------------------------------------*/
/* -----------------------------------[fonctions jeu cover picture]--------------------- */
/*----------------------------------------------------------------------------------------*/
//function qui test la validité du fichier cover
function testFormatCoverPicture(){

		$max_file = "3000000";
		//on recupère les données du fichier 
   		//la taille du fichier
   	 	$userfile_size = $_FILES["cover_file"]["size"];  
   	 	//l'extension du fichier
   	 	$filename = basename($_FILES["cover_file"]["name"]);  
   	 	
   		$file_ext = substr($filename, strrpos($filename, ".") + 1);  
	    if((!empty($_FILES["cover_file"])) && ($_FILES["cover_file"]["error"] == 0)) {
	    
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
    	else if($_FILES["cover_file"]["error"] == 4){
			return true;
		}
		
}

/*--------------------------------------*/
//fonction d'upload de l'image de la cover
function coverPictureUpload($plateforme_nom_generique,$jeu_region,$jeu_dossier){
	
	$max_file = "3000000"; // on permet une taille de fichier allant jusque approx 1MB
	$max_width = "120";
	$upload_dir_pictures = dossier_jeux().'/'.$jeu_dossier.'/covers'; 	// The directory for the images to be saved in
	$upload_path_pictures = $upload_dir_pictures."/";// The path to where the image will be saved
	//Image Locations
	$image_name = $plateforme_nom_generique.'_'.$jeu_region.'_'.nameimage();
	
	$image_location = $upload_path_pictures.$image_name;

	//on recupère les données du fichier 
	//le nom du fichier
    $userfile_name = $_FILES["cover_file"]["name"];  
    //le nom du fichier temporaire
    $userfile_tmp = $_FILES["cover_file"]["tmp_name"];  
    //la taille du fichier
    $userfile_size = $_FILES["cover_file"]["size"];  
    //le nom du fichier path exclus
    $filename = basename($_FILES["cover_file"]["name"]);  
    //l'extension du fichier
    $file_ext = substr($filename, strrpos($filename, ".") + 1);  

    if(testFormatCoverPicture()){
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



/*----------------------------------------------------------------------------------------*/
/* -----------------------------------[fonctions jeu jaquette picture]--------------------- */
/*----------------------------------------------------------------------------------------*/
//function qui test la validité du fichier cover
function testFormatJaquettePicture(){

		$max_file = "3000000";
		//on recupère les données du fichier 
   		//la taille du fichier
   	 	$userfile_size = $_FILES["jaquette_file"]["size"];  
   	 	//l'extension du fichier
   	 	$filename = basename($_FILES["jaquette_file"]["name"]);  
   	 	
   		$file_ext = substr($filename, strrpos($filename, ".") + 1);  
	    if((!empty($_FILES["jaquette_file"])) && ($_FILES["jaquette_file"]["error"] == 0)) {
	    
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
    	else if($_FILES["jaquette_file"]["error"] == 4){
			return true;
		}
		
}

/*--------------------------------------*/
//fonction d'upload de l'image de la cover
function jaquettePictureUpload($plateforme_nom_generique,$jeu_region,$jeu_dossier){

	$max_file = "3000000"; // on permet une taille de fichier allant jusque approx 1MB
	$max_width = "800";
	$upload_dir_pictures = dossier_jeux().'/'.$jeu_dossier.'/jaquettes'; 	// The directory for the images to be saved in
	$upload_path_pictures = $upload_dir_pictures."/";// The path to where the image will be saved

	//Image Locations
	$image_name = $plateforme_nom_generique.'_'.$jeu_region.'_'.nameimage();
	$image_location = $upload_path_pictures.$image_name;

	//on recupère les données du fichier 
	//le nom du fichier
    $userfile_name = $_FILES["jaquette_file"]["name"];  
    //le nom du fichier temporaire
    $userfile_tmp = $_FILES["jaquette_file"]["tmp_name"];  
    //la taille du fichier
    $userfile_size = $_FILES["jaquette_file"]["size"];  
    //le nom du fichier path exclus
    $filename = basename($_FILES["jaquette_file"]["name"]);  
    //l'extension du fichier
    $file_ext = substr($filename, strrpos($filename, ".") + 1);  

    if(testFormatJaquettePicture()){
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
/*---------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------*/


?>