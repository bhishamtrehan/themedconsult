<title><?php echo $this->lang->line('title_reset_password').$this->lang->line('title_universal');?></title>
<?php
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
        'placeholder' => $this->lang->line('enter_new_password'),
	'size'	=> 30,
        'class' => 'form-control',
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
        'placeholder' => $this->lang->line('confirm_new_password'),	
        'size' 	=> 30,
        'class' => 'form-control',
);
?>


<div class="wrapper full-page-wrapper page-auth page-login text-center">
    <div class="inner-page">
        <div class="logo">
            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo.png" alt="" /></a>
        </div>
        <div class="login-box center-block">
            <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
            <p class="title"><?php echo $this->lang->line('title_reset_password'); ?></p>
            <?php if ($this->session->flashdata('display_message') != '') { ?>
                <div class="success_message" style="display:block;"><span><?php echo $this->session->flashdata('display_message'); ?></span></div>
            <?php } ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group"><?php echo form_password($new_password); ?><span class="input-group-addon"><i class="fa fa-lock"></i></span></div>
                             <span class="form_error"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group"><?php echo form_password($confirm_new_password); ?><span class="input-group-addon"><i class="fa fa-lock"></i></span></div>
                             <span class="form_error"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></span>
                        </div>
                    </div>


                    <!--<i class="fa fa-arrow-circle-o-right"></i>-->
            <?php echo form_submit('reset', $this->lang->line('reset_password_btn'), "class='btn btn-custom-primary btn-lg btn-block btn-auth'"); ?>
            <?php echo form_close(); ?>

            <div class="links">
                <p><?php echo anchor('/auth/login/', $this->lang->line('sign_in')); ?></p>
            </div>
        </div>
    </div>
</div>