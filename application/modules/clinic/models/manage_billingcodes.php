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
class Manage_billingcodes extends CI_Model
{
	private $table_name			    = 'mc_clinic';			// Clinic entry
	
	private $countries_table_name	            = 'mc_countries';
	private $states_table_name		    = 'mc_states';
	private $cities_table_name		    = 'mc_cities';
	private $aus_suburb_table_name	            = 'mc_aus_suburb_list';	
	private $state_table_name 	            = 'mc_aus_states_list';	
	private $mc_clinic_admin 	            = 'mc_clinic_admin';	
	private $mc_clinic_access 	            = 'mc_clinic_access';	
	private $mc_billing_codes 	            = 'mc_billing_codes';
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
		$this->mc_billing_codes  	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_billing_codes;
		$this->mc_patients   	                = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->mc_patients;
		
	}
	
	
	
	
	
	

	public function add_new_billingcode($inputValues){
	// 	echo $ipAddress                         = $this->mc_constants->remote_ip();
		// print_r($inputValues);
		
			$ipAddress  			= $this->mc_constants->remote_ip();
			
			$billingcode['description']		   = $inputValues['billing_name'];
			$billingcode['item_code_no']		   = $inputValues['billing_code'];
			$billingcode['duration']		   = $inputValues['duration'];
			$billingcode['price']		   = $inputValues['price'];
			$billingcode['gst']		   = $inputValues['gst'];
			
		 	$billingcode['created_ip']          = $ipAddress;
            $billingcode['created_date']        = @date('Y-m-d H:i:s');

		// echo "<pre>";
		// print_r($billingcode);
		// die('dwsfsde');

		 try {
                        $this->db->trans_begin(); 
                   $this->db->insert($this->mc_billing_codes, $billingcode);
                        $this->db->trans_commit();
                $return = true;				
                }
                catch (Exception $e) {
                        $this->db->trans_rollback();
                        $return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
                }


	}

  
		public function all_billing_Details(){

		

		$return= array();
		
		$this->db->select("*");
		$this->db->from($this->mc_billing_codes);
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
