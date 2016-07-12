<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
	   <h4 class="modal-title">
		<?php echo 'Reason'; ?>	
	</h4>
</div>
<div class="modal-body ">
<div data-acc-content="demo1" class="panel-body acc-open">
        <!--tab-one-start-->
     <form class ='form-horizontal form_health form-popup-main' id = 'add_medication'>
        <div class="col-md-12 form-group">
          <div class="col-md-3">
		  	<label for="medication">Medication</label>
			<textarea type="text" id="reason" class="form-control required" name="medication">
		  </div>
		  
        </div>
	
      </form>
      </div>
</div>


<script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/validation_add_medication.js"></script> 
