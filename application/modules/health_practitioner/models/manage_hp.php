<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * HP
 *
 * This model handles clinic management. It operates the following tables:
 * - HP,
 * - users
 *
 * @author	Visions
 */
class Manage_hp extends CI_Model
{
	private $table_name			    = 'mc_hp_info';	
	private $table_users             ='mc_users';		// HP entry
	private $table_mc_user_roles = 'mc_user_roles';
	private $countries_table_name  = 'mc_countries';
	private $mc_speciality  = 'mc_speciality';
	private $mc_languages  = 'mc_languages';	
	private $table_hp_meta  = 'mc_hp_metadata';
	private $table_mc_clinic  = 'mc_clinic';
	private $table_mc_hp_clinic_relation = 'mc_hp_clinic_relation';

	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$this->table_name = $ci->config->item('db_table_prefix', 'tank_auth').$this->table_name;
		$this->countries_table_name = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->countries_table_name;
		$this->mc_speciality = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_speciality;
		$this->mc_languages = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_languages;
			$this->load->library('encrypt');
		$this->table_mc_users = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_users;
		$this->table_users = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_users;
		$this->table_mc_user_roles = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_user_roles;
		$this->table_hp_meta = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_hp_meta;
		$this->table_mc_clinic = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_clinic;
		$this->table_mc_hp_clinic_relation = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_hp_clinic_relation;
		}

	
	public function getHpList(){
	   
		$return= array();
            $this->db->select("*");
			$this->db->from($this->table_name .' as clist');
			$this->db->order_by('hp_id',"DESC");
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->result();
				
			}
		
    	return $return;
	}
        
        public function getClinicDetail($clinic_location_id = ''){
	    $return= array();
            $this->db->select("clist.*,clist_setting.abn_number,clist_setting.website_url,clist_setting.clinic_logo");
			$this->db->from($this->clinic_table_name .' as clist');	
                        $this->db->join($this->clinic_setting .' as clist_setting', 'clist.clinic_id = clist_setting.clinic_id','left');
			$where = "(clist.location_id='".$clinic_location_id."')";
                        $this->db->where($where);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row();
				
			}
            return $return;
	}

	public function create_hp($inputValues)
	{

		$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($inputValues['password']);
				
				$user_data= array(
				'username' => $inputValues['hp_username'],
				'password' => $hashed_password,
				'email'    => $inputValues['hp_email'],
				'activated'   => '0',
			    'last_ip' => $this->mc_constants->remote_ip(),

					);
            

		$pin=$inputValues['pin1'] .",". $inputValues['pin2'] .",". $inputValues['pin3'] .",". $inputValues['pin4'];

		
             $encode_pin = $this->encryption->encode($pin);

		
					try { 
						$this->db->trans_begin();
						$this->db->insert($this->table_mc_users, $user_data);
						$user_id  = $this->db->insert_id();

						$role = array(
								'user_id' => $user_id,
								'role_id' => 3,
							);
						$this->db->insert($this->table_mc_user_roles, $role);
						
						$hp_health_practitioner= array(
								'user_id' => $user_id,
								'title' =>$inputValues['hp_title'],
								'surname' =>$inputValues['hp_surname'],
								'name' => $inputValues['hp_name'],
								'pin' =>$encode_pin,
								'security_question' => $inputValues['reminder_question'],
								'security_answer' => $inputValues['reminder_answer'],
								'mobile' => @$inputValues['mobile'],
								'mobile_2' => @$inputValues['mobile_2'],
								'country' =>$inputValues['country'],
								'contact_emg_title' => @$inputValues['hp_emg_contact_title'],
								'contact_emg_surname' => @$inputValues['hp_emg_contact_surname'],
								'contact_emg_name' => @$inputValues['hp_emg_contact_name'],
								'contact_emg_email' => @$inputValues['hp_emg_contact_email'],
								'contact_emg_mobile' => @$inputValues['hp_emg_contact_mobile'],
								'contact_emg_relationship' =>@$inputValues['hp_emg_contact_relationship'],
								'contact_emg_title_2' => @$inputValues['hp_emg_contact_title_2'],
								'contact_emg_surname_2' => @$inputValues['hp_emg_contact_surname_2'],
								'contact_emg_name_2' => @$inputValues['hp_emg_contact_name_2'],
								'contact_emg_email_2' => @$inputValues['hp_emg_contact_email_2'],
								'contact_emg_mobile_2' => @$inputValues['hp_emg_contact_mobile_2'],
								'contact_emg_relationship_2' => @$inputValues['hp_emg_contact_relationship_2'],
								'speciality' => @$inputValues['hp_speciality'],
								'disability_employment_service' => @$inputValues['hp_des_yes'],
								'des_provider' => @$inputValues['hp_wh_des_name'],
								'languages' => @$inputValues['hp_language'],
								'declaration' => $inputValues['hp_declaration'],
								'created_ip' => $this->mc_constants->remote_ip(),
								'last_modified_ip' => $this->mc_constants->remote_ip(),
								'created_date' => date('Y-m-d H:i:s'),
								'last_modified_date' => date('Y-m-d H:i:s'),
								'created_by' =>'test',
								'last_modified_by' =>'test',
								'hp_status' => '0',
								
								
							);
					$this->db->insert($this->table_name, $hp_health_practitioner);
					$hp_id  = $this->db->insert_id();
					
				$hp_health_practitioner_edu = array(
									'user_id' => $user_id,
									'hp_ug_degree_name_1' => @$inputValues['hp_ug_degree_name_1'],
									'hp_ug_university_1' => @$inputValues['hp_ug_university_1'],
									'hp_ug_upload_degree_1' => @$inputValues['hp_ug_upload_degree_1'],
									'hp_ug_degree_name_2' => @$inputValues['hp_ug_degree_name_2'],
									'hp_ug_university_2' => @$inputValues['hp_ug_university_2'],
									'hp_ug_upload_degree_2' =>@$inputValues['hp_ug_upload_degree_2'],
									'hp_pg_degree_name_1' => @$inputValues['hp_pg_degree_name_1'],
									'hp_pg_university_1' => @$inputValues['hp_pg_university_1'],
									'hp_pg_upload_degree_1' =>@$inputValues['hp_pg_upload_degree_1'],
									'hp_pg_degree_name_2' => @$inputValues['hp_pg_degree_name_2'],
									'hp_pg_university_2' => @$inputValues['hp_pg_university_2'],
									'hp_pg_upload_degree_2' => @$inputValues['hp_pg_upload_degree_2'],
									'hp_mr_country' => @$inputValues['hp_mr_country'],
									'hp_mr_reg_no' => @$inputValues['hp_mr_reg_no'],
									'hp_mr_issue_date' => @$inputValues['hp_mr_issue_date'],
									'hp_mr_expiry_date' => @$inputValues['hp_mr_expiry_date'],
									'medical_registration_filename_1_1' => @$inputValues['hp_mr_document'],
									'medical_registration_filename_1_2' => @$inputValues['hp_mr_document_2'],
									'hp_mi_company_1' => @$inputValues['hp_mi_company'],
									'hp_mi_number_1' => @$inputValues['hp_mi_number'],
									'hp_mi_format_1_1' => @$inputValues['hp_mi_format'],
									'hp_mi_format_1_2' => @$inputValues['hp_mi_format_2'],
									'hp_mi_company_2' => @$inputValues['hp_mi_company_2'],
									'hp_mi_number_2' => @$inputValues['hp_mi_number_2'],
									'hp_mi_format_2_1' => @$inputValues['hp_mi_format_2_1'],
									'hp_mi_format_2_2' => @$inputValues['hp_mi_format_2_1'],
									);
									

						$this->db->insert($this->table_hp_meta, $hp_health_practitioner_edu);

						$hp_clinic_relation= array('hp_id' => $hp_id,'location_id' => $inputValues['clinic_loc'], );
						$this->db->insert($this->table_mc_hp_clinic_relation, $hp_clinic_relation);
						
						$this->db->trans_commit();
						$ret_msg = array('return' => 1);
						
					}
					catch (Exception $e) {
						$this->db->trans_rollback();
						$ret_msg = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
					} 
					
					$returnArray = $ret_msg;
					
					
				
			
			
		
		return $returnArray;
	}

	
	public function enable_clinic_details($clinicID = '', $author_id = ''){
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$clinic['status'] 	= '1';
		$clinic['last_modified_ip'] = $ipAddress;
		$clinic['last_modified_date'] = date('Y-m-d H:i:s');
		$clinic['last_modified_by'] = $author_id;
		
		$this->db->update($this->table_name, $clinic, array('clinic_id' => $clinicID));
		//$this->db->update($this->clinic_table_name, $clinic, array('clinic_id' => $clinicID));
		if ($this->db->affected_rows() == '1') {
			return 'success';
		} else {
			return 'failure';
		}
	}
	public function disable_clinic_details($clinicID = '', $author_id = ''){
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$clinic['status'] 	= '0';
		$clinic['last_modified_ip'] = $ipAddress;
		$clinic['last_modified_date'] = @date('Y-m-d H:i:s');
		$clinic['last_modified_by'] = $author_id;
		$this->db->update($this->table_name, $clinic, array('clinic_id' => $clinicID));
		
		if ($this->db->affected_rows() == '1') {
			return 'success';
		} else {
			return 'failure';
		}
	}
	public function getSuburb(){
		$return = array();
		$this->db->select("suburb_id,suburb_name");
		$this->db->from($this->aus_suburb_table_name);
		$this->db->where('activated', '1');
		$this->db->group_by('suburb_name');
		$this->db->order_by("suburb_name", "asc");
	 	$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result_array() as $sub_ary){ 
			    $return[$sub_ary['suburb_id']] = $sub_ary['suburb_name'];
			}
		}
		return $return;
	}
	public function getCountries() {
		$countries = array();
		$this->db->select("id,name");
		$this->db->from($this->countries_table_name);
		$query = $this->db->get();
		$countries[''] = 'Select country';
		$countries['AU'] = 'Australia';
		if($query->num_rows()>0){
			foreach($query->result_array() as $result) { 
			    $countries[$result['id']] = $result['name'];
			}
		}
		return $countries;
	}
	
	public function getSpecialities() {
		
		$specialities = array();
		$this->db->select("id,speciality");
		$this->db->from($this->mc_speciality);
		$this->db->where('parent_id', '0');
		$this->db->where('status', 1);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			
		foreach($query->result_array() as $result) { 
				$specialities[$result['id']] = $result['speciality'];
			}
		}
		
		return $specialities;
	}
	public function getlanguages() {
		
		$specialities = array();
		$this->db->select("ID,languages");
		$this->db->from($this->mc_languages);
		$this->db->where('status', 1);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			
		foreach($query->result_array() as $result) { 
				$specialities[$result['ID']] = $result['languages'];
			}
		}
		
		return $specialities;
	}	
	
	
	public function getSuburbAuto($subname = ''){
		$return= array();
		if($subname!=''){
			$this->db->select("suburb_id,suburb_name");
			$this->db->from($this->aus_suburb_table_name);
			$this->db->where('activated', '1');
			$this->db->like('suburb_name', $subname, 'after'); 
			$this->db->group_by('suburb_name');
			$this->db->order_by("suburb_name", "asc");
			$this->db->limit(70);
			$query = $this->db->get();
			if($query->num_rows()>0){
				foreach($query->result_array() as $sub_ary){ 
					$return[$sub_ary['suburb_id']] = $sub_ary['suburb_name'];
				}
			}
        }
		return $return;
	}
    public function getAusStatesList($subname = '', $viewType = ''){
		$return = array();
		if($subname!=''){
				$this->db->select('st.state_id, st.state_name');
				$this->db->from($this->aus_suburb_table_name .' as surb');
				$this->db->join($this->state_table_name .' as st', 'surb.state_id = st.state_id','inner');
				$this->db->where('surb.suburb_name', $subname);
				$this->db->where('surb.activated', '1');
				$this->db->where('st.activated', '1');
				$this->db->group_by('surb.suburb_name');
				$this->db->group_by('surb.state_id');
				$this->db->order_by('st.state_name',"ASC");
				$query = $this->db->get();
				if($query->num_rows()>0){
					if($viewType == 'edit_clinic') {
						foreach($query->result_array() as $result) { 
							$return[$result['state_id']] = $result['state_name'];
						}
					}
					else {
						$return = $query->result_array();
					}
				}
			}
		return $return;
	}
	public function getAusSuburbInfo($suburb_id=0){
		$return = array();
		if(($suburb_id!=0 && $suburb_id!='')) {
				$this->db->select('surb.*');
				$this->db->from($this->aus_suburb_table_name .' as surb');
				$this->db->where('surb.suburb_id', $suburb_id);
				$query = $this->db->get();
				if($query->num_rows()>0){
					$return = $query->result_array();
				}
			}
		return $return;
	}
	public function getAusSuburbid($subname = '',$state_id=0,$postal_code=0){
		$return = array();
		if($subname!='' && ($state_id!=0 && $state_id!='') && ($postal_code!=0 && $postal_code!='')) {
				$this->db->select('surb.suburb_id');
				$this->db->from($this->aus_suburb_table_name .' as surb');
				$this->db->where('surb.suburb_name', $subname);
				$this->db->where('surb.state_id', $state_id);
				$this->db->where('surb.postal_code', $postal_code);
				$query = $this->db->get();
				if($query->num_rows()>0){
					$return = $query->result_array();
				}
			}
		return $return;
	}
	public function getCountryStatesList($countryID = '', $viewType = ''){
		$returnArray = array();
		if($countryID!=''){
				$this->db->select('id as state_id, name as state_name');
				$this->db->from($this->states_table_name);
				$this->db->where('country_id', $countryID);
				$query = $this->db->get();
				if($query->num_rows()>0){
					if($viewType == 'edit_clinic') {
						foreach($query->result_array() as $result) { 
							$returnArray[$result['state_id']] = $result['state_name'];
						}
					}
					else {
						$returnArray =$query->result_array();
					}
				}
			}
		return $returnArray;
	}
	public function getStatesCitiesList($stateID = '', $viewType = ''){
		$returnArray = array();
		if($stateID!=''){
				$this->db->select('id as city_id, name as city_name');
				$this->db->from($this->cities_table_name);
				$this->db->where('state_id', $stateID);
				$query = $this->db->get();
				if($query->num_rows()>0){
					if($viewType == 'edit_clinic') {
						foreach($query->result_array() as $result) { 
							$returnArray[$result['city_id']] = $result['city_name'];
						}
					}
					else {
						$returnArray =$query->result_array();
					}
				}
			}
		return $returnArray;
	}
	public function getPostcodeList($stateId=0,$subname=''){
		$return = array();
		if($stateId!=0 && $subname!=''){
		    $this->db->select('suburb_id, postal_code');
            $this->db->from($this->aus_suburb_table_name);
            $this->db->where('suburb_name', $subname);
            $this->db->where('activated', '1');
            $this->db->where('state_id', $stateId);
			$this->db->group_by('suburb_name');
			$this->db->group_by('state_id');
			$this->db->group_by('postal_code');
            $this->db->order_by('postal_code',"ASC");
            $query = $this->db->get();
			if($query->num_rows()>0){
				$return =$query->result_array();
			}
		}
		return $return;
	}
	public function getDeleteClinic($clinic_id=0){
		$return=0;
		if($clinic_id!=0 && $clinic_id!=''){
		    $update_data=array('status'=>2,'end_date'=>@date('Y-m-d H:i:s'));
     		$this->db->where('clinic_id',$clinic_id);
			$this->db->update($this->table_name,$update_data);
			
			$update_data2=array('status'=>2,'end_date'=>@date('Y-m-d H:i:s'));
     		$this->db->where('clinic_id',$clinic_id);
			$this->db->update($this->clinic_table_name,$update_data2);
			$return = 1;
		}
		return $return;
	}
	public function getSurburbState($state_id=0){
		$return= array();
		if($state_id!=0 && $state_id!=''){
            $this->db->select("state_name");
			$this->db->from($this->state_table_name);
			$this->db->where('state_id',$state_id);
            $query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row_array();
			}
		}
		return $return;
	}
	public function getCityInfo($city_id = 0){
		$return = array();
		if($city_id!=0 && $city_id!='') {
            $this->db->select('ct.id as city_id, ct.name as city_name, st.id as state_id, st.name as state_name, cn.id as country_id, cn.name as country_name');
			$this->db->from($this->cities_table_name .' as ct');
			$this->db->join($this->states_table_name .' as st', 'st.id = ct.state_id','inner');
			$this->db->join($this->countries_table_name .' as cn', 'cn.id = st.country_id','inner');
			$this->db->where('ct.id', $city_id);
            $query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row_array();
			}
		}
		return $return;
	}
	public function getViewClinic($clinic_id = 0){
		$return= array();
		
		if($clinic_id!=0 && $clinic_id!=''){
            $this->db->select("*");
			$this->db->from($this->table_name .' as clist');
			$where = "(status='1' OR status='0')";
            $this->db->where('clinic_id',$clinic_id);
            $this->db->where($where);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row_array();
			}   	
		}
		return $return;
	}
	public function getClinicId($userid = 0){
		$return= array();
		if($userid!=0 && $userid!=''){
 		    $this->db->select("clist.clinic_id, rcl.relationship_id, rcl.user_id, role.role_id");
			$this->db->from($this->table_name .' as clist');
			$this->db->join($this->clinic_table_name .' as cloc', 'clist.clinic_id = cloc.clinic_id','inner');
			$this->db->join($this->clinic_relationship_table_name .' as rcl', 'cloc.location_id = rcl.clinic_location_id','inner');
			$this->db->join($this->role_table_name .' as role', 'rcl.user_id = role.user_id','inner'); 
            $this->db->where('`rcl`.`user_id`',$userid);
            $this->db->where('`role`.`user_id`',$userid);
			$query = $this->db->get();
			if($query->num_rows()>0){
				 $return=$query->row();
			}   	
		}
		return $return;
	}	
	public function locationsCount($clinicId = 0){
		$return= 0;
		if($clinicId!=0 && $clinicId!=''){

 		    $this->db->select("count(cloc.clinic_id) as total_locations");
			$this->db->from($this->table_name .' as clist');
			$this->db->join($this->clinic_table_name .' as cloc', 'clist.clinic_id = cloc.clinic_id','inner');
			$where = "(`clist`.`status`='1') AND (`cloc`.`status`='1') AND `cloc`.`clinic_id` ='".$clinicId."'";
			$this->db->where($where);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$result=$query->row();
				if(count($result)>0){
					$return=$result->total_locations;
				}
			}
		}
		return $return;
	}
	public function getAllTimeZone(){
	    $timezone = array();
		$timezone['']=$this->lang->line('select_time_zone');
        $this->db->select("`zone_id`,`zone_name`");
		$this->db->from($this->mc_zone);
		$this->db->order_by('zone_name', "ASC");
		$query = $this->db->get();
		if($query->num_rows()>0){
			$zones=$query->result_array();
			if(count($zones)>0){
				foreach($zones as $zone){
					$timezone[$zone['zone_name']]=$zone['zone_name'];
				}
			}
		} 
    	return $timezone;
	}	
	
	public function get_clinic_details($search_data){
		
		$this->db->select("*");
		$this->db->like('clinic_name', $search_data['clinic_name']);
		$this->db->like('country', $search_data['country']);
		$this->db->where("(street_address like' %".$search_data['address']."%' OR street_address_2 like '%".$search_data['address']."%' OR state like '%".$search_data['address']."%')");
		
		
		$this->db->from($this->table_mc_clinic);
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{ 
		//	echo '<pre>'; print_r($results); die;
			return $results = $query->result_array();
		}
		
		
		
		
	}
	
	
}
