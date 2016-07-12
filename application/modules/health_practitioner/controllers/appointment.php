<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appointments
 * This controller handles appointment types with color codes. It operates the following tables:
 *
 * @author	Visions 03/09/2015
 */
class Appointment extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('health_practitioner/appointments');
		$this->load->model('health_practitioner/manage_locations');
                $this->load->model('health_practitioner/manage_settings');
		$this->load->model('auth/tank_auth/users');
		$this->load->model('health_practitioner/general');
		
		
	}
	function glbl($perm1 = '', $perm2 = '') // declare global functions and variables
	{
		/*------------- load useful libraries and helpers  --------------------*/
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->load->library('encryption');
		$this->lang->load('universal');
		$this->lang->load('appointment');
		$this->load->library('mc_constants');
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
		
		
		$config = array('userID'=>$this->tank_auth->ci->session->userdata['user_id']);		
		$this->load->library('acl',$config);
		
		if( ($this->acl->hasPermission($perm1) != true) && ($this->acl->hasPermission($perm2) != true) ) {
		//	redirect('misc/error');
        }
	}
	//fetch types of appointments of clinic
	public function items_desc(){
	    $data = $this->glbl('practitioner_access');	
		$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
                $data['clinicSettings'] = $this->manage_settings->getClinicSetting($clinicData->clinic_id);
                $data['cliniclocationSettings'] = $this->manage_settings->getLocationSettings($clinicData->location_id);
		$data['datatables']  = $this->appointments->getTypes($clinicData->clinic_id);
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/items_desc', $data);		
	}
	//fetch billing codes for clinic
	public function item_codes(){
	    $data = $this->glbl('practitioner_access');	
		$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
		$data['datatables']  = $this->appointments->getBillingCodes($clinicData->clinic_id);
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/item_codes', $data);		
	}
	//insert new appointment type into system
	public function add_item_code(){
	    $data = $this->glbl('practitioner_access');	
		$data['currencies'] = $this->mc_constants->currency_symbols;
		if($this->input->post('submit_action')=='insert') {
			$inputValues = $this->input->post();
			$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
			$inputValues['clinic_id'] = $clinicData->clinic_id;
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->create_billing_code($inputValues);
			$this->session->set_flashdata('display_message', $this->lang->line('billing_code_add_msg'));
			redirect('/clinic/appointment/item_codes');
		}
		$this->load->view('clinic/appointment/ajax/add_item_code', $data);
	}
	//add appointment into system
	public function add_appointment() { 
	    $data = $this->glbl('practitioner_access');	
		if($this->input->post('submit_action')=='insert') { 
			$inputValues = $this->input->post();
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			//echo '<pre>'; print_r($inputValues); exit;
                        if($inputValues['form_save'] == 1)
                        {
                            $dataSuccess = $this->appointments->create_new_appointment($inputValues);
                        }
                        else 
                        {
                            $dataSuccess = 'false';
                        }
			
			if($dataSuccess == 'true') {
                            $pid = $this->encryption->decode($inputValues['patient_field_id']);  
                            $appointtype = $this->appointments->getAppntTypeDetail($inputValues['appointment_type']);
                            if($pid != 0 && !empty($appointtype) && ($appointtype->appointment_count != '' && $appointtype->appointment_count != 0))
                            {
                                $patient_counts = $this->appointments->get_patient_appointment_counts($pid,$inputValues['appointment_type']);
                                //echo '<pre>'; print_r($patient_counts); exit;
                                if(empty($patient_counts))
                                {
                                    $new_pat_count = 1;
                                    $this->appointments->insert_patient_appointment_counts($pid,$inputValues['appointment_type'],$new_pat_count,$inputValues['author_id']);
                                }
                                else {
                                    $pat_count = $patient_counts->patient_visit_count;
                                    $new_pat_count = $pat_count + 1;
                                    $this->appointments->update_patient_appointment_counts($pid,$inputValues['appointment_type'],$new_pat_count,$inputValues['author_id']);
                                }
                            }                            
                            //echo '<pre>'; print_r($patient_counts); exit;
                            
			    echo '<script type="text/javascript">self.close();window.opener.location.reload();</script>';
			}
		}
		$startDateTime 		 	 = $this->input->get('startDate');
		$endDateTime 		 	 = $this->input->get('endDate');
		$data['startDate']   	 = $startDateTime;
		$data['startTime']   	 = $this->input->get('startTime');
		$data['endTime']   		 = $this->input->get('endTime');
		if($endDateTime != '') 
			$data['appntDuration']	= round(abs($startDateTime - $endDateTime) / 60,2);
		else
			$data['appntDuration']	= '';
		
		if($this->input->get('patient_id') != ""){
			$data['patient_info'] = $this->appointments->patient_info($this->encryption->decode($this->input->get('patient_id')));
		}
		
		$user_id				  = $this->tank_auth->ci->session->userdata['user_id'];
		$clinicData 			  = $this->manage_locations->getClinicId($user_id);
		
		//$myClinicName      = $this->manage_locations->getClinicLocationName($loc);
		$data['appointmentTypes'] = $this->appointments->getActiveAppntTypes($clinicData->clinic_id);
		
		$data['locationDetails']  = $this->manage_locations->getLocationDetails($this->encryption->decode($this->session->userdata['clinic_location']));

		$data['prac_resource']	  = $this->general->get_locaation_prac_details($this->input->get('resource'));
		
		$hpID = $data['prac_resource']->hp_id;
		$data['hp_avail_time'] = $this->general->get_prac_avail_time($hpID, $data);
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/add_appointment', $data);
	}


	//add roster appointment

	public function add_roster_appointment() { 
	    $data = $this->glbl('practitioner_access');	
		if($this->input->post('submit_action')=='insert') { 

			$inputValues = $this->input->post();
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			//echo '<pre>'; print_r($inputValues); exit;
                        if($inputValues['form_save'] == 1)
                        {
                            $dataSuccess = $this->appointments->create_new_roster($inputValues);
                        }
                        else 
                        {
                            $dataSuccess = 'false';
                        }
			
			if($dataSuccess == 'true') {
                            $pid = $this->encryption->decode($inputValues['patient_field_id']);  
                            $appointtype = $this->appointments->getAppntTypeDetail($inputValues['appointment_type']);
                            if($pid != 0 && !empty($appointtype) && ($appointtype->appointment_count != '' && $appointtype->appointment_count != 0))
                            {
                                $patient_counts = $this->appointments->get_patient_appointment_counts($pid,$inputValues['appointment_type']);
                                //echo '<pre>'; print_r($patient_counts); exit;
                                if(empty($patient_counts))
                                {
                                    $new_pat_count = 1;
                                    $this->appointments->insert_patient_appointment_counts($pid,$inputValues['appointment_type'],$new_pat_count,$inputValues['author_id']);
                                }
                                else {
                                    $pat_count = $patient_counts->patient_visit_count;
                                    $new_pat_count = $pat_count + 1;
                                    $this->appointments->update_patient_appointment_counts($pid,$inputValues['appointment_type'],$new_pat_count,$inputValues['author_id']);
                                }
                            }                            
                            //echo '<pre>'; print_r($patient_counts); exit;
                            
			    echo '<script type="text/javascript">self.close();window.opener.location.reload();</script>';
			}
		}
		$startDateTime 		 	 = $this->input->get('startDate');
		$endDateTime 		 	 = $this->input->get('endDate');
		$data['startDate']   	 = $startDateTime;
		$data['startTime']   	 = $this->input->get('startTime');
		$data['endTime']   		 = $this->input->get('endTime');
		if($endDateTime != '') 
			$data['rostDuration']	= round(abs($startDateTime - $endDateTime) / 60,2);
		else
			$data['rostDuration']	= '';
		
		if($this->input->get('patient_id') != ""){
			$data['patient_info'] = $this->appointments->patient_info($this->encryption->decode($this->input->get('patient_id')));
		}
		
		$user_id				  = $this->tank_auth->ci->session->userdata['user_id'];
		$clinicData 			  = $this->manage_locations->getClinicId($user_id);
		
		//$myClinicName      = $this->manage_locations->getClinicLocationName($loc);
		$data['appointmentTypes'] = $this->appointments->getActiveAppntTypes($clinicData->clinic_id);
		
		$data['locationDetails']  = $this->manage_locations->getLocationDetails($this->encryption->decode($this->session->userdata['clinic_location']));
		$data['room_id'] = $this->input->get('resource');
		$data['prac_resource']	  = $this->general->get_locaation_prac_details($this->input->get('resource'));
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/roster/add_roster_appointment', $data);
	}

	//ends roaster appoitnment






	//edit existing appointment
	public function edit_appointment() { 
	    $data = $this->glbl('practitioner_access');	
		if($this->input->post('submit_action')=='insert') { 
			$inputValues = $this->input->post();
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->update_appointment($inputValues);
			echo '<script type="text/javascript">self.close();window.opener.location.reload();</script>';
		}
		$startDateTime 		 	 = $this->input->get('startDate');
		$endDateTime 		 	 = $this->input->get('endDate');
		$data['startDate']   	 = $startDateTime;
		$data['startTime']   	 = $this->input->get('startTime');
		$data['endTime']   		 = $this->input->get('endTime');
		$appntID				 = $this->input->get('appointment_id');
		$data['appntDetails'] 	 = $this->appointments->get_appointment_details($appntID);
		
		if($endDateTime != '') 
			$data['appntDuration']	= round(abs($startDateTime - $endDateTime) / 60,2);
		else
			$data['appntDuration']	= '';
		
		$user_id				  = $this->tank_auth->ci->session->userdata['user_id'];
		$clinicData 			  = $this->manage_locations->getClinicId($user_id);
		$data['appointmentTypes'] = $this->appointments->getActiveAppntTypes($clinicData->clinic_id);
		
		$data['locationDetails']  = $this->manage_locations->getLocationDetails($this->encryption->decode($this->session->userdata['clinic_location']));
		//echo '<pre>'; print_r($this->input->get('resource')); exit;
                $data['prac_resource']	  = $this->general->get_locaation_prac_details($this->input->get('resource'));
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/add_appointment', $data);
	}
	//cancel appointment
	public function cancel_appointment() {
		$data = $this->glbl('practitioner_access');
		$inputValues['appnt_id']  = $this->input->get('appnt_id');
		$inputValues['appointment_date']  = $this->input->get('appointment_date');
		$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
                
                $result = $this->appointments->cancel_appointment($inputValues);
                if($result == true)
                {
                    $this->session->set_flashdata('display_message', 'Appointment successfully cancelled.');
                }
                else 
                {
                    $this->session->set_flashdata('display_message', 'There is some problem in cancelling the appointment.');
                }
                                
                $appoint_details = $this->appointments->get_appoint_data($inputValues['appnt_id']);
                if(!empty($appoint_details) && $result == true)
                {
                    $pid = $appoint_details->patient_id;
                    $patient_counts = $this->appointments->get_patient_appointment_counts($pid,$appoint_details->appointment_type_id);
                    if(!empty($patient_counts))
                    {
                        $pat_count = $patient_counts->patient_visit_count;
                        $new_pat_count = $pat_count - 1;
                        if($new_pat_count < 0)
                        {
                            $new_pat_count = 0;
                        }
                        $this->appointments->update_patient_appointment_counts($pid,$appoint_details->appointment_type_id,$new_pat_count,$inputValues['author_id']);
                    } 
                }                
                
		redirect('/');
	}


	// cancel Roster

		public function cancel_roster() {
		$data = $this->glbl('practitioner_access');
		$inputValues['roster_id']  = $this->input->get('roster_id');
            $result = $this->appointments->cancel_roster($inputValues);
            if($result == true)
            {
                $this->session->set_flashdata('display_message', 'Roster successfully cancelled.');
            }
            else 
            {
                $this->session->set_flashdata('display_message', 'There is some problem in cancelling the roster.');
            }
                            
			redirect('clinic/rosterView');
	}



	//validate appointment that if practitioner or patient not available
	public function validate_appointment() {
		$data = $this->glbl('practitioner_access');
		$inputValues = $this->input->get();
		$aa = $this->appointments->validate_appointment($inputValues);
                echo $aa; exit;
	}

	//validate that if room for practitioner not available 
	public function validate_roster() {
		$data = $this->glbl('practitioner_access');
		$inputValues = $this->input->get();
		$aa = $this->appointments->validate_roster($inputValues);
                echo $aa; exit;
	}


	//get clinic location appointments JSON format
	public function get_calendar_appointments() {
		
		$data = $this->glbl('practitioner_access');
		$allAppointments  = array();
		$user_id	 	  = $this->tank_auth->ci->session->userdata['user_id'];
		//$clinicData = $this->manage_locations->getClinicId($user_id);
		//$clinicLocations = $this->manage_locations->clinicLocationsArray($clinicData->clinic_id);
		//$myLocation      = $this->manage_locations->getLocationID($user_id);
		
		$locationPracs = $this->manage_locations->locationPractitioner($this->encryption->decode($this->session->userdata['clinic_location']));
		//echo '<pre>'; print_r($locationPracs); die;
		/*if(isset($this->session->userdata['location_pracs']))
			$locationPracs = $this->session->userdata['location_pracs'];
		else
			$locationPracs = '';
                echo '<pre>'; print_r($locationPracs); die;
				*/
		$allAppointments = $this->appointments->get_appointments($this->encryption->decode($this->session->userdata['clinic_location']), $locationPracs);
                $this->session->unset_userdata('appointment_entered_date');
		echo json_encode($allAppointments);
		exit();
	}



	//get roster JSON format
	public function get_calendar_roster() {
		
		$data = $this->glbl('practitioner_access');
		$allRosters  = array();
		$user_id	 	  = $this->tank_auth->ci->session->userdata['user_id'];
		$clinicID = $this->encryption->decode($this->session->userdata['clinic_location']);
		$allRosters = $this->appointments->get_roster($clinicID);
		echo json_encode($allRosters);
		exit();
	}






	//get clinic location practitioners JSON format
	public function getLocPractitioners() {
		$data = $this->glbl('practitioner_access');
		$pracs = array();
		
		
		if(isset($this->session->userdata['clinic_location'])) {
				$locationPracs = $this->session->userdata['clinic_location'];
				//foreach($locationPracs as $locationPrac) {
				$prac = array();
				$pracID = intval($this->encryption->decode($locationPracs));
				
				$pracDetails = $this->manage_locations->getPractitionerName($pracID);
				foreach($pracDetails as $pracList){
					//$prac[]   = $pracID;
					//$pracs[$pracList->hp_id] = $pracList->name.' '.$pracList->surname;
					$prac = array();
					$prac['id']   = intval($pracList->hp_id);
					$prac['name'] = $pracList->name.' '.$pracList->surname;
					// Merge the practitioners array into the return array
					array_push($pracs, $prac);
				}
			// echo '<pre>'; print_r($pracDetails); die;
				
				
				// Merge the practitioners array into the return array
				//array_push($pracs, $prac);
		//	}
		}
		else {
			$user_id				 = $this->tank_auth->ci->session->userdata['user_id'];
			$clinicData              = $this->manage_locations->getClinicId($user_id);
			$myLocation      = $this->manage_locations->getLocationID($clinicData->id);
			$loc = explode(',',$myLocation->clinic_loc);
			
			$data['myLocation'] = $loc;
			//$locationPracs = $this->manage_locations->locationPractitioner($data['myLocation']->clinic_location_id);
			$locationPracs = $this->manage_locations->locationPractitioner($data['myLocation'][0]);
			foreach($locationPracs as $locationPrac) {
				$prac = array();
				$prac['id']   = intval($locationPrac->hp_id);
				$prac['name'] = $locationPrac->name.' '.$locationPrac->surname;
				// Merge the practitioners array into the return array
				array_push($pracs, $prac);
			}
			
		}
		
		echo json_encode($pracs);exit();
	}




	// Get clinic rooms function start

		public function getClinicsRooms() {
		$data = $this->glbl('practitioner_access');
		$pracs = array();
		if(isset($this->session->userdata['clinic_location'])) {
				
				$clinicRooms = $this->manage_locations->clinicRooms($this->encryption->decode($this->session->userdata['clinic_location']));
				$prac = array();
				foreach($clinicRooms as $clinic_room){
					
					$prac = array();
					$prac['id']   = intval($clinic_room->id);
					$prac['name'] = $clinic_room->room;
					// Merge the practitioners array into the return array
					array_push($pracs, $prac);
				}
				//array_push($pracs, $prac);
		}
		
		echo json_encode($pracs);exit();
			
		}
		
		
	



	// get clinic rooms end





	public function show_appointment_detail() {
		$data = $this->glbl('practitioner_access');
		$inputValues = $this->input->post();
		if(isset($inputValues)) {
			$appntID = $inputValues['appointment_id'];
                        $data['casualDetails'] = $this->appointments->get_appoint_data($appntID);                        
			$data['appntDetails'] = $this->appointments->get_appointment_details($appntID);
			$this->load->view('clinic/appointment/ajax/view_appointment', $data);
		}
	}

	// Show roster details
	public function show_roster_detail() {
		$data = $this->glbl('practitioner_access');
		$inputValues = $this->input->post();
		
		if(isset($inputValues)) {
			$rosterID = $inputValues['appointment_id'];
			$data['rosterDetails'] = $this->appointments->get_roster_pop_details($rosterID);
			
			$this->load->view('clinic/appointment/ajax/roster/view_roster', $data);
		}
	}

	//insert new appointment type into system
	public function add_type(){
	    $data = $this->glbl('practitioner_access');	
		$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
                $data['clinic_location_settings'] = $this->manage_settings->getLocationSettings($clinicData->location_id);
                
                if(!isset($data['clinic_location_settings']['currency']))
                {
                    $data['clinic_location_settings']['currency'] = $this->mc_constants->default_currency;
                }
                
                $data['currencies'] = $this->mc_constants->currency_symbols;
		if($this->input->post('submit_action')=='insert') {
			$inputValues = $this->input->post();
			$inputValues['clinic_id'] = $clinicData->clinic_id;
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->create_appointment_type($inputValues);
			$this->session->set_flashdata('display_message',$this->lang->line('item_desc_add_msg'));
			redirect('/clinic/appointment/items_desc');
		}
		$data['item_codes_array']  = $this->appointments->getBillingCodesArray($clinicData->clinic_id);
		$this->load->view('clinic/appointment/ajax/add', $data);
	}
	//get practitioners listing from database for particular clinic
	public function getPractitioners(){
	    $data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if($inputValues['locationID'] != '') {
			$locationPracs = $this->manage_locations->locationPractitioner($this->encryption->decode($inputValues['locationID']));
			$returnVal = '<option value="">'.$this->lang->line('select').'</option>';
			foreach($locationPracs as $locationPrac) {
				$returnVal.= '<option value="'.$this->encryption->encode($locationPrac->practitioner_id).'">'.$locationPrac->first_name.' '.$locationPrac->surname.'</option>';
			}
			echo $returnVal;
		}
	}
	//get settings of appointment for particular clinic
	public function settings(){
		
	    $data = $this->glbl('practitioner_access');	
		//$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
		$data['appnt_settings'] = $this->appointments->check_appointment_settings($this->encryption->decode($this->session->userdata['clinic_location']));
		if(sizeof($data['appnt_settings']) > 0)
			$data['action']	= 'update';
		else
			$data['action']	= 'insert';
		
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/settings', $data);
	}
	public function appointment_settings() {
		$data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if(isset($inputValues['action'])) {
			$inputValues['location_id'] = $this->encryption->decode($this->session->userdata['clinic_location']);
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$this->appointments->appointment_settings($inputValues);
			$this->session->set_flashdata('display_message', $this->lang->line('appnt_settings_msg'));
		}
		redirect('/clinic/appointment/settings');
	}
	public function fetch_settings() {
		
		$data = $this->glbl('practitioner_access');
	
		$appnt_settings = $this->appointments->check_appointment_settings($this->encryption->decode($this->session->userdata['clinic_location']));
		if(sizeof($appnt_settings) > 0) {
			$settings['duration']   = intval($appnt_settings->appointment_duration);
			$settings['start_time'] = date("g:i a", strtotime($appnt_settings->appointment_start_time));
			$settings['end_time']   = date("g:i a", strtotime($appnt_settings->appointment_end_time));
		} else {
			$settings['duration']   = intval('15');
			$settings['start_time'] = '8:00am';
			$settings['end_time']   = '8:00pm';
		}
		if(isset($this->session->userdata['appointment_entered_date'])) 
			$entered_date = explode('-', $this->session->userdata['appointment_entered_date']);
		else
			$entered_date = explode('-', date('Y-m-d'));
		
                if(isset($this->session->userdata['filter_currentdate']) && $this->session->userdata['filter_currentdate'] != '')
                {
                    $explodedate = explode('/',$this->session->userdata['filter_currentdate']);
                    
                    $settings['calendar_year'] = intval($explodedate['2']);
                    $settings['calendar_month'] = intval($explodedate['0'] - 1);
                    $settings['calendar_day'] = intval($explodedate['1']);
                }
                else
                {
                    $settings['calendar_year'] = intval($entered_date['0']);
                    $settings['calendar_month'] = intval($entered_date['1'] - 1);
                    $settings['calendar_day'] = intval($entered_date['2']);
                }
		
		//print_r($settings);exit;
		echo json_encode($settings);
	}
	public function search_patient() {
		$data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if($inputValues['search_for']!='') {
			$locations = array();
			$user_id = $this->tank_auth->ci->session->userdata['user_id'];
			$clinicData = $this->manage_locations->getClinicId($user_id);
			$clinicLocs = $this->manage_locations->clinicLocationsID($clinicData->clinic_id);
			foreach($clinicLocs as $clinicLoc) {
				$locations[] = $clinicLoc->location_id;
			}
			$inputValues['clinic_locations'] = $locations;
			$data['patientResults']   = $this->appointments->searchPatient($inputValues);
			$html = $this->load->view('clinic/appointment/search_patients', $data);
			return $html;
		}
		else {
			
		}	
	}

	//Search Prac

	public function search_prac_roster() {
		$data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		$clinicID = $inputValues['clinicId'];
		if($inputValues['search_for']!='') {
			$data['parcResults']   = $this->appointments->searchParcts($inputValues);
			$html = $this->load->view('clinic/appointment/roster/search_pracs', $data);
			return $html;
		}
		else {
			
		}	
	}	

	//Search end
	public function edit_type(){
	    $data = $this->glbl('practitioner_access');
            $data['currencies'] = $this->mc_constants->currency_symbols;
		$inputValues = $this->input->post();
		$encryptedTypeID = $inputValues['type_id'];
		$inputValues['type_id'] = $typeID = $this->encryption->decode($encryptedTypeID);
		if($this->input->post('submit_action')=='edit') {
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->update_appointment_type($inputValues);
			$this->session->set_flashdata('display_message', $this->lang->line('item_desc_updated_msg'));
			redirect('/clinic/appointment/items_desc');
		}
		$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
		$data['item_codes_array']  = $this->appointments->getBillingCodesArray($clinicData->clinic_id);
		$data['appntDetails']  = $this->appointments->getAppntTypeDetail($typeID);
                
                if($data['appntDetails']->currency == '')
                { 
                    $data['appntDetails']->currency = $this->mc_constants->default_currency;
                }
                //echo '<pre>'; print_r($data['appntDetails']); exit;
		$this->load->view('clinic/appointment/ajax/edit', $data);
	}
	public function edit_item_code(){
	    $data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		$encryptedTypeID = $inputValues['code_id'];
		$data['currencies'] = $this->mc_constants->currency_symbols;
		$inputValues['code_id'] = $typeID = $this->encryption->decode($encryptedTypeID);
		if($this->input->post('submit_action')=='edit') {
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->update_billing_code($inputValues);
			$this->session->set_flashdata('display_message', $this->lang->line('billing_code_edit_msg'));
			redirect('/clinic/appointment/item_codes');
		}
		$data['codeDetails']  = $this->appointments->getBillingCodeDetail($typeID);
		$this->load->view('clinic/appointment/ajax/edit_item_code', $data);
	}
	
	public function enable_type(){
	    $data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if(is_array($inputValues)) {
			$encryptedTypeID = $inputValues['type_id'];
			$inputValues['type_id'] = $typeID = $this->encryption->decode($encryptedTypeID);
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$inputValues['status']	  = '1';
			$dataSuccess = $this->appointments->update_appointment_type_status($inputValues);
		}
	}
	public function disable_type(){
	    $data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if(is_array($inputValues)) {
			$encryptedTypeID = $inputValues['type_id'];
			$inputValues['type_id'] = $typeID = $this->encryption->decode($encryptedTypeID);
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$inputValues['status']	  = '0';
			$dataSuccess = $this->appointments->update_appointment_type_status($inputValues);
		}
	}
	public function enable_item_code(){
	    $data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if(is_array($inputValues)) {
			$encryptedTypeID = $inputValues['code_id'];
			$inputValues['code_id'] = $typeID = $this->encryption->decode($encryptedTypeID);
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$inputValues['status']	  = '1';
			$dataSuccess = $this->appointments->update_billing_code_status($inputValues);
		}
	}
	public function disable_item_code(){
	    $data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if(is_array($inputValues)) {
			$encryptedTypeID = $inputValues['code_id'];
			$inputValues['code_id'] = $typeID = $this->encryption->decode($encryptedTypeID);
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$inputValues['status']	  = '0';
			$dataSuccess = $this->appointments->update_billing_code_status($inputValues);
		}
	}
    
    public function update_tax(){
	    $data = $this->glbl('practitioner_access');	
		$inputValues = $this->input->post();
		if(is_array($inputValues)) { 
			$encryptedTypeID = $inputValues['type_id'];
			$inputValues['type_id'] = $typeID = $this->encryption->decode($encryptedTypeID);
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->update_appointment_type_tax($inputValues);
		}
	}
        
    public function check_item_code()
    {	    		                
                $data = $this->glbl('practitioner_access');	
		$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
		$inputVal = $this->input->get();
		$result = 'false';
		if($inputVal != "")
		{
                    $typeid = '';
                    if(isset($inputVal['type_id']) && $inputVal['type_id'] != '')
                    {
                        $typeid = $this->encryption->decode($inputVal['type_id']);
                    }
			$availEmail = $this->appointments->is_itemcode_available($inputVal['billing_code'],$clinicData->clinic_id,$typeid);
			if($availEmail == '0')
				$result = 'true';
		}
		echo $result;
	}

	public function edit_roster()
	{
	    $data = $this->glbl('practitioner_access');	
		if($this->input->post('submit_action')=='insert') { 
			$inputValues = $this->input->post();
			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->update_roster($inputValues);
			echo '<script type="text/javascript">self.close();window.opener.location.reload();</script>';
		}
		$startDateTime 		 	 = $this->input->get('startDate');
		$endDateTime 		 	 = $this->input->get('endDate');
		$data['startDate']   	 = $startDateTime;
		$data['startTime']   	 = $this->input->get('startTime');
		$data['endTime']   		 = $this->input->get('endTime');
		$rosterID				 = $this->input->get('roster_id');
		$data['rosterDetails'] 	 = $this->appointments->get_roster_details($rosterID);

		if($endDateTime != '') 
			$data['rostDuration']	= round(abs($startDateTime - $endDateTime) / 60,2);
		else
			$data['rostDuration']	= '';

		$clinicID 			  = $this->encryption->decode($this->session->userdata['clinic_location']);
		
		$data['locationDetails']  = $this->manage_locations->getLocationDetails($clinicID);
		//echo '<pre>'; print_r($this->input->get('resource')); exit;
        $data['room_id']	  = $this->input->get('resource');
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/roster/add_roster_appointment', $data);		
	}

public function chkApptRosterSch(){
	 $data = $this->glbl('practitioner_access');		
	 $inputValues = $this->input->post();
	 $rId = $this->encryption->decode($inputValues['roster_id']);  
	 
	 $chkAppt = $this->appointments->chkApptRosterSch($rId);
	 echo $chkAppt; die;

}

	
}