$(document).ready(function(){
	var baseUrl = document.location.origin+'/themedconsult';
	
jQuery.validator.addMethod("passwordStrength", function(password, element) {
	if(password!=''){
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
	}else{
		           
		return true;
	}	
}, "Please provide at least one Uppercase, one lowercase, one digit and one special character from ! @ # $ % ^ & * /");

	jQuery.validator.addMethod("phoneValidation", function(clinic_telephone_no, element) {
	return clinic_telephone_no.match(/^[0-9]+(\-[0-9]+)*$/); 
}, "Please enter valid number!");
	
	
	jQuery.validator.addMethod("mobileValidation", function(clinic_telephone_no, element) {
 	     if (password.value != cpassword.value) {  cpassword.focus(); return false; }
	}, "Your password and confirmation password do not match!");

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
    var user_id=$('input[name="user_id"]').val(); 
	$("#add_clinic_form").validate({
		rules: {
			clinic_name: {
				required: true,
				nospace: true
			},
			clinic_admin_name: {
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
				remote: {
					url: baseUrl+'/admin/clinics/edit_check_username?user_id='+user_id,
					async:false
				},
				noSpaceReq: true
			},
			email: {
				required: true,
				email: true,
				remote: { 
					url: baseUrl+'/admin/clinics/edit_check_email?user_id='+user_id,
					async:false
				}	
			},
			password: {
				minlength: 8,
				passwordStrength: true
			},
			confirm_password: {
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
			clinic_suburb: {
				required: function(element) {
				return $("#country").val() == 'AU';
			  }
			},
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
			clinic_telephone_code: {
				required: true,
				nospace: true
			},
			clinic_telephone_no: {
				required: true,
				phoneValidation: true,
				nospace: true
			},
			clinic_mobile_no: {
				mobileValidation: true,
				nospace: true
			},
			clinic_fax_number: {
				mobileValidation: true,
				nospace: true
			}
		},
		messages: {
			username: {
				required: "",
				minlength: "Your username must consist of at least 6 characters",
				remote: "Username already taken! please try another.",
			},
			email: {
				required: "",
				email: "Please enter a valid email address",
				remote: "Email already exists! please try another.",
			},
			password: {
				required: "",
				minlength: "Your password must be at least 8 characters long"
			},
			confirm_password: {
				required: "",
				minlength: "Your password must be at least 8 characters long",
				equalTo: "Password do not match"
			},
			clinic_name: {
				required: "",
			},
			clinic_admin_name: {
				required: "",
			},
			clinic_admin_email: {
				required: "",
				email: "Please enter a valid email address"
			},
			clinic_street_address: {
				required: "",
			},
			timezone: {
				required: "",
			},
			country: {
				required: "",
			},
			clinic_suburb: {
				required: "",
			},
			clinic_state: {
				required: "",
			},
			clinic_city: {
				required: "",
			},
			clinic_postcode: {
				required: "",
			},
			clinic_telephone_code: {
				required: "",
			},
			clinic_telephone_no: {
				required: "",
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
				url: baseUrl+"/master/clinics/getstates", 
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
					url: baseUrl+"/master/clinics/getStatesCities", 
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
						url: baseUrl+"/master/clinics/getpostcodes", 
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
					url: baseUrl+"/master/clinics/getCountryStates", 
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
	
	var html = '<div class="form-group" id="newNo_'+newLngth+'"><label class="col-sm-3 control-label">Office No<span class="astrik">*</span></label><div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter telephone number" autocomplete="off" size="30" maxlength="80" value="" name="clinic_telephone_no[]"><a href="javascript:void(0);" onclick="removeCliNo('+newLngth+')">X</a></div></div>';
	$('.newOfficeNo').html('<a  href="javascript:void(0)" onclick="addNewTelephone('+newLngth+')">Add another telephone</a>');
	$('#clinicno').append(html);
	
	
}

function removeCliNo(inpId){
	$('#newNo_'+inpId).remove();
}

function addNewFax(cliLngth){
	var newLngth = cliLngth + 1;
	
	var html = '<div class="form-group" id="newFax_'+newLngth+'"><label class="col-sm-3 control-label">Fax No<span class="astrik">*</span></label><div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter fax number" autocomplete="off" size="30" maxlength="80" value="" name="clinic_fax_number[]"><a href="javascript:void(0);" onclick="removeFaxNo('+newLngth+')">X</a></div></div>';
	$('.newFaxNo').html('<a  href="javascript:void(0)" onclick="addNewFax('+newLngth+')">Add another fax</a>');
	$('#faxno').append(html);
	
	
}

function removeFaxNo(inpId){
	$('#newFax_'+inpId).remove();
}

function addNewEmail(cliLngth){
	var newLngth = cliLngth + 1;
	
	var html = '<div class="form-group" id="newEmail_'+newLngth+'"><label class="col-sm-3 control-label">Office Email ID<span class="astrik">*</span></label><div class="col-sm-9"><input class="form-control" type="text" placeholder="Enter email address" autocomplete="off" size="30" maxlength="80" value="" name="clinic_admin_email[]"><a href="javascript:void(0);" onclick="removeEmail('+newLngth+')">X</a></div></div>';
	$('.newEmailAddress').html('<a  href="javascript:void(0)" onclick="addNewEmail('+newLngth+')">Add another email</a>');
	$('#emailAdd').append(html);
	
	
}

function removeEmail(inpId){
	
	$('#newEmail_'+inpId).remove();
}



function addNewRoom(cliLngth){
	var newLngth = cliLngth + 1;
	
	var html = '<div class="form-group" id="newroom_'+newLngth+'"><label class="col-sm-3 control-label">Room<span class="astrik">*</span></label><div class="col-sm-9"><input type="text" class="form-control" placeholder="Room" autocomplete="off" size="30" maxlength="80" value="" name="clinic_room[]"><a href="javascript:void(0);" onclick="removeRoom('+newLngth+')">X</a></div></div>';
	$('.newroom').html('<a  href="javascript:void(0)" onclick="addNewRoom('+newLngth+')">Add another room</a>');
	$('#roomAdd').append(html);
	
	
}

function removeRoom(inpId){
	$('#newroom_'+inpId).remove();
}