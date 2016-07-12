<?php
$image = $results[0]['image_file_name'];
$id = $results[0]['user_id'];
$userName = $this->tank_auth->get_username();
$enc = $this->encryption->encode($id);

?>
<link href="<?php echo base_url();?>assets/css/rangeSlider.css" rel="stylesheet"/>

<div class="page-title">
    <div class="container">
        <h3><?php 
            if(isset($title)){
                echo $title;
            }else{
                echo $this->lang->line('home');
            }
            ?>
        </h3>
    </div>
</div>

<div id="main-wrapper" class="container">
    <div class="row">
        <div class="col-md-12" id="full">
            <div class="editor_row_top" style="overflow: hidden; margin-bottom: 5px;">
                
                <div class="column-right links col-md-3 color_col">
                    <strong><i class="fa fa-pencil"></i> <?= $this->lang->line('pen'); ?></strong>
                    <a class="black updateColor fa fa-check m-r-xs" href="javascript:void(0);" data-rel ="rgb(0,0,0)" ></a>
                    <a class="red updateColor" href="javascript:void(0);" data-rel ="rgb(255,0,0)" ></a>
                    <a class="green updateColor" href="javascript:void(0);" data-rel ="rgb(0,255,0)" ></a>
                    <a class="blue updateColor" href="javascript:void(0);" data-rel ="rgb(0,0,255)"></a>
                    
                    <div class="text_range">
                    <input type="range" value="0" data-rangeSlider>
    				 <output class="outputWrap"></output>
					<!--<select class="updateBrushSize">
						<option value="1">1</option>
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="15">15</option>
						<option value="20">20</option>
					</select>--></div>
                </div>
                <div class="column-left links col-md-3 text_col">
                   <!-- <strong>Add Text:</strong>-->
                    <a style="cursor:pointer;" href="javascript:void(0);" id="text_to_img" class="text_to_img"><i class="fa fa-pencil"></i>
					<?php echo $this->lang->line('text'); ?></a>
					<a class="black updateTextColor fa fa-check m-r-xs" href="javascript:void(0);" data-rel ="rgb(0,0,0)" ></a>
                    <a class="red updateTextColor" href="javascript:void(0);" data-rel ="rgb(255,0,0)" ></a>
                    <a class="green updateTextColor" href="javascript:void(0);" data-rel ="rgb(0,255,0)" ></a>
                    <a class="blue updateTextColor" href="javascript:void(0);" data-rel ="rgb(0,0,255)"></a>
					<div class="text_range_text">
                    	<input type="range_text" value="15" min="15" max="60" data-rangeSliderText>
    				 	<output class="outputWrap"></output>
					</div>
					<input type="hidden" id="textSize">
                </div>
                
                
                 <div class="column-left links col-md-3 undo_redo_col">
                <button style="cursor:pointer;" onclick="javascript:cUndo();return false;"><i class="fa fa-undo"></i>
				</button>
                <button style="cursor:pointer;" onclick="javascript:cRedo();return false;"><i class="fa fa-repeat"></i>
				</button>
				<button id="eraser">Eraser</button>
                </div>
                
                
                <div class="column-left links col-md-3 save_col" >
                    <a href="javascript:void(0);" class="download_pdf"><?= $this->lang->line('save'); ?></a>
                    <a href="javascript:void(0);" class="print"><?= $this->lang->line('print'); ?></a>
                </div>
                <div class="column-left links col-md-3 save_col_full none_display">
                    <a href="javascript:void(0)" onclick="full_exit();"><?= $this->lang->line('pdf_exit'); ?></a>
                </div>
               
                
            </div>
			<input type="hidden" id="orgImg" value="<?php echo base_url().'assets/uploads/'.$userName.'_'.$enc.'/'.$image; ?>" />
            <div class="ipad">
            <div id="can_wrap" style="position:relative; ">
            <span class="full_screen_icon">
				<a href="javascript:void(0)" id="fullscreen"><i class="fa fa-arrows-alt"></i></a></span>
            <canvas id="test" style="border: 1px solid;"></canvas>
            </div>
            </div>
            
        </div>
    </div><!-- Row -->
