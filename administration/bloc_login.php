<?php
require_once('authentification.php');

session_start();

function createLoginButton(){
	$toReturn ='';
	if(!testAuthentification()){
		$toReturn = '<p><a href="#" id="btn-login" data-action="login">se connecter</a></p>';
		$toReturn .='<p><a href="#" id="btn-inscription" data-action="inscription">s\'inscrire</a></p>';
	}
	else if(testAuthentification()){
		$toReturn = '['.$_SESSION['pseudo'].'] <p><a href="deconnexion.php">se déconnecter</a></p>';
	}
	return $toReturn;
}


function createLoginForm(){
	
	$toReturn ='';
	if(!testAuthentification()){
	$toReturn .='
	<form id="sign-in-form" action="" method="post">
		<div id="login-box" class="login-popup">
			
			<div class="header-login-box">
				<h2>connexion</h2>
        		<a href="#" class="close_cross"><span>close</span></a>
        	</div>
            
            
        	<fieldset id="login-fieldset" class="textbox">
                
                <p><label for="pseudo"><span>pseudo: </span></label></p>
                <p><input id="pseudo" name="pseudo" value="" type="text" autocomplete="on" placeholder="Pseudo"></p>
                
                <p><label for="password"><span>mot de passe: </span></label></p>
                <p><input id="password" name="password" value="" type="password" placeholder="Mot de passe"></p>

                
                <p><input type="submit" id="login_sumit" value="se connecter"/></p>
                
                <p><a href="#">Mot de passe oublié?</a></p>
                
            </fieldset>
          		
  		</div>
	</form>
	';
	}
	return $toReturn;

}

function createInscriptionForm(){
	
	$toReturn ='';
	if(!testAuthentification()){
	$toReturn .='
	<form id="register-form" action="" method="post">
		<div id="inscription-box" class="inscription-popup">
			<div class="header-login-box">
				<h2>inscription</h2>
        		<a href="#" class="close_cross"><span>close</span></a>
        	</div>
                
            <fieldset id="inscription-fieldset" class="textbox">
              
            <p><label for="inscription_pseudo"><span>pseudo: </span></label></p>
            <p><input id="inscription_pseudo" name="inscription_pseudo" value="" type="text" autocomplete="on" placeholder="Pseudo" pattern="^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ&?!._\ -]{3,30}$" title="minimum 3 caractères" required></p>
            
                
        	<p><label for="inscription_email"><span>email: </span></label></p>
            <p><input id="inscription_email" name="inscription_email" value="" type="email" placeholder="email" required></p>
			
				
            <p><label for="inscription_password"><span>mot de passe: </span></label></p>
            <p><input id="inscription_password" name="inscription_password" value="" type="password" placeholder="Mot de passe" pattern="(\w){6,}" title="minimum 6 caractères!"required></p>
			
				
            <p><label for="inscription_password_verif"><span>mot de passe: </span></label></p>
            <p><input id="inscription_password_verif" name="inscription_password_verif" value="" type="password" placeholder="Mot de passe"></p>
			
				
            <p><input type="submit" id="inscription_sumit" value="s\'inscrire"/></p>
                
            </fieldset>
          		
          </div>
	</form>';
	}
	return $toReturn;

}    	

?>