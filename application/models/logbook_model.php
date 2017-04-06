<?php 

class Logbook_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function getLogs(){
		$query = $this->db->get('logger');
		return $query->result();
	}

}


 ?>