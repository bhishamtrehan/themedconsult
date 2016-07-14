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
          console.log(response);
        }
      });
  });


    
});

