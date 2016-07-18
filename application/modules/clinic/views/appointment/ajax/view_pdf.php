<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 
		echo $this->lang->line('pdf'); 

		?>	
	</h4>
</div>
<div class="modal-body ">
<div class="pdf-popdesign">
<div class="panel panel-primary">
<div class="message"></div>
<form id="pdf_file123" method="post" enctype="multipart/form-data">
<div class="pdfupsecpop">
    <input id="inputFileToLoad" type="file" name="new_pdf_file"  />
     <input type="hidden" name="user_id" value="<?php echo $userid;?>">
 
  <input type="submit" class="pdf_submit btn btn-all" value="submit">
   </div>
  </form>
 </div>
      
<div class="pdfchoosetitle">
  <?php 
echo $this->lang->line('pdf_library_choose'); 
?>  
</div>
<div class="list">
<ul class="resultsOfPdf">

<?php foreach ($all_Results as $all_Result) {?>
<li id="<?php echo $all_Result->id; ?>">
<a class="editorGoOnconsult" href="javascript:void(0);" data-editpdf="<?php echo $all_Result->pdf_path.$all_Result->image_name; ?>">
<span class="glyphicon glyphicon-file pdfopoicon" aria-hidden="true"></span><?php echo $all_Result->pdf_name; ?></a></li>

<?php } ?>
</ul>


</div>
</div>
</div>
<script>

//$('.pdf_submit').click(function () {
	$("form#pdf_file123").submit(function() {
    //alert('abc');
     var form_data = new FormData($(this)[0]);
   //var form_data= $('#pdf_file').serialize();
   
   $.ajax({
       type: 'post',
       data: form_data,
       dataType: 'JSON',
       url: baseUrl+"clinic/appointment/consult_upload_pdf",
       async: false,
            cache: false,
        contentType: false,
        processData: false,
       success: function(data){
        
       	
       		$('.message').append('<div class="alert alert-success">Pdf file is uploaded successfully</div>');
          $('.list ul').prepend("<li id=''><a class='editorGoOnconsult' href='javascript:void(0);' data-editpdf='"+ data.path+data.imagename+"'><span class='glyphicon glyphicon-file pdfopoicon' aria-hidden='true'></span>"+ data.pdfname+"</a></li>");

      }

 });
   return false;

});
    jQuery(document).ready(function(){
      jQuery(document).on('click','.editorGoOnconsult', function(){
        var imgvalue = $(this).data('editpdf');
        $('#test').css('display', 'block');
        $('.close').trigger('click');
        addImage(imgvalue);
    });
    });
    

 
</script>


<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/pdf_consulation.js"></script> 