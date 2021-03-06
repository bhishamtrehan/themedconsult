<?php
/*
Template for Editing clinic for superadmin
*/
//Variables for clinic form fields with values starts here

$clinic_name = array(
	'name'	=> 'clinic_name',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_clinic_name'),
	'value' => $clinicDetails['clinic_name'],
);

$clinic_contact_email = array(
	'name'	=> 'clinic_admin_email',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('enter_clinic_admin_email'),
	'size'	=> 30,
	'autocomplete' => 'off',
	'value'	=> set_value('clinic_contact_email_address'),
	//'value' => $clinicDetails['clinic_contact_email_address'],
);
$clinic_street_address = array(
	'name'	=> 'clinic_street_address',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_street_add1'),
	'value' => $clinicDetails['street_address'],
);
$clinic_street_address_line2 = array(
	'name'	=> 'clinic_street_address_line2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control',
	'placeholder' => $this->lang->line('enter_street_add2'),
	'value' => $clinicDetails['street_address_2'],
);
$clinic_suburb = array(
	'name'	=> 'clinic_suburb',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'clinic_suburb form-control',
	'placeholder' => $this->lang->line('enter_suburb'),
);

$clinic_state_list     	= array();
$clinic_city_list		= array();
$countries_list       = form_dropdown('country', $countries,  $cityData['country_id'], 'id="country" class="form-control m-b-sm" onChange="getStateList(this.value);"');

$clinic_state       = form_dropdown('clinic_state', $states, $cityData['state_id'], 'class="clinic_state form-control m-b-sm" onChange="getCityPostcodes(this.value);" placeholder="Select your state"');

$clinic_postcode = array(
	'name'	=> 'clinic_postcode',
	'maxlength'	=> 20,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'id' => 'clinic_postcode',
	'placeholder' => $this->lang->line('enter_postcode'),
	'value' => $clinicDetails['postcode'],
);

$clinic_telephone_no = array(
	'name'	=> 'clinic_telephone_no',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_telephone'),
	//'value' => $clinicDetails['telephone'],
);

$clinic_fax_number = array(
	'name'	=> 'clinic_fax_number',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control',
	'placeholder' => $this->lang->line('enter_fax'),
	//'value' => $clinicDetails['fax_number'],
);

$clinic_room = array(
	'name'	=> 'clinic_room',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_clinic_room'),
	//'value' => $clinicDetails['clinic_room'],
);

$clinic_status_list = array(
						'0' =>'Pending',
						'1' =>'Approved'
						);
$clinic_status       = form_dropdown('clinic_status', $clinic_status_list, $clinicDetails["status"], 'class="clinic_status form-control m-b-sm" placeholder="Select status"');

//Variables for clinic form fields ends here
?>
<title><?php echo $this->lang->line('edit_clinic').$this->lang->line('title_universal');?></title>

