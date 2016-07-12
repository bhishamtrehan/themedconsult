<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PDF Class
 * @author Visions
 */

class Pdf extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('auth/tank_auth/users');
		$this->load->model('master/manage_pdf');
		$this->load->library('session');
		$this->load->library('tank_auth');
		$this->load->helper('url');
	}


	function glbl() //declare global functions and variables
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
		$this->lang->load('master/pdf/pdf');
		if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$config = array('userID'=>$userId);		
		$this->load->library('acl',$config);
		
		if($this->acl->hasPermission('master_access') != true){
			redirect('auth/login');
        }
	}

	public function index()
	{
		$data = $this->glbl();
		$this->lang->load('master/pdf/pdf');
		$userdata = $this->session->all_userdata();
		$data['username']=$userdata['username'];
		$data['title'] = $this->lang->line('upload_title');
		$data['breadcrumb_label'] = $this->lang->line('upload_bread');
		$data['breadcrumb_url'] = '';
		$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$data['output'] = $this->manage_pdf->getPdf($userId);
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/master_menu');
		$this->load->view('pdf/upload');
	}

	public function upload()
    {
    	$data = $this->glbl();
    	$userId = $this->tank_auth->get_user_id();
    	$userName = $this->tank_auth->get_username();
        // set path to store uploaded files
        $encode_id = $this->encryption->encode($userId);
        $dir =  realpath(APPPATH . '../'.$userName.'_'.$encode_id);
        $path_c = $dir.'assets/uploads/'.$userName.'_'.$encode_id;
        
        if (!file_exists($path_c)) {
		    mkdir($path_c, 0777, true);
		}
        $url = realpath(APPPATH . '../assets/uploads'.'/'.$userName.'_'.$encode_id);
        $config['upload_path'] = $url;
        // set allowed file types
        $config['allowed_types'] = 'pdf';
        // set upload limit, set 0 for no limit
        $config['max_size']    = 0;
        // load upload library with custom config settings
        $this->load->library('upload', $config);
         // if upload failed , display errors
        if (!$this->upload->do_upload('userfile'))
        {
            echo $this->upload->display_errors();
        }
        else
        {
            $userdata = $this->session->all_userdata();
			$data['username']=$userdata['username'];
			$data['title'] = $this->lang->line('list_title');
			$data['breadcrumb_label'] = $this->lang->line('list_bread');
			$data['breadcrumb_url'] = '';
			$pdfData =$this->upload->data();
			$data['output'] = $this->manage_pdf->insertPdf($pdfData, $userId);
			$this->edit($pdfData['file_name'], $userName, $userId);
			redirect('master/pdf/view');

        }
    }

    public function view()
    {
    	$data = $this->glbl();
    	$this->lang->load('master/pdf/pdf');
    	$userId = $this->tank_auth->ci->session->userdata['user_id'];
		$userdata = $this->session->all_userdata();
		$data['title'] = $this->lang->line('list_title');
		$data['breadcrumb_label'] = $this->lang->line('list_bread');
		$data['breadcrumb_url'] = '';
		$data['output'] = $this->manage_pdf->getPdf($userId);
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/master_menu');
		$this->load->view('pdf/view', $data);
		
	}

	public function edit($pdfname, $userName, $userId)
	{
		$data = $this->glbl();
		$data['title'] = 'PDF Edit';
		$data['breadcrumb_label'] = 'PDF Edit';
		$data['breadcrumb_url'] = '';
		$data['title'] = 'PDF Edit';
		$encode_id = $this->encryption->encode($userId);

		$pdf = $pdfname;
		$pdflocation = realpath(APPPATH . '../assets/uploads').'/'.$userName.'_'.$encode_id.'/'.$pdf;

		$output_dir = realpath(APPPATH . '../assets/uploads').'/'.$userName.'_'.$encode_id.'/';
		$RandomNum   = time();
		$ImageName      = str_replace(' ','-',strtolower($pdf));
		$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
		$ImageExt       = str_replace('.','',$ImageExt);
		if($ImageExt != "pdf")
		{
		    echo "Invalid file format. Only <b>\"PDF\"</b> allowed.";
		}
        else
        {
        	$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
            $location   = "/usr/bin/convert";
            $name       = $output_dir. $pdf;
            $num = 			$this->count_pages($name);
            $RandomNum   = time();
            $nameto     = $output_dir.$RandomNum.".jpg";
            $resolution = "-density 130";
            $convert    = $location . " " . $resolution . " " . $name . " ".$nameto;
            exec($convert);
            if($num == 1)
            {
            	$data['image'] = $RandomNum.".jpg";
            	$new_name = $RandomNum.".jpg";
            	$data['output'] = $this->manage_pdf->SavePdfByid($userId, $new_name, $pdfname );
            	$this->load->view('inc/header' , $data);
				$this->load->view('inc/master_menu/master_menu');
				$this->load->view('pdf/editor', $data);
				
            }
            else
            {
            $images = array();
            for($i = 0; $i<$num;$i++)
            {
            	$images[] = realpath(APPPATH . '../assets/uploads').'/'.$userName.'_'.$encode_id.'/'.$RandomNum."-".$i.".jpg";
                //echo "<img src='".base_url('assets/uploads')."/$RandomNum-$i.jpg' title='Page-$i' /><br>"; 
            }
            	
            	$location   = "/usr/bin/convert";
            	$new_images =  implode(" ", $images);
            	$new_name = $output_dir.$RandomNum."output.jpg";
            	$new_name_db = $RandomNum."output.jpg";
            	$count_img = count($images);
            	$string = '';
            	foreach ($images as $img) {
            		$string .= $img.' ';
            	}
            	exec("convert ".$string." -append $new_name");
            	$data['image'] = $RandomNum."output.jpg";
            	$data['output'] = $this->manage_pdf->SavePdfByid($userId, $new_name_db, $pdfname);
    //         	$this->load->view('inc/header' , $data);
				// $this->load->view('inc/master_menu/master_menu');
				// $this->load->view('pdf/editor', $data);
				
            }
            

        }

	}

	public function count_pages($pdfname)
	{
      $pdftext = file_get_contents($pdfname);
      $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
      return $num;
    }

    public function editor()
    {
    	$data = $this->glbl();
		$encId = $this->uri->segment(4);
		$id = $this->encryption->decode($encId);
		$data['results'] = $this->manage_pdf->getPdfToEdit($id);
		$data['title'] = $this->lang->line('edit_title');
		$data['breadcrumb_label'] = $this->lang->line('edit_bread');
		$data['breadcrumb_url'] = '';
		$this->load->view('inc/header' , $data);
		$this->load->view('inc/master_menu/master_menu');
		$this->load->view('pdf/editor', $data);

    }


}
	
	

