<?php 
//require_once('bloc_page_index.php');
require_once('bloc_menu.php');
require_once('bloc_login.php');
require_once('authentification.php');
require_once('admin_form_menu.php');
require_once('background_style.php');

session_start();
if(getGroupe()!='admin'){
	header("Location:  ../index.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SEGA MAG</title>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="fr,en" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet" href="styles/resetcss.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="styles/style_global.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="styles/style_admin_menu.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="styles/style_admin_panel.css" type="text/css" media="screen"/>
<?php
echo getBackgroundStyle();
?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>


<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:100' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Jockey+One|Russo+One|Hammersmith+One|Squada+One' rel='stylesheet' type='text/css'>

<!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
<![endif]-->


</head>

<body>

<!-- ++++++++++++++++++++++formulaire d'identification++++++++++++++++++++++++++ -->

<!-- ++++++++++++++++++++++formulaire d'identification++++++++++++++++++++++++++ -->



	<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	<div id="wrap"><!-- debut du wrap pour le stick to bottom footer-->
	
		<div id="maincontainer"><!-- debut du maincontainer-->
		
			<div id="headercontainer"><!-- debut du headercontainer-->
				<h1>segamag</h1>
				<div id="logincontainer"><!-- div bloc login -->
				<?php echo createLoginButton() ?>
				</div><!-- fin div bloc login -->
			</div><!-- fin du headercontainer -->
			
			<div id="menucontainer"><!-- debut du headercontainer-->
			<?php echo createDivMenu("Admin. Avancée"); ?>
			</div><!-- fin du menucontainer -->
			
			<div id="contentcontainer"><!-- debut du contentcontainer-->
				<div id="left_bar"><!-- debut du main content left-->
				
					<div id="admin_menu"><!-- debut du main content left-->
					<?php
						echo createMenuAdministration();
					?>
					</div>
				
				</div><!-- fin du content main left -->
				
				<div id="right_bar"><!-- debut du right_bar right-->
					<?php
					echo createAdminForm();
					?>
				
				</div><!-- fin du right_bar right -->		
			</div><!-- fin du contentcontainer -->
			
		</div><!-- fin du maincontainer -->
	
	</div><!-- fin du wrap pour le stick to bottom footer-->
	<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

	<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	<div id="footer"><!-- debut du footer-->
	<p>ici se trouve le footer</p>
	</div><!-- fin du footer-->
	<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
<script type="text/javascript" src="js/menu_smartphone.js"></script> <!-- menu accordeon pour la version smartphone -->
<script type="text/javascript" src="js/admin_menu.js"></script>
<script type="text/javascript" src="js/admin_form.js"></script> <!-- attache le datepicker, gere les peggis -->
<script type="text/javascript" src="js/admin_page_selector.js"></script> <!-- gere le bouton de selections des pages et les filres de tris -->
<script type="text/javascript" src="js/admin_liste_recherche_dynamique.js"></script> <!-- gere le remplissage dynamique des jeux dans la liste -->
<?php
if(isset($_GET['news'])){
echo '<script type="text/javascript" src="js/admin_liste_dynamique_news.js"></script> <!-- gere lajout de categorie pou les news -->';
}
else if(isset($_GET['article'])){
echo '<script type="text/javascript" src="js/admin_liste_dynamique_article.js"></script> <!-- gere lajout de categorie pou les news -->';
}
?>

<!-- ++++++ time picker +++++++ -->
<link rel="stylesheet" type="text/css" href="js/datetimepicker-master/jquery.datetimepicker.css"/ >
<script src="js/datetimepicker-master/jquery.js"></script>
<script src="js/datetimepicker-master/jquery.datetimepicker.js"></script>
<!-- ++++++ time picker +++++++ -->
</body>

</html>