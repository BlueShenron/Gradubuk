<?php
require_once('mysql_bdd_connect.php'); 

if(isset($_GET['log']) && isset($_GET['key'])){
 
	$connexion = connexion();
	$request = 'SELECT count(*) AS count, m.cle, m.groupe
			FROM  2015_membre AS m
			WHERE pseudo = "'.mysql_real_escape_string(trim($_GET['log'])).'"';
		
	$result = mysql_query($request) or die(mysql_error());
	$data = mysql_fetch_array($result);
	mysql_close($connexion);

	if($data['count']!=0){
		if($data['groupe']!='en attente'){
			echo "Votre compte est déjà actif !";
		}
		else{
			if($data['cle']==$_GET['key']){
				$connexion = connexion();
				$request2 = 'UPDATE 2015_membre
							SET 
							groupe="membre" ,  
							membre_date_modif=NOW()
							WHERE pseudo = "'.mysql_real_escape_string(trim($_GET['log'])).'"';
							//echo $request;
				$result2 = mysql_query($request2) or die(mysql_error());
				mysql_close($connexion);
				echo "Votre compte a bien été activé !";

			}
			else{
	    	    echo "Erreur ! Votre compte ne peut être activé...";
	    	}
	    }
	}
	else{
		echo "Erreur ! Votre compte ne peut être activé...";
	}
	
}
else{
	header("Location:  index.php");
}

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}



?>