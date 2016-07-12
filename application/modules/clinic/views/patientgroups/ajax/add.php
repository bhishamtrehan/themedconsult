        <div class="panel panel-white">
          <div class="panel-body">
            <?php echo form_open(base_url().'clinic/groups',array('class' => 'form-horizontal form_health','id' => 'addGroupForm')); ?>
            <div role="tabpanel" class="tab-pane active" id="home">
              <input type="hidden" name="grp_admin_id" value="<?php echo $user_id; ?>" id="current_user">
              <div class="row">
              <div class="col-xs-12 col-sm-12">
              <div class="addgroupdesign">
                <label><?php echo $this->lang->line('grp_name'); ?></label>
                <input type="text" name="grpName" class="form-control" placeholder="Group Name" id ="grpName">
              </div>
              </div>
                  </div>
            <!-- /container --> 
          </div>
          
          <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
          
          <table id="patientResult" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('select'); ?></th>
                <th><?php echo $this->lang->line('patient_picture'); ?></th>
                <th><?php echo $this->lang->line('surname'); ?></th>
                <th><?php echo $this->lang->line('first_name'); ?></th>
                <th><?php echo $this->lang->line('dob'); ?></th>
              </tr>
            </thead>
            <tbody>
                <?php
                if(isset($patient_Details)){
                foreach($patient_Details as $patient_Detail){   
                ?>
                <tr>
                <td><input type="checkbox" name="selectedUser[]" value="<?php echo $patient_Detail->patient_id; ?>"></td>
                <td><span class="glyphicon glyphicon-user"></span> Patient </td>
                <td><?php echo $patient_Detail->last_name; ?></td>
                <td><?php echo $patient_Detail->first_name; ?></td>
                <td><?php echo $patient_Detail->date_of_birth; ?></td>
                </tr>
                <?php } } else { echo $this->lang->line('not_found'); } ?>  
            </tbody>
          </table>
          <button class="btn btn-all okmedic" name="submit" type="submit" value="submit"><?php echo $this->lang->line('save_group'); ?></button>
          <?php echo form_close();?>
        </div>
        

<script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/patientgroups/customgroups.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> 