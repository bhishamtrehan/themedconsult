<div class="add_new_roster"><h4 class="modal-title">
		<?php echo $this->lang->line('add_new_roster');?><button class="close" data-dismiss="modal" type="button">×</button>
	</h4>
	</div>
<?php echo form_open('',array('class' => 'form-horizontal form_health form-popup-main','id' => 'add_appointment'));
//echo "<pre>"; print_r($rosterDetails); die();

if(!isset($rosterDetails) || empty($rosterDetails)) {
	$rosterDetails = "";
	$appointment_notes = "";
	$appnt_id = "";
	//$title = "add_new_appointment";
	$appointment_type_value = "";
	$appnt_type = $this->lang->line('select_type');
	
	$btnText = $this->lang->line('submit');
} else {
	$roster_id 	= $rosterDetails->roster_id;
	$prac_id = $this->encryption->encode($rosterDetails->practitioner_id);
	$title = "edit_new_appointment";
	
	$patientName = $rosterDetails->prac_title.'. '.$rosterDetails->prac_first_name.' '.$rosterDetails->prac_surname;
	$btnText = $this->lang->line('update');	
}
	
$appointment_notes = array(
	'name'	=> 'appointment_notes',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_notes'),
	'value' => $appointment_notes,
    'id' 	 => 'appointment_notes',
);
$color_code = array(
	'name'	=> 'color_code',
	'maxlength'	=> 80,
	'class' => 'form-control pick-a-color',
	'placeholder' => $this->lang->line('select_color_dropdown'),
	'size'	=> 30,
	'autocomplete' => 'off',
);
$types[''] = 'Select type';
$appointment_type = array(
  'name' => 'appointment_type',
  'type' => 'hidden',
  'id' 	 => 'appointment_type',
  'value' => $appointment_type_value,
);

$patient_field_id = array(
  'name' => 'prac_field_id',
  'type' => 'hidden',
  'id' 	 => 'prac_field_id',
  'value' => $prac_id,
);
$location_prac = array(
  'name' => 'location_prac',
  'type' => 'hidden',
  'id' 	 => 'location_prac',
  'value' => $this->encryption->encode($prac_resource->hp_id),
);
$appointment_id = array(
  'name' => 'roster_id',
  'type' => 'hidden',
  'id' 	 => 'roster_id',
  'value' => $rosterDetails->roster_id,
);
$appointment_date  = array(
	'name'=> 'appointment_date',
	'type' => 'hidden',
	'id'=> 'appointment_date',
	'value' => date('Y-m-d', $startDate),
);
$hours[''] = $this->lang->line('select');
$minutes[''] = $this->lang->line('select');

for($i='1';$i<13;$i++) {
	if($i<10)
		$hours['0'.$i] = '0'.$i;
	else
		$hours[$i] = $i;
}
for($j='0';$j<61;$j++) {
	if($j<10)
		$minutes['0'.$j] = '0'.$j;
	else
		$minutes[$j] = $j;
}
$hour_format['am'] = $this->lang->line('am');
$hour_format['pm'] = $this->lang->line('pm');
$time = explode(':',$startTime);
$appntTime = $time[0];
$selectedFormat = 'am';
if($time[0] == '12') {
	$selectedFormat = 'pm';
}
else if($time[0] == '0') {
	$appntTime = '12';
}
else if($time[0] > 12) {
	$appntTime = $time[0] - 12;
	$selectedFormat = 'pm';
}

$endTimeArray = explode(':',$endTime);
$appntEndTime = $endTimeArray[0];
$selectedEndFormat = 'am';
if($endTimeArray[0] == '12') {
	$selectedEndFormat = 'pm';
}
else if($endTimeArray[0] == '0') {
	$appntEndTime = '12';
}
else if($endTimeArray[0] > 12) {
	$appntEndTime = $endTimeArray[0] - 12;
	$selectedEndFormat = 'pm';
}

$appointment_hour   = form_dropdown('appointment_hour', $hours, $appntTime, 'id="appointment_hour", onChange="update_duration();"');
$appointment_minute = form_dropdown('appointment_minute', $minutes, $time[1], 'id="appointment_minute", onChange="update_duration();"');
$appointment_time_format = form_dropdown('appointment_time_format', $hour_format, $selectedFormat, 'id="appointment_time_format", onChange="update_duration();"');

$appointment_end_hour   = form_dropdown('appointment_end_hour', $hours, $appntEndTime, 'id="appointment_end_hour", onChange="update_duration();"');
$appointment_end_minute = form_dropdown('appointment_end_minute', $minutes, $endTimeArray[1], 'id="appointment_end_minute", onChange="update_duration();"');
$appointment_end_time_format = form_dropdown('appointment_end_time_format', $hour_format, $selectedEndFormat, 'id="appointment_end_time_format", onChange="update_duration();"');

