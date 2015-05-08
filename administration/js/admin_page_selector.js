$(window).load(function() {

$('.page_selector').change(function(event) {
	$(location).attr('href', 'administration.php?'+$('#admin_rubrique').val()+'='+$('#admin_operation').val()+'&page='+$(this).val()+'&order='+$("#order").val()+'#resultat_recherche');
});
$('.page_selector_jeu_nom_generique_search').change(function(event) {
	$(location).attr('href', 'administration.php?'+$('#admin_rubrique').val()+'='+$('#admin_operation').val()+'&page='+$(this).val()+'&jeu_nom_generique='+$("#jeu_nom_generique_search").val()+'#resultat_recherche');
});

$('#order').change(function(event) {
	//if($('#admin_rubrique').val()=="plateforme_version"){
	//	$(location).attr('href', 'administration.php?'+$('#admin_rubrique').val()+'='+$('#admin_operation').val()+'&id_plateforme='+$('#id_plateforme').val()+'&page=1&order='+$(this).val()+'');
	//}
	//else{
		$(location).attr('href', 'administration.php?'+$('#admin_rubrique').val()+'='+$('#admin_operation').val()+'&page=1&order='+$(this).val()+'#resultat_recherche');
	//}
});

});