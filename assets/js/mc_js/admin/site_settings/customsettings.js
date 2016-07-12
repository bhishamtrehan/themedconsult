/**
 * Custom JS file for Site Settings functions
 * Using ajax, loading bootstrap modal, Add , Edit , Delete functions.
 * @author Visions
 */
var base_url = jQuery('.base_url').val();
jQuery(document).ready(function(){

    jQuery('#tabsclick li a').on('click', function(){

        var table = jQuery(this).data('id');
		$('body').addClass("show_loader");
         jQuery.ajax({
             type : "POST",
             url  : base_url + "master/dataload", 
             data : {table : table},
             dataType : "html",  
             success : 
              function(data){

                    if(table == 'mc_consultation')
                    {
                        jQuery('div #consultation').html(data);
                            $('#cons').DataTable( {
                            "processing": true,
                            "serverSide": false,
                            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                           // $("td:first", nRow).html(iDisplayIndex +1);
                           // return nRow;
                            },
                            bPaginate : $("#cons").find('tbody tr').length>10,
                            "aoColumnDefs": [
                              //{ 'bSortable': false, 'aTargets': [ 0 ] },
                              { 'bSortable': false, 'aTargets': [ 1 ] }
                           ],

                        });
                    }

                    if(table == 'mc_languages')
                    {
                        jQuery('div #languages').html(data);
                            $('#language').DataTable( {
                            "processing": true,
                            "serverSide": false,
                            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                           // $("td:first", nRow).html(iDisplayIndex +1);
                           // return nRow;
                            },
                            bPaginate : $("#language").find('tbody tr').length>10,
                            "aoColumnDefs": [
                             // { 'bSortable': false, 'aTargets': [ 0 ] },
                              { 'bSortable': false, 'aTargets': [ 1 ] }
                           ],

                           
                        });
                    }

                    if(table == 'mc_route')
                    {
                        jQuery('div #route').html(data);
                            $('#routes').DataTable( {
                            "processing": true,
                            "serverSide": false,
                            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                            //$("td:first", nRow).html(iDisplayIndex +1);
                            //return nRow;
                            },
                            bPaginate : $("#routes").find('tbody tr').length>10,
                            "aoColumnDefs": [
                              //{ 'bSortable': false, 'aTargets': [ 0 ] },
                              { 'bSortable': false, 'aTargets': [ 1 ] }
                           ],

                           
                        });
                    }

                    if(table == 'mc_frequency')
                    {
                        jQuery('div #frequency').html(data);
                            $('#freq').DataTable( {
                            "processing": true,
                            "serverSide": false,
                            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                            //$("td:first", nRow).html(iDisplayIndex +1);
                           // return nRow;
                            },
                            bPaginate : $("#freq").find('tbody tr').length>10,
                            "aoColumnDefs": [
                             // { 'bSortable': false, 'aTargets': [ 0 ] },
                              { 'bSortable': false, 'aTargets': [ 1 ] }
                           ],

                        });
                    }

                    if(table == 'mc_speciality')
                    {
                        jQuery('div #speciality').html(' ');
                        jQuery('div #speciality').html(data);
                            $('#specials').DataTable( {
                            "processing": true,
                            "serverSide": false,
                            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                          // $("td:first", nRow).html(iDisplayIndex +1);
                           // return nRow;
                            },
                            bPaginate : $("#specials").find('tbody tr').length>10,
                            "aoColumnDefs": [
                              { 'bSortable': false, 'aTargets': [ 1 ] }
                           ],

                        });
                    }

					$('body').removeClass("show_loader");
              }
        });


    });
	