<body>
<!-- WRAPPER -->
<div class="wrapper"> 
  <!-- TOP BAR -->
  <?php //$this->load->view ('inc/top_bar');?>
  <!-- /top --> 
  
  <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
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
              <?php echo form_open($this->uri->uri_string(),array('class' => 'form-horizontal form_health','id' => 'add_clinic_form')); ?>
            </div>
            </div>
    <div class="container">
      <div class="row"> 
       
        
        <!-- top general alert -->
        <!--<div class="alert alert-danger top-general-alert"> <span>If you <strong>can't see the logo</strong> on the top left, please reset the style on right style switcher (for upgraded theme only).</span>
          <button type="button" class="close">&times;</button>
        </div>-->
        <!-- end top general alert --> 
        
        <!-- content-wrapper -->
		<?php if($this->session->flashdata('display_message')!='') { ?>
			   <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
		<?php }?>
	
          <div class="widget">
           
            <div class="widget-content">
            
                <fieldset>
                  
                  
                  <div class="col-lg-6 ">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('enter_clinic_name');?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($clinic_name); ?>
                    </div>
                  </div>
					  
				    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('street_address'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($clinic_street_address); ?>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                      <?php echo form_input($clinic_street_address_line2); ?>
                    </div>
                  </div>
					  
				 <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('country'); ?><span class="astrik">*</span> </label>
                    <div class="col-sm-9">
                      <?php echo $countries_list; ?>
					</div>
                  </div>
				  
				  
                  <div class="form-group" id="suburb_lists" style="display:none;">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('suburb'); ?><span class="astrik">*</span> </label>
                    <div class="col-sm-9">
                      <?php echo form_input($clinic_suburb);?>
					</div>
                  </div>
                  
                    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('state'); ?><span class="astrik">*</span> </label>
                    <div class="col-sm-9">
                      <?php echo $clinic_state; ?>
                    </div>
                  </div>
               	   <div class="form-group" id="city_lists" <?php if($clinicDetails['is_suburb'] =='1') {?>style="display:none;"<?php }?>>
                    <label for="ticket-email" class="col-sm-3 control-label"><?php echo $this->lang->line('city'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_dropdown('clinic_city', $cities, $cityData['city_id'], 'class="clinic_city form-control m-b-sm"');?>
                    </div>
                  </div>
                 
  
                      
                  </div>
                  
                  <div class="col-lg-6">
					   <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('postcode'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($clinic_postcode);?>
                    </div>
                  </div>
				 <div id="clinicno">
					 <?php
						$teleNos = explode('::',$clinicDetails['telephone']);
						$i =1; foreach($teleNos as $no){ ?>
					 		<div class="form-group" id="newNo_<?php echo $i; ?>">
							<label class="col-sm-3 control-label"><?php echo $this->lang->line('clinic_telephone'); ?></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="Enter telephone number" autocomplete="off" size="30" maxlength="80" value="<?php echo $no; ?>" name="clinic_telephone_no[]">
								<?php if($i > 1){ ?>
									<a href="javascript:void(0);" onclick="removeCliNo(<?php echo $i; ?>)">X</a>
								<?php } ?>
							</div>
						</div>
					 	<?php $i++; } ?>
						
					</div> 
					  <div class="newOfficeNo"><a  href="javascript:void(0)" onclick="addNewTelephone(<?php echo count($teleNos); ?>)"><?php echo $this->lang->line('add_another_telephone'); ?></a></div>
					  
					  <div id="faxno">
					 <?php
						$faxNos = explode('::',$clinicDetails['fax_number']);
						$i =1; foreach($faxNos as $no){ ?>
					 		<div class="form-group" id="newFax_<?php echo $i; ?>">
							<label class="col-sm-3 control-label"><?php echo $this->lang->line('fax_number'); ?></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="Enter fax number" autocomplete="off" size="30" maxlength="80" value="<?php echo $no; ?>" name="clinic_fax_number[]">
								<?php if($i > 1){ ?>
									<a href="javascript:void(0);" onclick="removeFaxNo(<?php echo $i; ?>)">X</a>
								<?php } ?>
							</div>
						</div>
					 	<?php $i++; } ?>
						
					</div> 
					  <div class="newFaxNo"><a  href="javascript:void(0)" onclick="addNewFax(<?php echo count($faxNos); ?>)"><?php echo $this->lang->line('add_another_fax'); ?></a></div>
					  
			
					   <div id="emailAdd">
					 <?php
						$Emailadd = explode('::',$clinicDetails['clinic_contact_email_address']);
						$i =1; foreach($Emailadd as $no){ ?>
					 		<div class="form-group" id="newEmail_<?php echo $i; ?>">
							<label class="col-sm-3 control-label"><?php echo $this->lang->line('cinic_person_email_address'); ?></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="Enter email address" autocomplete="off" size="30" maxlength="80" value="<?php echo $no; ?>" name="clinic_admin_email[]">
								<?php if($i > 1){ ?>
									<a href="javascript:void(0);" onclick="removeEmail(<?php echo $i; ?>)">X</a>
								<?php } ?>
							</div>
						</div>
					 	<?php $i++; } ?>
						
					</div> 
					  <div class="newEmailAddress"><a  href="javascript:void(0)" onclick="addNewEmail(<?php echo count($Emailadd); ?>)"><?php echo $this->lang->line('add_another_email'); ?></a></div>
					  
		
                  
                       <div id="roomAdd">
					 <?php
						$Roomadd = explode('::',$clinicDetails['clinic_room']);
						$i =1; foreach($Roomadd as $no){ ?>
					 		<div class="form-group" id="newroom_<?php echo $i; ?>">
							<label class="col-sm-3 control-label"><?php echo $this->lang->line('clinic_room'); ?></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="Room" autocomplete="off" size="30" maxlength="80" value="<?php echo $no; ?>" name="clinic_room[]">
								<?php if($i > 1){ ?>
									<a href="javascript:void(0);" onclick="removeRoom(<?php echo $i; ?>)">X</a>
								<?php } ?>
							</div>
						</div>
					 	<?php $i++; } ?>
						
					</div> 
					  <div class="newroom"><a  href="javascript:void(0)" onclick="addNewRoom(<?php echo count($Roomadd); ?>)"><?php echo $this->lang->line('add_another_room'); ?></a></div>
					  
                  
                  
                   
					 
					    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('status'); ?><span class="astrik">*</span> </label>
                    <div class="col-sm-9">
                      <?php echo $clinic_status; ?>
					</div>
                  </div>
				 
				
                
					<?php echo form_hidden('clinic_action', 'update'); ?>
					<?php echo form_hidden('clinic_city_id', $clinicDetails['city_id']); ?>
					<?php echo form_hidden('clinic_suburb_id', $clinicDetails['suburb_id']);?>
					<?php echo form_hidden('clinic_id', $this->encryption->encode($clinicDetails['clinic_id'])); 
					  
					 ?>

                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <?php echo form_submit('submit', $this->lang->line('submit'),"class='btn btn-primary btn-block'"); ?>
                    </div>
                  </div>
                  <?php echo form_close();?>
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

<!-- FOOTER -->
<?php $this->load->view ('inc/footer');?>
<!-- FOOTER -->
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/mc_js/admin/clinic/edit_clinic.js"></script> 