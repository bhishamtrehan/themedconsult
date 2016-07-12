var baseUrl = document.location.origin+'/themedconsult/';

$(document).ready(function(){ 


$( "body .fc-event" ).delegate( ".fc-event-time", "click", function() {
alert('working');
/* return false;
	$.ajax({
	type: "POST",
	url: baseUrl+"clinic/appointment/medication_detail", 
	data: "appointment_id="+calEvent.id,
	dataType: "html",  
	cache:false,
	success: function (response) {
	
	
	}
}); */
});
});