$('#special').DataTable( {
        "processing": true,
        "serverSide": false,
        "fnRowCallback" : function(nRow, aData, iDisplayIndex){
     //   $("td:first", nRow).html(iDisplayIndex +1);
       //	return nRow;
    	},
        bPaginate : $("#special").find('tbody tr').length>10,
    	"aoColumnDefs": [
 //         { 'bSortable': false, 'aTargets': [ 0 ] },
        { 'bSortable': false, 'aTargets': [ 1 ] },
       ],

       
    });

    /* Add */
    jQuery('.name_add').keypress(function()
    {
      jQuery('.error').html(' ');
    });

    jQuery('.submit').on('click', function(){
    	var input = jQuery('.name_add').val();
        jQuery('.modal_loader').show();
    	var term = jQuery('.term').val();
        var status = jQuery('.status').val();
    	if(input.length === 0)
    	{
            jQuery('.modal_loader').hide();
    		jQuery('.error').html('Field is required');
            return false;
    	}
        else
        {
            jQuery.ajax({
                type : "POST",
                url  : base_url + "master/addFromModal", 
                data : {input : input, term : term, status: status},
                dataType : "html",  
                success : 
                  function(data){
                    jQuery('.modal_loader').hide();
                    jQuery('#myModal').modal('hide');
                    jQuery('#success').show();
                    jQuery('.'+term).trigger('click');
                    $("#success").delay(4000).fadeOut();
                  }
            });
        }

    	
    });

     /* Add End*/


      /* Edit */
        jQuery('.name_edit').keypress(function()
        {
          jQuery('.error').html(' ');
        });

        jQuery('.update').on('click', function(){
            var input = jQuery('.name_edit').val();
            var id = jQuery('.id').val();
            var term = jQuery('.term').val();
            jQuery('.modal_loader').show();
            if(input.length === 0)
            {
                jQuery('.modal_loader').hide();
                jQuery('.error').html('Field is required');
                return false;
            }
            else
            {
                jQuery.ajax({
                    type : "POST",
                    url  : base_url + "master/updateFromModal", 
                    data : {input : input, term : term, id : id},
                    dataType : "html",  
                    success : 
                      function(data){
                        jQuery('.modal_loader').hide();
                        jQuery('#myEditModal').modal('hide');
                        jQuery('#success_update').show();
                        jQuery('.'+term).trigger('click');
                        $("#success_update").delay(4000).fadeOut();
                      }
                });
            }

            
        });

       /* Edit End */


       
	
});


/*Add Modal */ 
function openModal(){
        jQuery('.error').html(' ');
        jQuery('.name_add').val('');
        var name = jQuery('#add_modal').attr('data-name');
        jQuery('#title').html(name);
        jQuery('.name_text').html('Add New'+' '+name+'*');
        jQuery('.term').val(name);
        jQuery('#myModal').modal('show');

}

function openModalConsult(){
        jQuery('.error').html(' ');
        jQuery('.name_add').val('');
        var name = jQuery('#add_modal_c').attr('data-name');
        jQuery('#title').html(name);
        jQuery('.name_text').html('Add New'+' '+name+'*');
        jQuery('.term').val(name);
        jQuery('#myModal').modal('show');

}

function openModalFreq(){
        jQuery('.error').html(' ');
        jQuery('.name_add').val('');
        var name = jQuery('#add_modal_f').attr('data-name');
        jQuery('#title').html(name);
        jQuery('.name_text').html('Add New'+' '+name+'*');
        jQuery('.term').val(name);
        jQuery('#myModal').modal('show');

}

function openModalLang(){
        jQuery('.error').html(' ');
        jQuery('.name_add').val('');
        var name = jQuery('#add_modal_l').attr('data-name');
        jQuery('#title').html(name);
        jQuery('.name_text').html('Add New'+' '+name+'*');
        jQuery('.term').val(name);
        jQuery('#myModal').modal('show');

}

function openModalRoute(){
        jQuery('.error').html(' ');
        jQuery('.name_add').val('');
        var name = jQuery('#add_modal_r').attr('data-name');
        jQuery('#title').html(name);
        jQuery('.name_text').html('Add New'+' '+name+'*');
        jQuery('.term').val(name);
        jQuery('#myModal').modal('show');

}

/*Add Modal End */ 



/*Edit Modal */ 
function editModal(cID,Ctitle, term){
    var title = Ctitle;
    var id = cID;
    var term = term;
    jQuery('.error').html(' ');
    jQuery('#titles').html(term);
    jQuery('.name_text').html('Edit'+' '+term+'*');
    jQuery('.name_edit').val(title);
    jQuery('.id').val(id);
    jQuery('.term').val(term);
    jQuery('#myEditModal').modal('show');
}

