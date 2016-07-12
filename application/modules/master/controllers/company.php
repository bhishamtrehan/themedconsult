<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Company Class
 * @author Visions
 */

class Company extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('auth/tank_auth/users');
		$this->load->model('master/manage_company');
		$this->load->library('session');
		$this->load->helper('url');
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
		$this->lang->load('master/company/company');
		$this->load->library('mc_constants');
		
		if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$config = array('userID'=>$userId);		
		$this->load->library('acl',$config);
		
		if($this->acl->hasPermission('master_access') != true){
			redirect('auth/login');
        }
	}

	public function view()
	{
		$data = $this->glbl();
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$data['title'] = 'Manage Companies';
		$data['breadcrumb_label'] = 'Manage Companies';
		$data['breadcrumb_url'] = '';
		$output = $this->manage_company->getCompanyList();
		
		$data['output'] = $output;
		$data['title'] = 'Manage Companies';
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/master_menu');
		$this->load->view('company/view');
	}
	
		/**
	* Add data from modal.
	*/

	public function addFromModal()
	{
		$data = $this->glbl();
		$input = $_POST['input'];
		$output = $this->manage_company->addCompanyModal($input);
	}
	
	/**
	* Update data from modal.
	*/

	public function updateFromModal()
	{
		$data = $this->glbl();
		$input = $_POST['input'];
		$id = $_POST['id'];
		
		
		$output = $this->manage_company->updateSettingModal($input, $id);
		echo '<pre>'; print_r($output); die;
	}
	
	
	
}
