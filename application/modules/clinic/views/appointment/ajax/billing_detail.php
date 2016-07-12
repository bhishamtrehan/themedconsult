<div class="modal-header">
  <table style="width:100%">
  <tr>
    <th>Description</th>
    <th>Item Code Number </th>
    <th>Price</th>
    <th>Gst</th>
  </tr>
  <tr>
  <?php foreach (billing_details as billing_detail) {?>
    <td><?php echo $billing_detail->description;?></td>
    <td><?php echo $billing_detail->item_code_no;?></td>
    <td><?php echo $billing_detail->price;?></td>
    <td><?php echo $billing_detail->gst;?></td>
<?php }?>
  </tr>


</table>
	 
</div>

