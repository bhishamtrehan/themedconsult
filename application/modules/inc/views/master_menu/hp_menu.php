<div class="page-sidebar sidebar horizontal-bar">
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu">
            <li class="nav-heading"><span>Navigation</span></li>
            <li><a href="#"><span class="menu-icon icon-magnifier"></span><p><?= $this->lang->line('master_patient_search');?></p></a></li>
           <!-- <li><a href="<?php echo base_url();?>master/clinics"><span class="menu-icon fa fa-medkit"></span><p>Clinic Settings</p></a></li>
             <li><a href="#"><span class="menu-icon icon-settings"></span><p>Admin Settings</p></a></li> -->
            <li class="<?php echo ($this->uri->segment(2)=='company' || $this->uri->segment(3)=='view')?'active':''; ?>"><a href="<?php echo base_url();?>master/company/view"><span class="menu-icon icon-settings"></span><p><?= $this->lang->line('master_com_setting');?></p></a></li>
            <li class="<?php echo ($this->uri->segment(2)=='health_practitioner' || $this->uri->segment(3)=='health_practitioner')?'active':''; ?>"><a href="<?php echo base_url();?>master/health_practitioner"><span class="menu-icon fa fa-stethoscope"></span><p><?= $this->lang->line('master_health');?></p></a></li>
            <li class="<?php echo ($this->uri->segment(2)=='settings' || $this->uri->segment(3)=='settings')?'active':''; ?>"><a href="<?php echo base_url();?>master/settings"><span class="menu-icon fa fa-cog"></span><p><?= $this->lang->line('master_site_setting');?></p></a></li>
			
            <li class="<?php echo ($this->uri->segment(2)=='editProfile' || $this->uri->segment(3)=='editProfile')?'active':''; ?>"><a href="<?php echo base_url();?>master/editProfile"><span class="menu-icon fa fa-cogs"></span><p><?= $this->lang->line('master_acc_setting');?></p></a></li>
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->

<div class="page-inner">
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


<div class="container">
    <div class="alert alert-success" id="success" style="display:none;"> <?php echo $this->lang->line('added_successfully'); ?></div>
    <div class="alert alert-info" id="success_update" style="display:none;"> <?php echo $this->lang->line('up_successfully'); ?></div>
    <div class="alert alert-danger" id="success_delete" style="display:none;"><?php echo $this->lang->line('trash'); ?></div>
    <div class="alert alert-success" id="success_act" style="display:none;"><?php echo $this->lang->line('act_successfully'); ?></div>
    <div class="alert alert-danger" id="success_deact" style="display:none;"><?php echo $this->lang->line('deact_successfully'); ?></div>
</div>