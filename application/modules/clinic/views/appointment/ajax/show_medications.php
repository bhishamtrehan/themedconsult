<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 

if(count($appntDetails)>0){  
					echo 'Medications'; 
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
		<div class="row tabheading">
			<ul class="nav nav-tabs c_medication " role="tablist">
				
					<li  role="presentation" class="active tabber">
						<a   role="tab" data-target="#regular-meducations" data-toggle="tab">Regular Medications</a>
					</li>
				
			
					<li  role="presentation" class="tabber">
						<a  role="tab" data-target="#pnr-meducations" data-toggle="tab" >PRN Medications</a>
					</li>
			
			
					<li  role="presentation" class="tabber">
						<a  role="tab" data-target="#chemotherapy" data-toggle="tab"  >Chemotherapy</a>
					</li>
				
			</ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane active" id="regular-meducations">
                <div class="col-md-12 form-group listmedications">
		<h4 class="medication_label">Current Medication</h4>
		<table cellspacing="0" cellpadding="0" border="0" class="display table table-sorting table-hover table-bordered datatable dataTable no-footer">
			<tbody><tr>
				<!-- <th class="first withborder">&nbsp;</th> -->
				<th class="withborder second"><a of="c" inorder="asc" orderby="medication" coords="209" class="ordermedication asc" href="javascript:;">Medication</a></th>
				<th class="withborder">Dosage</th>
				<th class="withborder">Route</th>
				<th class="withborder">Frequency</th>
				<th class="withborder sixth">Regular Medication</th>
				<th class="withborder"><a of="c" inorder="asc" orderby="startdate" coords="209" class="ordermedication asc" href="javascript:;">Start Date</a></th>
				<th class="withborder"><a of="c" inorder="asc" orderby="enddate" coords="209" class="ordermedication asc" href="javascript:;">End Date</a></th>
				<th class="withoutborder last cm_action">Action</th>
			</tr>
			<?php 
			// echo "<pre>";
			// print_r($appntDetails);
			
			foreach($appntDetails as $appDet){ 
				?>
				<tr>
					<td class="first withborder"></td>
					<td class="withborder second"><?php echo $appDet->medication; ?></td>
					<td class="withborder"><?php echo $appDet->dose; ?></td>
					<td class="withborder"><?php echo $appDet->route; ?></td>
					<td class="withborder"><?php echo $appDet->frequency; ?></td>
					<td class="withborder sixth"><?php echo $appDet->notes; ?> </td>
					<td class="withborder"><?php echo $appDet->startdate; ?></td>
					<td class="withborder"><?php echo $appDet->enddate; ?></td>
					<td class="withoutborder last">
                      <a  class="viewmedication" href="javascript:;" id="<?php echo $appDet->id; ?>"><i class="fa fa-eye"></i>View</a>
                      <a  class="deletemedication" href="javascript:;"  id="<?php echo $appDet->id; ?>"><i class="fa fa-trash"></i>Delete</a>
					</td>
				</tr>
			<?php } ?>
		
					</tbody></table>
			<div class="clr"></div>
	<a data-attr="<?php echo $appntID; ?>" class="newmedication btn btn-default fr" href="javascript:void(0);">Add Medication</a>
	<div class="clr"></div>
	</div>
	
	
	
	
	
	
	
	
	     <div class="col-md-12 form-group listmedications">
		<h4 class="medication_label">Previous Medication</h4>
		<table cellspacing="0" cellpadding="0" border="0" class="display table table-sorting table-hover table-bordered datatable dataTable no-footer">
			<tbody><tr>
				<!-- <th class="first withborder">&nbsp;</th> -->
				<th class="withborder second"><a of="c" inorder="asc" orderby="medication" coords="209" class="ordermedication asc" href="javascript:;">Medication</a></th>
				<th class="withborder">Dosage</th>
				<th class="withborder">Route</th>
				<th class="withborder">Frequency</th>
				<th class="withborder sixth">Regular Medication</th>
				<th class="withborder"><a of="c" inorder="asc" orderby="startdate" coords="209" class="ordermedication asc" href="javascript:;">Start Date</a></th>
				<th class="withborder"><a of="c" inorder="asc" orderby="enddate" coords="209" class="ordermedication asc" href="javascript:;">End Date</a></th>
				<!-- <th class="withoutborder last">&nbsp;</th> -->
			</tr>
			<?php
		//echo "<pre>";
			//print_r($appnt_previous_Details);

			foreach($appnt_previous_Details as $appDet_previous){ 
				?>
				<tr>
					<td class="withborder second"><?php echo $appDet_previous->medication; ?></td>
					<td class="withborder"><?php echo $appDet_previous->dose; ?></td>
					<td class="withborder"><?php echo $appDet_previous->route; ?></td>
					<td class="withborder"><?php echo $appDet_previous->frequency; ?></td>
					<td class="withborder sixth"><?php echo $appDet_previous->notes; ?> </td>
					<td class="withborder"><?php echo $appDet_previous->startdate; ?></td>
					<td class="withborder"><?php echo $appDet_previous->enddate; ?></td>
					
				</tr>
			<?php } ?>
		
					</tbody></table>
			<div class="clr"></div>
	</div>
	
	
	
	
	
	
	
	
            </div>
            <div class="tab-pane" id="pnr-meducations">
                PRN Medications
            </div>
			<div class="tab-pane" id="chemotherapy">
                Chemotherapy
            </div>
        </div>
        
          
        
      </div>	
      </div>
</div>

<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/delete_medication.js"></script> 