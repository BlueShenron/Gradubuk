$(document).ready(function() {
    var $plateforme = $('#plateforme');
  	var $jeu_list = $('#jeu_list');
  	
  	var $plateforme_delete_test = $('#plateforme_delete_test');
  	var $add_categorie = $('#add_categorie');
  	var $add_plateforme = $('#add_plateforme');
 	var $add_constructeur = $('#add_constructeur');
 	var $add_developpeur = $('#add_developpeur');
 	var $add_jeu = $('#add_jeu');
 	
 	function youtube_parser(url){
    	var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    	var match = url.match(regExp);
    	if (match&&match[7].length==11){
       	 	return match[7];
    	}else{
        	alert("Url incorrecta");
    	}
	}
	
 		//------------------------------TEST et NEWS---------------------------------------------------//	
 		// à la sélection d une platforme dans la liste
    	$plateforme.on('change', function() {
    	
        var $val = $(this).val(); // on récupère la valeur de la région
 		
        if($val != '') {
            $jeu_list.empty(); // on vide la liste des départements
             
            $.ajax({
                url: 'admin_traitement_listes_dynamiques.php',
                data: 'id_plateforme='+ $val, // on envoie $_GET['id_region']
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                    	
                        $jeu_list.append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
        }
   		});
   		//------------------------------TEST et NEWS---------------------------------------------------//
   		
   		
   		
   		
   		
   		//------------------------------TEST---------------------------------------------------//
   		$plateforme_delete_test.on('change', function() {
    	
        var $val = $(this).val(); // on récupère la valeur de la région
 
        if($val != '') {
            $jeu_list.empty(); // on vide la liste des départements
             
            $.ajax({
                url: 'admin_traitement_listes_dynamiques.php',
                data: 'id_plateforme_delete_test='+ $val, // on envoie $_GET['id_region']
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                    	
                        $jeu_list.append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
        }
   		});
   		//------------------------------TEST---------------------------------------------------//




		//------------------------------NEWS---------------------------------------------------//		
		// fonction qui ajoute les catégories news lorsque qu'on clique sur ajouter à la liste
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
            	$("#liste_categorie").append('<p><input type="checkbox" name="liste_categorie[]" value="'+$("#categorie_news_list").val()+'" checked="checked"/>'+$("#categorie_news_list option:selected").text()+'</p>');
			}
		});
		
		$add_plateforme.click(function() {
			var liste_plateforme_checkbox = $("#liste_plateforme").find(":checkbox");
            var flag = false;
            
            liste_plateforme_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#plateforme_list").val()){
            		flag = true;
            	}
            });        
         	//alert (  $("#plateforme_list").val()  );
            
           	if(!flag && $("#plateforme_list").val()!="" ){
            	$("#liste_plateforme").append('<p><input type="checkbox" name="liste_plateforme[]" value="'+$("#plateforme_list").val()+'" checked="checked"/>'+$("#plateforme_list option:selected").text()+'</p>');
			}
		});
		
		$add_constructeur.click(function() {
			var liste_constructeur_checkbox = $("#liste_constructeur").find(":checkbox");
            var flag = false;
            
            liste_constructeur_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#constructeur_list").val()){
            		flag = true;
            	}
            });        
         	//alert (  $("#plateforme_list").val()  );
            
           	if(!flag && $("#constructeur_list").val()!="" ){
            	$("#liste_constructeur").append('<p><input type="checkbox" name="liste_constructeur[]" value="'+$("#constructeur_list").val()+'" checked="checked"/>'+$("#constructeur_list option:selected").text()+'</p>');
			}
		});
		
		$add_developpeur.click(function() {
			var liste_developpeur_checkbox = $("#liste_developpeur").find(":checkbox");
            var flag = false;
            
            liste_developpeur_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($(this).attr('value')) == $("#developpeur_list").val()){
            		flag = true;
            	}
            });        
         	//alert (  $("#plateforme_list").val()  );
            
           	if(!flag && $("#developpeur_list").val()!="" ){
            	$("#liste_developpeur").append('<p><input type="checkbox" name="liste_developpeur[]" value="'+$("#developpeur_list").val()+'" checked="checked"/>'+$("#developpeur_list option:selected").text()+'</p>');
			}
		});
		
		
		 		
 		$add_jeu.click(function() {
			var liste_jeu_checkbox = $("#liste_jeu").find(":checkbox");
            var flag = false;
            
            liste_jeu_checkbox.each(function() {
            	//console.log($(this).attr('value'));
            	if( ($.trim($(this).attr('value'))) == $.trim($("#jeu_list").val())){
            		flag = true;
            	}
            });          
         	
            
           	if(!flag && $("#jeu_list").val()!="" ){
           	$.ajax({
                url: 'admin_traitement_listes_dynamiques.php',
                data: 'id_jeu_version_plateforme='+ $.trim($("#jeu_list").val()), // on envoie $_GET['id_region']
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                    	if($.trim($("#jeu_list").val()) == $.trim(index)){
                        	$("#liste_jeu").append('<p><input type="checkbox" name="liste_jeu[]" value="'+index+'" checked="checked"/>'+value+'</p>');
							
							$.ajax({
								url: 'admin_traitement_listes_dynamiques.php',
								data: {getAllPictures: 'getAllPictures', id_jeu_version_plateforme: $.trim(index)},
								dataType: 'json',
								success: function(json) {
									var i = 0
									$.each(json, function(index, value) {
									i++;
									});
									if(i>0){
									var id_fieldset = 'image_fieldset_'+$.trim(index);
									$("#images_fieldset").append('<fieldset id="'+id_fieldset+'" class="fieldset_categorie_news"><legend>Images '+value+'</legend></fieldset>');
									$.each(json, function(index, value) {
                        				$("#"+id_fieldset).append('<div class="image_jeu_div"><p><input type="checkbox" name="liste_image_jeu[]" value="'+index+'"/><img src="'+value+'" alt="'+value+'"  /></p></div>');
									});
									}
								}
							});
							
							
							$.ajax({
								url: 'admin_traitement_listes_dynamiques.php',
								data: {getAllVideos: 'getAllVideos', id_jeu_version_plateforme: $.trim(index)},
								
								dataType: 'json',
								success: function(json) {
									var i = 0
									$.each(json, function(index, value) {
									i++;
									});
									if(i>0){
									var id_fieldset = 'video_fieldset_'+$.trim(index);
									$("#videos_fieldset").append('<fieldset id="'+id_fieldset+'" class="fieldset_categorie_news"><legend>Videos '+value+'</legend></fieldset>');
									$.each(json, function(index, value) {
									
										var video_id = youtube_parser($.trim(value));
                        				$("#"+id_fieldset).append('<div class="image_jeu_div"><p><input type="checkbox" name="liste_video_jeu[]" value="'+index+'"/><img src="http://img.youtube.com/vi/'+video_id+'/0.jpg"  /></p></div>');
                        				
									});
									}
								}
							});
						
						
						                     
						
                        }
                        else{
                       		$("#liste_jeu").append('<p><input type="checkbox" name="liste_jeu[]" value="'+index+'"/>'+value+'</p>');
                       		
                       		$.ajax({
								url: 'admin_traitement_listes_dynamiques.php',
								data: {getAllPictures: 'getAllPictures', id_jeu_version_plateforme: $.trim(index)},
								dataType: 'json',
								success: function(json) {
									var i = 0
									$.each(json, function(index, value) {
									i++;
									});
									if(i>0){
									var id_fieldset = 'image_fieldset_'+$.trim(index);
									$("#images_fieldset").append('<fieldset id="'+id_fieldset+'" class="fieldset_categorie_news"><legend>Images '+value+'</legend></fieldset>');
									$.each(json, function(index, value) {
                        				$("#"+id_fieldset).append('<div class="image_jeu_div"><p><input type="checkbox" name="liste_image_jeu[]" value="'+index+'"/><img src="'+value+'" alt="'+value+'"  /></p></div>');
									});
									}
								}
							});
							
							
							$.ajax({
								url: 'admin_traitement_listes_dynamiques.php',
								data: {getAllVideos: 'getAllVideos', id_jeu_version_plateforme: $.trim(index)},
								dataType: 'json',
								success: function(json) {
									var i = 0
									$.each(json, function(index, value) {
									i++;
									});
									if(i>0){
									var id_fieldset = 'video_fieldset_'+$.trim(index);
									$("#videos_fieldset").append('<fieldset id="'+id_fieldset+'" class="fieldset_categorie_news"><legend>Videos '+value+'</legend></fieldset>');
									$.each(json, function(index, value) {		
										var video_id = youtube_parser($.trim(value));
                        				$("#"+id_fieldset).append('<div class="image_jeu_div"><p><input type="checkbox" name="liste_video_jeu[]" value="'+index+'"/><img src="http://img.youtube.com/vi/'+video_id+'/0.jpg"  /></p></div>');
									});
									}
								}
							});
							
							
                        }

                    });
                }
            });
            }
           //alert ('ici');
        

		
		});
 		//------------------------------NEWS---------------------------------------------------//	
 
 
 	
});

