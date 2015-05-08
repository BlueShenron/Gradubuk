<?php
require_once('images_functions.php'); 
require_once('mysql_fonctions_editeur.php'); 
require_once('dossiers_ressources.php');
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form editeur]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_editeur']) || isset($_GET['submit_editeur']) ){
	if($_POST['submit_editeur']=="ajouter"){
		if(trim($_POST['editeur_name']) == ""  ||  !testFormatEditeurLogo()){
			header("Location:  administration.php?editeur=add&page=1&order=editeur_date_modif&record=nok");
		}
		else if(trim($_POST['editeur_name']) != "" && testFormatEditeurLogo()){
			if(($_FILES["image"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
					$image_name =NULL; //si pas de fichier on assigne un fichier par default
			}
			else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
					$image_name = editeurLogoUpload($_POST['editeur_name']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
			}
			$id = mysqlInsertEditeur($_POST['editeur_name'],$image_name);

			header("Location:  administration.php?editeur=gestion&page=1&order=editeur_date_modif&record=ok");
		}
	}
	else if($_POST['submit_editeur']=="ajouter un éditeur"){
		header("Location:  administration.php?editeur=add&page=1&order=editeur_date_modif");
	}
	else if($_GET['submit_editeur']=="delete"){
		$result = mysqlSelectEditeurByID($_GET['id_editeur']);
		$data = mysql_fetch_array($result);
		
		$resultCountImage = mysqlCountNewsImage("editeurs/".trim($data["editeur_logo"]));
		$dataCountImage = mysql_fetch_array($resultCountImage);
		
		if($dataCountImage['SumCount']==0){
				if($data['editeur_logo']!="nopicture.jpg"){
					mysqlDeleteNewsImage("editeurs/".trim($data["editeur_logo"]));
					unlink (dossier_editeurs()."/".trim($data["editeur_logo"]));
				}
		}
		
	
		
		mysqlDeleteEditeurByID($_GET['id_editeur']);
		mysqlDeleteNewsEditeurOrpheline();
		header("Location:  administration.php?editeur=gestion&page=1&order=".$_GET['order']."&record=ok");//
	}
	else if ($_POST['submit_editeur'] =="sauvegarder"){

		if ($_FILES["image"]){

			if(trim($_POST['editeur_name']) == ""  ||  !testFormatEditeurLogo()){
			header("Location:  administration.php?editeur=edit&id_editeur=".$_GET['id_editeur']."&record=nok");
			}
			else if(trim($_POST['editeur_name']) != "" && testFormatEditeurLogo()){
	
			if(($_FILES["image"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
					$image_name =NULL; //si pas de fichier on assigne un fichier par default
					
			}
			else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
					$image_name = editeurLogoUpload($_POST['editeur_name']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
					/*$result = mysqlSelectEditeurByID($_GET['id_editeur']);
					$data = mysql_fetch_array($result);
					if($data['editeur_logo']=="nopicture.jpg"){
					mysqlInsertEditeurImage($_GET['id_editeur'],$image_name);
					}
					else{
					mysqlUpdateEditeurImage($data['id_editeur_image'], $image_name);
					}*/
					//mysqlInsertEditeurImage($_GET['id_editeur'],$image_name);
					//mysqlUpdateEditeur(, $image_name);
					//mysqlUpdateEditeur($editeur_name, $_GET['id_editeur'], $image_nom);
			}
			mysqlUpdateEditeur($_POST['editeur_name'], $_GET['id_editeur'],$image_name);
			
			header("Location:  administration.php?editeur=gestion&page=1&order=editeur_date_modif&record=ok");
			}
		}	
		else{
			$result = mysqlSelectEditeurByID($_GET['id_editeur']);
			$data = mysql_fetch_array($result);
			//insertEditeur($_POST['editeur_name'], $image_name);
			
			if(trim($_POST['editeur_name']) == "" ){
			header("Location:  administration.php?editeur=edit&id_editeur=".$_GET['id_editeur']."&editeur_edit=nok");
			}
			else{
			mysqlUpdateEditeur($_POST['editeur_name'], $_GET['id_editeur'],$data['editeur_logo']);
			header("Location:  administration.php?editeur=gestion&page=1&order=editeur_date_modif&record=ok");
			}
		}
	}
	else if($_GET['submit_editeur'] == "delete_editeur_logo"){
			$result = mysqlSelectEditeurByID($_GET['id_editeur']);
			$data = mysql_fetch_array($result);
			$resultCountImage = mysqlCountNewsImage("editeurs/".trim($data["editeur_logo"]));
			$dataCountImage = mysql_fetch_array($resultCountImage);
			if($dataCountImage['SumCount']==0){
				if($data['editeur_logo']!="nopicture.jpg"){
					mysqlDeleteNewsImage("editeurs/".trim($data["editeur_logo"]));
					unlink (dossier_editeurs()."/".trim($data["editeur_logo"]));
				}
			}
			mysqlUpdateEditeur($data['editeur_nom'],$_GET['id_editeur'],NULL);
			header("Location:  administration.php?editeur=edit&id_editeur=".$_GET['id_editeur']."&record=ok");
	}		
}

}
else{
	header("Location:  ../index.php");
}
//----------------------------------------------------------------------------------------//
// -----------------------------------[fonctions logo editeur]------------------------ //
//----------------------------------------------------------------------------------------//
//function qui test la validité du fichier cover
function testFormatEditeurLogo(){

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
function editeurLogoUpload($nom_dev){

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

	$max_file = 3*MB;
	$max_width = "300";
	$upload_path_pictures = dossier_editeurs()."/";// The path to where the image will be saved

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

    if(testFormatEditeurLogo()){
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