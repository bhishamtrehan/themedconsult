<div>
<a href="javascript:void(0);" onclick="openModalFreq()" class="btn btn-primary" id="add_modal_f" data-name="Frequency"><?php echo $this->lang->line('add'); ?></a>
</div><br>
<table id="freq" class="display table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('frequency');?></th>
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
    	
    	<td><?php echo $value['frequency'];  ?></td>
    	<td>
            <?php $cTitle = $value['frequency'];

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
        	<a href="javascript:void(0);" onclick="editModal_f(<?php echo $value['ID']; ?>,<?php echo "'".$cTitle."'"; ?>, 'Frequency')" class="edit_text" data-id="<?php echo $value['ID']; ?>" data-name="Frequency" data-title="<?php echo $value['frequency'];  ?>"><?php echo $this->lang->line('edit'); ?> / </a> 
        	<a href="javascript:void(0);" onclick="deleteData_f(<?php echo $value['ID']; ?>,'Frequency')" class="delete_text" data-id="<?php echo $value['ID']; ?>" data-name="Frequency" ><?php echo $this->lang->line('delete'); ?></a>
    	</td>
    	
    </tr>
    <?php } }?>
    </tbody>
    
    <tfoot>
        <tr>
            <th><?php echo $this->lang->line('frequency');?></th>
            <th><?php echo $this->lang->line('actions'); ?></th>
        </tr>
    </tfoot>
</table>