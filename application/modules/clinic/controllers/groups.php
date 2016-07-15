<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Groups
 * This controller handles Patient Groups. It operates the following tables:
 *
 * @author	Visions 04/07/2016
 */


class Groups extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->model('clinic/appointments');

		$this->load->model('clinic/manage_locations');

        $this->load->model('clinic/manage_settings');

        $this->load->model('master/settings');

		$this->load->model('auth/tank_auth/users');

		$this->load->model('health_practitioner/general');

		$this->load->model('clinic/manage_groups');

		$this->lang->load('groups');


	}
	function glbl($perm1 = '', $perm2 = '') // declare global functions and variables
	{

		/*------------- load useful libraries and helpers  --------------------*/
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->load->library('encryption');
		
		$this->lang->load('appointment');
		$this->lang->load('universal');
		$this->load->library('mc_constants');
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
		
		
		$config = array('userID'=>$this->tank_auth->ci->session->userdata['user_id']);		
		$this->load->library('acl',$config);
		if( ($this->acl->hasPermission($perm1) != true) && ($this->acl->hasPermission($perm2) != true) ) {
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
	
	public function index()
	{

		$data = $this->glbl_login();
		$data['trigger'] = "trigger";
		$data['title'] = $this->lang->line('patient_groups');
		$data['user_id'] = $this->tank_auth->ci->session->userdata['user_id'];
		$data['group_list'] = $this->manage_groups->groupList($data['user_id']);

		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];

		if($inputValues = $this->input->post())
		{
			if($inputValues['submit'] == 'submit')
			{

				$data['saveGroupData'] = $this->manage_groups->saveGroupData($inputValues);
				
				if($data['saveGroupData'] == "true")
				{
					
					$this->session->set_flashdata('added_message_group',$this->lang->line('add_group'));

					redirect('clinic/groups');
					
				}
			}

		}
		else
		{
			$this->load->view('inc/header' , $data);
			$this->load->view('inc/master_menu/clinic_menu');
			$this->load->view('clinic/patientgroups/dashboard');
		}
		
		
	}	


	public function recycle()
	{
		$data = $this->glbl_login();
		
		$data['trigger'] = "trigger";
	//	xattr_get(filename, name);


		$data['title'] = $this->lang->line('patient_groups');
		$data['user_id'] = $this->tank_auth->ci->session->userdata['user_id'];
		$data['group_list'] = $this->manage_groups->groupList($data['user_id']);
		$data['group_list_recycle'] = $this->manage_groups->recycleGroupList($data['user_id']);

		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];

		if($inputValues = $this->input->post())
		{
			if($inputValues['submit'] == 'submit')
			{

				$data['saveGroupData'] = $this->manage_groups->saveGroupData($inputValues);
				
				if($data['saveGroupData'] == "true")
				{
					
					$this->session->set_flashdata('added_message_group',$this->lang->line('add_group'));

					redirect('clinic/groups');
					
				}
			}

		}
		else
		{
			$this->load->view('inc/header' , $data);
			$this->load->view('inc/master_menu/clinic_menu');
			$this->load->view('clinic/patientgroups/recycle');
		}
		
		
	}

	public function add()
	{
		$data = $this->glbl_login();
		$data['title'] = $this->lang->line('patient_groups');
		$data['user_id'] = $this->tank_auth->ci->session->userdata['user_id'];
		$data['patient_Details'] = $this->manage_groups->patient_Details();

		$this->load->view('clinic/patientgroups/ajax/add', $data);

	}

	public function addgroupfromcalendar()
	{
		$data = $this->glbl_login();
		$user_id = $this->tank_auth->ci->session->userdata['user_id'];
		if($inputValues = $this->input->post())
		{
			
				
				$data['saveGroupData'] = $this->manage_groups->saveGroupDataFromCalendar($inputValues, $user_id);
				
				if($data['saveGroupData'] == "true")
				{
					
					$this->session->set_flashdata('added_message_group',$this->lang->line('add_group'));

					redirect('clinic/dashboard');
					
				}
			

		}

	}

	public function search()
	{
		$data = $this->glbl_login();
		$inputValues = $this->input->post();
		
		if(isset($inputValues))
		{
			$data['patient_Details'] = $this->manage_groups->patient_Details();
			$this->load->view('clinic/patientgroups/ajax/patient_result', $data);
		}


	}

	public function showSingleGroup()
	{
		$data = $this->glbl_login();

		$gId = $this->input->post('id');
		
		$data['GroupDetails'] = $this->manage_groups->groupdetails($gId);
		$this->load->view('clinic/patientgroups/ajax/displayGroupInfo', $data);
	}	

	public function deleteGroup()
	{
		$data = $this->glbl_login();
		$id = $this->uri->segment(4);

		$deleteGrp = $this->manage_groups->deleteGroup($id);

		if($deleteGrp == 'success'){
			$this->session->set_flashdata('added_message_group',$this->lang->line('delete_success'));
		}else{
			$this->session->set_flashdata('added_message_group',$this->lang->line('delete_fails'));
		}
				redirect('clinic/groups');
	}	

	public function restore()
	{
		$data = $this->glbl_login();
		$id = $this->uri->segment(4);

		$deleteGrp = $this->manage_groups->restoreGroup($id);

		if($deleteGrp == 'success'){
			$this->session->set_flashdata('added_message_group',$this->lang->line('restore_success'));
		}else{
			$this->session->set_flashdata('added_message_group',$this->lang->line('restore_fails'));
		}
				redirect('clinic/groups');
	}


	public function patientConsultation()
	{
		$data = $this->glbl_login();

		$patientID = $this->input->post('patientid');

		$data['consulthistory'] = $this->manage_groups->get_all_consultation_history_groups($patientID);
		$this->load->view('clinic/patientgroups/ajax/cosnsultation', $data);
	}

	public function removeFrmGrp(){
		$data = $this->glbl_login();

		$inputInfo = $this->input->post();
		$removeGrp = $this->manage_groups->removePatientFrmGrp($inputInfo);

		echo $removeGrp;
	}

	
	
}