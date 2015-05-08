<?php
session_start();

function getBackgroundStyle(){
	return '<style type="text/css">
	@media (min-width: 960px) {	
		html { 
			//background-image: url(styles/background_images/betweengrassandsky.png);
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-color: #ccc;
			background-size: cover;
  		}
  	}
  	@media (min-width: 690px) and (max-width: 960px) {	
		html { 
			//background-image: url(styles/background_images/betweengrassandsky.png);
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-color: #ccc;
			background-size: cover;
  		}
  	}
  	@media handheld, only screen and (max-width: 690px), only screen and (max-device-width: 690px) {
  		html { 
			margin:0;
  			padding:0;
  			//background: url(styles/background_images/bg_small.jpg) no-repeat center fixed; 
  			//-webkit-background-size: cover; /* pour anciens Chrome et Safari */
  			//background-size: cover; /* version standardisée */
  		}
  	}
  	</style>';
}



?>
