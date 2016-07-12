<?php
/*
Template for adding new clinic 
*/
//Variables for clinic form fields starts here
$title_list = array(
				'Mr' =>'Mr',
				'Mrs' =>'Mrs',
				'Asst. Prof' =>'Asst. Prof',
				'Prof' =>'Prof',
				'Dr' =>'Dr'
				);
$hp_title       = form_dropdown('hp_title', $title_list, '', 'id="hp_title" class="form-control m-b-sm"');
$country_id = 'id="hp_mr_country_2" class="form-control m-b-sm"';
$country_id2 = 'id="hp_mr_country_3" class="form-control m-b-sm"';
$country_id3 = 'class="form-control m-b-sm"';
$hp_mr_country = form_dropdown('hp_mr_country', $countries, '', 'id="hp_mr_country" class="form-control m-b-sm"');


$hp_speciality = form_dropdown('hp_speciality', $specialities, '', 'id="hp_speciality" class="form-control m-b-sm" multiple');
$hp_language = form_dropdown('hp_language', $languages, '', 'id="hp_language" class="form-control m-b-sm" multiple');

$hp_status_list = array(
						'0' =>'Pending',
						'1' =>'Approved'
						);
$hp_status       = form_dropdown('hp_status', $hp_status_list, '', 'class="hp_status form-control m-b-sm" placeholder="Select status"');


$hp_declaration    = form_checkbox('hp_declaration', '', '', 'class="hp_declaration" placeholder="Select status"');

$hp_surname = array(
	'name'	=> 'hp_surname',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_surname'),
);
$hp_mr_reg_no = array(
	'name'	=> 'hp_mr_reg_no',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_reg_no'),
);
$hp_mr_issue_date = array(
	'name'	=> 'hp_mr_issue_date',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_issue_date'),
);
$hp_mr_expiry_date = array(
	'name'	=> 'hp_mr_expiry_date',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_expiry_date'),
);
$hp_mr_reg_no_2 = array(
	'name'	=> 'hp_mr_reg_no_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_reg_no'),
);
$hp_mr_issue_date_2 = array(
	'name'	=> 'hp_mr_issue_date_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_issue_date'),
);
$hp_mr_expiry_date_2 = array(
	'name'	=> 'hp_mr_expiry_date_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_expiry_date'),
);

$hp_mr_reg_no_3 = array(
	'name'	=> 'hp_mr_reg_no_3',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_reg_no'),
);
$hp_mr_issue_date_3 = array(
	'name'	=> 'hp_mr_issue_date_3',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_issue_date'),
);
$hp_mr_expiry_date_3= array(
	'name'	=> 'hp_mr_expiry_date_3',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_expiry_date'),
);

$hp_mi_reg_no = array(
	'name'	=> 'hp_mi_reg_no',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_reg_no'),
);
$hp_mi_reg_no_2 = array(
	'name'	=> 'hp_mi_reg_no_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_reg_no'),
);
$hp_mr_document = array(
	'name'	=> 'hp_mr_document_1_1',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_document'),
);
$hp_mr_document_2 = array(
	'name'	=> 'hp_mr_document_1_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_document'),
);
$hp_mr_document_2_1 = array(
	'name'	=> 'hp_mr_document_2_1',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_document'),
);
$hp_mr_document_2_2 = array(
	'name'	=> 'hp_mr_document_2_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_document'),
);
$hp_mr_document_3_1= array(
	'name'	=> 'hp_mr_document_3_1',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_document'),
);
$hp_mr_document_3_2 = array(
	'name'	=> 'hp_mr_document_3_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mr_document'),
);

$hp_mi_company = array(
	'name'	=> 'hp_mi_company',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_company'),
);

$hp_mi_number = array(
	'name'	=> 'hp_mi_number',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_number'),
);

$hp_mi_format = array(
	'name'	=> 'hp_mi_format_1_1',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_format'),
);
$hp_mi_format_2 = array(
	'name'	=> 'hp_mi_format_1_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_format'),
);

$hp_mi_company_2 = array(
	'name'	=> 'hp_mi_company_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_company'),
);

$hp_mi_number_2 = array(
	'name'	=> 'hp_mi_number_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_number'),
);

$hp_mi_format_2_1 = array(
	'name'	=> 'hp_mi_format_2_1',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_format'),
);
$hp_mi_format_2_2 = array(
	'name'	=> 'hp_mi_format_2_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_format'),
);

$hp_mi_issue_date = array(
	'name'	=> 'hp_mi_issue_date',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_issue_date'),
);
$hp_mi_expiry_date = array(
	'name'	=> 'hp_mi_expiry_date',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_expiry_date'),
);
$hp_mi_issue_date_2 = array(
	'name'	=> 'hp_mi_issue_date_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_issue_date'),
);
$hp_mi_expiry_date_2 = array(
	'name'	=> 'hp_mi_expiry_date_2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control date-picker',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mi_expiry_date'),
);


$hp_des_yes = array(
	'name'	=> 'hp_des_yes',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => '',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_des_yes'),
	'value' => '1',
);


$hp_des_no = array(
	'name'	=> 'hp_des_yes',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => '',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_des_no'),
	'value' => '0',
);
$hp_wh_des_name = array(
	'name'	=> 'hp_wh_des_name',
	'maxlength'	=> 255,
	'size'	=> 10,
	'class' => 'form-control',
	'autocomplete' => 'off',
);
$hp_name = array(
	'name'	=> 'hp_name',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_name'),
);

$hp_email = array(
	'name'	=> 'hp_email',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_email'),
	'size'	=> 30,
	'autocomplete' => 'off',
);

$hp_username = array(
	'name'	=> 'hp_username',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_username'),
	'size'	=> 30,
	'autocomplete' => 'off',
);

$clinic_street_address = array(
	'name'	=> 'clinic_street_address',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_street_add1'),
);
$clinic_street_address_line2 = array(
	'name'	=> 'clinic_street_address_line2',
	'maxlength'	=> 255,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control',
	'placeholder' => $this->lang->line('enter_street_add2'),
);
$clinic_suburb = array(
	'name'	=> 'clinic_suburb',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'clinic_suburb form-control',
	'placeholder' => $this->lang->line('enter_suburb'),
);


$clinic_state_list     	= array();
$clinic_city_list		= array();

$countries_list       = form_dropdown('country', $countries, '', 'id="country" class="form-control m-b-sm" ');
$health_practice_countries  = form_dropdown('health_practice_country', $countries, '', 'id="health_practice_country" class="form-control" ');

$clinic_state       = form_dropdown('clinic_state', $clinic_state_list, '', 'class="clinic_state form-control m-b-sm" onChange="getCityPostcodes(this.value);" placeholder="Select your state"');

$clinic_postcode = array(
	'name'	=> 'clinic_postcode',
	'maxlength'	=> 20,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'id' => 'clinic_postcode',
	'placeholder' => $this->lang->line('enter_postcode'),
);
$clinic_telephone_code = array(
	'name'	=> 'clinic_telephone_code',
	'maxlength'	=> 3,
	'size'	=> 30,
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_area_code'),
);
$clinic_telephone_no = array(
	'name'	=> 'clinic_telephone_no[]',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control',
	'placeholder' => $this->lang->line('enter_telephone'),
);

$clinic_fax_number = array(
	'name'	=> 'clinic_fax_number[]',
	'maxlength'	=> 80,
	'size'	=> 30,
	'autocomplete' => 'off',
	'class' => 'form-control',
	'placeholder' => $this->lang->line('enter_fax'),
);

$clinic_room = array(
	'name'	=> 'clinic_room[]',
	'maxlength'	=> 255,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('enter_clinic_room'),
);

$clinic_status_list = array(
						'0' =>'Pending',
						'1' =>'Approved'
						);
$clinic_status       = form_dropdown('clinic_status', $clinic_status_list, '', 'class="clinic_status form-control m-b-sm" placeholder="Select status"');

$hp_password = array(
	'name'	=> 'password',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'id'   =>  'password',
	'placeholder' => $this->lang->line('hp_password'),
);

