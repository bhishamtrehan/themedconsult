<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 

if(count($patientDetails)>0){  
					echo 'Patient Details'; 
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
				<!-- <th>Title</th> -->
				<th>First Name</th>
				<th>Last Name</th>
				<th>Gender</th>
				<th>Address</th>
			</tr>
			<?php 
			foreach($patientDetails as $patientDetails){ 
			$lang === 'french' ? 'oui' : 'yes'
				?>
				<tr>
					
					<!-- <td class="withborder second"><?php echo $patientDetails->title; ?></td>-->
					<td class="withborder"><?php echo ucfirst($patientDetails->first_name); ?></td>
					<td class="withborder"><?php echo ucfirst($patientDetails->last_name); ?></td>
					<td class="withborder"><?php echo ucfirst($patientDetails->gender == 1 ? 'Male' : 'female'); ?></td>
					<td class="withborder"><?php echo $patientDetails->street_address.' '. $patientDetails->street_address2; ?></td>
					
				</tr>
			<?php } ?>
	</div>
	</div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/delete_medication.js"></script> 