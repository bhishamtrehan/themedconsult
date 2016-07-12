<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Patient extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
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
		$this->load->library('shc_constants');
		if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$config = array('userID'=>$userId);					
		$this->load->library('acl',$config);
		
		if($this->acl->hasPermission('patient_access') != true){
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
			$data['roleId'] = '4';
			$data['account'] = 'patient';
			$this->load->view('inc/header_login', $data);
			$this->load->view('auth/login_form', $data);
			$this->load->view('inc/footer_login', $data);
	}
	/**
	* Patient Management controller.
	*/
	public function index()
	{
		$data = $this->glbl();
		redirect('/patient/dashboard');
	}
	public function dashboard() {
		
	}
}