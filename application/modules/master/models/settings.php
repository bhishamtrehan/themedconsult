<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings
 *
 * This model handles Site settings for master admin
 * @author	Visions
 */
class Settings extends CI_Model
{
	private $table_mc_settings	   = 'mc_speciality';
	private $countries_table_name  = 'mc_countries';
	private $table_mc_clinic_staff = 'mc_clinic_admin';
	private $table_mc_users = 'mc_users';
	private $mc_master_info = 'mc_master_info';
	private $table_mc_user_roles = 'mc_user_roles';
	private $table_mc_clinic = 'mc_clinic';
	private $mc_clinic_access = 'mc_clinic_access';
	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$this->table_mc_clinic_staff = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_clinic_staff;
		$this->countries_table_name = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->countries_table_name;
		$this->table_mc_users = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_users;
		$this->mc_master_info = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_master_info;

		$this->table_mc_user_roles = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_user_roles;
		$this->table_mc_clinic = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_clinic;
		$this->mc_clinic_access = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_access;
	}

	//fetch settings
	public function getspecialitySetting()
	{
		
		$this->db->select("*");
		$this->db->from($this->table_mc_settings);
		$this->db->where("status", 1); 
		$this->db->order_by("ID", "desc"); 
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}   	
		//return $results;
	}
	
	public function getSettingData($table)
	{
		$row = substr($table, 3);
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where("status", 1); 
		$this->db->order_by('ID', "desc"); 
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}   	
		//return $results;
	}

	//adding settings
	public function addSettingModal($input , $table, $row, $status)
	{
		$ipAddress   = $this->mc_constants->remote_ip();
		$data = array(
		   $row => $input,
		   'status' =>'1',
		   'created_date' => @date('Y-m-d H:i:s'),
		   'created_ip' => $ipAddress,
		   'created_by' => '',
		);
		try
		{
			$this->db->trans_begin();
			$result = $this->db->insert($table, $data); 
			$this->db->trans_commit();
			return $result;
		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			return $output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		
	}

	//update settings
	public function updateSettingModal($input , $table, $row, $id)
	{
		$ipAddress   = $this->mc_constants->remote_ip();
		$data = array(
		   $row => $input,
		   'last_modified_date' => @date('Y-m-d H:i:s'),
		   'last_modified_ip' => $ipAddress,
		   'last_modified_by' => '',
		);
		try
		{
			$this->db->trans_begin();
			$this->db->where('ID', $id);
			$result = $this->db->update($table, $data);
			$this->db->trans_commit();
			return $result;
		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			return $output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		 
	}
	
	//delete settings
	public function deleteSetting($table, $row, $id)
	{
		$data = array(
		   'status' => 0,
		);
		try
		{
			$this->db->trans_begin();
			$this->db->where('ID', $id);
			$result = $this->db->update($table, $data);
			$this->db->trans_commit();
			return $result;
		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			return $output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		 

	}

	//fetch countries
	public function getCountries() {
		$countries = array();
		$this->db->select("id,name");
		$this->db->from($this->countries_table_name);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			foreach($query->result_array() as $result) { 
			    $countries[$result['id']] = $result['name'];
			}
		}
		return $countries;
	}

	//add admin
	public function add_staff($dataform)
	{

		$ipAddress   = $this->mc_constants->remote_ip();
		$cId = $this->encryption->decode( $dataform['companyId']);
		$data = array(
			'user_id' => $dataform['user_id'],
			'fname'	   => $dataform['fname'],
			'lname'    => $dataform['lname'],
			'website'  => @$dataform['website'],
			'contact'  => $dataform['contact'],
			'company'  => @$dataform['company'],
			'country_id' => $dataform['country'],
			'companyId' => $cId,
			'created_date' => @date('Y-m-d H:i:s'),
		   	'created_ip' => $ipAddress,
		   	'created_by' => '',

		);
		$role = array(
			'user_id' => $dataform['user_id'],
			'role_id' => 2
		);
		
		try
		{
			$this->db->trans_begin();
			$this->db->insert($this->table_mc_clinic_staff, $data);
			$clinic_id  = $this->db->insert_id();
			
			$cli_loc = implode(',',$dataform['clinic_loc']);
			$clinic_access = array(
				'admin_id' => $clinic_id,
				'clinic_loc' =>$cli_loc,
				'created_date' => @date('Y-m-d H:i:s'),
			   	'created_ip' => $ipAddress,
			   	'created_by' => '',
			);
			$this->db->insert($this->table_mc_user_roles, $role);
			
			
			$this->db->insert($this->mc_clinic_access, $clinic_access);
			$this->db->trans_commit(); 
		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			return $output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		
		
	}

	//fetch admin list
	public function getadminList($cId)
	{
		$this->db->select("*");
		$this->db->from($this->table_mc_clinic_staff .' as staff');
		$this->db->where('staff.companyId', $cId);
		$this->db->join($this->table_mc_users .' as users', 'staff.user_id = users.id', 'LEFT');
		$this->db->where('users.banned', 0);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}
		
	}
	
		//fetch admin list
	public function getClinicLoc($cId)
	{
		$cliId = $this->encryption->decode($cId);
		$this->db->select("clinic_name,clinic_id");
		$this->db->from($this->table_mc_clinic);
		$status= array('0', '1');
		$this->db->or_where_in('status', $status);
		$this->db->where('company_id', $cliId);
		$query = $this->db->get();
		$clinics = array();
		if($query->num_rows()>0)
		{ 
			foreach($query->result_array() as $result) { 
			    $clinics[$result['clinic_id']] = $result['clinic_name'];
			}
			
		}
		
		return $clinics;
		
	}

	//Deactivated admin account
	public function deactAdmin($id, $status, $cId)
	{
		$data = array(
		   'activated' => 0,
		);
		
		$this->db->where('id', $id);
		$this->db->update($this->table_mc_users, $data);

		$this->db->select("*");
		$this->db->from($this->table_mc_clinic_staff .' as staff');
		$this->db->where('staff.companyId', $cId);
		$this->db->join($this->table_mc_users .' as users', 'staff.user_id = users.id', 'LEFT');
		$this->db->where('users.banned', 0);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}

	}

	//Activate admin account
	public function actAdmin($id, $status, $cId)
	{
		$data = array(
		   'activated' => 1,
		);
		$this->db->where('id', $id);
		$this->db->update($this->table_mc_users, $data);

		$this->db->select("*");
		$this->db->from($this->table_mc_clinic_staff .' as staff');
		$this->db->where('staff.companyId', $cId);
		$this->db->join($this->table_mc_users .' as users', 'staff.user_id = users.id', 'LEFT');
		$this->db->where('users.banned', 0);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}

	}

	//Delete admin account
	public function deleteAdmin($id, $status, $cId)
	{
		$data = array(
		   'banned' => 1,
		);
		$this->db->where('id', $id);
		$this->db->update($this->table_mc_users, $data);

		$this->db->select("*");
		$this->db->from($this->table_mc_clinic_staff .' as staff');
		$this->db->where('staff.companyId', $cId);
		$this->db->join($this->table_mc_users .' as users', 'staff.user_id = users.id', 'LEFT');
		$this->db->where('users.banned', 0);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}
	}

	//view to admin edit page
	public function getEditStaff($id = 0)
	{
		if($id!=0 && $id!='')
		{
			$this->db->select("*");
			$this->db->from($this->table_mc_clinic_staff .' as staff');
			$this->db->join($this->table_mc_users .' as users', 'staff.user_id = users.id', 'LEFT');
			$this->db->join($this->mc_clinic_access .' as clinics', 'staff.id = clinics.admin_id', 'LEFT');
			$this->db->where('users.id', $id);
			$query = $this->db->get();
			if($query->num_rows()>0)
			{ 
				return $results = $query->row_array();
			}

		}
	}

	//update admin account
	public function updateAdmin($dataform)
	{
		$ipAddress   = $this->mc_constants->remote_ip();
		$id = $dataform['id'];
		$p_id = $dataform['p_id'];
		if(!empty($dataform['password']))
		{

			$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($dataform['password']);

			
			$data = array(
				'username' => $dataform['username'],
				'password' => $hashed_password,
				'email'    => $dataform['email'],
				'activated'   => $dataform['status'],
			    'last_ip' => $ipAddress,

			);
			$this->db->where('id', $id);
			$this->db->update($this->table_mc_users, $data);

			$data = array(
				'fname'	   => $dataform['fname'],
				'lname'    => $dataform['lname'],
				'website'  => @$dataform['website'],
				'contact'  => $dataform['contact'],
				'company'  => @$dataform['company'],
				'country_id' => $dataform['country'],
				'last_modified_date' => @date('Y-m-d H:i:s'),
			    'last_modified_ip' => $ipAddress,
			    'last_modified_by' => '',

			);
			$this->db->where('user_id', $id);
			$this->db->update($this->table_mc_clinic_staff, $data);

			$cli_loc = implode(',',$dataform['clinic_loc']);
			$clinic_access = array(
			'admin_id' => $p_id,
			'clinic_loc' =>$cli_loc,
			'last_modified_date' => @date('Y-m-d H:i:s'),
		   	'last_modified_ip' => $ipAddress,
		   	'last_modified_by' => '',
			);
			$this->db->where('admin_id', $id);
			return $this->db->update($this->mc_clinic_access, $clinic_access);
		}
		else
		{
			$data = array(
				'username' => $dataform['username'],
				'email'    => $dataform['email'],
				'activated'   => $dataform['status'],
			    'last_ip' => $ipAddress,

			);
			$this->db->where('id', $id);
			$this->db->update($this->table_mc_users, $data);

			$data = array(
				'fname'	   => $dataform['fname'],
				'lname'    => $dataform['lname'],
				'website'  => @$dataform['website'],
				'contact'  => $dataform['contact'],
				'company'  => @$dataform['company'],
				'country_id' => $dataform['country'],
				'last_modified_date' => @date('Y-m-d H:i:s'),
			    'last_modified_ip' => $ipAddress,
			    'last_modified_by' => '',

			);
			$this->db->where('user_id', $id);
			$this->db->update($this->table_mc_clinic_staff, $data);

			$cli_loc = implode(',',$dataform['clinic_loc']); 
			$clinic_access = array(
			'admin_id' => $p_id,
			'clinic_loc' =>$cli_loc,
			'last_modified_date' => @date('Y-m-d H:i:s'),
		   	'last_modified_ip' => $ipAddress,
		   	'last_modified_by' => '',
			);
			$this->db->where('admin_id', $p_id);
			return $this->db->update($this->mc_clinic_access, $clinic_access);
		}
		
	}
	
		//update admin account
	public function updateMasterProfile($dataform)
	{
		$ipAddress   = $this->mc_constants->remote_ip();
		$id = $dataform['id'];
		
		$userdata = array(
			'username' => $dataform['username'],
			'email'    => $dataform['email'],
			
		);
		$data = array(
				'fname'	   => $dataform['fname'],
				'lname'    => $dataform['lname'],
				'website'  => @$dataform['website'],
				'contact'  => $dataform['contact'],
				'company'  => @$dataform['company'],
				'country' => $dataform['country'],
				'last_modified_date' => @date('Y-m-d H:i:s'),
		   		'last_modified_ip' => $ipAddress,
		   		'last_modified_by' => '',

			);
		
		if(!empty($dataform['password']))
		{
			$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($dataform['password']);
			
			$userdata['password'] =  $hashed_password;

		}
				
			$this->db->where('id', $id);
			 $this->db->update($this->table_mc_users, $userdata);
		
			$this->db->where('user_id', $id);
			return $this->db->update($this->mc_master_info, $data);
		
	}
}
