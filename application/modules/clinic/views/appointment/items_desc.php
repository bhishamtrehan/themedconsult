<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.css">
<title><?php echo $this->lang->line('item_descs').$this->lang->line('title_universal');?></title>
<body>
<!-- WRAPPER -->
<div class="wrapper"> 
  
  <!-- TOP BAR -->
  <?php $this->load->view ('inc/clinic_top_bar');?>
  <!-- /top --> 
  
  <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
  <div class="bottom">
    <div class="container">
      <div class="row"> 
        <!-- left sidebar -->
        <div class="col-md-2 left-sidebar"> 
           <?php 
                if($this->session->userdata['user_role'] == '5')
                    $this->load->view ('inc/clinic_location_left_nav');
                else
                    $this->load->view ('inc/clinic_left_nav');	
            ?>		  
        </div>
		  <!-- end left sidebar --> 
		  <?php if($this->session->flashdata('display_message')!='') {?>
           <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
			<?php }?>
		<div class="col-md-10 content-wrapper"> <!-- InstanceBeginEditable name="body" -->
			<!-- top general alert -->
			
            <!-- end top general alert -->   
			<div class="row">
			<div class="container">
				<div class="bread_outr">
				<ul class="breadcrumb">
					<li><i class="fa fa-home"></i><a href="<?php echo base_url();?>"><?php echo $this->lang->line('home');?></a></li>
					<li class="active"><?php echo $this->lang->line('item_descs');?></li>
				</ul>
				</div>
				<a href="javascript:void(0);" onClick="add_appointment_type();">
				<span class="addpopup_pg"><?php echo $this->lang->line('add_new_item_desc');?></span></a>
			</div></div>
			<div class="widget">
				<div class="widget-header">
				    <h3><i class="fa fa-list"></i><?php echo $this->lang->line('item_descs'); ?></h3>
				</div>
				<div class="widget-content">
	            <!-- content-wrapper -->
					<!--div class="col-md-10 content-wrapper"--> <!-- InstanceBeginEditable name="body" -->
                    <div class="table-responsive">
						<table id="clinicListing" class="  display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('item_code'); ?></th>
								<th><?php echo $this->lang->line('appnt_type'); ?></th>
                                                                <th><?php echo $this->lang->line('price'); ?></th>                                                                
								<th><?php echo $this->lang->line('assigned_color'); ?></th>
                                                                <th style="width: 35px !important;"><?php if(!empty($cliniclocationSettings) && $cliniclocationSettings['tax_applicable'] != ''){ echo $cliniclocationSettings['tax_applicable']; } else{ echo $this->lang->line('tax'); } ?></th>
                                                                <th class="status_table"><?php echo $this->lang->line('status'); ?></th>
								<th><?php echo $this->lang->line('actions'); ?></th>                                                                
							</tr>
						</thead>
						<tbody>
						<?php 	if(count($datatables)>0){
								foreach($datatables as $dbtbls){ 
								$typeID = '';
								$typeID = $this->encryption->encode($dbtbls->type_id);?>
							<tr>
								<td>
								<?php if($dbtbls->code!="")
										echo $dbtbls->code;
									else 
										echo '-';
									?>
								</td>
								<td><?php echo $dbtbls->appointment_type; ?></td>
                                                                <td><?php if($dbtbls->price != '' && $dbtbls->currency != ''){ echo $dbtbls->currency.' '.$this->shc_constants->currency_symbols[$dbtbls->currency].$dbtbls->price; }else{ echo '-'; } ?></td>
                                                                <td><span class="color_code" style="background-color:#<?php echo $dbtbls->color_code; ?>"></span></td>
                                                                <td>
                                                                    <div class="invoice_check invoice_item_disc">
                                                                        <input onClick="update_tax('<?php echo $typeID; ?>',this)" <?php if($dbtbls->is_tax == 1){ ?> checked <?php } ?> type="checkbox" id="is_tax_<?php echo $typeID; ?>" value="" />
                                                                        <span class="invoice_box"></span>
                                                                    </div>
                                                                </td>
								<td>
								<a class="appntDisable" id="appntDisable<?php echo $typeID; ?>" href="javascript:void(0)" title="<?php echo $this->lang->line('enable'); ?>" alt="<?php echo $this->lang->line('enable'); ?>" onClick="enable_appnt_type('<?php echo $typeID; ?>');" style="<?php echo ($dbtbls->status==0)?'display:block;':'display:none'; ?>"><i class="fa fa-dot-circle-o" ></i><span class="inactive_text"><?php echo $this->lang->line('inactive'); ?></span></a>
								   
								<a class="appntEnable" title="<?php echo $this->lang->line('disable'); ?>" alt="<?php echo $this->lang->line('disable'); ?>" id="appntEnable<?php echo $typeID; ?>" href="javascript:void(0)" onClick="disable_appnt_type('<?php echo $typeID; ?>');" style="<?php echo ($dbtbls->status==1)?'display:block;':'display:none';  ?>"; > <i class="fa fa-check-circle-o" style="color:green;"></i><span class="active_text"><?php echo $this->lang->line('active'); ?></span></a>
									</td>
								<td><a href="javascript:void(0);" onClick="edit_appointment_type('<?php echo $typeID; ?>');"><i class="fa fa-pencil-square-o"></i></a></td>
							</tr>
						<?php    } 
							} 
						?>	
						</tbody>
						<tfoot>
							<tr>
								<th><?php echo $this->lang->line('item_code'); ?></th>
								<th><?php echo $this->lang->line('appnt_type'); ?></th>
                                                                <th><?php echo $this->lang->line('price'); ?></th>                                                                
								<th><?php echo $this->lang->line('assigned_color'); ?></th>
                                                                <th style="width: 35px !important;"><?php if(!empty($cliniclocationSettings) && $cliniclocationSettings['tax_applicable'] != ''){ echo $cliniclocationSettings['tax_applicable']; } else{ echo $this->lang->line('tax'); } ?></th>
								<th><?php echo $this->lang->line('status'); ?></th>
								<th><?php echo $this->lang->line('actions'); ?></th>
							</tr>
						</tfoot>
						</table></div>
					<!--/div-->
                <!-- /content-wrapper --> 
                </div>
		    </div>	
		</div>
        <!-- /row --> 
      </div>
      <!-- /container --> 
    </div>
    <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT --> 
  </div>
</div>
<div class="popup">
 <button type="button" style="display:none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content"></div> 
    </div>
  </div>
</div>
<!-- /wrapper --> 
<!-- FOOTER -->
<?php $this->load->view ('inc/footer');?>
<!-- FOOTER -->
<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>js/shc_js/clinics/appointment/type.js"></script>