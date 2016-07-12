<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Master Class
 * @author Visions
 */

class Master extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('auth/tank_auth/users');
		$this->load->model('master/settings');
		$this->lang->load('universal');
		$this->load->library('session');
		$this->load->library('tank_auth');
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
	}
	/**
	* Master Management controller.
	*/
	public function index()
	{
		$data = $this->glbl();
		redirect('/master/dashboard');
	}

	/**
	* Master Dashboard.
	*/

	public function dashboard()
	{
		$this->glbl();
		$data = $this->session->all_userdata();
		$this->load->view('dashboard', array('data'=> $data));
	}

	/**
	* Master Settings.
	*/

	public function settings()
	{
		
		$data = $this->glbl();
		$this->lang->load('master/site_setting/setting');
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$data['title'] = $this->lang->line('title');
		$data['breadcrumb_label'] = $this->lang->line('bread');
		$data['breadcrumb_url'] = '';
		$user_id  = $this->tank_auth->ci->session->userdata['user_id'];
		
		$output = $this->settings->getspecialitySetting();

		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/master_menu');
		$this->load->view('site_settings', array('output' => $output, 'data' =>$data));
	}

	/**
	* Master Setting data loading to site_setting page.
	*/

	public function dataload()
	{
		$data = $this->glbl();
		$this->lang->load('master/site_setting/setting');
		$table = $_POST['table'];
		$output = $this->settings->getSettingData($table);

		if($table == 'mc_consultation')
		{
			$this->load->view('ajax/ajax_table_consultation', array('output' => $output));
		}

		if($table == 'mc_languages')
		{
			$this->load->view('ajax/ajax_table_language', array('output' => $output));
		}

		if($table == 'mc_route')
		{
			$this->load->view('ajax/ajax_table_route', array('output' => $output));
		}

		if($table == 'mc_frequency')
		{
			$this->load->view('ajax/ajax_table_frequency', array('output' => $output));
		}

		if($table == 'mc_speciality')
		{
			$this->load->view('ajax/ajax_table_special', array('output' => $output));
		}
		

	}

	/**
	* Add data from modal.
	*/

	public function addFromModal()
	{
		$data = $this->glbl();
		$input = $_POST['input'];
		$status = $_POST['status'];
		$term = $_POST['term'];
		$row = strtolower($term);
		$table = 'mc_'.$row;
		$output = $this->settings->addSettingModal($input , $table, $row, $status);
	}

	/**
	* Update data from modal.
	*/

	public function updateFromModal()
	{
		$data = $this->glbl();
		$input = $_POST['input'];
		$term = $_POST['term'];
		$id = $_POST['id'];
		$row = strtolower($term);
		$table = 'mc_'.$row;
		$output = $this->settings->updateSettingModal($input , $table, $row, $id);
	}
	

	/**
	* Delete data.
	*/

	public function delete_Data()
	{
		$data = $this->glbl();
		$term = $_POST['term'];
		$id = $_POST['id'];
		$row = strtolower($term);
		$table = 'mc_'.$row;
		$output = $this->settings->deleteSetting($table, $row, $id);
	}
	
	
	
		/**
	* Edit admin Details.
	*/
	public function editProfile()
	{
		
		$data = $this->glbl();
		
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		
		$userId = $userdata['user_id'];
		
		$data['breadcrumb_label'] = $this->lang->line('edit_profile_title');
		$data['breadcrumb_url'] = '';
		
		if(isset($_POST['submit']))
		{
			
			$dataform = $this->input->post();
			$data['output'] = $this->settings->updateMasterProfile($dataform);
			$this->session->set_flashdata('display_message',"Profile is Successfully Updated");
			redirect('master/editProfile');
		}
		else
		{
			$data['countries']    = $this->settings->getCountries();
			$data['output']    = $this->mc_constants->getMasterAdminDetails($userId);
			$data['title'] = $this->lang->line('edit_profile_bread');
			
			$this->load->view('inc/header' , $data);
			$this->load->view('inc/master_menu/master_menu');
			$this->load->view('add_admin/editprofile', $data );
		}
		
	}



	/*********************************************SETTINGS MODULE END************************************************/
	/**
	* Adding Admins.
	*/
	public function addstaff()
	{
		$data = $this->glbl();
		$encId = $this->uri->segment(3);
		if(empty($encId))
		{
			$this->session->set_flashdata('display_message',"Please select a company first.");
			redirect('master/company/view');
		}
		if(isset($_POST['submit']))
		{	
			$dataform = $this->input->post();

			$username = $dataform['username'];
			$email = $dataform['email'];
			$password = $dataform['password'];
			$status = $dataform['status'];
			$dataid = $this->tank_auth->create_user($username, $email, $password, $status);
			$dataform['user_id'] = $dataid['user_id'];
			$data = $this->settings->add_staff($dataform, $user_id);
			$this->session->set_flashdata('display_message',"Successfully added");
			redirect('master/adminlist/'.$encId);

		}
		else
		{
			$this->lang->load('master/add_admin/admin');
			$userdata = $this->session->all_userdata();
			$clinicloc = $this->settings->getClinicLoc($encId);
			$data['clinicloc']=$clinicloc;
			$data['username']=$userdata['username'];
			$data['title'] = $this->lang->line('title');
			$data['companyId'] = $encId;
			$data['breadcrumb_label'] = $this->lang->line('bread');
			$data['breadcrumb_url'] = '';
			$data['countries']    = $this->settings->getCountries();
			$this->load->view('inc/header' , $data);
			$this->load->view('inc/master_menu/master_menu');
			$this->load->view('add_admin/add_admin');

		}
		
	}

	/**
	* Fetching Admin List.
	*/
	public function adminlist($company)
	{
		$data = $this->glbl();
		$cId = $this->encryption->decode($company); 
		$this->lang->load('master/add_admin/view_admin');
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$data['title'] = $this->lang->line('title');
		$data['cId'] = $company;
		$data['breadcrumb_label1'] = $this->lang->line('bread');
		$data['breadcrumb_url1'] = '';
		
		$data['breadcrumb_label'] = 'Company';
		$data['breadcrumb_url'] = base_url().'master/company/view';
		$data['output'] = $this->settings->getadminList($cId);
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/master_menu');
		$this->load->view('add_admin/view', $data );
	}

	/**
	* Deactivating admin account.
	*/
	public function deactadmin()
	{
		$data = $this->glbl();
		$this->lang->load('master/add_admin/view_admin');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$cId = $this->input->post('cId');
		$output = $this->settings->deactAdmin($id, $status, $cId);
		$company = $cId;
		$this->load->view('add_admin/ajax/ajax_admin_list', array('output' => $output, 'c_id' => $company));
	}

	/**
	* Activating admin account.
	*/
	public function actadmin()
	{
		$data = $this->glbl();
		$this->lang->load('master/add_admin/view_admin');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$cId = $this->input->post('cId');
		$output = $this->settings->actAdmin($id, $status, $cId);
		$company = $cId;
		$this->load->view('add_admin/ajax/ajax_admin_list', array('output' => $output , 'c_id' => $company));
	}

	/**
	* Deleting admin account to TRASH.
	*/
	public function deleteadmin()
	{
		$data = $this->glbl();
		$this->lang->load('master/add_admin/view_admin');
		$id = $this->input->post('id');
		$status =  $this->input->post('status');
		$cId =  $this->input->post('cId');
		$output = $this->settings->deleteAdmin($id, $status, $cId);
		$company = $cId;
		$this->load->view('add_admin/ajax/ajax_admin_list', array('output' => $output , 'c_id' => $company));
	}

	/**
	* Edit admin Details.
	*/
	public function edit()
	{
		
		if(isset($_POST['submit']))
		{
			$data = $this->glbl();
			$dataform = $this->input->post();
			$data['output'] = $this->settings->updateAdmin($dataform);
			$this->session->set_flashdata('display_message',"Successfully Updated");
			$encId = $this->session->userdata("cid");
			redirect('master/adminlist/'.$encId);
		}
		else
		{
			$data = $this->glbl();
			$this->lang->load('master/add_admin/admin');
			$data['countries']    = $this->settings->getCountries();
			
			$data['title'] = $this->lang->line('edit_title');
			$data['breadcrumb_label'] = $this->lang->line('edit_bread');
			$data['breadcrumb_url'] = '';
			$staffID = $this->uri->segment(3);
			$id = $this->encryption->decode($staffID);
			$data['output'] = $this->settings->getEditStaff($id);
			$encId = $this->encryption->encode($data['output']['companyId']); 
			$clinicloc = $this->settings->getClinicLoc($encId);
			$data['clinicloc']=$clinicloc;
			$this->load->view('inc/header' , $data);
			$this->load->view('inc/master_menu/master_menu');
			$this->load->view('add_admin/edit', $data );
		}
		
	}

	//Mark notification as read
	function markNotificationRead()
	{
		$this->glbl_login();
		$userID = $this->input->post('userId');
		$markasRead = $this->mc_constants->markAsReadNotifications($userID);
		if($markasRead == 'TRUE')
		{
			echo "Marked as read";
		}
	}

}
