 <table id="patientListing" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
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
         // echo "<pre>";
         //          print_r($all_patient_Details);
                foreach($patient_Details as $patient_Detail){   
                 
              
            ?>
              <tr>
                  <td><div class="action-btn-sec"><a href="#"><img src="<?php echo base_url();?>assets/images/notification_image.bmp">  </a></div></td>
                <td><?php echo $patient_Detail->last_name; ?></td>
                <td><?php echo $patient_Detail->first_name; ?></td>
                <td><?php echo $patient_Detail->date_of_birth; ?></td>
                <td>
                    <div class="row action-btn-sec">
                        <div class="col-md-4"> <a href="#"><span class="profile-details-icon"></span><span class="linktext"><?php echo $this->lang->line('profile_details'); ?></span></a> </div>
                         <div class="col-md-4">   <a href="#"><span class="billing-summary-icon"></span><span class="linktext"><?php echo $this->lang->line('billing_summary'); ?></span></a></div>
                          <div class="col-md-4"> <a href="#"><span class="consultation-history-icon"></span><span class="linktext"><?php echo $this->lang->line('consultation_history'); ?></span></a> </div>
                    </div>
                    
                                 </td>

              </tr>
            <?php    } 
         
            ?>  
            </tbody>

            </table>