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
 <p>Select a File to Load:</p>
    <input id="inputFileToLoad" type="file" onchange="loadImageFileAsURL();" />
     
 
    <p>File Contents as DataURL:</p>
    <textarea id="textAreaFileContents" style="width:640;height:240" ></textarea>
 
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




function loadImageFileAsURL()
{
    var filesSelected = document.getElementById("inputFileToLoad").files;
    alert(filesSelected);
    if (filesSelected.length > 0)
    {
        var fileToLoad = filesSelected[0];
 
        var fileReader = new FileReader();
 
        fileReader.onload = function(fileLoadedEvent) 
        {
            var textAreaFileContents = document.getElementById
            (
                "textAreaFileContents"
            );
     
            textAreaFileContents.innerHTML = fileLoadedEvent.target.result;
        };
 
        fileReader.readAsDataURL(fileToLoad);
    }
}
 
 
</script>


<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/pdf_consulation.js"></script> 