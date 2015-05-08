<?php
require_once('mysql_bdd_connect.php'); 
require_once('authentification.php');
session_start();

if(getGroupe()=='admin'){ 
     
	if(isset($_GET['id_plateforme'])) {
        // requête qui récupère les jeux en fonction de la plateforme
    	$json = array();

        $requete = 'SELECT j.id_jeu, j.jeu_nom_generique, jvp.id_jeu_version_plateforme 
		FROM 2015_jeu_version_plateforme AS jvp
		LEFT OUTER JOIN 2015_jeu AS j
		ON jvp.id_jeu = j.id_jeu
		WHERE id_plateforme = '.$_GET['id_plateforme'].'

		ORDER BY jeu_nom_generique
		';

		
     	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
     	$result = mysql_query($requete) or die(mysql_error());
     	$i = 0;
		while($data=mysql_fetch_array($result)) {
     	// je remplis un tableau et mettant l'id en index
        	$toSend = $data['jeu_nom_generique'];
        	$json[' '.$data['id_jeu_version_plateforme']][] = $toSend;
    	}
    	// envoi du résultat au success
    	echo json_encode($json);
       
    } 
}
else{
	header("Location:  ../index.php");
}
  




?>