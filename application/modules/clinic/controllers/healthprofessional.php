<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Healthprofessional extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		 $this->load->model('clinic/manage_clinics');
		$this->load->model('clinic/manage_patientsearchs');
		$this->load->model('clinic/manage_healthprofessionals');
		 //$this->load->model('clinic/manage_locations');
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
		$this->lang->load('patientsearch');
		$this->lang->load('healthprofessional');
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
		$this->lang->load('patientsearch');
		$this->lang->load('healthprofessional');
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
		  $user_id= $this->tank_auth->ci->session->userdata['user_id'];
		

	
		$data['breadcrumb_label'] = $this->lang->line('patientsearch_bread');
		$data['breadcrumb_url'] = '';
	

		$data['all_hp_Details'] = $this->manage_healthprofessionals->all_healthprofessional_Details($user_id);
		// echo "<pre>";
		// print_r($data['all_hp_Details']);

		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$this->load->view('clinic/healthprofessional/view', $data);
		
	}

	



public function patient_detail() {
	
		$data = $this->glbl('clinic_access','clinic_location_access');	
		$inputValues = $this->input->post();
		// 	echo "<pre>";
		// print_r($inputValues);
		// die();
				
		
		if(isset($inputValues)) {
			
				 
	
			$data['patient_Details'] = $this->manage_patientsearchs->patient_Details($inputValues);
			

		
			
			
			$this->load->view('clinic/patientsearch/ajax/patient_details', $data);
		}
			
}


	


}
