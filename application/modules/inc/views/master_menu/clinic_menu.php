<div class="page-sidebar sidebar horizontal-bar">
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu">
            <li class="nav-heading"><span>Navigation</span></li>
			<li class="<?php echo ($this->uri->segment(2)=='dashboard' || $this->uri->segment(3)=='dashboard')?'active':''; ?>"><a href="<?php echo base_url();?>clinic/dashboard"><span class="menu-icon icon-calendar"></span><p><?php  echo $this->lang->line('appointment_calender'); ?></p></a></li>
		
            <li class="<?php echo ($this->uri->segment(2)=='patientsearch' || $this->uri->segment(3)=='patientsearch')?'active':''; ?>"><a href="<?php echo base_url();?>clinic/patientsearch"><span class="menu-icon icon-magnifier"></span><p><?= $this->lang->line('master_patient_search');?></p></a></li>
			
			 <li class="<?php echo ($this->uri->segment(2)=='healthprofessional' || $this->uri->segment(3)=='healthprofessional')?'active':''; ?>"><a href="<?php echo base_url();?>clinic/healthprofessional"><span class="menu-icon fa fa-user-md"></span><p><?= $this->lang->line('health_professionals');?></p></a></li>
			  <li class="<?php echo ($this->uri->segment(2)=='company' || $this->uri->segment(3)=='view')?'active':''; ?>"><a href="#"><span class="menu-icon fa fa-money"></span><p><?= $this->lang->line('financial_summary');?></p></a></li>
		    <li class="<?php echo ($this->uri->segment(2)=='notifications' || $this->uri->segment(3)=='notifications')?'active':''; ?>"><a href="<?php echo base_url();?>clinic/notifications"><span class="menu-icon fa fa-bell"></span><p><?= $this->lang->line('notifications');?></p></a></li>
			
			<li class="<?php echo ($this->uri->segment(2)=='groups' || $this->uri->segment(3)=='groups')?'active':''; ?>"><a href="<?php echo base_url();?>clinic/groups"><span class="menu-icon fa fa-users"></span><p><?= $this->lang->line('patients_groups');?></p></a></li>
          <!-- <li class="<?php echo ($this->uri->segment(2)=='dashboard' || $this->uri->segment(3)=='dashboard')?'active':''; ?>"><a href="<?php echo base_url();?>clinic/dashboard"><span class="menu-icon fa fa-medkit"></span><p><?= $this->lang->line('clinic_menu_dashboard');?></p></a></li>-->
           <li class="<?php echo ($this->uri->segment(1)=='clinic' && $this->uri->segment(2)=='')?'active':''; ?>"><a href="<?php echo base_url();?>clinic"><span class="menu-icon fa fa-medkit"></span><p><?= $this->lang->line('clinic_menu_setting');?></p></a></li>
             <!-- <li><a href="#"><span class="menu-icon icon-settings"></span><p>Admin Settings</p></a></li> 
            <li class="<?php echo ($this->uri->segment(2)=='company' || $this->uri->segment(3)=='view')?'active':''; ?>"><a href="#"><span class="menu-icon icon-settings"></span><p>Company Settings</p></a></li>
            <li class="<?php echo ($this->uri->segment(2)=='health_practitioner' || $this->uri->segment(3)=='health_practitioner')?'active':''; ?>"><a href="<?php echo base_url();?>master/health_practitioner"><span class="menu-icon fa fa-stethoscope"></span><p>Health Practioner</p></a></li>
            <li class="<?php echo ($this->uri->segment(2)=='settings' || $this->uri->segment(3)=='settings')?'active':''; ?>"><a href="#"><span class="menu-icon fa fa-cog"></span><p>Site Settings</p></a></li>-->
			
            <!--<li class="<?php echo ($this->uri->segment(2)=='editProfile' || $this->uri->segment(3)=='editProfile')?'active':''; ?>"><a href="#"><span class="menu-icon fa fa-cogs"></span><p><?= $this->lang->line('clinic_acc_setting');?></p></a></li>-->
			
			<li class="<?php echo ($this->uri->segment(2)=='billingcodes' || $this->uri->segment(3)=='billingcodes')?'active':''; ?>"><a href="<?php echo base_url();?>clinic/billingcodes"><span class="menu-icon fa fa-file-text"></span><p><?= $this->lang->line('fee_schedule');?></p></a></li>
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->
<?php if($this->uri->segment(2)=='dashboard' || $this->uri->segment(3)=='dashboard' ||$this->uri->segment(2)=='rosterView' || $this->uri->segment(3)=='dashboard') {
		$class="fixed";
	}else{
		$class="";
		} ?>
<div class="page-inner <?php echo $class; ?>">

<?php if($this->uri->segment(2)=='notifications' || $this->uri->segment(3)=='notifications') {  } else{?>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
		<?php if(isset($breadcrumb_label)){ ?>
        <li class="">
			<?php if(isset($breadcrumb_url) && $breadcrumb_url != ''){ ?>
				<a href="<?php echo $breadcrumb_url; ?>">
			<?php } ?>
				<?php echo $breadcrumb_label; ?>
			<?php if(isset($breadcrumb_url) && $breadcrumb_url != ''){ ?>
				</a>
			<?php } ?>
		
		</li>
		
		
		<?php } ?>
		<?php if(isset($breadcrumb_label1)){ ?>
        <li class="">
			<?php if(isset($breadcrumb_url1) && $breadcrumb_url1 != ''){ ?>
				<a href="<?php echo $breadcrumb_url1; ?>">
			<?php } ?>	
			<?php echo $breadcrumb_label1; 
				if(isset($breadcrumb_url1) && $breadcrumb_url1 != ''){ ?>
				</a>
			<?php } ?>
		</li>
		<?php } ?>
    </ol>
</div>
<?php }?>
<div class="container">
    <div class="alert alert-success" id="success" style="display:none;"> <?php echo $this->lang->line('added_successfully'); ?></div>
    <div class="alert alert-info" id="success_update" style="display:none;"> <?php echo $this->lang->line('up_successfully'); ?></div>
    <div class="alert alert-danger" id="success_delete" style="display:none;"><?php echo $this->lang->line('trash'); ?></div>
    <div class="alert alert-success" id="success_act" style="display:none;"><?php echo $this->lang->line('act_successfully'); ?></div>
    <div class="alert alert-danger" id="success_deact" style="display:none;"><?php echo $this->lang->line('deact_successfully'); ?></div>
</div>