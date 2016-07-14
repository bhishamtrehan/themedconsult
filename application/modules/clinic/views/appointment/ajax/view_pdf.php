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
	 <input type="file" name="pdf_file" id="pdf_file">
	  <button type="button" class="pdf_file">Click Me!</button> 

      </div>
</div>

<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/pdf_consulation.js"></script> 