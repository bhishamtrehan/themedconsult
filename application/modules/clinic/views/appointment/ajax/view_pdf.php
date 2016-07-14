<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 
		echo $this->lang->line('pdf'); 

		
		?>	
	</h4>
</div>
<div class="modal-body ">
<div class="panel panel-primary">
<div class="message"></div>
<form id="pdf_file123" method="post" enctype="multipart/form-data">

    <input id="inputFileToLoad" type="file" name="new_pdf_file"  />
     <input type="hidden" name="user_id" value="<?php echo $userid;?>">
 
  <input type="submit" class="pdf_submit" value="submit">
  </form>
 
      </div>

<div class="list">
<?php //foreach ($variable as $key => $value) {
	# code...

	print_r($data);
//}
?>
</div>

</div>
<script>

//$('.pdf_submit').click(function () {
	$("form#pdf_file123").submit(function() {
    //alert('abc');
     var form_data = new FormData($(this)[0]);
   //var form_data= $('#pdf_file').serialize();
   //alert(form_data);
   $.ajax({
       type: 'post',
       data: form_data,
       url: baseUrl+"clinic/appointment/consult_upload_pdf",
       async: false,
            cache: false,
        contentType: false,
        processData: false,
       success: function(data){
       	if(data=="1"){
       		$('.message').append('<div class="alert alert-success">Pdf file is uploaded successfully</div>');

       	}
       	else
       	{

       	}

      }

 });
   return false;

});



 
</script>


<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/pdf_consulation.js"></script> 