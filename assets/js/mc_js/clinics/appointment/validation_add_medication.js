var base_url = jQuery('.base_url').val();
$(document).ajaxComplete(function() {
 	
	$('input').blur(function(){
  //alert($(this).val());
    if($(this).val() == ''){
      
       $( this ).css( "border-color", "red" );

        //alert('Enter something');//here you call your desired process   
    }else{
	
	//alert('value');
	$( this ).css( "border-color", "#EEEEEE" );
	}
 
});
  $('.addnewmedtype').on('click', function () {
    
      $('#route').replaceWith($('<input type="text" id="route2" class="form-control required" name="route">')); 
      $( '.addnewmedtype' ).css( "display", "none" );

});

  $('.addnewmedtype2').on('click', function () {
    
      $('#frequency').replaceWith($('<input type="text" id="frequency2" class="form-control required" name="frequency">')); 
      $( '.addnewmedtype2' ).css( "display", "none" );

});

});