// This file contains the jQuery functions of groups on clinic module

$(document).ready(function() {

	

var base_url = jQuery('.base_url').val();
	
      $("#search_date").datepicker( "option", "dateFormat", "yy-mm-dd" );
      
      // search patient
      $('#search_patient').on('click', function(){
        
      });

      // create new group
      $('#newGroup').on('click', function(){

        // var userID = $('#current_user').val();
            
            $('body').addClass("show_loader");
            
            $.ajax({
              type: "POST",
              url: baseUrl+"clinic/groups/add", 
              dataType: "html",  
              cache:false,
              success: function (response) {
              $('#groupslist_li').removeClass('active');
              $('#newg_li').addClass('active');
              
              $( ".dashboardWrap" ).html(response);
              $('body').removeClass("show_loader");
              
                  
              }
          });
      });


      $('.grpId').on('click', function(){

      	var gId = $(this).data('groupid');
      	
      	$('body').addClass("show_loader");
            
            $.ajax({
              type: "POST",
              url: baseUrl+"clinic/groups/showSingleGroup", 
              dataType: "html",
              data:{id:gId},
              cache:false,
              success: function (response) {
               $( ".dashboardWrap" ).html(response);
               $('body').removeClass("show_loader");
              
                  
              }
          });

      });
$('#groupListInfo').dataTable({ 
	"columns": [
		{"searchable": true },
		{"searchable": true },
		{"searchable": false }
	
    ] 
	});
    
});

