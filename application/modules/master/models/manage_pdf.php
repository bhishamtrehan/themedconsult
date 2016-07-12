<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings
 *
 * This model handles PDF
 * @author	Visions
 */
class Manage_pdf extends CI_Model
{
	private $table_mc_pdf	   = 'mc_pdf';
	
	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$this->table_mc_pdf = 	$ci->config->item('db_table_prefix', 'tank_auth').$this->table_mc_pdf;
	}

	//Insert Pdf
	public function insertPdf($pdfData, $userId)
	{
		$data = array(
			'pdf_file_path' => $pdfData['full_path'],
			'pdf_name' => $pdfData['file_name'],
			'user_id' => $userId,
		);
		
		try 
		{
			$this->db->trans_begin();
			$output = $this->db->insert($this->table_mc_pdf, $data);
			$this->db->trans_commit();
		} 
		catch (Exception $e) 
		{
			$this->db->trans_rollback();
			$output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		$returnArray = $output;
		return $returnArray; 

	}

	public function getPdf($userId)
	{
		$this->db->select("id, pdf_name, user_id");
		$this->db->where('user_id', $userId);
		$this->db->from($this->table_mc_pdf);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}
	}

	public function getPdfByName($name)
	{
		$this->db->select("pdf_name");
		$this->db->where('pdf_name', $name);
		$this->db->from($this->table_mc_pdf);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}
	}

	public function SavePdfByid($userId, $new_name, $pdfname )
	{
		$data = array(
			'image_file_name' => $new_name,
		);
		try
		{
			$this->db->trans_begin();
			//$this->db->where('user_id', $decoded_id);
			$this->db->where("user_id",$userId);
			$this->db->where("pdf_name",$pdfname);
			$output = $this->db->update($this->table_mc_pdf, $data);
			$this->db->trans_commit(); 
		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			$output = array('return' => log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE))));
		}
		$returnArray = $output;
		return $returnArray;
	}

	public function getPdfToEdit($id)
	{
		$this->db->select("*");
		$this->db->where("id",$id);
		$this->db->from($this->table_mc_pdf);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{ 
			return $results = $query->result_array();
		}
	}

	

}
