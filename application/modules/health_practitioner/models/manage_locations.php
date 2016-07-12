<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Practitioners
 *
 * This model handles clinic management. It operates the following tables:
 * - Practitioners,
 * - users
 *
 * @author	Visions 28/08/2015
 */

class Manage_locations extends CI_Model
{
	private $clinic_table_name			            = 'mc_clinic';			// Clinic entry
	private $mc_clinic_admin	= 'mc_clinic_admin';	
	private $mc_clinic_access	= 'mc_clinic_access';	
	private $mc_hp_info	= 'mc_hp_info';	
	private $mc_hp_clinic_relation	= 'mc_hp_clinic_relation';	
	private $users_table_name	            = 'mc_users';	
	private $role_table_name	            = 'mc_user_roles';	// role save
	private $mc_practitioners			    = 'mc_hp_info';			// practitioners entry
	private $mc_practitioner_relationship	= 'mc_practitioner_relationship';	
    private $clinic_settings	= 'mc_clinic_setting';	
	private $mc_clinic_users	= 'mc_clinic_users';
	private $mc_clinic_rooms 	            = 'mc_clinic_rooms';	
	function __construct() {
		parent::__construct();
		$ci = & get_instance();
		$this->clinic_table_name			    = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->clinic_table_name;
		$this->mc_clinic_admin	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_admin;
		$this->mc_clinic_access	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_access;
		$this->mc_hp_info	                	= 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_hp_info;
		$this->mc_hp_clinic_relation	        = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_hp_clinic_relation;
		$this->users_table_name   	            = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->users_table_name;
		$this->role_table_name		            = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->role_table_name;
		$this->mc_practitioners		            = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_practitioners;
		$this->mc_practitioner_relationship		= 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_practitioner_relationship;
                $this->clinic_settings		                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->clinic_settings;
		$this->mc_clinic_users	         = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_users;
		$this->mc_clinic_rooms   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_clinic_rooms;
	}
	
	public function clinicLocations($clinicId=0){
	        $return = array();
			if($clinicId!=0){
				
				$this->db->select("cloc.*, usr.email");
				$this->db->from($this->clinic_table_name .' as cloc');
				$this->db->join($this->clinic_relationship_table_name .' as clrel', 'cloc.location_id = clrel.clinic_location_id','inner');
				$this->db->join($this->users_table_name .' as usr', 'clrel.user_id = usr.id','inner');
				$where = "(`cloc`.`status`='1' OR `cloc`.`status`='0') AND `cloc`.`clinic_id` ='".$clinicId."'";
				$this->db->where($where);
				$query = $this->db->get();
				if($query->num_rows()>0){
					$return=$query->result();
					if(count($return)>0){
						foreach($return as $key=>$ret){
							$return[$key]->total_practitioner=$this->locationsCountPractitioner($ret->location_id);
						}
					}
				}
			}
    	return $return;
	}
	
		public function getClinicIdfrFrntOfc($userid){
	    $return= array();
			$this->db->select("cloc.clinic_location_id");
			$this->db->from($this->mc_clinic_users .' as cloc');
			$where = "(cloc.status='1' OR cloc.status='0')";
            $this->db->where($where);
			$this->db->where("cloc.user_id",$userid);	
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row();
			}
		
