<?php //echo form_open('',array('class' => 'form-horizontal form_health form-popup-main','id' => 'add_instruction_to_patient'));
$instruction_url = array(
	'name'	=> 'instruction_url',
	'id'	=> 'instruction_url',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('instruction_url'),
);
$upload_file = array(
	'name'	=> 'upload_file',
	'id'	=> 'upload_file',
	'type'  =>  'file',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('upload_file'),
	'size'	=> 30,
	'autocomplete' => 'off',
);
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><?php echo $this->lang->line('add_instruction_to_patient');?></h4>
</div>

<div class="instructionformpopup">
<div class="row">
<div class="col-md-4 col-sm-offset-2">
<input type="radio" name="bedStatus" id="url"  value="url"> <label>Url</label>
</div>
<div class="col-md-4 col-sm-offset-2">
<input type="radio" name="bedStatus" id="upload" value="upload"><label>File upload</label>
</div>
</div>


<div class="formcentercontent">
<div class="modal-body">
	<div class="form-group" id="url_section">
		<label for="ticket-type"><?php echo $this->lang->line('instruction_url');?>:</label>
		<?php echo form_input($instruction_url); ?>
		
	</div>   
	
	<div class="form-group" id="upload_section">
	<div class="fileupsectionpop">
		<label for="ticket-type"><?php echo $this->lang->line('instruction_upload');?>:</label>
		<?php //echo form_input($upload_file); ?>
		<div class="fileupclass">
 		 	<input type="file" name="filePhoto" value="" id="filePhoto" class="form-control required borrowerImageFile" data-errormsg="PhotoUploadErrorMsg">
			<img id="previewHolder" alt="Uploaded Image Preview Holder" style="display:none;" width="250px" height="250px"/>
   			</div>
   			</div>
		
	</div> 
	<?php //echo form_hidden('submit_action', 'insert');?>
	<div class="form-group" id="submit_section">
		<div class="btncentertopage">
		<input type="hidden" name="appt_id" id="appt_id" value="<?php echo $apptId; ?>">
		<button id="inst_submit" class="btn btn-primary"><?php echo $this->lang->line('submit');?></button>
			 <?php //echo form_submit('submit', $this->lang->line('button'),"class='btn btn-primary btn-block' id='inst_submit'"); ?>
		</div>
	</div> 				
</div>
</div></div>
<?php //echo form_close();?>  
<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/add_instruction_to_patient.js"></script>
