$(document).ready(function() {

var $add_categorie = $('#add_categorie');

$add_categorie.click(function() {
			var liste_categorie_checkbox = $("#liste_categorie").find(":checkbox");
            var flag = false;
           
            liste_categorie_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#categorie_news_list").val()){
            		flag = true;
            	}
            });        
         	
            
           	if(!flag && $("#categorie_news_list").val()!="" ){
            	$("#liste_categorie").append('<p><input type="checkbox" name="liste_categorie_news[]" value="'+$("#categorie_news_list").val()+'" checked="checked"/>'+$("#categorie_news_list option:selected").text()+'</p>');
			
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {id_news: $("#id_news").val(),id_sous_categorie_news: $("#categorie_news_list").val()},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
                        $("#image_fieldset").append('<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/><img src="../'+value['url']+'" alt="'+value['alt']+'"  /><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="hidden" value="'+value['alt']+'"/><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="hidden" value="'+value['alt']+'"/></p>');
						//$("#image_fieldset").append('<tr><td><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"></td><td><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/></td><td class="cell_image_categorie_news"><img src="../'+value['url']+'" alt="'+value['alt']+'"  /></td><td><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="text" value="'+value['alt']+'"/></td><td><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="text" value="'+value['alt']+'"/></td></tr>');
						});
					}
								
				});
			}
});

var $add_plateforme = $('#add_plateforme');

$add_plateforme.click(function() {
			
			var liste_categorie_checkbox = $("#liste_plateforme").find(":checkbox");
            var flag = false;
           
            liste_categorie_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#plateforme_list").val()){
            		flag = true;
            	}
            });        
            
           	if(!flag && $("#plateforme_list").val()!="" ){
            	$("#liste_plateforme").append('<p><input type="checkbox" name="liste_plateforme_news[]" value="'+$("#plateforme_list").val()+'" checked="checked"/>'+$("#plateforme_list option:selected").text()+'</p>');
			
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {id_news: $("#id_news").val(),id_plateforme: $("#plateforme_list").val()},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
                        $("#image_fieldset").append('<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/><img src="../'+value['url']+'" alt="'+value['alt']+'"  /><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="hidden" value="'+value['alt']+'"/><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="hidden" value="'+value['alt']+'"/></p>');
						//$("#image_fieldset").append('<tr><td><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"></td><td><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/></td><td class="cell_image_categorie_news"><img src="../'+value['url']+'" alt="'+value['alt']+'"  /></td><td><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="text" value="'+value['alt']+'"/></td><td><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="text" value="'+value['alt']+'"/></td></tr>');

						});
					}
								
				});
			}
});

var $add_constructeur = $('#add_constructeur');

$add_constructeur.click(function() {
			var liste_categorie_checkbox = $("#liste_constructeur").find(":checkbox");
            var flag = false;
            liste_categorie_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#constructeur_list").val()){
            		flag = true;
            	}
            });        
         	
            
           	if(!flag && $("#constructeur_list").val()!="" ){
            	$("#liste_constructeur").append('<p><input type="checkbox" name="liste_constructeur_news[]" value="'+$("#constructeur_list").val()+'" checked="checked"/>'+$("#constructeur_list option:selected").text()+'</p>');
				
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {id_news: $("#id_news").val(),id_constructeur: $("#constructeur_list").val()},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
                        $("#image_fieldset").append('<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/><img src="../'+value['url']+'" alt="'+value['alt']+'"  /><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="hidden" value="'+value['alt']+'"/><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="hidden" value="'+value['alt']+'"/></p>');
						//$("#image_fieldset").append('<tr><td><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"></td><td><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/></td><td class="cell_image_categorie_news"><img src="../'+value['url']+'" alt="'+value['alt']+'"  /></td><td><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="text" value="'+value['alt']+'"/></td><td><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="text" value="'+value['alt']+'"/></td></tr>');

						});
					}
								
				});
			}
});

var $add_developpeur = $('#add_developpeur');

$add_developpeur.click(function() {
			var liste_categorie_checkbox = $("#liste_developpeur").find(":checkbox");
            var flag = false;
            liste_categorie_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#developpeur_list").val()){
            		flag = true;
            	}
            });        
         	
            
           	if(!flag && $("#developpeur_list").val()!="" ){
            	$("#liste_developpeur").append('<p><input type="checkbox" name="liste_developpeur_news[]" value="'+$("#developpeur_list").val()+'" checked="checked"/>'+$("#developpeur_list option:selected").text()+'</p>');
				
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {id_news: $("#id_news").val(),id_developpeur: $("#developpeur_list").val()},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
                       	$("#image_fieldset").append('<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/><img src="../'+value['url']+'" alt="'+value['alt']+'"  /><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="hidden" value="'+value['alt']+'"/><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="hidden" value="'+value['alt']+'"/></p>');
						//$("#image_fieldset").append('<tr><td><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"></td><td><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/></td><td class="cell_image_categorie_news"><img src="../'+value['url']+'" alt="'+value['alt']+'"  /></td><td><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="text" value="'+value['alt']+'"/></td><td><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="text" value="'+value['alt']+'"/></td></tr>');

						});
					}
								
				});
			}
});

var $add_editeur = $('#add_editeur');

