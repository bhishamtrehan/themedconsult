var base_url = jQuery('.base_url').val();
jQuery(document).ready(function(){
	jQuery('#viewcomapny').DataTable( {
        "processing": true,
        "serverSide": false,
 		"fnRowCallback" : function(nRow, aData, iDisplayIndex){
                            $("td:first", nRow).html(iDisplayIndex +1);
                            return nRow;
                            },
       bPaginate : jQuery("#viewcomapny").find('tbody tr').length>10,
      "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ 0 ] },
          { 'bSortable': false, 'aTargets': [ 2 ] },
       ],
    });
	
	
	  /* Edit */
        jQuery('.name_edit').keypress(function()
        {
          jQuery('.error').html(' ');
        });

        jQuery('.update').on('click', function(){
            var input = jQuery('.name_edit').val();
            var id = jQuery('.id').val();

            if(input.length === 0)
            {
                jQuery('.error').html('Field is required');
                return false;
            }
            else
            {
                jQuery.ajax({
                    type : "POST",
                    url  : base_url + "master/company/updateFromModal", 
                    data : {input : input, id : id},
                    dataType : "html",  
                    success : 
                      function(data){
                        jQuery('#myEditModal').modal('hide');
                        jQuery('#success_update').show();
						   window.location = base_url + 'master/company/view';
                        $("#success_update").delay(4000).fadeOut();
                      }
                });
            }

            
        });

       /* Edit End */
});

function openCompanyModal()
{
	jQuery('#myCompanyModal').modal('show');
}

/*Edit Modal */ 
function editModal(cID,Ctitle){
    var title = Ctitle;
    var id = cID;
    jQuery('.name_edit').val(title);
    jQuery('.id').val(id);
    jQuery('#myEditModal').modal('show');
}

jQuery('.name_company').keypress(function()
    {
      jQuery('.error').html(' ');
    });

jQuery('.submit').on('click', function(){
    	var input = jQuery('.name_company').val();
    	if(input.length === 0)
    	{
    		jQuery('.error').html('Field is required');
            return false;
    	}
        else
        {
             jQuery.ajax({
                 type : "POST",
                 url  : base_url + "master/company/addFromModal", 
                 data : {input : input},
                 dataType : "html",  
                 success : 
                   function(data){
                     jQuery('#myModal').modal('hide');
                     jQuery('#success').show();
                     window.location = base_url + 'master/company/view';
                     $("#success").delay(4000).fadeOut();
                   }
             });
        }

    	
    });