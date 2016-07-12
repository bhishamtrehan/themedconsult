$(document).ready(function() {

$(".archive").click(function(){

      var id = $(this).attr("data-id");
  $('body').addClass("show_loader");
 $(this).parents(".n_listOuter > li").hide();
        // alert(id);
  //  return false;

      
   
        $.ajax({
            type: "POST",
            url: baseUrl+"clinic/notifications/update_archive_notification", 
            data: {"id" :id},
            dataType: "html",  
            cache:false,
            success: function (response) {
            
            $( ".showbillingdata" ).html(response);
            //console.log(data);
            $('body').removeClass("show_loader");
           
            //$( ".btn-lg" ).trigger( "click" );
                
            }
        });
    
    
    });


$(".delete").on("click",function(){

 var id = $(this).attr("data-id");
      //  alert(id);
  //  return false;
 $('body').addClass("show_loader");
  $(this).parents(".n_listOuter > li").hide();
        $.ajax({
            type: "POST",
            url: baseUrl+"clinic/notifications/update_delete_notification", 
            data: {"id" :id},
            dataType: "html",  
            cache:false,
            success: function (response) {
            
            $( ".showbillingdata" ).html(response);
            //console.log(data);
            $('body').removeClass("show_loader");
            //$(this).parents(".n_listOuter > li").hide();
            //$( ".btn-lg" ).trigger( "click" );
                
            }
        });
    
    
    });


$(".restore").on("click",function(){

 var id = $(this).attr("data-id");
      //  alert(id);
  //  return false;
 $('body').addClass("show_loader");
  $(this).parents(".n_listOuter > li").hide();
        $.ajax({
            type: "POST",
            url: baseUrl+"clinic/notifications/restore_notification", 
            data: {"id" :id},
            dataType: "html",  
            cache:false,
            success: function (response) {
            
          //  $( ".showbillingdata" ).html(response);
            //console.log(data);
            $('body').removeClass("show_loader");
            //$(this).parents(".n_listOuter > li").hide();
            //$( ".btn-lg" ).trigger( "click" );
                
            }
        });
    
    
    });




$("#recycle").on("click",function(){

    $('body').addClass("show_loader");
        $.ajax({
            type: "POST",
            url: baseUrl+"clinic/notifications/deleted_notification", 
           
            dataType: "html",  
            cache:false,
            success: function (response) {
            
                
            }
        });
    
    
    });



$("#archive").on("click",function(){

    $('body').addClass("show_loader");
        $.ajax({
            type: "POST",
            url: baseUrl+"clinic/notifications/archived_notification", 
           
            dataType: "html",  
            cache:false,
            success: function (response) {
            
                
                
            }
        });
    
    
    });


    });
