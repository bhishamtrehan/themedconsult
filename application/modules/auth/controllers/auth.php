<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('mc_constants');
		$this->load->helper('security');
		$this->load->model('auth/tank_auth/users');
		$this->load->library('tank_auth');
		$this->lang->load('master/login/login');
		$this->load->library('encryption');
		$this->lang->load('tank_auth');
		$this->load->library('mc_constants');
	}
        
    function glbl() // declare global functions and variables
	{
		/*------------- load useful libraries and helpers  --------------------*/
		$this->load->library('pagination');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		
		
	    $this->load->model('clinic/manage_settings');
		$this->lang->load('tank_auth');
		$this->lang->load('universal');
		if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$config = array('userID'=>$userId);					
		$this->load->library('acl',$config);
		
		
	}

	function index()
	{
		if ($message = $this->session->flashdata('message')) {
			$this->load->view('auth/general_message', array('message' => $message));
		} else {
			redirect('/auth/login/');
		}
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	function login()
	{

		if ($this->tank_auth->is_logged_in()) {								// logged in

			$user_id = $this->tank_auth->ci->session->userdata['user_id'];
			$this->user_type_access($user_id);

		} 
		// elseif ($this->tank_auth->is_logged_in(FALSE)) {				// logged in, not activated

		// 	 redirect('/auth/send_again/');

		// } 
		else {

			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
			$this->form_validation->set_rules('login', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');
			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('login'))) {
				$login = $this->security->xss_clean($login);
			} else {
				$login = '';
			}

			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$data['login_by_username'],
						$this->input->post('roleId'),
						$data['login_by_email'])) {

													// success
					redirect('');

				} else {
					$errors = $this->tank_auth->get_error_message();

					if (isset($errors['banned'])) {								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} elseif (isset($errors['not_activated'])) {				// not activated user
						//redirect('/auth/login/');

						$user_id = $this->tank_auth->ci->session->userdata['user_id'];
						$userRole = $this->users->get_roleId($user_id);
						$roleById = $userRole->role_id;

						if($roleById == 3)
						{
							$encodedUserId = $this->encryption->encode($user_id);
							$encodedRoleID = $this->encryption->encode($roleById);
							echo '<a href="'.base_url().'auth/activate_account/'.$encodedUserId.'/'.$encodedRoleID.' ">Please click to your activate account.</a>';
						}
						if($roleById == 2)
						{
							$encodedUserId = $this->encryption->encode($user_id);
							$encodedRoleID = $this->encryption->encode($roleById);
							echo '<a href="'.base_url().'auth/activate_account/'.$encodedUserId.'/'.$encodedRoleID.' ">Please click to your activate account.</a>';
						}
						if($roleById == 1)
						{
							redirect('/auth/login/');
						}
						if($roleById == 4)
						{
							$encodedUserId = $this->encryption->encode($user_id);
							$encodedRoleID = $this->encryption->encode($roleById);
							echo '<a href="'.base_url().'auth/activate_account/'.$encodedUserId.'/'.$encodedRoleID.' ">Please click to your activate account.</a>';
						}

					} else {
						$this->session->set_flashdata('display_message',$this->lang->line('auth_incorrect_login'));// fail
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			//die;
			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha']) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			
			if($this->input->post('roleId') == 1)
			{
				redirect('/auth/login/');
			}
			if($this->input->post('roleId') == 2)
			{
				redirect('/clinic/login/');
			}
			if($this->input->post('roleId') == 3)
			{
				redirect('/health_practitioner/login/');
			}
			if($this->input->post('roleId') == 4)
			{
				redirect('/patient/login/');
			}
			$data['roleId'] = '1';
			$data['account'] = 'master';
			$data['title'] = "Login | Medconsult";
			$this->load->view('inc/header_login', $data);
			$this->load->view('login_form', $data);
			$this->load->view('inc/footer_login', $data);
			
		}
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	function logout()
	{
		$this->tank_auth->logout();
		// $user_role_id  = $this->session->userdata('role_ID_check');
		// if($user_role_id == 3)
		// {
		// 	redirect('/health_practitioner/login/');
		// }
		//$this->_show_message($this->lang->line('auth_message_logged_out'));
		redirect('auth/login');
	}

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	function register()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));

		} else {
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|unique|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
			}
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				} else {
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
				}
			}
			$data['errors'] = array();

			$email_activation = $this->config->item('email_activation', 'tank_auth');

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$email_activation))) {									// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					if ($email_activation) {									// send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

						$this->_send_email('activate', $data['email'], $data);

						unset($data['password']); // Clear password (just for any case)

						$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

					} else {
						if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

							$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Clear password (just for any case)

						$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
					}
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {

					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			$data['use_username'] = $use_username;
			$data['captcha_registration'] = $captcha_registration;
			$data['use_recaptcha'] = $use_recaptcha;
			$this->load->view('inc/header_login', $data);
			$this->load->view('auth/register_form', $data);
			$this->load->view('inc/footer_login', $data);
		}
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	function send_again()
	{
		if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/send_again_form', $data);
		}
	}

	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function activate()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Activate user
		if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));
        }else{																// fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}

	/**
	 * Generate reset code (to change password) and send it to user
	 *
	 * @return void
	 */
	function forgot_password()
	{
		$this->lang->load('master/login/forgot');
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} else {
			$this->form_validation->set_rules('login', 'Username', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->forgot_password(
						$this->form_validation->set_value('login')))) {

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with password activation link
					$this->_send_email('forgot_password', $data['email'], $data);

					/* $this->_show_message($this->lang->line('auth_message_new_password_sent'));*/
                                        $this->session->set_flashdata('display_message', $this->lang->line('auth_message_new_password_sent'));
		                        redirect('/auth/forgot_password');

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('inc/header_login');
			$this->load->view('auth/forgot_password_form', $data);
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_password()
	{
		$user_id		= $this->uri->segment(3);
		$new_pass_key	= $this->uri->segment(4);

		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if (!is_null($data = $this->tank_auth->reset_password(
					$user_id, $new_pass_key,
					$this->form_validation->set_value('new_password')))) {	// success

				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				// Send email with new password
				$this->_send_email('reset_password', $data['email'], $data);
				/* $this->_show_message($this->lang->line('auth_message_new_password_activated'));*/
                                $this->session->set_flashdata('display_message', $this->lang->line('auth_message_new_password_activated'));
		                redirect('/auth/login');

			} else {														// fail
				/* $this->_show_message($this->lang->line('auth_message_new_password_failed'));*/
                                $this->session->set_flashdata('display_message', $this->lang->line('auth_message_new_password_activated'));
		                redirect('/auth/reset_password');
			}
		} else {
			// Try to activate user by password key (if not activated yet)
			if ($this->config->item('email_activation', 'tank_auth')) {
				$this->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
                                $this->session->set_flashdata('display_message', $this->lang->line('auth_message_new_password_activated'));
		                redirect('/auth/reset_password/'.$user_id.'/'.$new_pass_key);
				/* $this->_show_message($this->lang->line('auth_message_new_password_failed'));*/
			}
		}
                $this->load->view('inc/header', $data);
		$this->load->view('auth/reset_password_form', $data);
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function check_current_password() {
		$inputValues = $this->input->get();
		$returnVal = $this->tank_auth->check_password($inputValues['old_password']);
		echo $returnVal;exit;
	}
	function change_password()
	{
		$data     = $this->glbl();
		$userId   = $this->tank_auth->ci->session->userdata['user_id'];
		$user_id  = $this->tank_auth->ci->session->userdata['user_id'];
		$data['role_id'] = $this->mc_constants->get_role_id($userId);
    	if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			    redirect('/auth/login/');
           }else{
				
			  $inputValues = $this->input->post();	
			  
			  if((isset($inputValues['question_second']) && $inputValues['question_second']) && (isset($inputValues['answer_second']) && $inputValues['answer_second']) && ($this->manage_settings->checkQuestionSecond($inputValues['question_second'],$inputValues['answer_second'],$user_id)=='true')  || (isset($inputValues['new_password']) && $inputValues['new_password'])){
				  
				 if((isset($inputValues['new_password']) && $inputValues['new_password']) && (isset($inputValues['old_password']) && $inputValues['old_password'])){	
					  $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
					  $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
					  $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
					  $data['errors'] = array();
						if($inputValues = $this->input->post()) {
							if ($this->tank_auth->change_password(
									$inputValues['old_password'],
									$inputValues['new_password'])) {	// success
								    //$this->_show_message($this->lang->line('auth_message_password_changed'));
								    $this->session->set_flashdata('display_message', $this->lang->line('auth_message_password_changed'));
								    redirect('/auth/change_password');

							} else {														// fail
								$errors = $this->tank_auth->get_error_message();
								foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
							}
						}
				  }
				  $this->load->view('auth/change_password_form', $data);		
              }elseif((isset($inputValues['question_first']) && $inputValues['question_first']) && (isset($inputValues['answer_first']) && $inputValues['answer_first']) && ($this->manage_settings->checkQuestionFirst($inputValues['question_first'],$inputValues['answer_first'],$user_id)=='true')  || (isset($inputValues['question_second']) && $inputValues['question_second'])){
				  
				      $ssetings                                  = $this->manage_settings->getSecuritySettings($user_id);
					  if(count($ssetings)>0){
						$question_second                         = $ssetings['question_second'];
						$answer_second_value                     = $ssetings['answer_second'];
					  }else{
 					    $question_second                         = "";
						$answer_second_value                     = "";
					  }
				   	 
				   	  $reslist                                 = $this->manage_settings->security_question();
					  if(count($reslist)>0){
						   foreach($reslist as $res){
								$result[$res->security_question_id] = $res->security_question_name;
							}
					   }
					   $ssetings                                = $this->manage_settings->getSecuritySettings($user_id);
					   if(count($ssetings)>0){
						 $question_second                         = $ssetings['question_second'];
						 $answer_second_value                     = $ssetings['answer_second'];
					   }else{
 					     $question_second                         = "";
						 $answer_second_value                     = "";
					   }
					   $data['question']                = $result;
					   $data['question_second']         = $question_second;
		               $data['answer_second_value']     = $answer_second_value;
		               if(!isset($inputValues['question_second'])){
					       $this->load->view('auth/security_question_second', $data);
				       }else{
						   echo '1';
						   exit;
                       }
			   }else{
				   	$reslist                                 = $this->manage_settings->security_question();
					if(count($reslist)>0){
						foreach($reslist as $res){
							$result[$res->security_question_id] = $res->security_question_name;
						}
					}
					$ssetings                                = $this->manage_settings->getSecuritySettings($user_id);
					if(count($ssetings)>0){
						$question_first                          = $ssetings['question_first'];
						$answer_first_value                      = $ssetings['answer_first'];
					}else{
						$question_first                          = "";
						$answer_first_value                      = "";
					}
					$data['question']                = $result;
					$data['question_first']          = $question_first;
					$data['answer_first_value']      = $answer_first_value;
	                if(!isset($inputValues['question_first'])){
 			  	       $this->load->view('inc/header', $data);
					   $this->load->view('auth/security_question_first', $data);
				    }else{
					  echo '1';	
					  exit;
					}
			   }
		}
	}

	/**
	 * Change user email
	 *
	 * @return void
	 */
	function change_email()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->set_new_email(
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password')))) {			// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with new email address and its activation link
					$this->_send_email('change_email', $data['new_email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/change_email_form', $data);
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_email()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Reset email
		if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {	// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_new_email_activated').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_new_email_failed'));
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	function unregister()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->delete_user(
						$this->form_validation->set_value('password'))) {		// success
					$this->_show_message($this->lang->line('auth_message_unregistered'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/unregister_form', $data);
		}
	}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/auth/');
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
              
	}

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	function _create_captcha()
	{
		$this->load->helper('captcha');
		
		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
		));
		
		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}
	function check_username()
	{
		$inputVal = $this->input->get();
		//echo '<pre>'; print_r($inputVal); die;
		$result = 'false';
		if($inputVal != "")
		{
			
			$availUsername = $this->tank_auth->is_username_available($inputVal['username'],$inputVal['role_id']);
			if($availUsername == '1')
				$result = 'true';
		}
		echo $result;
	}
	
	function check_hp_username()
	{
		$inputVal = $this->input->get();
		$result = 'false';
		if($inputVal != "")
		{
			
			$availUsername = $this->tank_auth->is_username_available($inputVal['hp_username'],$inputVal['role_id']);
			if($availUsername == '1')
				$result = 'true';
		}
		echo $result;
	}
	
	function check_email()
	{
		
		$inputVal = $this->input->get();
		$result = 'false';
		if($inputVal != "")
		{
			$availUsername = $this->tank_auth->is_email_available($inputVal['email'],$inputVal['role_id']);
			if($availUsername == '1')
				$result = 'true';
		}
		echo $result;
	}
	
	function check_hp_email()
	{
		
		$inputVal = $this->input->get();
		$result = 'false';
		if($inputVal != "")
		{
			
			$availUsername = $this->tank_auth->is_email_available($inputVal['hp_email'],$inputVal['role_id']);
			if($availUsername == '1')
				$result = 'true';
		}
		echo $result;
	}
	
	
	
	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}
	/*
	*Get user role custom function
	*
	*/
	function user_type_access($user_id) {
		$userRole = $this->users->get_roleId($user_id);
		
		if(!isset($this->session->userdata['user_role']))
			$this->session->set_userdata('user_role', $userRole->role_id);
		
		if($userRole) {
			if($userRole->role_id == $this->mc_constants->superadmin) {
				redirect('master/settings');
			} else if($userRole->role_id == $this->mc_constants->clinic_admin) {
				redirect('clinic/dashboard');
			} else if($userRole->role_id == $this->mc_constants->practitioner) {
				redirect('health_practitioner/dashboard');
			} else if($userRole->role_id == $this->mc_constants->patient) {
				redirect('patient/dashboard');
			}
		}
		else {
			//if user role not found
			$this->session->set_flashdata('display_message',$this->lang->line('Your account is not currently associated with any role. Please contact website administrator'));
			//redirect('/auth/logout');
		}
	}

	function activate_account()
	{
		$userID = $this->uri->segment(3);
		$roleID = $this->uri->segment(4);
		$decodedRole = $this->encryption->decode($roleID);

		$checkStatus = $this->users->get_userStatus($userID);
		if($checkStatus == 0)
		{
			if ($decodedRole == 2)
			{
				
			}
			if ($decodedRole == 3)
			{
				$activateAccount = $this->users->act_user_account($userID);
				//Email to master admin code here//

				// Email code end here//

				$notificationToMaster = $this->users->notification_for_approv($userID);

				echo $this->lang->line('account_act');
				echo '<br>';
				echo '<a href="'.base_url().'health_practitioner/login/">Login Now</a>';
				
			}
			if ($decodedRole == 4)
			{
				
			}
		}
		if($checkStatus == 1)
		{
			if ($decodedRole == 2)
			{
				echo $this->lang->line('already_act');
			}
			if ($decodedRole == 3)
			{
				echo '<br>';
				echo '<a href="'.base_url().'health_practitioner/login/">Login Now</a>';
				echo $this->lang->line('already_act');
			}
			if ($decodedRole == 4)
			{
				echo $this->lang->line('already_act');
			}
			
		}
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
