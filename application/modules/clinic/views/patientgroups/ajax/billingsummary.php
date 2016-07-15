<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 

			if(count($billinghistory)>0){  
					
					echo $this->lang->line('billing_summery');
				}else{ 
					echo 'No Information found'; 	
				}
		?>	
	</h4>
</div>
<div class="modal-body ">
<div class="panel-primary">

	  	<table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
			<tbody>
			<tr>
				<th><?php echo $this->lang->line('billing_name'); ?></th>
				<th><?php echo $this->lang->line('billing_item_code'); ?></th>
				<th><?php echo $this->lang->line('duration'); ?></th>
				<th><?php echo $this->lang->line('price'); ?></th>
				<th><?php echo $this->lang->line('gst'); ?></th>
				</tr>
			<?php
			if(!empty($billinghistory))
			{
			foreach($billinghistory as $billDetail){ 
			$lang === 'french' ? 'oui' : 'yes'
				?>
				<tr>
					
					<td class="withborder second"><?php echo $billDetail['description']; ?></td>
					<td class="withborder"><?php echo $billDetail['billing_codes_id']; ?></td>
					<td class="withborder"><?php echo $billDetail['duration']; ?></td>
					<td class="withborder"><?php echo $billDetail['price']; ?></td>
					<td class="withborder"><?php echo $billDetail['gst']; ?></td>
					
				</tr>
			<?php } }?>
	</div>
	</div>
    </div>
</div>