$hp_confirm_password = array(
	'name'	=> 'confirm_password',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'id'   =>  'confirm_password',
	'placeholder' => $this->lang->line('hp_confirm_password'),
);
$hp_pin1= array(
	'name'	=> 'pin1',
	'maxlength'	=> 1,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_pin1'),
);
$hp_pin2= array(
	'name'	=> 'pin2',
	'maxlength'	=> 1,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_pin2'),
);
$hp_pin3= array(
	'name'	=> 'pin3',
	'maxlength'	=> 1,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_pin3'),
);
$hp_pin4= array(
	'name'	=> 'pin4',
	'maxlength'	=> 1,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_pin4'),
);
$hp_reminder_question= array(
	'name'	=> 'reminder_question',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_reminder_question'),
);
$hp_reminder_answer= array(
	'name'	=> 'reminder_answer',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_reminder_answer'),
);
$hp_mobile= array(
	'name'	=> 'mobile',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mobile'),
);
$hp_mobile_2= array(
	'name'	=> 'mobile_2',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_mobile_2'),
);
$hp_notifications= array(
	'name'	=> 'hp_notifications',
	'maxlength'	=> 1,
	'size'	=> 30,
	'class' => '',
	'autocomplete' => 'off',

);
$hp_notifications2= array(
	'name'	=> 'hp_notifications',
	'maxlength'	=> 1,
	'size'	=> 30,
	'class' => '',
	'autocomplete' => 'off',
	
);
$hp_prescriber_number= array(
	'name'	=> 'hp_prescriber_number',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_prescriber_number'),
	
);
$hp_prescriber_number_2= array(
	'name'	=> 'hp_prescriber_number_2',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_prescriber_number'),
	
);$hp_prescriber_number_3= array(
	'name'	=> 'hp_prescriber_number_3',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_prescriber_number'),
	
);$hp_prescriber_number_4= array(
	'name'	=> 'hp_prescriber_number_4',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_prescriber_number'),
	
);
$hp_prescriber_number_5= array(
	'name'	=> 'hp_prescriber_number_5',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_prescriber_number'),
	
);

$hp_emg_contact_title= array(
	'name'	=> 'hp_emg_contact_title',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_emg_contact_title'),
	
);
$hp_emg_contact_surname= array(
	'name'	=> 'hp_emg_contact_surname',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_emg_contact_surname'),
	
);
$hp_emg_contact_name= array(
	'name'	=> 'hp_emg_contact_name',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_emg_contact_name'),
	
);
$hp_emg_contact_email = array(
	'name'	=> 'hp_emg_contact_email',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_emg_contact_email'),
	'size'	=> 30,
	'autocomplete' => 'off',
);
$hp_emg_contact_mobile = array(
	'name'	=> 'hp_emg_contact_mobile',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_emg_contact_mobile'),
	'size'	=> 30,
	'autocomplete' => 'off',
);
$hp_emg_contact_relationship = array(
	'name'	=> 'hp_emg_contact_relationship',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_emg_contact_relationship'),
	'size'	=> 30,
	'autocomplete' => 'off',
);

$hp_emg_contact_title_2= array(
	'name'	=> 'hp_emg_contact_title_2',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_emg_contact_title'),
	
);
$hp_emg_contact_surname_2= array(
	'name'	=> 'hp_emg_contact_surname_2',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_emg_contact_surname'),
	
);
$hp_emg_contact_name_2= array(
	'name'	=> 'hp_emg_contact_name_2',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_emg_contact_name'),
	
);
$hp_emg_contact_email_2 = array(
	'name'	=> 'hp_emg_contact_email_2',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_emg_contact_email'),
	'size'	=> 30,
	'autocomplete' => 'off',
);
$hp_emg_contact_mobile_2 = array(
	'name'	=> 'hp_emg_contact_mobile_2',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_emg_contact_mobile'),
	'size'	=> 30,
	'autocomplete' => 'off',
);
$hp_emg_contact_relationship_2 = array(
	'name'	=> 'hp_emg_contact_relationship_2',
	'maxlength'	=> 80,
	'class' => 'form-control',
	'placeholder' => $this->lang->line('hp_emg_contact_relationship'),
	'size'	=> 30,
	'autocomplete' => 'off',
);

$hp_teleconsultation_yes= array(
	'name'	=> 'hp_notifications',
	'maxlength'	=> 1,
	'size'	=> 30,
	'class' => '',
	'autocomplete' => 'off',

);


$hp_teleconsultation_no= array(
	'name'	=> 'hp_notifications',
	'maxlength'	=> 1,
	'size'	=> 30,
	'class' => '',
	'autocomplete' => 'off',

);

/* Qualification Section */
$hp_ug_degree_name_1= array(
	'name'	=> 'hp_ug_degree_name_1',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_degree_name'),

);
$hp_ug_university_1= array(
	'name'	=> 'hp_ug_university_1',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_university'),

);
$hp_ug_upload_degree_1= array(
	'name'	=> 'hp_ug_upload_degree_1',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_upload_degree'),

);
$hp_ug_degree_name_2= array(
	'name'	=> 'hp_ug_degree_name_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_degree_name'),

);
$hp_ug_university_2= array(
	'name'	=> 'hp_ug_university_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_university'),

);
$hp_ug_upload_degree_2= array(
	'name'	=> 'hp_ug_upload_degree_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_upload_degree'),

);


$hp_pg_degree_name= array(
	'name'	=> 'hp_pg_degree_name_1',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_degree_name'),

);

$hp_pg_university= array(
	'name'	=> 'hp_pg_university_1',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_university'),

);
$hp_pg_upload_degree= array(
	'name'	=> 'hp_pg_upload_degree_1',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_upload_degree'),

);

$hp_pg_degree_name_2= array(
	'name'	=> 'hp_pg_degree_name_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_degree_name'),

);

$hp_pg_university_2= array(
	'name'	=> 'hp_pg_university_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_university'),

);
$hp_pg_upload_degree_2= array(
	'name'	=> 'hp_pg_upload_degree_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_ug_upload_degree'),

);
$hp_provider_number= array(
	'name'	=> 'hp_provider_number',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_number'),

);
$hp_provider_location= array(
	'name'	=> 'hp_provider_location',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_location'),

);
$hp_provider_number_2= array(
	'name'	=> 'hp_provider_number_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_number'),

);
$hp_provider_location_2= array(
	'name'	=> 'hp_provider_location_2',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_location'),

);
$hp_provider_number_3= array(
	'name'	=> 'hp_provider_number_3',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_number'),

);
$hp_provider_location_3= array(
	'name'	=> 'hp_provider_location_3',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_number'),

);
$hp_provider_number_4= array(
	'name'	=> 'hp_provider_number_4',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_number'),

);
$hp_provider_location_4= array(
	'name'	=> 'hp_provider_location_4',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_location'),

);
$hp_provider_number_5= array(
	'name'	=> 'hp_provider_number_5',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_number'),

);
$hp_provider_location_5= array(
	'name'	=> 'hp_provider_location_5',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('hp_provider_location'),

);
$health_practice_name= array(
	'name'	=> 'health_practice_name',
	'id'    => 'health_practice_name',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('health_practice_name'),

);
$health_practice_address= array(
	'name'	=> 'health_practice_address',
	'id'    => 'health_practice_address',
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'form-control',
	'autocomplete' => 'off',
	'placeholder' => $this->lang->line('health_practice_name'),

);




/* Qualification Section Ends */

//Variables for clinic form fields ends here
?>

