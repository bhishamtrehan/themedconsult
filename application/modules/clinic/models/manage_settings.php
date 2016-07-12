<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nutrients
 *
 * This model handles nutrients. It operates the following tables:
 * 
 * @author	Visions 11/09/2015
 */
class Manage_settings extends CI_Model
{
	private $shc_clinic_setting	              = 'shc_clinic_setting'; // settings
	private $shc_clinic_locations	          = 'shc_clinic_locations'; // settings
    private $shc_clinic_location_setting	  = 'shc_clinic_location_setting'; // settings
    private $shc_users	                      = 'shc_users'; // user
    private $shc_users_security_questions     = 'shc_user_security_questions'; // user security questions
    private $shc_users_security_setting       = 'shc_user_security_setting'; // user security questions
    private $shc_subscription_setting       = 'shc_subscription_chk'; // user account subscription 
	
	function __construct()
	{
		parent::__construct();
		$ci                                   = &get_instance();
		$this->shc_clinic_setting             = $this->shc_clinic_setting;
		$this->clinic_table_name	          = $this->shc_clinic_locations;
        $this->shc_clinic_location_setting	  = $this->shc_clinic_location_setting;
        $this->shc_users	                  = $this->shc_users;
        $this->shc_users_security_questions	  = $this->shc_users_security_questions;
        $this->shc_users_security_setting	  = $this->shc_users_security_setting;
	}
	
