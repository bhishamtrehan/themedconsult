<div>
<a href="javascript:void(0);" onclick="openModalRoute()" class="btn btn-primary" id="add_modal_r" data-name="Route"><?php echo $this->lang->line('add'); ?></a>
</div><br>
<table id="routes" class="display table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('route');?></th>
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
    	
    	<td><?php echo $value['route'];  ?></td>
    	<td>
            <?php $cTitle = $value['route'];

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
        	<a href="javascript:void(0);" onclick="editModal_r(<?php echo $value['ID']; ?>,<?php echo "'".$cTitle."'"; ?>, 'Route')" class="edit_text" data-id="<?php echo $value['ID']; ?>" data-name="Route" data-title="<?php echo $value['route'];  ?>"><?php echo $this->lang->line('edit'); ?> / </a> 
        	<a href="javascript:void(0);" onclick="deleteData_l(<?php echo $value['ID']; ?>,'Route')" class="delete_text" data-id="<?php echo $value['ID']; ?>" data-name="Route" ><?php echo $this->lang->line('delete'); ?></a>
    	</td>
    	
    </tr>
    <?php } }?>
    </tbody>
    
    <tfoot>
        <tr>
            <th><?php echo $this->lang->line('route');?></th>
            <th><?php echo $this->lang->line('actions'); ?></th>
        </tr>
    </tfoot>
</table>