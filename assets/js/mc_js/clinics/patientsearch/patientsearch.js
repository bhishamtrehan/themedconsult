$(document).ready(function() {

$("#patient_search").click(function(){

    var patient_surname=$("#patient_surname").val();
    var patient_firstname=$("#patient_firstname").val();
    var dob=$("#dob").val();
        //alert(patient_surname+patient_firstname+dob);

      
   
        $.ajax({
            type: "POST",
            url: baseUrl+"clinic/patientsearch/patient_detail", 
            data: {"patient_surname" :patient_surname,"patient_firstname" :patient_firstname,"dob" :dob},
            dataType: "html",  
            cache:false,
            success: function (response) {
            
            // $( ".showbillingdata" ).html(response);
             $( ".view_php" ).html('');
             $( ".view_php" ).html(response);
        
                
            }
        });
    
    
    });

 });

