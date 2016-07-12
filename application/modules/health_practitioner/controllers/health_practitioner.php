<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Health_practitioner extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('health_practitioner/manage_hp');
		$this->load->model('auth/tank_auth/users');
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
		$this->lang->load('health_practitioner/health_practitioner');
		$this->load->library('mc_constants');
		

		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$config = array('userID'=>$userId);		
		$this->load->library('acl',$config);
		
		if($this->acl->hasPermission('practitioner_access') != true){
			redirect('misc/error');
        }
	}
	
	function glbl_def() // declare global functions and variables
	{
		/*------------- load useful libraries and helpers  --------------------*/
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->load->library('encryption');
		$this->lang->load('tank_auth');
		$this->lang->load('universal');
		$this->lang->load('health_practitioner/health_practitioner');
		$this->load->library('mc_constants');
		

		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$config = array('userID'=>$userId);		
		$this->load->library('acl',$config);
		
		
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
			$data['roleId'] = '3';
			$data['account'] = 'practitioner';
			$this->load->view('inc/header_login', $data);
			$this->load->view('auth/login_form', $data);
			$this->load->view('inc/footer_login', $data);
	}
	
	public function dashboard() {
		$data = $this->glbl_def();
     	//$RoleID = $this->session->set_userdata('role_ID_check', '3');
		$this->load->view('inc/header', $data);
		$this->load->view('health_practitioner/index', $data);
	}
	
	
	/**
	* Clinics Management controller.
	*/
	public function index(){
		redirect('health_practitioner/add');
		
	}
	function edit_check_username()
	{   
		$data = $this->glbl();
		$data['ajax_req']      = TRUE;
		$inputVal = $this->input->get();
		$result = 'false';
		if($inputVal != "")
		{   
			 $user_id = $this->encryption->decode($inputVal['user_id']);  
			$availUsername = $this->mc_constants->is_edit_username_available($inputVal['username'],$user_id);
			if($availUsername == '1')
				$result = 'true';
		}
		echo $result;
	}
	function edit_check_email()
	{   
		$data = $this->glbl();
		$inputVal = $this->input->get();
		$result = 'false';
		$data['ajax_req']      = TRUE;
		if($inputVal != "")
		{
			$user_id = $this->encryption->decode($inputVal['user_id']);  
			$availUsername = $this->mc_constants->is_edit_email_available($inputVal['email'],$user_id);
			if($availUsername == '1')
				$result = 'true';
		}
		echo $result;
	}
	public function disabled()
	{
		$data = $this->glbl();
		$data['datatables']  = $this->manage_hp->getClinicList('0');
		$data['messages'] = '';
		$data['clinic_disabled'] = '1';
		$this->load->view('inc/header', $data);
		$this->load->view('master/clinics/view', $data);
	}
	public function add()
	{
		
		$data = $this->glbl_def();
	
		$data['errors'] = array();
		$data['messages'] = '';
                
      if($inputValues = $this->input->post())
		{
									
					$files = $_FILES;
					//echo "<pre>";
					//print_r($_FILES); die;
					$this->load->library('upload');
					// next we pass the upload path for the images
					$config['upload_path'] = realpath(APPPATH . '../assets/uploads/documents/');
					// also, we make sure we allow only certain type of images
					$config['allowed_types'] = 'gif|jpg|png';
					    $config['max_size'] = '0';
					$this->upload->initialize($config);
						foreach ($_FILES as $key => $value) {
						
				        // we retrieve the number of files that were uploaded
				        if ($this->upload->do_upload($key))
				        {
				          $data['uploads'] = $this->upload->data();
				        }
				        else
				        {
				          $data['upload_errors'] = $this->upload->display_errors();
				        }		
				        //print_r($data); echo '<br/>';
					}	




					$data['output'] = $this->manage_hp->create_hp($inputValues);
				
			//for inserting clinic into database and authenticating username and email address
				$email_activation = $this->config->item('email_activation', 'tank_auth');
				//if ($this->form_validation->run()) {								// validation ok
				
					if(!array_key_exists('error', $dataSuccess)) {
						$subject = $this->lang->line('clinic_email_subject');
						$base_url=base_url();
						//$content = sprintf($this->lang->line('clinic_email_content'), $inputValues["clinic_admin_name"],  $dataSuccess["clinic_name"], $base_url, $dataSuccess["username"], $dataSuccess["clinic_email"], $dataSuccess["password"],$dataSuccess["clinic_name"]);
						$content = '';
						
						$recipient = $this->mc_constants->send_custom_email($subject, $dataSuccess['clinic_email'], $content);
						
						if($recipient){
							
							$data['site_name'] = $this->config->item('website_name', 'tank_auth');
							$this->session->set_flashdata('display_message',sprintf($this->lang->line('hp_created_successfully'),$inputValues["clinic_name"]));
							redirect('health_practitioner/login');
						}else{
							
							
							// $data['site_name'] = $this->config->item('website_name', 'tank_auth');
							 $this->session->set_flashdata('display_message',sprintf($this->lang->line('hp_created_successfully_but_email_not_sent'),$inputValues["clinic_name"]));
							 redirect('health_practitioner/login');
						}													
					}else{	
						$this->session->set_flashdata('display_message',$dataSuccess['error']);
					}
					
				
		}
			
	
		$data['countries']    = $this->manage_hp->getCountries();
		$data['specialities'] = $this->manage_hp->getSpecialities();
		$data['languages'] = $this->manage_hp->getlanguages();
		$data['title'] =  $this->lang->line('hp_reg_title');
		
		
		
		$this->load->view('inc/header', $data);
		$this->load->view('health_practitioner/health_practitioner/add', $data);
		//$this->load->view('inc/footer');
	}
	public function edit()
	{
		$data = $this->glbl();
		$use_username = $this->config->item('use_username', 'tank_auth');
		$data['errors'] = array();
		$clinicEncryptedID = $this->uri->segment(4);
		$data['clinicDetails'] = $this->manage_hp->getViewClinic($this->encryption->decode($clinicEncryptedID));
		if($inputValues = $this->input->post()){ 
			if(isset($inputValues['clinic_action']) && $inputValues['clinic_action'] == 'update') {
				$inputValues['clinic_id']          = $this->encryption->decode($inputValues['clinic_id']);
				
				$dataSuccess                       = $this->manage_hp->update_clinic($inputValues);
				if($dataSuccess==true){
					$subject                           = $this->lang->line('clinic_update_email_subject');
					$base_url                          = base_url();
					if(isset($inputValues['password2']) && $inputValues['password2']!=""){
							$content                     = sprintf($this->lang->line('clinic_update_email_content_password'), $inputValues["clinic_admin_name"],  $inputValues["clinic_name"], $base_url, $inputValues["username"], $inputValues["email"],$inputValues['password2'],$inputValues["clinic_name"]);
					}else{
								$content                     = sprintf($this->lang->line('clinic_update_email_content'), $inputValues["clinic_admin_name"],  $inputValues["clinic_name"], $base_url, $inputValues["username"], $inputValues["email"],$inputValues["clinic_name"]);
					
					}
					
					$recipient  = $this->mc_constants->send_custom_email($subject, $inputValues['email'], $content);
					if($recipient){
						$data['site_name'] = $this->config->item('website_name', 'tank_auth');
						$this->session->set_flashdata('display_message', sprintf($this->lang->line('clinic_updated_successfully'),$inputValues["clinic_name"]));
						redirect('/clinics');
					}else{
						$data['site_name'] = $this->config->item('website_name', 'tank_auth');
						$this->session->set_flashdata('display_message', sprintf($this->lang->line('clinic_updated_successfully_without_email'), $inputValues["clinic_name"]));
						redirect('/clinics');
					}
				}	

			}
        }
		
		//$data['suburb']       = $this->manage_hp->getSuburb();
		$data['use_username'] = $use_username;
		$data['countries']    = $this->manage_hp->getCountries();
		if($data['clinicDetails']['city_id']!= '') {
			
			$data['cityData'] = $this->manage_hp->getCityInfo($data['clinicDetails']['city_id']);
			
			$data['states']   = $this->manage_hp->getCountryStatesList($data['cityData']['country_id'],'edit_clinic');
			$data['cities']   = $this->manage_hp->getStatesCitiesList($data['cityData']['state_id'],'edit_clinic');
		}
		else {
			$data['states'] = $this->manage_hp->getAusStatesList($data['clinicDetails']['suburb'],'edit_clinic');
			$suburbDetail   = $this->manage_hp->getAusSuburbInfo($data['clinicDetails']['suburb_id']);
			$data['cityData']['country_id'] = 'AU';
			$data['cityData']['city_id'] 	= '';
			$data['cities'] = array();
			$data['cityData']['state_id'] 	= $suburbDetail[0]['state_id'];
		}
		
		$data['title'] = $this->lang->line('edit_clinic_title');
		
		$data['breadcrumb_label'] = $this->lang->line('clinic_title');
		$data['breadcrumb_url'] = base_url().'master/clinics';
		
		$data['breadcrumb_label1'] = $this->lang->line('edit_clinic_bread');
		$data['breadcrumb_url1'] = '';
		
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/master_menu');
		$this->load->view('master/clinics/edit', $data);
	}
	public function disableclinic(){
		$data = $this->glbl();
		$clinicID = $this->uri->segment(4);
		if($clinicID != ''){
		    $changeStatus = $this->manage_hp->disable_clinic_details($clinicID, $this->tank_auth->ci->session->userdata['user_id']);
			if($changeStatus == 'success')
				$this->session->set_flashdata('display_message', 'Clinic disabled successfully!');
			else
				$this->session->set_flashdata('display_message', 'Something went wrong as clinic was not updated.');
			redirect('/master/clinics');
		}
	}
	public function enableclinic(){
		$data = $this->glbl();
		$clinicID = $this->uri->segment(4);
		if($clinicID != ''){
		    $changeStatus = $this->manage_hp->enable_clinic_details($clinicID, $this->tank_auth->ci->session->userdata['user_id']);
			if($changeStatus == 'success')
				$this->session->set_flashdata('display_message', 'Clinic enabled successfully!');
			else
				$this->session->set_flashdata('display_message', 'Something went wrong as clinic was not updated.');
			redirect('/master/clinics');
		}
	}
	public function getsuburbs(){
		$data = $this->glbl();
		if(isset($_REQUEST['term']) && $_REQUEST['term']!=''){
		    $term                  = trim(strip_tags($_REQUEST['term']));
			$data['ajax_req']      = TRUE;
			$data['suburbs']       = $this->manage_hp->getSuburbAuto($term);
			$this->load->view('master/clinics/ajax/ajax_suburbs_autocomplete', $data);
		}
	}
	public function getstates(){
	    $data = $this->glbl();
            $inputValues  = $this->input->post();
	    if(isset($inputValues['suburbs_name'])){
                $data['ajax_req']   = TRUE;
                $state_id           = (isset($inputValues['stateid']))?$inputValues['stateid']:0;
                $data['state_id']   = $state_id;
                $data['state_list'] = $this->manage_hp->getAusStatesList($inputValues['suburbs_name']);
                $this->load->view('master/clinics/ajax/ajax_states', $data);
	    }
	}
	public function getCountryStates(){
		$data = $this->glbl();
		$inputValues = $this->input->post();
		if($inputValues['countryID'] != ''){
		    $data['ajax_req']   = TRUE;
		    $data['state_list'] = $this->manage_hp->getCountryStatesList($inputValues['countryID']);
		    $this->load->view('master/clinics/ajax/ajax_states', $data);
		}
	}
	public function getStatesCities(){
		$data = $this->glbl();
		$inputValues = $this->input->post();
		if($inputValues['stateID'] != ''){
		    $data['ajax_req']   = TRUE;
		    $data['city_list'] = $this->manage_hp->getStatesCitiesList($inputValues['stateID']);
		    $this->load->view('master/clinics/ajax/ajax_cities', $data);
		}
	}
	public function getpostcodes(){
		$data = $this->glbl();
	    if(isset($_POST['state_id']) && isset($_POST['suburbs_name'])){
		    $data['ajax_req']   = TRUE;
		    $data['postcode_list'] = $this->manage_hp->getPostcodeList($_POST['state_id'],$_POST['suburbs_name']);
			if(sizeof($data['postcode_list'])>0){
				echo $data['postcode_list']['0']['postal_code'];
			}
		}
	}
	/* public function send_custom_email($subject, $recipient, $content) {
		$data = $this->glbl();
		$this->load->library('email');
		$this->email->from('noreply@smartehealthcare.com', 'Smart eHealth');
		$this->email->to($recipient); 
		$this->email->subject($subject);
		$data['mail_content'] = $content;
		$html = $this->load->view('auth/email/shc_email_template', $data, true);
		$this->email->message($html);	
		if($this->email->send()){
			return true;
		}else{
			return false;		
		}	
	} */
	public function deleteclinic(){
	    $data = $this->glbl();	
		$data['return_result'] = 0;
		if($this->input->post('clinic_id')){
		    $data['ajax_req']      = TRUE;
		    $data['return_result'] = $this->manage_hp->getDeleteClinic($this->input->post('clinic_id'));
                }
		$this->load->view('master/clinics/ajax/ajax_delete_clinics', $data);		
	}
	public function viewclinic(){
	    $data = $this->glbl();	
		$data['return_result'] = 0;
		if($this->input->post('clinic_id')){
		    $data['ajax_req']      = TRUE;
		    $data['return_result'] = $this->manage_hp->getViewClinic($this->input->post('clinic_id'));
                }
		$this->load->view('master/clinics/ajax/ajax_view_clinics', $data);		
	}
    
	
	public function get_clinic_data(){
		$data = $this->glbl_def();	
		$search_data['clinic_name'] = $this->input->post('clinic_name');
		$search_data['country'] = $this->input->post('clinic_country');
		$search_data['address'] = $this->input->post('clinic_address');
		
		$query = $this->manage_hp->get_clinic_details($search_data);
		$data['clinics'] = $query;
		$this->load->view('health_practitioner/health_practitioner/ajax/list_clinic', $data);	
		
	}
	
	
}