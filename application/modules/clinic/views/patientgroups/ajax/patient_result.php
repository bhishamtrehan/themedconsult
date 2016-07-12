<table id="patientResult" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th><?php echo $this->lang->line('patient_picture'); ?></th>
      <th><?php echo $this->lang->line('surname'); ?></th>
      <th><?php echo $this->lang->line('first_name'); ?></th>
      <th><?php echo $this->lang->line('dob'); ?></th>
      <th><?php echo $this->lang->line('action'); ?></th>
    </tr>
  </thead>
  <tbody>
      <?php
      if(isset($patient_Details)){
      foreach($patient_Details as $patient_Detail){   
      ?>
      <tr>
      <td><span class="glyphicon glyphicon-user"></span> Patient </td>
      <td><?php echo $patient_Detail->last_name; ?></td>
      <td><?php echo $patient_Detail->first_name; ?></td>
      <td><?php echo $patient_Detail->date_of_birth; ?></td>
      <td><span class="glyphicon glyphicon-user"></span><?php echo $this->lang->line('profile_details'); ?>&nbsp;<span class="glyphicon glyphicon-list"></span><?php echo $this->lang->line('billing_summary'); ?>&nbsp;<span class="glyphicon glyphicon-list"></span><?php echo $this->lang->line('consultation_history'); ?></td>
      </tr>
      <?php } } else { echo $this->lang->line('not_found'); }?>  
  </tbody>

</table>