<?php if($this->session->flashdata('consultation_message')){?>
    <span class="alert alert-success consult_message">
  <?php echo $this->session->flashdata('consultation_message')?>
</span>
<?php } ?>
  

<?php $clinic_location = form_dropdown('clinic_location', $this->session->userdata['clinicLocations'], $this->session->userdata['clinic_location'], 'id="clinic_location", onChange="this.form.submit();"'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.contextMenu.css">
<body class="fullcalendar">
    <!-- WRAPPER -->
    <div class="wrapper c_fullcalendar"> 

        <!-- TOP BAR -->
        <?php
        //echo $this->shc_constants->tob_bar('');
        // $this->load->view ('inc/clinic_top_bar');
        ?>
        <!-- /top --> 

        <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
        <div class="bottom c_fullcalendar">
            <div class="container c_fullcalendar">
                <div class="row c_fullcalendar dash_both"> 
                    <!-- left sidebar -->
                    <style>
                        #left_clinic_minicalendar .ui-datepicker-inline.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all {
                            width: 100%;
                        }
                        .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
                            font-size: 11px;
                        }
                    </style>


                    <div class="col-md-3 c_fullcalendar left_dash"> <div id="dash-side" class="com_l_cal c_fullcalendar">
                            <div class="widget-header widget_pract display-loc">
                                <!--h3><i class="fa fa-list"></i><?php //echo $this->lang->line('appointments_left');       ?></h3-->
                                <h3><i class="fa fa-list"></i>Display</h3>

