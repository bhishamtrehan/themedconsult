<title><?php 
$fronttitile = ($clinic_disabled==0)? $this->lang->line('clinic_activate_titile'): $this->lang->line('clinic_disabled_titile');
echo sprintf($this->lang->line('title_clinic_page'),$fronttitile).$this->lang->line('title_universal');?></title>
<body>
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
                            </div>
                            </div>  
<div id="main-wrapper" class="container">
                    <div class="row">
                    
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                  <div id="rootwizard">
                    <!--    <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i><?php echo $this->lang->line('clinic_created'); ?> </a></li>
                                            <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-calendar"></i><?php echo $this->lang->line('clinic_access'); ?></a></li>
                                            </ul> -->
    <div class="tab-content">
          <div class="tab-pane active fade in" id="tab1">             
        <!-- end top general alert -->   
    
      
       
          
              <!-- content-wrapper -->
          <!--div class="col-md-10 content-wrapper"--> <!-- InstanceBeginEditable name="body" -->
                    <div class="table_scroller no-scroll">
                        <div class="patient-page-inputs">
                            <div class="row">
                                <div class="col-md-3">
                                     <label><?php echo $this->lang->line('patient_surname'); ?></label>
                                     <input type="text" value="" name="patient_surname" id="patient_surname" placeholder="Goh">
                                    
                                </div>
                                <div class="col-md-3">
                                    
                                     <label><?php echo $this->lang->line('patient_firstname'); ?></label>
                 <input type="text" value="" name="patient_firstname" id="patient_firstname" placeholder="Robin">
                                </div>
                                <div class="col-md-3">
                                    <label><?php echo $this->lang->line('date_of_birth'); ?></label>
                  <input type="text" value="" class="calender-icon" name="dob" id="dob" >
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                      <button type="button" id="patient_search"><?php echo $this->lang->line('search'); ?></button> 
                                </div>
                            </div>
                
                
                
                  
</div>
            <table id="patientListing" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer patientsearchstyle" cellspacing="0" width="100%">
            <thead
              <tr>
                <th><?php echo $this->lang->line('patient_picture'); ?></th>
                <th><?php echo $this->lang->line('surname'); ?></th>
                <th><?php echo $this->lang->line('first_name'); ?></th>
                <th><?php echo $this->lang->line('dob'); ?></th>
                <th><?php echo $this->lang->line('action'); ?></th>
               
              </tr>
            </thead>
            <tbody>
            <?php 
          
                foreach($all_patient_Details as $all_patient_Detail){   
                 
              
            ?>
              <tr>
                <td><img src="<?php echo base_url();?>assets/images/notification_image.bmp"> </td>
                <td><?php echo $all_patient_Detail->last_name; ?></td>
                <td><?php echo $all_patient_Detail->first_name; ?></td>
                <td><?php echo $all_patient_Detail->date_of_birth; ?></td>
                <td>
                    <div class="row action-btn-sec">
                        <div class="col-md-4"> <a href="javascript:void(0);" class="patientInfo" data-pid="<?php echo $all_patient_Detail->patient_id; ?>" ><span class="profile-details-icon"></span><span class="linktext"><?php echo $this->lang->line('profile_details'); ?></span></a> </div>
                         <div class="col-md-4">   <a href="javascript:void(0);" class="patientBilling" data-pid="<?php echo $all_patient_Detail->patient_id; ?>"><span class="billing-summary-icon"></span><span class="linktext"><?php echo $this->lang->line('billing_summary'); ?></span></a></div>
                          <div class="col-md-4"> <a href="javascript:void(0);" class="patientCons" data-pid="<?php echo $all_patient_Detail->patient_id; ?>"><span class="consultation-history-icon"></span><span class="linktext"><?php echo $this->lang->line('consultation_history'); ?></span></a> </div>
                    </div>
                                
                    
                </td>

              </tr>
            <?php    } 
         
            ?>  
            </tbody>

            </table>
                      </div>
          <!--/div-->
                <!-- /content-wrapper --> 
               
       
      </div>
    
    </div>
      <!-- /row --> 
      </div>
      <!-- /container --> 
    </div>
    <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT --> 
  </div>
</div>
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
<!-- FOOTER -->
<script>var baseUrl ="<?php echo base_url(); ?>";</script>
  <?php $this->load->view('inc/footer'); ?>
   <script src="<?php echo base_url();?>assets/js/mc_js/clinics/patientsearch/patientsearch.js"></script>
   <script src="<?php echo base_url();?>assets/js/mc_js/clinics/getPatientInfo.js"></script>
     <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
   <script type="text/javascript"> 
    $( "#dob" ).datepicker();
  $( "#dob" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
    </script>