var baseUrl = document.location.origin+'/themedconsult/';
$(document).ready(function() {

		$("#url_section").css( "display", "none" );
        $("#upload_section").css( "display", "none" );
        $("#submit_section").css( "display", "none" );


    $('input:radio[name=bedStatus]').change(function() {

        if (this.id == 'url') {
        $("#url_section").css( "display", "block" );
        $("#upload_section").css( "display", "none" );
        $("#submit_section").css( "display", "block" );
        $( "#upload_file" ).val('');
        $( "#inst_submit" ).click(function() {
        	var value= $( "#instruction_url" ).val();
          if($.trim(value)=='')
          {
          	$("#instruction_url.form-control").css( "border-color", "red" );
 		$("#filePhoto.form-control").css( "border-color", "#ccc" );
          }else{

          	after_submit();
          }

        });

        }

        else if (this.id == 'upload') {

         $("#url_section").css( "display", "none" );
        $("#upload_section").css( "display", "block" );
        $("#submit_section").css( "display", "block" );
         $( "#instruction_url" ).val('');

          $( "#inst_submit" ).click(function() {
        	var value= $( "#filePhoto" ).val();
          if($.trim(value)=='')
          {
          		$("#instruction_url.form-control").css( "border-color", "#ccc" );
          	$("#filePhoto.form-control").css( "border-color", "red" );

          }else{

          	after_submit();
          }

        });



        }
    });


 function readURL(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function(e) {
	      $('#previewHolder').attr('src', e.target.result);
	    }

	    reader.readAsDataURL(input.files[0]);
	  }
	}


			$("#filePhoto").change(function() {
			  readURL(this);
			});


			 function after_submit() {
				var url= $( "#instruction_url" ).val();
				var appt_id= $( "#appt_id" ).val();
				var upload_file= $( "#filePhoto" ).val();
				var src=  $("#previewHolder").attr('src');
				$('body').addClass("show_loader");
				$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/add_instruction_patient", 
				data: {"url" :url,"src":src,"upload_file":upload_file,"appt_id":appt_id},
				dataType: "html",  
				cache:false,
				success: function (response) {
					//alert(response);
					$( ".modal-content" ).html(response);
					$('body').removeClass("show_loader");
					// setTimeout(function(){
					//     location.reload();
					// },4000);
					//$( ".btn-lg" ).trigger( "click" );
				}
			});

			 // alert( "Handler for .click() called." );
			};



});