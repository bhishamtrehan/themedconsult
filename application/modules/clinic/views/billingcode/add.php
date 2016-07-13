<?php
/*
Template for adding new clinic 
*/
//Variables for clinic form fields starts here

$billing_name = array(
	'name'	=> 'billing_name',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'id' => 'billing_name',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('billing_name'),
);

$billing_code = array(
	'name'	=> 'billing_code',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'id' => 'billing_code',
	'placeholder' => $this->lang->line('billing_code'),
	'size'	=> 30,
	'autocomplete' => 'off',
	
);
$duration = array(
	'name'	=> 'duration',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'id' => 'duration',
	'placeholder' => $this->lang->line('duration'),
	'size'	=> 30,
	'autocomplete' => 'off',
	
);
$price = array(
	'name'	=> 'price',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'id' => 'price',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('price'),
);
$gst= array(
	'name'	=> 'gst',
	'maxlength'	=> 255,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control',
	'id' => 'gst',
	'placeholder' => $this->lang->line('gst'),
);


//Variables for clinic form fields ends here
?>
<title><?php echo $this->lang->line('add_new_clinic').$this->lang->line('title_universal');?></title>

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
				// if(isset($title)){
				// 	echo $title;
				// }else{
					//echo $this->lang->line('add_billing');
				// }
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
           
            <div class="widget-content">
          
    		    
               <?php echo form_open($baseurl.'clinic/billingcodes/add_billingcode',array('class' => 'form-horizontal form_health','id' => 'add_billing_form')); ?>
                <fieldset>
                 <br/>
                 <div class="freesheduleform">
                   <div style="display: block;" class="custom_title billcodetitle">
              <div class="container">
                <h3><?php   echo $this->lang->line('add_billing');?></h3>
              </div>
            </div>
                 <div class="row">
                  <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('enter_billing_name');?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($billing_name); ?>
                    </div>
                  </div>
					  
				    <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('billing_code'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($billing_code); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('duration'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($duration); ?>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('price'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($price); ?>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('gst'); ?><span class="astrik">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($gst); ?>
                    </div>
                  </div>
                        <?php echo form_submit('', $this->lang->line('submit'),"class='btn btn-primary btn-block'"); ?>
                  <?php echo form_close();?>
			                  </div>
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
<script src="<?php echo base_url();?>assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script> 
<!-- <script src="<?php echo base_url();?>assets/js/mc_js/admin/clinic/add_clinic.js"></script>  -->
<script src="<?php echo base_url();?>assets/js/mc_js/admin/clinic/billingcodes.js"></script> 