	public function getClinicSetting($clinic_id=0){
		$results = array();
		if($clinic_id!='' && $clinic_id!=0){
			$this->db->select("*");
			$this->db->from($this->shc_clinic_setting);
			$this->db->where('clinic_id',$clinic_id);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$results = $query->row_array();
			}
		}		
		return $results;
	}
	
	
	public function getSecuritySettings($user_id=0){
		$results = array();
		if($user_id!='' && $user_id!=0){
			$this->db->select("*");
			$this->db->from($this->shc_users_security_setting);
			$this->db->where('user_id',$user_id);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$results = $query->row_array();
			}
		}		
		return $results;
	}
	public function checkQuestionFirst($question="",$answer="",$user_id=0){
		$return = false;
		
		if(($user_id!='' && $user_id!=0) && $question!="" && $answer!=""){
			$this->db->select("*");
			$this->db->from($this->shc_users_security_setting);
			$this->db->where('user_id',$user_id);
			$this->db->where('question_first',$question);
			$this->db->where('answer_first',$answer);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return = true;
			}
		}		
		return $return;
	}
	public function checkQuestionSecond($question="",$answer="",$user_id=0){
		$return = false;
		
		if(($user_id!='' && $user_id!=0) && $question!="" && $answer!=""){
			$this->db->select("*");
			$this->db->from($this->shc_users_security_setting);
			$this->db->where('user_id',$user_id);
		    $this->db->where('question_second',$question);
			$this->db->where('answer_second',$answer);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return = true;
			}
		}		
		return $return;
	}
	
	/*public function checkPassword($formValue =array()){
		$results = false;
		if(count($formValue)>0 && (isset($formValue['user_id']) && $formValue['user_id']!=0) && (isset($formValue['password']) && $formValue['password']!='')){
			$this->db->select("*");
			$this->db->from($this->shc_users);
			$this->db->where('id',$formValue['user_id']);
			$this->db->where('password',$formValue['password']);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$results = true;
			}
		}
		
		return $results;
	}*/
	public function getLocationDetails($location_id = 0){
		$return= array();
		if($location_id!=0 && $location_id!=''){
		   
            $this->db->select("*");
			$this->db->from($this->clinic_table_name .' as cloc');
			$this->db->where('cloc.location_id',$location_id);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row_array();
			}   	
		}
		return $return;
	}
    public function security_question(){
		$return= array();
		   
            $this->db->select("*");
			$this->db->from($this->shc_users_security_questions);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->result();
			}   	
		return $return;
	}
    public function getLocationSettings($location_id = 0){
		$return         = array();
		if($location_id!=0 && $location_id!=''){
		    $this->db->select("*");
			$this->db->from($this->shc_clinic_location_setting .' as cloc');
			$this->db->where('cloc.clinic_location_id',$location_id);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$return=$query->row_array();
			}   	
		}
		return $return;
	}
	
    public function clinicSetting($formValue =array()){
		$return     = 0;
		//echo '<pre>'; print_r($formValue); exit;
		if(is_array($formValue) && count($formValue)>0){
			$ipAddress                                = $this->shc_constants->remote_ip();
			$inputList['created_ip']                  = $ipAddress;
			$inputList['created_date']                = @date('Y-m-d H:i:s');
			$inputList['created_by']                  = $formValue['clinic_id'];
                        
                        $inputList2['created_ip']                  = $ipAddress;
			$inputList2['created_date']                = @date('Y-m-d H:i:s');
			$inputList2['created_by']                  = $formValue['clinic_location_id'];
                        
                        $updateList['last_modified_ip']           = $ipAddress;
			$updateList['last_modified_date']         = @date('Y-m-d H:i:s');
			$updateList['last_modified_by']           = $formValue['author_id'];
                        
                        $updateList2['last_modified_ip']           = $ipAddress;
			$updateList2['last_modified_date']         = @date('Y-m-d H:i:s');
			$updateList2['last_modified_by']           = $formValue['author_id'];
	 
			$clinic_setting                           =  $this->getClinicSetting($formValue['clinic_id']);
                        $clinic_location_setting                  =  $this->getLocationSettings($formValue['clinic_location_id']);
			
			if(count($clinic_setting)>0){
                                $updateList['abn_number']             = $formValue['abn_number'];
				$updateList['website_url']            = $formValue['website_url'];
				$updateList['clinic_logo']            = $formValue['clinic_logo'];
				$clinic_id                            = $formValue['clinic_id'];
                                $updateList['clinic_letterhead_header'] = $formValue['clinic_letterhead_header'];
                                $updateList['clinic_letterhead_footer'] = $formValue['clinic_letterhead_footer'];
				//$updateList['currency']               = $formValue['currency'];
				//$updateList['tax_applicable']         = $formValue['tax_applicable'];
				//$updateList['tax_amount']             = $formValue['tax_amount'];
                                if(isset($formValue['hidden_headerimage']) && $formValue['hidden_headerimage'] != '')
                                {
                                    $updateList['header_image'] = $formValue['hidden_headerimage'];
                                }
                                
                                if(isset($formValue['hidden_footerimage']) && $formValue['hidden_footerimage'] != '')
                                {
                                    $updateList['footer_image'] = $formValue['hidden_footerimage'];
                                }
                                
					
				try{
					$this->db->trans_begin(); 
					$this->db->update($this->shc_clinic_setting, $updateList, array('clinic_id' => $clinic_id));
					$this->db->trans_commit();
					$return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
			}else{
			
				$inputList['abn_number']             = $formValue['abn_number'];
				$inputList['website_url']            = $formValue['website_url'];
				$inputList['clinic_logo']            = $formValue['clinic_logo'];
				$inputList['clinic_id']              = $formValue['clinic_id'];
                                $inputList['clinic_letterhead_header'] = $formValue['clinic_letterhead_header'];
                                $inputList['clinic_letterhead_footer'] = $formValue['clinic_letterhead_footer'];
				//$inputList['currency']               = $formValue['currency'];
				//$inputList['tax_applicable']         = $formValue['tax_applicable'];
				//$inputList['tax_amount']             = $formValue['tax_amount'];
                                if(isset($formValue['hidden_headerimage']) && $formValue['hidden_headerimage'] != '')
                                {
                                    $inputList['header_image'] = $formValue['hidden_headerimage'];
                                }
                                
                                if(isset($formValue['hidden_footerimage']) && $formValue['hidden_footerimage'] != '')
                                {
                                    $inputList['footer_image'] = $formValue['hidden_footerimage'];
                                }
					
				try {
					$this->db->trans_begin(); 
					$this->db->insert($this->shc_clinic_setting, $inputList);
					$this->db->trans_commit();
					$return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
			}
                        
                        if(count($clinic_location_setting)>0)
                        {
                                $clinic_id                            = $formValue['clinic_id'];
                                $clinic_location_id                   = $formValue['clinic_location_id'];
				$updateList2['currency']              = $formValue['currency'];
				$updateList2['tax_applicable']        = $formValue['tax_applicable'];
				$updateList2['tax_amount']            = $formValue['tax_amount'];
					
				try{
					$this->db->trans_begin(); 
					$this->db->update($this->shc_clinic_location_setting, $updateList2, array('clinic_location_id' => $clinic_location_id));
					$this->db->trans_commit();
					$return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
                        }
                        else
                        {
                                $inputList2['clinic_id']              = $formValue['clinic_id'];
                                $inputList2['clinic_location_id']     = $formValue['clinic_location_id'];
                                $inputList2['currency']               = $formValue['currency'];
				$inputList2['tax_applicable']         = $formValue['tax_applicable'];
				$inputList2['tax_amount']             = $formValue['tax_amount'];
					
				try {
					$this->db->trans_begin(); 
					$this->db->insert($this->shc_clinic_location_setting, $inputList2);
					$this->db->trans_commit();
					$return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
                        }
                        
		}
		return $return;
	} 
	
	public function securitySetting($formValue =array()){
		$return     = 0;
		
		if(is_array($formValue) && count($formValue)>0){
			$ipAddress                                = $this->shc_constants->remote_ip();
			$inputList['created_ip']                  = $ipAddress;
			$inputList['created_date']                = @date('Y-m-d H:i:s');
			$inputList['created_by']                  = $formValue['user_id'];
                        
          
            $updateList['last_modified_ip']           = $ipAddress;
			$updateList['last_modified_date']         = @date('Y-m-d H:i:s');
			$updateList['last_modified_by']           = $formValue['user_id'];
                        
           
	 
			$user_security_setting                    =  $this->getSecuritySettings($formValue['user_id']);
 			
			if(count($user_security_setting)>0){
				
				$updateList['question_first']                       = $formValue['question_first'];
			    $updateList['answer_first']                         = $formValue['answer_first'];
			    $updateList['question_second']                      = $formValue['question_second'];
		 	    $updateList['answer_second']                        = $formValue['answer_second'];
		 	    try{
					$this->db->trans_begin(); 
					$this->db->update($this->shc_users_security_setting, $updateList, array('user_id' => $formValue['user_id'] ));
					$this->db->trans_commit();
					$return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
			}else{
			
			    $inputList['question_first']                 = $formValue['question_first'];
			    $inputList['answer_first']                   = $formValue['answer_first'];
			    $inputList['question_second']                = $formValue['question_second'];
		 	    $inputList['answer_second']                  = $formValue['answer_second'];
		 	    $inputList['user_id']                        = $formValue['user_id'];
	
				try {
					$this->db->trans_begin(); 
					$this->db->insert($this->shc_users_security_setting, $inputList);
					$this->db->trans_commit();
					$return = true;				
				}
				catch (Exception $e) {
					$this->db->trans_rollback();
					$return = log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
				}
			}
                        
		}
		return $return;
	} 
	
	/************Account Upgrade Options************************************/
	
		public function getDetails(){
		$uId = $this->tank_auth->ci->session->userdata['user_id'];
		
		$results = array();
		
			$this->db->select("*");
			$this->db->from($this->shc_subscription_setting);
			$this->db->where('user_id',$uId);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$results = $query->row();
			}
				
		return $results;
	}
	
}
