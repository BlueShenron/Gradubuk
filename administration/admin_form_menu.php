<?php

// ====== on ne charge que ce qui est necessaire ===== //
if(isset($_GET['developpeur'])){
require_once('admin_traitement_developpeur.php'); 
require_once('admin_form_developpeur.php'); 
}
else if(isset($_GET['editeur'])){
require_once('admin_traitement_editeur.php'); 
require_once('admin_form_editeur.php'); 
}
else if(isset($_GET['constructeur'])){
require 'admin_traitement_constructeur.php'; 
require 'admin_form_constructeur.php'; 
}
else if(isset($_GET['plateforme'])){
require 'admin_traitement_plateforme.php'; 
require 'admin_form_plateforme.php'; 

}
else if(isset($_GET['plateforme_version']) || isset($_GET['plateforme_version_picture'])){
require 'admin_traitement_plateforme_version.php'; 
require 'admin_form_plateforme_version.php'; 
}
else if(isset($_GET['genre'])){
require 'admin_traitement_genre.php'; 
require 'admin_form_genre.php'; 
}
else if(isset($_GET['nombre_joueur'])){
require 'admin_traitement_nombre_joueur.php'; 
require 'admin_form_nombre_joueur.php'; 
}
else if(isset($_GET['sous_categorie_news'])){
require 'admin_traitement_sous_categorie_news.php'; 
require 'admin_form_sous_categorie_news.php'; 
}
else if(isset($_GET['categorie_news'])){
require 'admin_traitement_categorie_news.php'; 
require 'admin_form_categorie_news.php'; 
}
else if(isset($_GET['categorie_image'])){
require 'admin_traitement_categorie_image.php'; 
require 'admin_form_categorie_image.php'; 
}
else if(isset($_GET['categorie_video'])){
require 'admin_traitement_categorie_video.php'; 
require 'admin_form_categorie_video.php'; 
}
else if(isset($_GET['partenaire'])){
require 'admin_traitement_partenaire.php'; 
require 'admin_form_partenaire.php'; 
}
else if(isset($_GET['membre'])){
require 'admin_traitement_membre.php'; 
require 'admin_form_membre.php'; 
}
else if(isset($_GET['jeu'])){
require 'admin_traitement_jeu.php'; 
require 'admin_form_jeu.php';
}
else if(isset($_GET['jeu_version_region'])){
require 'admin_traitement_jeu_version_region.php'; 
require 'admin_form_jeu_version_region.php';
}
else if(isset($_GET['jeu_version_plateforme_image'])){
require 'admin_traitement_jeu_version_plateforme_image.php'; 
require 'admin_form_jeu_version_plateforme_image.php';
}
else if(isset($_GET['jeu_version_plateforme_video'])){
require 'admin_traitement_jeu_version_plateforme_video.php'; 
require 'admin_form_jeu_version_plateforme_video.php';
}
else if(isset($_GET['news'])){
require 'admin_traitement_news.php'; 
require 'admin_form_news.php'; 
}
else if(isset($_GET['news_photo'])){
require 'admin_traitement_news_photo.php'; 
require 'admin_form_news_photo.php'; 
}
else if(isset($_GET['article'])){
//require 'admin_traitement_article.php'; 
require 'admin_form_article.php'; 
}
else if(isset($_GET['article_photo'])){
require 'admin_traitement_article_photo.php'; 
require 'admin_form_article_photo.php'; 
}
else if(isset($_GET['test'])||isset($_GET['test_jeu_version_plateforme'])){
require 'admin_traitement_test.php'; 
require 'admin_form_test.php'; 
}
else if(isset($_GET['frontpage_news'])){
require 'admin_traitement_frontpage_news.php'; 
require 'admin_form_frontpage_news.php'; 
}
else if(isset($_GET['frontpage_article'])){
require 'admin_traitement_frontpage_article.php'; 
require 'admin_form_frontpage_article.php'; 
}
else if(isset($_GET['frontpage_test'])){
require 'admin_traitement_frontpage_test.php'; 
require 'admin_form_frontpage_test.php'; 
}
else if(isset($_GET['astuce'])){
require 'admin_traitement_astuce.php'; 
require 'admin_form_astuce.php'; 
}


