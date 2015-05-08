<?php 
require_once('bloc_page_jeu.php');
require_once('bloc_menu.php');
require_once('bloc_login.php');
require_once('authentification.php');
require_once('background_style.php');

session_start();

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
<link rel="stylesheet" href="styles/style_page.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="styles/paginate.css" type="text/css" media="screen"/>

<link rel="stylesheet" type="text/css" href="styles/style_authentification_popup.css" /> <!-- formulaire authentification -->
<?php
echo getBackgroundStyle();
?>

<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:100' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Jockey+One|Russo+One|Hammersmith+One|Squada+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Headland+One|Coustard|Rokkitt&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
<![endif]-->

</head>

<body>

<!-- ++++++++++++++++++++++formulaire d'identification++++++++++++++++++++++++++ -->
<div class="login_form_container">
	<div id="login_form_content">
        <?php
        echo createLoginForm();
    	echo createInscriptionForm();
        ?>
        <div id="background-on-popup"></div>
    </div>
</div>
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
			<?php echo createDivMenu("Jeux"); ?>
			</div><!-- fin du menucontainer -->
			
			<div id="contentcontainer"><!-- debut du contentcontainer-->
				<div id="left_bar"><!-- debut du main content left-->
				<?php 
				
				if(isset($_GET['id_jeu_version_plateforme']) && isset($_GET['jeu_region'])){
				
					echo createDivFicheJeuWithIdJeu($_GET['id_jeu_version_plateforme'],$_GET['jeu_region']);
					echo createDivTestJeu($_GET['id_jeu_version_plateforme']);
				} 
				else{
					echo createDivAllJeuWithPageNumber($_GET['page']);
				}
				?>
				</div><!-- fin du content main left -->
				
				<div id="right_bar"><!-- debut du right_bar right-->
				<?php echo createDivPub(); ?>
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
<script type="text/javascript" src="js/jquery.flexslider.js"></script>
<script type="text/javascript" src="js/menu_smartphone.js"></script> <!-- menu accordeon pour la version smartphone -->
<script type="text/javascript" src="js/login_popup.js"></script> <!-- formulaire d'authentification -->

<script type="text/javascript">
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    slideshowSpeed: 4000,
    pauseOnAction: false  
  });
});

</script>

</body>

</html>