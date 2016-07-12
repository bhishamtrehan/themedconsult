<?php

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'class' => 'form-control',
	'placeholder' => 'Username',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-3 center login-container">
                    <div class="login-icon"><!--<i class="fa fa-key"></i>--><img src="http://192.168.25.202/themedconsult/assets/images/logo-inner.png" alt=""></div>
                    <div class="login-box forgot_box">
                        <!-- <a href="" class="logo-name text-lg text-center"><img src="assets/images/logo.png" alt="" /></a> -->
                        <span class="login_title"><p class="text-center m-t-md"><?php echo $this->lang->line('forgot-title'); ?></p></span>
                        <?php if ($this->session->flashdata('display_message') != '') { ?>
			                <div class="success_message" style="display:block;"><span><?php echo $this->session->flashdata('display_message'); ?></span></div>
			            <?php } ?>
                        <?php echo form_open($this->uri->uri_string(), array('class' => 'm-t-md')); ?>
                            <div class="form-group">
                                <?php echo form_input($login); ?><span class="login_icon">
<i class="fa fa-user"></i>
</span>
                            </div>
                             <span class="form_error"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?></span>
                             
                             <div class="form-group btn_submit">
                             <?php echo form_submit('reset', $this->lang->line('submit'), "class='btn btn-primary btn-block'"); ?></div>
                             <div class="form-group bttn_back">
                            <a href="<?php echo base_url();?>auth/login" class="btn btn-default btn-block m-t-md"><i class="fa fa-long-arrow-left"></i>Back</a></div>
                            

                        <?php //echo form_close(); ?>
                        <!--<p class="text-center m-t-xs text-sm">2016 &copy; MedConsult.</p>-->
                    </div></div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- Page Inner -->
</main><!-- Page Content -->