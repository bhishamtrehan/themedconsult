var baseUrl = document.location.origin+'/themedconsult/';

$(document).ready(function(){ 

$( ".deletemedication" ).click(function() {

 var id = $(this).attr('id');


 
    jQuery.confirm({
        title:'Please enter the reason.',
        content: '<textarea class="form-control" id="reason" name="reason" rows="4" cols="50"></textarea>',
       confirm: function(){
        var val = this.$content.find('textarea').val(); // get the input value.
        if(val.trim() == ''){ // validate it.
		//alert('empty');
		
		$('#reason').css('border-color','red');
	

            return false; // dont close the dialog. (and maybe show some error.)
        }
		else{
		 // alert(id);
		 // alert(val);
		 
			$.ajax({
			type: "POST",
			url: baseUrl+"clinic/appointment/update_medications", 
			data: {"id":id,"reason":val},
			dataType: "html",  
			cache:false,
			success: function (response) {
			location.reload(); 
			//alert(response);
				
			}
		});
		 
		 
		 
		}
    }
    });
	

  
  	

  
  
  
  });

});






$(document).ready(function(){ 

$( ".viewmedication" ).click(function() {

 var id = $(this).attr('id');
	//alert('test');


    
		 
			$.ajax({
			type: "POST",
			url: baseUrl+"clinic/appointment/view_medications", 
			data: {"id":id},
			dataType: "html",  
			cache:false,
			success: function (response) {
			//alert(response);
			$( ".modal-content" ).html(response);
			$('body').removeClass("show_loader");
			//$( ".btn-lg" ).trigger( "click" );
				
			}
		});
		 

	

  
  	

  
  
  
  });

});
