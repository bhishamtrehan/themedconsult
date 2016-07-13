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
		$this->load->model('clinic/appointments');
		$this->load->model('clinic/manage_locations');
        $this->load->model('clinic/manage_settings');
        $this->load->model('master/settings');
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
			redirect('misc/error');
        }
	}
	//fetch types of appointments of clinic
	public function items_desc(){
	    $data = $this->glbl('clinic_access');	
		$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
                $data['clinicSettings'] = $this->manage_settings->getClinicSetting($clinicData->clinic_id);
                $data['cliniclocationSettings'] = $this->manage_settings->getLocationSettings($clinicData->location_id);
		$data['datatables']  = $this->appointments->getTypes($clinicData->clinic_id);
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/items_desc', $data);		
	}
	//fetch billing codes for clinic
	public function item_codes(){
	    $data = $this->glbl('clinic_access');	
		$clinicData = $this->manage_locations->getClinicId($this->tank_auth->ci->session->userdata['user_id']);
		$data['datatables']  = $this->appointments->getBillingCodes($clinicData->clinic_id);
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/item_codes', $data);		
	}
	//insert new appointment type into system
	public function add_item_code(){
	    $data = $this->glbl('clinic_access');	
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
		
	    $data = $this->glbl('clinic_access','clinic_location_access');	
		if($this->input->post('submit_action')=='insert') { 
			$inputValues = $this->input->post();

				// echo "<pre>";
				// print_r($inputValues);
				// die();

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
                    redirect('/clinic/dashboard');        
			    //echo '<script type="text/javascript">self.close();window.opener.location.reload();</script>';
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

		$data['countries']  = $this->appointments->get_countries();

		$data['prac_resource']	  = $this->general->get_locaation_prac_details($this->input->get('resource'));
		
		$hpID = $data['prac_resource']->hp_id;
		$data['hp_avail_time'] = $this->general->get_prac_avail_time($hpID, $data);
		//$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/add_appointment', $data);
	}


	//add roster appointment

	public function add_roster_appointment() { 
	    $data = $this->glbl('clinic_access','clinic_location_access');	
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
                            redirect('/clinic/rosterView');
			  //  echo '<script type="text/javascript">self.close();window.opener.location.reload();</script>';
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
		//$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/roster/add_roster_appointment', $data);
	}

	//ends roaster appoitnment






	//edit existing appointment
	public function edit_appointment() { 
	    $data = $this->glbl('clinic_access','clinic_location_access');	
	    $app_id = $this->input->post('appointment_id');
	    $data['appntDetails'] 	 = $this->appointments->get_appointment_details($app_id);
		
		if($this->input->post('submit_action')=='insert') { 
	 	$inputValues = $this->input->post();

			//echo '<pre>'; print_r( $this->input->post()); die;
		 	$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->update_appointment($inputValues);

			redirect('/clinic/dashboard');
		}
		$startDateTime 		 	 = $this->input->get('startDate');
		$endDateTime 		 	 = $this->input->get('endDate');
		$data['startDate']   	 = $startDateTime;
		$data['startTime']   	 = $this->input->get('startTime');
		$data['endTime']   		 = $this->input->get('endTime');
		$appntID				 = $this->input->get('appointment_id');
		
		// echo "<pre>";
		// print_r($data['appntDetails'] );
		// die;
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
        $hpID = $data['prac_resource']->hp_id;

        $data['hp_avail_time'] = $this->general->get_prac_avail_time($hpID, $data);

		//$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/edit_appointment', $data);
	}
	//cancel appointment
	public function cancel_appointment() {
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues['appnt_id']  = $this->input->get('appnt_id');
		//print_r($inputValues);
		
          $clinicID = $this->encryption->decode($inputValues['appnt_id']);      
      

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





public function cancel_calendar_appointment() {
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues['appnt_id']  = $this->input->get('appnt_id');
		//print_r($inputValues);
		
          $clinicID = $this->encryption->decode($inputValues['appnt_id']);      
      

                $result = $this->appointments->cancel_appointment($inputValues);
               
                                
            
                if(!empty($inputValues))
                {
                    
                        $this->appointments->canceled_calendar_appointment($inputValues);
                    } 
                          
                
		redirect('/');
	}


	// cancel Roster

		public function cancel_roster() {
		$data = $this->glbl('clinic_access','clinic_location_access');
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




			public function add_new_patient() {
				$data = $this->glbl('clinic_access','clinic_location_access');
				$inputValues = $this->input->post();
				// echo "<pre>";
				// print_r($inputValues);
				

		


				if(isset($inputValues)) {
			
                                      
			$data['appntDetails'] = $this->appointments->insert_new_patient($inputValues);


			//$this->load->view('clinic/appointment/ajax/view_appointment', $data);
		}


			        
			}






	public function billing_summery() {
			$data = $this->glbl('clinic_access','clinic_location_access');
			$inputValues = $this->input->post();

			$appt_ID = $this->encryption->decode($inputValues['appointment_id']);   
			if(isset($inputValues)) {
			
			$data['billDetails'] = $this->appointments->get_billing_summery($inputValues);
			//print_r($data['appntDetails']);
			// die();

			$this->load->view('clinic/appointment/ajax/billing_summery', $data);
			}
        
	}

	public function billing_summerybyId() {
			$data = $this->glbl('clinic_access','clinic_location_access');
			$inputValues = $this->input->post();

			$pid = $inputValues['pId'];   
			if(isset($inputValues)) {
			
			$data['billDetails'] = $this->appointments->get_billing_summerybyId($pid);
			//print_r($data['appntDetails']);
			// die();

			$this->load->view('clinic/appointment/ajax/billing_summery', $data);
			}
        
	}


	public function consultation_history() {
			$data = $this->glbl('clinic_access','clinic_location_access');
			$inputValues = $this->input->post();

			
			$appt_ID = $this->encryption->decode($inputValues['appointment_id']);   
			if(isset($inputValues)) {
			
			$data['consult_Details'] = $this->appointments->get_consultation_history($inputValues);
			// echo count($data['consult_Details']);
			// echo "<pre>";
			// print_r($data['consult_Details']);
			// die();
			

			$this->load->view('clinic/appointment/ajax/consultation_history', $data);
			}
        
	}



	/**
	 * this function is used to view webcam		 
	*/
	public function webcam(){
		$data                        = $this->glbl();
		$data['ajax_req']            = TRUE;
        $user_id                     = $this->tank_auth->ci->session->userdata['user_id'];
		$clinicId                    = $this->manage_patients->getClinicId($user_id);		
        $this->load->view('clinic/appointment/ajax/webcam', $data); 
	}
	
	public function webcam2(){
		$data                        = $this->glbl();
		$data['ajax_req']            = TRUE;
		$inputValues                 = $this->input->post();
        $user_id                     = $this->tank_auth->ci->session->userdata['user_id'];
		$clinicId                    = $this->manage_patients->getClinicId($user_id);	
		$pID                         = $this->encryption->decode($inputValues['patient_id']);

		$data['patient_details']     = $this->manage_patients->getPatientDetails($pID,$clinicId->location_id);
		$this->load->view('clinic/patients/ajax/webcam2', $data); 
	}
	/**
	 * this function is used to view webcam		 
	*/
	public function webcamsnap(){
		$name = date('YmdHis');
		$newname="images/patients/".$name.".jpg";
		$file = file_put_contents( $newname, file_get_contents('php://input') );
		if (!$file) {
			print "Error occured here";
			exit();
		}
		else
		{
			/* 
				$sql="insert into web_cam_image (id,name,images) values ('','$id'.'$newname')";
				$result=mysql_query($sql);
				$value=mysql_insert_id();
				$_SESSION["myvalue"]=$value;
			*/

		}
		$url = $newname;
	    echo $url;
	    exit;
     }
     public function webcamsnap2(){
		$name = date('YmdHis');
		$newname="images/patients/".$name.".jpg";
		$file = file_put_contents( $newname, file_get_contents('php://input') );
		if (!$file) {
			print "Error occured here";
			exit();
		}
		else
		{
			/* 
				$sql="insert into web_cam_image (id,name,images) values ('','$id'.'$newname')";
				$result=mysql_query($sql);
				$value=mysql_insert_id();
				$_SESSION["myvalue"]=$value;
			*/

		}
		$url = $newname;
	    echo $url;
	    exit;
     }
     








	//validate appointment that if practitioner or patient not available
	public function validate_appointment() {
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->get();
		$aa = $this->appointments->validate_appointment($inputValues);
                echo $aa; exit;
	}

	//validate that if room for practitioner not available 
	public function validate_roster() {
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->get();
		$aa = $this->appointments->validate_roster($inputValues);
                echo $aa; exit;
	}


	//get clinic location appointments JSON format
	public function get_calendar_appointments() {
		
		$data = $this->glbl('clinic_access','clinic_location_access');
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
		
		$data = $this->glbl('clinic_access','clinic_location_access');
		$allRosters  = array();
		$user_id	 	  = $this->tank_auth->ci->session->userdata['user_id'];
		$clinicID = $this->encryption->decode($this->session->userdata['clinic_location']);
		$allRosters = $this->appointments->get_roster($clinicID);
		echo json_encode($allRosters);
		exit();
	}






	//get clinic location practitioners JSON format
	public function getLocPractitioners() {
		$data = $this->glbl('clinic_access','clinic_location_access');
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
		$data = $this->glbl('clinic_access','clinic_location_access');
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
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();

		if(isset($inputValues)) {
			$appntID = $inputValues['appointment_id'];
                        $data['casualDetails'] = $this->appointments->get_appoint_data($appntID);                        
			$data['appntDetails'] = $this->appointments->get_appointment_details($appntID);
			$this->load->view('clinic/appointment/ajax/view_appointment', $data);
		}
	}

	
	public function medication_detail() {
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		// if(isset($inputValues)) {
			// $appntID = $inputValues['appointment_id'];
                      
			$this->load->view('clinic/appointment/ajax/medication');
		// }
	}



	public function search_check_username() {
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		$data['search_check_username'] = $this->appointments->search_check_username($inputValues);
                      
			//$this->load->view('clinic/appointment/ajax/medication');
		// }
	}
	// Show roster details
	public function show_roster_detail() {
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		
		if(isset($inputValues)) {
			$rosterID = $inputValues['appointment_id'];
			$data['rosterDetails'] = $this->appointments->get_roster_pop_details($rosterID);
			$this->load->view('clinic/appointment/ajax/roster/view_roster', $data);
		}
	}

	//insert new appointment type into system
	public function add_type(){
	    $data = $this->glbl('clinic_access');	
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
	    $data = $this->glbl('clinic_access','clinic_location_access');	
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
		
	    $data = $this->glbl('clinic_access','clinic_location_access');	
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
		$data = $this->glbl('clinic_access');	
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
		$data = $this->glbl('clinic_access','clinic_location_access');
		$appnt_settings = $this->appointments->check_appointment_settings($this->encryption->decode($this->session->userdata['clinic_location']));
		if(sizeof($appnt_settings) > 0) {
			$settings['duration']   = intval($appnt_settings->appointment_duration);
			$settings['start_time'] = date("g:i a", strtotime($appnt_settings->appointment_start_time));
			$settings['end_time']   = date("g:i a", strtotime($appnt_settings->appointment_end_time));
		} else {
			$settings['duration']   = intval('30');
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
		$data = $this->glbl('clinic_access','clinic_location_access');	
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

	public function search_patient_form() {
		$data = $this->glbl('clinic_access','clinic_location_access');	
		$inputValues = $this->input->post();
		// echo "<pre>";
		// print_r($inputValues);

		if($inputValues['firstname'] || $inputValues['surname'] || $inputValues['date']!='') {
			
			$data['patientResults']   = $this->appointments->searchPatient_result($inputValues);

			
			 count($data['patientResults']);

			 	if($data['patientResults']>0){


			$html_table = '<table width="100%" id="table" cellspacing="0" cellpadding="0" class="display table table-sorting table-hover table-bordered table-responsive datatable dataTable no-footer">
							<tr>
				<th>Name</th>
				<th>Surname </th>
				<th>Date of Birth</th>
				<th>Profile</th>
			  </tr>';
			foreach($data['patientResults'] as $patientResult){
				$html_table .= "<tr class='clickpatient' id='$patientResult->patient_id'><td class='first_name'> $patientResult->first_name </td>";                          
				$html_table .= "<td class='lname'> $patientResult->last_name </td>";                          
				$html_table .= "<td class='date_birth'> $patientResult->date_of_birth </td>";                          
				$html_table .= "<td class='$patientResult->patient_id'> <a href=''>View Detail</a> </td></tr>";                          
			}
			$html_table .='
							</table>
			';	
				echo $html_table;

			}else{

				echo '<div class="alert alert-info"><strong></strong>No Patient Found!</div>';

			}
			//$html = $this->load->view('clinic/appointment/search_patients', $data);
			//return $html;
		}
			
	}

	//Search Prac

	public function search_prac_roster() {
		$data = $this->glbl('clinic_access','clinic_location_access');	
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
	    $data = $this->glbl('clinic_access');
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
	    $data = $this->glbl('clinic_access');	
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
	    $data = $this->glbl('clinic_access');	
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
	    $data = $this->glbl('clinic_access');	
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
	    $data = $this->glbl('clinic_access');	
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
	    $data = $this->glbl('clinic_access');	
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
	    $data = $this->glbl('clinic_access');	
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
                $data = $this->glbl('clinic_access');	
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
	    $data = $this->glbl('clinic_access','clinic_location_access');	
		if($this->input->post('submit_action')=='insert') { 
			$inputValues = $this->input->post();
			// echo "<pre>";
			// print_r($inputValues);
			// die();

			$inputValues['author_id'] = $this->tank_auth->ci->session->userdata['user_id'];
			$dataSuccess = $this->appointments->update_roster($inputValues);
			//echo '<script type="text/javascript">self.close();window.opener.location.reload();</script>';
			redirect('/clinic/rosterView');
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
		//$this->load->view('inc/header', $data);
		$this->load->view('clinic/appointment/roster/add_roster_appointment', $data);		
	}

public function chkApptRosterSch(){
	 $data = $this->glbl('clinic_access');		
	 $inputValues = $this->input->post();
	 $rId = $this->encryption->decode($inputValues['roster_id']);  
	 
	 $chkAppt = $this->appointments->chkApptRosterSch($rId);
	 echo $chkAppt; die;

}

public function show_medications(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		
		if(isset($inputValues)) {
			 $appntID = $this->encryption->decode($inputValues['appointment_id']); 
					 
			$data['appntID'] = $appntID;
			$data['appntDetails'] = $this->appointments->get_medications($appntID);
			
			$data['appnt_previous_Details'] = $this->appointments->get_previous_medications($appntID);
			
			$this->load->view('clinic/appointment/ajax/show_medications', $data);
		}

}


public function instruction_patient(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();

	
		if(isset($inputValues)) {
		 $appntID = $this->encryption->decode($inputValues['appointment_id']); 
					 
					
			$this->load->view('clinic/appointment/ajax/add_instruction_to_patient',array('apptId' => $appntID));
		}

}


public function add_instruction_patient(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		
	
		 $data = $inputValues['src'];
		 $filename = str_replace( " ", "-", basename($inputValues['upload_file']) );
			
			define('UPLOAD_DIR', './assets/images/appointment/');
		    $base64img = str_replace('data:image/jpeg;base64,', '', $data);
		    $data = base64_decode($base64img);
		    $file = UPLOAD_DIR . $filename;
		    file_put_contents($file, $data);



		if(isset($inputValues,$filename)) {
			
			$data['inst_status'] = $this->appointments->insert_instruction_patient($inputValues,$filename);		
		//print_r($data['inst_status']);
			
			if($data['inst_status']=="1"){
			// die('dfghj');
				// $this->session->set_flashdata('s_message', 'Data Added Successfully!');
				echo '<div class="success_message"><span>Data Added Successfully</span></div>';


			} else { 


			echo '<div class="success_message"><span>Data Added Successfully</span></div>';

				}
				
			$this->load->view('clinic/appointment/ajax/add_instruction_to_patient', $data);
		

		}

}



public function new_consult(){

	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		
		$app_id =  $this->uri->segment(4); 
		if(isset($inputValues)) {
			$appntID = $this->encryption->decode($app_id); 
			$data['appt_id'] = $this->encryption->decode($app_id); 

		$data['appntDetails'] = $this->appointments->new_consult($appntID);

		//print_r($data['appntDetails']);
		
		$practitioner_id= $data['appntDetails'][0]->practitioner_id;
		
		$data['practitioner_details'] = $this->appointments->practitioner_detail($practitioner_id);
		// echo "<pre>";
			// print_r($data['practitioner_details']);
			// die();
			$this->load->view('inc/header', $data);
			$this->load->view('inc/master_menu/clinic_menu');
			$this->load->view('clinic/appointment/ajax/newconsult', $data);
			//$this->load->view('inc/footer', $data);
			//$this->load->view('inc/header', $data);
			
		 }

}


public function billing_detail($inputValues){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		//print_r($inputValues);
	
		if(isset($inputValues)) {
		
		
	$data['billing_details'] = $this->appointments->billing_detail($inputValues);
	
			$html_table = '
						<table width="100%" id="table" border="1" cellspacing="0" cellpadding="2">
							<tr>
				<th>Description</th>
				<th>Item Code Number </th>
				<th>Price</th>
				<th>Gst</th>
			  </tr>';
			foreach($data['billing_details'] as $billing_detail){
				$html_table .= "<tr class='clickbilling' id='$billing_detail->id'><td> $billing_detail->description </td>";                          
				$html_table .= "<td> $billing_detail->item_code_no </td>";                          
				$html_table .= "<td> $billing_detail->price </td>";                          
				$html_table .= "<td> $billing_detail->gst </td></tr>";                          
			}
			$html_table .='
							</table>
			';	
				echo $html_table;
			//$this->load->view('clinic/appointment/ajax/billing_detail', $data);
		 }

}



public function get_hp_info_form($inputValues){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		//print_r($inputValues);
	
		if(isset($inputValues)) {
		
		
	$data['hp_details'] = $this->appointments->hp_info_on_form($inputValues);
	
	// echo "<pre>";
	// print_r($data['hp_details'][0]->hp_id);
	// die();
		$count_array= count($data['hp_details'][0]->hp_id);
		if($count_array==0){
		echo "No Health Professional is found";
		
		}
		else{
	
			$html_table = '
						<table width="100%" id="table" border="1" cellspacing="0" cellpadding="2">
							<tr>
				<th>HP name</th>
				<th>HP surname </th>
				
			  </tr>';
			foreach($data['hp_details'] as $hp_detail){
				$html_table .= "<tr class='clickhp' id='$hp_detail->hp_id'><td> $hp_detail->name </td>";                          
				$html_table .= "<td> $hp_detail->surname </td>";                          
				                        
			}
			$html_table .='
							</table>
			';	
				echo $html_table;
			//$this->load->view('clinic/appointment/ajax/billing_detail', $data);
		 }
}
}



public function get_clinic_admin_form($inputValues){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
	
	
		if(isset($inputValues)) {
		
		
	$data['clinic_admin_details'] = $this->appointments->get_clinic_admin_form($inputValues);


	
	 	$count_array= count($data['clinic_admin_details'][0]->id);
	
		if($count_array==0){
		echo "No service provider is found";
		
		}
		else{
	
			$html_table = '
						<table width="100%" id="table" border="1" cellspacing="0" cellpadding="2">
							<tr>
				<th>HP name</th>
				<th>HP surname </th>
				
			  </tr>';
			foreach($data['clinic_admin_details'] as $clinic_admin_detail){
				$html_table .= "<tr class='clicksp' id='$clinic_admin_detail->id'><td> $clinic_admin_detail->fname </td>";                          
				$html_table .= "<td> $clinic_admin_detail->lname </td>";                          
				                        
			}
			$html_table .='
							</table>
			';	
				echo $html_table;
			//$this->load->view('clinic/appointment/ajax/billing_detail', $data);
		 }
}
}


public function view_medications(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		
		if(isset($inputValues)) {
			 $ID = $inputValues['id']; 
					 
			$data['ID'] = $ID;
			$data['appntview'] = $this->appointments->get_show_medications($ID);
			
			//print_r($data['appntview']);
			
			$this->load->view('clinic/appointment/ajax/view_medications', $data);
		}

}
public function upload_media(){
	//echo '<pre>'; print_r($_FILES);  die;
	$images=$_FILES['fileToUpload'];
	// echo $images['name'];
	// echo $images['type'];
	// echo $images['tmp_name'];

	   $config['upload_path'] =getcwd().'/assets/images/newconsult';
        $config['file_name'] = $images['name'];
        $config['overwrite'] = false;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
		// echo "<pre>";
		// print_r($config);
      // die();
      $image_response=  $this->load->library('upload', $config);
	  
	$this->upload->do_upload($_FILES['fileToUpload']);
	
        if(!$this->upload->do_upload()) {
 
            $this->data['error'] = $this->upload->display_errors();
			//print_r($data);
        } else {
            echo "successfull";                                  
        } 
	
		
}

public function upload_investigation_media(){
	//echo '<pre>'; print_r($_FILES);  die;
	$images=$_FILES['fileToUpload1'];
	// echo $images['name'];
	// echo $images['type'];
	// echo $images['tmp_name'];
	
	
	   $config['upload_path'] =getcwd().'/assets/images/newconsult';
        $config['file_name'] = $images['name'];
        $config['overwrite'] = false;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
		
      $image_response=  $this->load->library('upload', $config);
	  
	$this->upload->do_upload1($_FILES['fileToUpload1']);
	
        if(!$this->upload->do_upload1()) {
 
            $this->data['error'] = $this->upload->display_errors();
			//print_r($data);
        } else {
            echo "successfull";                                  
        } 
	
		
}

public function upload_refferal_media(){
	//echo '<pre>'; print_r($_FILES);  die;
	$images=$_FILES['fileToUpload2'];
	// echo $images['name'];
	// echo $images['type'];
	// echo $images['tmp_name'];

	   $config['upload_path'] =getcwd().'/assets/images/newconsult';
        $config['file_name'] = $images['name'];
        $config['overwrite'] = false;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
		// echo "<pre>";
		// print_r($config);
		// die();
      $image_response=  $this->load->library('upload', $config);
	  
	$this->upload->do_upload2($_FILES['fileToUpload2']);
	
        if(!$this->upload->do_upload2()) {
 
            $this->data['error'] = $this->upload->display_errors();
			//print_r($data);
        } else {
            echo "successfull";                                  
        } 
	
	
}



public function upload_pdf(){

		//echo '<pre>'; print_r($_FILES);  die;
	$images=$_FILES['fileToUpload2'];
	

	   $config['upload_path'] =getcwd().'/assets/images/newconsult';
        $config['file_name'] = $images['name'];
        $config['overwrite'] = false;
        $config["allowed_types"] = 'jpg|jpeg|png|gif';
		// echo "<pre>";
		// print_r($config);
		// die();
      $image_response=  $this->load->library('upload', $config);
	  
	$this->upload->do_upload2($_FILES['fileToUpload2']);
	
        if(!$this->upload->do_upload2()) {
 
            $this->data['error'] = $this->upload->display_errors();
			//print_r($data);
        } else {
            echo "successfull";                                  
        } 
	
	
	
}


// private function set_upload_options()
// {   
//     //upload an image options
//     $config = array();
//     $config['upload_path'] = './assets/images/newconsult/';
//     $config['allowed_types'] = 'gif|jpg|png';
//     $config['max_size']      = '0';
//     $config['overwrite']     = FALSE;

//     return $config;
// }



public function valid_wav_file($file) {
  $handle = fopen($file, 'r');
  $header = fread($handle, 4);
  list($chunk_size) = array_values(unpack('V', fread($handle, 4)));
  $format = fread($handle, 4);
  fclose($handle);
  return $header == 'RIFF' && $format == 'WAVE' && $chunk_size == (filesize($file) - 8);
}

public function upload_audio_files(){
	$data = $this->glbl('clinic_access','clinic_location_access');
	$inputValues = $this->input->post();

	
  
	$save_folder =  "./recorder/html/audio";
if(! file_exists($save_folder)) {
  if(! mkdir($save_folder)) {
    die("failed to create save folder $save_folder");
  }
 }


echo '<pre>'; print_r($_FILES); 
$key = 'filename';
$tmp_name = $_FILES["upload_file"]["tmp_name"][$key];
$upload_name = time()."__".$_FILES["upload_file"]["name"][$key];
$type = $_FILES["upload_file"]["type"][$key];
$filename = "$save_folder/$upload_name";
$saved = 0;
$status=$this->valid_wav_file($tmp_name);
if($type == 'audio/wav' && preg_match('/^[a-zA-Z0-9_\-]+\.wav$/', $upload_name) && $status) {
  $saved = move_uploaded_file($tmp_name, $filename) ? 1 : 0;
  echo "ffff";
  
	
            
                    
  
  
}

if($_POST['format'] == 'json') {
  header('Content-type: application/json');
  print "{\"saved\": $saved}";
} else {
  print $saved ? "Saved" : 'Not saved';
}


//$data['recording_status'] = $this->appointments->insert_recording($upload_name,$inputValues);	
	
	
	
}

public function new_consultation(){
 
	$data = $this->glbl('clinic_access','clinic_location_access');
	$inputValues = $this->input->post();

		// $audio_upload = $this->upload_audio_files();
		// print_r($audio_upload);
		// die();
		



	   $hpID = $this->encryption->encode($inputValues['hp_id']); 
	  $hpname = $inputValues['hp_name']; 
	

    	$files = $_FILES;

		include_once('./assets/fpdf181/fpdf.php');

		$data = $inputValues['pdfImgBase64'];

	
		$dataPieces = explode(',',$data);
		$encodedImg = $dataPieces[1];
		$decodedImg = base64_decode($encodedImg);
		$tempImg = './assets/images/'.time().'.png';
		$path='./assets/images/newconsult/'.$hpID.'_'.$hpname.'/';
		$pdf_name=time().'_pdf.pdf';

		$pdfPath = $path.$pdf_name;
		if (!is_dir($path)) {
		    mkdir($path, 0777, TRUE);

		}
		//  Check if image was properly decoded
		if( $decodedImg!==false )
		{
		    //  Save image to a temporary location
		    if( file_put_contents($tempImg,$decodedImg)!==false )
		    {
		        //  Open new PDF document and print image
		        $pdf = new FPDF('P','mm','A3');;
		        //$pdf->AddPage();
		        $pdf->Image($tempImg);
		        $pdf->Output($pdfPath,'F');

		        //  Delete image from server
		    unlink($tempImg);
		    }
		}

	
		
	 	$config = array();
	    $config['upload_path'] = $path;
	    $config['allowed_types'] = 'gif|jpg|png';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;

		foreach ($_FILES as $key => $value) {

			
	    $cpt = count($_FILES[$key]['name']);
	    for($i=0; $i<$cpt; $i++)
	    {        

       	$_FILES['userfile']['name']= $files[$key]['name'][$i];
      	 $_FILES['userfile']['type']= $files[$key]['type'][$i];
        $_FILES['userfile']['tmp_name']= $files[$key]['tmp_name'][$i];
        $_FILES['userfile']['error']= $files[$key]['error'][$i];
        $_FILES['userfile']['size']= $files[$key]['size'][$i];    
		
		$this->load->library('upload', $config);
        //$this->upload->initialize($config);
        $this->upload->do_upload();

	 if ( ! $this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
           //echo "fail"; 
            //$this->load->view('upload_form', $error); 
         }
			
         else { 
            $data = array('upload_data' => $this->upload->data()); 
           // $this->load->view('upload_success', $data); 

          //  echo "successfull";
         } 


    }
}


				 
		if(isset($inputValues)) {
			
			$data['consult_details'] = $this->appointments->insert_consultation($inputValues,$config,$files,$pdf_name,$path);
			//print_r($data['consult_details']);
		if($data['consult_details']==1){
				$this->session->set_flashdata('consultation_message', 'Consultation Sucessfully Created.');
			 redirect('clinic/dashboard', 'refresh');
		?>
				
			
				<?php 
			//$this->load->view('clinic/appointment/ajax/view_medications', $data);
		}
		}

}

public function show_previous_medications(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		
		if(isset($inputValues)) {
			 $appntID = $this->encryption->decode($inputValues['appointment_id']); 
					 
			$data['appntID'] = $appntID;
			$data['appnt_previous_Details'] = $this->appointments->get_previous_medications($appntID);
			
			$this->load->view('clinic/appointment/ajax/show_medications', $data);
		}

}

public function status_appointments(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
	
		//print_r($inputValues);
		
	$status=$inputValues['status'];
	
		if(isset($inputValues)) {
			 $appntID = $this->encryption->decode($inputValues['appointment_id']); 
			
			$data = array(
				'appt_status' => $status,
				);
				

			$this->db->where('appointment_id', $appntID);
			$this->db->update('mc_appointments', $data);
			
		}

}


public function update_medications(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
	
		if(isset($inputValues)) {
			 $id=$inputValues['id']; 
			 $reason = $inputValues['reason']; 
			
			$data = array(
				'status' => '0',
				'reason' => $reason,
				);
				

			$this->db->where('id', $id);
		
			$this->db->update('mc_medication', $data);
			
		}

}

public function add_medication(){

	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
	


		if(isset($inputValues['action'])) {
			$appntID = $inputValues['appointment_id'];  
			$create = $this->appointments->save_medications($inputValues);
			$data['appntDetails'] = $this->appointments->get_medications($appntID);
			$this->load->view('clinic/appointment/ajax/show_medications', $data);
			
			}else{

			$data['route'] = $output = $this->settings->getSettingData('mc_route');
			
			$data['frequency'] = $output = $this->settings->getSettingData('mc_frequency');
			
			
			 $data['appId'] = $inputValues['appId'];
			
		 
		 $data['prescriberDetails'] = $this->appointments->get_prescriber_info($inputValues);
			

			$this->load->view('clinic/appointment/ajax/add_medications', $data);
		}

}


	/**** Patient details popup start ******/
	public function showPatientsDetails(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();

		
		
		if(isset($inputValues)) {
			 $appntID = $this->encryption->decode($inputValues['appointment_id']); 
					 
			$data['appntID'] = $appntID;
			$data['patientDetails'] = $this->appointments->getPatientDetails($appntID);
			
			$this->load->view('clinic/appointment/ajax/show_patients_details', $data);
		}

	}	

	/**** Patient details popup start ******/
	public function showPatientsDetailsbyId(){
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();

		
		
		if(isset($inputValues)) {
			 $pid = $inputValues['pId']; 
					 
			
			$data['patientDetails'] = $this->appointments->getPatientDetailsbyId($pid);
			
			$this->load->view('clinic/appointment/ajax/show_patients_details', $data);
		}

	}

	public function getClinicGroups(){
		$this->load->model('clinic/manage_groups');
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		$appntID = $this->encryption->decode($inputValues['appointment_id']); 
		
		$data['appntID'] = $appntID;
		$data['user_id'] = $this->tank_auth->ci->session->userdata['user_id'];
		$data['group_list'] = $this->manage_groups->groupList($data['user_id']);
		$this->load->view('clinic/appointment/ajax/display_groups_info', $data);
	}

	public function addPatienttoGroup(){
		$this->load->model('clinic/manage_groups');
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		$grpId = $inputValues['grpId'];
		
		$getPatientId =  $this->appointments->getPatientDetails($inputValues['appId']);

		$pId = $getPatientId[0]->patient_id;
		$getPatientId =  $this->manage_groups->assignPatienttoGrp($pId,$grpId);		
		echo $getPatientId; die;


	}	

	public function removePatienttoGroup(){
		$this->load->model('clinic/manage_groups');
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues = $this->input->post();
		$grpId = $inputValues['grpId'];
		
		$getPatientId =  $this->appointments->getPatientDetails($inputValues['appId']);

		$pId = $getPatientId[0]->patient_id;
		$getPatientId =  $this->manage_groups->removePatienttoGroup($pId,$grpId);		
		echo $getPatientId; die;


	}
	/**** Patient details popup ends ******/

	
}
