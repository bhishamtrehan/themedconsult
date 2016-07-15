<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appointments
 *
 * This model handles appointment types with color codes. It operates the following tables:
 * - Universal appointment types,
  *
 * @author	Visions 03/09/2015
 */
class Appointments extends CI_Model
{
	private $table_appointment_types	= 'mc_clinic_appointment_types';			// Clinic appointment types
	private $table_billing_codes		= 'mc_billing_codes';			// Clinic billing codes
	private $table_appnt_settings		= 'mc_appointment_settings';			// Clinic appointment settings
	private $table_patients			= 'mc_patients';			// Clinic patients
	private $table_practitioners		= 'mc_hp_info';			// Clinic practitioners
	private $table_appointments		= 'mc_appointments';			// Clinic appointments
	private $table_appointment_counts	= 'mc_appointment_counts';			// Patient appointments count
	private $table_appointment_resetcounts	= 'mc_appointment_resetcounts';
    private $table_mc_hp_clinic_relation	= 'mc_hp_clinic_relation';
	private $table_mc_roster = 'mc_roster';
	private $table_mc_clinic_rooms = 'mc_clinic_rooms';
	private $mc_clinic_rooms = 'mc_clinic_rooms';
	private $mc_medication = 'mc_medication';
	private $mc_route = 'mc_route';
	private $mc_frequency = 'mc_frequency';
	private $mc_billing_codes = 'mc_billing_codes';
	private $mc_speciality = 'mc_speciality';
	private $mc_clinic = 'mc_clinic';
	private $mc_consultation = 'mc_consultation';
	private $mc_billing_relation = 'mc_billing_relation';
	private $mc_consult_investigation = 'mc_consult_investigation';
	private $mc_consult_refferal = 'mc_consult_refferal';
	private $mc_consultation_media = 'mc_consultation_media';
	private $mc_clinic_admin = 'mc_clinic_admin';
	private $mc_consult_clinical_notes = 'mc_consult_clinical_notes';
	private $mc_countries = 'mc_countries';
	private $mc_users = 'mc_users';

	private $mc_instruction_to_patient = 'mc_instruction_to_patient';

	private $mc_consultation_audio_files = 'mc_consultation_audio_files';
	private $mc_consult_investigation_media = 'mc_consult_investigation_media';
	private $mc_consult_refferal_media = 'mc_consult_refferal_media';
	private $mc_consult_pdf = 'mc_consult_pdf';

	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$this->table_appointment_types   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_appointment_types;
		$this->table_billing_codes		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_billing_codes;
		$this->table_appnt_settings		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_appnt_settings;
		$this->table_patients			 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_patients;
		$this->table_practitioners		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_practitioners;
		$this->table_appointments		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_appointments;
                $this->table_appointment_counts		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_appointment_counts;
                $this->table_appointment_resetcounts		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_appointment_resetcounts;
        $this->table_mc_hp_clinic_relation   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_hp_clinic_relation;

        $this->table_mc_roster   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_roster;
        $this->table_mc_clinic_rooms   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_clinic_rooms;
        $this->mc_clinic_rooms   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_rooms;
        $this->mc_medication   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_medication;
        $this->mc_route   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_route;
        $this->mc_frequency   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_frequency;
        $this->mc_billing_codes  = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_billing_codes;
        $this->mc_speciality  = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_speciality;
        $this->mc_clinic  = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic;
        $this->mc_consultation  = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consultation;
        $this->mc_billing_relation  = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_billing_relation;
        $this->mc_consult_investigation  = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consult_investigation;
        $this->mc_consult_refferal  = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consult_refferal;
        $this->mc_consultation_media = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consultation_media;
        $this->mc_clinic_admin = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_admin;
        $this->mc_consult_clinical_notes = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consult_clinical_notes;
        $this->mc_countries = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_countries;
        $this->mc_users = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_users;

        $this->mc_instruction_to_patient = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_instruction_to_patient;

        $this->mc_consultation_audio_files = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consultation_audio_files;
        $this->mc_consult_investigation_media = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consult_investigation_media;
        $this->mc_consult_refferal_media = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consult_refferal_media;
        $this->mc_consult_pdf = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consult_pdf;

	}
	
	//fetch appointment types of clinic
	public function getTypes($clinic_id){
		$results = array();
		//$this->db->select("types.*,bcodes.code_id,bcodes.code");
                $this->db->select("types.*");
		$this->db->from($this->table_appointment_types .' as types');
		//$this->db->join($this->table_billing_codes .' as bcodes', 'bcodes.code_id = types.billing_code_id','left');
		$this->db->where('types.clinic_id',$clinic_id);
                $query = $this->db->get();
		if($query->num_rows()>0){
			$results = $query->result();
		}   	
		return $results;
	}
	//fetch active appointment types of clinic
	public function getActiveAppntTypes($clinic_id){
		$results = array();
		$this->db->select("types.*");
		$this->db->from($this->table_appointment_types .' as types');
		$this->db->where('types.clinic_id',$clinic_id);
		//$this->db->where('types.billing_code_id != ', '0');
                $this->db->where('types.code != ', '');
                $this->db->where('types.status = ', '1');
		$query = $this->db->get();
		if($query->num_rows()>0){ 
			$results = $query->result();
		}   	
		return $results;
	}
	//fetch appointment types of clinic
	public function getTypesArray($clinic_id){
		$results = array();
		$this->db->select("types.type_id,types.appointment_type");
		$this->db->from($this->table_appointment_types .' as types');
		$this->db->where('types.clinic_id',$clinic_id);
		$this->db->where('status','1');
		$this->db->order_by("types.appointment_type", "asc"); 
		$query = $this->db->get();
		$results[''] = 'Select';
		if($query->num_rows()>0){
			foreach($query->result_array() as $result) { 
			    $results[$result['type_id']] = $result['appointment_type'];
			}
		}   	
		return $results;
	}	


	public function searchPatient_result($inputValues) {
	
	
		$firstname = $inputValues['firstname'];
		$surname = $inputValues['surname'];
		$date = $inputValues['date'];

		$this->db->select("*");
		$this->db->from($this->table_patients);
		//$this->db->where('clinic_location_id', $this->encryption->decode($inputValues['clinic_location_id']));
		//$this->db->where_in('clinic_location_id', $inputValues['clinic_locations']);
		$this->db->where('status','1');



		$this->db->like('first_name', $firstname);
		$this->db->like('last_name', $surname);
		$this->db->like('date_of_birth', $date);
		$query = $this->db->get();
		if($query->num_rows()>0){

        	

			$results = $query->result();
			// echo "<pre>";
			// print_r($results);
			
			

		}   	
		return $results;
	}	
	


		public function get_countries() {
	
	

		$this->db->select("*");
		$this->db->from($this->mc_countries);
		$query = $this->db->get();
		if($query->num_rows()>0){

        	

			$results = $query->result();
			
			
			

		}   	
		return $results;
	}	

	public function get_prescriber_info($inputValues) {
	
	
		$this->db->select("appoint.practitioner_id,hpinfo.name,hpinfo.surname,hpinfo.prescriber_number");
		$this->db->from($this->table_appointments .' as appoint');
		$this->db->join($this->table_practitioners .' as hpinfo', 'hpinfo.hp_id = appoint.practitioner_id','inner');
		
		$this->db->where('appoint.appointment_id', $inputValues['appId'] );
		
		$query = $this->db->get();
		$results = $query->result();

		// if($query->num_rows()>0){

        	

			$results = $query->result();
			

			
			

		// }   	
		return $results;
	}	

	public function searchPatient($inputValues) {
		
		$results = array();
		$searchVal = $inputValues['search_for'];
		$this->db->select("*");
		$this->db->from($this->table_patients);
		//$this->db->where('clinic_location_id', $this->encryption->decode($inputValues['clinic_location_id']));
		//$this->db->where_in('clinic_location_id', $inputValues['clinic_locations']);
		$this->db->where('status','1');
		$this->db->where("(first_name LIKE '%$searchVal%' ||
		last_name LIKE '%$searchVal%' ||
		date_of_birth LIKE '%$searchVal%' ||
		gender LIKE '%$searchVal%' ||
		street_address LIKE '%$searchVal%' ||
		street_address2 LIKE '%$searchVal%' ||
		city LIKE '%$searchVal%' ||
		suburb LIKE '%$searchVal%' ||
		state LIKE '%$searchVal%' ||
		country LIKE '%$searchVal%' ||
		postcode LIKE '%$searchVal%' ||
		telephone LIKE '%$searchVal%' ||
		mobile_no LIKE '%$searchVal%' ||
		emergency_contact_no LIKE '%$searchVal%')"); 
		$query = $this->db->get();
		if($query->num_rows()>0){
			$results = $query->result();
		}   	
		return $results;
	}	
	
	// search praction

		public function searchParcts($inputValues) {

		$results = array();
		$searchVal = $inputValues['search_for'];
		$clinicId = $inputValues['clinicId'];

		$this->db->select("*");
		$this->db->from($this->table_practitioners .' as pracs');
		$this->db->join($this->table_mc_hp_clinic_relation .' as clinicRel', 'clinicRel.hp_id = pracs.hp_id','inner');
		//$this->db->where('clinic_location_id', $this->encryption->decode($inputValues['clinic_location_id']));
		//$this->db->where_in('clinic_location_id', $inputValues['clinic_locations']);
		$this->db->where('clinicRel.location_id', $clinicId );
		$this->db->where("(pracs.surname LIKE '%$searchVal%' ||
		pracs.name LIKE '%$searchVal%')"); 
		$query = $this->db->get();
		if($query->num_rows()>0){
			$results = $query->result();
		}

		return $results;
	}	





	//fetch appointment types of clinic
	public function getBillingCodes($clinic_id){
		$results = array();
		$this->db->select("*");
		$this->db->from($this->table_billing_codes);
		$this->db->where('clinic_id',$clinic_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$results = $query->result();
		}   	
		return $results;
	}
	//cancel appointment
	public function cancel_appointment($inputValues) {
                $return = '';
		if($inputValues != '') {
			$ipAddress  					= $this->mc_constants->remote_ip();
			$appnt['status']  				= '0';
			$appnt['last_modified_ip']		= $ipAddress;
			$appnt['last_modified_date']	= @date('Y-m-d H:i:s');
			$appnt['last_modified_by']  	= $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_appointments, $appnt, array('appointment_id' => $this->encryption->decode($inputValues['appnt_id'])));
				$this->db->trans_commit();
				$this->session->set_userdata('appointment_entered_date', $inputValues['appointment_date']);
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
				
		}
                return $return;
	}



