<?php
/*
  Template for adding new clinic
 */
//Variables for clinic form fields starts here

$clinic_name = array(
    'name' => 'clinic_name',
    'maxlength' => 255,
    'size' => 30,
    'class' => 'form-control',
    'autocomplete' => 'off',
    'placeholder' => $this->lang->line('enter_clinic_name'),
);

$clinic_contact_email = array(
    'name' => 'clinic_admin_email[]',
    'maxlength' => 80,
    'class' => 'form-control',
    'placeholder' => $this->lang->line('enter_clinic_admin_email'),
    'size' => 30,
    'autocomplete' => 'off',
    'value' => set_value('clinic_admin_email'),
);
$clinic_street_address = array(
    'name' => 'clinic_street_address',
    'maxlength' => 255,
    'size' => 30,
    'class' => 'form-control',
    'autocomplete' => 'off',
    'placeholder' => $this->lang->line('enter_street_add1'),
);
$clinic_street_address_line2 = array(
    'name' => 'clinic_street_address_line2',
    'maxlength' => 255,
    'size' => 30,
    'autocomplete' => 'off',
    'class' => 'form-control',
    'placeholder' => $this->lang->line('enter_street_add2'),
);
$clinic_suburb = array(
    'name' => 'clinic_suburb',
    'maxlength' => 80,
    'size' => 30,
    'autocomplete' => 'off',
    'class' => 'clinic_suburb form-control',
    'placeholder' => $this->lang->line('enter_suburb'),
);

$clinic_state_list = array();
$clinic_city_list = array();
$countries_list = form_dropdown('country', $countries, '', 'id="country" class="form-control m-b-sm" onChange="getStateList(this.value);"');

$clinic_state = form_dropdown('clinic_state', $clinic_state_list, '', 'class="clinic_state form-control m-b-sm" onChange="getCityPostcodes(this.value);" placeholder="Select your state"');

$clinic_postcode = array(
    'name' => 'clinic_postcode',
    'maxlength' => 20,
    'size' => 30,
    'class' => 'form-control',
    'autocomplete' => 'off',
    'id' => 'clinic_postcode',
    'placeholder' => $this->lang->line('enter_postcode'),
);
$clinic_telephone_code = array(
    'name' => 'clinic_telephone_code',
    'maxlength' => 3,
    'size' => 30,
    'autocomplete' => 'off',
    'placeholder' => $this->lang->line('enter_area_code'),
);
$clinic_telephone_no = array(
    'name' => 'clinic_telephone_no[]',
    'maxlength' => 80,
    'size' => 30,
    'autocomplete' => 'off',
    'class' => 'form-control',
    'placeholder' => $this->lang->line('enter_telephone'),
);

$clinic_fax_number = array(
    'name' => 'clinic_fax_number[]',
    'maxlength' => 80,
    'size' => 30,
    'autocomplete' => 'off',
    'class' => 'form-control',
    'placeholder' => $this->lang->line('enter_fax'),
);

$clinic_room = array(
    'name' => 'clinic_room[]',
    'maxlength' => 255,
    'size' => 30,
    'class' => 'form-control',
    'autocomplete' => 'off',
    'placeholder' => $this->lang->line('enter_clinic_room'),
);

$clinic_status_list = array(
    '0' => 'Pending',
    '1' => 'Approved'
);
$clinic_status = form_dropdown('clinic_status', $clinic_status_list, '', 'class="clinic_status form-control m-b-sm" placeholder="Select status"');

