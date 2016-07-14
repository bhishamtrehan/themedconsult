<!DOCTYPE html>
<html>
  <head>

    <!-- Title -->
    <title><?php echo $title . $this->lang->line('title_universal'); ?> </title>
    <link rel="icon" href="<?= base_url() ?>assets/images/mid_favicon.png" type="image/gif">
   <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' >
    <meta charset="UTF-8">
    <meta name="description" content="Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Styles -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/drum.css"></link>
    <link href="<?php echo base_url(); ?>assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/jquery-confirm.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url(); ?>assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url(); ?>assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url(); ?>assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url(); ?>assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>

    <!-- Theme Styles -->
    <link href="<?php echo base_url(); ?>assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/hover.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>assets/plugins/3d-bold-navigation/js/modernizr.js"></script>

  </head>
  <body class="page-header-fixed compact-menu page-horizontal-bar">
    <?php
    $userdata = $this->session->all_userdata();
    $uName = $userdata['username'];

    $userId = $this->session->userdata['user_id'];
    $roleID = $this->session->userdata['user_role'];

    $notifications = $this->mc_constants->getNotifications($userId);
    $getNotifiyCount = $this->mc_constants->getNotificationsCount($userId);
    // echo "<pre>";
    // print_r($notifications);
    // die;
    ?>
    <input type="hidden" value="<?php echo base_url(); ?>" class="base_url">
    <div class="overlay"></div>
    <main class="page-content <?php echo ($this->uri->segment(2)=='dashboard' || $this->uri->segment(3)=='dashboard'|| $this->uri->segment(2)=='rosterView' || $this->uri->segment(3)=='rosterView')?'calendar_fixed_height':''; ?> content-wrap">
      <div class="navbar">
        <div class="navbar-inner container">
          <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
              <i class="fa fa-bars"></i>
            </a>
          </div>
          <div class="logo-box">
            <a href="<?php echo base_url(); ?>" class="logo-text"><img src="<?php echo base_url(); ?>assets/images/logo-inner.png" alt="" /></a>
          </div><!-- Logo Box -->
          <?php if (isset($uName) && $uName != '') { ?>
            <div class="topmenu-outer">
              <div class="top-menu">
                

                <ul class="nav navbar-nav navbar-right">
                  <li class="select_outer">
                    <i class="fa fa-globe"></i>
                    <select class="selectpicker">
                  <option>English</option>
                  <option>Spanish</option>
                 <option>Chinese</option>
                </select>
                    <i class="fa fa-caret-down"></i>
                  </li>
                  <!--
                  <li class="dropdown" id="notificationDropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                      <?php if (!empty($getNotifiyCount)) { ?>
                        <span id="notification_count"><?php echo $getNotifiyCount; ?></span>
                      <?php } ?>
                      <span class="notification"> <i class="fa fa-bell"></i> </span>
                    </a>
                    <ul class="dropdown-menu dropdown-list" role="menu">
                      <?php if (!empty($notifications)) { ?>
                        <?php foreach ($notifications as $notify) { ?>
                          <?php if ($roleID == 1 && $notify['recipient_id'] == $userId) { ?>
                            <li role="presentation">
                              <a href="javascript:void(0)" id="notifyId" class="notifyCls" data-notify-id="<?php echo $notify['id']; ?>"><?php echo sprintf($this->lang->line('hp_to_admin_app'), $notify['username']); ?></a>

                              <span class="time"><?php echo $notify['created']; ?></span>
                            </li>
                          <?php } ?>
                          <?php if ($roleID == 2 && $notify['recipient_id'] == $userId) { ?>
                            <li role="presentation">
                              <a href="javascript:void(0)" id="notifyId" class="notifyCls" data-notify-id="<?php echo $notify['id']; ?>">
                                <?php echo sprintf($this->lang->line('hp_to_clinic'), $notify['username']); ?>	
                              </a>
                              <span class="time"><?php echo $notify['created']; ?></span>
                            </li>
                          <?php } ?>
                        <?php } ?>
                        <li role="presentation">
                          <a href="javascript:void(0)" id="seeAllnotifyId" class="seeAllnotifyCls" data-user-id="<?php echo $userId; ?>"><?php echo $this->lang->line('view_notification'); ?></a>
                        </li>
                      <?php } else { ?>
                        <li role="presentation">
                          <span class="no-notifications"><?php echo $this->lang->line('no_notification'); ?></span>
                        </li>
                      <?php } ?>
                    </ul>
                  </li>-->


                 <!-- <li>
                    <div class="search_outer">
                      
                      <i class="fa fa-search my_search"></i>
                      <div class="search_div">
                        <input type="search"/>
                        <button> <i class="fa fa-search"></i></button>
                      </div>
                      
                    </div>
                  </li>-->
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                      <span class="user-name"><?php echo $this->lang->line('welcome'); ?>, <?php echo $uName; ?><i class="c_sandwich"></i></span>
<!--                      <img class="img-circle avatar" src="<?= base_url(); ?>assets/images/user.jpg" width="40" height="40" alt="">-->
                    </a>
                    <ul class="dropdown-menu dropdown-list" role="menu">

                      <li role="presentation"><a href="<?php echo base_url() ?>auth/logout"><i class="fa fa-sign-out m-r-xs"></i><?php echo $this->lang->line('Logout'); ?></a></li>
                    </ul>
                  </li>
                </ul><!-- Nav -->
              </div><!-- Top Menu -->
            </div>
          <?php } ?>
        </div>
      </div><!-- Navbar -->