<?php
require_once('mysql_bdd_connect.php'); 
global $host,$user,$pass,$base;
$link = mysql_connect($host, $user, $pass);
if (!$link) {
    die('Connexion impossible : ' . mysql_error());
}

$sql = 'CREATE DATABASE  '.$base.' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo 'Base de données '.$base.' créée correctement<br/>';
} else {
    echo 'Erreur lors de la création de la base de données '.$base.' : ' . mysql_error() . "<br/>";
}




$sql = 'CREATE TABLE  '.$base.'.2015_membre (
id_membre INT NOT NULL AUTO_INCREMENT ,
pseudo VARCHAR( 200 ) NOT NULL ,
pass_md5 VARCHAR( 200 ) NOT NULL ,
email VARCHAR( 200 ) NOT NULL ,
groupe VARCHAR( 200 ) NOT NULL ,
membre_date_inscription DATETIME NOT NULL ,
membre_date_modif DATETIME NOT NULL ,
membre_date_derniere_connexion DATETIME NOT NULL ,
cle VARCHAR(32) NOT NULL ,
PRIMARY KEY  (id_membre)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_membre créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_membre: ' . mysql_error() . "<br/>";
}
/*

$sql = 'INSERT INTO '.$base.'.2015_membre (id_membre, pseudo, pass_md5, email, groupe, membre_date_inscription, membre_date_modif, membre_date_derniere_connexion, cle) VALUES (NULL, "admin", "admin", "", "admin", "2014-12-05 00:00:00", "2014-12-05 00:00:00", "2014-12-05 00:00:00", "")';

if (mysql_query($sql, $link)) {
    echo 'compte admin créée -> login: admin / password: admin<br/>';
} else {
    echo 'Erreur lors de la création du compte admin : ' . mysql_error() . "<br/>";
}

*/
$sql = 'CREATE TABLE  '.$base.'.2015_developpeur (
id_developpeur INT NOT NULL AUTO_INCREMENT ,
developpeur_nom VARCHAR( 200 ) NOT NULL ,
developpeur_date_creation DATETIME NOT NULL ,
developpeur_date_modif DATETIME NOT NULL ,
developpeur_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (  id_developpeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_developpeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_developpeur: ' . mysql_error() . "<br/>";
}




$sql = 'CREATE TABLE  '.$base.'.2015_editeur (
id_editeur INT NOT NULL AUTO_INCREMENT ,
editeur_nom VARCHAR( 200 ) NOT NULL ,
editeur_date_creation DATETIME NOT NULL ,
editeur_date_modif DATETIME NOT NULL ,
editeur_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_editeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_editeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_editeur: ' . mysql_error() . "<br/>";
}




$sql = 'CREATE TABLE  '.$base.'.2015_constructeur (
id_constructeur INT NOT NULL AUTO_INCREMENT ,
constructeur_nom VARCHAR( 200 ) NOT NULL ,
constructeur_date_creation DATETIME NOT NULL ,
constructeur_date_modif DATETIME NOT NULL ,
constructeur_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_constructeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_constructeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_constructeur: ' . mysql_error() . "<br/>";
}


$sql = 'CREATE TABLE  '.$base.'.2015_plateforme (
id_plateforme INT NOT NULL AUTO_INCREMENT ,
id_constructeur INT NOT NULL ,
plateforme_nom_generique VARCHAR( 200 ) NOT NULL ,
plateforme_image_generique VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

plateforme_description TEXT NOT NULL ,
retro TINYINT NOT NULL DEFAULT  "0",
plateforme_date_creation DATETIME NOT NULL ,
plateforme_date_modif DATETIME NOT NULL ,
plateforme_dossier VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
PRIMARY KEY (  id_plateforme )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_plateforme créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_plateforme: ' . mysql_error() . "<br/>";
}



$sql = 'CREATE TABLE  '.$base.'.2015_plateforme_version (
id_plateforme_version INT NOT NULL AUTO_INCREMENT ,
id_plateforme INT NOT NULL ,
plateforme_version_nom VARCHAR( 200 ) NOT NULL ,
date_lancement DATE NOT NULL ,
date_fin DATE NOT NULL ,
plateforme_version_description TEXT NOT NULL ,
plateforme_version_date_creation DATETIME NOT NULL ,
plateforme_version_date_modif DATETIME NOT NULL ,
id_membre INT NOT NULL ,
PRIMARY KEY (  id_plateforme_version )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_plateforme_version créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_plateforme_version: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_plateforme_version_image (
id_plateforme_version_image INT NOT NULL AUTO_INCREMENT ,
id_plateforme_version INT NOT NULL ,
plateforme_version_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
plateforme_version_image_date_creation DATETIME NOT NULL ,
id_membre INT NOT NULL ,
PRIMARY KEY (  id_plateforme_version_image )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_plateforme_version_image créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_plateforme_version_image: ' . mysql_error() . "<br/>";
}


