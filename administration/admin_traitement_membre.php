<?php
require_once('mysql_fonctions_membre.php'); 
require_once('authentification.php');
session_start();
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//-----------------------------------[test submit form membre]----------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_membre']) || isset($_GET['submit_membre']) ){
	if($_POST['submit_membre']=="ajouter"){
		if(trim($_POST['membre_name']) == "" || trim($_POST['membre_url']) == ""){
			header("Location:  administration.php?membre=add&page=1&order=membre_date_modif&record=nok");
		}
		else if(trim($_POST['membre_name']) != "" && trim($_POST['membre_url']) != ""){
			mysqlInsertMembre($_POST['membre_name'],$_POST['membre_url']);
			header("Location:  administration.php?membre=add&page=1&order=membre_date_modif&record=ok");
		}
	}
	else if($_GET['submit_membre']=="delete"){
		mysqlDeleteMembreByID($_GET['id_membre']);
		header("Location:  administration.php?membre=gestion&page=1&order=".$_GET['order']."&record=ok");
	}
	else if($_POST['submit_membre']=="supprimer la selection"){
		foreach($_POST['membres'] as $valeur){
			mysqlDeleteMembreByID($valeur);
			header("Location:  administration.php?membre=gestion&page=1&order=membre_date_modif&record=ok");
		}
	}
	else if($_GET['submit_membre']=="edit"){
		header("Location:  administration.php?membre=edit&id_membre=".$_GET['id_membre']."");
		
	}
	else if ($_POST['submit_membre'] =="sauvegarder"){

			$result = mysqlSelectMembreByID($_GET['id_membre']);
			$data = mysql_fetch_array($result);
			//insertMembre($_POST['membre_name'], $image_name);
			
			/*if(trim($_POST['membre_name']) == "" ){
			header("Location:  administration.php?membre=edit&id_membre=".$_GET['id_membre']."&membre_edit=nok");
			}
			else{
			mysqlUpdateMembre($_POST['membre_name'],$_POST['membre_url'], $_GET['id_membre']);
			header("Location:  administration.php?membre=add&page=1&order=membre_date_modif&record=ok");
			}*/
			mysqlUpdateMembre($_POST['pseudo'],$_POST['email'],$_POST['groupe'], $_GET['id_membre']);
			header("Location:  administration.php?membre=edit&id_membre=".$_GET['id_membre']."&record=ok");
		
	}
	
}

}
else{
	header("Location:  ../index.php");
}


?>