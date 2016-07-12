$(document).ready(function() {
	var baseUrl = document.location.origin+'/themedconsult/';
	$.validator.addMethod("DateFormat", function(value,element) {
		
		value = $.datepicker.formatDate('yy-mm-dd', new Date(value));
		
		return value.match(/^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/);
    },"Please enter a date in the format 22 Jun 2015");
 
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
		if((password.match(/([!,%,&,@,#,$,^,*,?,_,~,/])/))) {
			//for checking special character in password
			passwordCounter++;	
		}
		if(passwordCounter == 3)
			passwordReturn = true;
		return passwordReturn;
    }, "Please provide at least one Uppercase, one lowercase, one digit and one special character from ! @ # $ % ^ & * /");
    

	jQuery.validator.addMethod("phoneValidation", function(clinic_telephone_no, element){
	    if(clinic_telephone_no!=''){
             return clinic_telephone_no.match(/^[- +()]*[0-9][- +()0-9]*$/); 		
		}else{
			 return true;
		}  
	 }, "Please enter valid number!");	

jQuery.validator.addMethod("mobileValidation", function(telephone_no, element) {
        if(telephone_no!=''){
             return telephone_no.match(/^[- +()]*[0-9][- +()0-9]*$/); 		
		} else {
			 return true;
		} 
}, "Please enter valid number!");
jQuery.validator.addMethod("emergencyContactNoValidation", function(telephone_no, element) {
	
		if(telephone_no!=''){
             return telephone_no.match(/^[- +()]*[0-9][- +()0-9]*$/); 		
		} else {
			 return true;
		} 
}, "Please enter valid number!");

jQuery.validator.addMethod("nospace",function(spaceset, element){
	if(spaceset.trim()!=""){
	    return spaceset.trim();
	}else{
			 return true;	
	}
}, "Please provide atleast one character!");

jQuery.validator.addMethod("noSpaceReq", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
  }, "Kindly remove space from the username");
  
jQuery.validator.addMethod("require_from_group", function(value, element, options) {
    var $fields = jQuery(options[1], element.form),
        $fieldsFirst = $fields.eq(0),
        validator = $fieldsFirst.data('valid_req_grp') ? $fieldsFirst.data('valid_req_grp') : jQuery.extend({}, this),
        isValid = $fields.filter(function() {
            return validator.elementValue(this);
        }).length >= options[0];
    // Store the cloned validator for future validation
    $fieldsFirst.data('valid_req_grp', validator);
        // If element isn't being validated, run each require_from_group field's validation rules
        if (!jQuery(element).data('being_validated')) {
            $fields.data('being_validated', true);
            $fields.each(function() {
                validator.element(this);
            });
            $fields.data('being_validated', false);
        }
        return isValid;
},"Please fill at least 1 of these fields.");
/* 
jQuery.validator.addMethod("checkusername", function(value, element, options) {
    if( ($('#first_name').val() != "") && ($('#last_name').val() != "") && ($('#dob_year').val() != "") && ($('#dob_month').val() != "") && ($('#dob_day').val() != "")) {
	    var username = $('#first_name').val()+$('#last_name').val()+$('#dob_year').val()+$('#dob_month').val()+$('#dob_day').val();
		$.ajax({
			type: "POST",
			url: baseUrl+"clinic/patients/check_username_available", 
			data: "username="+username,
			dataType: "html",  
			cache:false,
			success: function (response) {
				if(response.trim()!=""){
					$("#first_name").removeClass("error").addClass("valid");
					$("#last_name").removeClass("error").addClass("valid");
					$("#dob_year").removeClass("error").addClass("valid");
					$("#dob_month").removeClass("error").addClass("valid");
					$("#dob_day").removeClass("error").addClass("valid");
					$("#username-error").css("display", "none");
					$("#first_name-error").remove();
					$("#last_name-error").remove();
					$("#dob-error").remove();
				    return false;
				}else{
					$("#first_name").removeClass("valid").addClass("error");
					$("#last_name").removeClass("valid").addClass("error");
					$("#dob_year").removeClass("valid").addClass("error");
					$("#dob_month").removeClass("valid").addClass("error");
					$("#dob_day").removeClass("valid").addClass("error");
					$("#username-error").html("Patient already exists");
					$("#username-error").css("display", "block");
					return true;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				return false;
			}
		});
	}else{
		$("#first_name").removeClass("error").addClass("valid");
		$("#last_name").removeClass("error").addClass("valid");
		$("#dob_year").removeClass("error").addClass("valid");
		$("#dob_month").removeClass("error").addClass("valid");
		$("#dob_day").removeClass("error").addClass("valid");
		$("#username-error").css("display", "none");
		return true;	
	}
	
},"Patient already exists"); */

$("#medicare_expiry_date").datepicker({
         dateFormat: "mm/yy"
    });
    
$.validator.addMethod("isNumeric", function(value,element) {
	if(value!=''){
                return value.match(/^\d+$/);
        } else {
                return true;
        }         
     },"Only numeric values are allowed");
     
$.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
     }, "Please enter letters or numbers only"); 
 
$.validator.addMethod("MedicareDateFormat", function(value,element) {
    if(value!=''){
            return value.match(/^(([012]\d)|3[01])[\/\-]\d{4}$/);
    } else {
            return true;
    }   
},"Please enter a date in the format dd/yyyy");

$.validator.addMethod("extension",function(a,b,c){return c="string"==typeof c?c.replace(/,/g,"|"):"png|jpe?g|gif",this.optional(b)||a.match(new RegExp("\\.("+c+")$","i"))},"Please select valid format!");
	$.validator.addMethod("CheckDateFormat", function(value,element) {
            return value.match(/^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/);
         },"Please enter a date in the format yyyy-mm-dd");	
         
    	jQuery.validator.addMethod("checkfileheight", function (val, element) {
		var result;
		var thisId = "#"+element.name+"-error";
	
		if(val != ''){
            var file, img;
			var _URL = window.URL || window.webkitURL;	 
			 jQuery.validator.messages.checkfileheight = "Height and Width must be minimum 300px."; 
			if ((file = element.files[0])) {
				img = new Image();
			    img.src = _URL.createObjectURL(file);
				img.onload = function(){
					 var width = this.width;
					 var height = this.height;
				     window.URL.revokeObjectURL( img.src );
					  if (height >= 300 && width>=300) {
						 var image_height=$("input[name='crop_image']").val(); 
                         $('input[name="crop_image_height"]').val(height);
                         $('input[name="crop_image_width"]').val(width);
                         $(thisId).remove();
                         $('input[name="'+element.name+'"]').removeClass("error");
                          
                      }else{
					    $('input[name="crop_image_height"]').val(height);
					    $('input[name="crop_image_width"]').val(width);
					    $('input[name="'+element.name+'"]').addClass("error");
					  } 
                 };
                 if(($('input[name="crop_image_height"]').val()>=300 && $('input[name="crop_image_height"]').val()!=0) && ($('input[name="crop_image_width"]').val()>=300 && $('input[name="crop_image_width"]').val()!=0)){
				         return true;	 	 
				 }else{
					     return false;		 
				 }  
    		}
        }else{
		   return true;	
		   
		}
 });

	$("#patient_form").validate({
		groups: {
            name: "telephone_no mobile_no emergency_contact_no"
        },
		rules: {
			title: {
				required: true,
				nospace: true
			},
			first_name: {
				required: true,
				nospace: true,
				/* checkusername: true, */
			},
			last_name: {
				required: true,
				nospace: true,
				/* checkusername: true, */
			},
			/* dob_year: {
				required: true,
				
			},
			dob_month: {
				required: true,
				
			},
			dob_day: {
				required: true,
				
			},*/
			dob: {
				required: true,
				DateFormat: true,
				nospace:  true,
			},
			gender: {
				required: true,
			},
			email: {
				email: true,
				remote: baseUrl+'clinic/patients/check_patient_email'
			},
			confirm_email: {
				email: true,
				equalTo: "#email"
			},
			reminder: {
				/* required: true,*/
				nospace: true
			},
			street_address: {
				/* required: true,*/
				nospace: true
			},
			country: {
				/* required: true,*/
			},
			suburb: {
				/* required: function(element) {
				return $("#country").val() == 'AU';
			  }*/
			},
			state: {
				/* required: true,*/
			},
			city: {
				/* required: function(element) {
				return ($("#country").val() != 'AU' && $("#country").val() != '');
			  }*/
			},
			postcode: {
				/* required: true,*/
				nospace: true
			},
			telephone_code: {
				/* required:  function(element) { 
				   return	($(".telephone_no").val() != '');
			    },*/
				
			},
			telephone_no: {
			
				/* require_from_group: [1, '.group'],*/
				phoneValidation: true,
			},
			mobile_no: {
				/* require_from_group: [1, '.group'],*/
				mobileValidation: true,
				
			},
			emergency_contact_no: {
			    /* require_from_group: [1, '.group'],*/								
				emergencyContactNoValidation: true,
			},
			medicare_no: {
				/* 	//required: true, */
					alphanumeric: true,
			},
			patient_card_no: {
					/* //required: true,*/
					isNumeric: true
			},
			medicare_expiry_date: {
					/* //required: true, */
					/* MedicareDateFormat: true */
			},
		},
		messages: {
			email: {
				email: "Please enter a valid email address",
				remote: "Email already exist for other staff member.",
			},
			confirm_email: {
				email: "Please enter a valid email address",
				equalTo: "Email do not match",
			},
			title: {
				required: "",
			},
			first_name: {
				required: "",
				/* checkusername: "", */
			},
			last_name: {
				required: "",
				/* checkusername: "", */
			},
			/*dob_year: {
				required: "",
				
			},
			dob_month: {
				required: "",
				
			},
			dob_day: {
				required: "",
				
			},*/
			dob: {
				required: "",
				nospace:  "",
			},
			gender: {
				required: "",
			},
            reminder: {
			   /* required: "", */
			},
            street_address: {
			   /* required: "",*/
			},
			country: {
			   /* required: "",*/
			},
            state: {
			   /* required: "",*/
			},
			suburb: {
			   /* required: "",*/
			},
			city: {
			   /* required: "",*/
			},
			postcode: {
			  /* required: "",*/
			},
			telephone_code: {
			   /* required: "",*/
			},
			telephone_no: {
				/* require_from_group: "",*/
			},
			mobile_no: {
				/*  require_from_group: "",*/
			},
			emergency_contact_no: {
				/* require_from_group: "Please fill at least 1 of these 3 fields",*/
			},
			medicare_no:{
				/* //required: "",*/
			},
			patient_card_no:{
				/* //required: "",   */                                 
			},
			medicare_expiry_date:{
				/* //required: "",*/                               
			},
		}
	});
	$(".suburb").autocomplete({
		source: baseUrl+"clinic/patients/getsuburbs",
        /* minLength: 2,//search after two characters */
        select: function(event,ui){
		}
	});	
	$('#reminder').change(function() {
		$('#reminder_status').val('change');
	});
	$('#email').blur(function() {
		if($('#reminder_status').val() == "") {
			if( ($(this).val()!='') && ($('.mobile_no').val()!='')) {
				$('#reminder').val('both');
			} else if( ($(this).val()!='') && ($('.mobile_no').val()=='')) {
				$('#reminder').val('email');
			} else if( ($(this).val()=='') && ($('.mobile_no').val()!='')) { 
				$('#reminder').val('sms');
			}
		}
	});
	$('.mobile_no').blur(function() {
		if($('#reminder_status').val() == "") {
			if( ($(this).val()!='') && ($('#email').val()!='')) {
				$('#reminder').val('both');
			} else if( ($(this).val()!='') && ($('#email').val()=='')) {
				$('#reminder').val('sms');
			} else if( ($(this).val()=='') && ($('#email').val()!='')) { 
				$('#reminder').val('email');
			}
		}
	});
    $( ".suburb" ).blur(function(){
		var srbname=$(".suburb").val();
		$.ajax({
				type: "POST",
				url: baseUrl+"clinic/patients/getstates", 
				data: "suburbs_name="+srbname,
				dataType: "html",  
				cache:false,
				success: function (response) {
						$('.state').replaceWith(response);
						stateId = $(".state").val();
						getCityPostcodes(stateId);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
	
	});

	       var baseUrl = document.location.origin+'/smartehealth/';
		   //$("#wcMain").html(webcam.get_html(440, 240));
			webcam.set_api_url(baseUrl+"clinic/patients/webcamsnap");
			webcam.set_quality(90); // JPEG quality (1 - 100)
			webcam.set_shutter_sound(true); // play shutter click sound
			webcam.set_hook( 'onComplete', 'my_completion_handler' );
			$(".clickimg").click(function(){
			    $(".btn-lg").trigger("click");
	/* 		    var camHtml = $("#camra_part").html();
			    $("#wcMain").html(camHtml);
			    */ 
			    /*$("#wcMain").html(webcam.get_html(240, 240));*/
			});
			var snapdonecont = $(".popup").find(".snapdone").length;
			if(snapdonecont){
				$(".snapdone").click(function(){
				 	    $(window).resize(); 
						webcam.snap();
						$('#myModel').css("display","none");
				});
			}	
			
			var snapsettingcont = $(".popup").find(".snapsetting").length;
			if(snapsettingcont){
				$(".snapsetting").click(function(){ 
						webcam.configure();
				});
			}
			var popclosecont = $(".popup").find(".popclose").length;
			if(popclosecont){
				$(".popclose").click(function(){ 
					$(".btn-lg").trigger("click");
				});
			} 
			var uploadPicturecont = $(".widget-content").find(".uploadPicture").length;
			if(uploadPicturecont){
				$(".uploadPicture").click(function(){
					$(".btn-lg2").trigger("click");
 				    $("input[name='crop_image']").val(""); 
					$(".cropit-image-preview").css('background-image',"none");
				});
				$(".cropit-image-input").change(function() {
					 $(".cropit-image-preview").trigger("click");
				});
		
				$('.image-editor').cropit({
				  exportZoom: 1.25,
				  imageBackground: true,
				  imageBackgroundBorderWidth: 20,
				  /*imageState: {
					src: 'http://lorempixel.com/500/400/',
				  },*/
				});
                	crop_image_form();
				/*$('.export').click(function() {
				    var imageData = $('.image-editor').cropit('export');
				    $('body').addClass("show_loader");
					$.ajax({
							type: "POST",
							url: baseUrl+"clinic/patients/cropPatientPicAdd", 
							data: "patient_id=&imageData="+imageData,
							dataType: "json",  
							cache:false,
							success: function (response){
								var response = response;
								if(response['msg_type']=='success'){
									var img_path =  $('input[name="img_path"]').val(response['path']);
									$("#patientpic").replaceWith("<img id='patientpic' src=\""+response['path_url']+"\" class=\"img\">");
									$(".close").trigger("click");
									 $('body').removeClass("show_loader");
								}else{
									alert(response['messages']);
									 $('body').removeClass("show_loader");
								}
							},
							error: function (xhr, ajaxOptions, thrownError) {
								alert(xhr.status);
								alert(thrownError);
								 $('body').removeClass("show_loader");
							}
					});
				});*/
			}
				
		var removePicturecont = $(".widget-content").find(".removePicture").length;
		if(removePicturecont){
				$(".removePicture").click(function(){
				var img_path =  $('input[name="img_path"]').val();
				if(img_path==""){
					alert("No image exists");
					return false;
				}
					
				var checkTrue = confirm("Are you sure you want to remove patient's image?");
				  if (checkTrue == true) {
					if(img_path!='') {
					$('body').addClass("show_loader");
						$.ajax({
								type: "POST",
								url: baseUrl+"clinic/patients/removePatientPicAdd", 
								data: "img_path="+img_path,
								dataType: "json",  
								cache:false,
								success: function (response) {
									var response = response;
									if(response['msg_type']=='success'){
									    var img_path =  $('input[name="img_path"]').val(" ");
										$("#patientpic").replaceWith("<img id='patientpic' src=\""+baseUrl+"images/pic_icon.png\" class=\"img\">");
										$('body').removeClass("show_loader");
									}else{
										alert(response['messages']);
										$('body').removeClass("show_loader");
									}
								},
								error: function (xhr, ajaxOptions, thrownError) {
									alert(xhr.status);
									alert(thrownError);
									$('body').removeClass("show_loader");
								}
						});
					}
				} 	
			});
		}
		getStateList($("#country").val());	
    var select_ids = [];
//	$('select#pracList option').each(function(index, element) {
//		if($(this).val()!=''){
//		   select_ids.push($(this).val());
//		}
//	});
//	$('select#pracList option').click(function(){
//		if(this.value!='' && this.value!=null){
//			if(this.value=='select_all'){
//				selectAll(select_ids);
//			} 
//		}else{
//			deSelectAll();
//		}
//	});

        $('.pracListCheckboxAll').click(function() {
                if($(this).is(':checked')) { 
                    $('.pracListCheckbox').each(function() { 
                        this.checked = true;                
                    });                            
                }else{  
                    $('.pracListCheckbox').each(function() { 
                        this.checked = false;                
                    });                            
                }
        });

        $('.pracListCheckbox').click(function(){
                if(!$(this).is(':checked')) {
                        $('.pracListCheckboxAll').attr('checked', false);
                }
                else {
                        if($('.pracListCheckbox:checked').length == $('.pracListCheckbox').length) 
                        {
                           $('.pracListCheckboxAll').attr('checked', true);
                        }
                }				
        });
         $("#dob").datepicker({
			dateFormat: "dd M yy",
			endDate: '+0d',
			autoclose: true,
			changeYear: true,
			changeMonth: true,
		});

function selectAll(select_ids)
{
	$('select#pracList').val(select_ids);
}

function deSelectAll()
{
	$('select#pracList').val('');
}

function check_user_name(){
	var dobVal = $('#dob').val();
	if(dobVal !=''){
		dobVal = $.datepicker.formatDate('yymmdd', new Date(dobVal));
		if($.isNumeric(dobVal)){
			
		}else{
			return false; 
		}
	}else{
		dobVal="";	
	}
	
	if(($('#first_name').val() != "") && ($('#last_name').val() != "") && (dobVal!= "")) {
	    var username = $('#first_name').val()+$('#last_name').val()+dobVal;
		var baseUrl = document.location.origin+'/smartehealth/';
		$.ajax({
			type: "POST",
			url: baseUrl+"clinic/patients/check_username_available", 
			data: "username="+username,
			dataType: "html",  
			cache:false,
			success: function (response) {
				if(response.trim()!="" && (response.trim()==0 || response.trim()=='0')){
					$("#first_name").removeClass("error").addClass("valid");
					$("#last_name").removeClass("error").addClass("valid");
					$("#dobVal").removeClass("error").addClass("valid");
					/*$("#dob_year").removeClass("error").addClass("valid");
					$("#dob_month").removeClass("error").addClass("valid");
					$("#dob_day").removeClass("error").addClass("valid");*/
					$("#username-error").css("display", "none");
					$("#first_name-error").remove();
					$("#last_name-error").remove();
					$("#dob-error").remove();
					$('#hidden_submit').val('1');
				    return false;
				}else{
					$("#first_name").removeClass("valid").addClass("error");
					$("#last_name").removeClass("valid").addClass("error");
					$("#dob").removeClass("valid").addClass("error");
					/* $("#dob_year").removeClass("valid").addClass("error");
					$("#dob_month").removeClass("valid").addClass("error");
					$("#dob_day").removeClass("valid").addClass("error"); */
					$("#username-error").html("Patient already exists");
					$("#username-error").css("display", "block");
					$('#hidden_submit').val('0');
					return true;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				return false;
			}
		});
	}else{
		$("#first_name").removeClass("error").addClass("valid");
		$("#last_name").removeClass("error").addClass("valid");
		$("#dob").removeClass("error").addClass("valid");
		/* $("#dob_year").removeClass("error").addClass("valid");
		$("#dob_month").removeClass("error").addClass("valid");
		$("#dob_day").removeClass("error").addClass("valid");*/
		$("#username-error").css("display", "none");
		$('#hidden_submit').val('1');
		
		return true;	
	}
}
function checkOnsubmit(){
	$('body').addClass("show_loader");
	check_user_name();
	setTimeout(function(){
		var hidesubmit= $('#hidden_submit').val();
		if(hidesubmit=='1'){
			$('form#patient_form').submit(); 
		}
		$('body').removeClass("show_loader");
    }, 500);	
}

function show_username() {
		var dobVal = $('#dob').val();
		if(dobVal !=''){
			dobVal = $.datepicker.formatDate('yymmdd', new Date(dobVal));
		}else{
			dobVal="";	
		}
		if(($('#first_name').val() != "") && ($('#last_name').val() != "") && (dobVal != "")){
			$('#username_text').html($('#first_name').val()+$('#last_name').val()+dobVal);
			$('.username_label').show();
		}
}

function update_username() {
		if($('.username_label').css('display') == 'block') {
			var dobVal = $('#dob').val();
			if(dobVal !=''){
				dobVal = $.datepicker.formatDate('yymmdd', new Date(dobVal));
			}else{
				dobVal="";	
			}
			
			$('#username_text').html($('#first_name').val()+$('#last_name').val()+dobVal);
		}
}

function getCityPostcodes(stateId){
	var baseUrl = document.location.origin+'/smartehealth';
	var countryId = $("#country").val();
	if(stateId != '') {
		if(countryId!='AU') {
			$.ajax({
					type: "POST",
					url: baseUrl+"/clinic/patients/getStatesCities", 
					data: "stateID="+stateId,
					dataType: "html",  
					cache:false,
					success: function (response) {
							$('.city').replaceWith(response);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
		else {
			var srbname = $(".suburb").val();
			if(stateId!='' && stateId!=0 && srbname!=''){
					$.ajax({
						type: "POST",
						url: baseUrl+"/clinic/patients/getpostcodes", 
						data: "state_id="+stateId+"&suburbs_name="+srbname,
						dataType: "html",  
						cache:false,
						success: function (response) {
							$('#postcode').val(response);
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
	var baseUrl = document.location.origin+'/smartehealth';
	$('.suburb').val('');
	$('.state').html('');
	$('.postcode').val('');
	$('.city').val('');
	$('#postcode').val('');
	if(countryId != '') {
		if(countryId == 'AU')
		{
			$('#suburb_lists').show();
			$('#city_lists').hide();
			$("#postcode").css("pointer-events", "none"); 
		}
		else
		{
			$('#suburb_lists').hide();
			$('#city_lists').show();
			$("#postcode").css("pointer-events", "unset"); 
			$.ajax({
					type: "POST",
					url: baseUrl+"/clinic/patients/getCountryStates", 
					data: "countryID="+countryId,
					dataType: "html",  
					cache:false,
					success: function (response) {
							$('.state').replaceWith(response);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			});
		}
	}
}

function take_snapshot(){
			// take snapshot and upload to server
			document.getElementById('patientpic').innerHTML = '<h1>Uploading...</h1>';
			webcam.snap();
}

function my_completion_handler(msg) {
	// extract URL out of PHP output
	var baseUrl2 = document.location.origin+'/smartehealth/';
	var msg2 = baseUrl2+msg;
	if (msg2.match(/(http\:\/\/\S+)/)) {
		// show JPEG image in page
		 $("#patientpic").replaceWith("<img id='patientpic' src="+msg2+" class=\"img\">");
		 $('input[name="img_path"]').val(msg);
		 // reset camera for another shot
		 webcam.reset();
	}
	else {alert("Error occured we are trying to fix now: " + msg2); }
}

function crop_image_form() {
	var baseUrl2 = document.location.origin+'/smartehealth/';
	var patient_crop_pic = $("#patient_crop_pic");
	var maincropset ="";
	 var valid_check = patient_crop_pic.validate({
			rules: {
				crop_image: {
					required: true,
					extension: "png|jpg|jpeg",
					checkfileheight: true
				},
			},
			messages: {
					crop_image: {
						 required: "",
						 extension: "",
					}                          
			}, 
			submitHandler: function(form) {
				 maincropset = $('.cropit-image-preview').css('background-image').trim();
					  if(maincropset!='none'){
						   var imageData = $('.image-editor').cropit('export');
						   $('body').addClass("show_loader");
							  $.ajax({
									type: "POST",
									url: baseUrl2+"clinic/patients/cropPatientPicAdd", 
									data: "patient_id=&imageData="+imageData,
									dataType: "json",  
									cache:false,
									success: function (response){
										var response = response;
										if(response['msg_type']=='success'){
											var img_path =  $('input[name="img_path"]').val(response['path']);
											$("#patientpic").replaceWith("<img id='patientpic' src=\""+response['path_url']+"\" class=\"img\">");
											var htmlStr2 = "";
											htmlStr2 += "<div class='success_message' style='display:block;' id='newSuccess'><span>";
											htmlStr2 += response['messages'];
											htmlStr2 += "</span></div>";
											$('body').removeClass("show_loader");
											$(".patient_pic_head").prepend(htmlStr2);	
											setTimeout(function(){
												$('.patient_pic_head #newSuccess').remove();
											}, 5000);
											$(".close").trigger("click");
											$('body').removeClass("show_loader");
											}else{
											alert(response['messages']);
											$('body').removeClass("show_loader");
										}
									},
									error: function (xhr, ajaxOptions, thrownError) {
										alert(xhr.status);
										alert(thrownError);
										 $('body').removeClass("show_loader");
									}
							});						
						}
                   return false;
				}
		});
}
});