//cancel appointment
	public function canceled_calendar_appointment($inputValues) {

		// print_r($inputValues);
		// die('rftgyhjkl');
                $return = '';
		if($inputValues != '') {
			$ipAddress  					= $this->mc_constants->remote_ip();
			$appnt['status']  				= '0';
			$appnt['last_modified_ip']		= $ipAddress;
			$appnt['last_modified_date']	= @date('Y-m-d H:i:s');
			//$appnt['last_modified_by']  	= $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_appointments, $appnt, array('appointment_id' => $this->encryption->decode($inputValues['appnt_id'])));
				$this->db->trans_commit();
				//$this->session->set_userdata('appointment_entered_date', $inputValues['appointment_date']);
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
				
		}
                return $return;
	}






	//cancel roster

	public function cancel_roster($inputValues) {
                $return = '';
		if($inputValues != '') {
			$ipAddress  					= $this->mc_constants->remote_ip();
			$roster['status']  				= '0';
			$roster['last_modified_ip']		= $ipAddress;
			$roster['last_modified_date']	= @date('Y-m-d H:i:s');
			$roster['last_modified_by']  	= $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_mc_roster, $roster, array('roster_id' => $this->encryption->decode($inputValues['roster_id'])));
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
				
		}
                return $return;
	}

	//cancel roster

	public function chkApptRosterSch($inputValues) {

     $this->db->select("*");
		$this->db->from($this->table_mc_roster);
		$this->db->where('roster_id',$inputValues);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$res = $query->row();
			$roster_date = $res->roster_date;
			$start = $res->roster_from;
			$end = $res->roster_to;

			$clinic_loc_id = $res->clinic_location_id;
			$practitioner_id = $res->practitioner_id;
			$startDate =  $roster_date;
			$startTime =  date("H:i:s", strtotime($start));
			$endTime =  date("H:i:s", strtotime($end));

			$this->db->select("*");
			$this->db->from($this->table_appointments ." as appt");
			$this->db->where("appt.practitioner_id",$practitioner_id);
			$this->db->where("appt.appointment_date", $startDate);
			$this->db->where("`appt`.`status` = '1' and  `appt`.`appointment_from` >= '".$startTime."' and  `appt`.`appointment_to` <= '".$endTime."' ");

			//$this->db->where("`appt`.`status` = '1' and '".$startTime."' BETWEEN `appt`.`appointment_from` AND `appt`.`appointment_to` and  '".$endTime."' BETWEEN `appt`.`appointment_from` AND `appt`.`appointment_to`  ");
			$this->db->order_by("appt.appointment_id", "asc"); 
			$query = $this->db->get();
			$result = $query->result_array();
			return count($result);


		}else{
			return '0';
		}  
	}


	//fetch appointment types of clinic
	public function getBillingCodesArray($clinic_id){
		$results = array();
		$results[''] = 'Select Code';
		$this->db->select("*");
		$this->db->from($this->table_billing_codes);
		$this->db->where('clinic_id',$clinic_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result_array() as $result) { 
			    $results[$result['code_id']] = $result['code'];
			} 
		}   	
		return $results;
	}	
	public function create_appointment_type($inputValues) {
		if($inputValues != '') { 
			$ipAddress  = $this->mc_constants->remote_ip();
			$appnt_type['clinic_id']    = $inputValues['clinic_id'];
			$appnt_type['appointment_type']   = $inputValues['appointment_type'];
			$appnt_type['color_code']   = $inputValues['color_code'];
			//$appnt_type['billing_code_id']  = $inputValues['billing_code'];
                        $appnt_type['code'] 	 = $inputValues['billing_code'];
			$appnt_type['currency']  = $inputValues['currency'];
			$appnt_type['price']   	 = $inputValues['price'];
                        $appnt_type['text_color']   = $inputValues['text_color'];
			$appnt_type['status']  	 = '1';
                        $appnt_type['appointment_count']  = $inputValues['appointment_count'];
			$appnt_type['created_ip']   = $ipAddress;
			$appnt_type['created_date'] = @date('Y-m-d H:i:s');
			$appnt_type['created_by']   = $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
				$this->db->insert($this->table_appointment_types, $appnt_type);	
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
		}
	}	
	
	public function insert_recording($upload_name,$inputValues) {
		
		
		
		//if($upload_name != '') { 
			$ipAddress  = $this->mc_constants->remote_ip();
			$appnt_type['file_name']    = $upload_name;
			$appnt_type['appt_id']   = $inputValues['appt_id'];
			$appnt_type['created_at']   = @date('Y-m-d H:i:s');;
			$appnt_type['ip_address']   = $ipAddress;
			
			try {
				$this->db->trans_begin(); 
				$this->db->insert($this->mc_consultation_audio_files, $appnt_type);	
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
		//}
	}
	
	
	
	public function validate_appointment($inputValues) {
		$start_24_hour_format  = date("H:i", strtotime($inputValues['start_time']));
		$end_24_hour_format    = date("H:i", strtotime($inputValues['end_time']));
		$result = array();
		$this->db->select("appointment_id");
		$this->db->from($this->table_appointments);
		$this->db->where('patient_id',$this->encryption->decode($inputValues['patient_id']));
		$this->db->where('status', '1');
		if($inputValues['appointment_id'] != "")
		{
			$this->db->where('appointment_id !=',$inputValues['appointment_id']);
		}
		$this->db->where('appointment_date',$inputValues['appointment_date']);
		$this->db->where("((appointment_from < '$start_24_hour_format' AND appointment_to > '$start_24_hour_format') ||
		(appointment_from < '$end_24_hour_format' AND appointment_to > '$end_24_hour_format') ||
		(appointment_from = '$start_24_hour_format' AND appointment_to = '$end_24_hour_format') ||
		(appointment_from > '$start_24_hour_format' AND appointment_to < '$start_24_hour_format') ||
		(appointment_from > '$end_24_hour_format' AND appointment_to < '$end_24_hour_format'))"); 
		
		$query = $this->db->get();
		
		if($query->num_rows()>0) {
			$result['status'] = 'false';
			$result['msg']    = 'Patient already have an appointment. Please select any other slot. Thank you!';
			echo json_encode($result);exit;
		}
		else {
			$this->db->select("appointment_id");
			$this->db->from($this->table_appointments);
			$this->db->where('practitioner_id',$this->encryption->decode($inputValues['practitioner_id']));
			$this->db->where('status', '1');
			if($inputValues['appointment_id'] != "")
			{
				$this->db->where('appointment_id !=',$inputValues['appointment_id']);
			}
			$this->db->where('appointment_date',$inputValues['appointment_date']);
			$this->db->where("((appointment_from < '$start_24_hour_format' AND appointment_to > '$start_24_hour_format') ||
			(appointment_from < '$end_24_hour_format' AND appointment_to > '$end_24_hour_format') ||
			(appointment_from = '$start_24_hour_format' AND appointment_to = '$end_24_hour_format') ||
			(appointment_from > '$start_24_hour_format' AND appointment_to < '$start_24_hour_format') ||
			(appointment_from > '$end_24_hour_format' AND appointment_to < '$end_24_hour_format'))"); 
			
			$query = $this->db->get();
			if($query->num_rows()>0) {
				$result['status'] = 'false';
				$result['msg']    = 'Practitioner already have an appointment for this slot. Please select any other slot. Thank you!';
				echo json_encode($result);exit;
			} else {
				$result['status'] = 'true';
				echo json_encode($result);exit;
			}
		}
	}



	// Validation for roster if room not available

		public function validate_roster($inputValues) {
		
		$start_24_hour_format  = date("H:i", strtotime($inputValues['start_time']));
		$end_24_hour_format    = date("H:i", strtotime($inputValues['end_time']));

		$result = array();
		$this->db->select("roster_id");
		$this->db->from($this->table_mc_roster);
		//$this->db->where('practitioner_id',$this->encryption->decode($inputValues['practitioner_id']));
		$this->db->where('status', '1');
		$this->db->where('clinic_room_id', $inputValues['room_id']);
		// if($inputValues['appointment_id'] != "")
		// {
		// 	$this->db->where('appointment_id !=',$inputValues['appointment_id']);
		// }
		$this->db->where('roster_date',$inputValues['appointment_date']);
		$this->db->where("((roster_from < '$start_24_hour_format' AND roster_to > '$start_24_hour_format') ||
		(roster_from < '$end_24_hour_format' AND roster_to > '$end_24_hour_format') ||
		(roster_from = '$start_24_hour_format' AND roster_to = '$end_24_hour_format') ||
		(roster_from > '$start_24_hour_format' AND roster_to < '$start_24_hour_format') ||
		(roster_from > '$end_24_hour_format' AND roster_to < '$end_24_hour_format'))"); 
		
		$query = $this->db->get();
		
		if($query->num_rows()>0) {
			$result['status'] = 'false';
			$result['msg']    = 'Other Practitioner exists. Please select any other slot. Thank you!';
			echo json_encode($result);exit;
		}
		else {

			$this->db->select("roster_id");
			$this->db->from($this->table_mc_roster);
			$this->db->where('practitioner_id',$this->encryption->decode($inputValues['practitioner_id']));
			//$this->db->where('status', '1');
			// if($inputValues['appointment_id'] != "")
			// {
			// 	$this->db->where('appointment_id !=',$inputValues['appointment_id']);
			// }
			$this->db->where('roster_date',$inputValues['appointment_date']);
			$this->db->where("((roster_from < '$start_24_hour_format' AND roster_to > '$start_24_hour_format') ||
			(roster_from < '$end_24_hour_format' AND roster_to > '$end_24_hour_format') ||
			(roster_from = '$start_24_hour_format' AND roster_to = '$end_24_hour_format') ||
			(roster_from > '$start_24_hour_format' AND roster_to < '$start_24_hour_format') ||
			(roster_from > '$end_24_hour_format' AND roster_to < '$end_24_hour_format'))"); 
			
			$query = $this->db->get();
			if($query->num_rows()>0) {
				$result['status'] = 'false';
				$result['msg']    = 'Practitioner already exists. Please select any other slot. Thank you!';
				echo json_encode($result);exit;
			} else {
				$result['status'] = 'true';
				echo json_encode($result);exit;
			}
		}

	}


	public function search_check_username($inputValues) {

			if($inputValues != ''){
				$this->db->select('username');
					$this->db->from($this->mc_users);
					$this->db->where('username',$inputValues['username']);
					$query = $this-> db-> get();
					$user_result = $query->row();
					
					 $user_count=count($user_result);
					// print_r($user_result);
					// die(); 
				if($user_count!=0){

					echo "1";

				}else{

						echo "0";
					}
		}				
	}


	public function create_new_appointment($inputValues) {

			if($inputValues != ''){

				 $patient_previous_id=$inputValues['patient_field_id'];
					
				$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($inputValues['pwd']);

			$ipAddress  					= $this->mc_constants->remote_ip();
			$user_data['username']  		= $inputValues['username'];
			$user_data['email']   			= $inputValues['email'];
			$user_data['password']  		= $hashed_password;
		
			$user_data['last_ip']  		= $ipAddress;
			$user_data['created'] 		= @date('Y-m-d H:i:s');
		
	           try 
	           {
	                    $this->db->trans_begin(); 

    		
	                    if(empty($patient_previous_id)){

	                    	$this->db->insert($this->mc_users, $user_data);
    			$last_user_id = $this->db->insert_id();

    			$patient_data['user_id']  		= $last_user_id;
			$patient_data['last_name']   			= $inputValues['add_surname2'];
			$patient_data['first_name']  		= $inputValues['fname'];
			$patient_data['date_of_birth']  		= $inputValues['search_date_of_birth'];
			$patient_data['clinic_location_id']  		= $this->encryption->decode($inputValues['clinic_location_id']);
			$patient_data['gender']  		     = $inputValues['gender'];
		
			$patient_data['created_ip']  		= $ipAddress;
			$patient_data['created_date'] 		= @date('Y-m-d H:i:s');

							// echo "<pre>";
	      // 				  	print_r($patient_data);

			$this->db->insert($this->table_patients, $patient_data);

			$last_patient_id = $this->db->insert_id();

	         $time_24_hour_format  = date("H:i", strtotime($inputValues['appointment_hour'].':'.$inputValues['appointment_minute'].' '.$inputValues['appointment_time_format']));
			$time_24_hour_end_format  = date("H:i", strtotime($inputValues['appointment_end_hour'].':'.$inputValues['appointment_end_minute'].' '.$inputValues['appointment_end_time_format']));
			$ipAddress  			= $this->mc_constants->remote_ip();

			
			

			
			$appnt['patient_id']  		=$last_patient_id;
			$appnt['practitioner_id']   	= $this->encryption->decode($inputValues['location_prac']);
			$appnt['clinic_location_id']  	= $this->encryption->decode($inputValues['clinic_location']);
			$appnt['appointment_type_id']  	= '1';
			$appnt['appointment_date']  	= $inputValues['appointment_date'];
			$appnt['room_id']  	= $inputValues['room_id'];
			$appnt['appointment_from']  	= $time_24_hour_format;
			$appnt['appointment_to'] 	= $time_24_hour_end_format;
            $appnt['appointment_duration']  = $inputValues['appointment_duration'];
			$appnt['appointment_notes']  	= $inputValues['appointment_notes'];
			$appnt['status']  		= '1';
			$appnt['created_ip']  		= $ipAddress;
			$appnt['created_date'] 		= @date('Y-m-d H:i:s');
			$appnt['created_by']   		= $inputValues['author_id'];
                       
                

	                    if($appnt['patient_id'] != 0)
							        {
							            $insertt = '1';
							        }else{
											$insertt = '1';
									}
			

	                     if(isset($insertt))
	      				  {		

	      				  	// echo "<pre>";
	      				  	// print_r($appnt);
	      				  
	                    $this->db->insert($this->table_appointments, $appnt);

						}
					}else {

						 $time_24_hour_format  = date("H:i", strtotime($inputValues['appointment_hour'].':'.$inputValues['appointment_minute'].' '.$inputValues['appointment_time_format']));
			$time_24_hour_end_format  = date("H:i", strtotime($inputValues['appointment_end_hour'].':'.$inputValues['appointment_end_minute'].' '.$inputValues['appointment_end_time_format']));
			$ipAddress  			= $this->mc_constants->remote_ip();
			$appnt['patient_id']  		= $inputValues['patient_field_id'];
			$appnt['patient_id']  		= $inputValues['patient_field_id'];
			$appnt['practitioner_id']   	= $this->encryption->decode($inputValues['location_prac']);
			$appnt['clinic_location_id']  	= $this->encryption->decode($inputValues['clinic_location']);
			$appnt['appointment_type_id']  	= '1';
			$appnt['appointment_date']  	= $inputValues['appointment_date'];
			$appnt['room_id']  	= $inputValues['room_id'];
			$appnt['appointment_from']  	= $time_24_hour_format;
			$appnt['appointment_to'] 	= $time_24_hour_end_format;
            $appnt['appointment_duration']  = $inputValues['appointment_duration'];
			$appnt['appointment_notes']  	= $inputValues['appointment_notes'];
			$appnt['status']  		= '1';
			$appnt['created_ip']  		= $ipAddress;
			$appnt['created_date'] 		= @date('Y-m-d H:i:s');
			$appnt['created_by']   		= $inputValues['author_id'];
                       
                

	                    if($appnt['patient_id'] != 0)
							        {
							            $insertt = '1';
							        }else{
											$insertt = '1';
									}
			

	                     if(isset($insertt))
	      				  {		

	      				  	// echo "<pre>";
	      				  	// print_r($appnt);
	      				  	// die('else');
	                    $this->db->insert($this->table_appointments, $appnt);

					}
				}

	                    $this->db->trans_commit();
	                    $this->session->set_userdata('appointment_entered_date', $appnt['appointment_date']);
					
	            return 'true';			
	            }
	            catch (Exception $e) {
	                    $this->db->trans_rollback();
	                    $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
	            }
	        
	      
				
		}
	}

	// Create new roster book

		public function create_new_roster($inputValues) {

// echo "<pre>";
// 			print_r($inputValues);
// 			die('frghjk');

		if($inputValues != '') { 
			$time_24_hour_format  = date("H:i", strtotime($inputValues['appointment_hour'].':'.$inputValues['appointment_minute'].' '.$inputValues['appointment_time_format']));
			$time_24_hour_end_format  = date("H:i", strtotime($inputValues['appointment_end_hour'].':'.$inputValues['appointment_end_minute'].' '.$inputValues['appointment_end_time_format']));
			$ipAddress  			= $this->mc_constants->remote_ip();
			$appnt['practitioner_id']   	= $this->encryption->decode($inputValues['prac_field_id']);
			$appnt['clinic_location_id']  	= $this->encryption->decode($inputValues['clinic_location']);
			$appnt['clinic_room_id']  	= $inputValues['clinicRoom'];
			$appnt['roster_date']  	= $inputValues['appointment_date'];
			$appnt['roster_from']  	= $time_24_hour_format;
			$appnt['roster_to'] 	= $time_24_hour_end_format;
            $appnt['roster_duration']  = $inputValues['roster_duration'];
			$appnt['status']  		= '1';
			$appnt['created_ip']  		= $ipAddress;
			$appnt['created_date'] 		= @date('Y-m-d H:i:s');
			$appnt['created_by']   		= $inputValues['author_id'];
                       
                        
                        if(isset($appnt['practitioner_id']))
                        {
                            try {
                                    $this->db->trans_begin(); 
                                    $this->db->insert($this->table_mc_roster, $appnt);
                                    $this->db->trans_commit();
                                    $this->session->set_userdata('appointment_entered_date', $appnt['appointment_date']);
								
                            return 'true';			
                            }
                            catch (Exception $e) {
                                    $this->db->trans_rollback();
                                    $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                            }
                        }
                        else
                        {
                            return 'false';
                        }
				
		}
	}








	public function update_appointment($inputValues) {
		if($inputValues != '') { 
			$time_24_hour_format  = date("H:i", strtotime($inputValues['appointment_hour'].':'.$inputValues['appointment_minute'].' '.$inputValues['appointment_time_format']));
			$time_24_hour_end_format  = date("H:i", strtotime($inputValues['appointment_end_hour'].':'.$inputValues['appointment_end_minute'].' '.$inputValues['appointment_end_time_format']));
			$ipAddress  			= $this->mc_constants->remote_ip();
			$appnt['practitioner_id']   	= $this->encryption->decode($inputValues['location_prac']);
			$appnt['appointment_type_id']  	= $inputValues['appointment_type'];
			$appnt['appointment_date']  	= $inputValues['appointment_date'];
			$appnt['appointment_from']  	= $time_24_hour_format;
			$appnt['appointment_to'] 	= $time_24_hour_end_format;
                        $appnt['appointment_duration']  = $inputValues['appointment_duration'];
			$appnt['appointment_notes']  	= $inputValues['appointment_notes'];
			$appnt['status']  		= '1';
			$appnt['last_modified_ip']	= $ipAddress;
			$appnt['last_modified_date']	= @date('Y-m-d H:i:s');
			$appnt['last_modified_by']  	= $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_appointments, $appnt, array('appointment_id' => $inputValues['appointment_id']));
				$this->db->trans_commit();
				$this->session->set_userdata('appointment_entered_date', $appnt['appointment_date']);
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
				
		}
	}	
	public function check_appointment_settings($locationID) {
		$results = array();
		if($locationID!=0 && $locationID!=''){
			$this->db->select("setting_id, appointment_duration, appointment_start_time, appointment_end_time");
			$this->db->from($this->table_appnt_settings);
			$this->db->where('location_id',$locationID);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$results = $query->row();
			}
		}   
		return $results;
	}
	public function appointment_settings($inputValues) {
		if(is_array($inputValues)) {
			$ipAddress	= $this->mc_constants->remote_ip();
			$settings['location_id']   = $inputValues['location_id'];
			$settings['appointment_duration']   = $inputValues['duration'];
			$settings['appointment_start_time'] = date("H:i", strtotime($inputValues['start_time']));
			$settings['appointment_end_time']  	= date("H:i", strtotime($inputValues['end_time']));
		 	if($inputValues['action'] == 'insert') {
				$settings['created_ip']   = $ipAddress;
				$settings['created_date'] = @date('Y-m-d H:i:s');
				$settings['created_by']   = $inputValues['author_id'];	
				try {
					$this->db->trans_begin(); 
					$this->db->insert($this->table_appnt_settings, $settings);
					$this->db->trans_commit();
		        $return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
			}
			else {
				$settings['last_modified_ip']   = $ipAddress;
				$settings['last_modified_date'] = @date('Y-m-d H:i:s');
				$settings['last_modified_by']   = $inputValues['author_id'];	
				try {
					$this->db->trans_begin(); 
					$this->db->update($this->table_appnt_settings, $settings, array('setting_id' => $inputValues['setting_id']));
					$this->db->trans_commit();
		        $return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
			}
		}
	}
	public function get_appointments($clinicLocation, $locationPracs = "") {
		
		$allAppointments = array();
                $casualAppointments = array();
		if($clinicLocation!=0 && $clinicLocation!=''){
                        $this->db->select("appnts.*");
			$this->db->from($this->table_appointments .' as appnts');
			if($locationPracs != '') {
				$prac = array();
				foreach($locationPracs as $locationPrac) {
					//$pracID = intval($this->encryption->decode($locationPrac));
					$pracID = $locationPrac->hp_id;
					$prac[]   = $pracID;
				}
				$pracIDS = implode( ',',$prac);
				
				$this->db->where_in('appnts.practitioner_id', $prac);
			}
			$this->db->where('appnts.clinic_location_id',$clinicLocation);
			$this->db->where('appnts.status', '1');
                        $this->db->where('appnts.patient_id', '0');
                        $casualquery = $this->db->get();
                        
                        if($casualquery->num_rows()>0) {
				foreach($casualquery->result_array() as $casualresult) {
                                    //echo '<pre>'; print_r($casualresult); exit;
                                    $casual_appointment = array();
                                    $startDate = $endDate = "";
                                    //echo $result['practitioner_id'];
                                    $startDate =  date('Y-m-d H:i:s',strtotime($casualresult['appointment_date'].' '.$casualresult['appointment_from']));
                                    $endDate   =  date('Y-m-d H:i:s',strtotime($casualresult['appointment_date'].' '.$casualresult['appointment_to']));
                                    $casual_appointment['id'] 	  = $this->encryption->encode($casualresult['appointment_id']);
                                    
                                    if(strlen($casualresult['appointment_notes']) > 20)
                                    {
                                        $notess = substr($casualresult['appointment_notes'], 0, 20).'..';
                                    }
                                    else
                                    {
                                        $notess = $casualresult['appointment_notes'];
                                    }
                                    $casual_appointment['title'] = $notess;
                                    $casual_appointment['start'] = $startDate;
                                    $casual_appointment['end']   = $endDate;
                                    $casual_appointment['allDay']= false;
                                    $casual_appointment['color'] = '#777';
                                    $casual_appointment['textColor']= 'white';
                                    
                                    $casual_appointment['resourceId'] = intval($casualresult['practitioner_id']);
                                    $casual_appointment['notes'] = $casualresult['appointment_notes'];
                                    //$casual_appointment['image'] = base_url() .'images/pic_icon.png';
                                    
                                    
                                    // Merge the event array into the return array
                                    array_push($casualAppointments, $casual_appointment);                                    
                                    
                                }
                        }
                    
			$this->db->select("appnts.*,appnt_types.color_code,patient.first_name,patient.last_name, patient.image, appnt_types.text_color");
			$this->db->from($this->table_appointments .' as appnts');
			$this->db->join($this->table_patients .' as patient', 'patient.patient_id = appnts.patient_id','inner');
			$this->db->join($this->table_appointment_types .' as appnt_types', 'appnt_types.type_id = appnts.appointment_type_id','inner');
			if($locationPracs != '') {
				$prac = array();
				foreach($locationPracs as $locationPrac) {
					$pracID = $locationPrac->hp_id;
					$prac[]   = $pracID;
				}
				//echo '<pre>'; print_r($prac); die;
				$pracIDS = implode( ',',$prac);
				$this->db->where_in('appnts.practitioner_id', $prac);
			}
			$this->db->where('appnts.clinic_location_id',$clinicLocation);
			$this->db->where('appnts.status', '1');
			$query = $this->db->get();
		
			if($query->num_rows()>0) {
				foreach($query->result_array() as $result) { 
					
					$appointment = array();
					$startDate = $endDate = "";
					$startDate =  date('Y-m-d H:i:s',strtotime($result['appointment_date'].' '.$result['appointment_from']));
					$endDate   =  date('Y-m-d H:i:s',strtotime($result['appointment_date'].' '.$result['appointment_to']));
					$appointment['id'] 	  = $this->encryption->encode($result['appointment_id']);
					$appointment['title'] = $result['first_name'].' '.$result['last_name'];
					$appointment['appt_status'] = $result['appt_status'];
					$appointment['start'] = $startDate;
					$appointment['end']   = $endDate;
					$appointment['allDay']= false;
					$appointment['color'] = '#'.$result['color_code'];
					$textcolorcheck = strtolower($result['text_color']); 
                                        if($textcolorcheck != '')
                                        {
                                            $appointment['textColor']= $textcolorcheck;
                                        }
					$appointment['resourceId'] = intval($result['practitioner_id']);
					$appointment['notes'] = $result['appointment_notes'];
					$root_path                   =  getcwd();
					$image_path                  = 	$root_path .'/'.$result['image']; 
					if($result['image'] !='' && file_exists($image_path)){ 
		 				 $appointment['image'] = base_url() .$result['image'];
					}else{  
						 $appointment['image'] = base_url() .'assets/images/pic_icon.jpg';
				        } 
					
					// Merge the event array into the return array
					array_push($allAppointments, $appointment);
				}				
			}
                        $allAppointments = array_merge($casualAppointments,$allAppointments);
		}   
		return $allAppointments;
	}
	

	// Roster Booking
	public function get_roster($clinicID)
	{

		if($clinicID != 0 && $clinicID != '')
		{
			$allRosters = array();
			$this->db->select("rost.*,prac.title,prac.surname, prac.name");
			$this->db->from($this->table_mc_roster .' as rost');
			$this->db->join($this->table_practitioners .' as prac', 'prac.hp_id = rost.practitioner_id','inner');
			$this->db->where('rost.clinic_location_id',$clinicID);
			$this->db->where('rost.status', '1');
			$query = $this->db->get();
			$RESULT = $query->result_array();
			
			if($query->num_rows()>0) {
				foreach($query->result_array() as $result) { 
					
					$roster = array();
					$startDate = $endDate = "";
					$startDate =  date('Y-m-d H:i:s',strtotime($result['roster_date'].' '.$result['roster_from']));
					$endDate   =  date('Y-m-d H:i:s',strtotime($result['roster_date'].' '.$result['roster_to']));
					$roster['id'] 	  = $this->encryption->encode($result['roster_id']);
					$roster['title'] = $result['title'].' '.$result['surname'].' '.$result['name'];
					$roster['start'] = $startDate;
					$roster['end']   = $endDate;
					$roster['allDay']= false;
					$roster['color'] = 'grey';
                    $roster['textColor']= '#fff';
					$roster['resourceId'] = intval($result['clinic_room_id']);

					// Merge the event array into the return array
					array_push($allRosters, $roster);
				}				
			}

		}
		return $allRosters;
	}


	// Roster booking end


	public function getAppntTypeDetail($type_id){
		$results = array();
		if($type_id!=0 && $type_id!=''){
			$this->db->select("*");
			$this->db->from($this->table_appointment_types);
			$this->db->where('type_id',$type_id);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$results = $query->row();
			}
		}
		return $results;
	}
	public function get_appointment_details($appntID) {
		
		$this->db->select("appnt.*, patient.date_of_birth, rDet.room, patient.title as patient_title, patient.first_name, patient.last_name, patient.mobile_no, prac.title as prac_title, prac.name as prac_first_name, prac.surname as prac_surname");
		$this->db->from($this->table_appointments .' as appnt');
		$this->db->join($this->table_patients .' as patient', 'patient.patient_id = appnt.patient_id','inner');
		$this->db->join($this->mc_clinic_rooms .' as rDet', 'rDet.id = appnt.room_id','inner');
		//$this->db->join($this->table_appointment_types .' as appnt_types', 'appnt_types.type_id = appnt.appointment_type_id','inner');
		$this->db->join($this->table_practitioners .' as prac', 'prac.hp_id = appnt.practitioner_id','inner');
		$this->db->where('appnt.appointment_id', $this->encryption->decode($appntID));
		$query = $this->db->get();
		if($query->num_rows()>0) {
			$results = $query->row();
                        return $results;
		}
		else {
			return array();
		}
	}



	public function get_consultation_history($inputValues) {
		// echo "<pre>";
		// print_r($inputValues);
		// die();
		$appt_ID = $this->encryption->decode($inputValues['appointment_id']); 
		//die();
		$this->db->select("const.*,hpin.title,hpin.surname,hpin.name,clinic.clinic_name,spec.speciality");
		$this->db->from($this->mc_consultation .' as const');
		
		$this->db->join($this->table_practitioners .' as hpin', 'hpin.hp_id = const.hp_id','left');
		$this->db->join($this->mc_clinic .' as clinic', 'clinic.clinic_id =const.medical_clinic','left');
		$this->db->join($this->mc_speciality .' as spec', 'spec.ID =const.speciality','inner');
		$this->db->where('const.appt_id', $appt_ID);
		$query = $this->db->get();
		//print_r($this->db->last_query());

		$consultation_history_details = $query->result_array();

		// echo "<pre>";
		// print_r($consultation_history_details);
		// die();
		

		if($query->num_rows()>0) {
		
                        return $consultation_history_details;
		}
		else {
			return array();
		}
	}


public function get_billing_summery($inputValues) {

			$appt_ID = $this->encryption->decode($inputValues['appointment_id']);   
					// die();
			$this->db->select("ID");
			$this->db->from($this->mc_consultation);
			$this->db->where('appt_id',$appt_ID);
			$query = $this->db->get();

			$consult_ids = $query->result_array();
			//print_r($consult_ids);
				$billingcodes=array();
				foreach ($consult_ids as  $consult_id) {
					//echo $consult_id['ID'];

						$this->db->select("billing_codes_id");
						$this->db->from($this->mc_billing_relation);
						$this->db->where('consultation_id',$consult_id['ID']);
						$query = $this->db->get();

						$billingcodes[] = $query->result_array();
					//	array_push($billingcodes, $billingcode);

				}
				

				//print_r($billingcodes);
				


				$billings = array();
					foreach($billingcodes as $array) {
					 foreach($array as $k=>$v) {
					  $billings[]= $v['billing_codes_id'];
					 }
					}

						$bill_codes= array_unique($billings);
						//print_r($bill_codes);

						$billingdetails = array();
						foreach ($bill_codes as $bill_code) {
							//echo $bill_code;
							$this->db->select("*");
						$this->db->from($this->mc_billing_codes);
						$this->db->where('id',$bill_code);
						$query = $this->db->get();

						$billingdetails[] = $query->result_array();
						}

						$bil_count=count($billingdetails);

				if($bil_count!=0) {
				
		                        return $billingdetails;
				}
				else {
					return array();
				}
	}

public function get_billing_summerybyId($pid) {

		$this->db->select("appointment_id");
		$this->db->from($this->table_appointments .' as appointment');
		$this->db->where('appointment.patient_id', $pid);
		$appId = $this->db->get();

		$appIds = $appId->result_array();

		$billingHistroy = array();

		foreach ($appIds as $value) {
			
			$this->db->select("const.*,bill.billing_codes_id,billcode.*");
			$this->db->from($this->mc_consultation .' as const');
			
			$this->db->join($this->mc_billing_relation .' as bill', 'bill.consultation_id = const.ID','left');
			$this->db->join($this->mc_billing_codes .' as billcode', 'billcode.id = bill.billing_codes_id','left');
			$this->db->where('const.ID', $value['appointment_id']);
			$query = $this->db->get();
			

			$billing = $query->result_array();
			
			if(!empty($billing))
			{
				
				foreach ($billing as $bill) {
					array_push($billingHistroy, $bill);
				}
			}
		}

		if(count($billingHistroy) > 0)
		{
		
            return $billingHistroy;
		}
		else 
		{
			return array();
		}
		
	}



	public function get_consultation_historybyId($pid) {

		$this->db->select("appointment_id");
		$this->db->from($this->table_appointments .' as appointment');
		$this->db->where('appointment.patient_id', $pid);
		$appId = $this->db->get();

		$appIds = $appId->result_array();
		
		$consultHistroy = array();
		$newComArry = array();
		
		foreach ($appIds as $value) {
			
			$this->db->select("const.*,hpin.title,hpin.surname,hpin.name,clinic.clinic_name,spec.speciality");
			$this->db->from($this->mc_consultation .' as const');
			
			$this->db->join($this->table_practitioners .' as hpin', 'hpin.hp_id = const.hp_id','left');
			$this->db->join($this->mc_clinic .' as clinic', 'clinic.clinic_id =const.medical_clinic','left');
			$this->db->join($this->mc_speciality .' as spec', 'spec.ID =const.speciality','inner');
			$this->db->where('const.appt_id', $value['appointment_id']);
			$query = $this->db->get();
			//print_r($this->db->last_query());

			$consultation = $query->result_array();
			if(!empty($consultation))
			{
				
				foreach ($consultation as $con) {
					array_push($consultHistroy, $con);
				}
			}
			
			
			
		}
		

		if(count($consultHistroy) > 0)
		{
		
            return $consultHistroy;
		}
		else 
		{
			return array();
		}
		
	}


	//Show Roster details
	public function get_roster_pop_details($rosterID) {
		$this->db->select("rost.*, prac.title, prac.title, prac.surname, prac.name, cliRoom.room");
		$this->db->from($this->table_mc_roster .' as rost');
		$this->db->join($this->table_practitioners .' as prac', 'prac.hp_id = rost.practitioner_id','inner');
		$this->db->join($this->table_mc_clinic_rooms .' as cliRoom', 'cliRoom.id = rost.clinic_room_id','left');
		$this->db->where('rost.roster_id', $this->encryption->decode($rosterID));
		$query = $this->db->get();
		if($query->num_rows()>0) {
			$results = $query->row();
			
                        return $results;
		}
		else {
			return array();
		}
	}

	
        public function get_appoint_data($appntID) {
		$this->db->select("appnt.*");
		$this->db->from($this->table_appointments .' as appnt');
		$this->db->where('appnt.appointment_id', $this->encryption->decode($appntID));
		$query = $this->db->get();
		if($query->num_rows()>0) {
			$results = $query->row();
                        return $results;
		}
		else {
			return array();
		}
	}        
	public function patient_info($patientID = "") {
		if($patientID!=0 && $patientID!=''){
			$this->db->select("patient_id, title, first_name, last_name");
			$this->db->from($this->table_patients);
			$this->db->where('patient_id', $patientID);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$results = $query->row();
			}
			return $results;
		}
	}
	public function update_appointment_type($inputValues){
		$return = false;
		if(is_array($inputValues)) { 
			$ipAddress                       = $this->mc_constants->remote_ip();
			$appntType['appointment_type']   = $inputValues['appointment_type'];
			$appntType['color_code']   	 	 = $inputValues['color_code'];
			//$appntType['billing_code_id']  	 = $inputValues['billing_code'];
                        $appntType['code'] 	 = $inputValues['billing_code'];
			$appntType['currency']  = $inputValues['currency'];
			$appntType['price']   	 = $inputValues['price'];
                        $appntType['text_color']   = $inputValues['text_color'];
                        $appntType['appointment_count']  = $inputValues['appointment_count'];
			$appntType['last_modified_ip']   = $ipAddress;
			$appntType['last_modified_date'] = @date('Y-m-d H:i:s');
			$appntType['last_modified_by']   = $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_appointment_types, $appntType, array('type_id' => $inputValues['type_id']));
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
            
		} 
		 return $return;
	}
	public function update_appointment_type_status($inputValues){
		$return = false;
		if(is_array($inputValues)) {
			$ipAddress                       = $this->mc_constants->remote_ip();
			$appntType['status']   	 	 	 = $inputValues['status'];
			$appntType['last_modified_ip']   = $ipAddress;
			$appntType['last_modified_date'] = @date('Y-m-d H:i:s');
			$appntType['last_modified_by']   = $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_appointment_types, $appntType, array('type_id' => $inputValues['type_id']));
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
            
		}
		 return $return;
	}
        public function update_appointment_type_tax($inputValues){
		$return = false;
		if(is_array($inputValues)) {
			$ipAddress                       = $this->mc_constants->remote_ip();
			$appntType['is_tax']   	 	 	 = $inputValues['is_tax'];
			$appntType['last_modified_ip']   = $ipAddress;
			$appntType['last_modified_date'] = @date('Y-m-d H:i:s');
			$appntType['last_modified_by']   = $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_appointment_types, $appntType, array('type_id' => $inputValues['type_id']));
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
            
		}
		 return $return;
	}
	public function getBillingCodeDetail($code_id){
		$results = array();
		if($code_id!=0 && $code_id!='') {
			$this->db->select("*");
			$this->db->from($this->table_billing_codes);
			$this->db->where('code_id',$code_id);
			$query = $this->db->get();
			if($query->num_rows()>0) {
				$results = $query->row();
			}
		}   
		return $results;
	}
	public function create_billing_code($inputValues) {
		if($inputValues != '') {
			$ipAddress  = $this->mc_constants->remote_ip();
			$billing['clinic_id']    = $inputValues['clinic_id'];
			$billing['code'] 	 = $inputValues['billing_code'];
			$billing['currency']  	 = $inputValues['currency'];
			$billing['price']   	 = $inputValues['price'];
			$billing['status']  	 = '1';
			$billing['created_ip']   = $ipAddress;
			$billing['created_date'] = @date('Y-m-d H:i:s');
			$billing['created_by']   = $inputValues['author_id'];	
			try {
				$this->db->trans_begin(); 
			   $this->db->insert($this->table_billing_codes, $billing);
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
		}
	}


	public function insert_instruction_patient($inputValues,$filename) {
		// print_r($inputValues);
		// die();
		if($inputValues != '' || $filename !='') {
	
				if($filename == ''){

				$ipAddress  = $this->mc_constants->remote_ip();
			$inst_patient['url']    = $inputValues['url'];
			$inst_patient['appt_id']    = $inputValues['appt_id'];
			//$inst_patient['file_name'] 	 	 = $filename;
			//$inst_patient['file_path']  	 = base_url().'assets/images/appointment/';
			$inst_patient['created_ip']   = $ipAddress;
			$inst_patient['created_date'] = @date('Y-m-d H:i:s');


				} else{

			$ipAddress  = $this->mc_constants->remote_ip();
			$inst_patient['url']    = $inputValues['url'];
			$inst_patient['appt_id']    = $inputValues['appt_id'];
			$inst_patient['file_name'] 	 	 = $filename;
			$inst_patient['file_path']  	 = base_url().'assets/images/appointment/';
			$inst_patient['created_ip']   = $ipAddress;
			$inst_patient['created_date'] = @date('Y-m-d H:i:s');
			//$inst_patient['created_by']   = $inputValues['author_id'];	

			}

			try {
				$this->db->trans_begin(); 
			   $this->db->insert($this->mc_instruction_to_patient, $inst_patient);
				$this->db->trans_commit();
		        $return = '1';				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
			return $return;
		}
	}



	public function update_billing_code($inputValues) {
		$return = false;
		if(is_array($inputValues)) {
			$ipAddress                     = $this->mc_constants->remote_ip();
			$billing['code']     		   = $inputValues['billing_code'];
			$billing['currency']   	 	   = $inputValues['currency'];
			$billing['price']   	 	   = $inputValues['price'];
			$billing['last_modified_ip']   = $ipAddress;
			$billing['last_modified_date'] = @date('Y-m-d H:i:s');
			$billing['last_modified_by']   = $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_billing_codes, $billing, array('code_id' => $inputValues['code_id']));
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
            
		}
		 return $return;
	}
	public function update_billing_code_status($inputValues){
		$return = false;
		if(is_array($inputValues)) {
			$ipAddress                       = $this->mc_constants->remote_ip();
			$appntType['status']   	 	 	 = $inputValues['status'];
			$appntType['last_modified_ip']   = $ipAddress;
			$appntType['last_modified_date'] = @date('Y-m-d H:i:s');
			$appntType['last_modified_by']   = $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_billing_codes, $appntType, array('code_id' => $inputValues['code_id']));
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
            
		}
		 return $return;
	}
        
        public function is_itemcode_available($code = "",$clinicid = "",$type_id = "") {
		        $this->db->select("type_id");
			$this->db->from($this->table_appointment_types .' as types');
			$this->db->where('types.code',$code);
			$this->db->where('types.clinic_id',$clinicid);
                        
                        if($type_id != '')
                        {
                            $this->db->where('types.type_id !=',$type_id);
                        }
                        
			$query = $this->db->get();
			$numRows = $query->num_rows();
			return $numRows;
		
	}
        
         public function get_patient_appointments($patient_id = "") {
                $results = array();
                $this->db->select("appoints.*,appnt_types.appointment_count");
                $this->db->from($this->table_appointments .' as appoints');
                $this->db->join($this->table_appointment_types .' as appnt_types', 'appnt_types.type_id = appoints.appointment_type_id','inner');
                $this->db->where('appoints.patient_id',$patient_id);
                $this->db->where('appoints.status','1');
                $this->db->where('appoints.is_casual','0');                

                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                   $results = $query->result_array(); 
                }                
                return $results;
		
	}
        
        public function get_patient_appointment_counts($patient_id = "",$app_type_id = "") {
                $results = array();
                $this->db->select("appoints.*,appnt_types.appointment_count");
                $this->db->from($this->table_appointment_counts .' as appoints');
                $this->db->join($this->table_appointment_types .' as appnt_types', 'appnt_types.type_id = appoints.type_id','inner');
                $this->db->where('appoints.patient_id',$patient_id);
                $this->db->where('appoints.type_id',$app_type_id);
                
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                   $results = $query->row(); 
                }                
                return $results;
		
	}
        
        public function insert_patient_appointment_counts($patient_id = "",$app_type_id = "",$appoint_count = "",$author_id = "") {
                $ipAddress                         = $this->mc_constants->remote_ip();
                $appntCount['patient_id']          = $patient_id;
                $appntCount['type_id']             = $app_type_id;
                $appntCount['patient_visit_count'] = $appoint_count;
                $appntCount['created_ip']          = $ipAddress;
                $appntCount['created_date']        = @date('Y-m-d H:i:s');
                $appntCount['created_by']          = $author_id;
                
                try {
                        $this->db->trans_begin(); 
                   $this->db->insert($this->table_appointment_counts, $appntCount);
                        $this->db->trans_commit();
                $return = true;				
                }
                catch (Exception $e) {
                        $this->db->trans_rollback();
                        $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                }
        }


        public function insert_new_patient($inputValues) {
 			$clinic_location_id = $this->encryption->decode($inputValues['clinic_location_id']); 
				
					$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
					$hashed_password = $hasher->HashPassword($inputValues['pwd']);

                $ipAddress                           = $this->mc_constants->remote_ip();
                $patient_user['username']          	 = $inputValues['username'];
                $patient_user['email']               = $inputValues['email'];
                $patient_user['password']            = $hashed_password;
             
               
                $patient_user['last_ip']          = $ipAddress;
                $patient_user['created']        = @date('Y-m-d H:i:s');
                //$appntCount['created_by']          = $author_id;
                
					$this->db->select('username');
					$this->db->from($this->mc_users);
					$this->db->where('username',$inputValues['username']);
					$query = $this-> db-> get();
					$user_result = $query->result();
					
					 $user_count=count($user_result);

				if($user_count!=0){

					echo "1";

				}else{

                try {
                        $this->db->trans_begin(); 
				// echo "<pre>";
				// print_r($patient_user);

				


                   $this->db->insert( $this->mc_users, $patient_user);

                $insert_id = $this->db->insert_id();

 				$patient_table['user_id']          	 = $insert_id;
 				$patient_table['clinic_location_id']  = $clinic_location_id;
 				$patient_table['first_name']          	 = $inputValues['fname'];
                $patient_table['last_name']               = $inputValues['surname'];
                $patient_table['gender']            = $inputValues['gender'];
                $patient_table['country']            = $inputValues['country'];
                $patient_table['date_of_birth']            = $inputValues['dob'];
             
               
                $patient_table['created_ip']          = $ipAddress;
                $patient_table['created_date']        = @date('Y-m-d H:i:s');
                //$appntCount['created_by']          = $author_id;

 				$this->db->insert( $this->table_patients, $patient_table);
				// echo "<pre>";
				// print_r($patient_table);
				
                        $this->db->trans_commit();
                $return = true;				
                }
                catch (Exception $e) {
                        $this->db->trans_rollback();
                        $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                }

            }
        }

        
        public function update_patient_appointment_counts($patient_id = "",$app_type_id = "",$appoint_count = "",$author_id = "") {
                $return = false;
		if($app_type_id != '') {
			$appntCount['patient_visit_count'] = $appoint_count;
			$appntCount['last_modified_date']  = @date('Y-m-d H:i:s');
			$appntCount['last_modified_by']    = $author_id;
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_appointment_counts, $appntCount, array('patient_id' => $patient_id, 'type_id' => $app_type_id));
				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
            
		}
		 return $return;
        }
        
        /* function to update patient appointment counter details *************/
	public function reset_patient_appointment_counter($formFields){
		
		$ret_msg     = false;
		$ipAddress   = $this->mc_constants->remote_ip();
		$patient_id = $this->encryption->decode($formFields['patient_id']);
		$appntCount = array();
                $resetCount = array();
                $currentdate = @date('Y-m-d H:i:s');
                
                $appntCount['patient_visit_count'] = 0;
                $appntCount['last_modified_date']  = $currentdate;
                $appntCount['last_modified_by']    = $formFields['last_modified_by'];              
                
                try {
                        $this->db->trans_begin(); 
                        $this->db->update($this->table_appointment_counts, $appntCount, array('patient_id' => $patient_id));
                        $this->db->trans_commit();
                        $return = true;				
                }
                catch (Exception $e) {
                        $this->db->trans_rollback();
                        $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                }
                
                /* fetch type ids and insert reset logs in resetcount table ***********/
                $results = array();
                $this->db->select("appoints.type_id");
                $this->db->from($this->table_appointment_counts .' as appoints');
                $this->db->where('appoints.patient_id',$patient_id);
                
                $query = $this->db->get();
                if($query->num_rows()>0)
                {
                   $results = $query->result_array(); 
                   foreach($results as $result)
                   {
                        $resetCount['patient_id'] = $patient_id;
                        $resetCount['type_id'] = $result['type_id'];
                        $resetCount['reset_date'] = $currentdate;
                        $resetCount['is_clinic'] = $formFields['is_clinic'];
                        $resetCount['is_practitioner'] = $formFields['is_practitioner'];
                        $resetCount['created_by'] = $formFields['created_by'];
                        $resetCount['created_ip'] = $ipAddress;
                        
                        try {
                                $this->db->trans_begin(); 
                                $this->db->insert($this->table_appointment_resetcounts, $resetCount);
                                $this->db->trans_commit();
                                $returnlog = true;				
                        }
                        catch (Exception $e) {
                                $this->db->trans_rollback();
                                $returnlog = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                        }
                   }
                }             
                
		return $return;
	}


	public function get_roster_details($rosterID) {
		
		$this->db->select("rost.*, prac.title as prac_title, prac.name as prac_first_name, prac.surname as prac_surname");
		$this->db->from($this->table_mc_roster .' as rost');
		$this->db->join($this->table_practitioners .' as prac', 'prac.hp_id = rost.practitioner_id','inner');
		$this->db->where('rost.roster_id', $this->encryption->decode($rosterID));
		$query = $this->db->get();
		if($query->num_rows()>0) {
			$results = $query->row();
			
                        return $results;
		}
		else {
			return array();
		}
	}
	
		public function update_roster($inputValues) {
			
		if($inputValues != '') { 
			$time_24_hour_format  = date("H:i", strtotime($inputValues['appointment_hour'].':'.$inputValues['appointment_minute'].' '.$inputValues['appointment_time_format']));
			$time_24_hour_end_format  = date("H:i", strtotime($inputValues['appointment_end_hour'].':'.$inputValues['appointment_end_minute'].' '.$inputValues['appointment_end_time_format']));
			$ipAddress  			= $this->mc_constants->remote_ip();
			$roster['practitioner_id']   	= $this->encryption->decode($inputValues['prac_field_id']);
			$roster['roster_date']  	= $inputValues['appointment_date'];
			$roster['roster_from']  	= $time_24_hour_format;
			$roster['roster_to'] 	= $time_24_hour_end_format;
            $roster['roster_duration']  = $inputValues['updated_duration'];
            $roster['clinic_room_id']  = $inputValues['clinicRoom'];
            $roster['clinic_location_id']  = $inputValues['clinicID'];
			$roster['status']  		= '1';
			$roster['last_modified_ip']	= $ipAddress;
			$roster['last_modified_date']	= @date('Y-m-d H:i:s');
			$roster['last_modified_by']  	= $inputValues['author_id'];
			try {
				$this->db->trans_begin(); 
			    $this->db->update($this->table_mc_roster, $roster, array('roster_id' => $inputValues['roster_id']));
				$this->db->trans_commit();
				$this->session->set_userdata('appointment_entered_date', $roster['appointment_date']);
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
				
		}
	}


	// Roster Booking
	public function get_medications($appId)
	{

		if($appId != 0 && $appId != '')
		{
			$allRosters = array();
			$this->db->select("med.*, freq.frequency, rou.route");
			$this->db->from($this->mc_medication .' as med');
			$this->db->join($this->mc_frequency .' as freq', 'freq.ID = med.route_id','inner');
			$this->db->join($this->mc_route .' as rou', 'rou.ID = med.freq_id','inner');
			$this->db->where('med.appt_id',$appId);
			$this->db->where('med.status','1');
			$query = $this->db->get();
			$result = $query->result();

			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		}
		
	}
	
	
	
	
		public function insert_consultation($inputValues,$config,$files,$pdf_name){
	
	   $hpID = $this->encryption->encode($inputValues['hp_id']); 
	 $hpname = $inputValues['hp_name']; 

		// echo "<pre>";
		// print_r($inputValues);

		// echo "<pre>";
		// print_r($_FILES);
		// die('eghjk');
		


		$return = false;
		if(is_array($inputValues)) {
		
		 $consultType['hp_id']   	 	 	 = $inputValues['hp_id'];
	
			$consultType['appt_id']   	 	 = $inputValues['appointment_id'];
			$consultType['speciality']   	 	 = $inputValues['speciality'];
			$consultType['consultation_type']    = $inputValues['consultation_type'];
			$consultType['medical_clinic']    = $inputValues['medical_clinic'];
			$consultType['patient_access']    = $inputValues['public_access'];
			$consultType['status']    = $inputValues['public_access'];
			$ipAddress                       = $this->mc_constants->remote_ip();
			//$consultType['status']   	 	 	 = $inputValues['status'];
			$consultType['created_ip']   = $ipAddress;
			$consultType['created_date'] = @date('Y-m-d H:i:s');
			
			
		
			// 	echo "<pre>";
			// print_r($consultType);
			// 	die();
			//$appntType['last_modified_by']   = $inputValues['author_id'];
		 $billingType['billing_detail']   	 	 	 = $inputValues['billing_detail'];
		
		
		 $billingType['billing_detail']=trim($billingType['billing_detail'], ",");
		$billing_codes=explode(",",$billingType['billing_detail']);
	
			try {

			$this->db->trans_begin(); 
			
			
			    $this->db->insert($this->mc_consultation, $consultType);
			
				 $insert_id = $this->db->insert_id();
			
				$length = count($billing_codes);
				for ($i = 0; $i < $length; $i++) {
				
				 $billing_code['consultation_id']=$insert_id;
				 $billing_code['billing_codes_id']=$billing_codes[$i];
				//  echo "<pre>";
				// print_r($billing_code);

				  $this->db->insert($this->mc_billing_relation, $billing_code);
				  
				 }
				
				  $consultInvest['consultation_id']=$insert_id;
				 $consultInvest['serviceprovider'] = $inputValues['serviceprovider'];
			$consultInvest['type_of_investigation'] = $inputValues['type_of_investigation'];
			$consultInvest['clinical_notes'] = $inputValues['clinical_notes'];
			//$consultInvest['image_name'] = $files['investigation']['name'];
		//	$consultInvest['image_path'] =base_url().'assets/images/newconsult/'.$hpID.'_'.$hpname.'/';
		
			$consultInvest['created_ip'] =  $ipAddress;
			$consultInvest['created_date'] = @date('Y-m-d H:i:s');
			//  echo "<pre>";
			// print_r($consultInvest);  
			
			$this->db->insert($this->mc_consult_investigation, $consultInvest);

				 $cons_invest_media=count($files['investigation']['name']);
				
			//print_r($files['investigation']['name']);

			for ($i = 0; $i < $cons_invest_media; $i++) {
		$consultInvest_media['consultation_id']=$insert_id;
			$consultInvest_media['media_name'] = $files['investigation']['name'][$i];
		
			$consultInvest_media['media_path'] =base_url().'assets/images/newconsult/'.$hpID.'_'.$hpname.'/';
		
			$consultInvest_media['created_ip'] =  $ipAddress;
			$consultInvest_media['created_date'] = @date('Y-m-d H:i:s');

			// echo "<pre>";
			// print_r($consultInvest_media);
			$this->db->insert($this->mc_consult_investigation_media, $consultInvest_media);

			 }
				 
				   $consultRefferal['consultation_id']=$insert_id;
				 $consultRefferal['refferal_title'] = $inputValues['refferal_title'];
			$consultRefferal['health_professional'] = $inputValues['hp_id_by_search'];
			$consultRefferal['refferal_notes'] = $inputValues['refferal_notes'];
			
			//$consultRefferal['image_name'] = $files['refferal']['name'];
			//$consultRefferal['image_path'] =base_url().'assets/images/newconsult/'.$hpID.'_'.$hpname.'/';
		
			$consultRefferal['created_ip'] =  $ipAddress;
			$consultRefferal['created_date'] = @date('Y-m-d H:i:s');

			// echo "<pre>";
			// print_r($consultRefferal);

				 $this->db->insert($this->mc_consult_refferal, $consultRefferal);




				 $cons_reff_media=count($files['refferal']['name']);
				
			//print_r($files['investigation']['name']);

			for ($i = 0; $i < $cons_reff_media; $i++) {
			$consult_reff_media['consultation_id']=$insert_id;
			$consult_reff_media['image_name'] = $files['refferal']['name'][$i];
			
			$consult_reff_media['image_path'] =base_url().'assets/images/newconsult/'.$hpID.'_'.$hpname.'/';
		
			$consult_reff_media['created_ip'] =  $ipAddress;
			$consult_reff_media['created_date'] = @date('Y-m-d H:i:s');

			// echo "<pre>";
			// print_r($consult_reff_media);
			$this->db->insert($this->mc_consult_refferal_media, $consultInvest_media);

			 }


				
		 		 $consult_media_count=count($files['mediafiles']['name']);
		 		 if (empty($consult_media_count)) {

			for ($i = 0; $i < $consult_media_count; $i++) {
			 
			  $consultmedia['consultation_id']=$insert_id;

			$consultmedia['media_name'] =$files['mediafiles']['name'][$i];
			
			
			$consultmedia['media_path'] =base_url().'assets/images/newconsult/'.$hpID.'_'.$hpname.'/';
		
			$consultmedia['created_ip'] =  $ipAddress;
			$consultmedia['created_date'] = @date('Y-m-d H:i:s');
			
			// echo "<pre>";
			// print_r($consultmedia);	 
			
			$this->db->insert( $this->mc_consultation_media, $consultmedia);	
				}
			}

			  

			 	//// capture image uploading
			 		$capture_media=$inputValues['media'];
			 		 $capture_image_count=count($capture_media);
				if (empty($capture_image_count)) {

				for ($i = 0; $i < $capture_image_count; $i++) {
			 	
					$capturemedia['consultation_id']=$insert_id;
				$capturemedia['media_name']=basename($capture_media[$i]);
				 $capturemedia['media_path']= dirname($capture_media[$i]).'/';

				$capturemedia['created_ip'] =  $ipAddress;
				$capturemedia['created_date'] = @date('Y-m-d H:i:s');
				// echo "<pre>";
				// print_r($capturemedia);
			$this->db->insert( $this->mc_consultation_media, $capturemedia);	
			 	}
			 }
			 ///capture image uploading

				 
			 	  $consult_clinical_notes['consultation_id']=$insert_id;
				$consult_clinical_notes['pdf_name'] =$pdf_name;
			
			
			$consult_clinical_notes['pdf_path'] =base_url().'assets/images/newconsult/'.$hpID.'_'.$hpname.'/';
		
			$consult_clinical_notes['created_ip'] =  $ipAddress;
			$consult_clinical_notes['created_date'] = @date('Y-m-d H:i:s');
				 

			// echo "<pre>";
			// print_r($consult_clinical_notes);


			 $this->db->insert( $this->mc_consult_clinical_notes, $consult_clinical_notes);	 
				

				//die('done');

				$this->db->trans_commit();
		        $return = true;				
		    }
			catch (Exception $e) {
				$this->db->trans_rollback();
				$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
            
		}
		 return $return;
	}

		
	
	
	public function get_previous_medications($appId)
	{

		if($appId != 0 && $appId != '')
		{
			$allRosters = array();
			$this->db->select("med.*, freq.frequency, rou.route");
			$this->db->from($this->mc_medication .' as med');
			$this->db->join($this->mc_frequency .' as freq', 'freq.ID = med.route_id','inner');
			$this->db->join($this->mc_route .' as rou', 'rou.ID = med.freq_id','inner');
			$this->db->where('med.appt_id',$appId);
			$this->db->where('med.status','0');
			$query = $this->db->get();
			$result = $query->result();
		
			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		}
		
	}
	
	
	
	public function get_show_medications($ID)
	{

		if($ID != 0 && $ID != '')
		{
			$allRosters = array();
			$this->db->select("med.*, freq.frequency, rou.route");
			$this->db->from($this->mc_medication .' as med');
			$this->db->join($this->mc_frequency .' as freq', 'freq.ID = med.route_id','inner');
			$this->db->join($this->mc_route .' as rou', 'rou.ID = med.freq_id','inner');
			$this->db->where('med.id',$ID);
			$this->db->where('med.status','1');
			$query = $this->db->get();
			$result = $query->result();
		
			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		}
		
	}
	
	
		public function new_consult($appntID)
	{
			$query = $this->db->get_where('mc_appointments', array('appointment_id' => $appntID));
			$result = $query->result();
			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		
		
	}
	
	public function practitioner_detail($practitioner_id)
	{       
			
		
		
			$this->db->select("prac.*, spec.speciality, hp_clinic.location_id,clinic.clinic_name");
			$this->db->from($this->table_practitioners .' as prac');
			$this->db->join($this->mc_speciality .' as spec', 'spec.ID = prac.speciality','inner');
			$this->db->join($this->table_mc_hp_clinic_relation .' as hp_clinic', 'hp_clinic.hp_id = prac.hp_id','inner');
			$this->db->join($this->mc_clinic .' as clinic', 'clinic.clinic_id = hp_clinic.location_id','inner');
			$this->db->where('prac.hp_id',$practitioner_id);
		//	$this->db->where('med.status','1');
			$query = $this->db->get();
			$result = $query->result();
			// print_r($result);
			// die();
			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		
	}
	
	public function billing_detail($inputValues)
	{       
	
		$id= $inputValues['id'];
		$value=$inputValues['value'];

			$this->db->select("*");
			$this->db->from($this->mc_billing_codes);
			$this->db->where('status', '1');
			$this->db->like($id, $value);
			$query = $this->db->get();
			$result = $query->result();
		
	
			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		
	}
	
	public function hp_info_on_form($inputValues)
	{   
	
			$value=$inputValues['value'];

			$this->db->select("hp_id,name,surname");
			$this->db->from($this->table_practitioners);
			/*$this->db->where('status', '1');*/
			//$this->db->like(array('name' => $value, 'surname' => $value));
			 $this->db->like('name', $search);
			$this->db->like('surname', $value);
			
			$query = $this->db->get();
			$result = $query->result();
		// echo "<pre>";
		// print_r($result);
	
			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		
	}
	
	
		public function get_clinic_admin_form($inputValues)
	{   
	
			$value=$inputValues['value'];

			$this->db->select("id,fname,lname");
			$this->db->from($this->mc_clinic_admin);
			
			 $this->db->like('fname', $value);
			$this->db->or_like('lname', $value);
			
			$query = $this->db->get();
			$result = $query->result();
			// echo "<pre>";
			// print_r($result);
			// die();
			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		
	}
	

	//Save medication
	public function save_medications($info){
		 		$ipAddress  = $this->mc_constants->remote_ip();
		 		$userdata = $this->session->all_userdata();
  		 		$uId = $userdata['user_id'];
                $appntCount['appt_id']    = $info['appointment_id'];
                $appntCount['medication'] = $info['medication'];
                $appntCount['dose'] 	  = $info['dose'];
                $appntCount['route_id']   = $info['route'];
                $appntCount['freq_id'] 	  = $info['frequency'];
                $appntCount['notes'] 	  = $info['notes'];
                $appntCount['startdate']  = $info['startdate'];
                $appntCount['enddate'] 	  = $info['enddate'];
                $appntCount['created_ip']          = $ipAddress;
                $appntCount['created_date']        = @date('Y-m-d H:i:s');
                $appntCount['created_by']          = $uId;
                
                try {
                        $this->db->trans_begin(); 
                   $this->db->insert($this->mc_medication, $appntCount);
                        $this->db->trans_commit();
                $return = true;				
                }
                catch (Exception $e) {
                        $this->db->trans_rollback();
                        $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                }
	}
	
	//**** for patient details popup *****/
	public function getPatientDetails($appointmentId)

	{
		
		
		if($appointmentId != 0 && $appointmentId != '')
		{
			$allRosters = array();
			$this->db->select("patient.*, appointment.appointment_id,appointment.patient_id");
			$this->db->from($this->table_patients .' as patient');
			$this->db->join($this->table_appointments .' as appointment', 'patient.patient_id = appointment.patient_id','inner');
			$this->db->where('appointment.appointment_id',$appointmentId);
			$query = $this->db->get();
			

			$result = $query->result();
			// print_r($result);
			// die();

			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		}
		
	}
	//**** for patient details popup *****/
	public function getPatientDetailsbyId($pid)

	{
		
		
		if($pid != 0 && $pid != '')
		{
			$allRosters = array();
			$this->db->select("patient.*");
			$this->db->from($this->table_patients .' as patient');
			$this->db->where('patient.patient_id',$pid);
			$query = $this->db->get();
			

			$result = $query->result();
			// print_r($result);
			// die();

			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		}
		
	}


public function insert_consult_upload_pdf($inputValues,$config)

	{
			
		
				$ipAddress  = $this->mc_constants->remote_ip();
		 		
  		 		
                $consultpdf['user_id']    = $inputValues['user_id'];
                $consultpdf['pdf_name'] = $config['file_name'];
            	$consultpdf['pdf_path']  	 = base_url().'assets/images/newconsult/pdf/';
                $consultpdf['created_ip']          = $ipAddress;
                $consultpdf['created_date']        = @date('Y-m-d H:i:s');
            
                try {
                        $this->db->trans_begin(); 
                   $this->db->insert($this->mc_consult_pdf, $consultpdf);
                        $this->db->trans_commit();
                $return = true;				
                }
                catch (Exception $e) {
                        $this->db->trans_rollback();
                        $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                }
		

			return $return;
	}

public function get_all_consult_pdf($userid)

	{			//echo $userid;
		
				
		if($userid != 0 && $userid != '')
		{
			$allRosters = array();
			$this->db->select("*");
			$this->db->from($this->mc_consult_pdf);
			$this->db->where('user_id',$userid);
			$query = $this->db->get();
			

			$result = $query->result();
			// echo "<pre>";
			// print_r($result);
		

			if(count($result) > 0){
				return $result;		
			}else{
				return false;
			}
		}

	}






	//**** for patient details popup ends*****/
}
