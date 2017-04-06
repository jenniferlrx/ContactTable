
<?php 
header('Access-Control-Allow-Origin: *');

class Logbook extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('logbook_model');
	}


	public function index(){
		$data['logs'] = $this->logbook_model->getLogs();
		$this->load->view('header');
		$this->load->view('logbook_view', $data);
		$this->load->view('footer');
	}
	
	public function getLogs(){
		$data['logs']= $this->logbook_model->getLogs();
		echo json_encode($data);
	}
}

	
 ?>