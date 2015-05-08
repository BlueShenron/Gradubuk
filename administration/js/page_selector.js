$(window).load(function() {

$('#page_dev_edit').change(function() {
	$(location).attr('href', 'administration.php?developpeur=edit&page='+$('#page_dev_edit').val()+'');
});
$('#page_dev_delete').change(function() {
	$(location).attr('href', 'administration.php?developpeur=delete&page='+$('#page_dev_delete').val()+'');
});
//-----------//
$('#page_editeur_edit').change(function() {
	$(location).attr('href', 'administration.php?editeur=edit&page='+$('#page_editeur_edit').val()+'');
});
$('#page_editeur_delete').change(function() {
	$(location).attr('href', 'administration.php?editeur=delete&page='+$('#page_editeur_delete').val()+'');
});
//-----------//
$('#page_genre_edit').change(function() {
	$(location).attr('href', 'administration.php?genre=edit&page='+$('#page_genre_edit').val()+'');
});
$('#page_genre_delete').change(function() {
	$(location).attr('href', 'administration.php?genre=delete&page='+$('#page_genre_delete').val()+'');
});
//-----------//
$('#page_famille_categorie_edit').change(function() {
	$(location).attr('href', 'administration.php?famille_categorie=edit&page='+$('#page_famille_categorie_edit').val()+'');
});
$('#page_famille_categorie_delete').change(function() {
	$(location).attr('href', 'administration.php?famille_categorie=delete&page='+$('#page_famille_categorie_delete').val()+'');
});
//-----------//
$('#page_mode_edit').change(function() {
	$(location).attr('href', 'administration.php?mode=edit&page='+$('#page_mode_edit').val()+'');
});
$('#page_mode_delete').change(function() {
	$(location).attr('href', 'administration.php?mode=delete&page='+$('#page_mode_delete').val()+'');
});
//-----------//
$('#page_constructeur_edit').change(function() {
	$(location).attr('href', 'administration.php?constructeur=edit&page='+$('#page_constructeur_edit').val()+'');
});
$('#page_constructeur_delete').change(function() {
	$(location).attr('href', 'administration.php?constructeur=delete&page='+$('#page_constructeur_delete').val()+'');
});
//-----------//
$('#page_img_categorie_edit').change(function() {
	$(location).attr('href', 'administration.php?img_categorie=edit&page='+$('#page_img_categorie_edit').val()+'');
});
$('#page_img_categorie_delete').change(function() {
	$(location).attr('href', 'administration.php?img_categorie=delete&page='+$('#page_img_categorie_delete').val()+'');
});
//-----------//
$('#page_video_categorie_edit').change(function() {
	$(location).attr('href', 'administration.php?video_categorie=edit&page='+$('#page_video_categorie_edit').val()+'');
});
$('#page_video_categorie_delete').change(function() {
	$(location).attr('href', 'administration.php?video_categorie=delete&page='+$('#page_video_categorie_delete').val()+'');
});
//-----------//
$('#page_categorie_edit').change(function() {
	$(location).attr('href', 'administration.php?categorie=edit&page='+$('#page_categorie_edit').val()+'');
});
$('#page_categorie_delete').change(function() {
	$(location).attr('href', 'administration.php?categorie=delete&page='+$('#page_categorie_delete').val()+'');
});
//-----------//
$('#page_plateforme_edit').change(function() {
	$(location).attr('href', 'administration.php?plateforme=edit&page='+$('#page_plateforme_edit').val()+'');
});
$('#page_plateforme_delete').change(function() {
	$(location).attr('href', 'administration.php?plateforme=delete&page='+$('#page_plateforme_delete').val()+'');
});
//-----------//
$('#page_jeu_edit').change(function() {
	$(location).attr('href', 'administration.php?jeu=edit&page='+$('#page_jeu_edit').val()+'&order='+$('#order').val()+'');
});
$('#page_jeu_delete').change(function() {
	$(location).attr('href', 'administration.php?jeu=delete&page='+$('#page_jeu_delete').val()+'&order='+$('#order').val()+'');
});
//-----------//

//----------//
$('#page_jeu_edit_name').change(function() {
	$(location).attr('href', 'administration.php?jeu=edit&page='+$('#page_jeu_edit_name').val()+'&jeu_nom_generique='+$('#jeu_name_hidden').val()+'&order='+$('#order').val()+'');
});
$('#page_jeu_delete_name').change(function() {
	$(location).attr('href', 'administration.php?jeu=delete&page='+$('#page_jeu_delete_name').val()+'&jeu_nom_generique='+$('#jeu_name_hidden').val()+'&order='+$('#order').val()+'');
});
//-----------//

$('#page_test_submit_jeu_name').change(function() {
	$(location).attr('href', 'administration.php?test=submit_jeu&jeu_nom_generique='+$('#jeu_name_hidden').val()+'&page='+$('#page_test_submit_jeu_name').val()+'&order='+$('#order_test_submit_jeu').val()+'');
});
$('#page_test_submit_jeu').change(function() {
	$(location).attr('href', 'administration.php?test=submit_jeu&jeu_nom_generique='+$('#jeu_name_hidden').val()+'&page='+$('#page_test_submit_jeu').val()+'&order='+$('#order_test_submit_jeu').val()+'');
});
$('#page_test_submit_jeu').change(function() {
	$(location).attr('href', 'administration.php?test=submit_jeu&page='+$('#page_test_submit_jeu').val()+'&order='+$('#order_test_submit_jeu').val()+'');
});

//-----------//
$('#page_image_jeu_submit_jeu').change(function() {
	$(location).attr('href', 'administration.php?image_jeu=submit_jeu&page='+$('#page_image_jeu_submit_jeu').val()+'&order='+$('#order_image_jeu_submit_jeu').val()+'');
});
//-----------//
$('#page_video_jeu_submit_jeu').change(function() {
	alert('iii');
	$(location).attr('href', 'administration.php?video_jeu=submit_jeu&page='+$('#page_video_jeu_submit_jeu').val()+'&order='+$('#order_video_jeu_submit_jeu').val()+'');
});

$('#page_news').change(function() {
	$(location).attr('href', 'administration.php?news=edit&page='+$('#page_news').val()+'&order='+$('#order_news').val()+'');
});
$('#page_article').change(function() {
	$(location).attr('href', 'administration.php?article=edit&page='+$('#page_article').val()+'&order='+$('#order_article').val()+'');
});

});