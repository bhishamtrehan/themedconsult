		<?php if(!empty($output)){ ?>
		<?php foreach ($output as $value) {?>
		<?php 
		if (0 == $i % 2)
		{
			$class ="odd";
		}
		else
		{
			$class ="even";
		}
		$i++; 
		?>
	    <tr class="<?php echo $class; ?>">
	       <td><?php echo $value['lname']; ?></td> 	
	       <td><?php echo $value['fname']; ?></td> 	
	       <td><?php echo $value['email']; ?></td> 	
	       <td></td> 	
	       <td><?php if($value['activated'] == 1){ echo "Verified";}else{ echo "Non Verified"; } ?></td>
	       
	       <td>
		       <a href=""><?php echo $this->lang->line('edit'); ?></a>
		       <?php if($value['activated'] == 1){?>
		       <a href="javascript:void(0);" onclick="deactivate(<?php echo $value['id'];?>, 0, <?php echo $c_id; ?>)" ><?php echo $this->lang->line('deactivate'); ?></a>
		       <?php }else{ ?>
		       <a href="javascript:void(0);" onclick="activate(<?php echo $value['id'];?>, 1, <?php echo $c_id; ?>)"><?php echo $this->lang->line('active'); ?></a>
		       <?php } ?>
		       <a href="javascript:void(0);" onclick="deleteadmin(<?php echo $value['id'];?>,2, <?php echo $c_id; ?> );"><?php echo $this->lang->line('delete'); ?></a>
	       </td> 	
	    </tr>
        <?php } } ?>

