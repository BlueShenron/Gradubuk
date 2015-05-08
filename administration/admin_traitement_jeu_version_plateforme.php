<?php
require_once('dossiers_ressources.php');
require_once('authentification.php');
require_once('mysql_fonctions_jeu_version_plateforme.php');
session_start();

//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------[test submit form jeu]-------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
if(getGroupe()=='admin'){

if (isset($_POST['submit_jeu_version_plateforme']) || isset($_GET['submit_jeu_version_plateforme']) ){
	if($_GET['submit_jeu_version_plateforme']=="delete"){
		
		$result = mysqlSelectJeuVersionRegionByJeuVersionPlateformeID($_GET['id_jeu_version_plateforme']);
		while($data = mysql_fetch_array($result)){
		if($data["jeu_region_cover"]){
		unlink (dossier_jeux().'/'.$data["jeu_dossier"].'/covers/'.trim($data["jeu_region_cover"]));
		}
		
		if($data["jeu_region_jaquette"]){
		unlink (dossier_jeux().'/'.$data["jeu_dossier"].'/jaquettes/'.trim($data["jeu_region_jaquette"]));
		}
		}
		
		$resultImages = mysqlSelectJeuVersionPlateformeImage($_GET['id_jeu_version_plateforme']);
		while($dataImages = mysql_fetch_array($resultImages)){
			if($dataImages["image_nom"]){
				unlink (dossier_jeux()."/".htmlspecialchars(trim($dataImages["jeu_dossier"]))."/pictures/".htmlspecialchars(trim($dataImages["image_nom"])));
			}
		}
		
		
		mysqlDeleteJeuVersionPlateforme($_GET['id_jeu_version_plateforme']);
		mysqlDeleteJeuVersionRegionOrpheline();
		mysqlDeletePegiOrpheline();
		mysqlDeleteEsrbOrpheline();
		mysqlDeleteCeroOrpheline();
		mysqlDeleteJeuVersionPlateformeImageOrpheline();
		
		mysqlDeleteJeuVersionPlateformeVideoOrpheline();
		
		
		
		mysqlUpdateJeuDate($_GET["id_jeu"]);
		
		header("Location:  administration.php?jeu=edit&id_jeu=".$_GET["id_jeu"]."&record=ok#tableau_version");
	}
	else if($_GET['submit_jeu_version_plateforme']=="add_region"){
		$resultCount = mysqlCountJeuVersionRegionByJeuVersionPlateformeIDAndRegion($_GET['id_jeu_version_plateforme'], $_GET['region']);
		$dataCount = mysql_fetch_array($resultCount);
		if($dataCount['count'] == 0){
		$id = mysqlInsertJeuVersionRegion($_GET['id_jeu_version_plateforme'], '', $_GET['region'], '', '', '', '');
		if($_GET['region']=='pal'){
			mysqlInsertPegi($id);
		}
		else if($_GET['region']=='jp'){
			mysqlInsertCero($id);
		}
		else if($_GET['region']=='us'){
			mysqlInsertEsrb($id);
		}
		mysqlUpdateJeuDate($_GET["id_jeu"]);
		header("Location:  administration.php?jeu=edit&id_jeu=".$_GET["id_jeu"]."#tableau_version");
		}
		else{
		mysqlUpdateJeuDate($_GET["id_jeu"]);
		header("Location:  administration.php?jeu=edit&id_jeu=".$_GET["id_jeu"]."#tableau_version");
		}
		
	}

}

}
else{
	header("Location:  ../index.php");
}
?>