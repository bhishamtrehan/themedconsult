var baseUrl = document.location.origin+'/themedconsult/';

$(document).ready(function(){ 

// $( "#submit_newconsult1" ).click(function() {

// 		var hp_id = $( "#hp_id" ).val();
// 		var speciality = $( "#speciality" ).val();
// 		var consultation_type = $("#consultation_type").val();
// 		var medical_clinic = $("#medical_clinic").val();
// 		var billing_detail = $("#billing_detail" ).val();
// 		$('#public_access').bind('click',function() {
// 			if($(this).is(':checked')) {
// 				var public_access='1';
// 				}
// 			});
// 		$('#patient_access').bind('click',function() {
// 			if($(this).is(':checked')) {
// 			var patient_access='1';
// 			}
// 		});
		
// 		var serviceprovider = $("#serviceprovider_by_search" ).val();
// 		var type_of_investigation = $("#type_of_investigation" ).val();
// 		var clinical_notes = $("#clinical_notes" ).val();
// 		var refferal_title = $("#refferal_title" ).val();
// 		var health_professional = $("#hp_id_by_search" ).val();
// 		var refferal_notes = $("#refferal_notes" ).val();
// 		var media_image = $("#media_image" ).val();
// 		var investigator_image = $("#investigator_image" ).val();
// 		var refferal_image = $("#refferal_image" ).val();
			
		
// 			$.ajax({
// 			type: "POST",
// 			url: baseUrl+"clinic/appointment/new_consultation", 
// 			data: {"hp_id":hp_id,"speciality":speciality,"consultation_type":consultation_type,"medical_clinic":medical_clinic,"billing_detail":billing_detail,"public_access":public_access,"patient_access":patient_access,"serviceprovider":serviceprovider,"type_of_investigation":type_of_investigation,"clinical_notes":clinical_notes,"refferal_title":refferal_title,"health_professional":health_professional,"refferal_notes":refferal_notes,"media_image":media_image,"investigator_image":investigator_image,"refferal_image":refferal_image},
// 			dataType: "html",  
// 			cache:false,
// 			success: function (response) {
// 			alert(response);
// 			// if(response==1){
			
// 			// $( ".successmsg" ).append('New Consultation is saved successfully!');
// 			// }
// 			// else{
// 			// $( ".successmsg" ).append('New Consultation is not saved.');
// 			// }
				
// 			}
// 		});
//     });
	
 $(".billing").keyup(function(e){

        var id = $(this).attr("id");
		
		var value=$(this).val();
	$('body').addClass("show_loader");
		$.ajax({
			type: "POST",
			url: baseUrl+"clinic/appointment/billing_detail", 
			data: {"id" :id,"value":value},
			dataType: "html",  
			cache:false,
			success: function (response) {
			
			$( ".showbillingdata" ).html(response);
			//console.log(data);
			$('body').removeClass("show_loader");
			//$( ".btn-lg" ).trigger( "click" );
				
			}
		});
	
	
	
    });
	

$(document).on('click', '.clickbilling', function(){ 
	var id = $(this).attr("id");
	var row = $(this).html();
		$(this).closest ('tr').remove ();

	var	value=id;
	//alert(value);
	  // var zipcodeValue = $jq(this).val();
    //alert(zipcodeValue);
    var oldVal = $('#billing_detail').val();
    $('#billing_detail').val(value+","+oldVal );
	
	
	$( "#selecteddata" ).append('<tr>'+row+'<td class="remove"><i class="fa fa-times-circle" aria-hidden="true"></i></td></tr>');
		
	
}); 

$(document).on('click', '.remove', function(){ 

			$(this).closest ('tr').remove ();


	
}); 




// function handleFileSelect(event) 
// {
    // console.log(event)
    // var input = this;
	// if (input.files && input.files[0])
    // {
	    // var reader = new FileReader();
        // console.log(reader)
        // reader.onload = (function (e)
        // {
	        // var span = document.createElement('span');
		    // span.innerHTML = ['<img height="150" width="150" class="thumb" src="',e.target.result, '" title="', escape(e.name), '"/><span aria-hidden="true" class="glyphicon glyphicon-remove remove_img_preview"></span></div>'].join('');
	    // document.getElementById('preview').insertBefore(span, null);
	    // });
        // reader.readAsDataURL(input.files[0]);
    // }
// }
           
// $('#files').change(handleFileSelect);	

// $('#preview').on('click', '.remove_img_preview',function ()
// {
	// $(this).parent('span').remove();
    // $(this).val("");
// });



 $("#health_professional_refferal").keyup(function(e){

       
		var value=$(this).val();
		
	//$('body').addClass("show_loader");
		$.ajax({
			type: "POST",
			url: baseUrl+"clinic/appointment/get_hp_info_form", 
			data: {"value":value},
			dataType: "html",  
			cache:false,
			success: function (response) {
			
			$( ".search_health" ).html(response);
			//console.log(data);
			//$('body').removeClass("show_loader");
			//$( ".btn-lg" ).trigger( "click" );
				
			}
		});
	
	
	
    });
 $("#serviceprovider").keyup(function(e){

   
		var value=$(this).val();
		   // alert(value);
	 
	//$('body').addClass("show_loader");
		$.ajax({
			type: "POST",
			url: baseUrl+"clinic/appointment/get_clinic_admin_form", 
			data: {"value":value},
			dataType: "html",  
			cache:false,
			success: function (response) {
			
			$( ".search_serviceprovider" ).html(response);
			
				
			}
		});
	
	
	
    });
	
	
	$(document).on('click', '.clickhp', function(){ 
	var id = $(this).attr("id");
	//alert(id);
	var row = $.trim($(this).text());
		//alert(row);


		$("#hp_id_by_search").val(id);
	 $("#health_professional_refferal").val(row);
		$( "#table" ).remove();
		
	
});

$(document).on('click', '.clicksp', function(){ 
	var id = $(this).attr("id");
	//alert(id);
	var row = $.trim($(this).text());
		//alert(row);


		$("#serviceprovider_by_search").val(id);
	 $("#serviceprovider").val(row);
		$( "#table" ).remove();
		
	
});
	



	
  });

