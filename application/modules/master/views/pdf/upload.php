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
        <div class="col-md-12 upload_pdf med_pdf">
        <div class="col-md-6">
        	<strong><?= $this->lang->line('computer');?></strong>
        	<?php
				echo $error;
				echo form_open_multipart('master/pdf/upload', array('id' => 'pdf_form'));
				echo form_input(array('type' => 'file','name' => 'userfile'));
				echo form_submit('submit','upload');
				echo form_close();
                echo "<br>";
                echo $this->lang->line('pdf_upload_mesg');
			?>   
		</div>
		<div class="col-md-6">
			<strong><?= $this->lang->line('library');?></strong>
			<table class="table" >
        		<thead>
        			 <tr>
		                <th><?php echo $this->lang->line('file'); ?></th>
		            </tr>
        		</thead>
        		<tbody>
        			<?php if(!empty($output)) {
        				foreach ($output as $value) {
        			?>
        			<tr>
        				<?php $id = $this->encryption->encode($value['id']); ?>
        				<td><a href="<?php echo base_url();?>master/pdf/editor/<?php echo $id; ?>"><?php echo $value['pdf_name']; ?></a></td>
        			</tr>
        			<?php } }else{?>
                        <tr>
                            <td>No files in Library</td>
                        </tr>
                        <?php } ?>
        		</tbody>
        	</table>
		</div>
        </div>


    </div><!-- Row -->
</div><!-- Main Wrapper -->

<?php $this->load->view('inc/footer'); ?>
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#pdf_form').validate({
    rules: { userfile: { required: true, accept: "pdf"}},
    messages: { userfile: "Please attach PDF first." },
    
    });


</script>