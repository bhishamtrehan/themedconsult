<div> 
  <a href="javascript:void(0);" class="btn btn-primary" id="add_modal" onclick="openModal()" data-name="Speciality"><?php echo $this->lang->line('add'); ?></a> 
  </div> <br>
  <table id="specials" class="display table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('speciality');?></th>
            <th><?php echo $this->lang->line('actions'); ?></th>
        </tr>
    </thead>
    
    <tbody>
    <?php if(empty($output)) {?>
    	<!-- <td></td>
    	<td>No data to show</td>
    	<td></td> -->
    <?php }else{ ?>
    <?php foreach ($output as $value) {?>
    <tr>
    	
    	<td><?php echo $value['speciality'];  ?></td>
    	<td>
            <?php $cTitle = $value['speciality'];

                $quotes_detect =  preg_match('/"/', $cTitle);
                if($quotes_detect == 1)
                {
                    $cTitle = str_replace(array("'", "\""), "", htmlspecialchars($cTitle));
                }
                else
                {
                    $cTitle = str_replace("'","\\'", $cTitle);
                }
            ?>
        	<a href="javascript:void(0);" class="edit_text" onclick="editModal(<?php echo $value['ID']; ?>,<?php echo "'".$cTitle."'"; ?>, 'Speciality')" data-id="<?php echo $value['ID']; ?>" data-name="Speciality" data-title="<?php echo $value['speciality'];  ?>"><?php echo $this->lang->line('edit'); ?> / </a> 
        	<a href="javascript:void(0);" onclick="deleteData(<?php echo $value['ID']; ?>,'Speciality')" class="delete_text" data-id="<?php echo $value['ID']; ?>" data-name="Speciality" ><?php echo $this->lang->line('delete'); ?></a>
    	</td>
    	
    </tr>
    <?php } }?>
    </tbody>
    
    <tfoot>
        <tr>
            <th><?php echo $this->lang->line('speciality');?></th>
            <th><?php echo $this->lang->line('actions'); ?></th>
        </tr>
    </tfoot>
</table>