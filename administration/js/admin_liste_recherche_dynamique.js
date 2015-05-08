$(document).ready(function() {
		
		
		var $plateforme = $('#plateforme');
  		var $jeu_list = $('#id_jeu');
		$plateforme.on('change', function() {

        var $val = $(this).val(); // on récupère la valeur de la région
 		
        if($val != '') {
            $jeu_list.empty(); // on vide la liste des départements
             
            $.ajax({
                url: 'admin_traitement_liste_recherche_dynamique.php',
                data: 'id_plateforme='+ $val, // on envoie $_GET['id_region']
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                        $jeu_list.append('<option value="'+ $.trim(index) +'">'+ value +'</option>');
                    });
                }
            });
        }
   		});
   		
   		
   		var $plateforme_search = $('#plateforme_search');
  		var $jeu_list_search = $('#id_jeu_search');
		$plateforme_search.on('change', function() {

        var $val = $(this).val(); // on récupère la valeur de la région
 		
        if($val != '') {
            $jeu_list_search.empty(); // on vide la liste des départements
             
            $.ajax({
                url: 'admin_traitement_liste_recherche_dynamique.php',
                data: 'id_plateforme='+ $val, // on envoie $_GET['id_region']
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                        $jeu_list_search.append('<option value="'+ $.trim(index) +'">'+ value +'</option>');
                    });
                }
            });
        }
   		});
   		
   		
   		
   		
});