<body>
<!-- WRAPPER -->
<div class="custom_title">
                            <div class="container">
                             <h3><?php 
                                if(isset($title)){
                                    echo $title;
                                }else{
                                    echo 'Home';
                                }
                                ?>
                            </h3>
                            </div>
                            </div>	
 <div id="main-wrapper">
 <div class="container">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <div id="rootwizard">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-info"></i><?php echo $this->lang->line('personal_info'); ?></a></li>
                                          <!--  <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-cogs"></i>Services</a></li>-->
                                            <li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-graduation-cap"></i><?php echo $this->lang->line('qualification'); ?></a></li>
                                            <li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-stethoscope"></i>
											<?php echo  $this->lang->line('health_practice');?></a></li>
                                            <li role="presentation"><a href="#tab5" data-toggle="tab"><i class="fa fa-history"></i><?php echo  $this->lang->line('work_history');?></a></li>
                                            <li role="presentation"><a href="#tab6" data-toggle="tab"><i class="fa fa-language"></i><?php echo  $this->lang->line('languages');?></a></li>
										   <li role="presentation"><a href="#tab7" data-toggle="tab"><i class="fa fa-file-text-o"></i><?php echo $this->lang->line('declaration');?></a></li>
                                        </ul>
                          
                                    
                                        <div class="progress progress-sm m-t-sm">
                                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                            </div>
                                        </div>
                                       <?php echo form_open_multipart($this->uri->uri_string(),array('class' => 'form-horizontal form_health' ,'id' => 'add_hp_form' )); ?>
                                            <div class="tab-content">
                                                <div class="tab-pane active fade in" id="tab1">
                                                    <div class="row m-b-lg">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="hp_title"><?php echo $this->lang->line('hp_title');  ?></label>
                                                                    <?php echo $hp_title; ?>
                                                                </div>
															  <div class="form-group  col-md-6 surname">
                                                                    <label for="hp_surname"><?php echo $this->lang->line('hp_surname');  ?><span class="astrik">*</span></label>
                                                                    <?php echo form_input($hp_surname); ?>
                                                                </div>
                                                                <div class="form-group  col-md-6 surname">
                                                                    <label for="hp_name"><?php echo $this->lang->line('hp_name');  ?><span class="astrik">*</span></label>
                                                                    <?php echo form_input($hp_name); ?>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="hp_email"><?php echo $this->lang->line('hp_email');  ?><span class="astrik">*</span></label>
                                                                   <?php echo form_input($hp_email); ?>
                                                                </div>
															 <div class="form-group col-md-12">
                                                                    <label for="hp_username"><?php echo $this->lang->line('hp_username');  ?><span class="astrik">*</span></label>
                                                                   <?php echo form_input($hp_username); ?>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="hp_password"><span class="astrik">*</span><?php echo $this->lang->line('hp_password');  ?></label>
                                                                    
																	<?php echo form_password($hp_password); ?>
																	
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="hp_confrim_password"><?php echo $this->lang->line('hp_confirm_password'); ?><span class="astrik">*</span></label>
                                                                   <?php echo form_password($hp_confirm_password);?>
                                                                </div>
																 <div class="form-group col-md-12">
														  <label for="hp_pin"><?php echo $this->lang->line('hp_pin');?><span class="astrik">*</span></label>
														 <div class="row">
														  <div class=" col-md-3">
														<?php echo form_password($hp_pin1); ?>
															</div>
														<div class=" col-md-3">
														<?php echo form_password($hp_pin2); ?>
														</div>
														  <div class=" col-md-3">
													<?php echo form_password($hp_pin3); ?>
														</div>
														  <div class="  col-md-3">
													<?php echo form_password($hp_pin4); ?>
														</div>
														</div>
                                                            </div>
															<div class="form-group col-md-12">
                                                          <label for="hp_question">
														  <?php echo $this->lang->line('hp_reminder_question');  ?><span class="astrik">*</span></label>
                                                           <?php echo form_input($hp_reminder_question); ?>
                                                        </div>
														<div class="form-group col-md-12">
                                                          <label for="hp_answer">
														  <?php echo $this->lang->line('hp_reminder_answer');  ?><span class="astrik">*</span></label>
                                                           <?php echo form_password($hp_reminder_answer); ?>
                                                        </div>
														
															
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                         
                                                        <div id="hp_mobile_section">
														<div class="hp_mobile_section_wrraper">
														<div class="form-group col-md-12">
                                                          <label for="hp_mobile">
														  <?php echo $this->lang->line('hp_mobile');  ?><span class="notifi_alert">(<?php echo $this->lang->line('hp_notifications');  ?>)</span></label>
                                                           <?php echo form_input($hp_mobile); ?>
                                                        </div>
														</div>
														</div>
														<div class="mobile_action">
															<div class="form-group col-md-12 custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_mobile_degree" ><i class="fa fa-plus"></i></a></span></div>
																<div class="form-group col-md-12" ><span class="cross_btn"><a href="javascript:void(0);" class="add_mobile_degree_remove" style="display:none;" ><?php echo $this->lang->line('delete');?></a></span></div>
																</div>
																												
														<div class="form-group col-md-12">
                                                          <label for="hp_country">
														  <?php echo $this->lang->line('hp_country');  ?></label>
                                                           <?php echo $countries_list; ?>
                                                        </div>
														
														
														<div id="hp_emg_contact_section">
														<div class="hp_emg_contact_section_wrraper">
														
														<h3><?php echo $this->lang->line('hp_emergency_contact');?></h3>
														<div class="form-group col-md-12">
                                                          <label for="hp_emg_contact_title"> 
														  <?php echo $this->lang->line('hp_emg_contact_title');  ?></label>
                                                           <?php echo form_input($hp_emg_contact_title); ?>
                                                        </div>
														<div class="form-group col-md-12">
                                                          <label for="hp_emg_contact_surname"> 
														  <?php echo $this->lang->line('hp_emg_contact_surname');  ?></label>
                                                           <?php echo form_input($hp_emg_contact_surname); ?>
                                                        </div>
														<div class="form-group col-md-12">
                                                          <label for="hp_emg_contact_name"> 
														  <?php echo $this->lang->line('hp_emg_contact_name');  ?></label>
                                                           <?php echo form_input($hp_emg_contact_name); ?>
                                                        </div>
														<div class="form-group col-md-12">
                                                          <label for="hp_emg_contact_email"> 
														  <?php echo $this->lang->line('hp_emg_contact_email');  ?></label>
                                                           <?php echo form_input($hp_emg_contact_email); ?>
                                                        </div>
														<div class="form-group col-md-12">
                                                          <label for="hp_emg_contact_mobile"> 
														  <?php echo $this->lang->line('hp_emg_contact_mobile');  ?></label>
                                                           <?php echo form_input($hp_emg_contact_mobile); ?>
                                                        </div>
														<div class="form-group col-md-12">
                                                          <label for="hp_emg_contact_relationship"> 
														  <?php echo $this->lang->line('hp_emg_contact_relationship');  ?></label>
                                                           <?php echo form_input($hp_emg_contact_relationship); ?>
                                                        </div>
														
														</div>
														</div>
														<div class="emg_action">
															<div class="form-group col-md-12 custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_emg_degree" ><i class="fa fa-plus"></i></a></span></div>
																<div class="form-group col-md-12" ><span class="cross_btn"><a href="javascript:void(0);" class="add_emg_degree_remove" style="display:none;" ><?php echo $this->lang->line('delete');?></a></span></div>
																</div>
														
                                                        </div>
                                                    </div>
                                                </div>
                                                
												
													<!--**************Tab-3***************888-->
                                                <div class="tab-pane fade" id="tab3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="degree_wrapper_title">
														  <h3><?php echo $this->lang->line('hp_suplmentry_doc');?></h3>
														  <h4><?php echo $this->lang->line('hp_upgrade_qualification'); ?></h4></div>
															<div id="hp_ug_degree">
																<div class="hp_ug_degree_wrraper">
																	<div class="form-group">
																		<label for="hp_ug_degree_name_1"><?php echo $this->lang->line('hp_ug_degree_name');?></label>
																		<div class="row">
																			<div class="col-md-12">
																				<?php echo form_input($hp_ug_degree_name_1);?>
																			</div>

																		</div>
																	</div>
																	<div class="form-group">
																		<label for="hp_ug_university_1"><?php echo $this->lang->line('hp_ug_university'); ?></label>
																	 <?php echo form_input($hp_ug_university_1);?>
																	</div>

																	<div class="form-group">
																		<label for="hp_ug_upload_degree_1"><?php echo $this->lang->line('hp_ug_upload_degree');?></label>
																	   <?php echo form_upload($hp_ug_upload_degree_1);?>
																	</div>
																</div>
															</div>
															<div class="ug_action">
															<div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_ug_degree" ><i class="fa fa-plus"></i><?php echo $this->lang->line('ug_section'); ?></a></span></div>
																<div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_ug_degree_remove" style="display:none;" ><?php echo $this->lang->line('delete'); ?></a></span></div>
																</div>
															
															
															
                                                            <div class="form-group ">
                                                                <h4><?php echo $this->lang->line('hp_post_graduate');?></h4>
                                                            </div>
															<div id="hp_pg_degree">
															<div class="hp_pg_degree_wrraper">
															<div class="form-group">
                                                                <label for="hp_pg_degree_name"><?php echo $this->lang->line('hp_pg_degree_name');?></label>
                                                               <?php echo form_input($hp_pg_degree_name);?>
                                                            </div>
															 <div class="form-group">
                                                                <label for="hp_pg_university"><?php echo $this->lang->line('hp_pg_university'); ?></label>
                                                             <?php echo form_input($hp_pg_university);?>
                                                            </div>
															<div class="form-group">
                                                                <label for="hp_pg_upload_degree"><?php echo $this->lang->line('hp_pg_upload_degree');?></label>
                                                               <?php echo form_upload($hp_pg_upload_degree);?>
                                                            </div>
															</div>
															</div>
																<div class="pg_action">
															<div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_pg_degree" ><i class="fa fa-plus"></i><?php echo $this->lang->line('pg_section'); ?></a></span></div>
																<div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_pg_degree_remove" style="display:none;" ><?php echo $this->lang->line('delete'); ?> </a></span></div>
																</div>
															
														   <div class="form-group">
                                                                <h4><?php echo $this->lang->line('hp_medical_registration');?></h4>
                                                            </div>
															
															<div id="hp_mr_section">
															<div class="hp_mr_section_wrraper">
															<div class="form-group">
                                                                <label for="hp_mr_country"><?php echo $this->lang->line('hp_mr_country');?></label>
                                                               <?php echo $hp_mr_country;?>
                                                            </div>
															 <div class="form-group">
                                                                <label for="hp_mr_reg_no"><?php echo $this->lang->line('hp_mr_reg_no'); ?></label>
                                                             <?php echo form_input($hp_mr_reg_no);?>
                                                            </div>
															<div class="form-group date_row">
                                                              <div class="col-md-6">
                                                                <label for="hp_mr_issue_date"><?php echo $this->lang->line('hp_mr_issue_date');?></label>
                                                                <span>
                                                               <?php echo form_input($hp_mr_issue_date);?>
                                                               <i class="fa fa-calendar"></i>
                                                               </span>
                                                               </div>
                                                                   <div class="col-md-6">
                                                               <label for="hp_mr_expiry_date"><?php echo $this->lang->line('hp_mr_expiry_date');?></label> 
                                                               <span>
                                                               <?php echo form_input($hp_mr_expiry_date);?>
                                                               <i class="fa fa-calendar"></i>
                                                               </span>
                                                               </div>
                                                               
                                                            </div>
														
															<div id="hp_mr_degree">
															<div class="hp_mr_degree_wrraper">
															<div class="form-group">
                                                                <label for="hp_mr_document"><?php echo $this->lang->line('hp_mr_document');?></label>
                                                               <?php echo form_upload($hp_mr_document);?>
                                                            </div>
															</div>
															</div>
															
															<div class="mr_document_action">
															<div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_degree" ><i class="fa fa-plus"></i></a></span></div>
																<div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_degree_remove" style="display:none;" ><?php echo $this->lang->line('delete'); ?></a></span></div>
																</div>
																</div>
																</div>
																
																<div class="mr_section_action">
															<div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_section" ><i class="fa fa-plus"></i><?php echo $this->lang->line('mr_section'); ?></a></span></div>
																<div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_section_remove" style="display:none;" ><?php echo $this->lang->line('delete'); ?>  </a></span></div>
																</div>
																
																
																
															 <div class="form-group">
                                                                <h4><?php echo $this->lang->line('hp_speciality');?></h4>
                                                            </div>
															<div class="form-group">
                                                                <label for="hp_speciality"><?php echo $this->lang->line('hp_speciality');?><span class="astrik">*</span></label>
                                                               <?php echo $hp_speciality;?>
                                                            </div>
															
														 <div class="form-group">
                                                                <h4><?php echo $this->lang->line('hp_medial_insurance');?></h4>
                                                            </div>
															
															<div id="hp_mi_section">
															<div class="hp_mi_section_wrraper">
														<div class="form-group">
                                                                <label for="hp_mi_company"><?php echo $this->lang->line('hp_mi_company');?></label>
                                                               <?php echo form_input($hp_mi_company);?>
                                                            </div>
														<div class="form-group">
                                                                <label for="hp_mi_number"><?php echo $this->lang->line('hp_mi_number');?></label>
                                                               <?php echo form_input($hp_mi_number);?>
                                                            </div>
																<div class="form-group">
                                                                <label for="hp_mi_issue_date"><?php echo $this->lang->line('hp_mi_issue_date');?></label>
                                                               <?php echo form_input($hp_mi_issue_date);?>
                                                            </div>
															<div class="form-group">
                                                                <label for="hp_mi_expiry_date"><?php echo $this->lang->line('hp_mi_expiry_date');?></label>
                                                               <?php echo form_input($hp_mi_expiry_date);?>
                                                            </div>
															<div id="hp_mi_degree">
															<div class="hp_mi_degree_wrraper">
															<div class="form-group">
																	<label for="hp_mi_format"><?php echo $this->lang->line('hp_mi_format');?></label>
																   <?php echo form_upload($hp_mi_format);?>
															</div>
															</div>
															</div>
															<div class="mi_document_action">
															<div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_mi_degree" ><i class="fa fa-plus"></i></a></div>
																<div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_mi_degree_remove" style="display:none;" ><?php echo $this->lang->line('delete'); ?> </a></span></div>
																</div>
															
														
															</div>
															</div>
															
																<div class="hp_mi_section_action">
															<div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_hp_mi_section" ><i class="fa fa-plus"></i><?php echo $this->lang->line('mi_section'); ?> </a></span></div>
																<div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_hp_mi_section_remove" style="display:none;" ><?php echo $this->lang->line('delete'); ?> </a></span></div>
																</div>
															
															<h3><?php echo $this->lang->line('prescribe_number'); ?> </h3>
															<div id="prescribe_section">
															<div class="hp_prescribe_wrraper">
															<div class="form-group">
																	<label for="hp_prescriber_country"><?php echo $this->lang->line('hp_country');?></label>
															<?php echo form_dropdown('hp_prescriber_country', $countries,'',$country_id3);?>
															</div>
															<div class="form-group">
                                                          <label for="hp_prescriber_number"> 
														  <?php echo $this->lang->line('hp_prescriber_number');  ?></label>
                                                           <?php echo form_input($hp_prescriber_number); ?>
                                                     	</div>
														</div>
														</div>
															<div class="prescribe_action">
															<div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_prescribe_section" ><i class="fa fa-plus"></i><?php echo $this->lang->line('prescriber_section');  ?></a></span></div>
																</div>
                                                                
                                                                <div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_prescribe_section_remove" style="display:none;" ><?php echo $this->lang->line('delete');  ?></a></span></div>
																
																
															<h3><?php echo $this->lang->line('medical_provider_number');  ?></h3>
															<div id="medical_provider_section">
															<div class="medical_provider_wrraper">
															<div class="form-group">
                                                          <label for="hp_provider_number"> 
														  <?php echo $this->lang->line('hp_provider_number');  ?></label>
                                                           <?php echo form_input($hp_provider_number); ?>
                                                     	</div>
														<div class="form-group">
                                                          <label for="hp_prescriber_number"> 
														  <?php echo $this->lang->line('hp_provider_location');  ?></label>
                                                           <?php echo form_input($hp_provider_location); ?>
                                                     	</div>
															
															<div class="form-group">
															<label for="hp_provider_country"><?php echo $this->lang->line('hp_country');?></label>
															<?php echo form_dropdown('hp_provider_country', $countries,'',$country_id3);?>
															</div>
															
														</div>
														</div>
														
														<div class="provider_action">
															<div class="form-group custom_new">
                                                            <span class="cross_btn"><a href="javascript:void(0);" class="add_provider_section" ><i class="fa fa-plus"></i><?php echo $this->lang->line('provider_section');?></a></span></div>
                                                            <div class="form-group">
                                                            <span class="cross_btn"><a href="javascript:void(0);" class="add_provider_section_remove" style="display:none;" ><?php echo $this->lang->line('delete');?></a></span></div>
                                                         
														
                                                        </div>
														</div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tab4">
												                                                
												<div class="row">
												   <div class="col-md-4">	
													<div class="form-group">
													<label for="health_practice_name">
													<?php echo $this->lang->line('health_practice_name');?></label>
													<?php echo form_input($health_practice_name); ?>
													</div>
													
											
												   </div>
												   <div class="col-md-4">	
													<div class="form-group">
													<label for="health_practice_country">
													<?php echo $this->lang->line('health_practice_country'); ?></label>
											<?php echo $health_practice_countries;?>
													</div>
												   </div> 
												   <div class="col-md-4">	
													<div class="form-group">
													<label for="health_practice_address">
													<?php echo $this->lang->line('health_practice_address'); ?></label>
													<?php echo form_input($health_practice_address);?>
													
													</div> 
																									
												   </div>
												<div id="clinicsRes" name="clinicsRes"></div>
								
												
												<ul id="finalResult"></ul>
												
												</div>
												
												</div>
											   <div class="tab-pane fade" id="tab5">
                                                   <div class="row">
                                                        
                                                     <div class="col-md-12">
                                                 											
													  <div class="form-group">
														<label class="control-label question-lable tab5_label" for="hp_des"><?php echo $this->lang->line('hp_des');?></label>
														<div class="tab5_radio">
														  <label class="radio-inline">
														  	<?php echo form_radio($hp_des_yes);?>
														  	<?php echo $this->lang->line('hp_teleconsultation_yes');?>
														  </label>
														  <label class="radio-inline">
														    <?php echo form_radio($hp_des_no);?>
														  	<?php echo $this->lang->line('hp_des_no');?> 
														  </label>
														</div>
													  </div>
														<div class="form-group">
                                                                <label for="hp_wh_des_name"><?php echo $this->lang->line('hp_wh_des_name'); ?></label>
                                                             <?php echo form_textarea($hp_wh_des_name);?>
                                                            </div>
													   </div>
           
                                                    </div>
                                              
                                                </div>
                                                <div class="tab-pane fade" id="tab6">
                                                   <div class="row">
														 <div class="col-md-12">
															<div class="form-group">
																<label for="hp_language"><?php echo $this->lang->line('hp_language'); ?></label>
																<?php echo $hp_language;?>
															</div>
														</div>
                                                    </div>
                                                </div>
									
												<div class="tab-pane fade" id="tab7">
                                                   <div class="row">
														 <div class="col-md-12">
															<div class="form-group">
																<label><?php echo $this->lang->line('hp_declaration'); ?><span class="astrik">*</span></label>
																<label for="hp_declaration"><?php echo $hp_declaration;?><?php echo $this->lang->line('hp_declaration_yes'); ?></label>
															</div>
													
														</div>
														
                                                    </div>
                                                </div>
                                                <div class="row">
												<ul class="pager wizard">
                                                    <li class="previous"><a href="#" class="btn btn-default"><?php echo $this->lang->line('previous');?></a></li>
                                                    <li class="next"><a href="#" id="hp_next" class="btn btn-default"><?php echo $this->lang->line('next');?></a></li>
													 <input id="hp_submit" type="submit" class="btn btn-default" style="display:none;" name="submit" value="<?php echo $this->lang->line('submit');?>" />  
                                                </ul>
                                                </div>
                                                
                                            </div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->
                    </div>
                </div><!-- Main Wrapper -->
               
