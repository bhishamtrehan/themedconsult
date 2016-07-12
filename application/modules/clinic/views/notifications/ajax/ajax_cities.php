<?php 
if(isset($city_list)){  ?>
		<select name="clinic_city" class="clinic_city form-control m-b-sm">
		<?php 
			if(count($city_list)>0){
				foreach($city_list as $city){ ?>
					<option value="<?php echo $city['city_id'];?>"><?php echo $city['city_name'];?></option>
		<?php   } 
			}	
		?>
		</select>
<?php  }
else {?>
	<input name="name" class="name"/>
<?php }  ?>