$add_editeur.click(function() {
			var liste_categorie_checkbox = $("#liste_editeur").find(":checkbox");
            var flag = false;
            liste_categorie_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#editeur_list").val()){
            		flag = true;
            	}
            });        
         	
            
           	if(!flag && $("#editeur_list").val()!="" ){
            	$("#liste_editeur").append('<p><input type="checkbox" name="liste_editeur_news[]" value="'+$("#editeur_list").val()+'" checked="checked"/>'+$("#editeur_list option:selected").text()+'</p>');
				
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {id_news: $("#id_news").val(),id_editeur: $("#editeur_list").val()},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
                       	$("#image_fieldset").append('<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/><img src="../'+value['url']+'" alt="'+value['alt']+'"  /><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="hidden" value="'+value['alt']+'"/><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="hidden" value="'+value['alt']+'"/></p>');
						//$("#image_fieldset").append('<tr><td><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"></td><td><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/></td><td class="cell_image_categorie_news"><img src="../'+value['url']+'" alt="'+value['alt']+'"  /></td><td><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="text" value="'+value['alt']+'"/></td><td><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="text" value="'+value['alt']+'"/></td></tr>');

						});
					}
								
				});
			}
});

var $add_jeu = $('#add_jeu');

$add_jeu.click(function() {
			//alert ($.trim($("#id_jeu").val()));
			var liste_categorie_checkbox = $("#liste_jeu").find(":checkbox");
            var flag = false;
            liste_categorie_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $.trim($("#id_jeu").val())){
            		flag = true;
            	}
            });        
         	
            
           	if(!flag && $.trim($("#id_jeu").val())!="" ){
            	
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {operation: 'getAllJeuVersionPlateforme',id_jeu_version_plateforme: $.trim($("#id_jeu").val())},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
          		 			$("#liste_jeu").append('<p><input type="checkbox" name="liste_jeu_version_plateforme_news[]" value="'+index+'" checked="checked"/>'+value['plateforme']+' / '+value['jeu_nom_generique']+'</p>');
						});
					}
								
				});
				
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {operation: 'getAllJeuImage',id_news: $("#id_news").val(),id_jeu_version_plateforme: $.trim($("#id_jeu").val())},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
                        $("#image_fieldset").append('<p class="image_illustration_news"><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/><img src="../'+value['url']+'" alt="'+value['alt']+'"  /><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="hidden" value="'+value['alt']+'"/><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="hidden" value="'+value['alt']+'"/></p>');
						//$("#image_fieldset").append('<tr><td><input type="radio" name="image_illustration" value="'+value['url']+'" checked="checked"></td><td><input type="checkbox" name="news_liste_image[]" value="'+value['url']+'"/></td><td class="cell_image_categorie_news"><img src="../'+value['url']+'" alt="'+value['alt']+'"  /></td><td><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="text" value="'+value['alt']+'"/></td><td><input id="alt_'+changeCharateresSpeciaux(value['url'])+'" name="alt_'+changeCharateresSpeciaux(value['url'])+'"  type="text" value="'+value['alt']+'"/></td></tr>');

						});
					}
								
				});
				
				$.ajax({
					url: 'admin_traitement_liste_dynamique_news.php',
					data: {operation: 'getAllJeuVideo',id_news: $("#id_news").val(),id_jeu_version_plateforme: $.trim($("#id_jeu").val())},
					
               	 	dataType: 'json',
					success: function(json) {	
						$.each(json, function(index, value) {
                       	$("#video_fieldset").append('<p class="image_illustration_news"><input type="checkbox" name="news_liste_video[]" value="'+value['url']+'"/><img src="'+value['thumbnail']+'" alt="'+value['thumbnail']+'"  /><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="hidden" value="'+value['titre']+'"/></p>');
						//$("#video_fieldset").append('<tr><td><input type="checkbox" name="news_liste_video[]" value="'+value['url']+'"/></td><td class="cell_image_categorie_news"><img src="'+value['thumbnail']+'" alt="'+value['thumbnail']+'"  /></td><td><input id="titre_'+changeCharateresSpeciaux(value['url'])+'" name="titre_'+changeCharateresSpeciaux(value['url'])+'" type="text" value="'+value['titre']+'"/></td></tr>');

						});
					}
								
				});
			}
});


function changeCharateresSpeciaux(my_string) {
		var new_string = "";
		var pattern_accent = new Array("é", "è", "ê", "ë", "ç", "à", "â", "ä", "î", "ï", "ù", "ô", "ó", "ö");
		var pattern_replace_accent = new Array("e", "e", "e", "e", "c", "a", "a", "a", "i", "i", "u", "o", "o", "o");
		
		if (my_string && my_string!= "") {
			new_string = preg_replace (pattern_accent, pattern_replace_accent, my_string);
		}
		
		new_string = new_string.replace(/[^A-Za-z0-9]/g, "_");
		return new_string;
}
function preg_replace (array_pattern, array_pattern_replace, my_string)  {
	var new_string = String (my_string);
		for (i=0; i<array_pattern.length; i++) {
			var reg_exp= RegExp(array_pattern[i], "gi");
			var val_to_replace = array_pattern_replace[i];
			new_string = new_string.replace (reg_exp, val_to_replace);
		}
		return new_string;
}

});