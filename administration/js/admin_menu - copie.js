
$(window).load(function() {

$("#sub_menu_admin_advance").hide();

$("#sub_menu_admin_classique").hide();
//--------------- bidouille pour l'accordeon du menu -----------//

if( $("#admin").val() == 'classique' ) {
	$("#sub_menu_admin_classique").show();
	//$("#sub_menu_admin_advance").hide();
	$("#sub_menu_1").hide();
	$("#sub_menu_2").hide();
	$("#sub_menu_3").hide();
	$("#sub_menu_4").hide();
	$("#sub_menu_5").hide();
	$("#sub_menu_6").hide();
	$("#sub_menu_7").hide();
	$("#sub_menu_8").hide();
	$("#sub_menu_9").hide();
	$("#sub_menu_10").hide();
	$("#sub_menu_11").hide();
	$("#sub_menu_12").hide();

	if( $("#admin_rubrique").val() == 'jeu' ) {
		$("#sub_menu_jeu").show();
		$("#sub_menu_test").hide();
		$("#sub_menu_news").hide();
		$("#sub_menu_article").hide();
		$("#sub_menu_images_jeux").hide();
		$("#sub_menu_videos_jeux").hide();
	}
	else if( $("#admin_rubrique").val() == 'test' ){
	//alert ('2');
		$("#sub_menu_test").show();
		$("#sub_menu_jeu").hide();
		$("#sub_menu_news").hide();
		$("#sub_menu_article").hide();
		$("#sub_menu_images_jeux").hide();
		$("#sub_menu_videos_jeux").hide();
	}
	else if( $("#admin_rubrique").val() == 'news' ){
	//alert ('2');
		$("#sub_menu_test").hide();
		$("#sub_menu_jeu").hide();
		$("#sub_menu_news").show();
		$("#sub_menu_article").hide();
		$("#sub_menu_images_jeux").hide();
		$("#sub_menu_videos_jeux").hide();
	}
	else if( $("#admin_rubrique").val() == 'article' ){
	//alert ('2');
		$("#sub_menu_test").hide();
		$("#sub_menu_jeu").hide();
		$("#sub_menu_news").hide();
		$("#sub_menu_article").show();
		$("#sub_menu_images_jeux").hide();
		$("#sub_menu_videos_jeux").hide();
	}
	else if( $("#admin_rubrique").val() == 'images_jeux' ){
	//alert ('2');
		$("#sub_menu_test").hide();
		$("#sub_menu_jeu").hide();
		$("#sub_menu_news").hide();
		$("#sub_menu_article").hide();
		$("#sub_menu_images_jeux").show();
		$("#sub_menu_videos_jeux").hide();
		
	}
	else if( $("#admin_rubrique").val() == 'videos_jeux' ){
	//alert ('2');
		$("#sub_menu_test").hide();
		$("#sub_menu_jeu").hide();
		$("#sub_menu_news").hide();
		$("#sub_menu_article").hide();
		$("#sub_menu_images_jeux").hide();
		$("#sub_menu_videos_jeux").show();
		
	}
	else{
	//alert ('3');
		$("#sub_menu_jeu").hide();
		$("#sub_menu_test").hide();
		$("#sub_menu_news").hide();
		$("#sub_menu_article").hide();
		$("#sub_menu_images_jeux").hide();
		$("#sub_menu_videos_jeux").hide();
	}
}

else if( $("#admin").val() == 'advance' ) {
	//$("#sub_menu_admin_classique").hide();
	$("#sub_menu_admin_advance").show();
	$("#sub_menu_jeu").hide();
	$("#sub_menu_test").hide();
	$("#sub_menu_news").hide();
	$("#sub_menu_article").hide();
	$("#sub_menu_images_jeux").hide();
	$("#sub_menu_videos_jeux").hide();
	
	if( $("#admin_rubrique").val() == 'developpeur' ) {
		$("#sub_menu_1").show();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'editeur'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").show();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'genre'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").show();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();		
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'nombre_joueur'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").show();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();		
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'constructeur'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").show();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'plateforme' || $("#admin_rubrique").val() == 'plateforme_version'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").show();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'famille_categorie_news'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").show();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'categorie_news'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").show();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'categorie_image'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").show();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'categorie_video'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").show();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'partenaire'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").show();
		$("#sub_menu_12").hide();
	}
	else if($("#admin_rubrique").val() == 'membre'){
		$("#sub_menu_1").hide();
		$("#sub_menu_2").hide();
		$("#sub_menu_3").hide();
		$("#sub_menu_4").hide();
		$("#sub_menu_5").hide();
		$("#sub_menu_6").hide();
		$("#sub_menu_7").hide();
		$("#sub_menu_8").hide();
		$("#sub_menu_9").hide();
		$("#sub_menu_10").hide();
		$("#sub_menu_11").hide();
		$("#sub_menu_12").show();
	}
	
}

else{
	$("#sub_menu_jeu").hide();
	$("#sub_menu_test").hide();
	$("#sub_menu_news").hide();
	$("#sub_menu_article").hide();
	$("#sub_menu_images_jeux").hide();
	$("#sub_menu_videos_jeux").hide();
	$("#sub_menu_1").hide();
	$("#sub_menu_2").hide();
	$("#sub_menu_3").hide();
	$("#sub_menu_4").hide();
	$("#sub_menu_5").hide();
	$("#sub_menu_6").hide();
	$("#sub_menu_7").hide();
	$("#sub_menu_8").hide();
	$("#sub_menu_9").hide();
	$("#sub_menu_10").hide();
	$("#sub_menu_11").hide();
	$("#sub_menu_12").hide();
}

$("#menu_admin_classique").click(function () {
  if ( $("#sub_menu_admin_classique").is( ":hidden" ) ) {
    $("#sub_menu_admin_classique").slideDown( "slow" );
    $("#sub_menu_admin_advance").slideUp( "slow" );
  } else {
    $("#sub_menu_admin_classique").slideUp( "slow" );
  }
});

$("#menu_admin_advance").click(function () {
  if ( $("#sub_menu_admin_advance").is( ":hidden" ) ) {
    $("#sub_menu_admin_advance").slideDown( "slow" );
    $("#sub_menu_admin_classique").slideUp( "slow" );
  } else {
    $("#sub_menu_admin_advance").slideUp( "slow" );
  }
});

$("#menu_jeu").click(function () {
  if ( $("#sub_menu_jeu").is( ":hidden" ) ) {
    $("#sub_menu_jeu").slideDown( "slow" );
    $("#sub_menu_test").slideUp( "slow" );
    $("#sub_menu_news").slideUp( "slow" );
    $("#sub_menu_article").slideUp( "slow" );
    $("#sub_menu_images_jeux").slideUp( "slow" );
    $("#sub_menu_videos_jeux").slideUp( "slow" );

  } else {
    $("#sub_menu_jeu").slideUp( "slow" );
  }
});

$("#menu_test").click(function () {
  if ( $("#sub_menu_test").is( ":hidden" ) ) {
    $("#sub_menu_test").slideDown( "slow" );
    $("#sub_menu_jeu").slideUp( "slow" );
    $("#sub_menu_news").slideUp( "slow" );
    $("#sub_menu_article").slideUp( "slow" );
    $("#sub_menu_images_jeux").slideUp( "slow" );
    $("#sub_menu_videos_jeux").slideUp( "slow" );

  } else {
    $("#sub_menu_test").slideUp( "slow" );
  }
});

$("#menu_news").click(function () {
  if ( $("#sub_menu_news").is( ":hidden" ) ) {
    $("#sub_menu_test").slideUp( "slow" );
    $("#sub_menu_jeu").slideUp( "slow" );
    $("#sub_menu_news").slideDown( "slow" );
    $("#sub_menu_article").slideUp( "slow" );
    $("#sub_menu_images_jeux").slideUp( "slow" );
    $("#sub_menu_videos_jeux").slideUp( "slow" );
  } else {
    $("#sub_menu_news").slideUp( "slow" );
  }
});
$("#menu_article").click(function () {
  if ( $("#sub_menu_article").is( ":hidden" ) ) {
    $("#sub_menu_test").slideUp( "slow" );
    $("#sub_menu_jeu").slideUp( "slow" );
    $("#sub_menu_news").slideUp( "slow" );
    $("#sub_menu_article").slideDown( "slow" );
    $("#sub_menu_images_jeux").slideUp( "slow" );
    $("#sub_menu_videos_jeux").slideUp( "slow" );
  } else {
    $("#sub_menu_article").slideUp( "slow" );
  }
});
$("#menu_images_jeux").click(function () {
  if ( $("#sub_menu_images_jeux").is( ":hidden" ) ) {
    $("#sub_menu_test").slideUp( "slow" );
    $("#sub_menu_jeu").slideUp( "slow" );
    $("#sub_menu_news").slideUp( "slow" );
    $("#sub_menu_article").slideUp( "slow" );
    $("#sub_menu_images_jeux").slideDown( "slow" );
    $("#sub_menu_videos_jeux").slideUp( "slow" );
  } else {
    $("#sub_menu_images_jeux").slideUp( "slow" );
  }
});

$("#menu_videos_jeux").click(function () {
  if ( $("#sub_menu_videos_jeux").is( ":hidden" ) ) {
    $("#sub_menu_test").slideUp( "slow" );
    $("#sub_menu_jeu").slideUp( "slow" );
    $("#sub_menu_news").slideUp( "slow" );
    $("#sub_menu_article").slideUp( "slow" );
    $("#sub_menu_images_jeux").slideUp( "slow" );
    $("#sub_menu_videos_jeux").slideDown( "slow" );
  } else {
    $("#sub_menu_videos_jeux").slideUp( "slow" );
  }
});


$("#menu_1").click(function () {

  if ( $("#sub_menu_1").is( ":hidden" ) ) {
    $("#sub_menu_1").slideDown( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
  } else {
    $("#sub_menu_1").slideUp( "slow" );
  }
});
$("#menu_2").click(function () {
  if ( $("#sub_menu_2").is( ":hidden" ) ) {
    
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideDown( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );

  } else {
    $("#sub_menu_2").slideUp( "slow" );
  }
});
$("#menu_3").click(function () {
  if ( $("#sub_menu_3").is( ":hidden" ) ) {
    
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideDown( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );

  } else {
    $("#sub_menu_3").slideUp( "slow" );
  }
});
$("#menu_4").click(function () {
  if ( $("#sub_menu_4").is( ":hidden" ) ) {  
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideDown( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );

  } else {
    $("#sub_menu_4").slideUp( "slow" );
  }
});

$("#menu_5").click(function () {
if ( $("#sub_menu_5").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_5").slideDown( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
	$("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
  } else {
    $("#sub_menu_5").slideUp( "slow" );
  }
});

$("#menu_6").click(function () {
if ( $("#sub_menu_6").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_6").slideDown( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
  } else {
    $("#sub_menu_6").slideUp( "slow" );
  }
});


$("#menu_7").click(function () {
if ( $("#sub_menu_7").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_7").slideDown( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
  } else {
    $("#sub_menu_7").slideUp( "slow" );
  }
});

$("#menu_8").click(function () {
if ( $("#sub_menu_8").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_8").slideDown( "slow" );
  } else {
    $("#sub_menu_8").slideUp( "slow" );
  }
});

$("#menu_9").click(function () {
if ( $("#sub_menu_9").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
    $("#sub_menu_9").slideDown( "slow" );
  } else {
    $("#sub_menu_9").slideUp( "slow" );
  }
});


$("#menu_10").click(function () {
if ( $("#sub_menu_10").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_10").slideDown( "slow" );
  } else {
    $("#sub_menu_10").slideUp( "slow" );
  }
});

$("#menu_11").click(function () {
if ( $("#sub_menu_11").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_11").slideDown( "slow" );
    $("#sub_menu_12").slideUp( "slow" );
  } else {
    $("#sub_menu_11").slideUp( "slow" );
  }
});

$("#menu_12").click(function () {
if ( $("#sub_menu_12").is( ":hidden" ) ) {
    $("#sub_menu_1").slideUp( "slow" );
    $("#sub_menu_2").slideUp( "slow" );
    $("#sub_menu_3").slideUp( "slow" );
    $("#sub_menu_4").slideUp( "slow" );
    $("#sub_menu_10").slideUp( "slow" );
    $("#sub_menu_5").slideUp( "slow" );
    $("#sub_menu_6").slideUp( "slow" );
    $("#sub_menu_7").slideUp( "slow" );
    $("#sub_menu_8").slideUp( "slow" );
    $("#sub_menu_9").slideUp( "slow" );
    $("#sub_menu_12").slideDown( "slow" );
    $("#sub_menu_11").slideUp( "slow" );
  } else {
    $("#sub_menu_12").slideUp( "slow" );
  }
});
//--------------- bidouille pour l'accordeon du menu -----------//



});