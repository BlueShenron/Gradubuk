<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllNombreJoueurs(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_nombre_joueur 
			ORDER BY nombre_joueur_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllNombreJoueursWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT * 
			FROM  2015_nombre_joueur
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'nombre_joueur_nom'){$request .='DESC ';}
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertNombreJoueur($nombre_joueur_name){
$connexion = connexion();

$request = "INSERT INTO 2015_nombre_joueur
			VALUES ('','".mysql_real_escape_string(trim($nombre_joueur_name))."',NOW(),NOW())";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteNombreJoueurByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_nombre_joueur
			WHERE id_nombre_joueur = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectNombreJoueurByID($id){
$connexion = connexion();

$request = 'SELECT * 
			FROM 2015_nombre_joueur 
			WHERE id_nombre_joueur = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlUpdateNombreJoueur($nombre_joueur_name, $nombre_joueur_id){
$connexion = connexion();
$request = 'UPDATE 2015_nombre_joueur
			SET nombre_joueur_nom="'.mysql_real_escape_string(trim($nombre_joueur_name)).'" , 
			nombre_joueur_date_modif=NOW()
			WHERE id_nombre_joueur = '.mysql_real_escape_string(trim($nombre_joueur_id)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}
?>