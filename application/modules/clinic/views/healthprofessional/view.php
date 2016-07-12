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
     <div class="add-helth-btn">
            <a href="#">ADD HEALTH PROFESSIONAL</a>
        </div>
      <div class="patient-page-inputs">
                            <div class="main-row">
                                <div class="col-5">
                                     <label>Patient Surname:</label>
                                     <input type="text" value="" name="patient_surname" id="patient_surname" placeholder="Goh">
                                    
                                </div>
                                <div class="col-5">
                                    
                                     <label>Patient Firstname:</label>
                 <input type="text" value="" name="patient_firstname" id="patient_firstname" placeholder="Robin">
                                </div>
                                <div class="col-5">
                                    <label>Speciality</label>
                                    <select>
                                        <option> Select</option>
                                    </select>
                                </div>
                                 <div class="col-5">
                                    <label>Medical Practice/Hospital</label>
                                    <select>
                                        <option> Select</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label>&nbsp;</label>
                                      <button type="button" id="patient_search"><?php echo $this->lang->line('search'); ?></button> 
                                </div>
                            </div>
                
                
                
                  
</div>
     
          
              <!-- content-wrapper -->
          <!--div class="col-md-10 content-wrapper"--> <!-- InstanceBeginEditable name="body" -->
                    <div class="table_scroller no-scroll">
                <!-- <label><?php echo $this->lang->line('patient_surname'); ?></label>
                 <input type="text" value="" name="patient_surname" id="patient_surname"> 
                 <label><?php echo $this->lang->line('patient_firstname'); ?></label>
                 <input type="text" value="" name="patient_firstname" id="patient_firstname">
                <label><?php echo $this->lang->line('date_of_birth'); ?></label>
                  <input type="text" value="" name="dob" id="dob">
                    <button type="button" id="patient_search"><?php echo $this->lang->line('search'); ?></button>  -->

            <table id="patientListing" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer patientsearchstyle" cellspacing="0" width="100%">
            <thead
              <tr>
                <th><?php echo $this->lang->line('doctor_photo'); ?></th>
                <th><?php echo $this->lang->line('surname'); ?></th>
                <th><?php echo $this->lang->line('first_name'); ?></th>
                <th><?php echo $this->lang->line('specialities'); ?></th>
                <th><?php echo $this->lang->line('medicalpractice'); ?></th>
                <th><?php echo $this->lang->line('status'); ?></th>
                <th><?php echo $this->lang->line('action'); ?></th>
               
              </tr>
            </thead>
            <tbody>
            <?php 
                  //  echo "<pre>";
                  // print_r($all_hp_Details);
                  // die();
                foreach($all_hp_Details as $all_hp_Detail){   
                
              
            ?>
              <tr>
                <td><img src="<?php echo base_url();?>assets/images/notification_image.bmp"> </td>
                <td><?php echo $all_hp_Detail['surname']; ?></td>
                <td><?php echo $all_hp_Detail['name']; ?></td>
                <td><?php //echo $all_hp_Detail['name']; ?></td>
                <td><?php //echo $all_hp_Detail['name']; ?></td>
                <td><?php $status=$all_hp_Detail['name'];if($status==0){echo "Verified";}else{ echo "Non Verified"; }?></td>
                <td>
                    <div class="row action-btn-sec centeraction">
                        <div class="col-md-6">  <a href="#"><span class="message"></span><span class="linktext"><?php echo $this->lang->line('message'); ?></span></a></div>
                        <div class="col-md-6">  <a href="#"><span class="activate"></span> <span class="linktext">  <?php echo $this->lang->line('activate'); ?></span></a></div>
                   
                    </div>
                    <div class="row action-btn-sec centeraction">
                        <div class="col-md-6">  <a href="#"><span class="edit"></span> <span class="linktext"> <?php echo $this->lang->line('edit'); ?> </span></a></div>
                        <div class="col-md-6"> <a href="#"><span class="delete"></span> <span class="linktext"><?php echo $this->lang->line('delete'); ?></span> </a></div>
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

<!-- /wrapper --> 
<!-- FOOTER -->
<!-- FOOTER -->
<script>var baseUrl ="<?php echo base_url(); ?>";</script>
  <?php $this->load->view('inc/footer'); ?>
   <script src="<?php echo base_url();?>assets/js/mc_js/clinics/patientsearch/patientsearch.js"></script>