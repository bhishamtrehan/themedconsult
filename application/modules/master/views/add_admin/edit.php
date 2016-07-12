<?php
/*
Template for editing admin 
*/
//Variables for admin form fields starts here

$username = array(
	'name'	=> 'username',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('username'),
	'value' => $output['username'],
);

$password = array(
	'name'	=> 'password',
	'id'    => 'password',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('password'),
);

$passwordc = array(
	'name'	=> 'passwordc',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('passwordc'),
);

$fname = array(
	'name'	=> 'fname',
	'maxlength'	=> 255,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('fname'),
	'size'	=> 30,
	'autocomplete' => 'off',
	'value' => $output['fname'],
);
$lname = array(
	'name'	=> 'lname',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('lname'),
	'value' => $output['lname'],
);
$email = array(
	'name'	=> 'email',
	'maxlength'	=> 255,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control email',
	'placeholder' => $this->lang->line('email'),
	'value' => $output['email'],
);
$website = array(
	'name'	=> 'website',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control',
	'placeholder' => $this->lang->line('website'),
	'value' => $output['website'],
);

$contact = array(
	'name'	=> 'contact',
	'maxlength'	=> 30,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('contact'),
	'value' => $output['contact'],
);
$company = array(
	'name'	=> 'company',
	'maxlength'	=> 30,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('company'),
	'value' => $output['company'],
);
$myArray = explode(',', $output['clinic_loc']);
$country = form_dropdown('country', $countries, $output['country_id'], 'id="country" class="form-control m-b-sm"' );
$status_drop = array('0' => 'Pending', '1' => 'Approved' );
$status = form_dropdown('status', $status_drop, $output['activated'] , 'id="status" class="form-control m-b-sm"');
$clinics = form_dropdown('clinic_loc[]', $clinicloc, $myArray , 'id="status" class="form-control m-b-sm" multiple');
//Variables for admin form fields ends here
?>

<body>
<!-- WRAPPER -->
<div class="wrapper"> 
 
  <div class="bottom">
  <div class="custom_title">
            <div class="container"> 
            <h3><?php 
				if(isset($title)){
					echo $title;
				}else{
					echo $this->lang->line('home');
				}
				?>
			</h3>
			<a class="btn btn-primary" href="<?php echo base_url();?>master/company/view"><?php echo $this->lang->line('view');?></a>
			</div>
			</div>
    <div class="container">
      <div class="row"> 
          <div class="widget">
           
            <div class="widget-content">
            
              <?php echo form_open($this->uri->uri_string(),array('class' => 'form-horizontal form_health','id' => 'add_staff_form')); ?>
                <fieldset>
                 
                  <div class="col-lg-6 ">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('username');?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($username); ?>
                    </div>
                  </div>
                  	<?php echo form_hidden('id', $output['id']); ?>
                  	<?php echo form_hidden('p_id', $output['admin_id']); ?>
				    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('password'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_password($password); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('passwordc'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_password($passwordc); ?>
                    </div>
                  </div>
				  
				 <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('fname'); ?><span class="astrik">*</span> </label>
                    <div class="col-sm-9">
                      <?php echo form_input($fname); ?>
					</div>
                  </div>
				  
				  
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('lname'); ?><span class="astrik">*</span> </label>
                    <div class="col-sm-9">
                      <?php echo form_input($lname);?>
					</div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('selectclinic');?> </label>
                    <div class="col-sm-9">
                      <?php echo $clinics; ?>
					</div>
                  </div>
                  </div>
                  
                  <div class="col-lg-6">
					 <div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('email'); ?><span class="astrik">*</span> </label>
	                    <div class="col-sm-9">
	                      <?php echo form_input($email);?>
						</div>
	                  </div>

					  <div>
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo $this->lang->line('website'); ?></label>
							<div class="col-sm-9">
								<?php echo form_input($website); ?>
							</div>
						</div>
					</div> 
					  
				 	<div>
					<div class="form-group" >
						<label class="col-sm-3 control-label"><?php echo $this->lang->line('contact'); ?><span class="astrik">*</span></label>
						<div class="col-sm-9">
							<?php echo form_input($contact); ?>
						</div>
					</div>
					</div> 
					
					<div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('company'); ?></label>
	                    <div class="col-sm-9">
	                      <?php echo form_input($company); ?>
						</div>
                  	</div>

                  	<div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('country'); ?><span class="astrik">*</span></label>
	                    <div class="col-sm-9">
	                      <?php echo $country; ?>
						</div>
                  	</div>

                  	<div class="form-group">
	                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('status'); ?><span class="astrik">*</span></label>
	                    <div class="col-sm-9">
	                      <?php echo $status; ?>
						</div>
                  	</div>
                  </div>
                 
                  <div class="col-lg-12">
                  <div class="form-group">
                    <div class="col-sm-offset-9 col-sm-3">
                      <?php echo form_submit('submit', $this->lang->line('update'),"class='btn btn-primary btn-block'"); ?>
                    </div>
                  
                  <?php echo form_close();?>
                  </div>
                  </div>
                </fieldset>
            </div>
          </div>
          <!-- InstanceEndEditable --> 
          <!-- /content-wrapper --> 
       	
        <!-- /row --> 
      </div>
      <!-- /container --> 
    </div>
    <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT --> 
  </div>
</div>
<!-- /wrapper --> 

<!-- Javascript --> 

<!-- FOOTER -->
<?php $this->load->view ('inc/footer');?>
<!-- FOOTER -->
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/mc_js/admin/add_admin/edit_admin.js"></script>
