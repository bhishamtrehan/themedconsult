<?php
/*
Template for view comapnies list 
*/
?>

<body>
<!-- WRAPPER -->
<div class="wrapper"> 
 
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
	        	<a class="btn btn-primary" href="javascript:void(0);" onClick="openCompanyModal()" id="com_modal"><?php echo $this->lang->line('addcompany');?></a>
	        </div>
	        </div>
    <div class="container">
      <div class="row">
       <?php if($this->session->flashdata('display_message')!='') { ?>
           <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
		<?php }?>
          <div class="widget">
           
	        <div class="widget-content">
				<div class="panel panel-white">
					<div class="panel-body">
	        
			<div class="table-responsive ">
				<table id="viewcomapny" class="display table" style="width: 100%; cellspacing: 0;">
					<thead>
			            <tr>
							<th width="8%"><?php echo $this->lang->line('serialno'); ?></th>
			                <th width="72%"><?php echo $this->lang->line('companies'); ?></th>
			                <th width="20%"><?php echo $this->lang->line('actions'); ?></th>
			            </tr>
				    </thead>
				    	<tbody>
							<?php foreach ($output as $value) {?>
								 <tr>
									<td></td>
									<td><?php echo $value['company'];  ?></td>
									<td>
										<?php $cTitle = $value['company'];

											$quotes_detect =  preg_match('/"/', $cTitle);
											if($quotes_detect == 1)
											{
												$cTitle = str_replace(array("'", "\""), "", htmlspecialchars($cTitle));
											}
											else
											{
												$cTitle = str_replace("'","\\'", $cTitle);
											}
										?>
										<a href="javascript:void(0);" class="edit_text" onClick="editModal(<?php echo $value['ID']; ?>,<?php echo "'".$cTitle."'"; ?>)" data-id="<?php echo $value['ID']; ?>" data-name="Compay" data-title="<?php echo $value['company'];  ?>"><?php echo $this->lang->line('editComp'); ?>/ </a> 
										<a href="<?php echo base_url(); ?>master/adminlist/<?php echo $this->encryption->encode($value['ID']); ?>" class=""><?php echo $this->lang->line('listadmin'); ?> /</a> 
										<a href="<?php echo base_url(); ?>master/addstaff/<?php echo $this->encryption->encode($value['ID']); ?>"><?php echo $this->lang->line('addadmin'); ?></a>
									</td>

								</tr>
							<?php }?>
					    </tbody>
					<tfoot>
			            <tr>
							<th><?php echo $this->lang->line('serialno'); ?></th>
			                <th><?php echo $this->lang->line('companies'); ?></th>
			                <th><?php echo $this->lang->line('actions'); ?></th>
			            </tr>
			        </tfoot>
				</table>
	        </div>
	        </div>
	        </div>
	        </div>
          <!-- InstanceEndEditable --> 
          <!-- /content-wrapper --> 
       	
        <!-- /row --> 
      </div>
      <!-- /container --> 
    </div>
    <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT --> 
  </div>
</div>
<!-- Add Modal Start -->
<div id="myCompanyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title"><?php echo $this->lang->line('addcompany');?></h4>
      </div>
      <div class="modal-body">
        <input type="text" class="name_company form-control">
        <span class="error" style="color:red;"></span>
      </div>
      <div class="modal-footer">
        <img class="modal_loader" src="<?php echo base_url();?>assets/images/modal.gif" style="display:none;">
      	<button type="button" class="btn btn-success submit"><?php echo $this->lang->line('submit');?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
      </div>
    </div>

  </div>
</div>
<!-- Add Modal End-->
<!-- /wrapper --> 


<!-- Edit Modal Start -->
<div id="myEditModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Edit Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="titles">Edit Company</h4>
  </div>
  <div class="modal-body">
    <p class="name_text"></p>
    <input type="text" class="name_edit form-control" />
    <input type="hidden" class="id" value="" />
    <span class="error" style="color:red;"></span>
  </div>
	<div class="modal-footer">
	  	<button type="button" class="btn btn-success update">Update</button>
	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
	</div>
</div>
</div>


<!-- FOOTER -->
<?php $this->load->view ('inc/footer');?>
<!-- FOOTER -->


<script src="<?php echo base_url();?>assets/js/mc_js/admin/company/companycustom.js"></script>
