var base_url = jQuery('.base_url').val();
$(document).ready(function(){
  $('.success_message').delay(4000).fadeOut();
   $('#viewadmin').DataTable( {
        "processing": true,
        "serverSide": false,

        bPaginate : $("#viewadmin").find('tbody tr').length>10,
      "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ 5 ] },
       ],
    });


   
});

function deactivate(id, status, cId)
{

	$('body').addClass("show_loader");
	jQuery.ajax({
        type : "POST",
        url  : base_url + "master/deactadmin", 
        data : {id : id, status : status, cId: cId},
        dataType : "html",  
        success : 
          function(data){
           $('body').removeClass("show_loader");
           jQuery('#success_deact').show();
           jQuery('#viewadmin tbody').html(data);
           $("#success_deact").delay(4000).fadeOut();
          }
    });
}

function activate(id, status, cId)
{
	$('body').addClass("show_loader");
	jQuery.ajax({
        type : "POST",
        url  : base_url + "master/actadmin", 
        data : {id : id, status : status, cId: cId},
        dataType : "html",  
        success : 
          function(data){
           $('body').removeClass("show_loader");
           jQuery('#success_act').show();
           jQuery('#viewadmin tbody').html(data);
           $("#success_act").delay(4000).fadeOut();
          }
    });
}

function deleteadmin(id, status, cId)
{
 $.confirm({
        title: 'Delete Action',
        content: 'Are you sure want to delete?',
        confirmButton: 'Yes',
        cancelButton: 'No',
        confirmButtonClass: 'btn-danger',
        cancelButtonClass: 'btn-info',
        opacity:1,
        confirm: function(){
        $('body').addClass("show_loader");
        jQuery.ajax({
              type : "POST",
              url  : base_url + "master/deleteadmin", 
              data : {id : id, status : status, cId: cId},
              dataType : "html",  
              success : 
                function(data){
                 jQuery('#success_delete').show();
                 $('body').removeClass("show_loader");
                 jQuery('#viewadmin tbody').html(data);
                 $("#success_delete").delay(4000).fadeOut();
                }
    });
        },
        cancel: function(){
            
        }
    }); 

}