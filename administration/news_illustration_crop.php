<?php

require_once('mysql_fonctions_news_illustration_crop.php');
require_once('images_functions.php'); 

session_start();


/**
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008-2009 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$targ_w = 800;
	$targ_h = 450;
	$jpeg_quality = 90;

	$src = '../'.$_SESSION['url_fichier'];
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	//header('Content-type: image/jpeg');
	//imagejpeg($dst_r,null,$jpeg_quality);
	$filename = deleteTousCaracteresSpeciaux($_SESSION['titre'])."_".nameimage();
	$filedir = "../news/".$filename;
	//mysqlInsertNewsPhoto($_SESSION['id_news'],,'3','4');
	
	mysqlInsertNewsPhoto($_SESSION['id_news'],$filename,$_SESSION['titre'],'');
	
	mysqlDeleteNewsIllustration($_SESSION['id_news']);
	mysqlInsertNewsIllustration($_SESSION['id_news'],"news/".$filename,$_SESSION['titre'],$_SESSION['titre']);

	imagejpeg($dst_r,$filedir,72);
	//imagejpeg($tmp,$filename,100);


	imagedestroy($src);
	imagedestroy($tmp);
	
	header("Location:  administration.php?news=gestion&page=1&order=news_date_modif");

	exit;
}

function deleteTousCaracteresSpeciaux($chaine)
{    
    
    $accents = Array("/é/", "/è/", "/ê/","/ë/", "/ç/", "/à/", "/â/","/á/","/ä/","/ã/","/å/", "/î/", "/ï/", "/í/", "/ì/", "/ù/", "/ô/", "/ò/", "/ó/", "/ö/");
    $sans = Array("e", "e", "e", "e", "c", "a", "a","a", "a","a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
    
    $chaine = preg_replace($accents, $sans,$chaine);  
    $chaine = preg_replace('#[^A-Za-z0-9]#','_',$chaine);
	   
    return $chaine; 
}

// If not a POST request, display page below:

?><!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="css/main.css" type="text/css" />
  <link rel="stylesheet" href="css/demos.css" type="text/css" />
  <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      aspectRatio: 1.77777777778,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
<style type="text/css">
  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }


</style>

</head>
<body>

<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box">

<div class="page-header">


</div>

		<!-- This is the image we're attaching Jcrop to -->
		<img src=<?php echo '"../'.$_SESSION['url_fichier'].'"'?> id="cropbox" />

		<!-- This is the form that our event handler fills -->
		<form action="news_illustration_crop.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
		</form>




	</div>
	</div>
	</div>
	</div>
	</body>

</html>
