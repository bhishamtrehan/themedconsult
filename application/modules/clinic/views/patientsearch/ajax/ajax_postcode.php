<?php 
if(isset($postcode_list)){  ?>
	<select name="clinic_postcode" class="clinic_postcode" required="required">
		<?php 
			if(count($postcode_list)>0){
				foreach($postcode_list as $postcode){ ?>
					<option value="<?php echo $postcode['suburb_id'];?>"><?php echo $postcode['postal_code'];?></option>
		<?php   } 
			}	
		?>
	</select>
<?php  }  ?>
