<title>
  <?php
  $fronttitile = ($clinic_disabled == 0) ? $this->lang->line('clinic_activate_titile') : $this->lang->line('clinic_disabled_titile');
  echo sprintf($this->lang->line('title_clinic_page'), $fronttitile) . $this->lang->line('title_universal');
  ?></title>
<body>
  <!--<div class="custom_title">
                              <div class="container">
                               <h3><?php
  // if(isset($title)){
  //     echo $title;
  // }else{
  //     echo $this->lang->line('home');
  // }
  ?>
                                  Notifications
                              </h3>
                              </div>
                              </div>	-->
  <div id="main-wrapper" class="container">
    <div class="row">

      <div class="col-md-12 notif_wrapper">
        <div class="left_panel">
          <ul>
                <li><a href="<?php echo base_url(); ?>clinic/notifications" id="archive"><i class="fa fa-folder-open"></i>Notifications</a></li>
            <li><a href="<?php echo base_url(); ?>clinic/notifications/deleted_notification" id="recycle"><i class="fa fa-recycle"></i>Recycle</a></li>
          </ul>
        </div>
        <div class="panel panel-white">
          <div class="panel-body">
            <ul class="n_listOuter">
            <?php
            $userdata = $this->session->all_userdata();
            $uName = $userdata['username'];

            $userId = $this->session->userdata['user_id'];
            $roleID = $this->session->userdata['user_role'];

            $notifications = $this->mc_constants->archiveNotifications($userId);
            $getNotifiyCount = $this->mc_constants->archiveNotifications($userId);
            //echo "<pre>";
            //print_r($notifications);
            //die;
            ?>

            <?php if (!empty($notifications)) { ?>
              <?php foreach ($notifications as $notify) { ?>
                <?php if ($roleID == 1 && $notify['recipient_id'] == $userId) { ?>
             <li id="<?php echo $notify['id']; ?>">
                    <span class="n_icon">
                      <img src=""/>
                    </span>
                    <h5><a href="">Walk In Appointment</a></h5>
                    <p class="n_desc">Patient Lorra Andrew has confirmed the appointment.</p>
                     <span class="time"><?php echo $notify['created']; ?></span>

                  </li> -->
          <a href="javascript:void(0)" id="notifyId" class="notifyCls" data-notify-id="<?php echo $notify['id']; ?>"><?php echo sprintf($this->lang->line('hp_to_admin_app'), $notify['username']); ?></a>

                  <span class="time"><?php echo $notify['created']; ?></span>

                <?php } ?>
                <?php if ($roleID == 2 && $notify['recipient_id'] == $userId) { ?>
                             
                  <li id="<?php echo $notify['id']; ?>">
                    <span class="n_icon">
                      <img src="<?php echo base_url(); ?>assets/images/notification_image.bmp"/>
                    </span>
                    <h5><a href="">Walk In Appointment</a></h5>
                    <p class="n_desc"> <?php  echo sprintf($this->lang->line('hp_to_clinic'), $notify['username']); ?></p>
                     <span class="time"><?php echo $notify['created']; ?></span>
                     <!--<ul class="n_action">
                        <li><a href="javascript:void(0)" data-id="<?php echo $notify['id']; ?>" class="archive"> <i class="fa fa-folder-open"></i>Archive</a></li>
                        <!-- <li><a href="javascript:void(0)" data-id="<?php echo $notify['id']; ?>" class="delete"><i class="fa fa-trash"></i>Delete</a></li>
                     </ul>-->
<!--                  <a href="javascript:void(0)" id="notifyId" class="notifyCls" data-notify-id="<?php echo $notify['id']; ?>">
                    <?php// echo sprintf($this->lang->line('hp_to_clinic'), $notify['username']); ?>	
                 <!-- </a>
                  <span class="time"><?php //echo $notify['created']; ?></span>-->
                  </li>
                <?php } ?>
              <?php } ?>

             <!-- <a href="javascript:void(0)" id="seeAllnotifyId" class="seeAllnotifyCls" data-user-id="<?php echo $userId; ?>"><?php echo $this->lang->line('view_notification'); ?></a> -->

            <?php } else { ?>
<div class="alert alert-danger c_alert" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <?php echo $this->lang->line('no_notification'); ?>       </div>
<!--              <span class="no-notifications"></span>-->

            <?php } ?>

            </ul>
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
  <script>var baseUrl = "<?php echo base_url(); ?>";</script>
  <?php $this->load->view('inc/footer'); ?>
  <script src="<?php echo base_url(); ?>assets/js/mc_js/admin/clinic/view_clinics.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/notifications/notifications.js"></script>