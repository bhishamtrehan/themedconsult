// This file contains the jQuery functions of groups on clinic module

$(document).ready(function() {

var base_url = jQuery('.base_url').val();
    

    $('#patientResult').dataTable({ 
    "columns": [
        {"orderable": false, 
         "searchable": false},
        {"searchable": true },
        {"searchable": true },
        {"searchable": true },
        {"searchable": true }
    
    ] 
    });
    
 

});

