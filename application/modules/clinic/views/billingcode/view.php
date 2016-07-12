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
                    <!--    <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i><?php echo $this->lang->line('clinic_created'); ?> </a></li>
                                            <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-calendar"></i><?php echo $this->lang->line('clinic_access'); ?></a></li>
                                            </ul> -->

    <div class="tab-content">

          <div class="tab-pane active fade in" id="tab1">             
        <!-- end top general alert -->   


            <?php if ( $this->session->flashdata('billing_msg') ) {?>
                         
                         <div class="alert alert-success">
                         <?php echo $this->session->flashdata('billing_msg'); ?>
                          </div>
               <?php  }  ?>
        <div class="add-billbtn">
             
       <a class="btn btn-primary" href="<?php echo base_url()?>clinic/billingcodes/add">Add new billing code</a>
  
                
           </div>
          
              <!-- content-wrapper -->
          <!--div class="col-md-10 content-wrapper"--> <!-- InstanceBeginEditable name="body" -->
                    <div class="table_scroller">
               

            <table id="patientListing" class="tt view_php display table table-sorting table-hover table-bordered datatable dataTable no-footer" cellspacing="0" width="100%">
            <thead
              <tr>
                <th><?php echo $this->lang->line('name'); ?></th>
                <th><?php echo $this->lang->line('billing_code'); ?></th>
                <th><?php echo $this->lang->line('duration'); ?></th>
                <th><?php echo $this->lang->line('price'); ?></th>
                <th><?php echo $this->lang->line('gst'); ?></th>
               <th><?php echo $this->lang->line('action'); ?></th> 
               
              </tr>
            </thead>
            <tbody>
            <?php 
         // echo "<pre>";
         //          print_r($all_billing_Details);

         //          die();
                foreach($all_billing_Details as $all_billing_Detail){   
                 
              
            ?>
              <tr>
              
                <td><?php echo $all_billing_Detail->description; ?></td>
                <td><?php echo $all_billing_Detail->item_code_no; ?></td>
                <td><?php echo $all_billing_Detail->duration; ?></td>
                <td><?php echo $all_billing_Detail->price; ?></td>
                <td><?php echo $all_billing_Detail->gst; ?></td>
               <td><a href="cinic/billingcodes/edit?billing_id=<?php echo $all_billing_Detail->id; ?>" class="edit" id="<?php echo $all_billing_Detail->id; ?>"><i class="fa fa-pencil"></i></a>
               <a href="#" class="trash" id="<?php echo $all_billing_Detail->id; ?>"><i class="fa fa-trash"></i></a></td>
              
              </tr>
            <?php    } 
         
            ?>  
            </tbody>

            </table>
                      </div>
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

<!-- /wrapper --> 
<!-- FOOTER -->
<!-- FOOTER -->
<script>var baseUrl ="<?php echo base_url(); ?>";</script>
  <?php $this->load->view('inc/footer'); ?>
   <script src="<?php echo base_url();?>assets/js/mc_js/clinics/patientsearch/patientsearch.js"></script>
   <script type="text/javascript">
setTimeout(function(){
  $(".alert-success").css( "display", "none" );
}, 4000);
   </script>