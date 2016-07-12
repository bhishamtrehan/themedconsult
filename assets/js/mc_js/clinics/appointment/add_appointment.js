$(document).ready(function(){
	var baseUrl = document.location.origin+'/themedconsult';

	// date picker
	$( "#search_date" ).datepicker();
  $( "#search_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );


	$( "#search_date_of_birth" ).datepicker();
  $( "#search_date_of_birth" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  // date picker end



	$("#appnt_type_dropdown").click(function() {
	  $(".appt_list").toggle( "", function() {
	  });
	});
	
   $('.appointment_type_option').click(function(){
		var selectedAppntType = $(this).html();
		$('#appnt_type_dropdown').html(selectedAppntType);
		$('#appointment_type').val($(this).attr('id'));
		$('.appt_list').hide();
	});
	$('.patient_field').click(function(){
                //$('.patient_search_for').focus();
               // alert('clicked');
               // $( ".btn-lg" ).trigger( "click" );                
                
	});

	$('#firstname, #surname, #search_date').keyup(function(){
		
		var firstname= $("#firstname").val();

		var surname= $("#surname").val();
		var date= $("#search_date").val();
		
		//alert(firstname+surname+date);
		
		$.ajax({
				type: "POST",
				url: baseUrl+"/clinic/appointment/search_patient_form", 
				data: {"firstname":firstname,"surname":surname,"date":date},
				dataType: "html",  
				cache:false,
				success: function (responseData) {
						//alert(responseData);
					$('#patient_results').html(responseData);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
                
        });

	
	$('.patient_search_for').keyup(function(){
		var search_for = $(this).val();
		$.ajax({
				type: "POST",
				url: baseUrl+"/clinic/appointment/search_patient", 
				data: "search_for="+search_for,
				dataType: "html",  
				cache:false,
				success: function (responseData) {

					$('#patient_search_results').html(responseData);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
                
        });
        
        $('#is_casual').change(function(){
		var casual_val = $(this).val(); 
                if(casual_val == 1)
                {
                    $('#patient_and_desc').hide();
                }
                else
                {
                    $('#patient_and_desc').show();
                }
	});
});

function validateAppnt() { 
	var baseUrl = document.location.origin+'/themedconsult';
	
        var is_casual = $("#is_casual").val(); 
        var notess = $('#appointment_notes').val();
       
	   if($(".patient_field").val() == '') {
                    alert('Please select patient!');
                    return false;
            }
	var start_hour   = $('#appointment_hour').val(); 
	var start_minute = $('#appointment_minute').val();
	var start_format = $('#appointment_time_format').val();
	var end_hour     = $('#appointment_end_hour').val();
	var end_minute   = $('#appointment_end_minute').val();
	var end_format   = $('#appointment_end_time_format').val();
	var start_time	 = start_hour+':'+start_minute+' '+start_format;
	var end_time	 = end_hour+':'+end_minute+' '+end_format;
	var appnt_date   = $('#appointment_date').val();
	
	var start24Hour = ConvertTimeformat("00:00",start_hour+':'+start_minute+' '+start_format);
	var end24Hour   = ConvertTimeformat("00:00",end_hour+':'+end_minute+' '+end_format);
	var timeDiffer  = get_time_difference("01/18/2012 "+start24Hour, "01/18/2012 "+end24Hour);
	if( (timeDiffer.hours < 0) || ((timeDiffer.hours == 0) && (timeDiffer.minutes == 0)) ) {
		alert("Appointment end time should be greater than start time!");
		return false;
	}
	
	var patient_id   = $('#patient_field_id').val();
	var loc_prac     = $('#location_prac').val();
	var appnt_id     = $('#appointment_id').val();
    
        if(is_casual == 1 && (patient_id == '' || patient_id == 0))
        {
            $('#patient_field_id').val(0);
            
            if(notess == '')
            {
                $('#appointment_notes').css('border','1px solid red');
                return false;
            }
            else
            {
                $('#appointment_notes').css('border','1px solid #ccc');
            }
        }
        
        if($('#form_save').val() != 1)
        {
            $.ajax({
                            url: baseUrl+'/clinic/appointment/validate_appointment',
                            dataType:'json',
                            data:'patient_id='+patient_id+'&practitioner_id='+loc_prac+'&start_time='+start_time+'&end_time='+end_time+'&appointment_date='+appnt_date+'&appointment_id='+appnt_id,
                            success:function(response)
                            { 
                                    if(response.status == 'true') {
                                            $('#form_save').val(1);
                                            
                                            setTimeout(function(){ 
                                                $('#appoint_submit').click();
                                            }, 500);                                            
                                                                                   
                                    } else {
                                            alert(response.msg);                                            
                                    }
                            }
            });
            return false;
        }        
}
function get_time_difference(start,end) {      
    start = new Date(start);
    end = new Date(end);
    var diff = end.getTime() - start.getTime();                 
    var time_difference = new Object();

    time_difference.hours = Math.floor(diff/1000/60/60);        
    diff -= time_difference.hours*1000*60*60;
    if(time_difference.hours < 10) time_difference.hours = time_difference.hours;

    time_difference.minutes = Math.floor(diff/1000/60);     
    diff -= time_difference.minutes*1000*60;    
    if(time_difference.minutes < 10) time_difference.minutes = time_difference.minutes;                                  

    return time_difference;              
}
function ConvertTimeformat(format, str) {
    var hours = Number(str.match(/^(\d+)/)[1]);
    var minutes = Number(str.match(/:(\d+)/)[1]);
    var AMPM = str.match(/\s?([AaPp][Mm]?)$/)[1];
    var pm = ['P', 'p', 'PM', 'pM', 'pm', 'Pm'];
    var am = ['A', 'a', 'AM', 'aM', 'am', 'Am'];
    if (pm.indexOf(AMPM) >= 0 && hours < 12) hours = hours + 12;
    if (am.indexOf(AMPM) >= 0 && hours == 12) hours = hours - 12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if (hours < 10) sHours = "0" + sHours;
    if (minutes < 10) sMinutes = "0" + sMinutes;
    if (format == '0000') {
        return (sHours + sMinutes);
    } else if (format == '00:00') {
        return (sHours + ":" + sMinutes);
    } else {
        return false;
    }
}
function update_duration() {
	var startHour 	= $('#appointment_hour').val();
	var startMin 	= $('#appointment_minute').val();
	var startFormat = $('#appointment_time_format').val();
	var endHour 	= $('#appointment_end_hour').val();
	var endMin 		= $('#appointment_end_minute').val();
	var endFormat 	= $('#appointment_end_time_format').val();
	
	var start24Hour = ConvertTimeformat("00:00",startHour+':'+startMin+' '+startFormat);
	var end24Hour   = ConvertTimeformat("00:00",endHour+':'+endMin+' '+endFormat);
	var timeDiffer  = get_time_difference("01/18/2012 "+start24Hour, "01/18/2012 "+end24Hour);
	
	if( (timeDiffer.hours < 0) || ((timeDiffer.hours == 0) && (timeDiffer.minutes == 0)) ) {
		alert("Appointment end time should be greater than start time!");
	} else {
		$('#appnt_duration_label').html((timeDiffer.hours*60)+timeDiffer.minutes);
	}
}
function toSeconds(time_str) {
    // Extract hours, minutes and seconds
    var parts = time_str.split(':');
    // compute  and return total seconds
    return parts[0] * 3600 + // an hour has 3600 seconds
    parts[1] * 60 + // a minute has 60 seconds
    +
    parts[2]; // seconds
}
function popitup(url) {
	//newwindow=window.open(url,"name","height=300,width=400,top=20,left=20");
	//if (window.focus) {newwindow.focus()}

		   BootstrapDialog.show({
		   	cssClass: 'add_c_appointment',
            message: $('<div></div>').load(url)
        });
	//return false;

}
function getLocationPrac(locationID){
	var baseUrl = document.location.origin+'/themedconsult';
	if(locationID != '') {
		$.ajax({
				type: "POST",
				url: baseUrl+"/clinic/appointment/getPractitioners", 
				data: "locationID="+locationID,
				dataType: "html",  
				cache:false,
				success: function (response) {
						$('#location_prac').html(response);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
	}
}

$('#add_new_patient').click(function(){
		
	

		var surname= $("#surname2").val();

		var fname= $("#fname").val();
		var username= $("#username").val();
		var email= $("#email").val();
		var pwd= $("#pwd").val();
		var dob= $("#dob").val();
		var gender = $("input[type='radio'].gender:checked").val();
		var country= $("#country").val();
		var clinic_location_id= $("#clinic_location_id").val();
	
		// alert(clinic_location_id);
		
		
		
		$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/add_new_patient", 
				data: {"surname":surname,"fname":fname,"username":username,"email":email,"pwd":pwd,"dob":dob,"gender":gender,"country":country,"clinic_location_id":clinic_location_id},
				dataType: "html",  
				cache:false,
				success: function (responseData) {
						alert(responseData);
						if(responseData==1){
							  $(".error_msg").css( "display", "block" );
						}
						else{

							  $(".success_msg").css( "display", "block" );
						}
					//$('#patient_results').html(responseData);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
                
        });




$(document).on('click', '.clickpatient', function(){ 

		$('#firstname').val('');
		$('#surname').val('');
		$('#search_date').val('');

	var abc=  $(this).text();
	//alert(abc);

	        var tr = $(this).closest('tr');
	         var id = $(tr).attr('id');
        var first_name = tr.find('.first_name').text();
        var lname = tr.find('.lname').text();
        var date_birth = tr.find('.date_birth').text();

	// var first_name = $('.first_name').text();
	// var lname = $('.lname').text();
	// var date_birth = $('.date_birth').text();
	
	//alert(id+first_name+lname+date_birth);

	 $('#patient_field_id').val(id);
	 $('#firstname').val(first_name);
	 $('#surname').val(lname);
	 $('#search_date').val(date_birth);
	 $('#appoint_submit').css( "display", "block" );

//alert(first_name+lname+date_birth);
	
		
	
});

$('#appt_validat').on('click',function(){
 

//alert('DFGJKL');

	var surname  =$('#add_surname').val();
	var fname  =$('#fname').val();
	var username  =$('#username').val();
	var email  =$('#email').val();
	var pwd  =$('#pwd').val();
	var search_date_of_birth  =$('#search_date_of_birth').val();
	
	//var usercheck= $( ".checked_username" ).text();
	var country  =$('#country').val();


	function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
 	
	if(surname =='' ){
		
	 $('#add_surname.required.form-control').css( "border-color", "red" );	
	// alert('s');
	}
	else if(fname =='' ){
		//alert('fn');
	 $('#fname.required.form-control').css( "border-color", "red" );	
	 $('#add_surname.required.form-control').css( "border-color", "#ccc" );	
	}
	else if(username =='' ){
		//alert('us');
		 $('#username.required.form-control').css( "border-color", "red" );	
		 $('#fname.required.form-control').css( "border-color", "#ccc" );
	}

	else if(email ==''){
		//alert('email');
		 $('#username.required.form-control').css( "border-color", "#ccc" );	
		 $('#email.required.form-control').css( "border-color", "red" );	
	}
	else if(!ValidateEmail(email)){
		//alert('email12');
		$('#username.required.form-control').css( "border-color", "#ccc" );	
		 $('#email.required.form-control').css( "border-color", "red" );	
	}
	
	else if(pwd =='' ){
		//alert('pwd');
		 $('#email.required.form-control').css( "border-color", "#ccc" );
		 $('#pwd.required.form-control').css( "border-color", "red" );	
	}
	else if(search_date_of_birth =='' ){
		//alert('date');
		 $('#pwd.required.form-control').css( "border-color", "#ccc" );	
		 $('#search_date_of_birth.form-control').css( "border-color", "red" );	
	}
	else if(country =='' ){
		//alert('country');
		 $('#search_date_of_birth.form-control').css( "border-color", "#ccc" );
		 $('#country.required.form-control').css( "border-color", "red" );	
	}
	else{

			//alert('hii');
		$( "#appoint_submit" ).trigger( "click" );
	}

});



$( "#username" ).on('focusout',function() {

		var username  =$('#username').val();
 	$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/search_check_username", 
				data: {"username":username},
				dataType: "html",  
				cache:false,
				success: function (responseData) {
						//alert(responseData);
						if(responseData==1){
							 $('.checked_username').css( "display", "block" );
							 $('.checked_username').css( "color", "red" );
							  $('#username.required.form-control').css( "border-color", "red" );	
							 $('#username').val('');

						}else{

							 $('.checked_username').css( "display", "none" );
						}
					//$('.checked_username').html(responseData);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
});