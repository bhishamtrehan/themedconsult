<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clinic extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('clinic/manage_clinics');
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

	public function dashboard() {
	$data = $this->glbl();

          error_reporting(E_ALL); ini_set('display_errors', 1);  
            //empty filter session current date firstly
            $this->session->set_userdata('filter_currentdate', '');
	if($this->input->post()) {

		$inputValues = $this->input->post();
		
		if(isset($inputValues['clinic_loc_filter']))
		{
			$clinicLocId = $inputValues['clinic_loc_filter'];
			$this->session->set_userdata('clinic_location', $clinicLocId);
		}
		if(isset($inputValues['location_pracs_select_all'])) {
			$this->session->set_userdata('location_pracs_all', '1');
		}
		else {
			if(isset($inputValues['location_pracs']))
				$this->session->set_userdata('location_pracs_all', '');
		}
                    
                    if(isset($inputValues['currentdate']) && $inputValues['currentdate'] != '')
                    {
                        $this->session->set_userdata('filter_currentdate', $inputValues['currentdate']);
                    }
          
		if(isset($inputValues['location_pracs']))
			$this->session->set_userdata('location_pracs', $inputValues['location_pracs']);
	}
		$user_id				 = $this->tank_auth->ci->session->userdata['user_id'];
	
	if($this->session->userdata['user_role'] == '2'){
		$clinicData              = $this->manage_locations->getClinicId($user_id);
		$myLocation      = $this->manage_locations->getLocationID($clinicData->id);
		$loc = explode(',',$myLocation->clinic_loc);
		$myClinicName      = $this->manage_locations->getClinicLocationName($loc);
		$data['myLocation'] = $loc;
		$data['myClinicName'] = $myClinicName;
	}
	

	if(!isset($this->session->userdata['clinic_location']))
		$this->session->set_userdata('clinic_location', $this->encryption->encode($data['myLocation'][0]));
	
	if($this->acl->hasPermission('clinic_access') == '2'){
		$this->session->set_userdata('clinicLocations', $loc);
	}else{
		$this->session->set_userdata('clinicLocations', $loc);
	}
		
	$data['locationPracs'] 	= $this->manage_locations->locationPractitioner($this->encryption->decode($this->session->userdata['clinic_location']));
	

	if(!isset($this->session->userdata['location_pracs_all']))
		$this->session->set_userdata('location_pracs_all', '1');
	
	if(!isset($this->session->userdata['clinic_detail']))
		$this->session->set_userdata('clinic_detail', $data['myLocation']);
	
	if(isset($this->session->userdata['location_pracs'])) 
		$data['selectedPracs']	= $this->session->userdata['location_pracs'];
	else
		$data['selectedPracs']	= array();
	$this->session->set_userdata('view_calendar', 'appointment_view');
	$data['title'] = $this->lang->line('clinic_dashboard_ttle');
	$this->load->view('inc/header', $data);
	$this->load->view('inc/master_menu/clinic_menu');
	$this->load->view('clinic/index', $data);
}
	
	/**
	* Clinics Management controller.
	*/

	public function rosterView()
	{
		$data = $this->glbl();
		if($this->input->post()) {

		$inputValues = $this->input->post();
		
		if(isset($inputValues['clinic_loc_filter']))
		{
			$clinicLocId = $inputValues['clinic_loc_filter'];
			$this->session->set_userdata('clinic_location', $clinicLocId);
		}
		if(isset($inputValues['location_pracs_select_all'])) {
			$this->session->set_userdata('location_pracs_all', '1');
		}
		else {
			if(isset($inputValues['location_pracs']))
				$this->session->set_userdata('location_pracs_all', '');
		}
                    
                    if(isset($inputValues['currentdate']) && $inputValues['currentdate'] != '')
                    {
                        $this->session->set_userdata('filter_currentdate', $inputValues['currentdate']);
                    }
          
		if(isset($inputValues['location_pracs']))
			$this->session->set_userdata('location_pracs', $inputValues['location_pracs']);
		}
			$user_id				 = $this->tank_auth->ci->session->userdata['user_id'];
		
		if($this->session->userdata['user_role'] == '2'){
			$clinicData              = $this->manage_locations->getClinicId($user_id);
			$myLocation      = $this->manage_locations->getLocationID($clinicData->id);
			$loc = explode(',',$myLocation->clinic_loc);
			$myClinicName      = $this->manage_locations->getClinicLocationName($loc);
			$data['myLocation'] = $loc;
			$data['myClinicName'] = $myClinicName;
		}
		

		if(!isset($this->session->userdata['clinic_location']))
			$this->session->set_userdata('clinic_location', $this->encryption->encode($data['myLocation'][0]));
		
		if($this->acl->hasPermission('clinic_access') == '2'){
			$this->session->set_userdata('clinicLocations', $loc);
		}else{
			$this->session->set_userdata('clinicLocations', $loc);
		}
			
		$data['locationPracs'] 	= $this->manage_locations->locationPractitioner($this->encryption->decode($this->session->userdata['clinic_location']));
		$data['clinicRooms'] 	= $this->manage_locations->clinicRooms($this->encryption->decode($this->session->userdata['clinic_location']));
		
		if(!isset($this->session->userdata['location_pracs_all']))
			$this->session->set_userdata('location_pracs_all', '1');
		
		if(!isset($this->session->userdata['clinic_detail']))
			$this->session->set_userdata('clinic_detail', $data['myLocation']);
		
		if(isset($this->session->userdata['location_pracs'])) 
			$data['selectedPracs']	= $this->session->userdata['location_pracs'];
		else
			$data['selectedPracs']	= array();
		$this->session->set_userdata('view_calendar', 'roster_view');
		$data['title'] = $this->lang->line('clinic_roster_ttle');
		$this->load->view('inc/header', $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$this->load->view('clinic/roster/index', $data);
	}


	public function index(){
		
	
		$data = $this->glbl();
		
		//echo $returnVal = $this->encryption->encode('26');exit;
		$data['clinic_created']  = $this->manage_clinics->getClinicListbyUser('1');
		$data['datatables']  = $this->manage_clinics->getClinicList('1');
		$data['messages'] = '';
		$data['clinic_disabled'] = '0';
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$data['title'] = $this->lang->line('clinic_title');
		
		$data['breadcrumb_label'] = $this->lang->line('clinic_bread');
		$data['breadcrumb_url'] = '';
		
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$this->load->view('clinic/clinics/view', $data);
		
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
		$data['datatables']  = $this->manage_clinics->getClinicList('0');
		$data['messages'] = '';
		$data['clinic_disabled'] = '1';
		$this->load->view('inc/header', $data);
		$this->load->view('clinic/clinics/view', $data);
	}
	public function add()
	{
		$data = $this->glbl();
		
	
		$data['errors'] = array();
		$data['messages'] = '';
        $compId   = $this->manage_clinics->getCompanyId(); 
             
		$data['companyId'] = $compId;
                if($inputValues = $this->input->post()){

						//for inserting clinic into database and authenticating username and email address
						if($inputValues['clinic_action'] == 'insert') {
							$email_activation = $this->config->item('email_activation', 'tank_auth');
							//if ($this->form_validation->run()) {								// validation ok


								$dataSuccess = $this->manage_clinics->create_clinic($inputValues);
								if(!array_key_exists('error', $dataSuccess)) {
									$subject = $this->lang->line('clinic_email_subject');
									$base_url=base_url();
									//$content = sprintf($this->lang->line('clinic_email_content'), $inputValues["clinic_admin_name"],  $dataSuccess["clinic_name"], $base_url, $dataSuccess["username"], $dataSuccess["clinic_email"], $dataSuccess["password"],$dataSuccess["clinic_name"]);
									$content = '';

									$recipient = $this->mc_constants->send_custom_email($subject, $dataSuccess['clinic_email'], $content);

									if($recipient){

										$data['site_name'] = $this->config->item('website_name', 'tank_auth');
										$this->session->set_flashdata('display_message',sprintf($this->lang->line('clinic_created_successfully'),$inputValues["clinic_name"]));
										redirect('clinic');
									}else{

										$data['site_name'] = $this->config->item('website_name', 'tank_auth');
										$this->session->set_flashdata('display_message',sprintf($this->lang->line('clinic_created_successfully_but_email_not_sent'),$inputValues["clinic_name"]));
										redirect('clinic');
									}													
								}else{	
									$this->session->set_flashdata('display_message',$dataSuccess['error']);
								}

							//}
						}
					}
		
	
		
		$data['countries']    = $this->manage_clinics->getCountries();
		$data['title'] = $this->lang->line('add_clinic_title');
		
		$data['breadcrumb_label'] = $this->lang->line('clinic_title');
		$data['breadcrumb_url'] = base_url().'clinic';
		
		$data['breadcrumb_label1'] = $this->lang->line('add_clinic_bread');
		$data['breadcrumb_url1'] = '';
		
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$this->load->view('inc/header', $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$this->load->view('clinic/clinics/add', $data);
		//$this->load->view('inc/footer');
	}
	public function edit()
	{
		$data = $this->glbl();
		$use_username = $this->config->item('use_username', 'tank_auth');
		$data['errors'] = array();
		$clinicEncryptedID = $this->uri->segment(3);
		$data['clinicDetails'] = $this->manage_clinics->getViewClinic($this->encryption->decode($clinicEncryptedID));
		// echo "<pre>";
		// print_r($data['clinicDetails']);
		// die;
		if($inputValues = $this->input->post()){ 
			if(isset($inputValues['clinic_action']) && $inputValues['clinic_action'] == 'update') {
				$inputValues['clinic_id']          = $this->encryption->decode($inputValues['clinic_id']);
				
				$dataSuccess                       = $this->manage_clinics->update_clinic($inputValues);
				if($dataSuccess==true){
					$subject                           = $this->lang->line('clinic_update_email_subject');
					$base_url                          = base_url();
					if(isset($inputValues['password2']) && $inputValues['password2']!=""){
							$content                     = sprintf($this->lang->line('clinic_update_email_content_password'), $inputValues["clinic_admin_name"],  $inputValues["clinic_name"], $base_url, $inputValues["username"], $inputValues["email"],$inputValues['password2'],$inputValues["clinic_name"]);
					}else{
								$content                     = sprintf($this->lang->line('clinic_update_email_content'), $inputValues["clinic_admin_name"],  $inputValues["clinic_name"], $base_url, $inputValues["username"], $inputValues["email"],$inputValues["clinic_name"]);
					
					}
					
					$recipient                         = $this->mc_constants->send_custom_email($subject, $inputValues['email'], $content);
					if($recipient){
						$data['site_name'] = $this->config->item('website_name', 'tank_auth');
						$this->session->set_flashdata('display_message', sprintf($this->lang->line('clinic_updated_successfully'),$inputValues["clinic_name"]));
						redirect('/clinic');
					}else{
						$data['site_name'] = $this->config->item('website_name', 'tank_auth');
						$this->session->set_flashdata('display_message', sprintf($this->lang->line('clinic_updated_successfully_without_email'), $inputValues["clinic_name"]));
						redirect('/clinic');
					}
				}	

			}
        }
		
		//$data['suburb']       = $this->manage_clinics->getSuburb();
		$data['use_username'] = $use_username;
		$data['countries']    = $this->manage_clinics->getCountries();
		if($data['clinicDetails']['city_id']!= '') {
			
			$data['cityData'] = $this->manage_clinics->getCityInfo($data['clinicDetails']['city_id']);
			
			$data['states']   = $this->manage_clinics->getCountryStatesList($data['cityData']['country_id'],'edit_clinic');
			$data['cities']   = $this->manage_clinics->getStatesCitiesList($data['cityData']['state_id'],'edit_clinic');
		}
		else {
			$data['states'] = $this->manage_clinics->getAusStatesList($data['clinicDetails']['suburb'],'edit_clinic');
			$suburbDetail   = $this->manage_clinics->getAusSuburbInfo($data['clinicDetails']['suburb_id']);
			$data['cityData']['country_id'] = 'AU';
			$data['cityData']['city_id'] 	= '';
			$data['cities'] = array();
			$data['cityData']['state_id'] 	= $suburbDetail[0]['state_id'];
		}
		
		$data['title'] = $this->lang->line('edit_clinic_title');
		
		$data['breadcrumb_label'] = $this->lang->line('clinic_title');
		$data['breadcrumb_url'] = base_url().'clinic';
		
		$data['breadcrumb_label1'] = $this->lang->line('edit_clinic_bread');;
		$data['breadcrumb_url1'] = '';
		
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/clinic_menu');
		$this->load->view('clinic/clinics/edit', $data);
	}
	public function disableclinic(){
		$data = $this->glbl();
		$clinicID = $this->uri->segment(4);
		if($clinicID != ''){
		    $changeStatus = $this->manage_clinics->disable_clinic_details($clinicID, $this->tank_auth->ci->session->userdata['user_id']);
			if($changeStatus == 'success')
				$this->session->set_flashdata('display_message', 'Clinic disabled successfully!');
			else
				$this->session->set_flashdata('display_message', 'Something went wrong as clinic was not updated.');
			redirect('/clinic');
		}
	}
	public function enableclinic(){
		$data = $this->glbl();
		$clinicID = $this->uri->segment(4);
		if($clinicID != ''){
		    $changeStatus = $this->manage_clinics->enable_clinic_details($clinicID, $this->tank_auth->ci->session->userdata['user_id']);
			if($changeStatus == 'success')
				$this->session->set_flashdata('display_message', 'Clinic enabled successfully!');
			else
				$this->session->set_flashdata('display_message', 'Something went wrong as clinic was not updated.');
			redirect('/clinic');
		}
	}
	public function getsuburbs(){
		$data = $this->glbl();
		if(isset($_REQUEST['term']) && $_REQUEST['term']!=''){
		    $term                  = trim(strip_tags($_REQUEST['term']));
			$data['ajax_req']      = TRUE;
			$data['suburbs']       = $this->manage_clinics->getSuburbAuto($term);
			$this->load->view('clinic/clinics/ajax/ajax_suburbs_autocomplete', $data);
		}
	}
	public function getstates(){
	    $data = $this->glbl();
            $inputValues  = $this->input->post();
	    if(isset($inputValues['suburbs_name'])){
                $data['ajax_req']   = TRUE;
                $state_id           = (isset($inputValues['stateid']))?$inputValues['stateid']:0;
                $data['state_id']   = $state_id;
                $data['state_list'] = $this->manage_clinics->getAusStatesList($inputValues['suburbs_name']);
                $this->load->view('clinic/clinics/ajax/ajax_states', $data);
	    }
	}
	public function getCountryStates(){
		$data = $this->glbl();
		$inputValues = $this->input->post();
		if($inputValues['countryID'] != ''){
		    $data['ajax_req']   = TRUE;
		    $data['state_list'] = $this->manage_clinics->getCountryStatesList($inputValues['countryID']);
		    $this->load->view('clinic/clinics/ajax/ajax_states', $data);
		}
	}
	public function getStatesCities(){
		$data = $this->glbl();
		$inputValues = $this->input->post();
		if($inputValues['stateID'] != ''){
		    $data['ajax_req']   = TRUE;
		    $data['city_list'] = $this->manage_clinics->getStatesCitiesList($inputValues['stateID']);
		    $this->load->view('clinic/clinics/ajax/ajax_cities', $data);
		}
	}
	public function getpostcodes(){
		$data = $this->glbl();
	    if(isset($_POST['state_id']) && isset($_POST['suburbs_name'])){
		    $data['ajax_req']   = TRUE;
		    $data['postcode_list'] = $this->manage_clinics->getPostcodeList($_POST['state_id'],$_POST['suburbs_name']);
			if(sizeof($data['postcode_list'])>0){
				echo $data['postcode_list']['0']['postal_code'];
			}
		}
	}
	
	public function deleteclinic(){
	    $data = $this->glbl();	
		$data['return_result'] = 0;
		if($this->input->post('clinic_id')){
		    $data['ajax_req']      = TRUE;
		    $data['return_result'] = $this->manage_clinics->getDeleteClinic($this->input->post('clinic_id'));
                }
		$this->load->view('clinic/clinics/ajax/ajax_delete_clinics', $data);		
	}
	public function viewclinic(){
	    $data = $this->glbl();	
		$data['return_result'] = 0;
		if($this->input->post('clinic_id')){
		    $data['ajax_req']      = TRUE;
		    $data['return_result'] = $this->manage_clinics->getViewClinic($this->input->post('clinic_id'));
                }
		$this->load->view('clinic/clinics/ajax/ajax_view_clinics', $data);		
	}


	
}
