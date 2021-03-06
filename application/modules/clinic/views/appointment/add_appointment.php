<?php
echo form_open('', array('class' => 'form-horizontal form_health form-popup-main', 'id' => 'add_appointment'));

//echo '<pre>'; print_r($appntDetails); 

if (!isset($appntDetails) || empty($appntDetails)) {
  if (isset($patient_info)) {
    $patient_id = $this->encryption->encode($patient_info->patient_id);
    $patientName = $patient_info->title . '. ' . $patient_info->first_name . ' ' . $patient_info->last_name;
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
  $appnt_id = $appntDetails->appointment_id;
  $appointment_type_value = $appntDetails->appointment_type_id;
  $patient_id = $this->encryption->encode($appntDetails->patient_id);
  $title = "edit_new_appointment";
  $appnt_type = '<span style="background-color:#' . $appntDetails->color_code . ';"></span>' . $appntDetails->appointment_type;
  $patientName = $appntDetails->patient_title . '. ' . $appntDetails->first_name . ' ' . $appntDetails->last_name;
  $btnText = $this->lang->line('update');
}

$appointment_notes = array(
    'name' => 'appointment_notes',
    'maxlength' => 255,
    'size' => 30,
    'class' => 'form-control',
    'autocomplete' => 'off',
    'placeholder' => $this->lang->line('enter_appointment_notes'),
    'value' => $appointment_notes,
    'id' => 'appointment_notes',
);
$firstname = array(
    'name' => 'firstname',
    'maxlength' => 255,
    'size' => 30,
    'class' => 'form-control',
    'autocomplete' => 'off',
    'placeholder' => $this->lang->line('exist_first_name'),
    'id' => 'firstname',
);

$surname = array(
    'name' => 'surname',
    'maxlength' => 255,
    'size' => 30,
    'class' => 'form-control',
    'autocomplete' => 'off',
    'placeholder' => $this->lang->line('exist_surname'),
    'id' => 'surname',
);





$color_code = array(
    'name' => 'color_code',
    'maxlength' => 80,
    'class' => 'form-control pick-a-color',
    'placeholder' => $this->lang->line('select_color_dropdown'),
    'size' => 30,
    'autocomplete' => 'off',
);
$types[''] = 'Select type';
$appointment_type = array(
    'name' => 'appointment_type',
    'type' => 'hidden',
    'id' => 'appointment_type',
    'value' => $appointment_type_value,
);

$patient_field_id = array(
    'name' => 'patient_field_id',
    'type' => 'hidden',
    'id' => 'patient_field_id',
    'value' => $patient_id,
);
$location_prac = array(
    'name' => 'location_prac',
    'type' => 'hidden',
    'id' => 'location_prac',
    'value' => $this->encryption->encode($prac_resource->hp_id),
);
$appointment_id = array(
    'name' => 'appointment_id',
    'type' => 'hidden',
    'id' => 'appointment_id',
    'value' => $appnt_id,
);
$appointment_date = array(
    'name' => 'appointment_date',
    'type' => 'hidden',
    'id' => 'appointment_date',
    'value' => date('Y-m-d', $startDate),
);
$hours[''] = $this->lang->line('select');
$minutes[''] = $this->lang->line('select');

for ($i = '1'; $i < 13; $i++) {
  if ($i < 10)
    $hours['0' . $i] = '0' . $i;
  else
    $hours[$i] = $i;
}
for ($j = '0'; $j < 61; $j++) {
  if ($j < 10)
    $minutes['0' . $j] = '0' . $j;
  else
    $minutes[$j] = $j;
}
$hour_format['am'] = $this->lang->line('am');
$hour_format['pm'] = $this->lang->line('pm');
$time = explode(':', $startTime);
$appntTime = $time[0];
$selectedFormat = 'am';
if ($time[0] == '12') {
  $selectedFormat = 'pm';
} else if ($time[0] == '0') {
  $appntTime = '12';
} else if ($time[0] > 12) {
  $appntTime = $time[0] - 12;
  $selectedFormat = 'pm';
}

$endTimeArray = explode(':', $endTime);
$appntEndTime = $endTimeArray[0];
$selectedEndFormat = 'am';
if ($endTimeArray[0] == '12') {
  $selectedEndFormat = 'pm';
} else if ($endTimeArray[0] == '0') {
  $appntEndTime = '12';
} else if ($endTimeArray[0] > 12) {
  $appntEndTime = $endTimeArray[0] - 12;
  $selectedEndFormat = 'pm';
}

$appointment_hour = form_dropdown('appointment_hour', $hours, $appntTime, 'id="appointment_hour", onChange="update_duration();"');
$appointment_minute = form_dropdown('appointment_minute', $minutes, $time[1], 'id="appointment_minute", onChange="update_duration();"');
$appointment_time_format = form_dropdown('appointment_time_format', $hour_format, $selectedFormat, 'id="appointment_time_format", onChange="update_duration();"');

$appointment_end_hour = form_dropdown('appointment_end_hour', $hours, $appntEndTime, 'id="appointment_end_hour", onChange="update_duration();"');
$appointment_end_minute = form_dropdown('appointment_end_minute', $minutes, $endTimeArray[1], 'id="appointment_end_minute", onChange="update_duration();"');
$appointment_end_time_format = form_dropdown('appointment_end_time_format', $hour_format, $selectedEndFormat, 'id="appointment_end_time_format", onChange="update_duration();"');

$patient = array(
    'name' => 'prac_name',
    'maxlength' => 80,
    'size' => 30,
    'autocomplete' => 'off',
    'class' => 'patient_field form-control',
    'readonly' => 'readonly',
);
$patientSearchFor = array(
    'name' => 'prac_search_for',
    'maxlength' => 80,
    'size' => 30,
    'autocomplete' => 'off',
    'class' => 'form-control patient_search_for',
);
?>
<h2 class="c_modal_header addnewpopheadertitle">New Appointment<button class="close" data-dismiss="modal" type="button">×</button></h2>
<title><?php echo $this->lang->line($title) . $this->lang->line('title_universal'); ?></title>
<div class="innr_dashbrd_form test">
  <div class="modal-body add_app_pg dashbrd_popup">
    <div class="col-xs-12 patient_detail_head"><i class="fa fa-calendar-check-o"></i><?php echo $this->lang->line($title); ?></div>



    <!-- left -->
    <div class="col-sm-6">
      <div class="row">
        <!-- appointment_date -->
        <div class="col-xs-12 row_full ">
          <div class="col-xs-12 col-sm-4 row_field"><label><i class="fa fa-calendar"></i><?php echo $this->lang->line('appointment_date'); ?>:</label></div>
          <div class="col-xs-12 col-sm-8  row_field field_auto">
            <div class="appt_tme_estimate"> 
              <?php 
                $mnth = date('n', $startDate);    
                $date = date('j', $startDate);    
                $year = date('Y', $startDate);    
                
              ?>
              <select class="date" id="date" name="date">
                <?php for ($i = 1; $i < 31; $i++) { ?>
                  <option value="<?php echo $i; ?>" <?php if($date == $i){ echo 'selected'; } ?> ><?php echo $i; ?></option> 
                <?php } ?>
              </select>
              <select class="date" id="month" name="month">
                <?php for ($i = 1; $i <= 12; $i++) { ?>
                  <option  value="<?php echo $i; ?>" <?php if($mnth == $i){ echo 'selected'; } ?>><?php echo $i; ?></option> 
                <?php } ?>
              </select>
              <select class="date" id="fullYear" name="fullYear">
                <?php for ($i = 2000; $i <= 2018; $i++) { ?>
                  <option value="<?php echo $i; ?>"  <?php if($year == $i){ echo 'selected'; } ?>><?php echo $i; ?></option> 
                <?php } ?>

              </select>


            </div>
          </div>
        </div>
        <div class="col-xs-12 row_full">
          <div class="col-xs-12"><label><i class="fa fa-map-marker"></i><?php echo $this->lang->line('clinic_location'); ?>:</label></div>
          <div class="col-xs-12">
            <div class="custom_field">
              <?php echo $locationDetails['clinic_name']; ?>
            </div>
          </div>
        </div>	
        <div class="col-xs-12 row_full">
          <div class="col-xs-12 col-sm-4 row_field"><label><i class="fa fa-bookmark"></i><?php echo $this->lang->line('avail_room'); ?>:</label></div>
          <div class="col-xs-12">
            <div class="custom_field">       
              <?php
              if (!isset($appntDetails) || empty($appntDetails)) {
                 if (isset($hp_avail_time->room)) {
                echo $hp_avail_time->room;
              } else {
                echo '<p class="text_red">' . $this->lang->line('no_avail_room') . '</p>';
              }
              }else
              {
                echo $appntDetails->room;
              }
              // echo "<pre>";
              // print_r($hp_avail_time);
              // die;
             
              ?>
            </div>
          </div>
        </div>
        <div class="col-xs-12 row_full">
          <div class="col-xs-12"><label><i class="fa fa-user-md "></i><?php echo $this->lang->line('practitioner'); ?>:</label></div>
          <div class="col-xs-12">
            <div class="custom_field">
              <?php echo $prac_resource->prac_title . ' ' . $prac_resource->prac_first_name . ' ' . $prac_resource->prac_surname; ?>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- right -->
    <div class="col-sm-6">
      <div class="row">
        <div id="patient_and_desc">

          <div class="patient_results"></div>



              


          <div class="col-xs-12 row_full">
            <div class="col-xs-12 col-sm-4 row_field"><label><i class="fa fa-clock-o"></i><?php echo $this->lang->line('appointment_start'); ?>:</label></div>
            <div class="col-xs-12 col-sm-8  row_field field_auto ">
              <div class="appt_tme_estimate"> <?php echo $appointment_hour . $appointment_minute . $appointment_time_format; ?></div>
            </div>
          </div>
          <div class="col-xs-12 row_full">
            <div class="col-xs-12 col-sm-4 row_field"><label><i class="fa fa-clock-o"></i><?php echo $this->lang->line('appointment_end'); ?>:</label></div>
            <div class="col-xs-12 col-sm-8  row_field field_auto">
              <div class="appt_tme_estimate"> <?php echo $appointment_end_hour . $appointment_end_minute . $appointment_end_time_format; ?></div>
            </div>
          </div>	
          <div class="col-xs-12 row_full">
            <div class="col-xs-12 col-sm-4 row_field"><label><label><i class="fa fa-clock-o"></i><?php echo $this->lang->line('duration'); ?>:</label></div>
            <div class="col-xs-12 col-sm-8  row_field field_auto">
              <div class="appt_tme_estimate"> <span id="appnt_duration_label">
                
                <?php  if (isset($appntDetails->appointment_duration)) {
                echo $appntDetails->appointment_duration;
              } else {
               echo $appntDuration;
              }
              ?>

    
                


              </span> <?php echo $this->lang->line('minutes'); ?></div>
            </div>
          </div>
          <div class="col-xs-12 row_full">
            <div class="col-xs-12 col-sm-4 row_field"><label><i class="fa fa-question-circle"></i><?php echo $this->lang->line('notes'); ?>:</label></div>
            <div class="col-xs-12">
              <?php echo form_input($appointment_notes); ?>
            </div>
          </div>
          <?php
          echo form_hidden('clinic_location', $this->session->userdata['clinic_location']);
          echo form_hidden('appointment_duration', $appntDuration);
          echo form_hidden('room_id', $hp_avail_time->clinic_room_id);
          echo form_input(array('name' => 'form_save', 'type' => 'hidden', 'id' => 'form_save'));
          echo form_input($appointment_type);
          echo form_input($location_prac);
          echo form_input($appointment_id);
          echo form_input($patient_field_id);
          echo form_input($appointment_date);
          ?>
         <?php echo form_hidden('submit_action', 'insert'); ?>











          				
        </div>
      </div>
    </div>



  </div>
  <!-- tabing modal-body add_app_pg dashbrd_popup start-->


<div class="modal-body add_app_pg dashbrd_popup">

    <div class="col-xs-12 patient_detail_head"><i class="fa fa-calendar-check-o"></i><?php echo $this->lang->line('patient_details'); ?></div>
    <!-- Nav tabs -->
    <div class="search_pat_innner">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo $this->lang->line('search_existing_search'); ?></a></li>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $this->lang->line('add_new_patient'); ?></a></li>

      </ul>

      <!-- Tab panes -->
      <div class="tab-content row">
        <div role="tabpanel" class="tab-pane active" id="home">
          <p>Please search the patient</p>
          <div class="col-xs-12 col-sm-4 ">
            <label><?php echo $this->lang->line('sur_name'); ?>:</label>
            <?php echo form_input($surname); ?>
          </div>
          <div class="col-xs-12 col-sm-4 ">
            <label><?php echo $this->lang->line('first_name'); ?>:</label>

            <?php echo form_input($firstname); ?>
          </div>
          <div class="col-xs-12 col-sm-4 ">

            <label>Date</label>
            <input type="text" name="search_date" placeholder="<?php echo $this->lang->line('exist_date_of_birth'); ?>" value="" maxlength="255" size="30" class="form-control" autocomplete="off" placeholder="" id="search_date">
          </div>
            <div class="clearfix"></div>
            <div class="borderline"></div>
  <!-- search_pat_inner ends -->
  
    <div class="col-xs-12 patient_detail_head leftspcheadng"><i class="fa fa-search"></i><?php echo $this->lang->line('search_results'); ?></div>
  <div id="patient_results"></div>
        
        <?php
              if (isset($hp_avail_time->room)) {
                echo form_submit('submit', $btnText, "id='appoint_submit' style='display:none;' class='btn btn-primary btn-block' onclick='return validateAppnt();'");
              }
              ?>
              <?php //echo form_submit('button', 'Close', "id='appoint_close' class='btn btn-primary btn-block' onclick='self.close();'"); ?>
               <input type="button" name="hiddenbutton" style="display:none;" value="submit" id="appt_valid" class="btn btn-primary btn-block">
              <input type="button" name="button" value="Close"  data-dismiss="modal" class="btn btn-primary btn-all">
        </div>
        <div role="tabpanel" class="tab-pane" id="profile">
          <!--  <form enctype="multipart/form-data" method="post" action="" name="register_spcialist" id="register_spcialist" class="form-horizontal m_4_input m_lable-style" novalidate="novalidate"> -->
          <input type="hidden" value="yes" name="viewtousers">
          <div class="example1">
            <div class="panel panel-primary">
             <!--  <div class="success_msg" style="display:none;color:green;">User Registered Successfully!</div>
              <div class="error_msg" style="display:none; color:red;">Username Is already Exist!</div> -->

              <div data-acc-content="demo1" class="panel-body acc-open" style="">
                <!--tab-one-start-->
                <div class="col-md-12">
              
                  <div class="form-group">
                     <div class="col-sm-4">
                    <label class="control-label" for="inputEmail3"><?php echo $this->lang->line('patient_surname'); ?></label>
                   
                      <input type="text" value="" placeholder="" class="required form-control" name="add_surname2" id="add_surname">
                    </div>
                      <div class="col-sm-4">
                    <label class="control-label" for="inputEmail3"><?php echo $this->lang->line('patient_first_name'); ?></label>
                   
                      <input type="text" value="" class="required form-control" name="fname" id="fname" placeholder="">
                    </div>
                       <div class="col-sm-4">
                    <label class="control-label" for="inputEmail3"><?php echo $this->lang->line('search_Username'); ?></label>
                  
                      <input type="text" class="form-control required" value="" id="username" name="username" placeholder="">
                      <div style="display:none;" class="checked_username">User is already exist!</div>
                    </div>
                  </div>
              
                  <div class="form-group">
                     <div class="col-sm-4">
                    <label class=" control-label" for="inputEmail3"><?php echo $this->lang->line('search_email_id'); ?></label>
                  
                      <input type="text" class="form-control required email" value="" id="email" name="email" placeholder="">
                    </div>
                     <div class="col-sm-4">
                    <label class="control-label" for="inputEmail3"><?php echo $this->lang->line('search_password'); ?></label>
                    
                      <input type="password" class="form-control required" id="pwd" name="pwd" placeholder="">
                    </div>
                    <div class="col-sm-4">
                    <label class="control-label" for="inputPassword3"><?php echo $this->lang->line('search_date_of_birth'); ?></label>
                 <input type="text" id="search_date_of_birth" placeholder="" autocomplete="off" class="form-control" size="30" maxlength="255" value="" name="search_date_of_birth">
                    </div>
                  </div>
                 
                  <div class="form-group">
                     <div class="col-sm-4 radio_outer">
                    <label for="inputEmail3" class="control-label question-lable"><?php echo $this->lang->line('search_sex'); ?></label>
                   
                      <label class="radio-inline">
                        <input type="radio" checked="checked" class="gender" value="1" name="gender">&nbsp;<?php echo $this->lang->line('search_male'); ?> </label>
                      <label class="radio-inline">
                        <input type="radio" value="2" class="gender" name="gender">&nbsp;<?php echo $this->lang->line('search_female'); ?> </label>
                    </div>
                     <div class="col-sm-4">
                    <label class=" control-label" for="inputEmail3"><?php echo $this->lang->line('search_country'); ?></label>
             

                      <select id="country" name="country" title="Country" data-live-search="true" class="form-control selectpicker required bs-select-hidden">
                        <option class="bs-title-option" value=""><?php echo $this->lang->line('search_select'); ?></option>
                        <?php foreach ($countries as $country) { ?>

                          <option value="<?php echo $country->id; ?>"> <?php echo $country->name; ?></option>
                        <?php } ?>



                      </select>
                      <input type="hidden"  id="clinic_location_id" value="<?php echo $this->session->userdata['clinic_location']; ?>" name="clinic_location_id">

                    </div>
                  </div>
                 
                </div>
               <!-- <div class="col-xs-12">
                <button type="button" id="add_new_patient"  class="btn btn-default">Submit</button>
              </div>-->
              </div>
              <!--tbs-end-->
              

            </div><!-- </form> -->

          </div>

            <?php
              if (isset($hp_avail_time->room)) {
                echo form_submit('submit', $btnText, "id='appoint_submit' style='display:none;' class='btn btn-primary btn-block' onclick='return validateAppnt();'");
              }
              ?>
              <?php //echo form_submit('button', 'Close', "id='appoint_close' class='btn btn-primary btn-block' onclick='self.close();'"); ?>
              <div class="popcalenderbtn">
               <input type="button" name="hiddenbutton" value="submit" id="appt_validat" class="btn btn-primary btn-block">
              <input type="button" name="button" value="Close"  data-dismiss="modal"  class="btn btn-primary btn-block">
</div>

        </div>

      </div>

    </div>
  
 <div class="col-xs-12 row_full">
            <div class="col-xs-12 col-sm-4 row_field"><label for="ticket-type" control-label></label></div>
            <div class="col-xs-12 col-sm-8  row_field">

            </div>
          </div> 



    <div class="popup">
      <button type="button" style="display:none;" id="btn-modal" class="btn btn-info " data-toggle="modal" data-target="#myModal"></button>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content -->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><?php echo $this->lang->line('patient_finder'); ?></h4>
            </div>
            <div class="modal-body">
              <div class="form-group" style="border-top: none;">
                <div class="patient_search_label"><label><?php echo $this->lang->line('enter_patient_keyword'); ?></label></div>
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
    <?php echo form_close(); ?> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/datepicker.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery/jquery-2.1.0.min.js"></script> 
    <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>  
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script> 
    <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/appointment/add_appointment.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script> 
    <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap-datepicker.js"></script> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
    <script src="<?php echo base_url(); ?>assets/js/hammerjs/hammer.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/hammerjs/hammer.fakemultitouch.js"></script>


    <script src="<?php echo base_url(); ?>assets/js/hammerjs/drum.js"></script>

    <script>
              $(document).ready(function () {
                $('.modal').on('shown.bs.modal', function () {
                  $(this).find('input:text:visible:first').focus();
                });



                jQuery("#appointment_hour,#appointment_minute,#appointment_time_format,#appointment_end_hour,#appointment_end_minute,#appointment_end_time_format,#date,#month,#fullYear").drum();

              });
    </script>
    <style>
      body {
        background-color: #fefefe;
        font-family: Arial, Verdana, sans-serif;
      }

      div.drum figure {
        text-align: center;
      }
    </style>


