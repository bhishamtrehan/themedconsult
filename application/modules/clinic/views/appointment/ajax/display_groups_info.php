<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
    <?php echo $this->lang->line('patient_group');  ?>  
  </h4>
</div>
<div class="modal-body">

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
  <!-- /wrapper --> 
  <!-- FOOTER -->
  <!-- FOOTER -->
  <script>var baseUrl = "<?php echo base_url(); ?>";</script>
  <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/appointment/group_info.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> 