<!-- <input type='hidden' id='left_clinic_minicalendar'/> -->

                                <!-- Clinic Name Filter Start-->
                                <?php echo form_open('', array('class' => 'filter-clinic-locations','id'=>'filter-clinic-locations')); ?>
                                <label>Location</label>
                                <?php if (sizeof($myClinicName) > 0) { ?>
                                    <select name="clinic_loc_filter" class="cls_for_clinic_fliter">
                                        <?php foreach ($myClinicName as $locationClinic) { ?>
                                            <option value="<?php echo $this->encryption->encode($locationClinic->clinic_id); ?>"><?php echo $locationClinic->clinic_name . ' ,' . $locationClinic->state; ?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" name="currentdate" id="hidden_currentdate" value="<?php
                                    if (isset($this->session->userdata['filter_currentdate']) && $this->session->userdata['filter_currentdate'] != '') {
                                        echo $this->session->userdata['filter_currentdate'];
                                    }
                                    ?>" />
                                       <?php } ?>
                                       <?php echo form_submit('submit', $this->lang->line('submit'), "class='location_submit' style='display:none;'") . form_close(); ?> 

                                <div class="cal_view_cls">
                                    <label>Viewing Mode</label>
                                    <select name="cal_view" id="ID_for_cal_view">
                                        <option value="appointment_view"><?php echo $this->lang->line('appointment_view'); ?></option>
                                        <option value="roster_view"><?php echo $this->lang->line('roster_view'); ?></option>
                                    </select>
                                    <input type="hidden" name="currentdate" id="hidden_currentdate" value="<?php
                                    if (isset($this->session->userdata['filter_currentdate']) && $this->session->userdata['filter_currentdate'] != '') {
                                        echo $this->session->userdata['filter_currentdate'];
                                    }
                                    ?>" />
                                </div>
                                <!-- Clinic Name Filter End -->
                                <?php /* if(sizeof($locationPracs)>0) { ?>
                                  <div class="filter-practitioners"><span class="filter_bttn"><?php echo $this->lang->line('filter_practitioners');?></span>
                                  <?php echo form_open('',array('class' => 'filter-appnt-practitioners'));?>
                                  <div class="filter_pracs_dv">
                                  <span>
                                  <input type="checkbox" class="pracCheckboxAll" name="location_pracs_select_all" <?php if($this->session->userdata['location_pracs_all'] == '1') {?> checked="checked" <?php }?> value="select_all" /><p>Select  all</p><br /></span>
                                  <?php foreach($locationPracs as $locationPrac) { ?>
                                  <span>
                                  <input type="checkbox" class="pracCheckbox" name="location_pracs[]" value="<?php echo $this->encryption->encode($locationPrac->hp_id);?>"<?php if (in_array($this->encryption->encode($locationPrac->hp_id), $selectedPracs) || ($this->session->userdata['location_pracs_all'] == '1')) {?> checked="checked"<?php }?> /><p><?php echo $locationPrac->name.' '.$locationPrac->surname;?></p><br /></span>
                                  <?php } ?>
                                  </div>
                                  <input type="hidden" name="currentdate" id="hidden_currentdate" value="<?php if(isset($this->session->userdata['filter_currentdate']) && $this->session->userdata['filter_currentdate'] != ''){ echo $this->session->userdata['filter_currentdate']; } ?>" />
                                  <?php echo form_submit('submit', $this->lang->line('submit'),"class=''").form_close();?>
                                  </div>
                                  <?php } */ ?>
                                <?php ?>
                            </div>


                            <div class="dash-cal" id="left_clinic_minicalendar"></div>   
                        </div>
                    </div>

                    <!-- end left sidebar --> 
                    <div class="col-md-12 col-xs-12 content-wrapper practitioner_sectn appointment_dash c_fullcalendar"> <!-- InstanceBeginEditable name="body" -->
                        <!-- top general alert -->
                        <?php if ($this->session->flashdata('display_message') != '') { ?>
                            <div class="success_message"> <span><?php echo $this->session->flashdata('display_message'); ?></span></div>
                        <?php } ?>
                        <!-- end top general alert -->   
                        <div class="widget">

                        </div>
                        <?php if($this->session->flashdata('added_message_group')) { ?>
                       <div class="success_message"> <span><?php echo $this->session->flashdata('added_message_group');?></span></div>
                      <?php } ?>	
                        <div class="widget-content" style="margin-top:20px; padding-top: 5px;">

                            <?php if (sizeof($locationPracs) > 0) { ?>
                                <span id="book_another_appnt" style="display:none;"></span>
                                <div class="table-responsive c_fullcalendar"><div class="calendar"></div></div>
                            <?php
                            } 
                          
                                else { ?>
          <div class="alert alert-danger c_alert" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <?php
                    echo $this->lang->line('no_prac_assign');
                 ?>
          </div>
                <?php  } ?>

                        </div>

                    </div>
                    <!-- /row --> 
                </div>
                <!-- /container --> 
            </div>
            <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT --> 
        </div>
    </div>
    <div class="popup">
        <button type="button" style="display:none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></button>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content"></div> 
            </div>
        </div>
    </div>
    <!-- /wrapper --> 
    <!-- FOOTER -->

<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery/jquery-1.10.2.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/full_calendar/fullcalendar.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/full_calendar/fullcalendar.min.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/full_calendar/src/_loader.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/appointment/calendar.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/jquery.contextMenu.js"></script>
    <?php $this->load->view('inc/footer'); ?>

<?php if (isset($this->session->userdata['filter_currentdate']) && $this->session->userdata['filter_currentdate'] != '') { ?>
        <script>
            $(document).ready(function ()
            {
                var defaultdd = "<?php echo $this->session->userdata['filter_currentdate']; ?>";
                $.noConflict()('#left_clinic_minicalendar').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    // showOn: 'button',
                    // buttonText: 'Calendar',
                    defaultDate: new Date(defaultdd),
                    onSelect: function (selectedDate) {
                        var d = new Date(selectedDate);
                        $('.calendar').fullCalendar('gotoDate', d);
                        $('#hidden_currentdate').val(selectedDate);
                    }
                });
            });
        </script> 
<?php } else {
    ?> 
        <script>
            $(document).ready(function ()
            {
                $.noConflict()('#left_clinic_minicalendar').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    // showOn: 'button',
                    // buttonText: 'Calendar',
                    onSelect: function (selectedDate) {
                        var d = new Date(selectedDate);
                        $('.calendar').fullCalendar('gotoDate', d);
                        $('#hidden_currentdate').val(selectedDate);
                    }
                });
            });
        </script> 
<?php } ?>
    <script type="text/javascript">
        var value_option = "<?php echo $this->session->userdata['clinic_location']; ?>";
        $(".cls_for_clinic_fliter").val(value_option).change();

        var value_view = "<?php echo $this->session->userdata['view_calendar']; ?>";
        $("#ID_for_cal_view").val(value_view).change();
		
		
		jQuery(document).ready(function(){
		
		jQuery( ".cls_for_clinic_fliter" ).change(function() {

		jQuery( ".location_submit" ).trigger( "click" );
			});

			});
		
    </script>

    <!-- FOOTER -->

 <script src="<?php echo base_url();?>assets/js/mc_js/clinics/appointment/bootstrap-dialog.min.js"></script>