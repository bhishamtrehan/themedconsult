<title><?php 
$fronttitile = ($clinic_disabled==0)? $this->lang->line('clinic_activate_titile'): $this->lang->line('clinic_disabled_titile');
echo sprintf($this->lang->line('title_clinic_page'),$fronttitile).$this->lang->line('title_universal');?></title>
<body>
	
<!-- WRAPPER -->
<div class="wrapper"> 
  
  <!-- TOP BAR -->
  <?php //echo 'here'; die;;?>
  <!-- /top --> 
  
  <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
  <div class="bottom">
  <div class="custom_title">
	<div class="container">
	<h3><?php 
	if(isset($title)){
		echo $title;
	}else{
		echo $this->lang->line('home');
	}
	?>
	</h3>
	</div>
	</div>
    <div class="container">
      <div class="row"> 
        <!-- left sidebar -->
      
		
		<!-- end left sidebar --> 
     	<!-- top general alert -->
	   
        <!-- end top general alert -->   
		 <?php if($this->session->flashdata('display_message')!='') { ?>
           <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
		<?php }?>
			
			<div class="widget">
			
				<div class="widget-content">
				
	            <!-- content-wrapper -->
					<!--div class="col-md-10 content-wrapper"--> <!-- InstanceBeginEditable name="body" -->
                    <div class="table-responsive">
						<table id="clinicListing" class="view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
						<thead>
							<tr>
                              <th>Doctor Photo</th>
								<th><?php echo $this->lang->line('hp_surname'); ?></th>
								<th><?php echo $this->lang->line('hp_name'); ?></th>
								<th><?php echo $this->lang->line('hp_speciality'); ?></th>
								<th><?php echo $this->lang->line('hp_clinics'); ?></th>
								<th class="status_table"><?php echo $this->lang->line('status'); ?></th>
								<th class="cL_action"><?php //echo $this->lang->line('hp_date_created'); ?>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							if(count($datatables)>0){
								foreach($datatables as $dbtbls){   
								if($dbtbls->suburb != '')
									$region = $dbtbls->suburb;
								else
									$region = $dbtbls->city;
						?>
							<tr>
                              <td class="doc_image"><span><img src=""/></span></td>
								<td><?php echo ($dbtbls->surname); ?></td>
								<td><?php echo ($dbtbls->name); ?></td>
								<td><?php echo ($dbtbls->speciality); ?></td>
								<td></td>
								<td>
								<?php
								if($dbtbls->activated == 0)
								{
									echo $this->lang->line('non_verified');
								}
								elseif($dbtbls->activated == 1)
								{
									if($dbtbls->hp_status == 0)
									{?>
										<a href="javascript:void(0)" class="hpActive" data-hpID="<?php echo $dbtbls->hp_id;  ?>"><?php echo $this->lang->line('activate'); ?></a>
									<?php
									}
									if($dbtbls->hp_status == 1)
									{?>
										<a href="javascript:void(0)" class="hpInActive" data-hpID="<?php echo $dbtbls->hp_id;  ?>"><?php echo $this->lang->line('inactivate'); ?></a>
									<?php
									}
								}
								?>

								</td>
								<td><?php //echo ($dbtbls->created_date=="")?'-':date('jS M, Y H:i:s', strtotime($dbtbls->created_date)); ?>
                                  <ul class="cL_action_ul">
                                    <li><a href=""><i class="fa fa-envelope"></i>Message</a></li>
                                    <li><a href=""><i class="fa fa-check-square-o"></i>Activate</a></li>
                                    <li><a href=""><i class="fa fa-pencil"></i>Edit</a></li>
                                    <li><a href=""><i class="fa fa-trash-o"></i>Delete</a></li>
                                  </ul>
                                </td>
							</tr>
						<?php    } 
							} 
						?>	
						</tbody>
						<tfoot>
							<tr>
                               <th>Doctor Photo</th>
								<th><?php echo $this->lang->line('hp_surname'); ?></th>
								<th><?php echo $this->lang->line('hp_name'); ?></th>
								<th><?php echo $this->lang->line('hp_speciality'); ?></th>
								<th><?php echo $this->lang->line('hp_clinics'); ?></th>
								<th class="status_table"><?php echo $this->lang->line('status'); ?></th>
								<th><?php //echo $this->lang->line('hp_date_created'); ?>Actions</th>
							</tr>
						</tfoot>
						</table></div>
						
					<!--/div-->
                <!-- /content-wrapper --> 
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
<!-- FOOTER -->
<script>var baseUrl ="<?php echo base_url(); ?>";</script>
	<?php $this->load->view('inc/footer'); ?>
<script src="<?php echo base_url();?>assets/js/mc_js/admin/hp/view_hp.js"></script>
<script src="<?php echo base_url();?>assets/js/mc_js/admin/hp/hpCustomSettings.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.success_message').delay(4000).fadeOut();
});
	
</script>