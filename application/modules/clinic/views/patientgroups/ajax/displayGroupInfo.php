   <div class="panel-body">
       <div class="leftgroupinfo">
           <h2><?php echo $this->lang->line('group_name'); ?>:<span class="groupname"><?php echo $GroupDetails->group_name; ?></span></h2>
      </div>
      <div class="rightInfo">
          <div class="leftgroupcreated"><p><?php echo $this->lang->line('created_on'); ?>:<strong> <?php echo $GroupDetails->created_date; ?></strong></p>
              <p><?php echo $this->lang->line('modified_on'); ?>:<strong> <?php echo $GroupDetails->last_modified_date; ?></strong></p></div>
          <div class="deletefroupbtn">
        <a class="btn btn-all" href="<?php echo base_url() ?>clinic/groups/deleteGroup/<?php echo $GroupDetails->id; ?>"><?php echo $this->lang->line('delete_group'); ?></a>
        </div>
      </div>

      <table id="patientResult" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
        <thead>
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
            foreach($GroupDetails->members as $info){  
           
            ?>
            <tr id="patient_<?php echo $info->patient_id; ?>">
            <td><span class="glyphicon glyphicon-user"></span> <?php echo $this->lang->line('title_patientss'); ?> </td>
            <td><?php echo $info->last_name; ?></td>
            <td><?php echo $info->first_name; ?></td>
            <td><?php echo $info->date_of_birth; ?></td>
            <td>
                
                    <div class="row action-btn-sec centeraction">
                        <div class="col-md-6">  <a href="javascript:void(0)" class="consultationHistory" data-patientID="<?php echo $info->patient_id; ?>"><span class="consultation-history-icon"></span><span class="linktext"><?php echo $this->lang->line('consultation_history'); ?></span></a></div>
                        <div class="col-md-6">  <a href="javascript:void(0)" id="billSummary" data-patientID="<?php echo $info->patient_id; ?>"><span class="billing-summary-icon"></span> <span class="linktext"><?php echo $this->lang->line('bill_sum'); ?></span></a></div>
                   
                    </div>
                    <div class="row action-btn-sec centeraction">
                        <div class="col-md-6"> <a href="javascript:void(0)" class="removefromgrp" data-grp ="<?php echo $GroupDetails->id; ?>"  data-pid="<?php echo $info->patient_id; ?>"><span class="removefromgroup"></span> <span class="linktext"><?php echo $this->lang->line('remove_from_group'); ?></span> </a></div>
                        <div class="col-md-6">  <a href="javascript:void(0)"><span class="message"></span> <span class="linktext"><?php echo $this->lang->line('message'); ?></span></a></div>
                    </div>
                
                  </td>
            </tr>
            <?php } ?>  
        </tbody>

      </table>
  
  
  </div>

  <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/patientgroups/singleGroup.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/patientgroups/groupPatientSummary.js"></script>
  <script src="<?php echo base_url();?>assets/js/mc_js/clinics/getPatientInfo.js"></script>
 