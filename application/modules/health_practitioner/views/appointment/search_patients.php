<?php if(sizeof($patientResults)>0) {?>
<table class="patient_lists">
<tr class="listing_heading">
<th><?php echo $this->lang->line('patient_name');?></th>
<th><?php echo $this->lang->line('dob');?></th>
<th><?php echo $this->lang->line('mobile_number');?></th>
</tr>

<!--<div class="listing_results">-->
<!--<tr><td colspan="3"><table class="inner_tabl">-->
<?php foreach($patientResults as $patientResult) {?>
<tr class="select_patient">
<td style="display:none;"><span class="patient_id" id="<?php echo $this->encryption->encode($patientResult->patient_id); ?>"></span></td>
<td class="patient_name"><?php echo $patientResult->first_name.' '.$patientResult->last_name; ?></td>
<td><?php echo date('jS M, Y', strtotime($patientResult->date_of_birth)); ?></td>
<td><?php echo $patientResult->mobile_no; ?></td>
</tr>
<?php }?>

<!--</table><td></tr>-->

<!--</div>-->
</table>
<?php }else {?>
<span><?php echo $this->lang->line('no_results_patient');?></span>
<?php }?>
<script>
$(document).ready(function(){
$('.select_patient').click(function() {
	var patientName = $(this).find('.patient_name').html();
	$('.patient_field').val(patientName);
	$('#patient_field_id').val($(this).find('.patient_id').attr('id'));
	$('.btn-lg').trigger('click');
});

});</script>