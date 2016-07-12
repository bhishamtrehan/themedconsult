<?php
/*
Template for view admin list 
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
    	<a class="btn btn-primary" href="<?php echo base_url();?>master/addstaff/<?php echo $cId; ?>"><?php echo $this->lang->line('addadmin'); ?></a>
    </div>
    </div>
    <div class="container">
      <div class="row">
       <?php if($this->session->flashdata('display_message')!='') { ?>
           <div class="success_message"> <span><?php echo $this->session->flashdata('display_message');?></span></div>
		<?php }?>
          <div class="widget">
           
	        <div class="widget-content">
	        
				<table id="viewadmin" class="display table" style="width: 100%; cellspacing: 0;">
					<thead>
			            <tr>
			                <th><?php echo $this->lang->line('surname'); ?></th>
			                <th><?php echo $this->lang->line('firstname');?></th>
			                <th><?php echo $this->lang->line('email'); ?></th>
			                <th><?php echo $this->lang->line('medical'); ?></th>
			                <th><?php echo $this->lang->line('status'); ?></th>
			                <th><?php echo $this->lang->line('actions'); ?></th>
			            </tr>
				    </thead>
				    	<tbody>
				    		<?php if(!empty($output)){ ?>
				    		<?php foreach ($output as $value) {?>
						    <tr>
						       <td><?php echo $value['lname']; ?></td> 	
						       <td><?php echo $value['fname']; ?></td> 	
						       <td><?php echo $value['email']; ?></td> 	
						       <td></td> 	
						       <td><?php if($value['activated'] == 1){ echo "Verified";}else{ echo "Non Verified"; } ?></td>
						       <td>
						       		<?php $encode_id = $this->encryption->encode($value['id']); ?>
						       		<?php $c_id = $this->encryption->decode($cId); 
						       		$this->session->set_userdata('cid', $cId);
						       		?>
							       <a href="<?php echo base_url();?>master/edit/<?php echo $encode_id;?>"><?php echo $this->lang->line('edit'); ?></a>/
							       <?php if($value['activated'] == 1){?>
							       <a href="javascript:void(0);" onclick="deactivate(<?php echo $value['id'];?>, 0, <?php echo $c_id; ?>)"><?php echo $this->lang->line('deactivate'); ?></a>/
							       <?php }else{ ?>
							       <a href="javascript:void(0);" onclick="activate(<?php echo $value['id'];?>, 1, <?php echo $c_id; ?>)"><?php echo $this->lang->line('active'); ?></a>/
							       <?php } ?>
							       <a href="javascript:void(0);" onclick="deleteadmin(<?php echo $value['id'];?>,2, <?php echo $c_id; ?> );"><?php echo $this->lang->line('delete'); ?></a>
						       </td> 	
						    </tr>
					        <?php } } ?>
					    </tbody>
					<tfoot>
			            <tr>
			                <th><?php echo $this->lang->line('surname'); ?></th>
			                <th><?php echo $this->lang->line('firstname');?></th>
			                <th><?php echo $this->lang->line('email'); ?></th>
			                <th><?php echo $this->lang->line('medical'); ?></th>
			                <th><?php echo $this->lang->line('status'); ?></th>
			                <th><?php echo $this->lang->line('actions'); ?></th>
			            </tr>
			        </tfoot>
				</table>
	              
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
<!-- /wrapper --> 

<!-- Javascript --> 

<!-- FOOTER -->
<?php $this->load->view ('inc/footer');?>
<!-- FOOTER -->


<script src="<?php echo base_url();?>assets/js/mc_js/admin/add_admin/admincustom.js"></script>
