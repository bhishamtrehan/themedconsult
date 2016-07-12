$(document).ready(function() {
	$('#clinicListing').dataTable({ 
	"columns": [
		{"searchable": true },
		{"bSortable": false },
		{"bSortable": true },
		{"bSortable": true },
		{"bSortable": false },
		{"bSortable": false }
    ] 
	});
	
	jQuery.validator.addMethod("nospace",function(spaceset, element){	
		if(spaceset!=''){
			return spaceset.trim(); 	
		} else {
			return true;
		}
	}, "Please provide atleast one character!");
});

function add_billing_code() {
	var baseUrl = document.location.origin+'/smarthealthcare/';
	$('body').addClass("show_loader");
	$.ajax({
		type: "POST",
		url: baseUrl+"clinic/appointment/add_item_code", 
		data: "true=true",
		dataType: "html",  
		cache:false,
		success: function (response) {
			$( ".modal-content" ).html(response);
			$('body').removeClass("show_loader");
			$( ".btn-lg" ).trigger( "click" );  
			$("#add_billing_code").validate({
					rules: {
						billing_code: {
							required: true,
							nospace: true,
							//remote: baseUrl+'clinic/appointment/check_billing_code'
						},
						price: {
							required: true,
							nospace: true,
							number: true
						},
					},
					messages: {
						billing_code: {
							required: "",
						},
						price: {
							required: "",
							number: "Must be an integer",
						},
					}
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			}
	});
}
function edit_billing_code(code_id) {
	var baseUrl = document.location.origin+'/smarthealthcare/';
	$('body').addClass("show_loader");
	if(code_id!='' && code_id!=0){
		$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/edit_item_code", 
				data: "code_id="+code_id,
				dataType: "html",  
				cache:false,
				success: function (response) {
					$( ".modal-content" ).html(response);
					$('body').removeClass("show_loader");
					$( ".btn-lg" ).trigger( "click" );  
					$("#edit_billing_code").validate({
					rules: {
						billing_code: {
							required: true,
							nospace: true
						},
						price: {
							required: true,
							nospace: true,
							number: true
						},
					},
					messages: {
						billing_code: {
							required: "",
						},
						price: {
							required: "",
							number: "Must be an integer",
						},
					}
				});
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
	}
}
function enable_billing_code(code_id){
	var enable_code  ="codeEnable"+code_id;
	var disable_code ="codeDisable"+code_id;
	var baseUrl = document.location.origin+'/smarthealthcare/';
	if(code_id!='' && code_id!=0){
			$.ajax({
					type: "POST",
					url: baseUrl+"clinic/appointment/enable_item_code", 
					data: "code_id="+code_id,
					dataType: "html",  
					cache:false,
					success: function (response) {
						document.getElementById(enable_code).style.display="block";
						document.getElementById(disable_code).style.display="none";
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
	
} 
function disable_billing_code(code_id){
		var enable_code  ="codeEnable"+code_id;
	    var disable_code ="codeDisable"+code_id;
		var baseUrl = document.location.origin+'/smarthealthcare/';
		if(code_id!='' && code_id!=0){
			$.ajax({
					type: "POST",
					url: baseUrl+"clinic/appointment/disable_item_code", 
					data: "code_id="+code_id,
					dataType: "html",  
					cache:false,
					success: function (response) {
						document.getElementById(enable_code).style.display="none";
						document.getElementById(disable_code).style.display="block";
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
	
}