<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
		<?php 

if(count($rosterDetails)>0){  
					echo $this->lang->line('roster_view');
				}else{ 
					echo $this->lang->line('noappoint'); 	
				}
		?>	
	</h4>
</div>
<div class="modal-body">
<?php 
$baseurl = base_url();

   $rostid =  $rosterDetails->roster_id;
   $pract_id = $rosterDetails->practitioner_id;
   $roster_startdate = strtotime($rosterDetails->roster_date);
   //$roster_startdate = $roster_startdate+86400;
   $roster_duration = $rosterDetails->roster_duration;
   $roster_enddate = '';
   if($roster_duration != '')
   {
       $roster_duration_secs = $roster_duration*60;
       $roster_enddate = $roster_startdate + $roster_duration_secs;
   }   
   $roster_starttime = date("G:i", strtotime($rosterDetails->roster_from));
   $roster_endtime = date("G:i", strtotime($rosterDetails->roster_to));
   
?>
    
    
    <?php echo form_open($baseurl.'clinic/patients/generate_invoice',array('class' => 'form-horizontal form_health','id' => 'appoint_invoiceform')); ?>
        <input type="hidden" id="prac_id" name="prac_id" value="<?php echo $this->encryption->encode($rosterDetails->practitioner_id); ?>" />
        <?php echo form_hidden('patient_action', 'add_invoice'); ?>
        <input type="hidden" id="roster_id" name="selected_roster[]" value="<?php echo $rosterDetails->roster_id; ?>" />
        <input type="hidden" name="selected_pract_name[<?php echo $rosterDetails->roster_id; ?>]" value="<?php echo $rosterDetails->title.'.'.$rosterDetails->name.' '.$rosterDetails->surname; ?>" />
       
        <input type="hidden" name="appointment_invoice" value="1" />
    <?php echo form_close();?>
        
    <div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('roster_date');?>:</label>
		<div class="col-sm-9">
		     <?php echo date("jS M, Y", strtotime($rosterDetails->roster_date)); ?>
			 
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('roster_duration');?>:</label>
		<div class="col-sm-9">
		     <?php echo date("g:i a", strtotime($rosterDetails->roster_from)).' - '.date("g:i a", strtotime($rosterDetails->roster_to));?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('practitioner_name');?>:</label>
		<div class="col-sm-9">
		     <?php echo $rosterDetails->title.' '.$rosterDetails->name.' '.$rosterDetails->surname; ?>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('practitioner_room');?>:</label>
		<div class="col-sm-9">
		     <?php echo $rosterDetails->room; ?>
		</div>
	</div> 

        <div class="top_right_invoice" style="width: 75%;">
            
	<div class="top_right_invoice" style="width: 90%;">
            
            <a href="javascript:void(0);" id="<?php echo $this->encryption->encode($rosterDetails->roster_id);?>" appointment_date="<?php echo $rosterDetails->roster_date;?>" class="cancel_roster"><?php echo $this->lang->line('cancel_roster');?></a>
            <a href="javascript:void(0);" id="<?php echo $this->encryption->encode($rosterDetails->roster_id);?>" appointment_date="<?php echo $rosterDetails->roster_date;?>" class="edit_roster" onclick="popitup('<?php echo base_url(); ?>clinic/appointment/edit_roster?startDate=<?php echo $roster_startdate; ?>&startTime=<?php echo $roster_starttime; ?>&endTime=<?php echo $roster_endtime; ?>&endDate=<?php echo $roster_enddate; ?>&resource=<?php echo $rosterDetails->clinic_room_id; ?>&roster_id=<?php echo $this->encryption->encode($rostid); ?>')"><?php echo $this->lang->line('edit_roster');?></a>
        </div>
        

</div>
<script>
function popitup(url) {
	//alert('test');
	return false;
	newwindow=window.open(url,"name","height=420,width=510,top=20,left=20,scrollbars=0,resizable=0,fullscreen=0");
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>