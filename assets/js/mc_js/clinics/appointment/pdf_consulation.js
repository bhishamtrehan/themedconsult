var baseUrl = document.location.origin+'/themedconsult/';

$(document).ready(function(){ 

jQuery(".pdf_file").click(function(){
   // alert("The paragraph was clicked.");

 return false;
	$.ajax({
	type: "POST",
	url: baseUrl+"clinic/appointment/upload_new_pdf", 
	data: "appointment_id="+calEvent.id,
	dataType: "html",  
	cache:false,
	success: function (response) {
	
	
	}
}); 
});
});