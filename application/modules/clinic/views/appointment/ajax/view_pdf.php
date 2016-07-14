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
	   Please select a file and then hit Evaluate:
  
  <br/>
  <br/>
  <input id="file" type="file"/>
  <br/>
  <br/>
  <button id="button">Evaluate
  

      </div>
</div>
<script type="text/javascript">

// $(".pdf_file").click(function(){
//        // alert('fghj');
//        var form=$("#abc");
// 	var form1 = $("#abc").serialize();
//         var file=  $('#pdf_file123').val();
//         alert(form1);
//     return false;

//    $('body').addClass("show_loader");

//     $.ajax({
//             type: "POST",
//             url: baseUrl+"clinic/appointment/consult_pdf", 
         
//             dataType: "html",  
//             cache:false,
//             success: function (response) {
            
//             $( ".modal-content" ).html(response);
//                 $('body').removeClass("show_loader");
//                     $( ".btn-lg" ).trigger( "click" );
            
                
//             }
//         });

//  });




document.getElementById('button').addEventListener('click', function() {
  var files = document.getElementById('file').files;
  alert(files);
  if (files.length > 0) {
    getBase64(files[0]);
  }
});

function getBase64(file) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
     console.log(reader.result);

   };
   reader.onerror = function (error) {
     console.log('Error: ', error);
   };
}

 
</script>


<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/pdf_consulation.js"></script> 