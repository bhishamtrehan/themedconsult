<?php echo form_open('',array('class' => 'form-horizontal form_health form-popup-main','id' => 'add_appointment'));

//echo '<pre>'; print_r($hp_avail_time->room); die;

if(!isset($appntDetails) || empty($appntDetails)) {
	if(isset($patient_info)) {
		$patient_id = $this->encryption->encode($patient_info->patient_id);
		$patientName = $patient_info->title.'. '.$patient_info->first_name.' '.$patient_info->last_name;
	} else {
		$patientName = '';	
		$patient_id = "";
	}
	$appntDetails = "";
	$appointment_notes = "";
	$appnt_id = "";
	$title = "add_new_appointment";
	$appointment_type_value = "";
	$appnt_type = $this->lang->line('select_type');
	
	$btnText = $this->lang->line('submit');
} else {
	$appointment_notes = $appntDetails->appointment_notes;
	$appnt_id 	= $appntDetails->appointment_id;
	$appointment_type_value = $appntDetails->appointment_type_id;
	$patient_id = $this->encryption->encode($appntDetails->patient_id);
	$title = "edit_new_appointment";
	$appnt_type = '<span style="background-color:#'.$appntDetails->color_code.';"></span>'.$appntDetails->appointment_type;
	$patientName = $appntDetails->patient_title.'. '.$appntDetails->first_name.' '.$appntDetails->last_name;
	$btnText = $this->lang->line('update');	
}
	
$appointment_notes = array(
	'name'	=> 'appointment_notes',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_appointment_notes'),
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
  'name' => 'patient_field_id',
  'type' => 'hidden',
  'id' 	 => 'patient_field_id',
  'value' => $patient_id,
);
$location_prac = array(
  'name' => 'location_prac',
  'type' => 'hidden',
  'id' 	 => 'location_prac',
  'value' => $this->encryption->encode($prac_resource->hp_id),
);
$appointment_id = array(
  'name' => 'appointment_id',
  'type' => 'hidden',
  'id' 	 => 'appointment_id',
  'value' => $appnt_id,
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
	'name'	=> 'prac_name',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'patient_field form-control',
	'readonly' => 'readonly',
);
$patientSearchFor = array(
	'name'	=> 'prac_search_for',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control patient_search_for',
);
?>
<title><?php echo $this->lang->line($title).$this->lang->line('title_universal');?></title>
<div class="innr_dashbrd_form">
<div class="modal-body add_app_pg dashbrd_popup">
<div class="col-xs-12 patient_detail_head"><?php echo $this->lang->line($title);?></div>
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('clinic_location');?>:</label></div>
		<div class="col-xs-8">
			 <?php echo $locationDetails['clinic_name']; ?>
		</div>
	</div>	
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('avail_room');?>:</label></div>
		<div class="col-xs-8">
		 <?php 
		 	if(isset($hp_avail_time->room)){
		 		echo $hp_avail_time->room; 
		 	}else{
		 		echo '<p class="text_red">'.$this->lang->line('no_avail_room').'</p>';
		 	}
		 ?>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('practitioner');?>:</label></div>
		<div class="col-xs-8">
			 <?php echo $prac_resource->prac_title.' '.$prac_resource->prac_first_name.' '.$prac_resource->prac_surname; ?>
		</div>
	</div>
      
    <div id="patient_and_desc">
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('patient');?>:</label></div>
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
			<div class="appt_tme_estimate"> <span id="appnt_duration_label"><?php echo $appntDuration;?></span> <?php echo $this->lang->line('minutes'); ?></div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-4"><label><?php echo $this->lang->line('notes');?>:</label></div>
		<div class="col-xs-8">
			 <?php echo form_input($appointment_notes); ?>
		</div>
	</div>
	<?php echo form_hidden('clinic_location', $this->session->userdata['clinic_location']);
	echo form_hidden('appointment_duration', $appntDuration);
	echo form_hidden('room_id', $hp_avail_time->clinic_room_id);
    echo form_input(array('name' => 'form_save', 'type'=>'hidden', 'id' =>'form_save'));
	echo form_input($appointment_type);
	echo form_input($location_prac);
	echo form_input($appointment_id);
	echo form_input($patient_field_id);
	echo form_input($appointment_date); ?>
	<?php echo form_hidden('submit_action', 'insert');?>
	<div class="col-xs-12">
		<div class="col-xs-4"><label for="ticket-type" control-label></label></div>
		<div class="col-xs-8">
			 <?php 
			 if(isset($hp_avail_time->room)){
			 	echo form_submit('submit', $btnText, "id='appoint_submit' class='btn btn-primary btn-block' onclick='return validateAppnt();'");
			 }
			  ?>
                         <?php //echo form_submit('button', 'Close', "id='appoint_close' class='btn btn-primary btn-block' onclick='self.close();'"); ?>
                         <input type="button" name="button" value="Close" id="appoint_close" class="btn btn-primary btn-block" onclick="self.close();">
		</div>
	</div> 				
</div></div>
<div class="popup">
 <button type="button" style="display:none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
	  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $this->lang->line('patient_finder');?></h4>
</div>
<div class="modal-body">
    <div class="form-group" style="border-top: none;">
		<div class="patient_search_label"><label><?php echo $this->lang->line('enter_patient_keyword');?></label></div>
		<div class="patient_search_field">
		     <?php echo form_input($patientSearchFor); ?>
		</div>
	</div>  
	<div id="patient_search_results"></div>
</div>
	  </div>
    </div>
  </div>
</div>
<?php echo form_close();?> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/datepicker.css">
<script src="<?php echo base_url();?>assets/js/jquery/jquery-2.1.0.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>  
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> 
<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/add_appointment.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap-datepicker.js"></script> 
<script>
$(document).ready(function(){
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('input:text:visible:first').focus();
    });
});
</script>
