<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * General
 *
 * This model handles practitioner role related queries. It operates the following tables:
 * - Universal appointment types,
  *
 * @author	Visions 05/10/2015
 */
class General extends CI_Model
{
	private $table_appointment_types	= 'mc_clinic_appointment_types';			// Clinic appointment types
	private $table_billing_codes		= 'mc_billing_codes';			// Clinic billing codes
	private $table_patients				= 'mc_patients';			// Clinic patients
	private $table_practitioners		= 'mc_hp_info';			// Clinic practitioners
	private $table_appointments			= 'mc_appointments';			// Clinic appointments
	private $table_prac_locations		= 'mc_practitioner_relationship';	// Practitioner locations
	private $table_locations			= 'mc_clinic_locations';	// Practitioner assigned locations
	private $table_roster				= 'mc_roster';	// Practitioner roster
	private $table_room				    = 'mc_clinic_rooms';	// Practitioner roster
	
	
	function __construct() {
		parent::__construct();
		$ci =& get_instance();
		$this->table_appointment_types   = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_appointment_types;
		$this->table_billing_codes		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_billing_codes;
		$this->table_patients			 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_patients;
		$this->table_practitioners		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_practitioners;
		$this->table_appointments		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_appointments;
		$this->table_prac_locations		 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_prac_locations;
		$this->table_locations			 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_locations;
		$this->table_roster			 	 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_roster;
		$this->table_room			 	 = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_room;
	}
	public function get_prac_details($userID) {
		$this->db->select("prac.practitioner_id, prac.clinic_id, prac.title as prac_title, prac.first_name as prac_first_name, prac.surname as prac_surname");
		$this->db->from($this->table_practitioners .' as prac');
		$this->db->where('prac.user_id', $userID);
		$query = $this->db->get();
		if($query->num_rows()>0) {
			$results = $query->row();
			return $results;
		}
		else {
			return 'false';
		}
	}
	public function get_locaation_prac_details($practitioner_id) {
		$this->db->select("prac.hp_id, prac.title as prac_title, prac.name as prac_first_name, prac.surname as prac_surname");
		$this->db->from($this->table_practitioners .' as prac');
		$this->db->where('prac.hp_id', $practitioner_id);
		$query = $this->db->get();
		if($query->num_rows()>0) {
			$results = $query->row();
			return $results;
		}
		else {
			return 'false';
		}
	}
	public function get_prac_locations($pracID) {
		$this->db->select("prac_locations.location_id,loc.clinic_name,loc.clinic_id");
		$this->db->join($this->table_locations .' as loc', 'loc.location_id = prac_locations.location_id','inner');
		$this->db->from($this->table_prac_locations .' as prac_locations');
		$this->db->where('prac_locations.practitioner_id', $pracID);
		$query = $this->db->get();
		if($query->num_rows()>0) {
			foreach($query->result_array() as $result) {
				$results['clinic_id'] = $result['clinic_id'];
				$results['locations'][$this->encryption->encode($result['location_id'])] = $result['clinic_name'];
			}
			return $results;
		}
		else {
			return 'false';
		}
	}
	public function get_appointments($practitioner_id = "", $location_id = "") {
		$allAppointments = array();
                $casualAppointments = array();
		if($practitioner_id!=0 && $practitioner_id!='') {
                        $this->db->select("appnts.*");
			$this->db->from($this->table_appointments .' as appnts');
			$this->db->where('appnts.practitioner_id',$practitioner_id);
			$this->db->where('appnts.clinic_location_id', $this->encryption->decode($location_id));
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
                                    
                                    $casual_appointment['title'] = $casualresult['appointment_notes'];
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
                    
			$this->db->select("appnts.*,appnt_types.color_code,patient.first_name,patient.last_name,patient.image,appnt_types.text_color");
			$this->db->from($this->table_appointments .' as appnts');
			$this->db->join($this->table_patients .' as patient', 'patient.patient_id = appnts.patient_id','left');
			$this->db->join($this->table_appointment_types .' as appnt_types', 'appnt_types.type_id = appnts.appointment_type_id','inner');
			$this->db->where('appnts.practitioner_id',$practitioner_id);
			$this->db->where('appnts.clinic_location_id', $this->encryption->decode($location_id));
                        $this->db->where('appnts.status', '1');
			
			$query = $this->db->get();
		
			if($query->num_rows()>0) {
				foreach($query->result_array() as $result) { 
					$appointment = array();
					$startDate = $endDate = "";
					//echo $result['practitioner_id'];
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
                        
                        //echo '<pre>'; print_r($allAppointments); exit;
		}   
		return $allAppointments;
	}

	public function get_prac_avail_time($hpID, $data)
	{
		$startDate =  date('Y-m-d',$data['startDate']);
		$startTime =  date("H:i:s", strtotime($data['startTime']));
		$endTime =  date("H:i:s", strtotime($data['endTime']));
		
		$this->db->select("roster.clinic_room_id,room.room");
		$this->db->from($this->table_roster ." as roster");
		$this->db->join($this->table_room ." as room", "room.id = roster.clinic_room_id","left");
		$this->db->where("roster.practitioner_id",$hpID);
		$this->db->where("roster.roster_date", $startDate);
		$this->db->where("`roster`.`status` = '1' and '".$startTime."' BETWEEN `roster`.`roster_from` AND `roster`.`roster_to` and  '".$endTime."' BETWEEN `roster`.`roster_from` AND `roster`.`roster_to`  ");
		//$this->db->where("'09:15:00' BETWEEN `roster`.`roster_from` AND `roster`.`roster_to`");
	    //$this->db->where("roster.status", "1");
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
}
