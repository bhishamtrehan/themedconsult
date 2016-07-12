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

	public function create_new_appointment($inputValues) {
		
		if($inputValues != '') { 
			$time_24_hour_format  = date("H:i", strtotime($inputValues['appointment_hour'].':'.$inputValues['appointment_minute'].' '.$inputValues['appointment_time_format']));
			$time_24_hour_end_format  = date("H:i", strtotime($inputValues['appointment_end_hour'].':'.$inputValues['appointment_end_minute'].' '.$inputValues['appointment_end_time_format']));
			$ipAddress  			= $this->mc_constants->remote_ip();
			$appnt['patient_id']  		= $this->encryption->decode($inputValues['patient_field_id']);
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
	           try {
	                    $this->db->trans_begin(); 
	                    $this->db->insert($this->table_appointments, $appnt);
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

	// Create new roster book

		public function create_new_roster($inputValues) {

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
            $appnt['roster_duration']  = $inputValues['appointment_duration'];
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
            $roster['roster_duration']  = $inputValues['roster_duration'];
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
}
