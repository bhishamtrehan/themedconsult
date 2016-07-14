$(document).ready(function(){
	var baseUrl = document.location.origin+'/themedconsult';
	
jQuery.validator.addMethod("passwordStrength", function(password, element) {
	var passwordReturn = false;
	var passwordCounter = 0;
    if((password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))) {
		//for checking upper case in password
		passwordCounter++;	
	}
	if((password.match(/([0-9])/))) {
		//for checking numbers in password
		passwordCounter++;	
	}
	if((password.match(/([!,%,&,@,#,$,^,*,?,_,~,/,/])/))) {
		//for checking special character in password
		passwordCounter++;	
	}
	if(passwordCounter == 3)
		passwordReturn = true;
	return passwordReturn;
}, "Please provide at least one Uppercase, one lowercase, one digit and one special character from ! @ # $ % ^ & * /");

	jQuery.validator.addMethod("phoneValidation", function(clinic_telephone_no, element) {
	return clinic_telephone_no.match(/^[0-9]+(\-[0-9]+)*$/); 
}, "Please enter valid number!");

jQuery.validator.addMethod("mobileValidation", function(clinic_telephone_no, element) {
	if(clinic_telephone_no!=''){
		return clinic_telephone_no.match(/^[- +()]*[0-9][- +()0-9]*$/); 	
	} else {
		return true;
	}
	
}, "Please enter valid number!");
jQuery.validator.addMethod("nospace",function(spaceset, element){	
	if(spaceset!=''){
		return spaceset.trim(); 	
	} else {
		return true;
	}
}, "Please provide at-least one character!");
 $.validator.addMethod('selectcheck', function (value) {
        return (value != '0');
    }, "");
 $.validator.addMethod("noSpaceReq", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
  }, "Kindly remove space from the username");

	$("#add_clinic_form").validate({
		rules: {
			clinic_name: {
				required: true,
				nospace: true
			},
			
			clinic_admin_email: {
				required: true,
				email: true
			},
			clinic_street_address: {
				required: true,
				nospace: true
			},
			username: {
				required: true,
				minlength: 6,
				remote: baseUrl+'/auth/check_username',
				noSpaceReq: true
			},
			email: {
				required: true,
				email: true,
				remote: baseUrl+'/auth/check_email'
			},
			password: {
				required: true,
				minlength: 8,
				passwordStrength: true
			},
			confirm_password: {
				required: true,
				minlength: 8,
				equalTo: "#password"
			},
			timezone: {
				required: true,
				selectcheck: true,
			},
			country: {
				required: true,
			},
			// clinic_suburb: {
			// 	required: function(element) {
			// 	return $("#country").val() == 'AU';
			//   }
			// },
			clinic_state: {
				required: true,
			},
			clinic_city: {
				required: function(element) {
				return ($("#country").val() != 'AU' && $("#country").val() != '');
			  }
			},
			clinic_postcode: {
				required: true,
				nospace: true
			},
			
			clinic_telephone_no: {
				required: true,
				phoneValidation: true,
				nospace: true
			},
			
			clinic_fax_number: {
				mobileValidation: true,
				nospace: true
			}
		},
		messages: {
			
			clinic_name: {
				required: "This field is required",
			},
			
			clinic_admin_email: {
				required: "his field is required",
				email: "Please enter a valid email address"
			},
			clinic_street_address: {
				required: "This field is required",
			},
			
			country: {
				required: "",
			},
			clinic_suburb: {
				required: "",
			},
			clinic_state: {
				required: "This field is required",
			},
			clinic_city: {
				required: "",
			},
			clinic_postcode: {
				required: "",
			},
			clinic_fax_number: {
				required: "This field is required",
			},
			clinic_telephone_no: {
				required: "This field is required",
			},
		}
	});
	$(".clinic_suburb").autocomplete({
		source: baseUrl+"/clinics/getsuburbs",
        /* minLength: 2,//search after two characters */
        select: function(event,ui){
		}
	});	
    $( ".clinic_suburb" ).blur(function(){
		var srbname=$(".clinic_suburb").val();
                var stateid=$(".clinic_state").val();
		$.ajax({
				type: "POST",
				url: baseUrl+"/clinic/getstates", 
				data: "suburbs_name="+srbname+"&stateid="+stateid,
				dataType: "html",  
				cache:false,
				success: function (response) {
						$('.clinic_state').replaceWith(response);
						stateId = $(".clinic_state").val();
						getCityPostcodes(stateId);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
	
	});
   
});

function getCityPostcodes(stateId){
	var baseUrl = document.location.origin+'/themedconsult';
	var countryId = $("#country").val();
	if(stateId != '') {
		if(countryId!='AU') {
			$.ajax({
					type: "POST",
					url: baseUrl+"/clinic/getStatesCities", 
					data: "stateID="+stateId,
					dataType: "html",  
					cache:false,
					success: function (response) {
							$('.clinic_city').replaceWith(response);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
		else {
			var srbname = $(".clinic_suburb").val();
			if(stateId!='' && stateId!=0 && srbname!=''){
					$.ajax({
						type: "POST",
						url: baseUrl+"/clinic/getpostcodes", 
						data: "state_id="+stateId+"&suburbs_name="+srbname,
						dataType: "html",  
						cache:false,
						success: function (response) {
							$('#clinic_postcode').val(response);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
						}
				}); 
			}		
		}
	}
}
function getStateList(countryId) {
	var baseUrl = document.location.origin+'/themedconsult';
	$('.clinic_suburb').val('');
	$('.clinic_state').html('');
	$('.clinic_postcode').val('');
	$('.clinic_city').val('');
	$('#clinic_postcode').val('');
	if(countryId != '') {
		if(countryId == 'AU')
		{
			$('#suburb_lists').show();
			$('#city_lists').hide();
			$("#clinic_postcode").css("pointer-events", "none"); 
		}
		else
		{
			$('#suburb_lists').hide();
			$('#city_lists').show();
			$("#clinic_postcode").css("pointer-events", "unset"); 
			$.ajax({
					type: "POST",
					url: baseUrl+"/clinic/getCountryStates", 
					data: "countryID="+countryId,
					dataType: "html",  
					cache:false,
					success: function (response) {
							$('.clinic_state').replaceWith(response);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
	}
}

function addNewTelephone(cliLngth){
	var newLngth = cliLngth + 1;
	
	var html = '<div class="form-group" id="newNo_'+newLngth+'"><div class="col-sm-12"><div class="input-group"><input type="text" class="form-control" placeholder="Enter telephone number" autocomplete="off" size="30" maxlength="80" value="" name="clinic_telephone_no[]"> <span class="input-group-btn"><a class="btn btn-default" type="button"><i  onclick="removeCliNo('+newLngth+')" class="fa fa-trash-o remove-field"></i></a></span></div></div></div>';
	$('.newOfficeNo').html('<i class="fa fa-plus" onClick="addNewTelephone('+newLngth+')"></i>');
	$('#clinicno').append(html);
	
	
}

function removeCliNo(inpId){
	$('#newNo_'+inpId).remove();
}

function addNewFax(cliLngth){
	var newLngth = cliLngth + 1;
	
	var html = '<div class="form-group" id="newFax_'+newLngth+'"><div class="col-sm-12"><div class="input-group"><input type="text" class="form-control" placeholder="Enter fax number" autocomplete="off" size="30" maxlength="80" value="" name="clinic_fax_number[]"> <span class="input-group-btn"><a class="btn btn-default" type="button"><i  onclick="removeFaxNo('+newLngth+')" class="fa fa-trash-o remove-field"></i></a></span></div></div></div>';
	$('.newFaxNo').html('<i class="fa fa-plus" onClick="addNewFax('+newLngth+')"></i>');
	$('#faxno').append(html);
	
	
}

function removeFaxNo(inpId){
	$('#newFax_'+inpId).remove();
}

function addNewEmail(cliLngth){
	var newLngth = cliLngth + 1;
	
	var html = '<div class="form-group" id="newEmail_'+newLngth+'"><div class="col-sm-12"><div class="input-group"><input type="text" class="form-control" placeholder="Enter email address" autocomplete="off" size="30" maxlength="80" value="" name="clinic_admin_email[]"> <span class="input-group-btn"><a class="btn btn-default" type="button"><i onclick="removeEmail('+newLngth+')" class="fa fa-trash-o remove-field"></i></a></span></div></div></div>';
	$('.newEmailAddress').html('<i class="fa fa-plus" onClick="addNewEmail('+newLngth+')"></i>');
	$('#emailAdd').append(html);
	
	
}

function removeEmail(inpId){
	$('#newEmail_'+inpId).remove();
}


function addNewRoom(cliLngth){
	var newLngth = cliLngth + 1;
	
	var html = '<div class="form-group" id="newroom_'+newLngth+'"><div class="col-sm-12"><div class="input-group"><input type="text" class="form-control" placeholder="Room" autocomplete="off" size="30" maxlength="80" value="" name="clinic_room[]"> <span class="input-group-btn"><a class="btn btn-default" type="button"><i onclick="removeRoom('+newLngth+')" class="fa fa-trash-o remove-field"></i></a></span></div></div></div>';
	$('.newroom').html('<i class="fa fa-plus" onClick="addNewRoom('+newLngth+')"></i>');
	$('#roomAdd').append(html);
	
	
}

function removeRoom(inpId){
	$('#newroom_'+inpId).remove();
}

$("#country").change(function(){
 //	alert($(this).val());
  if($(this).val()!='AU'){

$('.clinic_suburb').attr("disabled", true); 
}
else
{
$('.clinic_suburb').attr("disabled", false); 



}
});