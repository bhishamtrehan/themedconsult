$(document).ready(function() {
	$('#clinicListing').dataTable({ 
	"columns": [
		{"searchable": true },
		{"bSortable": false },
                {"bSortable": false },                
		{"searchable": true },
                {"bSortable": false },
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

function add_appointment_type() {
	var baseUrl = document.location.origin+'/smarthealthcare/';
	$('body').addClass("show_loader");
	$.ajax({
		type: "POST",
		url: baseUrl+"clinic/appointment/add_type", 
		data: "true=true",
		dataType: "html",  
		cache:false,
		success: function (response) {
			$( ".modal-content" ).html(response);
			$('body').removeClass("show_loader");
			$( ".btn-lg" ).trigger( "click" );  
			$(".pick-a-color").pickAColor({
				showSpectrum            : true,
				showSavedColors         : true,
				saveColorsPerElement    : true,
				fadeMenuToggle          : true,
				showAdvanced			: true,
				showBasicColors         : true,
				showHexInput            : true,
				allowBlank				: true,
				inlineDropdown			: true
			});
                        
                        $("#color_code input").on("change", function () {
                            var preview_span = '#'+$(this).val();
                            var text_color = $('#textcolor').val();
                            $('#item_preview').css('background',preview_span);
                            $('#item_preview').css('color',text_color);
                            $('#item_preview').show();
                        });
                        
                        $("#textcolor").on("change", function () {
                            var preview_span = '#'+$("input[name='color_code']").val(); 
                            var text_color = $(this).val();
                            $('#item_preview').css('background',preview_span);
                            $('#item_preview').css('color',text_color);
                            $('#item_preview').show();
                        });
			
			$("#add_appointment_type").validate({
					rules: {
						appointment_type: {
							required: true,
							nospace: true
						},
						color_code: {
							required: true,
							nospace: true
						},
						billing_code: {
							required: true,
                                                        remote: baseUrl+'clinic/appointment/check_item_code'
						},
                                                price: {
							required: true,
							nospace: true,
							number: true
						},
					},
					messages: {
						appointment_type: {
							required: "",
						},
						color_code: {
							required: "",
						},
						billing_code: {
							required: "",
                                                        remote: "Code already exist for clinic.",
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
function edit_appointment_type(type_id) {
	var baseUrl = document.location.origin+'/smarthealthcare/';
	$('body').addClass("show_loader");
	if(type_id!='' && type_id!=0){
		$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/edit_type", 
				data: "type_id="+type_id,
				dataType: "html",  
				cache:false,
				success: function (response) {
					$( ".modal-content" ).html(response);
					$('body').removeClass("show_loader");
					$( ".btn-lg" ).trigger( "click" );  
					$(".pick-a-color").pickAColor({
						showSpectrum            : true,
						showSavedColors         : true,
						saveColorsPerElement    : true,
						fadeMenuToggle          : true,
						showAdvanced			: true,
						showBasicColors         : true,
						showHexInput            : true,
						allowBlank				: true,
						inlineDropdown			: true
					});
                                        
                                        $("#color_code input").on("change", function () {
                                            var preview_span = '#'+$(this).val();
                                            var text_color = $('#textcolor').val();
                                            $('#item_preview').css('background',preview_span);
                                            $('#item_preview').css('color',text_color);
                                            $('#item_preview').show();
                                        });

                                        $("#textcolor").on("change", function () {
                                            var preview_span = '#'+$("input[name='color_code']").val(); 
                                            var text_color = $(this).val();
                                            $('#item_preview').css('background',preview_span);
                                            $('#item_preview').css('color',text_color);
                                            $('#item_preview').show();
                                        });
                                        
                                        var type_idd = $("input[name='type_id']").val(); 
                                                                                
					$("#edit_appointment_type").validate({
						rules: {
							appointment_type: {
								required: true,
								nospace: true
							},
							color_code: {
								required: true,
								nospace: true
							},
							billing_code: {
								required: true,
                                                                //remote: baseUrl+'clinic/appointment/check_item_code?type_id='+type_idd
                                                                remote: {
                                                                    url: baseUrl+'clinic/appointment/check_item_code?type_id='+type_idd,
                                                                    async: false,
                                                                    type: "get",
                                                                    data: { 
                                                                    }
                                                                }
							},
                                                        price: {
                                                                required: true,
                                                                nospace: true,
                                                                number: true
                                                        },
						},
						messages: {
							appointment_type: {
								required: "",
							},
							color_code: {
								required: "",
							},
							billing_code: {
								required: "",
                                                                remote: "Code already exist for clinic.",
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
function enable_appnt_type(type_id){
	var enable_appnt  ="appntEnable"+type_id;
	var disable_appnt ="appntDisable"+type_id;
	var baseUrl = document.location.origin+'/smarthealthcare/';
	if(type_id!='' && type_id!=0){
			$.ajax({
					type: "POST",
					url: baseUrl+"clinic/appointment/enable_type", 
					data: "type_id="+type_id,
					dataType: "html",  
					cache:false,
					success: function (response) {
						document.getElementById(enable_appnt).style.display="block";
						document.getElementById(disable_appnt).style.display="none";
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
	
} 
function disable_appnt_type(type_id){
		var enable_appnt  ="appntEnable"+type_id;
	    var disable_appnt ="appntDisable"+type_id;
		var baseUrl = document.location.origin+'/smarthealthcare/';
		if(type_id!='' && type_id!=0){
			$.ajax({
					type: "POST",
					url: baseUrl+"clinic/appointment/disable_type", 
					data: "type_id="+type_id,
					dataType: "html",  
					cache:false,
					success: function (response) {
						document.getElementById(enable_appnt).style.display="none";
						document.getElementById(disable_appnt).style.display="block";
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
	
}

function update_tax(type_id,elem)
{
    //alert($(elem).is(":checked"));
    if($(elem).is(":checked") == true)
    {
        var istax = 1;
    }
    else
    {
        var istax = 0;
    }
    
    var baseUrl = document.location.origin+'/smarthealthcare/';
    if(type_id!='' && type_id!=0){
            $.ajax({
                            type: "POST",
                            url: baseUrl+"clinic/appointment/update_tax", 
                            data: "type_id="+type_id+"&is_tax="+istax,
                            dataType: "html",  
                            cache:false,
                            success: function (response) {
                                    
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status);
                                    alert(thrownError);
                            }
            });
    }
}