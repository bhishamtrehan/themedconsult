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
        	<table class="display table" style="width: 100%; cellspacing: 0;">
        		<thead>
        			 <tr>
		                <th><?php echo $this->lang->line('file'); ?></th>
		                <th><?php echo $this->lang->line('action');?></th>
		            </tr>
        		</thead>
        		<tbody>
        			<?php if(!empty($output)) {
        				foreach ($output as $value) {
        			?>
        			<tr>
        				<td><?php echo $value['pdf_name']; ?></td>
        				<?php $id = $this->encryption->encode($value['id']); ?>
        				<td><a href="<?php echo base_url();?>master/pdf/editor/<?php echo $id; ?>">Edit Pdf</a></td>
        			</tr>
        			<?php } }else{?>
                        <tr>
                            <td>No data</td>
                        </tr>
                        <?php } ?>
        		</tbody>
        	</table>
        </div>
    </div><!-- Row -->
</div><!-- Main Wrapper -->
<?php $this->load->view('inc/footer'); ?>
