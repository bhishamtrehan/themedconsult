// This file contains the jQuery functions of groups on clinic module

$(document).ready(function() {

  var base_url = jQuery('.base_url').val();

  $('.consultationHistory').on('click', function(){
      var patientId = $(this).data('patientid');

      $.ajax({
        type: "POST",
        url: baseUrl+"clinic/groups/patientConsultation",
        dataType: "html",
        data:{patientid : patientId},
        success: function(response)
        {
          $(".modal-content").html(response);
          $( ".btn-lg" ).trigger( "click" );
        }
      });
  });


  $('.billSummary').on('click', function(){
      var patientId = $(this).data('patientid');

      $.ajax({
        type: "POST",
        url: baseUrl+"clinic/groups/patientBilling",
        dataType: "html",
        data:{patientid : patientId},
        success: function(response)
        {
          $(".modal-content").html(response);
          $( ".btn-lg" ).trigger( "click" );
        }
      });
  });


    
});

