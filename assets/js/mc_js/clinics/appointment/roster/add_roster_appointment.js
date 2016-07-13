$(document).ready(function(){
	var baseUrl = document.location.origin+'/themedconsult';
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
	// $('.patient_field').click(function(){
 //                //$('.patient_search_for').focus();
 //                $( ".btn-lg" ).trigger( "click" );                
                
	// });
	
	$('.pracs_search_for').keyup(function(){
		var search_for = $(this).val();
		var clinicId = $('#clinic_Id').val();
		$.ajax({
				type: "POST",
				url: baseUrl+"/clinic/appointment/search_prac_roster", 
				data:{ search_for : search_for, clinicId : clinicId },
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
                    alert('Please select Practitioner!');
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
	
	var room_id   = $('#clinic_Room').val();
	var loc_prac     = $('#location_prac').val();
	var appnt_id     = $('#appointment_id').val();
    
        if(is_casual == 1 && (room_id == '' || room_id == 0))
        {
            $('#clinic_Room').val(0);
            
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
                            url: baseUrl+'/clinic/appointment/validate_roster',
                            dataType:'json',
                            data:'room_id='+room_id+'&practitioner_id='+loc_prac+'&start_time='+start_time+'&end_time='+end_time+'&appointment_date='+appnt_date+'&appointment_id='+appnt_id,
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
		
		 $('#updated_duration').val((timeDiffer.hours*60)+timeDiffer.minutes);
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
	//alert('hjkl');
	BootstrapDialog.show({
     	cssClass: 'add_c_appointment',
            message: $('<div></div>').load(url)
        });
	// newwindow=window.open(url,"name","height=300,width=400,top=20,left=20");
	// if (window.focus) {newwindow.focus()}
	// return false;
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


	// $('.patient_field').keyup(function(){
$( "body" ).delegate( ".patient_field", "keyup", function() {
		//alert('hello');
		var search_for = $('#patient_field').val();
		var clinicId = $('#clinic_Id').val();
	
		$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/search_prac_roster", 
				data:{ search_for : search_for, clinicId : clinicId },
				dataType: "html",  
				cache:false,
				success: function (responseData) {
					//alert(responseData);
					$('.result_hpinfo').html(responseData);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		});
                
        });