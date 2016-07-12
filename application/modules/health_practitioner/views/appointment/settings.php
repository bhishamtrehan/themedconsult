<?php
/*
Template for changing appointment settings
*/
//Variables for appointment settings form fields starts here
if(sizeof($appnt_settings) > 0) {
	$setting_id = $appnt_settings->setting_id;
	$duration   = $appnt_settings->appointment_duration;
	$start_time = $appnt_settings->appointment_start_time;
	$end_time   = $appnt_settings->appointment_end_time;
}
else {
	$setting_id = '';
	$duration   = '15';
	$start_time = '8:00';
	$end_time   = '20:00';
}
$duration = array(
	'name'	=> 'duration',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_clinic_name'),
	'value' => $duration,
);
$start_time = array(
	'name'	=> 'start_time',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'id' => 'startTimepicker',
	'placeholder' => $this->lang->line('enter_clinic_admin_name'),
	'size'	=> 30,
	'autocomplete' => 'off',
	'value' => date("g:i a", strtotime($start_time)),
);
$end_time = array(
	'name'	=> 'end_time',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'id' => 'endTimepicker',
	'placeholder' => $this->lang->line('enter_clinic_admin_email'),
	'size'	=> 30,
	'autocomplete' => 'off',
	'value' => date("g:i a", strtotime($end_time)),
);

//Variables for clinic form fields ends here
?>
<title><?php echo $this->lang->line('appnt_settings').$this->lang->line('title_universal');?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.css">
<body>
<!-- WRAPPER -->
<div class="wrapper"> 
  
  <!-- TOP BAR -->
  <?php //$this->load->view ('inc/clinic_top_bar');?>
  <!-- /top --> 
  
  <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
  <div class="bottom">
    <div class="container">
      <div class="row"> 
        <!-- left sidebar -->
        <div class="col-md-2 left-sidebar"> 
          <?php //if($this->session->userdata['user_role'] == '5')
			//	$this->load->view ('inc/clinic_location_left_nav');
			//	else
				//$this->load->view ('inc/clinic_left_nav');	?>		  
        </div>
		  <!-- end left sidebar --> 
		<div class="col-md-10 content-wrapper practitioner_sectn"> <!-- InstanceBeginEditable name="body" -->
			<!-- top general alert -->
			<?php if($this->session->flashdata('display_message')!='') {?>
           <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
			<?php }?>
            <!-- end top general alert -->   
			<div class="widget">
				<div class="widget-header widget_pract">
				    <h3><i class="fa fa-list"></i><?php echo $this->lang->line('appnt_settings');?></h3>
				</div>
				<div class="widget-content">
	            <!-- content-wrapper -->
					<div class="row">
			<!--<div class="col-lg-4 ">
			<ul class="breadcrumb">
				<li><i class="fa fa-home"></i><a href="<?php echo base_url();?>"><?php echo $this->lang->line('title_clinic');?></a></li>
				<li class="active"><?php echo $this->lang->line('add_new_clinic');?></li>
			</ul>
			</div>-->
		</div>
          
              <?php echo form_open('clinic/appointment/appointment_settings',array('class' => 'form-horizontal form_health','id' => 'appointment_settings')); ?>
                <fieldset>
                  <div class="col-lg-12 ">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('appnt_duration');?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($duration); ?>
					  <?php echo $this->lang->line('appnt_duration_mins');?> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('day_start_time');?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($start_time); ?>
					  <?php echo $this->lang->line('appnt_start_msg');?> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('day_end_time');?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($end_time); ?>
					   <?php echo $this->lang->line('appnt_end_msg');?> 
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                      <?php echo form_hidden('action', $action);
					  echo form_submit('submit', $this->lang->line('update'), "class='btn btn-primary btn-block'"); ?>
                    </div>
                  </div>
                  <?php echo form_hidden('setting_id', $setting_id);
				  echo form_close();?>
                      
                  </div>
                 
                </fieldset>
           
                <!-- /content-wrapper --> 
                </div>
		    </div>	
		</div>
        <!-- /row --> 
      </div>
      <!-- /container --> 
    </div>
    <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT --> 
  </div>
</div>
<div class="popup">
 <button type="button" style="display:none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content"></div> 
    </div>
  </div>
</div>

<!-- /wrapper --> 
<!-- FOOTER -->
<?php $this->load->view ('inc/footer');?>
<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url();?>js/jquery.validate.js"></script> 
<script>
$('#startTimepicker').timepicker({
	template: false,
	showInputs: false,
	minuteStep: 5
});
$('#endTimepicker').timepicker({
	template: false,
	showInputs: false,
	minuteStep: 5
});


$(document).ready(function(){
	$.validator.addMethod("nospace",function(spaceset, element){
		return spaceset.trim();
	}, "Please provide atleast one character!");

	$.validator.addMethod('greaterThan', function(value, element, param) {
            
            var start = $(param).val();
            var end = value;
            var dtStart = Date.parse("1/1/2015 " + start);
            var dtEnd = Date.parse("1/1/2015 " + end);                      
            
		return this.optional(element) || dtEnd > dtStart;
	}, 'Invalid value');
	
	$.validator.addMethod('minValue', function(value) {
        return parseFloat(value) > 4;
    }, 'Minimum duration value should be greater than or equal to 5');
	
	$("#appointment_settings").validate({
		rules: {
			duration: {
				required: true,
				nospace: true,
				number: true,
				minValue: true,
			},
			start_time: {
				required: true,
			},
			end_time: {
				required: true,
				greaterThan: '#startTimepicker',
			}
		},
		messages: {
			duration: {
				required: "",
			},
			start_time: {
				required: "",
			},
			end_time: {
				required: "",
				greaterThan: "End time should be greater than start time.",
			}
		}
	});
	
});
</script>
<!-- FOOTER -->