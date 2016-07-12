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
class Manage_company extends CI_Model
{
	private $table_name			    = 'mc_company';			// Company entry


	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$this->table_name    = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_name;
			
	}
	
	public function getCompanyList(){
	   
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by("ID", "desc"); 
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}   	
		//return $results;
	}

	//adding company
	public function addCompanyModal($input)
	{
		$ipAddress      = $this->mc_constants->remote_ip();
		$data = array(
		   'company' => $input,
		   'status' =>'1',
		   'created_ip' => $ipAddress,
		   'created_date' => @date('Y-m-d H:i:s'),
		   'created_by' => '',
		);
		try
		{
			$this->db->trans_begin();
			$output =  $this->db->insert($this->table_name, $data);
			$this->db->trans_commit();

		}
		catch(Exception $e)
		{
			$this->db->trans_rollback();
			$output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		$returnArray = $output;
		return $returnArray;

		 
	}
	
	//update settings
	public function updateSettingModal($input , $id)
	{
		$ipAddress      = $this->mc_constants->remote_ip();
		$data = array(
		   'company' => $input,
			'last_modified_ip' => $ipAddress,
		   'last_modified_date' => @date('Y-m-d H:i:s'),
		   'last_modified_by' => '',
		);
		try
		{
			$this->db->trans_begin();
			$this->db->where('ID', $id);
			$output = $this->db->update($this->table_name, $data);
			$this->db->trans_commit();
		}
		catch(Exception $e)
		{
			$this->db->trans_rollback();
			$output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		$returnArray = $output;
		return $returnArray;
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

	public function create_clinic($formFields)
	{
		$clinicNos = implode('::',$formFields['clinic_telephone_no']);
		$FaxNos = implode('::',$formFields['clinic_fax_number']);
		$EmailAdd = implode('::',$formFields['clinic_admin_email']);
		$RoomAdd = implode('::',$formFields['clinic_room']);
		
		$ipAddress      = $this->mc_constants->remote_ip();
		
		$role = $clinic = $clinicInfo = $relation =	$is_suburb = $suburb_id = $city_id  = '';
		
		if($formFields['country']=='AU') {
			$country = 'Australia';
			$returnSuburb = $this->getAusSuburbid($formFields['clinic_suburb'], $formFields['clinic_state'], $formFields['clinic_postcode']);	
			$returnState = $this->getSurburbState($formFields['clinic_state']);
			$suburb_id = $returnSuburb[0]['suburb_id'];
			$state = $returnState['state_name'];
			$is_suburb = '1';
			$city = '';
		} else {
			$city_id 	= $formFields['clinic_city'];
			$cityData	= $this->getCityInfo($city_id);
			$city 		= $cityData['city_name'];
			$state	 	= $cityData['state_name'];
			$country	= $cityData['country_name'];
		}
		
		$clinicInfo['clinic_name']                  = $formFields['clinic_name'];
		$clinicInfo['clinic_contact_email_address'] = $EmailAdd;
		$clinicInfo['street_address']   = $formFields['clinic_street_address'];
		$clinicInfo['street_address_2'] = $formFields['clinic_street_address_line2'];
		$clinicInfo['is_suburb']        = $is_suburb;
		$clinicInfo['suburb_id']        = $suburb_id;
		$clinicInfo['city_id'] 	        = $city_id;
		$clinicInfo['city'] 	        = $city;
		$clinicInfo['status'] 	        = $formFields['clinic_status'];
		$clinicInfo['suburb'] 	        = $formFields['clinic_suburb'];
		$clinicInfo['state'] 	        = $state;
		$clinicInfo['country'] 	        = $country;
		$clinicInfo['postcode']         = $formFields['clinic_postcode'];
		$clinicInfo['clinic_room']         = $RoomAdd;
		$clinicInfo['telephone']        = $clinicNos;
		$clinicInfo['fax_number']       = $FaxNos;
		$clinicInfo['created_ip']       = $ipAddress;
		$clinicInfo['created_date']     = @date('Y-m-d H:i:s');
		$clinicInfo['created_by']       = '';
		$clinicInfo['code']       = $city."".$formFields['clinic_postcode']."".rand(5, 9999);
		
		$relation['created_ip']         = $ipAddress;
		$relation['created_date']       = @date('Y-m-d H:i:s');
		$relation['created_by']         = '';
		

					try { 
						$this->db->trans_begin();
						$this->db->insert($this->table_name, $clinicInfo);
						$clinic_location_id  = $this->db->insert_id();
						
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
	public function update_clinic($formFields,$is_main=1)
	{
		$ret_msg     = false; 
		$ipAddress   = $this->mc_constants->remote_ip();
		$clinic 	 = '';
		$clinicInfo  = '';
		$relation 	 = '';
		$is_suburb 	 = '';
		$suburb_id 	 = '0';
		$city_id 	 = '';
		if($formFields['country']=='AU') {
			$country = 'Australia';
			$returnSuburb = $this->getAusSuburbid($formFields['clinic_suburb'], $formFields['clinic_state'], $formFields['clinic_postcode']);	
			$returnState = $this->getSurburbState($formFields['clinic_state']);
			$suburb_id = $returnSuburb[0]['suburb_id'];
			$state = $returnState['state_name'];
			$is_suburb = '1';
			$city = '';
		}
		else {
			$city_id 	= $formFields['clinic_city'];
			$cityData	= $this->getCityInfo($city_id);
			$city 		= $cityData['city_name'];
			$state	 	= $cityData['state_name'];
			$country	= $cityData['country_name'];
		}
		
		$clinicNos = implode('::',$formFields['clinic_telephone_no']);
		$FaxNos = implode('::',$formFields['clinic_fax_number']);
		$EmailAdd = implode('::',$formFields['clinic_admin_email']);
		$RoomAdd = implode('::',$formFields['clinic_room']);
		$clinicInfo['clinic_name']        = $formFields['clinic_name'];
		$clinicInfo['clinic_contact_email_address'] = $EmailAdd;
		$clinicInfo['street_address']     = $formFields['clinic_street_address'];
		$clinicInfo['street_address_2']   = $formFields['clinic_street_address_line2'];
		$clinicInfo['is_suburb']          = $is_suburb;
		$clinicInfo['suburb_id']          = $suburb_id;
		$clinicInfo['city_id'] 	          = $city_id;
		$clinicInfo['city'] 	          = $city;
		$clinicInfo['suburb'] 	          = $formFields['clinic_suburb'];
		$clinicInfo['status'] 	        = $formFields['clinic_status'];
		$clinicInfo['state'] 	          = $state;
		$clinicInfo['country'] 	          = $country;
		$clinicInfo['postcode']           = $formFields['clinic_postcode'];
		$clinicInfo['clinic_room']         =$RoomAdd;
		$clinicInfo['telephone']          = $clinicNos;
		$clinicInfo['fax_number']         = $FaxNos;
		$clinicInfo['last_modified_ip']   = $ipAddress;
		$clinicInfo['last_modified_date'] = @date('Y-m-d H:i:s');
		$clinicInfo['last_modified_by']   = $formFields['author_id'];
		
	   try{ 
			$this->db->trans_begin();
		   if($is_main==1){
				$clinic['last_modified_ip']   = $ipAddress;
				$clinic['last_modified_date'] = date('Y-m-d H:i:s');
				$clinic['last_modified_by']   = $formFields['author_id'];
				$this->db->update($this->table_name, $clinicInfo, array('clinic_id' => $formFields['clinic_id']));
			}
			//$this->db->update($this->users_table_name, $userInfo, array('id' => $formFields['user_id']));
		//	$this->db->update($this->clinic_table_name, $clinicInfo, array('location_id' => $formFields['clinic_location_id']));
			$this->db->trans_commit();
			$ret_msg = true;
		}
		catch (Exception $e) {
			$this->db->trans_rollback();
			$ret_msg = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		} 
		return $ret_msg;		
		
		
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
}
