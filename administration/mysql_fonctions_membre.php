<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllMembres(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_membre 
			ORDER BY pseudo';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllMembresWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT m.id_membre, m.pseudo, DATE_FORMAT(m.membre_date_inscription,"%d %b %Y - %H:%i") AS membre_date_inscription, DATE_FORMAT(m.membre_date_derniere_connexion,"%d %b %Y - %h:%i") AS membre_date_derniere_connexion, m.email, m.groupe
			FROM  2015_membre AS m
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'pseudo'){$request .='DESC ';}

$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertMembre($membre_name,$membre_url ){
$connexion = connexion();

$request = "INSERT INTO 2015_membre
			VALUES ('','".mysql_real_escape_string(trim($membre_name))."','".mysql_real_escape_string(trim($membre_url))."',NOW(),NOW())";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteMembreByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_membre
			WHERE id_membre = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectMembreByID($id){
$connexion = connexion();

$request = 'SELECT * 
			FROM 2015_membre 
			WHERE id_membre = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlUpdateMembre($pseudo, $email, $groupe, $id_membre){
$connexion = connexion();
$request = 'UPDATE 2015_membre
			SET 
			pseudo="'.mysql_real_escape_string(trim($pseudo)).'" , 
			email="'.mysql_real_escape_string(trim($email)).'" ,
			groupe="'.mysql_real_escape_string(trim($groupe)).'" ,  
			membre_date_modif=NOW()
			WHERE id_membre = '.mysql_real_escape_string(trim($id_membre)).'';
//echo $request;
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}
?>