<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 

if(count($appntDetails)>0){  
					echo 'Appointment details'; 
				}else{ 
					echo $this->lang->line('noappoint'); 	
				}
		?>	
	</h4>
</div>
<div class="modal-body">
<?php 
$baseurl = base_url();
if(count($appntDetails)>0){
   $appid =  $appntDetails->appointment_id;
   $pract_id = $appntDetails->practitioner_id;
   $appoint_startdate = strtotime($appntDetails->appointment_date);
   //$appoint_startdate = $appoint_startdate+86400;
   $appoint_duration = $appntDetails->appointment_duration;
   $appoint_enddate = '';
   if($appoint_duration != '')
   {
       $appoint_duration_secs = $appoint_duration*60;
       $appoint_enddate = $appoint_startdate + $appoint_duration_secs;
   }   
   $appoint_starttime = date("G:i", strtotime($appntDetails->appointment_from));
   $appoint_endtime = date("G:i", strtotime($appntDetails->appointment_to));
   
?>
    
    
    <?php echo form_open($baseurl.'clinic/patients/generate_invoice',array('class' => 'form-horizontal form_health','id' => 'appoint_invoiceform')); ?>
        <input type="hidden" id="patient_id" name="patient_id" value="<?php echo $this->encryption->encode($appntDetails->patient_id); ?>" />
        <?php echo form_hidden('patient_action', 'add_invoice'); ?>
        <input type="hidden" id="appoint_id" name="selected_appointments[]" value="<?php echo $appntDetails->appointment_id; ?>" />
        <input type="hidden" name="selected_pract_name[<?php echo $appntDetails->appointment_id; ?>]" value="<?php echo $appntDetails->prac_title.'.'.$appntDetails->prac_first_name.' '.$appntDetails->prac_surname; ?>" />
        <input type="hidden" name="selected_pract_provider_no[<?php echo $appntDetails->appointment_id; ?>]" value="<?php echo $appntDetails->prac_provider_no; ?>" />
        <input type="hidden" name="appointment_invoice" value="1" />
    <?php echo form_close();?>
        
    <div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('appointment_date');?>:</label>
		<div class="col-sm-9">
		     <?php echo date("jS M, Y", strtotime($appntDetails->appointment_date)); ?>
			 
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('appointment_duration');?>:</label>
		<div class="col-sm-9">
		     <?php echo date("g:i a", strtotime($appntDetails->appointment_from)).'-'.date("g:i a", strtotime($appntDetails->appointment_to));?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('practitioner_name');?>:</label>
		<div class="col-sm-9">
		     <?php echo $appntDetails->prac_title.' '.$appntDetails->prac_first_name.' '.$appntDetails->prac_surname; ?>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('avail_room');?>:</label>
		<div class="col-sm-9">
		     <?php echo $appntDetails->room; ?>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('practitioner_dept');?>:</label>
		<div class="col-sm-9">
		     <?php echo $appntDetails->department; ?>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('patient_name');?>:</label>
		<div class="col-sm-9">
		     <a href="<?php echo base_url();?>clinic/patients/details/<?php echo $this->encryption->encode($appntDetails->patient_id);?>"><?php echo $appntDetails->patient_title.' '.$appntDetails->first_name.' '.$appntDetails->last_name; ?></a>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('patient_dob');?>:</label>
		<div class="col-sm-9">
		     <?php echo date("jS M, Y", strtotime($appntDetails->date_of_birth)); ?>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('patient_mobile_no');?>:</label>
		<div class="col-sm-9">
		     <?php echo $appntDetails->mobile_no; ?>
		</div>
	</div> 
        
	<div class="form-group last_form_group note_popup">
		<label for="ticket-type" class="col-sm-12 control-label"><?php echo $this->lang->line('notes');?>:</label>
		<div class="col-sm-12 note_txt">
		     <?php if($appntDetails->appointment_notes != '') 
					echo $appntDetails->appointment_notes;
				   else
					echo 'N/A';
			 ?>
		</div>
	</div> 
        <div class="top_right_invoice" style="width: 75%;">
            <!--<a href="javascript: void(0)" id="generate_invoice_link"><?php echo $this->lang->line('generate_invoice'); ?></a>
            <a href="<?php echo base_url();?>clinic/patients/details/<?php echo $this->encryption->encode($appntDetails->patient_id);?>" class="editt_appnt">View patient page</a>
        </div>-->
	<div class="top_right_invoice" style="width: 90%;">
            
            <a href="javascript:void(0);" id="<?php echo $this->encryption->encode($appntDetails->appointment_id);?>" appointment_date="<?php echo $appntDetails->appointment_date;?>" class="cancel_appnt"><?php echo $this->lang->line('cancel_appointment');?></a>
            <a href="javascript:void(0);" id="<?php echo $this->encryption->encode($appntDetails->appointment_id);?>" appointment_date="<?php echo $appntDetails->appointment_date;?>" class="editt_appnt" onclick="popitup('<?php echo base_url(); ?>clinic/appointment/edit_appointment?startDate=<?php echo $appoint_startdate; ?>&startTime=<?php echo $appoint_starttime; ?>&endTime=<?php echo $appoint_endtime; ?>&endDate=<?php echo $appoint_enddate; ?>&resource=<?php echo $pract_id; ?>&appointment_id=<?php echo $this->encryption->encode($appid); ?>')"><?php echo $this->lang->line('edit_appointment');?></a>
        </div>
        
<?php }else{
    
            if(isset($casualDetails->appointment_notes) &&  $casualDetails->appointment_notes != ''){
 ?>
	      <div class="form-group last_form_group">
                    <label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('notes');?>:</label>
                    <div class="col-sm-9">
                         <?php echo $casualDetails->appointment_notes; ?>
                    </div>
              </div>
 <?php } else { ?>
              <div class="form-group last_form_group">
                    <label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('notes');?>:</label>
                    <div class="col-sm-9">
                         <?php echo $this->lang->line('no_scheduled_appoint');  ?>
                    </div>
              </div>     
 <?php } 
 
 }
	?>	
</div>
<script>
function popitup(url) {
	newwindow=window.open(url,"name","height=420,width=510,top=20,left=20,scrollbars=0,resizable=0,fullscreen=0");
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>