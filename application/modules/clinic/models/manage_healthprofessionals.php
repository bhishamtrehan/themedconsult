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
class Manage_healthprofessionals extends CI_Model
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
	private $mc_users 	            = 'mc_users';
	private $mc_clinic 	            = 'mc_clinic';
	private $mc_hp_info 	            = 'mc_hp_info';
	private $mc_hp_clinic_relation 	            = 'mc_hp_clinic_relation';
	private $mc_speciality 	            = 'mc_speciality';


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
		$this->mc_users   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_users;
		$this->mc_clinic   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic;
		$this->mc_hp_info  	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_hp_info;
		$this->mc_hp_clinic_relation  	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_hp_clinic_relation;
		$this->mc_speciality  	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_speciality;
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

  
		public function all_healthprofessional_Details($user_id){

				//echo $user_id;
				

				$return= array();
		
			$this->db->select("clinicad.id,clinicacc.clinic_loc");
			$this->db->from($this->mc_clinic_admin .' as clinicad');
			$this->db->join($this->mc_clinic_access .' as clinicacc', 'clinicacc.access_id = clinicad.id','inner');
			$this->db->where('clinicad.user_id',$user_id);
			//$this->db->where('rost.status', '1');
			//$this->db->where('rost.status', '1');
			$query = $this->db->get();
			$location_results = $query->result_array();
			//$result =	$this->db->last_query();
				
				
				$locations= (explode(",",$location_results[0]['clinic_loc']));
				//print_r($locations);
					$results = array();
				foreach ($locations as $loc) {
					// echo $loc;
				$this->db->select("hp_id");
				 $where = "FIND_IN_SET('".$loc."', location_id)";
				 $this->db->where($where);
				 $this->db->from($this->mc_hp_clinic_relation);
					$query = $this->db->get();
				 $hp_results[] = $query->result_array();

				

				// $counter = 0; 
				// foreach ($admidIds as $value) {
				// 	array_push($clinicAdmin, $admidIds[$counter]['admin_id']);
				// 	$counter++;
				// }
				
				
			}
			
			 //print_r($results);
			foreach($hp_results as $subArray){
				    foreach($subArray as $val){
				        $hp_id[] = $val['hp_id'];
				    }
				}

			
				$newArray= array_unique($hp_id);
				//print_r($newArray);
						$hp_data = array();
			 	foreach ($newArray as $key => $value) {
			 		
			 	//echo $value;

				// $this->db->select("*");
				// $this->db->from($this->mc_hp_info);
				// $this->db->where('hp_id', $value);


				$this->db->select("hpinfo.*,spec.speciality");
				$this->db->from($this->mc_hp_info .' as hpinfo');
				$this->db->join($this->mc_speciality .' as spec', 'hpinfo.speciality = spec.ID','inner');
				$this->db->where('hpinfo.hp_id',$value);
				// $this->db->group_by('suburb_name');
				// $this->db->order_by("suburb_name", "asc");
			 	$query = $this->db->get();
				$result = $query->result_array();
				
				array_push($hp_data, $result);
			 	}
					
				// echo "<pre>";
				// print_r($hp_data);

				// die();  		
				$hp_details = array();
					foreach($hp_data as $array) {
					 foreach($array as $k=>$v) {
					 // $hp_details[$k] = $v;
					  array_push($hp_details, $v);
					 }
					}
					// echo "<pre>";
					// print_r($hp_details);
					// die();

					if(count($hp_details) > 0){
						return $hp_details;		
						
					}else{
						return false;
					}
					
      
		return $return;
	}




	
}
