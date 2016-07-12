<div>
<a href="javascript:void(0);" onclick="openModalConsult()" class="btn btn-primary" id="add_modal_c" data-name="Consultation"><?php echo $this->lang->line('add'); ?></a>
</div><br>
<table id="cons" class="display table" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('consultation');?></th>
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
    	
    	<td><?php echo $value['consultation'];  ?></td>
    	<td>
            <?php $cTitle = $value['consultation'];

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
        	<a href="javascript:void(0);" onclick="editModal_c(<?php echo $value['ID']; ?>,<?php echo "'".$cTitle."'"; ?>, 'Consultation')" class="edit_text" data-id="<?php echo $value['ID']; ?>" data-name="Consultation" data-title="<?php echo $value['consultation'];  ?>"><?php echo $this->lang->line('edit'); ?> / </a> 
        	<a href="javascript:void(0);" onclick="deleteData_c(<?php echo $value['ID']; ?>,'Consultation')" class="delete_text" data-id="<?php echo $value['ID']; ?>" data-name="Consultation" ><?php echo $this->lang->line('delete'); ?></a>
    	</td>
    	
    </tr>
    <?php } }?>
    </tbody>
    
    <tfoot>
        <tr>
            <th><?php echo $this->lang->line('consultation');?></th>
            <th><?php echo $this->lang->line('actions'); ?></th>
        </tr>
    </tfoot>
</table>