    	return $return;
	}
	
	
	public function clinicLocationsArray($clinicId=0){
	        $results = array();
			if($clinicId!=0){
				$this->db->select("cloc.location_id, cloc.clinic_name, cloc.city, cloc.suburb");
				$this->db->from($this->clinic_table_name .' as cloc');
				//$this->db->join($this->clinic_relationship_table_name .' as clrel', 'cloc.location_id = clrel.clinic_location_id','inner');
				//$this->db->join($this->users_table_name .' as usr', 'clrel.user_id = usr.id','inner');
				$where = "(`cloc`.`status`='1') AND `cloc`.`clinic_id` ='".$clinicId."'";
				$this->db->where($where);
				$query = $this->db->get();
				if($query->num_rows()>0){
					foreach($query->result_array() as $result) {
						if($result['suburb']!='')
							$location = $result['suburb'];
						else
							$location = $result['city'];
						$results[$this->encryption->encode($result['location_id'])] = $result['clinic_name'].', '.$location;
					}
				}
			}
    	return $results;
		
	}
	public function clinicLocationsID($clinicId=0){
	        $results = array();
			if($clinicId!=0){
				$this->db->select("cloc.location_id");
				$this->db->from($this->clinic_table_name .' as cloc');
				$where = "(`cloc`.`status`='1') AND `cloc`.`clinic_id` ='".$clinicId."'";
				$this->db->where($where);
				$query = $this->db->get();
				if($query->num_rows()>0){
					$results = $query->result();
				} 
			}
    	return $results;
	}
	public function myClinicLocationArray($locationId=0){
	        $results = array();
			if($locationId!=0){
				$this->db->select("cloc.location_id, cloc.clinic_name, cloc.city, cloc.suburb");
				$this->db->from($this->clinic_table_name .' as cloc');
				$where = "(`cloc`.`status`='1') AND `cloc`.`location_id` ='".$locationId."'";
				$this->db->where($where);
				$query = $this->db->get();
				if($query->num_rows()>0){
					foreach($query->result_array() as $result) {
						if($result['suburb']!='')
							$location = $result['suburb'];
						else
							$location = $result['city'];
						$results[$this->encryption->encode($result['location_id'])] = $result['clinic_name'].', '.$location;
					}
				} 
			}
    	return $results;
	}
	public function locationPractitionerArray($locationId=0){
	        $results = array();
			if($locationId!=0){
				$this->db->select("prac.hp_id, prac.first_name, prac.surname");
				$this->db->from($this->mc_practitioners .' as prac');
				$this->db->join($this->mc_practitioner_relationship .' as prac_relation', 'prac_relation.hp_id = prac.hp_id','inner');
				$where = "(`prac_relation`.`status`='1') AND `prac_relation`.`location_id` ='".$locationId."'";
				$this->db->where($where);
				$query = $this->db->get();
				$results[''] = $this->lang->line('select');
				if($query->num_rows()>0){
					foreach($query->result_array() as $result) {
						$results[$this->encryption->encode($result['hp_id'])] = $result['first_name'].' '.$result['surname'];
					}
				} 
			}
    	return $results;
	}
	public function getPractitionerName($locationId=0){
		
	       $results = array();
			if($locationId!=0){
				$this->db->select("prac.hp_id, prac.surname, prac.name");
				$this->db->from($this->mc_hp_info .' as prac');
				$this->db->join($this->mc_hp_clinic_relation .' as prac_relation', 'prac_relation.hp_id = prac.hp_id','inner');
				$where = "( `prac_relation`.`location_id` ='".$locationId."')";
				$this->db->where($where);
				$query = $this->db->get();
				if($query->num_rows()>0) {
					$results = $query->result();
				} 
			}
	
    	return $results;
	}
	public function locationPractitioner($locationId=0){
	        $results = array();
			if($locationId!=0){
				$this->db->select("prac.hp_id, prac.surname, prac.name");
				$this->db->from($this->mc_hp_info .' as prac');
				$this->db->join($this->mc_hp_clinic_relation .' as prac_relation', 'prac_relation.hp_id = prac.hp_id','inner');
				$where = "( `prac_relation`.`location_id` ='".$locationId."')";
				$this->db->where($where);
				$query = $this->db->get();
				if($query->num_rows()>0) {
					$results = $query->result();
				} 
			}
    	return $results;
	}
	/* Get Clinic Rooms function start */
	public function clinicRooms($ClinicId=0){
	        $results = array();
			if($ClinicId!=0){
				$this->db->select("clinicRoom.room, clinicRoom.id");
				$this->db->from($this->mc_clinic_rooms .' as clinicRoom');
				$where = "(`clinic_id` ='".$ClinicId."')";
				$this->db->where($where);
				$query = $this->db->get();
				if($query->num_rows()>0) {
					$results = $query->result();
				}
			}
			// echo "<pre>";
			// print_r($results);
			// die;
    	return $results;
	}

	/* Get Clinic Rooms function end */

	public function getClinicId($userid){
	
	    $return= array();
			$this->db->select("cloc.id");
			$this->db->from($this->mc_clinic_admin .' as cloc');
			$this->db->where("cloc.user_id",$userid);	
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row();
			}
		
    	return $return;
	}
	public function getLocationID($adminid){
		 $return= array();
			$this->db->select("*");
			$this->db->from($this->mc_clinic_access .' as cloc');
			$this->db->where("admin_id",$adminid);	
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row();
			}
    	return $return;
	}
	
	public function getClinicLocationName($Locid){
		$count = count($Locid);
		 $return= array();
		 	for ($i=0; $i < $count; $i++) { 
		 		$this->db->select("*");
				$this->db->from($this->clinic_table_name .' as cloc');
				$this->db->where("clinic_id",$Locid[$i]);	
				$query = $this->db->get();
				if($query->num_rows()>0){
					$value=$query->row();
					array_push($return, $value);
				}
		 	}
			
    	return $return;
	}


	public function getViewClinic($location_id = 0){
		$return= array();
		if($location_id!=0 && $location_id!=''){
		   
            $this->db->select("cloc.*, usr.username, usr.email, usr.id");
			$this->db->from($this->clinic_table_name .' as cloc');
			$this->db->join($this->table_name .' as cl', 'cloc.clinic_id = cl.clinic_id','inner');
			$this->db->join($this->clinic_relationship_table_name .' as clrel', 'clrel.clinic_location_id=cloc.location_id','inner');
			$this->db->join($this->users_table_name .' as usr', 'clrel.user_id=usr.id','inner');
			$where = "(cloc.status='1' OR cloc.status='0')";
			$this->db->where('cloc.location_id',$location_id);
		
            $this->db->where($where);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row_array();
			}   	
		}
		return $return;
	}
	public function getLocationDetails($location_id = 0){
		$return= array();
		if($location_id!=0 && $location_id!=''){
		   
            $this->db->select("cloc.clinic_name, cloc.clinic_id");
			$this->db->from($this->clinic_table_name .' as cloc');
			$this->db->where('cloc.clinic_id',$location_id);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row_array();
			}   	
		}
		return $return;
	}
	
	public function getLocationStatus($id=0,$status_type='enable'){
		$status     = 0;
		$ret_msg    = false;
		if($id!='' && $id!=0){
			
			$status=($status_type=='enable')?1:0;
			$update_data=array('status'=>$status,'end_date'=>@date('Y-m-d H:i:s'));
			try{
				$this->db->where('location_id',$id);
				$this->db->update($this->clinic_table_name,$update_data);
				$ret_msg = true;
			}
			catch (Exception $e) {
				$this->db->trans_rollback();
				$ret_msg = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
			}
		}
		return $ret_msg;
	}
	
	public function	locationsCountPractitioner($location_id=0){
		$return =0;
		if($location_id!=0){
			$this->db->select("count(prel.location_id) as total_practitioner");
			$this->db->from($this->mc_practitioner_relationship .' as prel');
			$this->db->join($this->mc_practitioners .' as pract', 'prel.hp_id=pract.hp_id','inner');
			
			$where = "(`prel`.`status`='1') AND (`pract`.`status`='1') AND `prel`.`location_id` ='".$location_id."'";
			
			$this->db->where($where);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$result=$query->row();
				if(count($result)>0){
					$return=$result->total_practitioner;
				}
			}
		}
		return $return;
		
	}
	
}
