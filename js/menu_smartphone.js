$(window).load(function() {

$('#menusmallscreen > ul').hide();	   			
	$('#menuexpander').click(function(e){
		e.preventDefault();
		if ( $('#menusmallscreen > ul').is( ":hidden" ) ) {
		$('#menusmallscreen > ul').slideDown( 'fast',function() {});
		} 
		else {
		$('#menusmallscreen > ul').slideUp('fast',function() {});
		}
});

});