<?php
session_start();

function getBackgroundStyle(){
	return '<style type="text/css">
	@media (min-width: 960px) {	
		html { 
			margin:0;
  			padding:0;
  			background: url(../styles/background_images/bg_big.jpg) no-repeat center fixed; 
  			-webkit-background-size: cover; /* pour anciens Chrome et Safari */
  			background-size: cover; /* version standardisée */
  		}
  	}
  	@media (min-width: 690px) and (max-width: 960px) {	
		html { 
			margin:0;
  			padding:0;
  			background: url(../styles/background_images/bg_small.jpg) no-repeat center fixed; 
  			-webkit-background-size: cover; /* pour anciens Chrome et Safari */
  			background-size: cover; /* version standardisée */
  		}
  	}
  	@media handheld, only screen and (max-width: 690px), only screen and (max-device-width: 690px) {
  		html { 
			margin:0;
  			padding:0;
  			//background: url(../styles/background_images/bg_small.jpg) no-repeat center fixed; 
  			//-webkit-background-size: cover; /* pour anciens Chrome et Safari */
  			//background-size: cover; /* version standardisée */
  		}
  	}
  	</style>';
}



?>
