<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clinics
 *
 * This model handles patient search on groups management. It operates the following tables:
 * - Groups,
 * - users
 *
 * @author	Visions
 */
class Manage_groups extends CI_Model
{
	private $table_name			    		= 'mc_clinic';			// Clinic entry
	
	private $countries_table_name	        = 'mc_countries';
	private $states_table_name		    	= 'mc_states';
	private $cities_table_name		    	= 'mc_cities';
	private $aus_suburb_table_name	        = 'mc_aus_suburb_list';	
	private $state_table_name 	            = 'mc_aus_states_list';	
	private $mc_clinic_admin 	            = 'mc_clinic_admin';	
	private $mc_clinic_access 	            = 'mc_clinic_access';	
	private $mc_clinic_rooms 	            = 'mc_clinic_rooms';
	private $mc_patients 	            	= 'mc_patients';
	private $mc_groups						= 'mc_groups';
	private $mc_groups_members				= 'mc_groups_members';
	private $mc_consultation				= 'mc_consultation';
	private $mc_appointments				= 'mc_appointments';
	private $table_practitioners			= 'mc_hp_info';	
	private $mc_speciality					= 'mc_speciality';	
	
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
		$this->mc_patients   	                	= 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_patients;
		$this->mc_groups   	                		= 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_groups;
		$this->mc_groups_members   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_groups_members;
		$this->mc_consultation   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_consultation;
		$this->mc_appointments   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_appointments;
		$this->table_practitioners   	            = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_practitioners;
		$this->mc_speciality   	            		= 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_speciality;
	}
	
	
	
	
	
	

	public function patient_Details(){

		// $patient_surname=$inputValues['surname'];
		// $first_name=$inputValues['fname'];
		// $dob=$inputValues['dob'];

		$return= array();
		//if($inputValues!=''){

		$this->db->select("*");
		$this->db->from($this->mc_patients);
		$this->db->where('status', '1');
		// $this->db->like('last_name', $patient_surname); 
		// $this->db->like('first_name', $first_name); 
		// $this->db->like('date_of_birth', $dob); 
		
		$query = $this->db->get();
		$result = $query->result();


		if(count($result) > 0)
		{
			return $result;		
			
		}
		else
		{
			return false;
		}

		//}
			return $return;
	}


	public function all_patient_Details(){



	$return= array();

	$this->db->select("*");
	$this->db->from($this->mc_patients );
	$this->db->where('status', '1');

	$query = $this->db->get();
	$result = $query->result();



	if(count($result) > 0)
	{
		return $result;		

	}
	else
	{
		return false;
	}


		return $return;
	}


	public function saveGroupData($inputValues)
	{	
		$ip = $this->mc_constants->remote_ip();

		if(isset($inputValues['selectedUser']))
		{
			$group = array(
				'group_name' => $inputValues['grpName'],
				'group_admin_id' => $inputValues['grp_admin_id'],
				'created_ip' => $ip,
				'status' =>1,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by'  => $inputValues['grp_admin_id']
			);

			$insertGroup = $this->db->insert($this->mc_groups, $group);

			$inserted_id = $this->db->insert_id();
			
			//$count = count($inputValues['selectedUser']);
			
			$counter = 0;

			foreach ($inputValues['selectedUser'] as $value) {

				$this->db->set('group_id', $inserted_id);
				$this->db->set('member_id', $value);
				$this->db->set('created_ip', $ip);
				$this->db->set('created_date', date('Y-m-d H:i:s'));
				$this->db->set('created_by', $inputValues['grp_admin_id']);
				$this->db->insert($this->mc_groups_members);
			}

		}
		else
		{
			$group = array(
				'group_name' => $inputValues['grpName'],
				'group_admin_id' => $inputValues['grp_admin_id'],
				'created_ip' => $ip,
				'status' =>1,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by'  => $inputValues['grp_admin_id']
			);

			$insertGroup = $this->db->insert($this->mc_groups, $group);
		}

		return "true";
		
	}

	public function saveGroupDataFromCalendar($inputValues, $adminid)
	{	
		$ip = $this->mc_constants->remote_ip();
		$group = array(
			'group_name' => $inputValues['grpName'],
			'group_admin_id' => $adminid,
			'created_ip' => $ip,
			'status' =>1,
			'created_date' => date('Y-m-d H:i:s'),
			'created_by'  => $adminid
		);

		$insertGroup = $this->db->insert($this->mc_groups, $group);

		$inserted_id = $this->db->insert_id();
		
		

		$group_members = array(
				'group_id' => $inserted_id,
				'member_id' => $inputValues['PatientId'],
				'created_ip' => $ip,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by'  => $adminid
			);

			$insertGroup = $this->db->insert($this->mc_groups_members, $group_members);
			
		return "true";
		
	}

	public function groupList($id)
	{	
		$this->db->select('*');
		$this->db->from($this->mc_groups);
		$this->db->where(array('group_admin_id' => $id));
		$this->db->where('status', '1');
		$results = $this->db->get();
		return $results->result_array();
	}

	public function enrolled_members($pId)
	{
		$this->db->select('group_id');
		$this->db->from($this->mc_groups_members);
		$this->db->where('member_id', $pId);
		
		$results = $this->db->get();
		// echo "<pre>";
		// print_r($results->result());
		// echo '</pre>';die;
		return $results->result_array();
	}


	public function recycleGroupList($id)
	{	
		$this->db->select('*');
		$this->db->from($this->mc_groups);
		$this->db->where(array('group_admin_id' => $id));
		$this->db->where('status', '0');
		$results = $this->db->get();
		return $results->result_array();
	}

	public function groupdetails($id)
	{

		$this->db->select("*");
		$this->db->from($this->mc_groups .' as groups');
		$this->db->where('groups.id', $id);
		$this->db->where('groups.status', '1');
		$results = $this->db->get();
		$results = $results->row();

		if(isset($results->id) && $results->id != ''){
			$this->db->select("*");
			$this->db->from($this->mc_patients .' as patients');
			$this->db->join($this->mc_groups_members .' as mem', 'patients.patient_id = mem.member_id');
			//$this->db->join($this->mc_patients .' as patient', 'mem.member_id = patient.patient_id','inner');
			$this->db->where('mem.group_id', $id);
			$resultsInfo = $this->db->get();
			$results->members = $resultsInfo->result();		
		}
		
		return $results;
        
	}

	public function deleteGroup($sid){


			$data = array( 'status' => '0');

			$this->db->where('id', $sid);

			$this->db->update($this->mc_groups, $data); 

		if ($this->db->affected_rows() == '1') {
			return 'success';
		} else {
			return 'failure';
		}
	}


	public function restoreGroup($sid){

			$data = array( 'status' => '1');

			$this->db->where('id', $sid);

			$this->db->update($this->mc_groups, $data); 

		if ($this->db->affected_rows() == '1') {
			return 'success';
		} else {
			return 'failure';
		}
	}

	public function assignPatienttoGrp($pId,$grpId){
		$userdata = $this->session->all_userdata();
  		$uId = $userdata['user_id'];

		$ip = $this->mc_constants->remote_ip();
		$this->db->set('group_id', $grpId);
		$this->db->set('member_id', $pId);
		$this->db->set('created_ip', $ip);
		$this->db->set('created_date', date('Y-m-d H:i:s'));
		$this->db->set('created_by', $uId);
		$this->db->insert($this->mc_groups_members);

		return true;
	}

	public function removePatienttoGroup($pId,$grpId){
		
  		$this->db->where('group_id', $grpId);
  		$this->db->where('member_id', $pId);
		$this->db->delete($this->mc_groups_members);	
		
		
		return true;
	}

	public function get_all_consultation_history_groups($patientID)
	{
		$this->db->select("appointment_id");
		$this->db->from($this->mc_appointments .' as appointment');
		$this->db->where('appointment.patient_id', $patientID);
		$appId = $this->db->get();

		$appIds = $appId->result_array();
		
		$consultHistroy = array();
		$counter = 0;
		foreach ($appIds as $value) {
			
			$this->db->select("const.*,hpin.title,hpin.surname,hpin.name,clinic.clinic_name,spec.speciality");
			$this->db->from($this->mc_consultation .' as const');
			
			$this->db->join($this->table_practitioners .' as hpin', 'hpin.hp_id = const.hp_id','left');
			$this->db->join($this->table_name .' as clinic', 'clinic.clinic_id =const.medical_clinic','left');
			$this->db->join($this->mc_speciality .' as spec', 'spec.ID =const.speciality','inner');
			$this->db->where('const.appt_id', $value['appointment_id']);
			$query = $this->db->get();
			//print_r($this->db->last_query());

			$consultation = $query->result_array();
			
			array_push($consultHistroy, $consultation);
			
			$counter++;
		}
			
		// echo "<pre>";
		// print_r($consultHistroy);
		// die("here");

		if(count($consultHistroy) > 0)
		{
		
            return $consultHistroy;
		}
		else 
		{
			return array();
		}
	}

	public function removePatientFrmGrp($input){
		 $this->db->where('group_id', $input['gid']);
		 $this->db->where('member_id', $input['pId']);
  		 return $this->db->delete($this->mc_groups_members); 

	}

	public function get_patient_by_appointment($appntID)
	{
		$this->db->select("patient_id");
		$this->db->from($this->mc_appointments .' as appointment');
		$this->db->where('appointment.appointment_id', $appntID);
		$pat_id = $this->db->get();

		$patient_id = $pat_id->row();
		return $patient_id;
	}

	public function getPatientTonewGroup($pId)
	{
		$this->db->select("*");
		$this->db->from($this->mc_patients);
		$this->db->where('patient_id', $pId);
		$patientdata = $this->db->get();

		$patient = $patientdata->result_array();
		return $patient;
	}
}
