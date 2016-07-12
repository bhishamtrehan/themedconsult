<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/mc_js/clinics/appointment/webcam.js"></script>

<style type="text/css">
    body{
        margin:0;
        padding:0;
    }
    .img
    { background:#ffffff;
      padding:12px;
      border:1px solid #999999; }
    .shiva{
        -moz-user-select: none;
        background: #2A49A5;
        border: 1px solid #082783;
        box-shadow: 0 1px #4C6BC7 inset;
        color: white;
        padding: 3px 5px;
        text-decoration: none;
        text-shadow: 0 -1px 0 #082783;
        font: 12px Verdana, sans-serif;}


</style>


<link href="<?php echo base_url(); ?>assets/css/rangeSlider.css" rel="stylesheet"/>
<!-- <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
<?php
echo 'New Consultation';
?>	
        </h4>
</div> -->
<div class="modal-body " style="min-height: 530px;">
    <div class="panel panel-primary">
        <form id="add_clinic_form" class="add_new_clinin form-horizontal cmxform" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo base_url() ?>clinic/appointment/new_consultation" >

  <!--<input type="hidden" value="209" id="medicationappid" name="medicationappid">-->

            <div class="bs-example lf_outer">
                <?php //echo form_open('', array('class' => '','id'=>'new_consultation'));  ?>
                <div class="lf_menu col-md-3">
                    <div class="lf_inner">
                        <div class="setting-icon-left"><i class="fa fa-cog" aria-hidden="true"></i></div>
                        <ul>
                            <li><span class="lf_icon camera" data-target="#capture_popup" data-toggle="modal"></span></li>
                            <li><span class="lf_icon voice" data-toggle="modal" data-target="#audio_popup"></span></li>
                          <!--  <li><span class="lf_icon hand"></span></li>-->
                            <li><span class="lf_icon addText"></span></li>
                            <li><span class="leftbox-hover-menu"><span class="lf_icon stylus openslidemenu"></span><span class="rightbox-hover-menu" id="rightmenu1">
                                        <span class="leftbox-hovercontent">    <strong><i class="fa fa-pencil"></i> <?= $this->lang->line('pen'); ?></strong>
                                            <a class="black updateColor fa fa-check m-r-xs" href="javascript:void(0);" data-rel ="rgb(0,0,0)" ></a>
                                            <a class="red updateColor" href="javascript:void(0);" data-rel ="rgb(255,0,0)" ></a>
                                            <a class="green updateColor" href="javascript:void(0);" data-rel ="rgb(0,255,0)" ></a>
                                            <a class="blue updateColor" href="javascript:void(0);" data-rel ="rgb(0,0,255)"></a>

                                            <div class="text_range">
                                                <input type="range" value="0" data-rangeSlider>
                                                <output class="outputWrap"></output>
                  <!--<select class="updateBrushSize">
                                                               <option value="1">1</option>
                                                               <option value="5">5</option>
                                                               <option value="10">10</option>
                                                               <option value="15">15</option>
                                                               <option value="20">20</option>
                                                       </select>-->

                                            </div>
                                            <span class="leftbox-hover-close" id="colse1"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                        </span>
                                    </span></span> 

                            </li>
                            <li><span class="leftbox-hover-menu"><span class="lf_icon colorTray slidemenucolor"></span>
                                    <span class="rightbox-hover-menu" id="rightmenu2">
                                        <span class="leftbox-hovercontent">    
                                            <a style="cursor:pointer;" href="javascript:void(0);" id="text_to_img" class="text_to_img"><i class="fa fa-pencil"></i>
                                                <?php echo $this->lang->line('text'); ?></a>
                                            <a class="black updateTextColor fa fa-check m-r-xs" href="javascript:void(0);" data-rel ="rgb(0,0,0)" ></a>
                                            <a class="red updateTextColor" href="javascript:void(0);" data-rel ="rgb(255,0,0)" ></a>
                                            <a class="green updateTextColor" href="javascript:void(0);" data-rel ="rgb(0,255,0)" ></a>
                                            <a class="blue updateTextColor" href="javascript:void(0);" data-rel ="rgb(0,0,255)"></a>
                                            <div class="text_range_text">
                                                <input type="range_text" value="15" min="15" max="60" data-rangeSliderText>
                                                <output class="outputWrap"></output>
                                            </div>
                                            <input type="hidden" id="textSize">
                                            <span class="leftbox-hover-close" id="colse2"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                        </span>
                                    </span>


                                </span>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="panel-group" id="accordion">

                    <div class="panel panel-default">
                        <div  data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="panel-heading">
                            <h4 class="panel-title">
                                Health Practitioner
                            </h4>  
                        </div>
                       <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body">
                     <div class="col-xs-12 col-sm-3">
                                  <label class=" control-label" for="doctor">Health Professional :</label>	
                                    <select name="hp_id" id="hp_id" class="form-control m-b-sm">
                                        <option value="" selected="selected">Select</option>
                                        <?php foreach ($practitioner_details as $practitioner_detail) { ?>
                                            <option value="<?php echo $practitioner_detail->hp_id; ?>"><?php echo $practitioner_detail->title . ' ' . $practitioner_detail->name . ' ' . $practitioner_detail->surname; ?></option>
                                                                                    </select>
                              <input type="hidden" name="hp_name" value="<?php echo $practitioner_detail->name; ?>"/>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                       <label class=" control-label" for="speciality">Speciality :</label>

                                        <select name="speciality" id="speciality" class="form-control m-b-sm">
                                             <option value="" selected="selected">Select</option>

                                            <option value="1"><?php echo $practitioner_detail->speciality; ?></option>

                                        </select>

                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                    <label class=" control-label" for="consultation_type">Consultation Type :</label>

                                        <select name="consultation_type" id="consultation_type" class="form-control m-b-sm">
                                            <option value="" selected="selected">Select</option>
                                            <option value="1">Dental Consult </option>
                                            <option value="2">General Practitioner Consult</option>
                                            <option value="3">Hospital Discharge Summary Notes</option>
                                        </select>
                                    </div>

                                    <div class="col-xs-12 col-sm-3">
                                    <label class=" control-label" for="medical_clinic">Medical Practice/Clinic :</label>	

                                        <select name="medical_clinic" id="medical_clinic" class="form-control m-b-sm">
                                            <option value="" selected="selected">Select</option>
                                            <option value="1"><?php echo $practitioner_detail->clinic_name; ?></option>

                                        </select>
                                    </div>


                                <?php } ?>
                                <div class="col-sm-12">
                                    <a data-parent="#accordion" href="#problemInfo" style="margin: 15px 0; " class="btn btn-all pull-right continue">Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----panel 1 end here------->
                    <div class="panel panel-default">
                        <div  data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="panel-heading">
                            <h4 class="panel-title">
                                Clinical Notes
                            </h4> 
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel">


                            <div class="panel-body">

                <!--<input type="file" value="" data-rel="fileToUpload2" id="fileToUpload2" class="browse  fileToUpload2 NFI-current" name="fileToUpload2"> <div>Show app pdf file </div>-->
                                <!-- PDF editor -->
                                <div id="main-wrapper" class="container">
                                    <div class="row">
                                        <div class="col-md-12" id="full">
                                            <div class="editor_row_top" style="overflow: hidden; margin-bottom: 5px;">

                                                <!--			                <div class="column-right links col-md-3 color_col">
                                                                                            <strong><i class="fa fa-pencil"></i> <? //= $this->lang->line('pen');    ?></strong>
                                                                                            <a class="black updateColor fa fa-check m-r-xs" href="javascript:void(0);" data-rel ="rgb(0,0,0)" ></a>
                                                                                            <a class="red updateColor" href="javascript:void(0);" data-rel ="rgb(255,0,0)" ></a>
                                                                                            <a class="green updateColor" href="javascript:void(0);" data-rel ="rgb(0,255,0)" ></a>
                                                                                            <a class="blue updateColor" href="javascript:void(0);" data-rel ="rgb(0,0,255)"></a>
                                                                                            
                                                                                            <div class="text_range">
                                                                                            <input type="range" value="0" data-rangeSlider>
                                                                                                         <output class="outputWrap"></output>
                                                                                                                <select class="updateBrushSize">
                                                                                                                        <option value="1">1</option>
                                                                                                                        <option value="5">5</option>
                                                                                                                        <option value="10">10</option>
                                                                                                                        <option value="15">15</option>
                                                                                                                        <option value="20">20</option>
                                                                                                                </select></div>
                                                                                        </div>-->
                                                <!--			                <div class="column-left links col-md-3 text_col">
                                                                                            <strong>Add Text:</strong>
                                                                                            <a style="cursor:pointer;" href="javascript:void(0);" id="text_to_img" class="text_to_img"><i class="fa fa-pencil"></i>
                                                <?php //echo $this->lang->line('text');  ?></a>
                                                                                                                <a class="black updateTextColor fa fa-check m-r-xs" href="javascript:void(0);" data-rel ="rgb(0,0,0)" ></a>
                                                                                            <a class="red updateTextColor" href="javascript:void(0);" data-rel ="rgb(255,0,0)" ></a>
                                                                                            <a class="green updateTextColor" href="javascript:void(0);" data-rel ="rgb(0,255,0)" ></a>
                                                                                            <a class="blue updateTextColor" href="javascript:void(0);" data-rel ="rgb(0,0,255)"></a>
                                                                                                                <div class="text_range_text">
                                                                                                <input type="range_text" value="15" min="15" max="60" data-rangeSliderText>
                                                                                                                <output class="outputWrap"></output>
                                                                                                                </div>
                                                                                                                <input type="hidden" id="textSize">
                                                                                        </div>-->


                                                <div class="column-left links col-md-3 undo_redo_col">
                                                    <button style="cursor:pointer;" onclick="javascript:cUndo();
                                                            return false;"><i class="fa fa-undo"></i>
                                                    </button>
                                                    <button style="cursor:pointer;" onclick="javascript:cRedo();
                                                            return false;"><i class="fa fa-repeat"></i>
                                                    </button>
                                                    <!-- <button id="eraser">Eraser</button> -->
                                                </div>


                                                <div class="column-left links col-md-3 save_col" >
                                                    <a href="javascript:void(0);" class="download_pdf">Save<?php //$this->lang->line('save');    ?></a>
                                                    <a href="javascript:void(0);" class="print"><?= $this->lang->line('print'); ?></a>
                                                </div>
                                                <div class="column-left links col-md-3 save_col_full none_display">
                                                    <a href="javascript:void(0)" onclick="full_exit();"><?= $this->lang->line('pdf_exit'); ?></a>
                                                </div>


                                            </div>
                                            <input type="hidden" id="orgImg" value="<?php echo base_url() . 'assets/uploads/' . $userName . '_' . $enc . '/' . $image; ?>" />
                                            <div class="ipad">
                                                <div id="can_wrap" style="position:relative; ">
                                                    <span class="full_screen_icon">
                                                        <a href="javascript:void(0)" id="fullscreen"><i class="fa fa-arrows-alt"></i></a></span>
                                                    <canvas id="test" style="border: 1px solid;" width="500" height="250"></canvas>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- Row -->
                                </div><!-- Main Wrapper -->

                                <!-- editor end	 -->
                                <div class="container"><a class="btn btn-all" href="#collapseOne" data-parent="#accordion">Previous</a>
                                    <a data-parent="#accordion" href="#problemInfo" class="btn btn-all pull-right continue">Continue</a></div>

                            </div> </div></div>



                    <div class="panel panel-default">
                        <div  data-toggle="collapse" data-parent="#accordion" href="#collapseSix" class="panel-heading">
                            <h4 class="panel-title">
                                Media Library
                            </h4> 
                        </div>
                        <div id="collapseSix" class="panel-collapse collapse">
                            <div class="panel-body">                     	
                                <!-- <div id="outer" style="margin:0px; width:100%; height:90px;background-color:#3B5998;">
                                </div> -->
                                <div class="container">
                                    <!-- Trigger the modal with a button -->
                                    <button type="button" class="btn btn-all btn-lg" data-toggle="modal" data-target="#capture_popup">Capture Image</button>

                            <!--<button type="button" data-toggle="modal" data-target="#capture_popup777">Open Modal</button>-->
                                    <div id="img">

                                        <div class="theimage"></div>
                                    </div>

                                    <p>
                                    <div class="fields dobFieldsNext2 uplodeimgsec">
                                        <label>Upload Image</label>
                                        <input type="file" id="files" name="mediafiles[]" multiple />

                                        <output id="list"></output>
                                    </div>
                                    </p>
                                </div>

                                <div class="container"><a class="btn btn-all" data-parent="#accordion" href="#collapseTwo">Previous</a>
                                    <a data-parent="#accordion" href="#problemInfo" class="btn btn-all pull-right continue">Continue</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div  data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="panel-heading">
                            <h4 class="panel-title">
                                Investigation
                            </h4> 
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="container">
                                    <p>

                                        <a href="" class="btn btn-all">Add Investigation</a>


                                        <!-- <button type="submit">Radiology</button>
                                        <button type="submit">Pathology</button> -->


                                    <div class="border-arround">
                                        <div class="border-title">Investigation 1</div>
                                        <div class="padding-arround">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label for="serviceprovider">Service Provider: </label>
                                                        <input type="text" name="serviceprovider" class="form-control" id="serviceprovider" placeholder="Enter service provider">

                                                    </fieldset>
                                                    <input type="hidden" class="form-control" id="serviceprovider_by_search" value="" placeholder="Enter text">

                                                    <div class="search_serviceprovider"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <fieldset class="form-group">
                                                        <label for="type_of_investigation">Type of Investigation</label>
                                                        <input type="text" class="form-control" name="type_of_investigation" id="type_of_investigation" placeholder="Enter text">
                                                    </fieldset>
                                                </div>
                                            </div>





                                            <fieldset class="form-group">
                                                <label for="exampleTextarea">Clinical Notes:</label>
                                                <textarea class="form-control" name="clinical_notes" id="clinical_notes" rows="3"></textarea>
                                            </fieldset>


                                            <div class="uploadImage">
                                                <div class="searchBar">
                                                    <div id="fileToUpload" data-rel="fileToUpload" class="browse fileToUpload  fileupbtn"><div class="NFI-button NFI14661537616486172">Attach Media
                                                            <input type="file" value="" data-rel="fileToUpload1" id="fileToUpload1" class="browse  fileToUpload1a NFI-current" name="investigation"></div>
                                                            <!--<input name="investigator_image" type="hidden" value="" id="investigator_image">-->
                                                        <p class="fileError" id="errorFile"></p>

                                                    </div>
                                                </div>
                                                <div class="imgpreview"></div>
                                            </div>




                                            </p>
                                        </div></div>



                                    <p>

                                        <a href="" class="btn btn-all">Add Refferal</a>


                                        <!-- <button type="submit">Radiology</button>
                                        <button type="submit">Pathology</button> -->


                                    <div class="border-arround">
                                        <div class="border-title">Investigation 1</div>
                                        <div class="padding-arround">
                                            <div class="row">
                                                <div class="col-md-6"> <fieldset class="form-group">
                                                        <label for="serviceprovider">Title: </label>
                                                        <input type="text" class="form-control" name="refferal_title" id="refferal_title" placeholder="Enter service provider">

                                                    </fieldset></div>
                                                <div class="col-md-6">

                                                    <fieldset class="form-group">
                                                        <label for="type_of_investigation">Health Professional</label>
                                                        <input type="text" class="form-control" name="health_professional_refferal" id="health_professional_refferal" value="" placeholder="Enter text">
                                                        <input type="hidden" class="form-control" name="hp_id_by_search" id="hp_id_by_search" value="" placeholder="Enter text">
                                                        <div class="search_health"></div>
                                                    </fieldset>
                                                </div>
                                            </div>





                                            <fieldset class="form-group">
                                                <label for="exampleTextarea">Clinical Notes:</label>
                                                <textarea class="form-control" name="refferal_notes" id="refferal_notes" rows="3"></textarea>
                                            </fieldset>
                                            <div class="uploadImage">
                                                <div class="searchBar">
                                                    <div id="fileToUpload" data-rel="fileToUpload" class="browse fileToUpload fileupbtn"><div class="NFI-button NFI14661537616486172">Attach Media
                                                            <input type="file" value="" data-rel="fileToUpload2" id="fileToUpload2" class="browse  fileToUpload2a NFI-current" name="refferal"></div>
                                                    <!--	<input name="refferal_image" type="hidden" value="" id="refferal_image">-->
                                                        <p class="fileError" id="errorFile"></p>

                                                    </div>
                                                </div>
                                                <div class="imgpreview"></div>
                                            </div>







                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="container"><a class="btn btn-all" data-parent="#accordion" href="#collapseSix">Previous</a>
                                    <a data-parent="#accordion" href="#problemInfo" class="btn btn-all pull-right continue">Continue</a></div>
                            </div>

                        </div>
                    </div>



                    <div class="panel panel-default">
                        <div  data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="panel-heading">
                            <h4 class="panel-title">
                                Billing Codes
                            </h4> 
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>
                                <div class="col-sm-12">

                                    <div class="showbillingselected">
                                        <table width="100%" border="1" cellspacing="0" id="selecteddata" cellpadding="2">

                                        </table>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <label for="Description">Description</label>
                                            <input type="text" placeholder="Description" id="description"  name="description" class="form-control billing">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Item Code Number">Item Code Number</label>
                                            <input type="text" placeholder="Item Code Number" id="item_code_no"  name="codeno" class="form-control billing">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Price">Price</label>
                                            <input type="text" placeholder="Price" id="price" class="form-control billing" name="price">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="GST">GST</label>
                                            <input type="text" placeholder="GST" id="gst"  class="form-control billing" name="gst">
                                        </div>
                                    </div>


                                    <input type="hidden" name="billing_detail" class="form-control" id="billing_detail" value="">
                                    <div class="showbillingdata"></div>
                                </div>
                                <!--  <div class="col-sm-4 blue-text col-sm-offset-5 healthp"><a class="anothercode" href="javascript:;">+ add billing code</a></div>-->
                                </p>
                                <div class="container"><a class="btn btn-all" href="#collapseThree" data-parent="#accordion">Previous</a>
                                    <a data-parent="#accordion" href="#problemInfo" class="btn btn-all pull-right continue cont">Continue</a></div>

                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div  data-toggle="collapse" data-parent="#accordion" href="#collapseFive" class="panel-heading">
                            <h4 class="panel-title">
                                Status
                            </h4> 
                        </div>
                        <div id="collapseFive" class="panel-collapse collapse public-patient-sec">
                            <div class="panel-body">
                                <p>
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group">


                                            <input type="checkbox"  <?php
                                            if (empty($_POST["public_access"])) {
                                                echo "value='1'";
                                            } else {
                                                echo "value=''";
                                            }
                                            ?> name="public_access" id="public_access" class="form-control">
                                            <label class="col-sm-5 control-label" for="inputEmail3">Public Access :</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">


                                            <input type="checkbox" <?php
                                            if (empty($_POST["patient_access"])) {
                                                echo "value='1'";
                                            } else {
                                                echo "value=''";
                                            }
                                            ?> name="patient_access" id="patient_access" class="form-control">
                                            <label class="col-sm-5 control-label" for="inputEmail3">Patient Access:</label>
                                        </div>
                                    </div>



                                </div>


                                </p>
                                <div class="container"><a class="btn btn-all" href="#collapseFour" data-parent="#accordion">Previous</a>
                                    <a data-parent="#accordion" href="#problemInfo" class="btn btn-all pull-right continue all_fields_valid">Continue</a></div>
                            </div>


                        </div>
                    </div>
                        <input name="appointment_id" value="<?php echo $appt_id; ?>" type="hidden">
                    <input type="hidden" name="pdfImgBase64" id="pdfImageType" value="">
                    <button class="btn btn-all submit_newconsult" style="display:none;" type="submit">Submit</button>
       <!-- <input class="submit" type="submit" class= value="Submit">-->
                </div>
                <?php //echo form_submit('submit', $this->lang->line('submit'), "class='btn btn-default submit_newconsult'") . form_close();  ?> 
                <div class="successmsg"></div>
            </div>
    </div>
</form>
</div>
</div>
<?php $this->load->view('inc/footer_modal'); ?>

<!--Audio Popup-->

<div class="modal fade" id="audio_popup" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Save Your Audio Here</h4>
            </div>
            <div class="modal-body">
                <div class="popup_section">

                    <div id="main" style="/*height:800px; width:100%*/">
                        <div id="content" style="float:left; /*width:500px; margin-left:50px; margin-top:20px;*/" align="center">
                            <div class="container">

                                <script type="text/javascript" src="<?php echo base_url(); ?>recorder/html/js/swfobject.js"></script>
                                <script type="text/javascript" src="<?php echo base_url(); ?>recorder/html/js/recorder.js"></script>
                                <script type="text/javascript" src="<?php echo base_url(); ?>recorder/html/basic/basic.js"></script>
                                <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>recorder/html/basic/basic.css">
                                <section class="recorder-container">

                                    <!-- Recorder control buttons -->
                                    <div class="recorder">
                                        <button class="start-recording" onclick="FWRecorder.record('audio', 'audio.wav');">
                                            <img src="<?php echo base_url(); ?>recorder/html/images/record.png" alt="Record">
                                        </button>
                                        <div class="level">
                                            <div class="progress"></div>
                                        </div>
                                        <button class="stop-recording" onclick="FWRecorder.stopRecording('audio');">
                                            <img src="<?php echo base_url(); ?>recorder/html/images/stop.png" alt="Stop Recording"/>
                                        </button>
                                        <button class="start-playing" onclick="FWRecorder.playBack('audio');" title="Play">
                                            <img src="<?php echo base_url(); ?>recorder/html/images/play.png" alt="Play"/>
                                        </button>
                                        <div class="upload" style="display: inline-block">
                                            <div id="flashcontent">
                                                <p>Your browser must have JavaScript enabled and the Adobe Flash Player installed.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden form for easy specifying the upload request parameters -->
                                    <form id="uploadForm" name="uploadForm" action="<?php echo base_url(); ?>clinic/appointment/upload_audio_files">
                                        <input name="authenticity_token" value="xxxxx" type="hidden">
                                        <input name="upload_file[parent_id]" value="1" type="hidden">
                                        <input name="appt_id" value="<?php echo $appt_id; ?>" type="hidden">


                                        <input name="format" value="json" type="hidden">
                                    </form>
                                </section>

                            </div>


                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>

    <!--Audio Popup Ends here->

    <!-- Capture Modal -->
    <div class="modal fade" id="capture_popup" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Camera</h4>
                </div>
                <div class="modal-body">
                    <div class="popup_section">
                        <script language="JavaScript">
                            document.write(webcam.get_html(440, 240));
                        </script>
                        <div id="main" style="/*height:800px; width:100%*/">
                            <div id="content" style="float:left; /*width:500px; margin-left:50px; margin-top:20px;*/" align="center">
                            </div>
                            <form>
                                <br />

                                                        <!--<input type="button" value="Configure settings" onClick="webcam.configure()" class="shiva">-->
                                &nbsp;&nbsp;
                                <input type="button" value="Take Snapshot" onClick="take_snapshot()" class="shiva">
                            </form>


                        </div>

                    </div>
                </div>
                <!-- <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 </div>-->
            </div>

        </div>
    </div>


    <!-- Capture Modal -->
    <script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/mc_js/clinics/ajaxfileupload.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/appointment/newconsult.js"></script>

    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/jspdf.js"></script>
    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/html2canvas.js"></script>
    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/canvas2image.js"></script>
    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/screenfull.js"></script>
    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/UndoRedo.js"></script>
    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/rangeSlider.js"></script>
    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/customjs.js"></script>
    <script src="<?php echo base_url() ?>assets/js/mc_js/editor/customtextsize.js"></script>

    <script type="text/javascript">
     jQuery(document).ready(function () {

 // $( "#list > span" ).click(function() {
    $( "#list" ).delegate( "span", "click", function() {
           // alert('tesdt');
  //alert('test');
$(this).remove();
});
});
    </script>
    <script>
        jQuery(document).ready(function () {
            $("#colse1").click(function () {
                $('#rightmenu1.activemenu').animate({"width": "-0"}, 1000);
                $('#rightmenu1.activemenu').removeClass('activemenu');

            });
            $(".openslidemenu").click(function () {
                $('#rightmenu1').animate({"width": "200px"}, 1000);
                $('#rightmenu1').addClass('activemenu');

            });
            $("#colse2").click(function () {
                $('#rightmenu2.activemenu').animate({"width": "-0"}, 1000);
                $('#rightmenu2.activemenu').removeClass('activemenu');

            });
            $(".slidemenucolor").click(function () {
                $('#rightmenu2').animate({"width": "200px"}, 1000);
                $('#rightmenu2').addClass('activemenu');

            });

        });

    </script>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("#hp_id").select2();
            jQuery("#speciality").select2();
            jQuery("#consultation_type").select2();
            jQuery("#medical_clinic").select2();
        });

    </script>
    <script type="text/javascript">

        $(document).ready(function ()
        {
            InitThis();
            $("#test").jqScribble();
            $(addImage);


            /* Eraser Function */
            var canvas = document.getElementById("test");
            var ctx = canvas.getContext("2d");
            var lastX;
            var lastY;
            var mouseX;
            //var mode = 'pen';
            var mouseY;
            var canvasOffset = $("#test").offset();
            var offsetX = canvasOffset.left;
            var offsetY = canvasOffset.top;
            var isMouseDown = true;
            var parentOffset = $('#test').offset();

            function handleMouseDown(e) {
                mouseX = e.originalEvent.pageX - parentOffset.left;
                mouseY = e.originalEvent.pageY - parentOffset.top;
                //mouseX=parseInt(e.clientX-offsetX);
                //mouseY=parseInt(e.clientY-offsetY);

                // Put your mousedown stuff here
                lastX = mouseX;
                lastY = mouseY;
                isMouseDown = true;
            }

            function handleMouseUp(e) {
                mouseX = e.originalEvent.pageX - parentOffset.left;
                mouseY = e.originalEvent.pageY - parentOffset.top;
                //mouseX=parseInt(e.clientX-offsetX);
                //mouseY=parseInt(e.clientY-offsetY);

                // Put your mouseup stuff here
                isMouseDown = false;
            }

            function handleMouseOut(e) {
                mouseX = e.originalEvent.pageX - parentOffset.left;
                mouseY = e.originalEvent.pageY - parentOffset.top;
                //mouseX=parseInt(e.clientX-offsetX);
                //mouseY=parseInt(e.clientY-offsetY);

                // Put your mouseOut stuff here
                isMouseDown = false;
            }

            function handleMouseMove(e) {
                mouseX = e.originalEvent.pageX - parentOffset.left;
                mouseY = e.originalEvent.pageY - parentOffset.top;

                //mouseX=parseInt(e.clientX-offsetX);
                //mouseY=parseInt(e.clientY-offsetY);

                // Put your mousemove stuff here
                if (isMouseDown) {
                    ctx.beginPath();

                    if (mode == "pen") {
                        ctx.globalCompositeOperation = "source-over";
                        ctx.moveTo(lastX, lastY);
                        ctx.lineTo(mouseX, mouseY);
                        ctx.stroke();
                    } else {

                        ctx.globalCompositeOperation = "destination-out";
                        ctx.fillStyle = "#3370d4"; //blue
                        ctx.arc(lastX, lastY, 5, 0, Math.PI * 2, false);

                        ctx.fill();
                    }
                    lastX = mouseX;
                    lastY = mouseY;
                }
            }

            //$("#test").mousedown(function(e){handleMouseDown(e);});
            //$("#test").mousemove(function(e){handleMouseMove(e);});
            //$("#test").mouseup(function(e){handleMouseUp(e);});
            //$("#test").mouseout(function(e){handleMouseOut(e);});


            $("#eraser").on('click touchstart', function () {
                ctx.globalCompositeOperation = "destination-out";
                ctx.fillStyle = "#3370d4"; //blue
                ctx.arc(lastX, lastY, 5, 0, Math.PI * 2, false);
                ctx.fill();
            });

            $("#text_to_img").click(function () {
                mode = "pen";
            });
            $("#updateColor").click(function () {
            });
        });

        function save()
        {
            jQuery("#test").data("jqScribble").save(function (imageData)
            {
                if (confirm("This will write a file using the example image_save.php. Is that cool with you?"))
                {
                    jQuery.post('image_save.php', {imagedata: imageData}, function (response)
                    {
                        jQuery('body').append(response);
                    });
                }
            });
        }
        function addImage()
        {
            //var img = prompt("Enter the URL of the image.");
            var tmpImg = new Image();
            var img = "<?php echo base_url() ?>/assets/uploads/1458197012-0.jpg";
            tmpImg.src = img;

            $(tmpImg).one('load', function () {
                orgHeight = tmpImg.height;
                orgWidth = tmpImg.width;

                if (orgWidth <= '1170')
                {
                    orgWidth = orgWidth;
                }
                else
                {
                    orgWidth = '1170';
                }

                jQuery("#test").attr('height', orgHeight);
                jQuery("#test").attr('width', orgWidth);
                jQuery("#can_wrap").css('height', orgHeight);
                //jQuery("#can_wrap").css('width',orgWidth);
                jQuery("#can_wrap").css('width', '100%');



                jQuery("#test").data("jqScribble").update({backgroundImage: img});

            });
        }

    </script>

    <script type="text/javascript">
        $('.download_pdf').on('click ', function ()
        {


            $('#full').removeClass('nowscroll');
            screenfull.exit();

            $('.delText').css('display', 'none');

            $my_view = $('#test');
            var useHeight = $('#can_wrap').prop('scrollHeight');

            html2canvas($my_view[0], {
                height: useHeight + 1000,
                useCORS: true,
                allowTaint: true,
                onrendered: function (canvas) {
                    var imgSrc = canvas.toDataURL("image/jpeg");

                    var imgWidth = 210;
                    var pageHeight = 300;
                    var imgHeight = canvas.height * imgWidth / canvas.width;
                    var heightLeft = imgHeight;

                    var doc = new jsPDF('p', 'mm');
                    var position = 0;

                    doc.addImage(imgSrc, 'JPEG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;

                    while (heightLeft >= 0) {
                        position = heightLeft - imgHeight;
                        doc.addPage();
                        doc.addImage(imgSrc, 'JPEG', 0, position, imgWidth, imgHeight);
                        heightLeft -= pageHeight;
                    }

                    //	doc.save( 'file.pdf');

                    var dataURL = canvas.toDataURL();
                    $('#pdfImageType').val(dataURL);




                }
            });


            //}, 2000);

        });


    </script>
    <script>
        $('#text_to_img').on('click touchstart', function () {

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('#test').removeClass('cursorText');
                var col = $('.fa-check').attr('data-rel');
                $("#test").data("jqScribble").update({brushColor: col});
            } else {
                var textover_api;
                $(this).addClass('active');
                $('#handScroll').removeClass('fa fa-check m-r-xs');
                $('#test').addClass('cursorText');
                $("#test").data("jqScribble").update({brushColor: 'transparent'});
                $('#test').TextOver({}, function () {
                    textover_api = this;

                });
            }

        });


        $(document).ready(function () {
            $('.updateColor').on('click', function () {

                $('#text_to_img').removeClass('active');
                $('#test').removeClass('cursorText');
                var val = $(this).attr('data-rel');
                $('.updateColor').removeClass('fa fa-check m-r-xs');
                $(this).addClass('fa fa-check m-r-xs');
                $("#test").data("jqScribble").update({brushColor: val});

            });

            $('.updateTextColor').on('click', function () {

                $('#text_to_img').addClass('active');
                $('#test').addClass('cursorText');
                var val = $(this).attr('data-rel');
                $('.updateTextColor').removeClass('fa fa-check m-r-xs');
                $(this).addClass('fa fa-check m-r-xs');
                $("#test").data("jqScribble").update({brushColor: 'transparent'});
                $('#test').TextOver({}, function () {
                    textover_api = this;

                });
            });

            $('.updateBrushSize').change(function () {

                var val = $(this).val();
                $("#test").data("jqScribble").update({brushSize: val});
                //$("#test").TextOver({ 'font-size': 50 });
            })


        })

        function removeCanvasText(e) {
            e.css('display', 'none');
            e.remove();

        }
    </script>
    <script type="text/javascript">
        function full_exit()
        {
            var elem = document.getElementById("full");
            screenfull.toggle(elem);
            $('#full').toggleClass('nowscroll');
            $('.save_col').toggleClass('none_display');
            $('.save_col_full').toggleClass('block_display');
        }

        $(document).ready(function () {
            addImage();
            if (!screenfull.enabled) {
                return false;
            }
            var elem = document.getElementById("full");
            $('#fullscreen').on('click', function () {
                screenfull.toggle(elem);
                $('#full').toggleClass('nowscroll');
                $('.save_col').toggleClass('none_display');
                $('.save_col_full').toggleClass('block_display');

            });

            $(document).keyup(function (e) {
                if (e.keyCode == 27) {
                    $('#full').removeClass('nowscroll');
                    $('.save_col').removeClass('none_display');
                    $('.save_col_full').removeClass('block_display');
                    $('.save_col_full').addClass('none_display');
                }
            });
            function fullscreenchange() {
                var elem = screenfull.element;

                $('#status').text('Is fullscreen: ' + screenfull.isFullscreen);

                if (elem) {
                    $('#element').text('Element: ' + elem.localName + (elem.id ? '#' + elem.id : ''));
                }

                if (!screenfull.isFullscreen) {
                    $('#external-iframe').remove();
                    document.body.style.overflow = 'auto';
                }
            }
            document.addEventListener(screenfull.raw.fullscreenchange, fullscreenchange);
            fullscreenchange();
        });



    </script>
    <script type="text/javascript">
        $('.print').on('click touchstart', function () {
            screenfull.exit();
            $('.delText').css('display', 'none');
            $('#full').removeClass('nowscroll');
            $('.delText').css('display', 'none');

            $my_view = $('#test');
            var useHeight = $('#can_wrap').prop('scrollHeight');

            html2canvas($my_view[0], {
                height: useHeight + 1000,
                useCORS: true,
                allowTaint: true,
                onrendered: function (canvas) {
                    var imgSrc = canvas.toDataURL("image/jpeg");
                    var windowContent = '<!DOCTYPE html>';
                    windowContent += '<html>'
                    windowContent += '<head><title></title></head>';
                    windowContent += '<body>'
                    windowContent += '<img src="' + imgSrc + '">';
                    windowContent += '</body>';
                    windowContent += '</html>';
                    var printWin = window.open('', '', 'width=500,height=500');
                    printWin.document.write(windowContent);
                    setTimeout(function () {
                        printWin.document.close();
                        printWin.focus();
                        printWin.print();
                        printWin.close();
                    }, 20);


                }
            });
        });
    </script>
    <script>

        $('.continue').click(function (e) {

            e.preventDefault();
            var sectionValid = true;
            var collapse = $(this).closest('.panel-collapse.collapse');
            $.each(collapse.find('input, select, textarea'), function () {
                if (!$(this).valid()) {
                    sectionValid = false;
                }
            });
            if (sectionValid) {
                collapse.collapse('toggle');
                collapse.parents('.panel').next().find('.panel-collapse.collapse').collapse('toggle');
            }
        });

        $('a[href="#collapseOne"]').click(function (e) {
            e.preventDefault();
            $('#collapseTwo').collapse('toggle');
            $('#collapseOne').collapse('toggle');
        });

        $('a[href="#collapseTwo"]').click(function (e) {
            e.preventDefault();
            $('#collapseSix').collapse('toggle');
            $('#collapseTwo').collapse('toggle');
        });

        $('a[href="#collapseSix"]').click(function (e) {
            e.preventDefault();
            $('#collapseThree').collapse('toggle');
            $('#collapseSix').collapse('toggle');
        });





        $('a[href="#collapseThree"]').click(function (e) {
            e.preventDefault();
            $('#collapseFour').collapse('toggle');
            $('#collapseThree').collapse('toggle');
        });

        $('a[href="#collapseFour"]').click(function (e) {
            e.preventDefault();
            $('#collapseFive').collapse('toggle');
            $('#collapseFour').collapse('toggle');
        });





        $(".cmxform").validate({
            errorClass: "error text-warning",
            validClass: "success text-success",
            highlight: function (element, errorClass) {
                //alert('em');
                //$(element).fadeOut(100,function () {
                //$(element).fadeIn(100);
                // });
            },
            rules: {
                hp_id: "required",
                speciality: "required",
                consultation_type: "required",
                medical_clinic: "required",
                serviceprovider: "required",
                type_of_investigation: "required",
                clinical_notes: "required",
                refferal_title: "required",
                health_professional_refferal: "required",
                refferal_notes: "required",
            },
            submitHandler: function (form) {
                // var a = $(form).serialize();
                $(".cmxform").submit();
                //alert(a);
            },
        });

        $(".all_fields_valid").click(function () {
            $(".submit_newconsult").css("display", "block");
        });

    </script>
    <script type ="text/javascript" >
        webcam.set_api_url('<?php echo base_url(); ?>assets/js/webcam/handleimage.php');
        webcam.set_quality(90); // JPEG quality (1 - 100)
        webcam.set_shutter_sound(true); // play shutter click sound
        webcam.set_hook('onComplete', 'my_completion_handler');
        function take_snapshot() {
            // take snapshot and upload to server
            //document.getElementById('img').innerHTML = '<h1>Uploading...</h1>';
            webcam.snap();
        }

        function my_completion_handler(msg) {
            // extract URL out of PHP output
            if (msg.match(/(http\:\/\/\S+)/)) {
                // show JPEG image in page
                //document.getElementById('img').innerHTML ='<h3>Upload Successfuly done</h3>'+msg;

                $("#img").append("<img src=" + msg + " class=\"img\">");
                $("#img").append("<input type=\"hidden\" value=" + msg + " name=\"media[]\">");


                //  document.getElementById('img').innerHTML ="<img src="+msg+" class=\"img\">";


                // reset camera for another shot
                webcam.reset();
            }
            else {
                alert("Error occured we are trying to fix now: " + msg);
            }
        }
    </script>


    <script>
        function handleFileSelect(evt) {
            var files = evt.target.files; // FileList object

            // Loop through the FileList and render image files as thumbnails.
            for (var i = 0, f; f = files[i]; i++) {

                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                var reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function (theFile) {
                    return function (e) {
                        // Render thumbnail.
                        var span = document.createElement('span');
                        span.innerHTML = ['<span class="cross-arow"><i class="fa fa-times-circle" aria-hidden="true"></i></span><img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
                        document.getElementById('list').insertBefore(span, null);
                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        }

        document.getElementById('files').addEventListener('change', handleFileSelect, false);
    </script>						