$sql = 'CREATE TABLE  '.$base.'.2015_genre (
id_genre INT NOT NULL AUTO_INCREMENT ,
genre_nom VARCHAR( 200 ) NOT NULL ,
genre_date_creation DATETIME NOT NULL ,
genre_date_modif DATETIME NOT NULL ,
PRIMARY KEY (  id_genre )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_genre créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_genre: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_nombre_joueur (
id_nombre_joueur INT NOT NULL AUTO_INCREMENT ,
nombre_joueur_nom VARCHAR( 200 ) NOT NULL ,
nombre_joueur_date_creation DATETIME NOT NULL ,
nombre_joueur_date_modif DATETIME NOT NULL ,
PRIMARY KEY (  id_nombre_joueur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_nombre_joueur  créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_nombre_joueur : ' . mysql_error() . "<br/>";
}


$sql = 'CREATE TABLE  '.$base.'.2015_categorie_news (
id_categorie_news INT NOT NULL AUTO_INCREMENT ,
categorie_news_nom VARCHAR( 200 ) NOT NULL ,
categorie_news_date_creation DATETIME NOT NULL ,
categorie_news_date_modif DATETIME NOT NULL ,
PRIMARY KEY (  id_categorie_news )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_categorie_newscréée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_categorie_news: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_sous_categorie_news (
id_sous_categorie_news INT NOT NULL AUTO_INCREMENT ,
id_categorie_news INT NOT NULL ,
sous_categorie_news_nom VARCHAR( 200 ) NOT NULL ,
sous_categorie_news_date_creation DATETIME NOT NULL ,
sous_categorie_news_date_modif DATETIME NOT NULL ,
sous_categorie_news_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_sous_categorie_news )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_sous_categorie_news créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_sous_categorie_news: ' . mysql_error() . "<br/>";
}




$sql = 'CREATE TABLE  '.$base.'.2015_partenaire (
id_partenaire INT NOT NULL AUTO_INCREMENT ,
partenaire_nom VARCHAR( 200 ) NOT NULL ,
partenaire_url VARCHAR( 200 ) NOT NULL ,
partenaire_date_creation DATETIME NOT NULL ,
partenaire_date_modif DATETIME NOT NULL ,
partenaire_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_partenaire )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_partenaire créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_partenaire: ' . mysql_error() . "<br/>";
}


