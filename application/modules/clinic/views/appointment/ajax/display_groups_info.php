<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
    <?php echo $this->lang->line('patient_group');  ?>  
  </h4>
</div>
<div class="modal-body">
<div class="patientgrouptabsec">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo $this->lang->line('existing_group');  ?> </a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $this->lang->line('add_to_new');  ?></a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    <table id="groupListInfo" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('group_id'); ?></th>
          <th><?php echo $this->lang->line('group_picture'); ?></th>
          <th><?php echo $this->lang->line('group_name'); ?></th>
        </tr>
      </thead>
    <tbody>
      <?php
      $k = 0;
      foreach($group_list as $list){

      ?>
      <tr>
        <td><input type="checkbox" name="selectGroup" data-app = "<?php echo $appntID; ?>" data-rel="<?php echo $list['id']; ?>" class="selGrp" <?php echo (in_array($list['id'], $paitents_enrolled) ? 'checked' : '');?>/></td>
        <td><img src="<?php echo base_url();?>assets/images/notification_image.bmp"></td>
        <td><?php echo $list['group_name']; ?></td>

      </tr>
      <?php $k++; } ?>  
      </tbody>

      </table>


    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
    
    <?php echo form_open(base_url().'clinic/groups/addgroupfromcalendar',array('class' => 'form-horizontal form_health','id' => 'newGroupFromCalendar')); ?>
       <div class="popupgrouptablael">
          <label><?php echo $this->lang->line('grp_name'); ?></label>
          
          <input type="text" name="grpName" class="form-control" placeholder="Group Name" id ="grpName">
        </div>
        <input type="hidden" name="PatientId" value="<?php echo $patient_details_group[0]['patient_id']; ?>">
       <div class="to_add_patient">
         <table width="100%" id="table" cellspacing="0" cellpadding="0" class="display table table-sorting table-hover table-bordered table-responsive datatable dataTable no-footer">
              <tbody>
                <tr>
                  <th><?php echo $this->lang->line('patient_name'); ?></th>
                  <th><?php echo $this->lang->line('patient_surname'); ?> </th>
                  <th><?php echo $this->lang->line('patient_related_dob'); ?></th>
                </tr>
                <tr>
                  <td class="first_name"> <?php echo $patient_details_group[0]['first_name']; ?> </td>
                  <td class="lname"> <?php echo $patient_details_group[0]['last_name']; ?> </td>
                  <td class="date_birth"> <?php echo $patient_details_group[0]['date_of_birth']; ?> </td>
                  
                </tr>
              </tbody>
          </table>
       </div>
       <input type="submit" class="btn btn-all" value="Add Group" id="submitnewgroup">
       <?php echo form_close();?>
    </div>

  </div>

</div>


</div>
  <!-- /wrapper --> 
  <!-- FOOTER -->
  <!-- FOOTER -->
  <script>var baseUrl = "<?php echo base_url(); ?>";</script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script> 
  <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/appointment/group_info.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap-datepicker.js"></script>
  