//Variables for clinic form fields ends here
?>
<title><?php echo $this->lang->line('add_new_clinic') . $this->lang->line('title_universal'); ?></title>

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
            if (isset($title)) {
              echo $title;
            } else {
              echo $this->lang->line('home');
            }
            ?>
          </h3>
        </div>
      </div>
      <div class="container">
        <div class="row"> 
          <!-- left sidebar -->

          <!-- end left sidebar --> 

          <!-- top general alert -->
          <!--<div class="alert alert-danger top-general-alert"> <span>If you <strong>can't see the logo</strong> on the top left, please reset the style on right style switcher (for upgraded theme only).</span>
            <button type="button" class="close">&times;</button>
          </div>-->
          <!-- end top general alert --> 

          <!-- content-wrapper -->

          <div class="widget">

            <div class="widget-content c_wrapper">
              <div class="custom_title" style="display: block;">
        <div class="container">
          <h3><?php
            if (isset($title)) {
              echo $title;
            } else {
              echo $this->lang->line('home');
            }
            ?>
          </h3>
        </div>
      </div>
              <?php echo form_open($this->uri->uri_string(), array('class' => ' add_php form-horizontal form_health', 'id' => 'add_clinic_form')); ?>
              <fieldset>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('enter_clinic_name'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-12">

                      <?php echo form_input($clinic_name); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('street_address'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-6 col-xs-12">
                      <?php echo form_input($clinic_street_address); ?>
                    </div>
                     <div class="col-sm-6 col-xs-12">
                      <?php echo form_input($clinic_street_address_line2); ?>
                    </div>
                  </div>
<!--                  <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                   
                  </div>-->

                  <div class="form-group">
                   
                    <div class="col-sm-6 col-xs-12">
                       <label class="control-label"><?php echo $this->lang->line('country'); ?><span class="astrik">*</span> </label>
                      <?php echo $countries_list; ?>
                    </div>
                     <div class="col-sm-6 col-xs-12">
                        <label class="control-label"><?php echo $this->lang->line('suburb'); ?><span class="astrik">*</span> </label>
                      <?php echo form_input($clinic_suburb); ?>
                    </div>
                  </div>


                  

                  <div class="form-group">
                   
                    <div class="col-sm-6 col-xs-12">
                       <label class="control-label"><?php echo $this->lang->line('state'); ?><span class="astrik">*</span> </label>
                      <?php echo $clinic_state; ?>
                    </div>
                    <div class="col-sm-6 col-xs-12" id="city_lists" style="display:none;">
                      <label class="control-label"><?php echo $this->lang->line('city'); ?><span class="astrik">*</span></label>
                      <?php echo form_dropdown('clinic_city', $clinic_city_list, '', 'class="clinic_city form-control m-b-sm"'); ?>
                    </div>
                  </div>
                
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('postcode'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-12">
                      <?php echo form_input($clinic_postcode); ?>
                    </div>
                  </div>


                </div>

                <div class="col-lg-12">
                  <div id="clinicno">
                    <div class="form-group" id="newNo_1">
                      <label class="col-sm-12 control-label"><?php echo $this->lang->line('clinic_telephone'); ?></label>
                      <div class="col-sm-12">
                        <div class="input-group">

                          <?php echo form_input($clinic_telephone_no); ?>
                          <span class="input-group-btn">
                            <a class="btn btn-default newOfficeNo" type="button" ><i class="fa fa-plus"  onClick="addNewTelephone(1)"></i></a>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div> 
<!--                  <div class=" custom_new">
                      <a href="javascript:void(0);"><i class="fa fa-plus" onClick="addNewTelephone(1)"></i></a>
                  </div>-->







                  <div id="faxno">
                    <div class="form-group" id="newFax_1">
                      <label class="col-sm-3 control-label"><?php echo $this->lang->line('fax_number'); ?></label>
                      <div class="col-sm-12">
                         <div class="input-group">
                        <?php echo form_input($clinic_fax_number); ?>
                            <span class="input-group-btn">
                            <a class="btn btn-default newFaxNo" type="button"><i class="fa fa-plus" onClick="addNewFax(1)"></i></a>
                          </span>
                         </div>
                      </div>
                    </div>
                  </div> 
<!--                  <div class="newFaxNo custom_new"><a href="javascript:void(0);"><i class="fa fa-plus"></i></a></div>-->


                  <div id="emailAdd">
                    <div class="form-group" id="newEmail_1">
                      <label class="col-sm-3 control-label"><?php echo $this->lang->line('cinic_person_email_address'); ?></label>
                      <div class="col-sm-12">
                         <div class="input-group">
                        <?php echo form_input($clinic_contact_email); ?>
                            <span class="input-group-btn">
                            <a class="btn btn-default newEmailAddress" type="button"><i class="fa fa-plus" onClick="addNewEmail(1)"></i></a>
                            </span>
                         </div>
                      </div>
                    </div>
                  </div> 
<!--                  <div class="newEmailAddress custom_new"><a href="javascript:void(0);"><i class="fa fa-plus" onClick="addNewEmail(1)"></i></a></div>-->

                  <div id="roomAdd">
                    <div class="form-group" id="newroom_1">
                      <label class="col-sm-3 control-label"><?php echo $this->lang->line('clinic_room'); ?></label>
                      <div class="col-sm-12">
                         <div class="input-group">
                        <?php echo form_input($clinic_room); ?>
                            <span class="input-group-btn">
                              <a class="btn btn-default newroom" type="button"><i class="fa fa-plus" onClick="addNewRoom(1)"></i></a>
                            </span>
                         </div>
                      </div>
                    </div>
                  </div> 
<!--                  <div class="newroom custom_new"><a  href="javascript:void(0)"><i class="fa fa-plus" onClick="addNewRoom(1)"></i></a></div>-->


                  <?php echo form_hidden('companyId', $companyId); ?>
                  <?php echo form_hidden('clinic_action', 'insert'); ?>

                  <div class="form-group">
                    <div class=" col-sm-12">
                      <?php echo form_submit('submit', $this->lang->line('submit'), "class='btn btn-primary btn-block'"); ?>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
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
  <?php $this->load->view('inc/footer'); ?>
  <!-- FOOTER -->
  <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script> 
  <script src="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script> 
  <script src="<?php echo base_url(); ?>assets/js/mc_js/admin/clinic/add_clinic.js"></script> 
