<?php
require_once('mysql_bdd_connect.php'); 
session_start();
/*--------------------------------------------------------------------------------------*/
/*-----------------------------[Authentification]---------------------------------------*/
/*--------------------------------------------------------------------------------------*/
//login
if(isset($_POST['pseudo']) && isset($_POST['password']) && !isset($_POST['email']) ){
	
	$json = array();
	
	$requete = 'SELECT count(*) AS count, m.pseudo AS pseudo, m.groupe AS groupe

	FROM 2015_membre AS m WHERE pseudo="'.mysql_escape_string($_POST['pseudo']).'" AND pass_md5="'.mysql_escape_string($_POST['password']).'"';
    
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	$result = mysql_query($requete) or die(mysql_error());
	$data = mysql_fetch_array($result);
	mysql_free_result($data);
	mysql_close();
    
	if ($data[count] == 1) {
		$_SESSION['pseudo'] = $data['pseudo'];
		//$_SESSION['groupe'] = $data['groupe'];
		//$json['pseudo'] = $data['pseudo'];
		//$json['goupe'] = $data['groupe'];
		echo 'ok';
	}
	else if ($data[count] == 0) {
		echo 'nok';
	}
}
//test pseudo
else if(isset($_POST['pseudo']) && !isset($_POST['password']) && !isset($_POST['email'])){
	
	$requete = 'SELECT count(*) AS count
	FROM 2015_membre AS m WHERE pseudo="'.mysql_escape_string(trim($_POST['pseudo'])).'"';
	
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	$result = mysql_query($requete) or die(mysql_error());
	$data = mysql_fetch_array($result);
	mysql_free_result($data);
	mysql_close();
	
	if ($data['count'] >= 1) {
		//$json['pseudo'] = "exist";
		echo "exist";
	}
	else if ($data['count'] == 0) {
		//$json['pseudo'] = "notexist";
		echo "notexist";
	}


}
//inscription
else if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){
	//$cle = md5(microtime(TRUE)*100000);
	//echo $cle;
	$requete = "INSERT INTO 2015_membre VALUES ('','".$cle."','".$_POST['password']."','".$_POST['email']."','en attente',NOW(),NOW(),NOW(),'".$cle."')";
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	$result = mysql_query($requete);
	
	if($result){
	echo "ok";
	}
	else{
	echo "nok";
	}
	
	mysql_free_result($req);
	mysql_close();

}

function testAuthentification(){
	if(isset($_SESSION['pseudo'])){
		return true;
	}
	else{
		return false;
	}
}

function getGroupe(){

global $host,$user,$pass,$base;


	
	if($_SESSION['pseudo']){
		$requete = 'SELECT m.groupe AS groupe
		FROM 2015_membre AS m WHERE pseudo="'.mysql_escape_string(trim($_SESSION['pseudo'])).'"';
	
		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
		$result = mysql_query($requete) or die(mysql_error());
		$data = mysql_fetch_array($result);
		mysql_free_result($data);
		mysql_close();
		
		return $data['groupe'];
	}
	else{
		return "";
	}
}

function getID(){

global $host,$user,$pass,$base;

	
	
	if($_SESSION['pseudo']){
		$requete = 'SELECT m.id_membre AS id_membre
		FROM 2015_membre AS m WHERE pseudo="'.mysql_escape_string(trim($_SESSION['pseudo'])).'"';
		//echo $requete;
		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
		$result = mysql_query($requete) or die(mysql_error());
		$data = mysql_fetch_array($result);
		mysql_free_result($data);
		mysql_close();
		
		return $data['id_membre'];
	}
	else{
		return "";
	}
	
}



?>