<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clinics
 *
 * This model handles clinic management. It operates the following tables:
 * - Clinics,
 * - users
 *
 * @author	Visions
 */
class Manage_patientsearchs extends CI_Model
{
	private $table_name			    = 'mc_clinic';			// Clinic entry
	
	private $countries_table_name	            = 'mc_countries';
	private $states_table_name		    = 'mc_states';
	private $cities_table_name		    = 'mc_cities';
	private $aus_suburb_table_name	            = 'mc_aus_suburb_list';	
	private $state_table_name 	            = 'mc_aus_states_list';	
	private $mc_clinic_admin 	            = 'mc_clinic_admin';	
	private $mc_clinic_access 	            = 'mc_clinic_access';	
	private $mc_clinic_rooms 	            = 'mc_clinic_rooms';
	private $mc_patients 	            = 'mc_patients';

	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$this->table_name			                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_name;
		$this->countries_table_name	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->countries_table_name;
		$this->states_table_name	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->states_table_name;
		$this->cities_table_name	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->cities_table_name;
		$this->aus_suburb_table_name	            = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->aus_suburb_table_name;
		$this->state_table_name   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->state_table_name;
		$this->mc_clinic_admin   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_admin;
		$this->mc_clinic_access   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_access;
		$this->mc_clinic_rooms   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_rooms;
		$this->mc_patients   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_patients;
	}
	
	
	
	
	
	

	public function patient_Details($inputValues){

		$patient_surname=$inputValues['patient_surname'];
		$first_name=$inputValues['patient_firstname'];
		$dob=$inputValues['dob'];

		$return= array();
		if($inputValues!=''){
		$this->db->select("*");
		$this->db->from($this->mc_patients );
		$this->db->where('status', '1');
		$this->db->like('last_name', $patient_surname); 
		$this->db->like('first_name', $first_name); 
		$this->db->like('date_of_birth', $dob); 
			// $this->db->group_by('suburb_name');
			// $this->db->order_by("suburb_name", "asc");
			//$this->db->limit(70);
			$query = $this->db->get();
			$result = $query->result();
		

			if(count($result) > 0){
				return $result;		
				echo "sdd";
			}else{
				return false;
			}
			
        }
		return $return;
	}

  
		public function all_patient_Details(){

		

		$return= array();
		
		$this->db->select("*");
		$this->db->from($this->mc_patients );
		$this->db->where('status', '1');

			// $this->db->group_by('suburb_name');
			// $this->db->order_by("suburb_name", "asc");
			//$this->db->limit(70);
			$query = $this->db->get();
			$result = $query->result();
		
				

			if(count($result) > 0){
				return $result;		
				
			}else{
				return false;
			}
			
      
		return $return;
	}




	
}
