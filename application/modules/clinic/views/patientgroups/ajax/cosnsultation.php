<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 

if(count($consult_Details)>0){  
					
					echo $this->lang->line('consultation_history');
				}else{ 
					echo 'No Information found'; 	
				}
		?>	
	</h4>
</div>
<div class="modal-body ">
<div class="panel-primary">
<?php //echo "<pre>"; print_r($consult_Details); ?>
	  	<table cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
			<tbody>
			<tr>
				<th><?php echo $this->lang->line('health_professional'); ?></th>
				<th><?php echo $this->lang->line('speciality'); ?></th>
				<th><?php echo $this->lang->line('consultation_type'); ?></th>
				<th><?php echo $this->lang->line('medical_hospital'); ?></th>
				<th><?php echo $this->lang->line('date_consult'); ?></th>
				</tr>
			<?php 
			foreach($consult_Details as $consult_Detail){ 
				//print_r($consult_Detail);
			//$lang === 'french' ? 'oui' : 'yes'
				?>
				<tr>
					
					<td class="withborder second"><?php echo $consult_Detail['title'].' '.$consult_Detail['name'].' '.$consult_Detail['surname']; ?></td>
					<td class="withborder second"><?php echo $consult_Detail['speciality']; ?></td>
					<td class="withborder"><?php echo "Dental Consult" ?></td>
					<td class="withborder"><?php echo $consult_Detail['clinic_name']; ?></td>
					<td class="withborder"><?php echo $consult_Detail['created_date']; ?></td>
					<!--<td class="withborder"><?php //echo $billDetail[0]['gst']; ?></td>-->
					
				</tr>
			<?php } ?>
	</div>
	</div>
    </div>
</div>

