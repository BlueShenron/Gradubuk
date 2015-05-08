$(document).ready(function() {
	//--------------- tout ce qui est lié à l'authentification -----------//
	
	//--------------- affichage de la box de login quand click sur login -----------//
	$('#btn-login').click(function() {	
		if(this.dataset.action=="login"){
			
		
			//Set the center alignment padding + border
			//var popMargTop = ($("#login-box").height() + 24) / 2; 
			//var popMargLeft = ($("#login-box").width() + 24) / 2; 
		
			//$("#login-box").css({ 
			//	'margin-top' : -popMargTop,
			//	'margin-left' : -popMargLeft
			//});
		
			// Add the mask to body
			$('body').append('<div id="mask"></div>');
			$('#mask').fadeIn(300);
			$("#login-box").fadeIn(300);
			
		}
	});
	
	
	//--------------- desaffichage de la fenêtre login quand clic que la croix -----------//
	$('#close_login_cross').click(function() {
		
		$('#mask , .login-popup').fadeOut(300 , function() {
				$('#mask').remove();  
		});
	});
	
	//--------------- affichage de la box de inscription quand click sur inscription -----------//
	$('#btn-inscription').click(function() {
		
		if(this.dataset.action=="inscription"){
			
		
			//Set the center alignment padding + border
			/*var popMargTop = ($("#inscription-box").height() + 24) / 2; 
			var popMargLeft = ($("#inscription-box").width() + 24) / 2; 
		
			$("#inscription-box").css({ 
				'margin-top' : -popMargTop,
				'margin-left' : -popMargLeft
			});
		
			// Add the mask to body*/
			$('body').append('<div id="mask"></div>');
			$('#mask').fadeIn(300);
			$("#inscription-box").fadeIn(300);
			
		}
	});
	//--------------- desaffichage de la fenêtre login quand clic que la croix -----------//
	$('#close_inscription_cross').click(function() {
		$('#mask , .inscription-popup').fadeOut(300 , function() {
			$('#mask').remove(); 
			
			$("#inscription_pseudo").val("");
			$("#inscription_email").val("");
			$("#inscription_password").val("");
		
			if ($("#message_inscription_pseudo_ok").length ) {
				$('#message_inscription_pseudo_ok').remove();
			}
		
			if ($("#message_erreur_pseudo_inscription").length ) {
				$('#message_erreur_pseudo_inscription').remove();
			}
			
			if ($("#message_inscription_email_ok").length ) {
				$('#message_inscription_email_ok').remove();
			}
		
			if ($("#message_erreur_email_inscription").length ) {
				$('#message_erreur_email_inscription').remove();
			}
			
			if ($("#message_inscription_password_ok").length ) {
				$('#message_inscription_password_ok').remove();
			}
		
			if ($("#message_erreur_password_inscription").length ) {
				$('#message_erreur_password_inscription').remove();
			}
			
			
		});
		
	});
	
	//--------------- ajax lors du clic sur le bouton login -----------//
	$('#login_sumit').click(function() {	
		//alert ($("#username").val());
		$.ajax({
                url: 'authentification.php',
				data: {pseudo: $("#pseudo").val(), password: $("#password").val()},
                type: 'POST',
                dataType: 'json',
                
               
                success: function(data) {
                	if(data['pseudo']){
                		$('#mask , .login-popup').fadeOut(300 , function() {
							$('#mask').remove();  
						}); 
						$('#logincontainer').empty();
						$('#logincontainer').append('['+data['pseudo']+'] <a href="deconnexion.php">se déconnecter</a>');
						/*if(data['admin']!=0){
							$('.menu-list').append('<li><a href="#">Administration</a></li>');
						}*/
                	}
                	else{
                		if ( $( "#message_erreur_authentification" ).length ) {
                			//un message d'erreur existe alors on ne fait rien
                		}
                		else{
                    		$("#login-fieldset").prepend('<p class="message_erreur_authentification" id="message_erreur_authentification">erreur d\'authentification</p>');
                    		$('#message_erreur_authentification').fadeIn().delay(2000).fadeOut(300, function() { $(this).remove(); });
                    		
                    	}
                    }
                }
        });
	});
	
	//--------------- ajax lors de l'inscription d'un pseudo durant l'inscription -----------//
	$('#inscription_pseudo').focusout(function() {
		verificationPseudo();
	});
	
	$('#inscription_pseudo').keyup(function() {
		if ($("#message_erreur_pseudo_inscription" ).length) {
				$('#message_erreur_pseudo_inscription').fadeOut(300, function() { $(this).remove(); });
		}
		if ($("#message_inscription_pseudo_ok" ).length) {
				$('#message_inscription_pseudo_ok').fadeOut(300, function() { $(this).remove(); });
		}
	});
	//--------------- ajax lors de l'inscription d'un pseudo durant l'inscription -----------//
	
	
	//--------------- ajax lors de l'inscription d'un email durant l'inscription -----------//
	$('#inscription_email').focusout(function() {
		verificationEmail();
	});
	
	$('#inscription_email').keyup(function() {
		if ($("#message_erreur_email_inscription" ).length) {
				$('#message_erreur_email_inscription').fadeOut(300, function() { $(this).remove(); });
		}
		if ($("#message_inscription_email_ok" ).length) {
				$('#message_inscription_email_ok').fadeOut(300, function() { $(this).remove(); });
		}
	});
	//--------------- ajax lors de l'inscription d'un pseudo durant l'inscription -----------//
	
	//--------------- ajax lors de l'inscription d'un email durant l'inscription -----------//
	$('#inscription_password').focusout(function() {
		verificationPassword();
	});
	
	$('#inscription_password').keyup(function() {
		if ($("#message_erreur_password_inscription" ).length) {
				$('#message_erreur_password_inscription').fadeOut(300, function() { $(this).remove(); });
		}
		if ($("#message_inscription_password_ok" ).length) {
				$('#message_inscription_password_ok').fadeOut(300, function() { $(this).remove(); });
		}
	});
	//--------------- ajax lors de l'inscription d'un pseudo durant l'inscription -----------//
	$('#inscription_sumit').click(function() {		
		verificationPseudo();
		verificationEmail();
		verificationPassword();
		if(verificationPseudo() && verificationEmail() && verificationPassword()){
		
			
			$.ajax({
				url: 'authentification.php',
				data: {pseudo: $("#inscription_pseudo").val(), email: $("#inscription_email").val(), password: $("#inscription_password").val()},
				type: 'POST',
                dataType: 'text',
			
				success: function(data) {
					if(data=="ok"){
						$("#inscription-fieldset").empty();
						$("#inscription-fieldset").append('<p class="texte_confirmation_inscription">Un email de validation vous a été envoyé. Veuillez consulter votre boîte email et cliquer sur le lien pour activer votre compte.</p>');
						$("#inscription-fieldset").append('<div class="buttonHolder"><p><input type="submit" id="inscription_sumit" value="ok"/></p></div>');
					}
					else if(data=="nok"){
						$("#inscription-fieldset").empty();
						$("#inscription-fieldset").append('<p class="texte_confirmation_inscription>une erreur est survenue lors de l\'inscrpition</p>');
						$("#inscription-fieldset").append('<div class="buttonHolder"><p><input type="submit" id="inscription_sumit" value="ok"/></p></div>');
					}
				}
			});
			
			
		}
	});
                
	function verificationPseudo(){
		if($.trim($('#inscription_pseudo').val())==""){
			if ($("#message_erreur_pseudo_inscription" ).length) {
				return false		
			}	
			else{
				if ($("#message_inscription_pseudo_ok").length ) {
					$('#message_inscription_pseudo_ok').remove();
				}
				$("#inscription_pseudo_p").append('<span class="message_erreur_inscription" id="message_erreur_pseudo_inscription">pseudo invalide</span>');
				return false;

			}
		}
		else if($.trim($('#inscription_pseudo').val()).length < 5){
			if ($("#message_erreur_pseudo_inscription" ).length) {
							//un message ok existe alors on ne fait rien
				return false;
			}	
			else{
				if ($("#message_inscription_pseudo_ok").length ) {
					$('#message_inscription_pseudo_ok').remove();
				}
				$("#inscription_pseudo_p").append('<span class="message_erreur_inscription" id="message_erreur_pseudo_inscription">pseudo trop court</span>');
				return false;

			}
		}
		else{
		//alert ($(this).val());
			var toReturn = false;
			$.ajax({
				url: 'authentification.php',
				data: {pseudo: $.trim($('#inscription_pseudo').val())},
				async: false,
    			type: "POST",
    			global: false,
				dataType: 'json',
			
				success: function(data) {
					if(data['pseudo'] == "exist"){
						if ($("#message_erreur_pseudo_inscription").length ) {
        	        			//un message d'erreur existe alors on ne fait rien
        	        		toReturn =  false;
        	        	}
        	        	else{
							if ($("#message_inscription_pseudo_ok" ).length) {
								$("#message_inscription_pseudo_ok").remove();
							}
							$("#inscription_pseudo_p").append('<span class="message_erreur_inscription" id="message_erreur_pseudo_inscription">ce pseudo est déjà pris</span>');
							toReturn =  false;
						
						}
					}
					else{
						if ($("#message_inscription_pseudo_ok" ).length) {
							//un message ok existe alors on ne fait rien
							toReturn =  true;
	
						}	
						else{
							if ($("#message_erreur_pseudo_inscription").length ) {
								$('#message_erreur_pseudo_inscription').remove();
							}
							$("#inscription_pseudo_p").append('<span class="message_inscription_ok" id="message_inscription_pseudo_ok"></span>');
							toReturn =  true;
						}
					}
				}
			});
			return toReturn;
		}
	}
	
	function verificationEmail(){
		if(!validateEmail($('#inscription_email').val())){
			if ($("#message_erreur_email_inscription" ).length) {
				return false;
			}	
			else{
				if ($("#message_inscription_email_ok").length ) {
					$('#message_inscription_email_ok').remove();// si il y a un message "ok" on l'enleve 
				}
				$("#inscription_email_p").append('<span class="message_erreur_inscription" id="message_erreur_email_inscription">email invalide</span>');
				return false;
			}
		}
		else{
			if ($("#message_inscription_email_ok" ).length) {
				return true;
			}
			else{
				$("#inscription_email_p").append('<span class="message_inscription_ok" id="message_inscription_email_ok"></span>');
				return true;
			}
		}
	}
	
	function verificationPassword(){
		if($('#inscription_password').val().length < 6){
			if ($("#message_erreur_password_inscription" ).length) {
				return false;
			}	
			else{
				if ($("#message_inscription_password_ok").length ) {
					$('#message_inscription_password_ok').remove();// si il y a un message "ok" on l'enleve 
				}
				$("#inscription_password_p").append('<span class="message_erreur_inscription" id="message_erreur_password_inscription">mot de passe trop court</span>');
				return false;
			}
		}
		else{
			if ($("#message_inscription_password_ok" ).length) {
				return true
			}
			else{
				$("#inscription_password_p").append('<span class="message_inscription_ok" id="message_inscription_password_ok"></span>');
				return true
			}
		}
	}
	function validateEmail(email) { 
    	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(email);
	} 
	
});



