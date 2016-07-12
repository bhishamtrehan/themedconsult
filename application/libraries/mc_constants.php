<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class mc_constants{
        public $superadmin                        = 1; 
        public $clinic_admin                      = 2; 
        public $practitioner                      = 3; 
        public $patient                           = 4; 
        public $role_table_name	                  = 'mc_user_roles';	         
        public $mc_users	                  	  = 'mc_users';	                 
        public $mc_master_info	                  	  = 'mc_master_info';	 
        public $mc_notify	                  	  = 'mc_notifications';	 
	 
	 //var $default_timezone                     = 'Australia/Melbourne';
	 var $default_timezone                     = 'India/Delhi';
		
		function __construct(){
			$this->ci = &get_instance();
				      
			$this->role_table_name	= /* $ci->config->item('db_table_prefix', 'tank_auth'). */$this->role_table_name;
			$this->mc_master_info	= /* $ci->config->item('db_table_prefix', 'tank_auth'). */$this->mc_master_info;
			$this->mc_users	= /* $ci->config->item('db_table_prefix', 'tank_auth'). */$this->mc_users;
			$this->mc_notify	= $this->mc_notify;
			date_default_timezone_set($this->default_timezone);
		}	
	public function remote_ip(){
	            return $_SERVER['REMOTE_ADDR'];	
		}
	public function time_stamp(){
	            return time();	
		}
	
	public function send_custom_email($subject, $recipient, $content, $attachment='') {
			$data = array();
			$this->ci->load->library('email');
			$this->ci->email->from('', '');
			$this->ci->email->to($recipient); 
			$this->ci->email->subject($subject);
			$data['mail_content'] = $content;
			$html = $this->ci->load->view('auth/email/shc_email_template', $data, true);
			$this->ci->email->message($html);
			if($attachment!=""){
		    	$this->ci->email->attach($attachment);
			}else{
				
			}
				
			if($this->ci->email->send()){
				return true;
			}else{
				return false;		
			}	
	   }
	
	function get_role_id($user_id=0){
			$return = 100; /* Invalid role id */
			if($user_id!=0 && $user_id!=''){
                              $this->ci->db->where('user_id', $user_id);
                              $query = $this->ci->db->get($this->role_table_name);
                              if($query->num_rows() > 0){ 
                                 $return= $query->row()->role_id;
                              }
			}
			return $return;
	    }
	
	function getMasterAdminDetails($user_id=0){
		
		$return= array();
		if($user_id!=0 && $user_id!=''){
	    $this->ci->db->select("*");
	    $this->ci->db->from($this->mc_users .' as mu');
        $this->ci->db->join($this->mc_master_info .' as mi', 'mu.id=mi.user_id','left');
	    $this->ci->db->where("mu.id",$user_id);	
            $query = $this->ci->db->get();
            if($query->num_rows()>0){
                  $return=$query->row();
            }
		}
    	return $return;
		
	    }


	// Get Notifications
	function getNotifications($user_id)
	{
		$roleId = $this->get_role_id($user_id);
		if($roleId == 1)
		{
			$this->ci->db->select("notify.*, users.username, users.email ");
			$this->ci->db->from($this->mc_notify .' as notify');
			$this->ci->db->join($this->mc_users .' as users', 'users.id = notify.sender_id','left');
			$this->ci->db->where("activity_type" , '0');
			$this->ci->db->where('recipient_id', $user_id);
			$this->ci->db->where('notify.status', '1');
			$this->ci->db->order_by('notify.created', 'DESC');
			
			$this->ci->db->limit('10');
			$query = $this->ci->db->get();
			$result = $query->result_array();

		}
		elseif($roleId == 2)
		{
			$this->ci->db->select("notify.*, users.username, users.email ");
			$this->ci->db->from($this->mc_notify .' as notify');
			$this->ci->db->join($this->mc_users .' as users', 'users.id = notify.sender_id','left');
			$this->ci->db->where('recipient_id', $user_id);
			$this->ci->db->where("activity_type" , '1');
			$this->ci->db->where('notify.status', '1');
			$this->ci->db->order_by('notify.created', 'DESC');

			$this->ci->db->limit('10');
			$query = $this->ci->db->get();
			$result = $query->result_array();
			
		}
		else
		{
			$result = "";
		}
		
		return $result;
	}

		function archiveNotifications($user_id)
			{
				$roleId = $this->get_role_id($user_id);
				if($roleId == 1)
				{
					$this->ci->db->select("notify.*, users.username, users.email ");
					$this->ci->db->from($this->mc_notify .' as notify');
					$this->ci->db->join($this->mc_users .' as users', 'users.id = notify.sender_id','left');
					$this->ci->db->where("activity_type" , '0');
					$this->ci->db->where('recipient_id', $user_id);
					$this->ci->db->where('notify.status', '2');
					$this->ci->db->order_by('notify.created', 'DESC');
					
					$this->ci->db->limit('5');
					$query = $this->ci->db->get();
					$result = $query->result_array();

				}
				elseif($roleId == 2)
				{
					$this->ci->db->select("notify.*, users.username, users.email ");
					$this->ci->db->from($this->mc_notify .' as notify');
					$this->ci->db->join($this->mc_users .' as users', 'users.id = notify.sender_id','left');
					$this->ci->db->where('recipient_id', $user_id);
					$this->ci->db->where("activity_type" , '1');
					$this->ci->db->where('notify.status', '2');
					$this->ci->db->order_by('notify.created', 'DESC');

					$this->ci->db->limit('5');
					$query = $this->ci->db->get();
					$result = $query->result_array();
					
				}
				else
				{
					$result = "";
				}
				
				return $result;
			}

	function deleteNotifications($user_id)
	{
		$roleId = $this->get_role_id($user_id);
		if($roleId == 1)
		{
			$this->ci->db->select("notify.*, users.username, users.email ");
			$this->ci->db->from($this->mc_notify .' as notify');
			$this->ci->db->join($this->mc_users .' as users', 'users.id = notify.sender_id','left');
			$this->ci->db->where("activity_type" , '0');
			$this->ci->db->where('recipient_id', $user_id);
			$this->ci->db->where('notify.status', '3');
			$this->ci->db->order_by('notify.created', 'DESC');
			
			$this->ci->db->limit('5');
			$query = $this->ci->db->get();
			$result = $query->result_array();

		}
		elseif($roleId == 2)
		{
			$this->ci->db->select("notify.*, users.username, users.email ");
			$this->ci->db->from($this->mc_notify .' as notify');
			$this->ci->db->join($this->mc_users .' as users', 'users.id = notify.sender_id','left');
			$this->ci->db->where('recipient_id', $user_id);
			$this->ci->db->where("activity_type" , '1');
			$this->ci->db->where('notify.status', '3');
			$this->ci->db->order_by('notify.created', 'DESC');

			$this->ci->db->limit('5');
			$query = $this->ci->db->get();
			$result = $query->result_array();
			
		}
		else
		{
			$result = "";
		}
		
		return $result;
	}





	// Mark Notification as Read
	function markAsReadNotifications($userID)
	{
		$timeSeen = date('Y-m-d H:i:s');
		$this->ci->db->set('is_read', 1);
		$this->ci->db->set('time_seen', $timeSeen);
		$this->ci->db->where('recipient_id', $userID);
		$this->ci->db->update($this->mc_notify);
		return TRUE;
	}

	function getNotificationsCount($userID)
	{
		$this->ci->db->select("notify.is_read");
		$this->ci->db->from($this->mc_notify .' as notify');
		$this->ci->db->where('recipient_id', $userID);
		$this->ci->db->where("is_read" , '0');
		$query = $this->ci->db->get();
		$result = $query->num_rows();
		if($result == 0)
		{
			$result = "";
			return $result;
		}
		else
		{
			return $result;
		}
	}
}



/* End of file mc_constants.php */
?>