<!-- /wrapper --> 

<!-- Javascript --> 

<!-- FOOTER -->

<?php $this->load->view ('inc/footer');?>

<!-- FOOTER -->
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery-ui/jquery-ui-1.10.4.custom.min.js"></script> 
<script src="<?php echo base_url();?>assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.css"> 
<script src="<?php echo base_url();?>assets/js/mc_js/health_practitioner/add_hp.js"></script> 
<script>
				/* Hp UG Degree start  */
	var ug_html =  '<div class="hp_ug_degree_wrraper">';
		ug_html += '<div class="form-group"><label for="hp_ug_degree_name_2"><?php echo $this->lang->line('hp_ug_degree_name');?></label>';
		ug_html += '<div class="row"><div class="col-md-12"><?php echo form_input($hp_ug_degree_name_2);?></div></div></div>';
		ug_html += '<div class="form-group"><label for="hp_ug_university_2"><?php echo $this->lang->line('hp_ug_university'); ?></label>';
		ug_html += '<?php echo form_input($hp_ug_university_2);?></div>';
		ug_html += '<div class="form-group"><label for="hp_ug_upload_degree_2"><?php echo $this->lang->line('hp_ug_upload_degree');?></label>';
		ug_html += '<?php echo form_upload($hp_ug_upload_degree_2);?></div></div>';
	
		$('.add_ug_degree').click(function(){
			var count = jQuery('#hp_ug_degree .hp_ug_degree_wrraper').length;
			if(count < 2){				
				$('#hp_ug_degree').append(ug_html);
				$('.add_ug_degree').css('display','none');
				$('.add_ug_degree_remove').css('display','block');
			}
			
		});
		$( ".add_ug_degree_remove" ).click(function() {
		$(".hp_ug_degree_wrraper:nth-child(2)").remove();
		$('.add_ug_degree').css('display','block');
		$('.add_ug_degree_remove').css('display','none');
		
		});
		/* Hp UG Degree end  */
		
							/* Hp PG Degree start */
		
			var pg_html =  '<div class="hp_pg_degree_wrraper">';
		pg_html += '<div class="form-group"><label for="hp_pg_degree_name_2"><?php echo $this->lang->line('hp_pg_degree_name');?></label>';
		pg_html += '<div class="row"><div class="col-md-12"><?php echo form_input($hp_pg_degree_name_2);?></div></div></div>';
		pg_html += '<div class="form-group"><label for="hp_pg_university_2"><?php echo $this->lang->line('hp_pg_university'); ?></label>';
		pg_html += '<?php echo form_input($hp_pg_university_2);?></div>';
		pg_html += '<div class="form-group"><label for="hp_pg_upload_degree_2"><?php echo $this->lang->line('hp_pg_upload_degree');?></label>';
		pg_html += '<?php echo form_upload($hp_pg_upload_degree_2);?></div></div>';
	
		$('.add_pg_degree').click(function(){
			var count = jQuery('#hp_pg_degree .hp_pg_degree_wrraper').length;
			if(count < 2){				
				$('#hp_pg_degree').append(pg_html);
				$('.add_pg_degree').css('display','none');
				$('.add_pg_degree_remove').css('display','block');
			}
			
		});
		$( ".add_pg_degree_remove" ).click(function() {
		$(".hp_pg_degree_wrraper:nth-child(2)").remove();
		$('.add_pg_degree').css('display','block');
		$('.add_pg_degree_remove').css('display','none');
		
		});
		
		/* Hp PG Degree end  */
		
		/* Upload medical registration document Scan start  */
			
			var mr_html =  '<div class="hp_mr_degree_wrraper">';
			    mr_html += '<div class="form-group"><label for="hp_mr_document_2"><?php echo $this->lang->line('hp_mr_document');?></label>';
			    mr_html += '<?php echo form_upload($hp_mr_document_2);?></div></div>';
	
            $('.add_mr_degree').click(function(){
			
			var count = jQuery('#hp_mr_degree .hp_mr_degree_wrraper').length;
	
			if(count < 2){	
		
				$('#hp_mr_degree').append(mr_html);
				$('.add_mr_degree').css('display','none');
				$('.add_mr_degree_remove').css('display','block');
			}
			
		});
		$( ".add_mr_degree_remove" ).click(function() {
		$(".hp_mr_degree_wrraper:nth-child(2)").remove();
		$('.add_mr_degree').css('display','block');
		$('.add_mr_degree_remove').css('display','none');
		
		});                                         
			
		/* Upload medical registration document Scan end  */
		
		/* Upload medical Insurance document Scan start  */
			var mi_html =  '<div class="hp_mi_degree_wrraper">';
			    mi_html += '<div class="form-group"><label for="hp_mi_format"><?php echo $this->lang->line('hp_mi_format');?></label>';
			    mi_html += '<?php echo form_upload($hp_mi_format_2);?></div></div>';
		
		  $('.add_mi_degree').click(function(){
			
			var count = jQuery('#hp_mi_degree .hp_mi_degree_wrraper').length;
	
			if(count < 2){	
		
				$('#hp_mi_degree').append(mi_html);
				$('.add_mi_degree').css('display','none');
				$('.add_mi_degree_remove').css('display','block');
			}
			
		});
		$( ".add_mi_degree_remove" ).click(function() {
		$(".hp_mi_degree_wrraper:nth-child(2)").remove();
		$('.add_mi_degree').css('display','block');
		$('.add_mi_degree_remove').css('display','none');
		
		});                                         
			
				
		/* Upload medical Insurance document Scan end  */
		
		/* Upload medical Insurance complete section  start  */
		var mi_complete_html =  '<div class="hp_mi_section_wrraper">';
			mi_complete_html += '<div class="form-group"><label for="hp_mi_company_2"><?php echo $this->lang->line('hp_mi_company');?></label>';
			mi_complete_html += '<?php echo form_input($hp_mi_company_2);?></div>';
			mi_complete_html += '<div class="form-group"><label for="hp_mi_number_2"><?php echo $this->lang->line('hp_mi_number');?></label><?php echo form_input($hp_mi_number_2);?></div>';
			mi_complete_html += '<div class="form-group"><label for="hp_mi_issue_date_2"><?php echo $this->lang->line('hp_mi_issue_date');?></label><?php echo form_input($hp_mi_issue_date_2);?></div><div class="form-group"><label for="hp_mi_expiry_date"><?php echo $this->lang->line('hp_mi_expiry_date_2');?></label><?php echo form_input($hp_mi_expiry_date_2);?></div>';
			mi_complete_html += '<div id="hp_mi_degree2"><div class="hp_mi_degree_wrraper2"><div class="form-group"><label for="hp_mi_format_2_1"><?php echo $this->lang->line('hp_mi_format');?></label><?php echo form_upload($hp_mi_format_2_1);?></div></div></div>';
			mi_complete_html += '<div class="mi_document_action2"><div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_mi_degree2" ><i class="fa fa-plus"></i></a></span></div><div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_mi_degree_remove2" style="display:none;" ><?php echo $this->lang->line('delete');?></a></span></div></div>';
			mi_complete_html += '</div> ';
			
			
			 $('.add_hp_mi_section').click(function(){
			
			var count = jQuery('#hp_mi_section .hp_mi_section_wrraper').length;
	
			if(count < 2){	
		
				$('#hp_mi_section').append(mi_complete_html);
				$('.add_hp_mi_section').css('display','none');
				$('.add_hp_mi_section_remove').css('display','block');
			}
			
		});
		$( ".add_hp_mi_section_remove" ).click(function() {
		$(".hp_mi_section_wrraper:nth-child(2)").remove();
		$('.add_hp_mi_section').css('display','block');
		$('.add_hp_mi_section_remove').css('display','none');
		
		});                  
			
			
		/* Upload medical Insurance complete section  end  */
		
		
		/* Upload medical Insurance document Scan 2nd section start  */
			var mi_html2 =  '<div class="hp_mi_degree_wrraper2">';
			    mi_html2 += '<div class="form-group"><label for="hp_mi_format"><?php echo $this->lang->line('hp_mi_format');?></label>';
			    mi_html2 += '<?php echo form_upload($hp_mi_format_2_2);?></div></div>';
		

			 $("body").delegate(".add_mi_degree2","click",function(){
		
			var count = jQuery('#hp_mi_degree2 .hp_mi_degree_wrraper2').length;
	
			if(count < 2){	
		
				$('#hp_mi_degree2').append(mi_html2);
				$('.add_mi_degree2').css('display','none');
				$('.add_mi_degree_remove2').css('display','block');
			}
			
		});
		
		$("body").delegate(".add_mi_degree_remove2","click",function(){
		$(".hp_mi_degree_wrraper2:nth-child(2)").remove();
		$('.add_mi_degree2').css('display','block');
		$('.add_mi_degree_remove2').css('display','none');
		
		});                                         
			
				
		/* Upload medical Insurance document Scan 2nd section end  */
		
		/* Mobile add more jquery */
		
		var mobile_html =  '<div class="hp_mobile_section_wrraper">';
			    mobile_html += '<div class="form-group col-md-12"><label for="hp_mobile_2"><?php echo $this->lang->line('hp_mobile_2');  ?></label>';
			    mobile_html += '<?php echo form_input($hp_mobile_2); ?></div>';
		
			
			 $('.add_mobile_degree').click(function(){
			var count = jQuery('#hp_mobile_section .hp_mobile_section__wrraper').length;
	
			if(count < 2){	
		
				$('#hp_mobile_section').append(mobile_html);
				$('.add_mobile_degree').css('display','none');
				$('.add_mobile_degree_remove').css('display','block');
			}
			
		});
		 $('.add_mobile_degree_remove').click(function(){
		$(".hp_mobile_section_wrraper:nth-child(2)").remove();
		$('.add_mobile_degree').css('display','block');
		$('.add_mobile_degree_remove').css('display','none');
		
		});                                         
			
		
		/* Mobile add more jquery */
		
		/* Emergency Contact Number add more jquery */
		
		var emg_contact_html =  '<div class="hp_emg_contact_section_wrraper">';
			    emg_contact_html += '<h3><?php echo $this->lang->line('hp_emergency_contact_2');?></h3><div class="form-group col-md-12"><label for="hp_emg_contact_title_2"><?php echo $this->lang->line('hp_emg_contact_title');  ?></label><?php echo form_input($hp_emg_contact_title_2); ?></div>';
			    emg_contact_html += '<div class="form-group col-md-12"><label for="hp_emg_contact_surname_2"><?php echo $this->lang->line('hp_emg_contact_surname');  ?></label><?php echo form_input($hp_emg_contact_surname_2); ?></div>';
			    emg_contact_html += '<div class="form-group col-md-12"><label for="hp_emg_contact_name_2"><?php echo $this->lang->line('hp_emg_contact_name');  ?></label><?php echo form_input($hp_emg_contact_name_2); ?></div>';
			    emg_contact_html += '<div class="form-group col-md-12"><label for="hp_emg_contact_email_2"><?php echo $this->lang->line('hp_emg_contact_email');  ?></label><?php echo form_input($hp_emg_contact_email_2); ?></div>';
			    emg_contact_html += '<div class="form-group col-md-12"><label for="hp_emg_contact_mobile_2"><?php echo $this->lang->line('hp_emg_contact_mobile');  ?></label><?php echo form_input($hp_emg_contact_mobile_2); ?></div>';
			    emg_contact_html += '<div class="form-group col-md-12"><label for="hp_emg_contact_relationship_2"><?php echo $this->lang->line('hp_emg_contact_relationship');  ?></label><?php echo form_input($hp_emg_contact_relationship_2); ?></div></div>';
				
		
				$('.add_emg_degree').click(function(){
			var count = jQuery('#hp_emg_contact_section .hp_emg_contact_section_wrraper').length;
	
			if(count < 2){	
		
				$('#hp_emg_contact_section').append(emg_contact_html);
				$('.add_emg_degree').css('display','none');
				$('.add_emg_degree_remove').css('display','block');
				}
			
		});
		
		$('.add_emg_degree_remove').click(function(){
		$(".hp_emg_contact_section_wrraper:nth-child(2)").remove();
		$('.add_emg_degree').css('display','block');
		$('.add_emg_degree_remove').css('display','none');
		
		});                                         
		
		/* Mobile add more jquery */
		
		
		/* Medical Registration complete section  start  */
		<?php $country_listing2=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('hp_mr_country_2', $countries,'',$country_id)); ?>
		
		var mr_complete_html ='<div class="hp_mr_section_wrraper">';
			mr_complete_html += '<div class="form-group"><label for="hp_mr_country"><?php echo $this->lang->line('hp_mr_country');?></label>';
			mr_complete_html += '<?php echo $country_listing2;?></div>';
			mr_complete_html += '<div class="form-group"><label for="hp_mr_reg_no"><?php echo $this->lang->line('hp_mr_reg_no'); ?></label><?php echo form_input($hp_mr_reg_no_2);?></div>';
			mr_complete_html += '<div class="form-group"><label for="hp_mr_issue_date"><?php echo $this->lang->line('hp_mr_issue_date');?></label><?php echo form_input($hp_mr_issue_date_2);?></div>';
			mr_complete_html += '<div class="form-group"><label for="hp_mr_expiry_date"><?php echo $this->lang->line('hp_mr_expiry_date');?></label><?php echo form_input($hp_mr_expiry_date_2);?></div>';
			mr_complete_html += '<div id="hp_mr_degree2"><div class="hp_mr_degree_wrraper2"><div class="form-group"><label for="hp_mr_document"><?php echo $this->lang->line('hp_mr_document');?></label><?php echo form_upload($hp_mr_document_2_1);?></div></div></div>';
			mr_complete_html += '<div class="mr_document_action2"><div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_degree2" ><i class="fa fa-plus"></i></a></span></div><div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_degree_remove2" style="display:none;" ><?php echo $this->lang->line('delete');?></a></span></div></div>';
			mr_complete_html += '</div>';
			
			
			<?php $country_listing3=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('hp_mr_country_3', $countries,'',$country_id2)); ?>
		
		var mr_complete_html3 ='<div class="hp_mr_section_wrraper">';
			mr_complete_html3 += '<div class="form-group"><label for="hp_mr_country"><?php echo $this->lang->line('hp_mr_country');?></label>';
			mr_complete_html3 += '<?php echo $country_listing3;?></div>';
			mr_complete_html3 += '<div class="form-group"><label for="hp_mr_reg_no"><?php echo $this->lang->line('hp_mr_reg_no'); ?></label><?php echo form_input($hp_mr_reg_no_3);?></div>';
			mr_complete_html3 += '<div class="form-group"><label for="hp_mr_issue_date"><?php echo $this->lang->line('hp_mr_issue_date');?></label><?php echo form_input($hp_mr_issue_date_3);?></div>';
			mr_complete_html3 += '<div class="form-group"><label for="hp_mr_expiry_date"><?php echo $this->lang->line('hp_mr_expiry_date');?></label><?php echo form_input($hp_mr_expiry_date_3);?></div>';
			mr_complete_html3 += '<div id="hp_mr_degree3"><div class="hp_mr_degree_wrraper3"><div class="form-group"><label for="hp_mr_document"><?php echo $this->lang->line('hp_mr_document');?></label><?php echo form_upload($hp_mr_document_3_1);?></div></div></div>';
			mr_complete_html3 += '<div class="mr_document_action3"><div class="form-group custom_new"><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_degree3" ><i class="fa fa-plus"></i></a></span></div><div class="form-group" ><span class="cross_btn"><a href="javascript:void(0);" class="add_mr_degree_remove3" style="display:none;" ><?php echo $this->lang->line('delete');?></a></span></div></div>';
			mr_complete_html3 += '</div>';
	
			 $('.add_mr_section').click(function(){
							
			var count = jQuery('#hp_mr_section .hp_mr_section_wrraper').length;
	
			if(count < 3){	
				if(count==1){
					
				$('#hp_mr_section').append(mr_complete_html);
				}else{
				
					$('#hp_mr_section').append(mr_complete_html3)
				}
				//$('.add_mr_section').css('display','none');
				$('.add_mr_section_remove').css('display','block');
			}
			
		});
		$( ".add_mr_section_remove" ).click(function() {
			
		$(".hp_mr_section_wrraper:last-child").remove();
		$('.add_mr_section').css('display','block');
		var count = jQuery('#hp_mr_section .hp_mr_section_wrraper').length;
		if(count == 1){
		$('.add_mr_section_remove').css('display','none');
		}
		});  

		/* Medical Registration complete section  end  */
		
			/* Upload medical registration document for 2nd time Scan start  */
			
			var mr_html2 =  '<div class="hp_mr_degree_wrraper2">';
			    mr_html2 += '<div class="form-group col-md-12"><label for="hp_mr_document_2_2"><?php echo $this->lang->line('hp_mr_document');?></label>';
			    mr_html2 += '<?php echo form_upload($hp_mr_document_2_2);?></div></div>';
	
            
			$("body").delegate(".add_mr_degree2","click",function(){
			var count = jQuery('#hp_mr_degree2 .hp_mr_degree_wrraper2').length;
	
			if(count < 2){	
		
				$('#hp_mr_degree2').append(mr_html2);
				$('.add_mr_degree2').css('display','none');
				$('.add_mr_degree_remove2').css('display','block');
			}
			
		});

		$("body").delegate(".add_mr_degree_remove2","click",function(){
		$(".hp_mr_degree_wrraper2:nth-child(2)").remove();
		$('.add_mr_degree2').css('display','block');
		$('.add_mr_degree_remove2').css('display','none');
		
		});                                         
			
		/* Upload medical registration document for 2nd time Scan end  */
		
		/* Upload medical registration document for 3nd time Scan start  */
			
			var mr_html3 =  '<div class="hp_mr_degree_wrraper3">';
			    mr_html3 += '<div class="form-group"><label for="hp_mr_document_3_2"><?php echo $this->lang->line('hp_mr_document');?></label>';
			    mr_html3 += '<?php echo form_upload($hp_mr_document_3_2);?></div></div>';
	
            
			$("body").delegate(".add_mr_degree3","click",function(){
			var count = jQuery('#hp_mr_degree3 .hp_mr_degree_wrraper3').length;
	
			if(count < 2){	
		
				$('#hp_mr_degree3').append(mr_html3);
				$('.add_mr_degree3').css('display','none');
				$('.add_mr_degree_remove3').css('display','block');
			}
			
		});

		$("body").delegate(".add_mr_degree_remove3","click",function(){
		$(".hp_mr_degree_wrraper3:nth-child(2)").remove();
		$('.add_mr_degree3').css('display','block');
		$('.add_mr_degree_remove3').css('display','none');
		
		});                                         
			
		/* Upload medical registration document for 3nd time Scan end  */
		
			/* prescribe section   */
			<?php $prescribe_country=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('prescribe_country_2', $countries,'',$country_id3)); ?>
			var prescribe_html =  '<div class="hp_prescribe_wrraper">';
			    prescribe_html += '<div class="form-group"><label for="prescribe_country_2"><?php echo $this->lang->line('hp_country');?></label>';
			    prescribe_html += '<?php echo $prescribe_country;?></div>';
			    prescribe_html += '<div class="form-group"><label for="hp_prescriber_number_2"><?php echo $this->lang->line('hp_prescriber_number');  ?></label><?php echo form_input($hp_prescriber_number_2); ?></div></div>';
				
				<?php $prescribe_country2=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('prescribe_country_3', $countries,'',$country_id3)); ?>
			var prescribe_html2 =  '<div class="hp_prescribe_wrraper">';
			    prescribe_html2 += '<div class="form-group"><label for="prescribe_country2"><?php echo $this->lang->line('hp_country');?></label>';
			    prescribe_html2 += '<?php echo $prescribe_country2;?></div>';
			    prescribe_html2 += '<div class="form-group"><label for="hp_prescriber_number_3"><?php echo $this->lang->line('hp_prescriber_number');  ?></label><?php echo form_input($hp_prescriber_number_3); ?></div></div>';
	
		<?php $prescribe_country3=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('prescribe_country_4', $countries,'',$country_id3)); ?>
			var prescribe_html3 =  '<div class="hp_prescribe_wrraper">';
			    prescribe_html3 += '<div class="form-group"><label for="prescribe_country_4"><?php echo $this->lang->line('hp_country');?></label>';
			    prescribe_html3 += '<?php echo $prescribe_country3;?></div>';
			    prescribe_html3 += '<div class="form-group"><label for="hp_prescriber_number_4"><?php echo $this->lang->line('hp_prescriber_number');  ?></label><?php echo form_input($hp_prescriber_number_4); ?></div></div>';
	
		<?php $prescribe_country4=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('prescribe_country_5', $countries,'',$country_id3)); ?>
			var prescribe_html4 =  '<div class="hp_prescribe_wrraper">';
			    prescribe_html4 += '<div class="form-group"><label for="prescribe_country_5"><?php echo $this->lang->line('hp_country');?></label>';
			    prescribe_html4 += '<?php echo $prescribe_country4;?></div>';
			    prescribe_html4 += '<div class="form-group"><label for="hp_prescriber_number_5"><?php echo $this->lang->line('hp_prescriber_number');  ?></label><?php echo form_input($hp_prescriber_number_5); ?></div></div>';
            
			
				$( ".add_prescribe_section" ).click(function() {
			var count = jQuery('#prescribe_section .hp_prescribe_wrraper').length;
	
			if(count < 5){	
				if(count==1){
					
				$('#prescribe_section').append(prescribe_html);
				}if(count==2){
				
					$('#prescribe_section').append(prescribe_html2);
				}
				if(count==3){
						
					$('#prescribe_section').append(prescribe_html3);
				}
				if(count==4){
						
					$('#prescribe_section').append(prescribe_html4);
				}
				//$('.add_prescribe_section').css('display','none');
				$('.add_prescribe_section_remove').css('display','block');
			}
			
		});

		$( ".add_prescribe_section_remove" ).click(function() {	
		var count = jQuery('#prescribe_section .hp_prescribe_wrraper').length;
	
		$(".hp_prescribe_wrraper:last-child").remove();
		
		$('.add_prescribe_section').css('display','block');
		if(count == 2){
		
		$('.add_prescribe_section_remove').css('display','none');
		}
		});                                         
			
		/* prescribe section  */
		
		/* provider  section  */
		
	
		<?php $provide_country=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('provide_country_2', $countries,'',$country_id3)); ?>
			var provider_html =  '<div class="medical_provider_wrraper">';
			    provider_html += '<div class="form-group"><label for="hp_provider_number_2"><?php echo $this->lang->line('hp_provider_number');  ?></label><?php echo form_input($hp_provider_number_2); ?></div>';
			    provider_html += '<div class="form-group"><label for="hp_provider_location_2"><?php echo $this->lang->line('hp_provider_location');  ?></label><?php echo form_input($hp_provider_location_2); ?></div>';
			    provider_html += '<div class="form-group"><label for="hp_provider_country_2"><?php echo $this->lang->line('hp_country');?></label><?php echo $provide_country;?></div></div>';
		
		<?php $provide_country2=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('hp_provider_country_3', $countries,'',$country_id3)); ?>
			var provider_html2 =  '<div class="medical_provider_wrraper">';
			    provider_html2 += '<div class="form-group"><label for="hp_provider_number_3"><?php echo $this->lang->line('hp_provider_number');  ?></label><?php echo form_input($hp_provider_number_3); ?></div>';
			    provider_html2 += '<div class="form-group"><label for="hp_provider_location_3"><?php echo $this->lang->line('hp_provider_location');  ?></label><?php echo form_input($hp_provider_location_3); ?></div>';
			    provider_html2 += '<div class="form-group"><label for="hp_provider_country_3"><?php echo $this->lang->line('hp_country');?></label><?php echo $provide_country2;?></div></div>';
		
		<?php $provide_country3=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('hp_provider_country_4', $countries,'',$country_id3)); ?>
			var provider_html3 =  '<div class="medical_provider_wrraper">';
			    provider_html3 += '<div class="form-group"><label for="hp_provider_number_4"><?php echo $this->lang->line('hp_provider_number');  ?></label><?php echo form_input($hp_provider_number_4); ?></div>';
			    provider_html3 += '<div class="form-group"><label for="hp_provider_location_4"><?php echo $this->lang->line('hp_provider_location');  ?></label><?php echo form_input($hp_provider_location_4); ?></div>';
			    provider_html3 += '<div class="form-group"><label for="hp_provider_country_4"><?php echo $this->lang->line('hp_country');?></label><?php echo $provide_country3;?></div></div>';
		
		<?php $provide_country4=preg_replace(array('/\s+/','/\'/'),array(' ',''),form_dropdown('hp_provider_country_5', $countries,'',$country_id3)); ?>
			var provider_html4 = '<div class="medical_provider_wrraper">';
			    provider_html4 += '<div class="form-group"><label for="hp_provider_number_5"><?php echo $this->lang->line('hp_provider_number');  ?></label><?php echo form_input($hp_provider_number_5); ?></div>';
			    provider_html4 += '<div class="form-group"><label for="hp_provider_location_5"><?php echo $this->lang->line('hp_provider_location');  ?></label><?php echo form_input($hp_provider_location_5); ?></div>';
			    provider_html4 += '<div class="form-group"><label for="hp_provider_country_5"><?php echo $this->lang->line('hp_country');?></label><?php echo $provide_country4;?></div></div>';
		
		
				$( ".add_provider_section" ).click(function() {
				
			var count = jQuery('#medical_provider_section .medical_provider_wrraper').length;
	
			if(count < 5){	
				if(count==1){
					
				$('#medical_provider_section').append(provider_html);
				}if(count==2){
				
					$('#medical_provider_section').append(provider_html2);
				}
				if(count==3){
						
					$('#medical_provider_section').append(provider_html3);
				}
				if(count==4){
						
					$('#medical_provider_section').append(provider_html4);
				}
				//$('.add_prescribe_section').css('display','none');
				$('.add_provider_section_remove').css('display','block');
			}
			
		});

		$( ".add_provider_section_remove" ).click(function() {	
		var count = jQuery('#medical_provider_section .medical_provider_wrraper').length;
	
		$(".medical_provider_wrraper:last-child").remove();
		
		$('.add_provider_section').css('display','block');
		if(count == 2){
		
		$('.add_provider_section_remove').css('display','none');
		}
		});                                         
			
		/* provider section  */
		
		
		
		/* Submit Button code start */
		
			$( document ).ready(function() {
			$('.hp_declaration').click(function() {
			$("#hp_submit").toggle(this.checked);
			 if (this.checked) {
          	$('#hp_next').css('display','none');
			} else {
          	$('#hp_next').css('display','block');
			}
			});
			});
		
		/* Submit button code end */
		/* Speciality select 2 */
		
		$("#hp_speciality").select2();
		$("#hp_language").select2();
	
		/* Speciality select 2 */
		
</script>
<script>
$(document).ready(function(){
	$('#health_practice_name, #health_practice_country, #health_practice_address').on('keyup keypress change', function() {


//dataString = $("#health_practice_name").serialize();
var name = $("#health_practice_name").val();
var country = $("#health_practice_country").val();
var address = $("#health_practice_address").val();



jQuery.ajax({
	type : "POST",
	url  : "<?php echo base_url(); ?>health_practitioner/get_clinic_data", 
	data : {clinic_name : name,clinic_country:country,clinic_address:address},
	dataType : "html",  
	success : 
	  function(data){
		if (data == "")
    {
        $('#clinicsRes').html('<p>Please select correct clinic</p>');
		 $("#clinicsRes p").css("color", "red");
		$('#hp_next').css('display','none');
    }
    else {
		$('#clinicsRes').html(' ');
       $('#clinicsRes').html(data);
	   $('#hp_next').css('display','block');
	   
    }
	 }
});

});
});


</script>