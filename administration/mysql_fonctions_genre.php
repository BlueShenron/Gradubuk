<?php
require_once('mysql_bdd_connect.php'); 

function connexion(){
	global $host,$user,$pass,$base;
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	return $connexion;
}

function mysqlSelectAllGenres(){
$connexion = connexion();

$request = 'SELECT * 
			FROM  2015_genre 
			ORDER BY genre_nom';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectAllGenresWithPageNumber($page, $order, $nb_element_par_page){

$connexion = connexion();
$limit=$nb_element_par_page;
$offset=$page*$nb_element_par_page-$nb_element_par_page;
$request = 'SELECT * 
			FROM  2015_genre
			ORDER BY '.mysql_real_escape_string(trim($order)).' ';
if($order != 'genre_nom'){$request .='DESC ';}
$request .=	'LIMIT '.mysql_real_escape_string(trim($limit)).' OFFSET '.mysql_real_escape_string(trim($offset)).'';
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlInsertGenre($genre_name){
$connexion = connexion();

$request = "INSERT INTO 2015_genre
			VALUES ('','".mysql_real_escape_string(trim($genre_name))."',NOW(),NOW())";
			
$result = mysql_query($request) or die(mysql_error());
//on retourne l'id de l'élément enregistré.
return mysql_insert_id();
mysql_close($connexion);
}

function mysqlDeleteGenreByID($id){
$connexion = connexion();

$request = 'DELETE
			FROM 2015_genre
			WHERE id_genre = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}

function mysqlSelectGenreByID($id){
$connexion = connexion();

$request = 'SELECT * 
			FROM 2015_genre 
			WHERE id_genre = \''.mysql_real_escape_string(trim($id)).'\'
			';
			
$result = mysql_query($request) or die(mysql_error());
return $result;
mysql_close($connexion);
}


function mysqlUpdateGenre($genre_name, $genre_id){
$connexion = connexion();
$request = 'UPDATE 2015_genre
			SET genre_nom="'.mysql_real_escape_string(trim($genre_name)).'" , 
			genre_date_modif=NOW()
			WHERE id_genre = '.mysql_real_escape_string(trim($genre_id)).'';
$result = mysql_query($request) or die(mysql_error());
mysql_close($connexion);
}
?>