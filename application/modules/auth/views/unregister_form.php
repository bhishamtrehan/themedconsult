<title><?php echo $this->lang->line('title_forgot').$this->lang->line('title_universal');?></title>
<?php
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
?>

<div class="wrapper full-page-wrapper page-auth page-login text-center">
		<div class="inner-page">
			<div class="logo">
				<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" alt="" /></a>
			</div>
			<div class="login-box center-block"><?php echo form_open($this->uri->uri_string(),array('class' => 'form-horizontal')); ?>
				<span class="form_error"></span>
					<p class="title"><?php echo  sprintf($this->lang->line('password_unregister'), $password['id']);?></p>
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
							<?php echo form_password($password); ?>
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
							</div>
							<span class="form_error">?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></span>
						</div>
					</div>
					
					<?php echo form_submit('cancel', $this->lang->line('delete_account'),"class='btn btn-custom-primary btn-lg btn-block btn-auth'"); ?>
                    <!--<i class="fa fa-arrow-circle-o-right"></i>-->
				<?php echo form_close(); ?>

				<div class="links">
					<p><?php echo anchor('/auth/login/', $this->lang->line('sign_in')); ?></p>
				</div>
			</div>
		</div>
	</div>