// ====== la création du formulaire d'admin ===== //
function createMenuAdministration(){
	$toReturn ='';
	
	
	$toReturn .='<ul>';
	
	//-----------------------//
	$toReturn .='<li><span id="menu_admin_classique">administration classique</span>';
	$toReturn .='<div id="sub_menu_admin_classique">';
	$toReturn .='<ul>';
	
		$toReturn .='<li><span><a href="administration.php?jeu=gestion&page=1&order=jeu_date_modif"';
			if(isset($_GET['jeu']) || isset($_GET['jeu_version_region']) || isset($_GET['jeu_version_plateforme_image']) || isset($_GET['jeu_version_plateforme_video'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>jeux</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?news=gestion&page=1&order=news_date_modif"';
			if(isset($_GET['news']) || isset($_GET['frontpage_news'])|| isset($_GET['news_photo'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>news</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?article=gestion&page=1&order=article_date_modif"';
			if(isset($_GET['article']) || isset($_GET['frontpage_article']) || isset($_GET['article_photo'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>articles</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?test=gestion&page=1&order=test_date_modif"';
			if(isset($_GET['test']) || isset($_GET['frontpage_test'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>tests</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?astuce=gestion&page=1&order=astuce_date_modif"';
			if(isset($_GET['astuce'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>astuces</a></span></li>';
	
	$toReturn .='</ul>';
	$toReturn .='</div>';
	$toReturn .='</li>';
	//-----------------------//

	
	//-----------------------//
	$toReturn .='<li><span id="menu_admin_advance">administration avancée</span>';
	$toReturn .='<div class="avoidflash" id="sub_menu_admin_advance">';
	$toReturn .='<ul>';	
		
		$toReturn .='<li><span><a href="administration.php?developpeur=gestion&page=1&order=developpeur_date_modif"';
			if(isset($_GET['developpeur'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>développeurs</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?editeur=gestion&page=1&order=editeur_date_modif"';
			if(isset($_GET['editeur'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>éditeurs</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?constructeur=gestion&page=1&order=constructeur_date_modif"';
			if(isset($_GET['constructeur'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>constructeurs</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?plateforme=gestion&page=1&order=plateforme_date_modif"';
			if(isset($_GET['plateforme'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>plateformes</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?genre=gestion&page=1&order=genre_date_modif"';
			if(isset($_GET['genre'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>genres</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?nombre_joueur=gestion&page=1&order=nombre_joueur_date_modif"';
			if(isset($_GET['nombre_joueur'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>nombres de joueurs</a></span></li>';
		
		/*
		$toReturn .='<li><span><a href="administration.php?famille_categorie_news=add&page=1&order=famille_categorie_news_date_modif"';
			if(isset($_GET['famille_categorie_news'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>familles catégories news</a></span></li>';
		*/
		
		$toReturn .='<li><span><a href="administration.php?categorie_news=gestion&page=1&order=categorie_news_date_modif"';
			if(isset($_GET['categorie_news'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>catégories news</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?categorie_image=gestion&page=1&order=categorie_image_date_modif"';
			if(isset($_GET['categorie_image'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>catégories images</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?categorie_video=gestion&page=1&order=categorie_video_date_modif"';
			if(isset($_GET['categorie_video'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>catégories vidéos</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?partenaire=gestion&page=1&order=partenaire_date_modif"';
			if(isset($_GET['partenaire'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>partenaires</a></span></li>';
		
		$toReturn .='<li><span><a href="administration.php?membre=gestion&page=1&order=membre_date_modif"';
			if(isset($_GET['membre'])){
			$toReturn .=' class="menu_selected" ';
			}
		$toReturn .='>membres</a></span></li>';
	$toReturn .='</ul>';	
	$toReturn .='</div>';
	$toReturn .='</li>';
	//-----------------------//


	
	$toReturn .='</ul>';

	return $toReturn;
}


// ====== ici on appelle la fonction qui créera la formulaire admin ===== //
function createAdminForm(){
	if ($_GET['developpeur'] == "gestion"){
		return createDeveloppeurGestionForm();
	}
	else if ($_GET['developpeur'] == "add"){
		return createDeveloppeurAddForm();
	}
	else if($_GET['developpeur'] == "edit"){
		return createDeveloppeurEditForm();
	}
	else if ($_GET['editeur'] == "gestion"){
		return createEditeurGestionForm();
	}
	else if ($_GET['editeur'] == "add"){
		return createEditeurAddForm();
	}
	else if($_GET['editeur'] == "edit"){
		return createEditeurEditForm();
	}
	else if ($_GET['constructeur'] == "gestion"){
		return createConstructeurGestionForm();
	}
	else if ($_GET['constructeur'] == "add"){
		return createConstructeurAddForm();
	}
	else if($_GET['constructeur'] == "edit"){
		return createConstructeurEditForm();
	}
	else if ($_GET['plateforme'] == "gestion"){
		return createPlateformeGestionForm();
	}
	else if ($_GET['plateforme'] == "add"){
		return createPlateformeAddForm();
	}
	else if($_GET['plateforme'] == "edit"){
		return createPlateformeEditForm();
	}
	else if ($_GET['genre'] == "gestion"){
		return createGenreGestionForm();
	}
	else if ($_GET['genre'] == "add"){
		return createGenreAddForm();
	}
	else if ($_GET['genre'] == "edit"){
		return createGenreEditForm();
	}
	else if ($_GET['plateforme_version'] == "add"){
		return createPlateformeVersionAddForm();
	}
	else if($_GET['plateforme_version'] == "edit"){
		return createPlateformeVersionEditForm();
	}
	else if ($_GET['plateforme_version_picture'] == "add"){
		return createPlateformeVersionPictureAddForm();
	}
	else if($_GET['plateforme_version_picture'] == "edit"){
		return createPlateformeVersionPictureEditForm();
	}
	else if ($_GET['nombre_joueur'] == "gestion"){
		//return 'iiii';
		return createNombreJoueurGestionForm();
	}
	else if ($_GET['nombre_joueur'] == "add"){
		//return 'iiii';
		return createNombreJoueurAddForm();
	}
	else if ($_GET['nombre_joueur'] == "edit"){
		return createNombreJoueurEditForm();
	}
	else if ($_GET['categorie_news'] == "gestion"){
		return createCategorieNewsGestionForm();
	}
	else if ($_GET['categorie_news'] == "add"){
		return createCategorieNewsAddForm();
	}
	else if ($_GET['categorie_news'] == "edit"){
		return createCategorieNewsEditForm();
	}
	else if ($_GET['categorie_image'] == "gestion"){
		return createCategorieImageGestionForm();
	}
	else if ($_GET['categorie_image'] == "add"){
		return createCategorieImageAddForm();
	}
	else if ($_GET['categorie_image'] == "edit"){
		return createCategorieImageEditForm();
	}
	else if ($_GET['categorie_video'] == "gestion"){
		return createCategorieVideoGestionForm();
	}
	else if ($_GET['categorie_video'] == "add"){
		return createCategorieVideoAddForm();
	}
	else if ($_GET['categorie_video'] == "edit"){
		return createCategorieVideoEditForm();
	}
	
	else if ($_GET['sous_categorie_news'] == "add"){
		return createSousCategorieNewsAddForm();
	}
	else if ($_GET['sous_categorie_news'] == "edit"){
		return createSousCategorieNewsEditForm();
	}
	else if ($_GET['partenaire'] == "gestion"){
		return createPartenaireGestionForm();
	}
	else if ($_GET['partenaire'] == "add"){
		return createPartenaireAddForm();
	}
	else if ($_GET['partenaire'] == "edit"){
		return createPartenaireEditForm();
	}
	else if ($_GET['membre'] == "gestion"){
		return createMembreGestionForm();
	}
	else if ($_GET['membre'] == "edit"){
		return createMembreEditForm();
	}
	else if ($_GET['jeu'] == "add"){
		return createJeuAddForm();
	}
	else if ($_GET['jeu'] == "gestion"){
		return createJeuGestionForm();
	}
	else if ($_GET['jeu'] == "edit"){
		return createJeuEditForm();
	}
	else if ($_GET['jeu_version_region'] == "add"){
		return createJeuVersionRegionAddForm();
	}
	else if ($_GET['jeu_version_region'] == "edit"){
		return createJeuVersionRegionEditForm();
	}
	else if ($_GET['jeu_version_plateforme_image'] == "add"){
		return createJeuVersionPlateformeImageAddForm();
	}
	else if ($_GET['jeu_version_plateforme_image'] == "edit"){
		return createJeuVersionPlateformeImageEditForm();
	}
	else if ($_GET['jeu_version_plateforme_video'] == "add"){
		return createJeuVersionPlateformeVideoAddForm();
	}
	else if ($_GET['jeu_version_plateforme_video'] == "edit"){
		return createJeuVersionPlateformeVideoEditForm();
	}
	else if ($_GET['news'] == "gestion"){
		//echo 'iii';
		return createNewsGestionForm();
	}
	
	else if ($_GET['news'] == "add"){
		return createNewsAddForm();
	}
	else if ($_GET['news'] == "edit"){
		return createNewsEditForm();
	}
	else if ($_GET['news_photo'] == "gestion"){
		return createNewsPhotoGestionForm();
	}
	else if ($_GET['news_photo'] == "add"){
		return createNewsPhotoAddForm();
	}
	else if ($_GET['article'] == "gestion"){
		//echo 'iii';
		return createArticleGestionForm();
	}
	else if ($_GET['article'] == "add"){
		return createArticleAddForm();
	}
	else if ($_GET['article'] == "edit"){
		return createArticleEditForm();
	}
	else if ($_GET['article_photo'] == "gestion"){
		return createArticlePhotoGestionForm();
	}
	else if ($_GET['article_photo'] == "add"){
		return createArticlePhotoAddForm();
	}
	else if ($_GET['article_photo'] == "edit"){
		return createArticlePhotoEditForm();
	}

	else if ($_GET['test'] == "gestion"){
		//echo 'iii';
		return createTestGestionForm();
	}
	else if ($_GET['test'] == "add"){
		return createTestAddForm();
	}
	else if ($_GET['test'] == "edit"){
		return createTestEditForm();
	}
	else if ($_GET['test_jeu_version_plateforme'] == "edit"){
		return createTestJeuVersionPlateformeEditForm();
	}
	else if ($_GET['frontpage_news'] == "add"){
		return createFrontpageNewsAddForm();
	}
	else if ($_GET['frontpage_news'] == "edit"){
		return createFrontpageNewsEditForm();
	}
	else if ($_GET['frontpage_article'] == "add"){
		return createFrontpageArticleAddForm();
	}
	else if ($_GET['frontpage_article'] == "edit"){
		return createFrontpageArticleEditForm();
	}
	else if ($_GET['frontpage_test'] == "add"){
		//echo 'iiii';
		return createFrontpageTestAddForm();
	}
	else if ($_GET['frontpage_test'] == "edit"){
		return createFrontpageTestEditForm();
	}
	else if ($_GET['astuce'] == "add"){
		return createAstuceAddForm();
	}
	else if ($_GET['astuce'] == "edit"){
		return createAstuceEditForm();
	}
	else if ($_GET['astuce'] == "gestion"){
		return createAstuceGestionForm();
	}

	

}


//echo 'ici';
?>