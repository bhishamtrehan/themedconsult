<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Billingcodes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		 $this->load->model('clinic/manage_clinics');
		$this->load->model('clinic/manage_patientsearchs');
		$this->load->model('clinic/manage_billingcodes');
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
		$this->lang->load('billingcodes');
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
		$this->lang->load('billingcodes');
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
		$data['title'] = $this->lang->line('billingcodes_title');
		
		$data['breadcrumb_label'] = $this->lang->line('patientsearch_bread');
		$data['breadcrumb_url'] = '';
		
		$this->load->view('inc/header' , $data);

		$this->load->view('inc/master_menu/clinic_menu');

		$data['all_billing_Details'] = $this->manage_billingcodes->all_billing_Details();
		$this->load->view('clinic/billingcode/view', $data);
		
	}

	

	public function add(){
		

		$data = $this->glbl_login();
		
			
		
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$data['all_billing_Details'] = $this->manage_billingcodes->all_billing_Details();
		$this->load->view('clinic/billingcode/add', $data);
		
	}

	public function edit(){
		
	$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues['billing_id']  = $this->input->get('billing_id');
		
		
		$data['all_edit_Details'] = $this->manage_billingcodes->all_billing_edit_Details($inputValues);

		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$this->load->view('clinic/billingcode/edit', $data);
		
	}


	public function add_billingcode(){
		
		$data = $this->glbl_login();
		$data = $this->glbl('clinic_access','clinic_location_access');	
		$inputValues = $this->input->post();

		// print_r($inputValues);
			
		if(isset($inputValues)) {
			
				 
	
			$data['patient_Details'] = $this->manage_billingcodes->add_new_billingcode($inputValues);
			
			$this->session->set_flashdata('billing_msg', 'Billing Code is successfully added.');
			redirect('/clinic/billingcodes');
			
		
			
			
			//$this->load->view('clinic/patientsearch/ajax/patient_details', $data);
		}
		
	}




		public function update_billingcode(){
		
		$data = $this->glbl_login();
		$data = $this->glbl('clinic_access','clinic_location_access');	
		$inputValues = $this->input->post();

		// print_r($inputValues);
			
		if(isset($inputValues)) {
			
				 
	
			$data['patient_Details'] = $this->manage_billingcodes->update_new_billingcode($inputValues);
			
			$this->session->set_flashdata('billing_update', 'Billing Code is successfully updated.');
			redirect('/clinic/billingcodes');
			
		
			
			
			//$this->load->view('clinic/patientsearch/ajax/patient_details', $data);
		}
		
	}



public function delete_billingcode() {
	
		$data = $this->glbl('clinic_access','clinic_location_access');
		$inputValues['billing_id']  = $this->input->get('billing_id');
	
			
		
		if(isset($inputValues)) {
			
				 
	
			$data['patient_Details'] = $this->manage_billingcodes->delete_previous_billingcode($inputValues);
			

			$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$data['all_billing_Details'] = $this->manage_billingcodes->all_billing_Details();
			$this->load->view('clinic/billingcode/view', $data);
		}
			
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
