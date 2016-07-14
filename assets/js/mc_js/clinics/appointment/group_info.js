
$(document).ready(function() {
	$('.selGrp').click(function(){
		var grpId = $(this).attr('data-rel');
		var appId = $(this).attr('data-app');
		$('body').addClass("show_loader");
		if($(this). prop("checked") == true){
			$.ajax({
					type: "POST",
					url: baseUrl+"clinic/appointment/addPatienttoGroup", 
					data: "grpId="+grpId+"&appId="+appId,
					dataType: "html",  
					success: function (response) {
						$('body').removeClass("show_loader");
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
						$('body').removeClass("show_loader");
					}
			});
		}
		else if($(this). prop("checked") == false){
			$.ajax({
					type: "POST",
					url: baseUrl+"clinic/appointment/removePatienttoGroup", 
					data: "grpId="+grpId+"&appId="+appId,
					dataType: "html",  
					success: function (response) {
						$('body').removeClass("show_loader");
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
						$('body').removeClass("show_loader");
					}
			});
		}
			
	});

     jQuery("#newGroupFromCalendar").validate({
        rules: {
         grpName: {
            required: true
        }

         },
         messages: {
            
            grpName: {
               required: "Group Name is Required",
               
            }
             

         }
     });
	   
});

