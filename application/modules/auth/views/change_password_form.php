<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
 /* ?> 

<title><?php echo $this->lang->line('change_password').$this->lang->line('title_universal');?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.css">
<style>
	.form_error p
	{
		color: #ff0000;
	}
</style>
<body>
<!-- WRAPPER -->
<div class="wrapper"> 
  
  <!-- TOP BAR -->
  <?php
  if($role_id==1){  
		     $this->load->view ('inc/top_bar');
		  }elseif($role_id==2){  
		     $this->load->view ('inc/clinic_top_bar');
		  }elseif($role_id==3){  
		      $this->load->view ('inc/practitioner_top_bar'); 
		  }elseif($role_id==4){  
		      $this->load->view ('inc/patient_top_bar'); 
		  }else{  
		      $this->load->view ('inc/clinic_top_bar'); 
		  }
  ?>
  <!-- /top --> 
  
  <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
  <div class="bottom">
    <div class="container">
      <div class="row"> 
        <!-- left sidebar -->
        <div class="col-md-2 left-sidebar"> 
          <?php 
          if($role_id==1){  
		     $this->load->view ('inc/admin_left_nav');
		  }elseif($role_id==2){  
		     $this->load->view ('inc/clinic_left_nav');
		  }elseif($role_id==3){  
		      $this->load->view ('inc/practitioner_left_nav'); 
		  }elseif($role_id==4){  
		      $this->load->view ('inc/patient_left_nav'); 
		  }else{  
		      $this->load->view ('inc/clinic_location_left_nav'); 
		  }
          ?>		  
        </div>
		  <!-- end left sidebar --> 
		  
		  <!-- top general alert -->
			<?php if($this->session->flashdata('display_message')) { ?>
           <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
			<?php } ?>
          <!-- end top general alert --> 
		<div id="checking_security" class="col-md-10 content-wrapper practitioner_sectn"> <!-- InstanceBeginEditable name="body" -->			  
			<div class="widget">
				<div class="widget-header widget_pract">
				    <h3><i class="fa fa-list"></i>Change Password</h3>
				</div>
				
          <div>      <?php */ ?> 
            <div class="widget-content"  id="checking_security">
              <?php echo form_open($this->uri->uri_string(),array('class' => 'form-horizontal form_health','id' => 'change_password')); ?>
                <fieldset>
                  <legend><?php echo $this->lang->line('general_info');?></legend>
                  
                  <div class="col-lg-12 ">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Old Password<span class="astrik">*</span></label>
                    <div class="col-sm-9">
						<?php echo form_password($old_password,'',"class='form-control'"); ?>
						<span class="form_error"><?php echo form_error($old_password['name']); ?></span>
                    </div>
				  </div>
				  <div class="form-group">
                    <label class="col-sm-3 control-label">New Password<span class="astrik">*</span></label>
                    <div class="col-sm-9">
					     <?php echo form_password($new_password,'',"class='form-control'"); ?>	
						 <span class="form_error"><?php echo form_error($new_password['name']); ?></span>
                    </div>				    
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Confirm New Password<span class="astrik">*</span></label>
                    <div class="col-sm-9">
						<?php echo form_password($confirm_new_password,'',"class='form-control'"); ?>		
						<span class="form_error"><?php echo form_error($confirm_new_password['name']); ?></span>
                    </div>					
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <?php //echo form_hidden('action', $action);
					  echo form_submit('change', 'Change Password',"class='btn btn-primary btn-block'"); ?>
                    </div>
                  </div>
                  <?php echo form_close();?>
                      
                  </div>
                 
                </fieldset>
            </div>
        <?php /* ?>  </div>
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
<script src="<?php echo base_url();?>js/jquery.validate.js"></script> 
<script src="<?php echo base_url();?>js/change_password.js"></script> 
<!-- FOOTER -->
* 
<?php */?> 