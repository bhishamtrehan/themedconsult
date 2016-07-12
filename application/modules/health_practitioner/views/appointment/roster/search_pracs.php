<?php if(sizeof($parcResults)>0) {?>
<table class="patient_lists">
<tr class="listing_heading">
<th><?php echo $this->lang->line('prac_name');?></th>
<th><?php echo $this->lang->line('prac_lname');?></th>
</tr>

<!--<div class="listing_results">-->
<!--<tr><td colspan="3"><table class="inner_tabl">-->
<?php foreach($parcResults as $parcResult) {?>
<tr class="select_patient">
<td style="display:none;"><span class="prac_id" id="<?php echo $this->encryption->encode($parcResult->hp_id); ?>"></span></td>
<td class="parc_surname"><?php echo $parcResult->surname; ?></td>
<td class="parc_name"><?php echo $parcResult->name; ?></td>
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
	var SurName = $(this).find('.parc_surname').html();
	var parcName = $(this).find('.parc_name').html();
	$('.patient_field').val(SurName+' '+parcName);
	$('#prac_field_id').val($(this).find('.prac_id').attr('id'));
	$('.btn-lg').trigger('click');
});

});</script>