</div><!-- Main Wrapper -->

<?php $this->load->view('inc/footer'); ?>
<!--<script src="<?php echo base_url();?>assets/js/jquery.mobile-1.4.5.min.js"></script>-->
<script src="<?php echo base_url()?>assets/js/mc_js/editor/jspdf.js"></script>
<script src="<?php echo base_url()?>assets/js/mc_js/editor/html2canvas.js"></script>
<script src="<?php echo base_url()?>assets/js/mc_js/editor/canvas2image.js"></script>
<script src="<?php echo base_url()?>assets/js/mc_js/editor/screenfull.js"></script>
<script src="<?php echo base_url()?>assets/js/mc_js/editor/UndoRedo.js"></script>
<script src="<?php echo base_url()?>assets/js/mc_js/editor/rangeSlider.js"></script>
<script src="<?php echo base_url()?>assets/js/mc_js/editor/customjs.js"></script>
<script src="<?php echo base_url()?>assets/js/mc_js/editor/customtextsize.js"></script>
<!--<script src="<?php echo base_url()?>assets/js/mc_js/editor/jquery.ui.touch-punch.js"></script>-->



<script type="text/javascript">

$(document).ready(function()
{
	InitThis();
    $("#test").jqScribble();
    $(addImage); 
    
   
	/* Eraser Function */
	var canvas=document.getElementById("test");
	var ctx=canvas.getContext("2d");
	var lastX;
	var lastY;
	var mouseX;
	//var mode = 'pen';
	var mouseY;
	var canvasOffset=$("#test").offset();
	var offsetX=canvasOffset.left;
	var offsetY=canvasOffset.top;
	var isMouseDown=true;
	var parentOffset = $('#test').offset(); 

	function handleMouseDown(e){
		mouseX = e.originalEvent.pageX - parentOffset.left;
		mouseY = e.originalEvent.pageY - parentOffset.top;
	  //mouseX=parseInt(e.clientX-offsetX);
	  //mouseY=parseInt(e.clientY-offsetY);

	  // Put your mousedown stuff here
	  lastX=mouseX;
	  lastY=mouseY;
	  isMouseDown=true;
	}

	function handleMouseUp(e){
		mouseX = e.originalEvent.pageX - parentOffset.left;
		mouseY = e.originalEvent.pageY - parentOffset.top;
	  //mouseX=parseInt(e.clientX-offsetX);
	  //mouseY=parseInt(e.clientY-offsetY);

	  // Put your mouseup stuff here
	  isMouseDown=false;
	}

	function handleMouseOut(e){
		mouseX = e.originalEvent.pageX - parentOffset.left;
		mouseY = e.originalEvent.pageY - parentOffset.top;
	  //mouseX=parseInt(e.clientX-offsetX);
	  //mouseY=parseInt(e.clientY-offsetY);

	  // Put your mouseOut stuff here
	  isMouseDown=false;
	}

	function handleMouseMove(e){
	 mouseX = e.originalEvent.pageX - parentOffset.left;
		mouseY = e.originalEvent.pageY - parentOffset.top;
		
	  //mouseX=parseInt(e.clientX-offsetX);
	  //mouseY=parseInt(e.clientY-offsetY);

	  // Put your mousemove stuff here
	  if(isMouseDown){
	    ctx.beginPath();
		
	    if(mode =="pen"){
	      ctx.globalCompositeOperation="source-over";
	      ctx.moveTo(lastX,lastY);
	      ctx.lineTo(mouseX,mouseY);
	      ctx.stroke();     
	    }else{
			
	      ctx.globalCompositeOperation="destination-out";
		  ctx.fillStyle = "#3370d4"; //blue
	      ctx.arc(lastX,lastY,5,0,Math.PI*2,false);
		 
	      ctx.fill();
	    }
	    lastX=mouseX;
	    lastY=mouseY;
	  }
	}

	//$("#test").mousedown(function(e){handleMouseDown(e);});
	//$("#test").mousemove(function(e){handleMouseMove(e);});
	//$("#test").mouseup(function(e){handleMouseUp(e);});
	//$("#test").mouseout(function(e){handleMouseOut(e);});

	
	$("#eraser").on('click touchstart',function(){  
			 ctx.globalCompositeOperation="destination-out";
			 ctx.fillStyle = "#3370d4"; //blue
	      	 ctx.arc(lastX,lastY,5,0,Math.PI*2,false);
		     ctx.fill(); 
	});
	
	$("#text_to_img").click(function(){  mode="pen";});
	$("#updateColor").click(function(){ });
});

