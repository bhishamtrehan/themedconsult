<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php   if(count($return_result)>0){  
					echo $return_result['clinic_name']; 
				}else{
					echo $this->lang->line('invalid_clinic'); 	
				}
		?>	
	</h4>
</div>
<div class="modal-body">
<?php if(count($return_result)>0){?>  
    <div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('clinic_name');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['clinic_name']; ?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('clinic_admin_name');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['clinic_admin_contact_name']; ?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('cinic_person_email_address');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['clinic_contact_email_address']; ?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('username');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['username']; ?>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('clinic_official_email_address');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['email']; ?>
		</div>
	</div>   
	  
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('street_address');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['street_address']; ?>
		</div>
	</div>   
	<?php if($return_result['is_suburb'] == '1') {?>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('suburb_state_country');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['suburb'].'/'.$return_result['state'].'/'.$return_result['country']; ?>
		</div>
	</div>
	<?php } else {?>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('city_state_country');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['city'].'/'.$return_result['state'].'/'.$return_result['country']; ?>
		</div>
	</div>
	<?php }?>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('postcode');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['postcode']; ?>
		</div>
	</div>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('clinic_telephone');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['telephone']; ?>
		</div>
	</div>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('mobile_number');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['mobile_no']; ?>
		</div>
	</div>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('fax_number');?>:</label>
		<div class="col-sm-9">
		     <?php echo $return_result['fax_number']; ?>
		</div>
	</div>

<?php }else{
	      echo $this->lang->line('invalid_clinic'); 	
      }
	?>	
</div>