$patient = array(
	'name'	=> 'patient_name',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'patient_field form-control',
	//'readonly' => 'readonly',
	'id' => 'patient_field',
);
$patientSearchFor = array(
	'name'	=> 'patient_search_for',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control pracs_search_for',
);
?>

<div class="innr_dashbrd_form">
<div class="modal-body add_app_pg dashbrd_popup">
<div class="col-xs-12 patient_detail_head"><?php //echo $this->lang->line('add_new_roster');?></div>
	<div class="col-xs-12 clinicnamespc">
		<div class="col-xs-4"><label><?php echo $this->lang->line('clinic_location');?>:</label></div>
		<div class="col-xs-8">
			 <?php echo $locationDetails['clinic_name']; ?>
			 
		</div>
	</div>
	
      
    <div id="patient_and_desc">
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('search_practitioner');?>:</label></div>
		<div class="col-xs-8">
		<?php
		if($patientName !=''){
			echo $patientName;
		}
		else
		{  
			echo form_input($patient);
		}

		?>
				<div class="result_hpinfo"></div>
	</div>
</div>
	
    </div>	
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('appointment_date');?>:</label></div>
		<div class="col-xs-8">
			<div class="appt_tme_estimate"> <?php echo date('F j, Y', $startDate); ?></div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('appointment_start');?>:</label></div>
		<div class="col-xs-8">
			<div class="appt_tme_estimate"> <?php echo $appointment_hour.$appointment_minute.$appointment_time_format; ?></div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('appointment_end');?>:</label></div>
		<div class="col-xs-8">
			<div class="appt_tme_estimate"> <?php echo $appointment_end_hour.$appointment_end_minute.$appointment_end_time_format; ?></div>
		</div>
	</div>	
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('duration');?>:</label></div>
		<div class="col-xs-8">
			<div class="appt_tme_estimate"> <span id="appnt_duration_label"><?php echo $rostDuration;?></span> <?php echo $this->lang->line('minutes'); ?></div>
			<input type="hidden" value="" name="updated_duration" id="updated_duration">
		</div>
	</div>
	<!-- <div class="col-xs-12">
		<div class="col-xs-4"><label><?php //echo $this->lang->line('notes_on_roster');?>:</label></div>
		<div class="col-xs-8">
			 <?php //echo form_input($appointment_notes); ?>
		</div> 
	</div> -->
	<?php echo form_hidden('clinic_location', $this->session->userdata['clinic_location']);
	echo form_hidden('roster_duration', $rostDuration);
    echo form_input(array('name' => 'form_save', 'type'=>'hidden', 'id' =>'form_save'));
	echo form_input($appointment_type);
	echo form_input($location_prac); 
	echo form_input($appointment_id);
	echo form_input($patient_field_id);
	echo form_input($appointment_date); ?>
	<input type="hidden" name="clinicID" id="clinic_Id" value="<?php echo $locationDetails['clinic_id']; ?>">
	<input type="hidden" name="clinicRoom" id="clinic_Room" value="<?php echo $room_id; ?>">
	<?php echo form_hidden('submit_action', 'insert');?>
	<div class="col-xs-12">
		<div class="col-xs-4"><label for="ticket-type" control-label></label></div>
		<div class="col-xs-8">
		<div class="popcalenderbtn editap">
			 <?php echo form_submit('submit', $btnText, "id='appoint_submit' class='btn btn-primary btn-block' onclick='return validateAppnt();'"); ?>
                         <?php //echo form_submit('button', 'Close', "id='appoint_close' class='btn btn-primary btn-block' onclick='self.close();'"); ?>
                         <input type="button" name="button" value="Close"  data-dismiss="modal" class="btn btn-primary btn-block">
                         </div>
		</div>
	</div> 				
</div></div>
<!-- <div class="popup">
 <button type="button" style="display:none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></button>
  <!-- Modal -->
  <!--<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <!--<div class="modal-content">
	  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $this->lang->line('prac_finder');?></h4>
</div>
<div class="modal-body">
    <div class="form-group" style="border-top: none;">
		<div class="patient_search_label"><label><?php echo $this->lang->line('enter_prac_keyword');?></label></div>
		<div class="patient_search_field">
		     <?php echo form_input($patientSearchFor); ?>
		</div>
	</div>  
	<div id="patient_search_results"></div>
</div>
	  </div>
    </div>
  </div>
</div> -->
<?php echo form_close();?> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/datepicker.css">
<script src="<?php echo base_url();?>assets/js/jquery/jquery-2.1.0.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>  
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> 
<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/roster/add_roster_appointment.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap-datepicker.js"></script> 
<script>
$(document).ready(function(){
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('input:text:visible:first').focus();
    });
});
</script>
