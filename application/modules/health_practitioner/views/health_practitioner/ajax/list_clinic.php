<?php
foreach($clinics as $clinic){ ?>
	<label><?php echo $clinic['clinic_name']; ?></label><input type="radio" class="clinic_loc" name="clinic_loc" value="<?php echo $clinic['clinic_id']; ?>" />
<?php }