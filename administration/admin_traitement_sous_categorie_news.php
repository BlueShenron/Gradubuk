<?php
require_once('images_functions.php'); 
require_once('mysql_fonctions_sous_categorie_news.php'); 
require_once('dossiers_ressources.php');
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form sous_categorie_news]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_sous_categorie_news']) || isset($_GET['submit_sous_categorie_news']) ){
	if($_POST['submit_sous_categorie_news']=="ajouter"){
		if(trim($_POST['sous_categorie_news_name']) == ""  ||  !testFormatSousCategorieNewsLogo()){
			header("Location:  administration.php?sous_categorie_news=add&id_categorie_news=".$_GET['id_categorie_news']."&record=nok");
		}
		else if(trim($_POST['sous_categorie_news_name']) != "" && testFormatSousCategorieNewsLogo()){
			if(($_FILES["image"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
					$image_name =NULL; //si pas de fichier on assigne un fichier par default
			}
			else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
					$image_name = SousCategorieNewsLogoUpload($_POST['sous_categorie_news_name']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
			}
			$id = mysqlInsertSousCategorieNews($_POST['sous_categorie_news_name'],$_GET['id_categorie_news'],$image_name);

			header("Location:  administration.php?categorie_news=gestion&order=categorie_news_date_modif&record=ok");
		}
	}
	if($_GET['submit_sous_categorie_news']=="delete"){
		$result = mysqlSelectSousCategorieNewsByID($_GET['id_sous_categorie_news']);
		$data = mysql_fetch_array($result);
		if($data['sous_categorie_news_logo']!="nopicture.jpg"){
			unlink (dossier_categories_news()."/".trim($data["sous_categorie_news_logo"]));
		}
		mysqlDeleteSousCategorieNewsByID($_GET['id_sous_categorie_news']);
		mysqlDeleteNewsSousCategorieNewsSousCategorieNewsOrpheline();
		header("Location:  administration.php?categorie_news=gestion&record=ok");//
	}
	else if ($_POST['submit_sous_categorie_news'] =="sauvegarder"){

		if ($_FILES["image"]){

			if(trim($_POST['sous_categorie_news_name']) == ""  ||  !testFormatSousCategorieNewsLogo()){
			header("Location:  administration.php?sous_categorie_news=edit&id_sous_categorie_news=".$_GET['id_sous_categorie_news']."&record=nok");
			}
			else if(trim($_POST['sous_categorie_news_name']) != "" && testFormatSousCategorieNewsLogo()){
	
			if(($_FILES["image"]["error"] == 4)){ //4 = pas de fichier à uploader, on assigne l'image par défaut.
					$image_name =NULL; //si pas de fichier on assigne un fichier par default
					
			}
			else{ //un fichier a uploader, on appelle la fonction cover upload qui nous renvoie le nom à renseigner dans la base.
					$image_name = SousCategorieNewsLogoUpload($_POST['sous_categorie_news_name']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
					/*$result = mysqlSelectSousCategorieNewsByID($_GET['id_sous_categorie_news']);
					$data = mysql_fetch_array($result);
					if($data['sous_categorie_news_logo']=="nopicture.jpg"){
					mysqlInsertSousCategorieNewsImage($_GET['id_sous_categorie_news'],$image_name);
					}
					else{
					mysqlUpdateSousCategorieNewsImage($data['id_sous_categorie_news_image'], $image_name);
					}*/
					//mysqlInsertSousCategorieNewsImage($_GET['id_sous_categorie_news'],$image_name);
					//mysqlUpdateSousCategorieNewsImage($_GET['id_sous_categorie_news'], $image_name);

			}
			
			
			mysqlUpdateSousCategorieNews($_POST['sous_categorie_news_name'], $_GET['id_sous_categorie_news'], $_POST['id_categorie_news'],$image_name);
			
			header("Location:  administration.php?categorie_news=gestion&record=ok");
			}
		}	
		else{
			$result = mysqlSelectSousCategorieNewsByID($_GET['id_sous_categorie_news']);
			$data = mysql_fetch_array($result);
			//insertSousCategorieNews($_POST['sous_categorie_news_name'], $image_name);
			
			if(trim($_POST['sous_categorie_news_name']) == "" ){
			header("Location:  administration.php?sous_categorie_news=edit&id_sous_categorie_news=".$_GET['id_sous_categorie_news']."&sous_categorie_news_edit=nok");
			}
			else{
			mysqlUpdateSousCategorieNews($_POST['sous_categorie_news_name'], $_GET['id_sous_categorie_news'], $_POST['id_categorie_news'],$data['sous_categorie_news_logo']);
			header("Location:  administration.php?categorie_news=gestion&record=ok");
			}
		}
	}
	else if($_GET['submit_sous_categorie_news'] == "delete_sous_categorie_news_logo"){
			$result = mysqlSelectSousCategorieNewsByID($_GET['id_sous_categorie_news']);
			$data = mysql_fetch_array($result);
			if($data['sous_categorie_news_logo']!="nopicture.jpg"){
				unlink (dossier_categories_news()."/".trim($data["sous_categorie_news_logo"]));
			}
			mysqlUpdateSousCategorieNews($data['sous_categorie_news_nom'], $data['id_sous_categorie_news'], $data['id_categorie_news'],NULL);

			//mysqlUpdateSousCategorieNewsImage($data["id_sous_categorie_news"],NULL);
			header("Location:  administration.php?sous_categorie_news=edit&id_sous_categorie_news=".$_GET['id_sous_categorie_news']."&record=ok");
	}		
}

}
else{
	header("Location:  ../index.php");
}
//----------------------------------------------------------------------------------------//
// -----------------------------------[fonctions logo sous_categorie_news]------------------------ //
//----------------------------------------------------------------------------------------//
//function qui test la validité du fichier cover
function testFormatSousCategorieNewsLogo(){

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
function SousCategorieNewsLogoUpload($nom_dev){

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

	$max_file = 3*MB;
	$max_width = "300";
	$upload_path_pictures = dossier_categories_news()."/";// The path to where the image will be saved

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

    if(testFormatSousCategorieNewsLogo()){
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