/////  image upload 



// $(document).ready(function() { /* Function to upload Entity1 pic */
// $('.fileToUpload').on('change', function(){  
// 	 var attr =$(this).attr('data-rel');
// 	 var img_name=$(this).attr('value');
// 	 $('#media_image').val(img_name);
// 	// var value =$(this).val();
//     var url =  baseUrl+'clinic/appointment/upload_media'; 
		
//         jQuery.ajaxFileUpload
//         (
//             {
//                 url:url,
//                 secureuri:false,
//                 fileElementId:attr,
// 				dataType: 'json',
//                 success: function (data, status)
//                 {
				
//                 },
//                 error: function (data, status, e)
//                 {
// 					$('.contentLoader').css('display', 'none');
// 					$('.contentLoader').html('');
//                     alert(e);
//                 }
//             }
//         )
		
       
//         return false;

//     })


// });

// $(document).ready(function() { /* Function to upload Entity1 pic */
// $('.fileToUpload1').on('change', function(){  
// 	 var attr =$(this).attr('data-rel');
// 	 var img_name=$(this).attr('value');
	 
// 	 $('#investigator_image').val(img_name);
// 	// var value =$(this).val();
//     var url =  baseUrl+'clinic/appointment/upload_investigation_media'; 
		
//         jQuery.ajaxFileUpload
//         (
//             {
//                 url:url,
//                 secureuri:false,
//                 fileElementId:attr,
// 				dataType: 'json',
//                 success: function (data, status)
//                 {
				
//                 },
//                 error: function (data, status, e)
//                 {
// 					$('.contentLoader').css('display', 'none');
// 					$('.contentLoader').html('');
//                     alert(e);
//                 }
//             }
//         )
		
       
//         return false;

//     })


// });


// $(document).ready(function() { /* Function to upload Entity1 pic */
// $('.fileToUpload2').on('change', function(){  
// 	 var attr =$(this).attr('data-rel');
// 	 var img_name=$(this).attr('value');
// 	 $('#refferal_image').val(img_name);
// 	// var value =$(this).val();

//     var url =  baseUrl+'clinic/appointment/upload_pdf'; 
		
//         jQuery.ajaxFileUpload
//         (
//             {
//                 url:url,
//                 secureuri:false,
//                 fileElementId:attr,
// 				dataType: 'json',
//                 success: function (data, status)
//                 {
				
//                 },
//                 error: function (data, status, e)
//                 {
// 					$('.contentLoader').css('display', 'none');
// 					$('.contentLoader').html('');
//                     alert(e);
//                 }
//             }
//         )
		
       
//         return false;

//     })
// });

