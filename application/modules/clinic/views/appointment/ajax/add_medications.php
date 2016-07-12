<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
	   <h4 class="modal-title">
		<?php echo $this->lang->line('add_medication'); ?>	
	</h4>
</div>
<div class="modal-body ">
<div data-acc-content="demo1" class="panel-body acc-open">
        <!--tab-one-start-->
     <form class ='form-horizontal form_health form-popup-main' id = 'add_medication'>
        <div class="col-md-12 form-group">
          <div class="col-md-3">
		  	<label for="medication"><?php echo $this->lang->line('medication_medication');?></label>
			<input type="text" id="medication" class="form-control required" name="medication">
		  </div>
		  <div class="col-md-3">
		  	<label for="dose"><?php echo $this->lang->line('medication_dose');?></label>
			<input type="text" id="dose" class="form-control required" name="dose">
		  </div>
		  <div class="col-md-3 addnewmed">
		  	<label for="route"><?php echo $this->lang->line('medication_route');?></label>
			<select title="Select" data-live-search="true" class="form-control required selectpicker bs-select-hidden" id="route" name="route"><option class="bs-title-option" value=""><?php echo $this->lang->line('medication_select');?></option>
					<?php 
									
					foreach($frequency as $freq){ ?>
						<option value="<?php echo $freq['ID']; ?>"><?php echo $freq['frequency']; ?></option>
					<?php } ?>
				</select>
			
			<a coords="route" class="addnewmedtype" href="javascript:;">Add New</a>
		  </div>
		  <div class="col-md-3 addnewmed">
		  	<label for="frequency"><?php echo $this->lang->line('medication_frequency');?></label>
			<select title="Select" data-live-search="true" class="form-control required selectpicker bs-select-hidden" id="frequency" name="frequency"><option class="bs-title-option" value=""><?php echo $this->lang->line('medication_select');?></option>
				<?php foreach($route as $rou){ ?>
					<option value="<?php echo $rou['ID']; ?>"><?php echo $rou['route']; ?></option>
				<?php } ?>
			</select>
			<a coords="frequency" class="addnewmedtype2" href="javascript:;"><?php echo $this->lang->line('medication_add_new');?></a>
		  </div>
        </div>
		<div class="col-md-12 form-group">
          <div class="col-md-6">
		  	<label for="notes"><?php echo $this->lang->line('medication_notes');?></label>
			<input type="text" id="notes" class="form-control required" name="notes">
		  </div>
		  <div class="col-md-3">
		  	<label for="startdate1"><?php echo $this->lang->line('medication_start_date');?></label>
			<input type="text" id="startdate" class="form-control" name="startdate">
		  </div>
		  <div class="col-md-3">
		  	<label for="enddate"><?php echo $this->lang->line('medication_end_date');?></label>
			<input type="text" id="enddate" class="form-control" name="enddate">
		  </div>
        </div>
		<div class="col-md-12 form-group">
		<input type="hidden" value="create" name="action">
		<input type="hidden" value="<?php echo $appId; ?>" name="appointment_id">
          <div class="col-md-5">
		  	<label for="notes"><?php echo $this->lang->line('medication_prescriber_name');?></label>
			<input type="text" id="prescriber_name" class="form-control" readonly="" name="prescriber_name" value="xbdfb">
		  </div>
		  <div class="col-md-5">
		  	<label for="startdate2"><?php echo $this->lang->line('medication_prescriber_number');?></label>
			<input type="text" id="prescriber_number" class="form-control" readonly="" name="prescriber_number" value="12345">
		  </div>
        </div>
		<div class="col-md-12 form-group">
          <div class="col-md-6">
		  	 <button class="btn btn-default cancelmedic" type="submit"><?php echo $this->lang->line('medication_cancel');?></button>
			 <button class="btn btn-default okmedic" type="submit"><?php echo $this->lang->line('medication_submit');?></button>
		  </div>
        </div>

      </form>
      </div>
</div>

<link href="<?php echo base_url();?>assets/css/jquery-confirm.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/js/plugins/jQuery-confirm/jquery-confirm.js"></script>
<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/validation_add_medication.js"></script> 
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
  <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/datepicker.css">
 <script type="text/javascript"> 
 $(document).ready(function(){
    $( "#startdate" ).datepicker();
  $( "#startdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  })
  //$( "#startdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
    </script>