<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 

if(count($appntview)>0){  
					echo 'Medication'; 
				}else{ 
					echo 'No Medications'; 	
				}
		?>	
	</h4>
</div>
<div class="modal-body ">
<div class="panel panel-primary">
	  <input type="hidden" value="209" id="medicationappid" name="medicationappid">
      <div data-acc-content="demo1" class="panel-body acc-open">
        <!--tab-one-start-->
	

       
            <div class="tab-pane active" id="regular-meducations">
                <div class="col-md-12 form-group listmedications">
		<!--<h4 class="medication_label">Current Medication</h4>-->
		<table cellspacing="0" cellpadding="0" border="0" class="display table table-sorting table-hover table-bordered datatable dataTable no-footer">
			<tbody><tr>
				<th class="first withborder">&nbsp;</th>
				<th class="withborder second"><a of="c" inorder="asc" orderby="medication" coords="209" class="ordermedication asc" href="javascript:;">Medication</a></th>
				<th class="withborder">Dosage</th>
				<th class="withborder">Route</th>
				<th class="withborder">Frequency</th>
				<th class="withborder sixth">Regular Medication</th>
				<th class="withborder"><a of="c" inorder="asc" orderby="startdate" coords="209" class="ordermedication asc" href="javascript:;">Start Date</a></th>
				<th class="withborder"><a of="c" inorder="asc" orderby="enddate" coords="209" class="ordermedication asc" href="javascript:;">End Date</a></th>
				<!--<th class="withoutborder last">&nbsp;</th>-->
			</tr>
			<?php 
			// echo "<pre>";
			// print_r($appntDetails);
			
			foreach($appntview as $appview){ 
				?>
				<tr>
					<td class="first withborder"></td>
					<td class="withborder second"><?php echo $appview->medication; ?></td>
					<td class="withborder"><?php echo $appview->dose; ?></td>
					<td class="withborder"><?php echo $appview->route; ?></td>
					<td class="withborder"><?php echo $appview->frequency; ?></td>
					<td class="withborder sixth"><?php echo $appview->notes; ?> </td>
					<td class="withborder"><?php echo $appview->startdate; ?></td>
					<td class="withborder"><?php echo $appview->enddate; ?></td>
					
				</tr>
			<?php } ?>
		
					</tbody></table>
		

	<div class="clr"></div>
	</div>
	
	
	
	
	
	
	
	
	
            </div>
         
    
        
          
        
      </div>
      </div>
</div>

<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/delete_medication.js"></script> 