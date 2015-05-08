<?php
session_start();
require_once('authentification.php');

/*---------------------------------------------------------------------*/
/*--------------------------[MENU]-------------------------------------*/
//création des menus sur toutes les pages.
/*---------------------------------------------------------------------*/
function createDivMenu($menu_item_selected){

		$toReturn = '<div id="menudesktop" class="menu">
		<ul class="menu-list">
		<li '.define_class_menu_item_selected($menu_item_selected,"Accueil").'><a href="../index.php">Accueil</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"News").'><a href="../news.php">News</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Tests").'><a href="../tests.php">Tests</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Jeux").'><a href="../jeux.php">Jeux</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Articles").'><a href="../articles.php">Articles</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Planning").'><a href="#">Planning</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Forum").'><a href="#">Forum</a></li>';
		
		if(getGroupe()=="admin"){
		$toReturn .= '<li '.define_class_menu_item_selected($menu_item_selected,"Administration").'><a href="administration.php">Administration</a></li>';
		}
		
		$toReturn .= '</ul></div>';
	
		$toReturn .= '<div id="menusmallscreen" class="menu">
		<ul class="menu-list">
		<li '.define_class_menu_item_selected($menu_item_selected,"Accueil").'><a href="../index.php">Accueil</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"News").'><a href="../news.php">News</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Tests").'><a href="../tests.php">Tests</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Jeux").'><a href="../jeux.php">Jeux</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Articles").'><a href="../articles.php">Articles</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Planning").'><a href="#">Planning</a></li>
		<li '.define_class_menu_item_selected($menu_item_selected,"Forum").'><a href="#">Forum</a></li>';
		
		if(getGroupe()=="admin"){
		$toReturn .= '<li '.define_class_menu_item_selected($menu_item_selected,"Administration").'><a href="administration.php">Administration</a></li>';
		}
		
		$toReturn .= '</ul>
		<div id="menuexpander"></div>
		</div>';
		
		return $toReturn;
}
//fonction appelée depuis la fonction de création du menu, donne à la page selectionné la classe menu-item-selected
function define_class_menu_item_selected($menu_item_selected,$menu_item_toCompare){
	if($menu_item_selected==$menu_item_toCompare){
		return ('class="menu-item-selected"');
	}
	else{}
}	




?>
