<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.css">
<link rel="stylesheet" href="<?php echo base_url();?>colorpicker/css/pick-a-color-1.2.3.min.css">
<script src="<?php echo base_url();?>colorpicker/js/tinycolor-0.9.15.min.js"></script>
<script src="<?php echo base_url();?>colorpicker/js/pick-a-color-1.2.3.min.js"></script>
<style>
#item_preview
{
    display: none; float: left; height: 34px; text-align: center; padding-top: 5px; width: 100%; font-size: 16px; border: 1px solid #cccccc;
}
</style>
<?php echo form_open('',array('class' => 'form-horizontal form_health form-popup-main','id' => 'add_appointment_type'));
$appointment_type = array(
	'name'	=> 'appointment_type',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_appnt_type'),
);
$color_code = array(
	'name'	=> 'color_code',
	'maxlength'	=> 80,
	'class' => 'form-control pick-a-color',
	'placeholder' => $this->lang->line('select_color_dropdown'),
	'size'	=> 30,
	'autocomplete' => 'off',
);
$billing_code = array(
	'name'	=> 'billing_code',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('item_code'),
);
$price = array(
	'name'	=> 'price',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('price'),
	'size'	=> 30,
	'autocomplete' => 'off',
);

$currencyy = array(
	'name'	=> 'currencyy',
        'id' => 'currency',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'size'	=> 30,
	'autocomplete' => 'off',
	'value' => isset($clinic_location_settings['currency'])?$clinic_location_settings['currency']:'',
        'disabled' => true,
        'style' => 'float: right;'
);

$appointment_count = array(
	'name'	=> 'appointment_count',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_app_count'),
);

foreach($currencies as $key => $value)
{
  $currency_array[$key] = $key.'('.$value.')';
}
$currency_list = form_dropdown('currency', $currency_array, '', 'id="currency"');

$text_color_array = array();
$text_color_array['white'] = 'White';
$text_color_array['black'] = 'Black';
$text_color = form_dropdown('text_color', $text_color_array, '', 'id="textcolor"');

if(sizeof($item_codes_array) > 1) {
$billing_codes = form_dropdown('billing_code', $item_codes_array, '', 'id="billing_code"');
}
else {
	$anchor_start = '<a href="'.base_url().'clinic/appointment/item_codes'.'">';
	$anchor_end   = '</a>';
	$billing_codes = sprintf($this->lang->line('billing_code_not_found_desc'), $anchor_start, $anchor_end);
}
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><?php echo $this->lang->line('add_new_item_desc');?></h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('appnt_type');?>:</label>
		<div class="col-sm-9">
			 <?php echo form_input($appointment_type); ?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('select_color_code');?>:</label>
		<div class="col-sm-9">
			 <?php echo form_input($color_code); ?>
		</div>
	</div> 
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('item_code');?>:</label>
		<div class="col-sm-9">
			 <?php echo form_input($billing_code); ?>
		</div>
	</div>   
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('price');?>:</label>
		<div class="col-sm-9">
		<?php echo form_input($currencyy); //echo $currency_list; ?>
		<?php echo form_input($price); ?>
                    <input type="hidden" name="currency" value="<?php echo isset($clinic_location_settings['currency'])?$clinic_location_settings['currency']:''; ?>" />
		</div>
	</div> 
        <div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('text_color');?>:</label>
		<div class="col-sm-5" style="width: 37%; padding-right: 5px;">
		<?php echo $text_color; ?>
		</div>
                <div class="col-sm-5" style="width: 38%; padding-left: 2px;">
                    <span id="item_preview">text</span>
		</div>
	</div> 
        <div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"><?php echo $this->lang->line('app_count');?>:</label>
		<div class="col-sm-9">
		<?php echo form_input($appointment_count); ?>
		</div>
                
	</div>
    
        <?php echo form_hidden('submit_action', 'insert');?>
	<div class="form-group">
		<label for="ticket-type" class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
			 <?php echo form_submit('submit', $this->lang->line('submit'),"class='btn btn-primary btn-block'"); ?>
		</div>
	</div> 				
</div>
<?php echo form_close();?>  