function save()
{
    jQuery("#test").data("jqScribble").save(function(imageData)
    {
        if(confirm("This will write a file using the example image_save.php. Is that cool with you?"))
        {
            jQuery.post('image_save.php', {imagedata: imageData}, function(response)
            {
                jQuery('body').append(response);
            }); 
        }
    });
}
function addImage()
{
    //var img = prompt("Enter the URL of the image.");
    var tmpImg = new Image();
    var img = "<?php echo base_url().'assets/uploads/'.$userName.'_'.$enc.'/'.$image; ?>";
    tmpImg.src=img;
   
    $(tmpImg).one('load',function(){
        orgHeight = tmpImg.height;
        orgWidth = tmpImg.width;

        if(orgWidth <= '1170')
        {
        orgWidth = orgWidth;
        }
        else
        {
        orgWidth = '1170';
        }

    jQuery("#test").attr('height',orgHeight);
    jQuery("#test").attr('width',orgWidth);
    jQuery("#can_wrap").css('height',orgHeight);
   //jQuery("#can_wrap").css('width',orgWidth);
    jQuery("#can_wrap").css('width','100%');
		
	

    jQuery("#test").data("jqScribble").update({backgroundImage: img});

    });
}

</script>

<script type="text/javascript">
    $('.download_pdf').on('click ', function()
    {

    	
      	$('#full').removeClass('nowscroll');
      	screenfull.exit();
	
	    $('.delText').css('display', 'none');
	
		  $my_view = $('#test');
		  var useHeight = $('#can_wrap').prop('scrollHeight');
	
		html2canvas($my_view[0], {
			height: useHeight+1000,
			useCORS: true,
			allowTaint: true,
			onrendered: function (canvas) {
				var imgSrc = canvas.toDataURL("image/jpeg");
				
				var imgWidth = 210; 
			      var pageHeight = 300; 
			      var imgHeight = canvas.height * imgWidth / canvas.width;
			      var heightLeft = imgHeight;

			      var doc = new jsPDF('p', 'mm');
			      var position = 0;

			      doc.addImage(imgSrc, 'JPEG', 0, position, imgWidth, imgHeight);
			      heightLeft -= pageHeight;

			      while (heightLeft >= 0) {
			        position = heightLeft - imgHeight;
			        doc.addPage();
			        doc.addImage(imgSrc, 'JPEG', 0, position, imgWidth, imgHeight);
			        heightLeft -= pageHeight;
		      	}
		      	doc.save( 'file.pdf');
				}
				  });
  
		 
	//}, 2000);
	
    });
	

</script>
<script>
$('#text_to_img').on('click touchstart', function(){

	if($(this).hasClass('active')){
		$(this).removeClass('active');
		$('#test').removeClass('cursorText');
		var col = $('.fa-check').attr('data-rel');
		$("#test").data("jqScribble").update({brushColor: col});
	}else{
		var textover_api;
		$(this).addClass('active');
		$('#handScroll').removeClass('fa fa-check m-r-xs');
		$('#test').addClass('cursorText');
		$("#test").data("jqScribble").update({brushColor: 'transparent'});
		$('#test').TextOver({}, function() {
		  textover_api = this;

		});
	}
	
});


