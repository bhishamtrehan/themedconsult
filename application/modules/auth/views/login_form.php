<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'class' => 'form-control',
	'value' => set_value('login'),
	'placeholder' => $this->lang->line('title_login'),
	'maxlength'	=> 80,
	'size'	=> 30,
    'autocomplete' => 'off'
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'class' => 'form-control',
	'placeholder' => $this->lang->line('password'),
	'size'	=> 30,
    'autocomplete' => 'off'
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>

<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-3 center login-container">
                    <div class="login-icon"><!--<i class="fa fa-sign-in"></i>-->
                    <img alt="" src="<?php echo base_url(); ?>/assets/images/logo-inner.png">
                    </div>
					
                    <div class="login-box">
                     <?php
                    
                      if($this->session->flashdata('display_message')!='') { ?>
					   <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
						<?php }?>    
                        <span class="login_title"><p class="text-center m-t-md">
                        <?php echo sprintf($this->lang->line('login_heading'), $account );?>
                        </p></span>
                        <?php echo form_open(base_url().'auth/login',array('class' => 'm-t-md')); ?>
                            <div class="form-group">
                                <?php echo form_input($login,'required'); ?>
                                <span class="login_icon">
								<i class="fa fa-user"></i>
								</span>
								<?php echo form_hidden('roleId', $roleId); ?>
                            </div>
                            <span class="form_error"><?php echo form_error('login'); ?></span>
                            <div class="form-group">
                                <?php echo form_password($password); ?>
                                <span class="login_icon">
<i class="fa fa-lock"></i>

</span>
                            </div>
                           <span class="form_error"><?php echo form_error('password'); ?></span>
                            <?php if ($show_captcha) {
							if ($use_recaptcha) { ?>
								<div class="captcha_main_container">
								<tr>
									<td colspan="2">
										<div id="recaptcha_image"></div>
									</td>
									<td>
										
									</td>
								</tr>
								<tr>
									
									<div class="captcha_field_container"><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /><a href="javascript:Recaptcha.reload()"><i class="fa fa-refresh captcha_referesh"></i></a></div>
									<span class="form_error"><?php echo form_error('recaptcha_response_field'); ?></span>
									<?php echo $recaptcha_html; ?>
								</tr>
								</div>
								<?php } else { ?>
								<tr>
									<td colspan="3">
										<p><?php echo $this->lang->line('enter_captcha'); ?></p>
										<?php echo $captcha_html; ?>
									</td>
								</tr>
								<tr>
									<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
									<td><?php echo form_input($captcha); ?></td>
									<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
								</tr>
								<?php }
								} ?>
							<label class="form-group">
								<?php echo form_checkbox($remember); ?>
								<span><?php echo $this->lang->line('remember_me');?></span>
							</label>
                            <button type="submit" class="btn btn-success btn-block"><?php echo $this->lang->line('login');?></button>
                        <?php echo form_close(); ?>
						 <a href="<?php echo base_url(); ?>health_practitioner/add" class="btn btn-default btn-block m-t-md"><?php echo $this->lang->line('create_account');?></a>
                            <a href="<?php echo base_url();?>auth/forgot_password" class="display-block text-center m-t-md text-sm"><?php echo $this->lang->line('forgot_password');?></a>
                          
                           
                        </form>
                        <p class="text-center m-t-xs text-sm"><?php //echo $this->lang->line('copyright');?></p>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- Page Inner -->
</main><!-- Page Content -->
