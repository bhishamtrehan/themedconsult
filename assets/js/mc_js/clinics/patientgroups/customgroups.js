// This file contains the jQuery functions of groups on clinic module

$(document).ready(function() {

var base_url = jQuery('.base_url').val();
	
	$("#search_date").datepicker( "option", "dateFormat", "yy-mm-dd" );

	$('#patientResult').dataTable({ 
	"columns": [
		{"orderable": false,  "searchable": false},
		{"searchable": true },
		{"searchable": true },
		{"searchable": true },
		{"searchable": true }
	
    ] 
	});
	
	$("#addGroupForm").validate({
		rules: {
			grpName: {
				required: true,
				nospace: true,
				number: true,
				minValue: true,
			},
			selectedUser: {
				required: true,
			}
		},
		messages: {
			grpName: {
				required: "The group name is required",
			},
			selectedUser: {
				required: "asdasdasddasdsdfsdfsdf dsadfsdf afsdfsd",
			}
		}
	});

});

