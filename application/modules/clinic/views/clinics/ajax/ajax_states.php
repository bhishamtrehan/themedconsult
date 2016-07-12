<?php 
if(isset($state_id) && $state_id!=0 && $state_id!=''){
   
    
}else{
    
    $state_id = ""; 
}
if(isset($state_list)){  ?>
        <select name="clinic_state" class="clinic_state form-control m-b-sm" onChange="getCityPostcodes(this.value);" required="required">
        <option value="">Please select state</option>
        <?php 
                if(count($state_list)>0){
                        foreach($state_list as $state){ ?>
                                <option value="<?php echo $state['state_id'];?>" <?php if($state_id==$state['state_id']) { echo "selected='selected'"; }?>><?php echo $state['state_name'];?></option>
        <?php   } 

                }	
        ?>
        </select>
<?php  }  ?>
