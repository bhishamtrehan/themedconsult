<div class="page-title">
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
                
                    <div class="table-responsive">
                    	<ul class="nav nav-tabs" id="tabsclick">
						    <li class="active"><a data-toggle="tab" class="Speciality" data-id="mc_speciality" href="#speciality"><i class="fa fa-user-md"></i><?php echo $this->lang->line('speciality');?></a></li>
						    <li><a data-toggle="tab" class="Consultation" data-id="mc_consultation" href="#consultation"><i class="fa fa-user-md"></i><?php echo $this->lang->line('consultation');?></a></li>
						    <li><a data-toggle="tab" class="Languages" data-id="mc_languages" href="#languages"><i class="fa fa-language"></i><?php echo $this->lang->line('languages');?></a></li>
						    <li><a data-toggle="tab" class="Route" data-id="mc_route" href="#route"><i class="fa fa-road"></i>
<?php echo $this->lang->line('route'); ?></a></li>
						    <li><a data-toggle="tab" class="Frequency" data-id="mc_frequency" href="#frequency"><i class="fa fa-clock-o"></i>
<?php echo $this->lang->line('frequency'); ?></a></li>
					  	</ul>
					  	<div class="tab-content">
                    	<div id="speciality" class="tab-pane fade in active">
                    	<div> 
					      <a href="javascript:void(0);" onclick="openModal()" class="btn btn-primary" id="add_modal" data-name="Speciality"><?php echo $this->lang->line('add'); ?></a> 
					    </div> <br>
                        <table id="special" class="display table" style="width: 100%; cellspacing: 0;">
                         <thead>
					            <tr>
					                <th><?php echo $this->lang->line('speciality');?></th>
					                <th><?php echo $this->lang->line('actions'); ?></th>
					            </tr>
					    </thead>
					        
					        <tbody>
					        <?php if(empty($output)) {?>
					        	<!-- <td></td>
					        	<td>No data to show</td>
					        	<td></td> -->
					        <?php }else{ ?>
					        <?php foreach ($output as $value) {?>
					        <tr>
					        	
					        	<td><?php echo $value['speciality'];  ?></td>
					        	<td>
					        	<?php $cTitle = $value['speciality'];

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
						        	<a href="javascript:void(0);" onclick="editModal(<?php echo $value['ID']; ?>,<?php echo "'".$cTitle."'"; ?>, 'Speciality')" class="edit_text" data-id="<?php echo $value['ID']; ?>" data-name="Speciality" data-title="<?php echo $value['speciality'];  ?>"> <?php echo $this->lang->line('edit'); ?> / </a> 
						        	<a href="javascript:void(0);" onclick="deleteData(<?php echo $value['ID']; ?>,'Speciality')" class="delete_text" data-id="<?php echo $value['ID']; ?>" data-name="Speciality" ><?php echo $this->lang->line('delete'); ?></a>
					        	</td>
					        	
					        </tr>
					        <?php } }?>
					        </tbody>
					        
					        <tfoot>
					            <tr>
					                <th width="77%"><?php echo $this->lang->line('speciality');?></th>
					                <th width="15%"><?php echo $this->lang->line('actions'); ?></th>
					            </tr>
					        </tfoot>
                        </table>
                        </div>
                        <div id="consultation" class="tab-pane fade">

					    </div>

					    <div id="languages" class="tab-pane fade">
					      
					    </div>

					    <div id="route" class="tab-pane fade">
					     
					    </div>

					    <div id="frequency" class="tab-pane fade">
					      
					    </div>
					    </div>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- Row -->
</div><!-- Main Wrapper -->
<!-- Add Modal Start -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title"></h4>
      </div>
      <div class="modal-body">
        <p class="name_text"></p>
        <!-- <select class="select_parent form-control m-b-sm">
	    	<option value="" disabled selected>$this->lang->line('please_select_modal');</option>
	    	<option value="">test</option>
    	</select> -->
        <input type="text" class="name_add form-control"></input>
        <input type="hidden" class="term" value=""></input>
        <input type="hidden" class="status" value="1"></input>
        <span class="error" style="color:red;"></span>
        <br>
        <!-- <input type="checkbox" name="visible" value="1" id="visible"> <?php //echo $this->lang->line('visible'); ?> -->
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

<!-- Edit Modal Start -->
<div id="myEditModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Edit Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="titles"></h4>
  </div>
  <div class="modal-body">
    <p class="name_text"></p>
    <!-- <select class="select_parent form-control m-b-sm">
    	<option value="" disabled selected>$this->lang->line('please_select_modal');</option>
    	<option value=""></option>
	</select> -->
    <input type="text" class="name_edit form-control" />
    <input type="hidden" class="id" value="" />
    <input type="hidden" class="term" value="" />
    <span class="error" style="color:red;"></span>
    <br>
    <!-- <input type="checkbox" name="visible" value="1" id="visible"> <?php //echo $this->lang->line('visible'); ?> -->
  </div>
	<div class="modal-footer">
		<img class="modal_loader" src="<?php echo base_url();?>assets/images/modal.gif" style="display:none;">
	  	<button type="button" class="btn btn-success update"><?php echo $this->lang->line('update');?></button>
	    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
	</div>
	</div>
</div>
</div>
<?php 
$this->load->view('inc/footer');

?>
<script src="<?php echo base_url();?>assets/js/mc_js/admin/site_settings/customsettings.js"></script>

<!-- Edit Modal End -->