function editModal_c(cID,Ctitle, term){
    var title = Ctitle;
    var id = cID;
    var term = term;
    jQuery('.error').html(' ');
    jQuery('#titles').html(term);
    jQuery('.name_text').html('Edit'+' '+term+'*');
    jQuery('.name_edit').val(title);
    jQuery('.id').val(id);
    jQuery('.term').val(term);
    jQuery('#myEditModal').modal('show');
}

function editModal_f(cID,Ctitle, term){
    var title = Ctitle;
    var id = cID;
    var term = term;
    jQuery('.error').html(' ');
    jQuery('#titles').html(term);
    jQuery('.name_text').html('Edit'+' '+term+'*');
    jQuery('.name_edit').val(title);
    jQuery('.id').val(id);
    jQuery('.term').val(term);
    jQuery('#myEditModal').modal('show');
}

function editModal_l(cID,Ctitle, term){
    var title = Ctitle;
    var id = cID;
    var term = term;
    jQuery('.error').html(' ');
    jQuery('#titles').html(term);
    jQuery('.name_text').html('Edit'+' '+term+'*');
    jQuery('.name_edit').val(title);
    jQuery('.id').val(id);
    jQuery('.term').val(term);
    jQuery('#myEditModal').modal('show');
}

function editModal_r(cID,Ctitle, term){
    var title = Ctitle;
    var id = cID;
    var term = term;
    jQuery('.error').html(' ');
    jQuery('#titles').html(term);
    jQuery('.name_text').html('Edit'+' '+term+'*');
    jQuery('.name_edit').val(title);
    jQuery('.id').val(id);
    jQuery('.term').val(term);
    jQuery('#myEditModal').modal('show');
}
/*Edit Modal End*/ 

/* Delete Data*/


function deleteData(cID, term)
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
        var id = cID;
            jQuery.ajax({
                type : "POST",
                url  : base_url + "master/delete_Data", 
                data : {id : id, term : term},
                dataType : "html",  
                success : 
                  function(data){
                    jQuery('#success_delete').show();
                    jQuery('.'+term).trigger('click');
                    $("#success_delete").delay(4000).fadeOut();
                  }
            });
        },
        cancel: function(){
            
        }
    });   
    
}


function deleteData_c(cID, term)
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
        var id = cID;
        jQuery.ajax({
            type : "POST",
            url  : base_url + "master/delete_Data", 
            data : {id : id, term : term},
            dataType : "html",  
            success : 
              function(data){
                jQuery('#success_delete').show();
                jQuery('.'+term).trigger('click');
                $("#success_delete").delay(4000).fadeOut();
              }
        });
        },
        cancel: function(){
            
        }
});
}


function deleteData_l(cID, term)
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
        var id = cID;
        jQuery.ajax({
            type : "POST",
            url  : base_url + "master/delete_Data", 
            data : {id : id, term : term},
            dataType : "html",  
            success : 
              function(data){
                jQuery('#success_delete').show();
                jQuery('.'+term).trigger('click');
                $("#success_delete").delay(4000).fadeOut();
              }
        });
        },
        cancel: function(){
            
        }
});

}


function deleteData_f(cID, term)
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
        var id = cID;
        jQuery.ajax({
            type : "POST",
            url  : base_url + "master/delete_Data", 
            data : {id : id, term : term},
            dataType : "html",  
            success : 
              function(data){
                jQuery('#success_delete').show();
                jQuery('.'+term).trigger('click');
                $("#success_delete").delay(4000).fadeOut();
              }
        });
        },
        cancel: function(){
            
        }
});

}


function deleteData_r(cID, term)
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
        var id = cID;
        jQuery.ajax({
            type : "POST",
            url  : base_url + "master/delete_Data", 
            data : {id : id, term : term},
            dataType : "html",  
            success : 
              function(data){
                jQuery('#success_delete').show();
                jQuery('.'+term).trigger('click');
                $("#success_delete").delay(4000).fadeOut();
              }
        });
        },
        cancel: function(){
            
        }
});

}
        /* Delete Data End*/
