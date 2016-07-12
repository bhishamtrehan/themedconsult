<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
	   <h4 class="modal-title">
		<?php echo 'Add Medications'; ?>	
	</h4>
</div>
<div class="modal-body ">
<div data-acc-content="demo1" class="panel-body acc-open">
        <!--tab-one-start-->
     <form class ='form-horizontal form_health form-popup-main' id = 'add_medication'>
        <div class="col-md-12 form-group">
          <div class="col-md-3">
		  	<label for="medication">Medication</label>
			<input type="text" id="medication" class="form-control required" name="medication">
		  </div>
		  <div class="col-md-3">
		  	<label for="dose">Dose</label>
			<input type="text" id="dose" class="form-control required" name="dose">
		  </div>
		  <div class="col-md-3 addnewmed">
		  	<label for="route">Route</label>
			<select title="Select" data-live-search="true" class="form-control required selectpicker bs-select-hidden" id="route" name="route"><option class="bs-title-option" value="">Select</option>
					<?php 
									
					foreach($frequency as $freq){ ?>
						<option value="<?php echo $freq['ID']; ?>"><?php echo $freq['frequency']; ?></option>
					<?php } ?>
				</select>
			
			<a coords="route" class="addnewmedtype" href="javascript:;">Add New</a>
		  </div>
		  <div class="col-md-3 addnewmed">
		  	<label for="frequency">Frequency</label>
			<select title="Select" data-live-search="true" class="form-control required selectpicker bs-select-hidden" id="frequency" name="frequency"><option class="bs-title-option" value="">Select</option>
				<?php foreach($route as $rou){ ?>
					<option value="<?php echo $rou['ID']; ?>"><?php echo $rou['route']; ?></option>
				<?php } ?>
			</select>
			<a coords="frequency" class="addnewmedtype2" href="javascript:;">Add New</a>
		  </div>
        </div>
		<div class="col-md-12 form-group">
          <div class="col-md-6">
		  	<label for="notes">Notes</label>
			<input type="text" id="notes" class="form-control required" name="notes">
		  </div>
		  <div class="col-md-3">
		  	<label for="startdate">Start Date</label>
			<input type="text" id="startdate" class="form-control required dob date-picker" name="startdate">
		  </div>
		  <div class="col-md-3">
		  	<label for="enddate">End Date</label>
			<input type="text" id="enddate" class="form-control required dob date-picker" name="enddate">
		  </div>
        </div>
		<div class="col-md-12 form-group">
		<input type="hidden" value="create" name="action">
		<input type="hidden" value="<?php echo $appId; ?>" name="appointment_id">
          <div class="col-md-5">
		  	<label for="notes">Prescriber Name</label>
			<input type="text" id="prescriber_name" class="form-control" readonly="" name="prescriber_name" value="xbdfb">
		  </div>
		  <div class="col-md-5">
		  	<label for="startdate">Prescriber Number</label>
			<input type="text" id="prescriber_number" class="form-control" readonly="" name="prescriber_number" value="12345">
		  </div>
        </div>
		<div class="col-md-12 form-group">
          <div class="col-md-6">
		  	 <button class="btn btn-default cancelmedic" type="submit">Cancel</button>
			 <button class="btn btn-default okmedic" type="submit">Ok</button>
		  </div>
        </div>

      </form>
      </div>
</div>
<link href="<?php echo base_url();?>assets/css/jquery-confirm.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>themedconsult/assets/js/plugins/jQuery-confirm/jquery-confirm.js"></script>
<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/validation_add_medication.js"></script> 
