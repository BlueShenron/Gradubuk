$(document).ready(function() {
	$("#btn-login").click(function() {
		loadSignIn();  // function to display the sin in form
	});

	$("#btn-inscription").click(function() {
		loadRegister(); // function to display the register form
	});

	$(".close_cross").click(function() {
		disablePopup();  // function to close pop-up forms
	});

	$("#background-on-popup").click(function() {
		disablePopup();  // function to close pop-up forms
	});

	$(this).keyup(function(event) {
		if (event.which == 27) { // 27 is the code of the ESC key
			disablePopup();
		}
	});

	var status = 0;

	function loadSignIn() {
		if(status == 0) {
			$("#sign-in-form").fadeIn(300);
			$("#background-on-popup").css("opacity", "0.7");
			$("#background-on-popup").fadeIn(300);
			status = 1;
		}
	}

	function loadRegister() {
		if(status == 0) {
			$("#register-form").fadeIn(300);
			$("#background-on-popup").css("opacity", "0.7");
			$("#background-on-popup").fadeIn(300);
			status = 1;
		}
	}

	function disablePopup() {
		if(status == 1) {
			$("#sign-in-form").fadeOut("normal");
			$("#register-form").fadeOut("normal");
			$("#background-on-popup").fadeOut("normal");
			status = 0;
		}
	}
	
	//--------------- fonction appelée lors du clic submit -----------//
	$('#inscription_sumit').click(function () {
	//alert(verificationPseudo());
		if(verificationPseudo()=="exist"){
				$('#inscription_pseudo').prop('pattern', '^(?!^'+$('#inscription_sumit').val()+'$)');
				$('#inscription_pseudo')[0].setCustomValidity('ce pseudo existe déjà');
				$('#inscription_pseudo').prop('title', '');
		}
		else{
				$('#inscription_pseudo')[0].setCustomValidity('');
				$('#inscription_pseudo').prop('pattern', '^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ&?!._\\ -]{3,30}$');
				$('#inscription_pseudo').prop('title', 'minimum 3 caractères!');
		}
			
		if($('#inscription_password').val() == $('#inscription_password_verif').val()) {
        		$('#inscription_password_verif')[0].setCustomValidity('');
    	}
    	else {
        		$('#inscription_password_verif')[0].setCustomValidity('Passwords must match');
    	}
	});
	
	$('#register-form').submit(function () {
		sendContactForm();
 		return false;
	});
	
	$('#sign-in-form').submit(function () {
		sendSignInForm();
 		return false;
	});

	function sendContactForm() {
		//if( verificationPseudo()=="ok" && document.getElementById('inscription_email').checkValidity() && document.getElementById('inscription_password').checkValidity() && $('#inscription_password').val()==$('#inscription_password_verif').val()){
			$.ajax({
				url: 'authentification.php',
				data: {pseudo: $("#inscription_pseudo").val(), email: $("#inscription_email").val(), password: $("#inscription_password").val()},
				type: 'POST',
                dataType: 'text',
			
				success: function(data) {
					if(data=="ok"){
						$("#inscription-fieldset").empty();
						$("#inscription-fieldset").append('<p class="confirmation_inscription">Un email de validation va vous être envoyé. Veuillez consulter votre boîte email et cliquer sur le lien pour activer votre compte.</p>');
						$("#inscription-fieldset").append('<p><a href="index.php" class="inscription_ok">ok</a></p>');
						}
					else if(data=="nok"){
						$("#inscription-fieldset").empty();
						$("#inscription-fieldset").append('<p>une erreur est survenue lors de l\'inscrpition</p>');
						$("#inscription-fieldset").append('<p><a href="index.php" class="inscription_ok">ok</a></p>');

					}
				}
			});
	}
	
	function sendSignInForm() {
		$.ajax({
				url: 'authentification.php',
				data: {pseudo: $("#pseudo").val(), password: $("#password").val()},
				type: 'POST',
                dataType: 'text',
			
				success: function(data) {
					if(data=="ok"){
						window.location.href = 'index.php';
					}
					else if(data=="nok"){
						//alert('nok nok nok');
						
						$("#login-fieldset").prepend('<p class="message_erreur_authentification" id="message_erreur_authentification">erreur d\'authentification</p>');
                    	$('#message_erreur_authentification').fadeIn().delay(2000).fadeOut(300, function() { $(this).remove(); });
                    		
					}
					else if(data=="en attente"){

						$("#login-fieldset").prepend('<p class="message_erreur_authentification" id="message_erreur_authentification">vous n\'avez pas encore validé votre inscription</p>');
                    	$('#message_erreur_authentification').fadeIn().delay(10000).fadeOut(300, function() { $(this).remove(); });
                    		
					}
				}
			});
	}
	
	$('#inscription_password_verif').keyup(function() {
		if($('#inscription_password').val() == $(this).val()) {
        	$(this)[0].setCustomValidity('');
    	}
    	else {
        	$(this)[0].setCustomValidity('Passwords must match');
    	}
	});
	
	
	
	// ======= fonctions de verifications des champs ======== //
	function verificationPseudo(){
	
		if($.trim($('#inscription_pseudo').val())==""){
			return "vide";		
		}
		else if($.trim($('#inscription_pseudo').val()).length < 3){
			return "trop court";
		}
		else{
			var toReturn =  "prout";
			
			$.ajax({
				url: 'authentification.php',
				data: {pseudo: $.trim($('#inscription_pseudo').val())},
				async: false,
    			type: "POST",
    			global: false,
				dataType: 'text',
			
				success: function(data) {
					if(data == "exist"){
						
						toReturn =  "exist";
					}
					else if(data == "notexist"){
						toReturn =  "ok";
					}
				}
			});
			
			return toReturn;
		}
	}
	
	// ======== ============ //
	$('#inscription_ok').click(function () {
		disablePopup();
	});

	

});