$sql = 'CREATE TABLE  '.$base.'.2015_categorie_image (
id_categorie_image INT NOT NULL AUTO_INCREMENT ,
categorie_image_nom VARCHAR( 200 ) NOT NULL ,
categorie_image_date_creation DATETIME NOT NULL ,
categorie_image_date_modif DATETIME NOT NULL ,
PRIMARY KEY (  id_categorie_image )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_categorie_image créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_categorie_image: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_categorie_video (
id_categorie_video INT NOT NULL AUTO_INCREMENT ,
categorie_video_nom VARCHAR( 200 ) NOT NULL ,
categorie_video_date_creation DATETIME NOT NULL ,
categorie_video_date_modif DATETIME NOT NULL ,
PRIMARY KEY (  id_categorie_video )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_categorie_video créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_categorie_video: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_jeu (
id_jeu INT NOT NULL AUTO_INCREMENT ,
id_developpeur INT NOT NULL ,
id_genre INT NOT NULL ,
jeu_nom_generique VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
id_nombre_joueur_offline INT NOT NULL ,
id_nombre_joueur_online INT NOT NULL ,
jeu_descriptif TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
jeu_dossier VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
jeu_date_creation DATETIME NOT NULL ,
jeu_date_modif DATETIME NOT NULL ,
id_membre INT NOT NULL ,

PRIMARY KEY (  id_jeu )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_jeu créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_jeu: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_jeu_version_plateforme (
id_jeu_version_plateforme INT NOT NULL AUTO_INCREMENT ,
id_jeu INT NOT NULL ,
id_plateforme INT NOT NULL ,
jeu_version_plateforme_date_creation DATETIME NOT NULL ,
jeu_version_plateforme_date_modification DATETIME NOT NULL ,
id_membre INT NOT NULL ,
PRIMARY KEY (  id_jeu_version_plateforme )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_jeu_version_plateforme créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_jeu_version_plateforme: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_jeu_version_region (
id_jeu_version_region INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_plateforme INT NOT NULL ,
jeu_region_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
jeu_region VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
jeu_date_sortie DATE NOT NULL ,
id_editeur INT NOT NULL ,
jeu_region_cover VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  "nopicture.jpg",
jeu_region_jaquette VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  "nopicture.jpg",
jeu_version_plateforme_date_creation DATETIME NOT NULL ,
jeu_version_plateforme_date_modification DATETIME NOT NULL ,
id_membre INT NOT NULL ,
PRIMARY KEY (  id_jeu_version_region )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_jeu_version_region créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_jeu_version_region: ' . mysql_error() . "<br/>";
}


$sql = 'CREATE TABLE  '.$base.'.2015_classification_pegi (
id_classification_pegi INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_region INT NOT NULL ,
pegi_3 TINYINT NOT NULL ,
pegi_4 TINYINT NOT NULL ,
pegi_6 TINYINT NOT NULL ,
pegi_7 TINYINT NOT NULL ,
pegi_12 TINYINT NOT NULL ,
pegi_16 TINYINT NOT NULL ,
pegi_18 TINYINT NOT NULL ,
pegi_langage TINYINT NOT NULL ,
pegi_discrimination TINYINT NOT NULL ,
pegi_drogue TINYINT NOT NULL ,
pegi_peur TINYINT NOT NULL ,
pegi_jeux_hasard TINYINT NOT NULL ,
pegi_sexe TINYINT NOT NULL ,
pegi_violence TINYINT NOT NULL ,
pegi_internet TINYINT NOT NULL ,
PRIMARY KEY (  id_classification_pegi )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_classification_pegi créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_classification_pegi: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_classification_cero (
id_classification_cero INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_region INT NOT NULL ,
cero_a TINYINT NOT NULL ,
cero_b TINYINT NOT NULL ,
cero_c TINYINT NOT NULL ,
cero_d TINYINT NOT NULL ,
cero_z TINYINT NOT NULL ,
cero_romance TINYINT NOT NULL ,
cero_sexe TINYINT NOT NULL ,
cero_violence TINYINT NOT NULL ,
cero_horreur TINYINT NOT NULL ,
cero_argent TINYINT NOT NULL ,
cero_crime TINYINT NOT NULL ,
cero_alcool TINYINT NOT NULL ,
cero_drogue TINYINT NOT NULL ,
cero_langage TINYINT NOT NULL ,
PRIMARY KEY (  id_classification_cero )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_classification_cero créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_classification_cero: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_classification_esrb (
id_classification_esrb INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_region INT NOT NULL ,
esrb_c TINYINT NOT NULL ,
esrb_e TINYINT NOT NULL ,
esrb_e10 TINYINT NOT NULL ,
esrb_t TINYINT NOT NULL ,
esrb_m TINYINT NOT NULL ,
esrb_a TINYINT NOT NULL ,
esrb_info TINYINT NOT NULL ,
esrb_location TINYINT NOT NULL ,
esrb_interact TINYINT NOT NULL ,
PRIMARY KEY (  id_classification_esrb )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_classification_esrb créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_classification_esrb: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_jeu_version_plateforme_image (
id_jeu_version_plateforme_image INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_plateforme INT NOT NULL ,
image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
id_categorie_image INT NOT NULL ,
image_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
jeu_version_plateforme_image_date_upload DATETIME NOT NULL ,
id_membre INT NOT NULL ,
PRIMARY KEY (  id_jeu_version_plateforme_image )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';

if (mysql_query($sql, $link)) {
    echo "table 2015_jeu_version_plateforme_image créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_jeu_version_plateforme_image: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_jeu_version_plateforme_video (
id_jeu_version_plateforme_video INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_plateforme INT NOT NULL ,
video_url VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
id_categorie_video INT NOT NULL ,
video_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
jeu_version_plateforme_video_date_upload DATETIME NOT NULL ,
id_membre INT NOT NULL ,
PRIMARY KEY (  id_jeu_version_plateforme_video )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';

if (mysql_query($sql, $link)) {
    echo "table 2015_jeu_version_plateforme_video créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_jeu_version_plateforme_video: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_news (
id_news INT NOT NULL AUTO_INCREMENT ,
news_titre TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
news_corps TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
news_date_creation DATETIME NOT NULL ,               
news_date_modif DATETIME NULL DEFAULT NULL,
news_date_publication DATETIME NULL DEFAULT NULL,
id_membre_createur INT NOT NULL ,
id_membre_modificateur INT NOT NULL ,
PRIMARY KEY (  id_news )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';

if (mysql_query($sql, $link)) {
    echo "table 2015_news créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_news: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_image (
id_news_image INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
url_news_image VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_news_image )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_image créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_image: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_video (
id_news_video INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
url_news_video VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
video_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_news_video )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_video créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_video: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_illustration (
id_news_illustration INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
url_news_illustration VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_news_illustration )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_illustration créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_illustration: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_sous_categorie_news(
id_news_sous_categorie_news INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
id_sous_categorie_news INT NOT NULL ,
PRIMARY KEY (  id_news_sous_categorie_news )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_sous_categorie_news créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_sous_categorie_news: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_plateforme(
id_news_plateforme INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
id_plateforme INT NOT NULL ,
PRIMARY KEY (  id_news_plateforme )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_plateforme créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_plateforme: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_constructeur(
id_news_constructeur INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
id_constructeur INT NOT NULL ,
PRIMARY KEY (  id_news_constructeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_constructeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_constructeur: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_developpeur(
id_news_developpeur INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
id_developpeur INT NOT NULL ,
PRIMARY KEY (  id_news_developpeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_developpeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_developpeur: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_editeur(
id_news_editeur INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
id_editeur INT NOT NULL ,
PRIMARY KEY (  id_news_editeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_editeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_editeur: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_news_jeu_version_plateforme(
id_news_jeu_version_plateforme INT NOT NULL AUTO_INCREMENT ,
id_news INT NOT NULL ,
id_jeu_version_plateforme INT NOT NULL ,
PRIMARY KEY (  id_news_jeu_version_plateforme )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_news_jeu_version_plateforme créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_news_jeu_version_plateforme: ' . mysql_error() . "<br/>";
}

//--------------------------//

$sql = 'CREATE TABLE  '.$base.'.2015_article (
id_article INT NOT NULL AUTO_INCREMENT ,
article_titre TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
article_corps TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
article_date_creation DATETIME NOT NULL ,               
article_date_modif DATETIME NULL DEFAULT NULL,
article_date_publication DATETIME NULL DEFAULT NULL,
id_membre_createur INT NOT NULL ,
id_membre_modificateur INT NOT NULL ,
PRIMARY KEY (  id_article )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';

if (mysql_query($sql, $link)) {
    echo "table 2015_article créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_article: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_image (
id_article_image INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
url_article_image VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_alt VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (  id_article_image )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_image créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_image: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_video (
id_article_video INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
url_article_video VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
video_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_article_video )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_video créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_video: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_illustration (
id_article_illustration INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
url_article_illustration VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_alt VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_article_illustration )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_illustration créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_illustration: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_sous_categorie_news(
id_article_sous_categorie_news INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
id_sous_categorie_news INT NOT NULL ,
PRIMARY KEY (  id_article_sous_categorie_news )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_sous_categorie_news créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_sous_categorie_news: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_plateforme(
id_article_plateforme INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
id_plateforme INT NOT NULL ,
PRIMARY KEY (  id_article_plateforme )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_plateforme créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_plateforme: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_constructeur(
id_article_constructeur INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
id_constructeur INT NOT NULL ,
PRIMARY KEY (  id_article_constructeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_constructeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_constructeur: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_developpeur(
id_article_developpeur INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
id_developpeur INT NOT NULL ,
PRIMARY KEY (  id_article_developpeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_developpeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_developpeur: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_editeur(
id_article_editeur INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
id_editeur INT NOT NULL ,
PRIMARY KEY (  id_article_editeur )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_editeur créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_editeur: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_article_jeu_version_plateforme(
id_article_jeu_version_plateforme INT NOT NULL AUTO_INCREMENT ,
id_article INT NOT NULL ,
id_jeu_version_plateforme INT NOT NULL ,
PRIMARY KEY (  id_article_jeu_version_plateforme )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_article_jeu_version_plateforme créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_article_jeu_version_plateforme: ' . mysql_error() . "<br/>";
}
//----------------------------------------------//
$sql = 'CREATE TABLE  '.$base.'.2015_test (
id_test INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_plateforme INT NOT NULL ,
id_membre_createur INT NOT NULL ,
id_membre_modificateur INT NOT NULL ,
test_date_creation DATETIME NOT NULL ,               
test_date_modif DATETIME NULL DEFAULT NULL,
test_date_publication DATETIME NULL DEFAULT NULL,
PRIMARY KEY (  id_test )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';

if (mysql_query($sql, $link)) {
    echo "table 2015_test créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_test: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE  '.$base.'.2015_test_jeu_version_plateforme (
id_test_jeu_version_plateforme INT NOT NULL AUTO_INCREMENT ,
id_test INT NOT NULL ,
id_jeu_version_plateforme INT NOT NULL ,
test_titre TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
test_corps TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
test_note INT NOT NULL ,
test_plus TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
test_moins TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
id_membre_createur INT NOT NULL ,
id_membre_modificateur INT NOT NULL ,
test_date_creation DATETIME NOT NULL ,               
test_date_modif DATETIME NULL DEFAULT NULL,
PRIMARY KEY (  id_test_jeu_version_plateforme )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';

if (mysql_query($sql, $link)) {
    echo "table 2015_test_jeu_version_plateforme créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_test_jeu_version_plateforme: ' . mysql_error() . "<br/>";
}
//----------------------//
$sql = 'CREATE TABLE '.$base.'.2015_test_image (
id_test_image INT NOT NULL AUTO_INCREMENT ,
id_test INT NOT NULL ,
url_test_image VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_test_image )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_test_image créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_test_image: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_test_video (
id_test_video INT NOT NULL AUTO_INCREMENT ,
id_test INT NOT NULL ,
url_test_video VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
video_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_test_video )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_test_video créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_test_video: ' . mysql_error() . "<br/>";
}

$sql = 'CREATE TABLE '.$base.'.2015_test_illustration (
id_test_illustration INT NOT NULL AUTO_INCREMENT ,
id_test INT NOT NULL ,
url_test_illustration VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
image_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

PRIMARY KEY (  id_test_illustration )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_test_illustration créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_test_illustration: ' . mysql_error() . "<br/>";
}
//-----------------------------//
$sql = 'CREATE TABLE '.$base.'.2015_frontpage_news(
id_frontpage INT NOT NULL AUTO_INCREMENT ,
frontpage_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
frontpage_sous_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
frontpage_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

id_news INT NOT NULL ,
PRIMARY KEY (  id_frontpage )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_frontpage_news créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_frontpage_news: ' . mysql_error() . "<br/>";
}


//----------------------//

$sql = 'CREATE TABLE '.$base.'.2015_frontpage_article(
id_frontpage INT NOT NULL AUTO_INCREMENT ,
frontpage_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
frontpage_sous_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
frontpage_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

id_article INT NOT NULL ,
PRIMARY KEY (  id_frontpage )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_frontpage_article créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_frontpage_article: ' . mysql_error() . "<br/>";
}


//----------------------//


$sql = 'CREATE TABLE '.$base.'.2015_frontpage_test(
id_frontpage INT NOT NULL AUTO_INCREMENT ,
frontpage_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
frontpage_sous_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
frontpage_image_nom VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,

id_test INT NOT NULL ,
PRIMARY KEY (  id_frontpage )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysql_query($sql, $link)) {
    echo "table 2015_frontpage_test créée<br/>";
} else {
    echo 'Erreur lors de la création table 2015_frontpage_test: ' . mysql_error() . "<br/>";
}


//----------------------//
//----------------------------------------------//
$sql = 'CREATE TABLE  '.$base.'.2015_astuce (
id_astuce INT NOT NULL AUTO_INCREMENT ,
id_jeu_version_plateforme INT NOT NULL ,
astuce_titre VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
astuce VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
id_membre_createur INT NOT NULL ,
id_membre_modificateur INT NOT NULL ,
astuce_date_creation DATETIME NOT NULL ,               
astuce_date_modif DATETIME NULL DEFAULT NULL,
astuce_date_publication DATETIME NULL DEFAULT NULL,
PRIMARY KEY (  id_astuce )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci';

if (mysql_query($sql, $link)) {
    echo "table 2015_astuce créée<br/>";
} else {
    echo 'Erreur lors de la création 2015_astuce: ' . mysql_error() . "<br/>";
}

?>
