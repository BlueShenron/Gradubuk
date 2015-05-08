<?php
require_once('mysql_fonctions_frontpage_test.php'); 
require_once('authentification.php');

require_once('images_functions.php'); 
require_once('dossiers_ressources.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form membre]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_frontpage_test']) || isset($_GET['submit_frontpage_test']) ){
	if($_POST['submit_frontpage_test']=="créer"){
		if(trim($_POST['frontpage_titre']) == ""  || trim($_POST['frontpage_sous_titre']) == "" ){
			//echo '>>'.trim($_POST['frontpage_titre']).'<<>>'.trim($_POST['frontpage_sous_titre']).'<<';
			header("Location:  administration.php?frontpage_test=add&id_test=".$_GET['id_test']."&record=nok");
		}
		else if(trim($_POST['frontpage_titre']) != "" && trim($_POST['frontpage_sous_titre']) !=""){
			$resultTest = mysqlSelectTestByID($_GET['id_test']);
			$dataTest=mysql_fetch_array($resultTest);
			//echo $dataTest['url_test_jeu_version_plateforme_illustration'];
			$id = mysqlInsertFrontpage($_POST['frontpage_titre'],$_POST['frontpage_sous_titre'],$_GET['id_test'],$dataTest['test_date_publication'],$dataTest['url_test_jeu_version_plateforme_illustration']);
			mysqlUpdateTest($_GET['id_test']);
			header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");
			
			//$image_name = imageFrontpageUpload($_POST['frontpage_titre']); //la fonction coverUplaod me renvoie un nom de fichier à inserer dans la BDD
			
			//echo 'ok';
			//$id = mysqlInsertFrontpage($_POST['frontpage_titre'],$_POST['frontpage_sous_titre'],$image_name,$_GET['id_test']);
			//mysqlUpdateTest($_GET['id_test']);
			//header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");
		}
	}
	else if($_GET['submit_frontpage_test']=="delete"){
		
		$resulFrontpage = mysqlSelectFrontpageByID($_GET['id_frontpage']);
		$dataFrontpage = mysql_fetch_array($resulFrontpage);
		
		unlink (dossier_frontpages()."/".trim($dataFrontpage["frontpage_image_nom"]));
		
		mysqlDeleteFrontpage($_GET['id_frontpage']);
		mysqlUpdateTest($_GET['id_test']);
		header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");
	}
	else if($_POST['submit_frontpage_test']=="sauvegarder"){
		if(trim($_POST['frontpage_titre']) == ""  || trim($_POST['frontpage_sous_titre']) == ""){
			
			//echo '>>'.trim($_POST['frontpage_titre']).'<<>>'.trim($_POST['frontpage_sous_titre']).'<<';
			header("Location:  administration.php?frontpage_test=edit&id_test=".$_GET['id_test']."&id_frontpage=".$_GET['id_frontpage']."&record=nok");
		}
		else if(trim($_POST['frontpage_titre']) != "" && trim($_POST['frontpage_sous_titre']) != "" ){
			
			$resultTest = mysqlSelectTestByID($_GET['id_test']);
			$dataTest=mysql_fetch_array($resultTest);
			
			$id = mysqlUpdateFrontpage($_GET['id_frontpage'],$_POST['frontpage_titre'],$_POST['frontpage_sous_titre']);
			mysqlUpdateTest($_GET['id_test']);
			header("Location:  administration.php?test=gestion&page=1&order=test_date_modif&record=ok");
		}
	}
}

}
else{
	header("Location:  ../index.php");
}



//----------------------------------------------------------------------------------------//
// -----------------------------------[fonctions logo developpeur]------------------------ //
//----------------------------------------------------------------------------------------//
//function qui test la validité du fichier cover
function testImageFrontpage(){

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
    	//aucun fichier uploader
    	else if($_FILES["image"]["error"] == 4){
			return true;
		}
		
}

//--------------------------------------//
//fonction d'upload de l'image de la cover
function imageFrontpageUpload($titre_test){
define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

	$max_file = 3*MB;
	$max_width = "300";
	$upload_path_pictures = dossier_frontpages()."/";// The path to where the image will be saved

	//Image Locations
	$image_name = deleteTousCaracteresSpeciaux($titre_test).'_'.nameimage();
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

    if(testImageFrontpage()){
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