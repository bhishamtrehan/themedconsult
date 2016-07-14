<title>
  <?php
  $fronttitile = ($clinic_disabled == 0) ? $this->lang->line('clinic_activate_titile') : $this->lang->line('clinic_disabled_titile');
  echo sprintf($this->lang->line('title_clinic_page'), $fronttitile) . $this->lang->line('title_universal');
  ?></title>
<body>

  <div id="main-wrapper" class="container ">
    <div class="row" id="rowContains">

      <div class="col-md-12 notif_wrapper">
      <?php if($this->session->flashdata('added_message_group')) { ?>
          <div class="success_message"> <span><?php echo $this->session->flashdata('added_message_group');?></span></div>
      <?php } ?>
        <div class="left_panel">
          <ul class="menu">
            <li id="newg_li"><a href="javascript:void(0)" id="newGroup"><i class="fa fa-user-plus"></i><?php echo $this->lang->line('new_groups'); ?></a></li>
            <li id="trahsli"><a href="<?php echo base_url() ?>clinic/groups/recycle" id="recycleGroups"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('recycle'); ?></a></li>
             <li class="dropdown active" id="groupslist_li">
                <a href="<?php echo base_url() ?>clinic/groups" id="groupList" ><i class="fa fa-users"></i><?php echo $this->lang->line('groups'); ?></a>
                <ul class=" forAnimate" role="menu">
                <?php if(!empty($group_list)){ ?>
                  <?php foreach($group_list as $list) { ?>
                    <li><a href="javascript:void(0)" style="color:#000;" data-groupid="<?php echo $list['id']; ?>" class="grpId"><?php echo $list['group_name']; ?></a></li>
                  <?php } } else {?>
                    <li><a href="javascript:void(0)"><?php echo $this->lang->line('no_grp'); ?></a></li>
                    <?php } ?>
                </ul>
            </li>   
          </ul>
        </div>
        <div class="panel panel-white dashboardWrap">
            
          
<div class="scrolltablemobile">
             <table id="groupListInfo" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('group_picture'); ?></th>
                  <th><?php echo $this->lang->line('group_name'); ?></th>
                  <th><?php echo $this->lang->line('action'); ?></th>
                </tr>
              </thead>
              <tbody>
                  <?php
                  foreach($group_list_recycle as $list){   
                  ?>
                  <tr>
                  <td><img src="<?php echo base_url();?>assets/images/notification_image.bmp"></td>
                  <td><?php echo $list['group_name']; ?></td>
                  <td>
<span class="action-btn-sec centeraction"><a href="<?php echo base_url() ?>clinic/groups/restore/<?php echo $list['id']; ?>" style="color:#000;" class="grpId"><span class="restore-icon"></span><span class="linktext"><?php echo $this->lang->line('restore'); ?></span></a></span>

                 </td>
                  </tr>
                  <?php } ?>  
              </tbody>

            </table>
</div>

            <!-- /container --> 
          <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT --> 
        </div>
      </div>
    </div>
  </div>
 
  <!-- /wrapper --> 
  <!-- FOOTER -->
  <!-- FOOTER -->
  <script>var baseUrl = "<?php echo base_url(); ?>";</script>
  <?php $this->load->view('inc/footer'); ?>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/patientgroups/groupDetails.js"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> 