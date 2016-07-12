<title><?php 
$fronttitile = ($clinic_disabled==0)? $this->lang->line('clinic_activate_titile'): $this->lang->line('clinic_disabled_titile');
echo sprintf($this->lang->line('title_clinic_page'),$fronttitile).$this->lang->line('title_universal');?></title>
<body>
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
<div id="main-wrapper" class="container">
                    <div class="row">
                    
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                  <div id="rootwizard">
										   <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i><?php echo $this->lang->line('clinic_created'); ?> </a></li>
                                            <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-calendar"></i><?php echo $this->lang->line('clinic_access'); ?></a></li>
                                            </ul>
		<div class="tab-content">
         	<div class="tab-pane active fade in" id="tab1">             
        <!-- end top general alert -->   
		 <?php if($this->session->flashdata('display_message')!='') { ?>
           <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
		<?php }?>
			
			
				<div class="addClinicBtn"><a class="btn btn-primary" href="<?php echo base_url(); ?>clinic/add"><?php echo $this->lang->line('add_new_clinic'); ?></a></div>
				
					
	            <!-- content-wrapper -->
					<!--div class="col-md-10 content-wrapper"--> <!-- InstanceBeginEditable name="body" -->
                    <div class="table_scroller">
						<table id="clinicListing" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
						<thead
							<tr>
								<th><?php echo $this->lang->line('name_clinic'); ?></th>
								<th><?php echo $this->lang->line('code_clinic'); ?></th>
								<th><?php echo $this->lang->line('location_clinic'); ?></th>
								<th><?php echo $this->lang->line('clinic_telephone'); ?></th>
								<th><?php echo $this->lang->line('clinic_official_email_address'); ?></th>
								<th><?php echo $this->lang->line('created_date'); ?></th>
								<th><?php echo $this->lang->line('modified_date'); ?></th>
								<th><?php echo $this->lang->line('status_clinic'); ?></th>
								<th><?php echo $this->lang->line('actions_clinic'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php 
							if(count($clinic_created)>0){
								foreach($clinic_created as $dbtbls){   
								if($dbtbls->suburb != '')
									$region = $dbtbls->suburb;
								else
									$region = $dbtbls->city;
						?>
							<tr>
								<td><?php echo $dbtbls->clinic_name; ?></td>
								<td><?php echo $dbtbls->code; ?></td>
								<td><?php echo $dbtbls->street_address.', '.$region.', '.$dbtbls->state.', '.$dbtbls->country; ?></td>
								<td><?php 
									$teleNo = explode('::',$dbtbls->telephone);
									echo $teleNo[0]; ?></td>
								<td><?php 
									$emailAdd = explode('::',$dbtbls->clinic_contact_email_address);
									echo $emailAdd[0]; ?></td>
								<td><?php echo ($dbtbls->created_date=="")?'-':date('jS M, Y H:i:s', strtotime($dbtbls->created_date)); ?></td>
								<td><?php echo ($dbtbls->last_modified_date=="")?'-':date('jS M, Y H:i:s', strtotime($dbtbls->last_modified_date)); ?></td>
									<td><?php if($dbtbls->status == '1'){ ?><span class="inactive_text"><?php echo $this->lang->line('active'); ?></span><?php }?>
								<?php if($dbtbls->status == '0'){ ?>
								<span class="active_text"><?php echo $this->lang->line('inactive'); ?></span><?php }?>
								</td>
								<td>
								<?php if($clinic_disabled == '0'){ ?>
                                  <ul class="cL_action_ul">
                                 
                                    <li><a class="clinic_action" href="<?php echo base_url();?>clinic/edit/<?php echo $this->encryption->encode($dbtbls->clinic_id); ?>" title="<?php echo $this->lang->line('edit_clinic_information');?>" alt="<?php echo $this->lang->line('edit_clinic_information');?>">
                                        <i class="fa fa-pencil"></i>
                                      </a>
                                    </li>
                                  </ul>
								
								<?php } ?>
								
								</td>
							</tr>
						<?php    } 
							} 
						?>	
						</tbody>
<!--						<tfoot>
							<tr>
								<th><?php echo $this->lang->line('name_clinic'); ?></th>
								<th><?php echo $this->lang->line('code_clinic'); ?></th>
								<th><?php echo $this->lang->line('location_clinic'); ?></th>
								<th><?php echo $this->lang->line('clinic_telephone'); ?></th>
								<th><?php echo $this->lang->line('clinic_official_email_address'); ?></th>
                                <th><?php echo $this->lang->line('created_date'); ?></th>
								<th><?php echo $this->lang->line('modified_date'); ?></th>
								<th><?php echo $this->lang->line('status_clinic'); ?></th>
								<th><?php echo $this->lang->line('actions_clinic'); ?></th>
							</tr>
						</tfoot>-->
						</table>
                      </div>
					<!--/div-->
                <!-- /content-wrapper --> 
               
		   
			</div>
			<div class="tab-pane  fade in" id="tab2">
				
	            <!-- content-wrapper -->
					<!--div class="col-md-10 content-wrapper"--> <!-- InstanceBeginEditable name="body" -->
                    
						<table id="clinicListingaccess" class="display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('name_clinic'); ?></th>
								<th><?php echo $this->lang->line('code_clinic'); ?></th>
								<th><?php echo $this->lang->line('location_clinic'); ?></th>
								<th><?php echo $this->lang->line('clinic_telephone'); ?></th>
								<th><?php echo $this->lang->line('clinic_official_email_address'); ?></th>
								<th><?php echo $this->lang->line('created_date'); ?></th>
								<th><?php echo $this->lang->line('modified_date'); ?></th>
								
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
								<td><?php echo $dbtbls->clinic_name; ?></td>
								<td><?php echo $dbtbls->code; ?></td>
								<td><?php echo $dbtbls->street_address.', '.$region.', '.$dbtbls->state.', '.$dbtbls->country; ?></td>
								<td><?php 
									$teleNo = explode('::',$dbtbls->telephone);
									echo $teleNo[0]; ?></td>
								<td><?php 
									$emailAdd = explode('::',$dbtbls->clinic_contact_email_address);
									echo $emailAdd[0]; ?></td>
								<td><?php echo ($dbtbls->created_date=="")?'-':date('jS M, Y H:i:s', strtotime($dbtbls->created_date)); ?></td>
								<td><?php echo ($dbtbls->last_modified_date=="")?'-':date('jS M, Y H:i:s', strtotime($dbtbls->last_modified_date)); ?></td>
							
							
							</tr>
						<?php    } 
							} 
						?>	
						</tbody>
<!--						<tfoot>
							<tr>
								<th><?php echo $this->lang->line('name_clinic'); ?></th>
								<th><?php echo $this->lang->line('code_clinic'); ?></th>
								<th><?php echo $this->lang->line('location_clinic'); ?></th>
								<th><?php echo $this->lang->line('clinic_telephone'); ?></th>
								<th><?php echo $this->lang->line('clinic_official_email_address'); ?></th>
                                <th><?php echo $this->lang->line('created_date'); ?></th>
								<th><?php echo $this->lang->line('modified_date'); ?></th>
								
							</tr>
						</tfoot>-->
						</table>
					
						
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
<script src="<?php echo base_url();?>assets/js/mc_js/admin/clinic/view_clinics.js"></script>