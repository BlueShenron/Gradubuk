
$(window).load(function() {

$("#sub_menu_admin_advance").hide();

$("#sub_menu_admin_classique").hide();
//--------------- bidouille pour l'accordeon du menu -----------//

if( $("#admin").val() == 'classique' ) {
	$("#sub_menu_admin_classique").show();
	$("#sub_menu_admin_advance").hide();
}

else if( $("#admin").val() == 'advance' ) {
	$("#sub_menu_admin_classique").hide();
	$("#sub_menu_admin_advance").show();

}

$("#menu_admin_classique").click(function () {
  if ( $("#sub_menu_admin_classique").is( ":hidden" ) ) {
    $("#sub_menu_admin_classique").slideDown( "fast" );
    $("#sub_menu_admin_advance").slideUp( "fast" );
  } else {
    $("#sub_menu_admin_classique").slideUp( "fast" );
  }
});

$("#menu_admin_advance").click(function () {
  if ( $("#sub_menu_admin_advance").is( ":hidden" ) ) {
    $("#sub_menu_admin_advance").slideDown( "fast" );
    $("#sub_menu_admin_classique").slideUp( "fast" );
  } else {
    $("#sub_menu_admin_advance").slideUp( "fast" );
  }
});

//--------------- bidouille pour l'accordeon du menu -----------//



});