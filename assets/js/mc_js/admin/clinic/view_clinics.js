
$(document).ready(function() {
 
	$('#clinicListing').dataTable({ 
	"columns": [
		{"searchable": true },
		{"searchable": false },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		{"bSortable": false }
    ] 
	});
	
	$('#clinicListingaccess').dataTable({ 
	"columns": [
		{"searchable": true },
		{"searchable": false },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		
    ] 
	});
});
function view_clinic(clinic_id){
	var baseUrl = document.location.origin+'/smarthealthcare/';
		if(clinic_id!='' && clinic_id!=0){
                    $('body').addClass("show_loader");
                    $.ajax({
                            type: "POST",
                            url: baseUrl+"admin/clinics/viewclinic", 
                            data: "clinic_id="+clinic_id,
                            dataType: "html",  
                            cache:false,
                            success: function (response) {
                                    $(".modal-content").html(response);
                                    $('body').removeClass("show_loader");
                                    $(".btn-lg").trigger("click");  
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status);
                                    alert(thrownError);
                            }
                    });
		}
}

