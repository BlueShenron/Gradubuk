
$(window).load(function() {

//--------------- date time picker plugin-----------//
jQuery('.date_picker').datetimepicker({
timepicker:false,
format:'Y.m.d',
  lang:'fr',
});
jQuery('.date_picker_avec_heure').datetimepicker({

format:'Y.m.d H:i',
  lang:'fr',
});

//--------------- date time picker plugin-----------//

//--------------- fade out sur les messages d'alertes -----------//
$('.message_alerte').fadeIn().delay(2000).fadeOut();
//--------------- fade out sur les messages d'alertes -----------//

//-----------------------------------------------------------//

$('#select_all').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $("input[name='membres[]']").each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $("input[name='membres[]']").each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
});
    

//-----------------------------------------------------------//

});