$(document).ready(function(){
$('.updateColor').on('click',function(){
	
	$('#text_to_img').removeClass('active');
	$('#test').removeClass('cursorText');
    var val = $(this).attr('data-rel');
    $('.updateColor').removeClass('fa fa-check m-r-xs');
    $(this).addClass('fa fa-check m-r-xs');
    $("#test").data("jqScribble").update({brushColor: val});

});

$('.updateTextColor').on('click',function(){
	
	$('#text_to_img').addClass('active');
	$('#test').addClass('cursorText');
    var val = $(this).attr('data-rel');
    $('.updateTextColor').removeClass('fa fa-check m-r-xs');
    $(this).addClass('fa fa-check m-r-xs');
    $("#test").data("jqScribble").update({brushColor: 'transparent'});
    $('#test').TextOver({}, function() {
	  textover_api = this;

	});
});

$('.updateBrushSize').change(function(){
	
    var val = $(this).val();
    $("#test").data("jqScribble").update({brushSize: val});
    //$("#test").TextOver({ 'font-size': 50 });
})


})

function removeCanvasText(e){
	e.css('display','none');
    e.remove();

}
</script>
<script type="text/javascript">
	function full_exit()
	{
		var elem = document.getElementById("full");
		screenfull.toggle(elem);
		$('#full').toggleClass('nowscroll');
		$('.save_col').toggleClass('none_display');
		$('.save_col_full').toggleClass('block_display');
	}
	
	$(document).ready(function(){
		addImage();
	if (!screenfull.enabled) {
		return false;
	}
	var elem = document.getElementById("full");
	$('#fullscreen').on('click',function () {
		screenfull.toggle(elem);
		$('#full').toggleClass('nowscroll');
		$('.save_col').toggleClass('none_display');
		$('.save_col_full').toggleClass('block_display');

	});

	$(document).keyup(function(e) {
	if (e.keyCode == 27) { 
	   $('#full').removeClass('nowscroll');
	   $('.save_col').removeClass('none_display');
		$('.save_col_full').removeClass('block_display');
		$('.save_col_full').addClass('none_display');
	}
	});
	function fullscreenchange() {
				var elem = screenfull.element;

				$('#status').text('Is fullscreen: ' + screenfull.isFullscreen);

				if (elem) {
					$('#element').text('Element: ' + elem.localName + (elem.id ? '#' + elem.id : ''));
				}

				if (!screenfull.isFullscreen) {
					$('#external-iframe').remove();
					document.body.style.overflow = 'auto';
				}
			}
	document.addEventListener(screenfull.raw.fullscreenchange, fullscreenchange);
	fullscreenchange();
	});
</script>
<script type="text/javascript">
	$('.print').on('click touchstart', function(){
	screenfull.exit();
	$('.delText').css('display', 'none');
    $('#full').removeClass('nowscroll');
   	$('.delText').css('display', 'none');

    $my_view = $('#test');
	var useHeight = $('#can_wrap').prop('scrollHeight');

    		html2canvas($my_view[0], {
			height: useHeight+1000,
			useCORS: true,
			allowTaint: true,
			onrendered: function (canvas) {
				var imgSrc = canvas.toDataURL("image/jpeg");
			    var windowContent = '<!DOCTYPE html>';
			    windowContent += '<html>'
 			    windowContent += '<head><title></title></head>';
			    windowContent += '<body>'
			    windowContent += '<img src="'+imgSrc +'">';
			    windowContent += '</body>';
			    windowContent += '</html>';
			    var printWin = window.open('','','width=500,height=500');
			    printWin.document.write(windowContent);
			    setTimeout(function(){
			    printWin.document.close();
			    printWin.focus();
			    printWin.print();
			    printWin.close(); 
			    }, 20);

			   
			}
		}); 
    });
</script>
	