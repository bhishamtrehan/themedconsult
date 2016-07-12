<?php echo form_open('',array('class' => 'form-horizontal form_health form-popup-main','id' => 'edit_billing_code'));
$billing_code = array(
	'name'	=> 'billing_code',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('item_code'),
	'value' => $codeDetails->code,
);
$price = array(
	'name'	=> 'price',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('price'),
	'size'	=> 30,
	'autocomplete' => 'off',
	'value' => $codeDetails->price,
);

foreach($currencies as $key => $value)
{
  $currency_array[$key] = $key.'('.$value.')';
}
$currency_list = form_dropdown('currency', $currency_array, $codeDetails->currency, 'id="currency"');
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><?php echo $this->lang->line('edit_item_code');?></h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('item_code');?>:</label>
		<div class="col-sm-9">
			 <?php echo form_input($billing_code); ?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('price');?>:</label>
		<div class="col-sm-9">
		<?php echo $currency_list; ?>
		<?php echo form_input($price); ?>
		</div>
	</div> 
	<?php echo form_hidden('code_id', $this->encryption->encode($codeDetails->code_id));?>
	<?php echo form_hidden('submit_action', 'edit');?>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
			 <?php echo form_submit('submit', $this->lang->line('update'),"class='btn btn-primary btn-block'"); ?>
		</div>
	</div> 				
</div>
<?php echo form_close();?>  