<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		 $this->load->model('clinic/manage_clinics');
		$this->load->model('clinic/manage_notifications');
		 $this->load->model('clinic/manage_locations');
		$this->load->model('auth/tank_auth/users');
	}
	function glbl() // declare global functions and variables
	{
		/*------------- load useful libraries and helpers  --------------------*/
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->load->library('encryption');
		$this->lang->load('tank_auth');
		$this->lang->load('universal');
		$this->load->library('mc_constants');
		
		if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$config = array('userID'=>$userId);		
		$this->load->library('acl',$config);
		
		if($this->acl->hasPermission('clinic_access') != true){
			redirect('misc/error');
        }
	}
	
	function glbl_login() // declare global functions and variables
	{
		/*------------- load useful libraries and helpers  --------------------*/
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->load->library('encryption');
		$this->lang->load('tank_auth');
		$this->lang->load('universal');
		$this->load->library('mc_constants');
		$this->lang->load('master/login/login');
		$this->load->model('auth/tank_auth/login_attempts');
	}


	public function login()
	{
		$data = $this->glbl_login();

			$data['title'] = "Login | Medconsult";
			$data['roleId'] = '2';
			$data['account'] = 'clinic';
			$this->load->view('inc/header_login', $data);
			$this->load->view('auth/login_form', $data);
			$this->load->view('inc/footer_login', $data);
	}

	
	
	/**
	* Clinics Management controller.
	*/




	public function index(){
		
	
		$data = $this->glbl_login();
		
		//echo $returnVal = $this->encryption->encode('26');exit;
		$data['clinic_created']  = $this->manage_clinics->getClinicListbyUser('1');
		$data['datatables']  = $this->manage_clinics->getClinicList('1');
		$data['messages'] = '';
		$data['clinic_disabled'] = '0';
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$data['title'] = $this->lang->line('notifications_title');
		
		$data['breadcrumb_label'] = $this->lang->line('notifications_bread');
		$data['breadcrumb_url'] = '';
		
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$this->load->view('clinic/notifications/view', $data);
		
	}

	public function update_archive_notification() {
		$data = $this->glbl('clinic_access','clinic_location_access');	
		$inputValues = $this->input->post();
		//print_r($inputValues['id']);
		//$clinicID = $inputValues['clinicId'];
		if($inputValues['id']!='') {
			$data['archive_status']   = $this->manage_notifications->archive_notification($inputValues);
			//$html = $this->load->view('clinic/appointment/roster/search_pracs', $data);
			return $html;
		}
		else {
			
		}	
	}	



	public function update_delete_notification() {
		$data = $this->glbl('clinic_access','clinic_location_access');	
		$inputValues = $this->input->post();
		//print_r($inputValues['id']);
		//$clinicID = $inputValues['clinicId'];
		if($inputValues['id']!='') {
			$data['delete_status']   = $this->manage_notifications->delete_notification($inputValues);
			//$html = $this->load->view('clinic/appointment/roster/search_pracs', $data);
			return $html;
		}
		else {
			
		}	
	}


	public function restore_notification() {
		$data = $this->glbl('clinic_access','clinic_location_access');	
		$inputValues = $this->input->post();
		//print_r($inputValues['id']);
		//$clinicID = $inputValues['clinicId'];
		if($inputValues['id']!='') {
			$data['restore_status']   = $this->manage_notifications->restore_notification($inputValues);
			//$html = $this->load->view('clinic/appointment/roster/search_pracs', $data);
			return $html;
		}
		else {
			
		}	
	}



public function deleted_notification() {
	// echo "aman";
	// die();
		$data = $this->glbl('clinic_access','clinic_location_access');	
		//$inputValues = $this->input->post();
		
			// $data['deleted_notifications']   = $this->mc_constants->deleteNotifications();
			// print_r($data);

			$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		//$this->load->view('clinic/notifications/view', $data);
			$this->load->view('clinic/notifications/deleted_notifications', $data);
			return $html;
	
			
	}public function archived_notification() {
	// echo "aman";
	// die();
		$data = $this->glbl('clinic_access','clinic_location_access');	
		//$inputValues = $this->input->post();
		
			// $data['deleted_notifications']   = $this->mc_constants->deleteNotifications();
			// print_r($data);

			$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		//$this->load->view('clinic/notifications/view', $data);
			$this->load->view('clinic/notifications/archived_notifications', $data);
			return $html;
	
			
	}


	


}
