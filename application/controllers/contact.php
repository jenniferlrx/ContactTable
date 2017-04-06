
<?php 
header('Access-Control-Allow-Origin: *');

class Contact extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('contact_model');
	}


	public function index(){
		$data['contacts'] = $this->contact_model->getContacts();
		$this->load->view('header');
		$this->load->view('contact_view',$data);
		$this->load->view('footer');
	}


	public function addContact(){
		//save to db->companies
		$data_company = $this->input->post('inputCompany');
		$company_id = $this->contact_model->addCompany($data_company);
		//save to db->countries
		$data_country = $this->input->post('inputCountry');
		$country_id = $this->contact_model->addCountry($data_country);
		//save to db->contacts
		$data = array(
			'contact_name'=>$this->input->post('inputName'),
			'company_id'=>$company_id,
			'contact_phone'=>$this->input->post('inputPhone'),
			'contact_email'=>$this->input->post('inputEmail'),
			'country_id'=>$country_id,
			);
		$this->contact_model->addContact($data);
		echo json_encode(array('status'=>TRUE));
	}


	public function editContact($id){
		//add Log
		$ip = $this->input->ip_address();
		$action= 'edited';
		$this->contact_model->addLog($ip, $id,$action);
		// edit contact
		$data = $this->contact_model->editContact($id, $ip);
		echo json_encode($data);

	}


	public function updateContact(){
		//add Log
		$ip = $this->input->ip_address();
		$id = $this->input->post("inputContactId");
		$action= 'updated';
		$this->contact_model->addLog($ip, $id,$action);
		// //update contact
		//update db->companies
		$data_company = $this->input->post('inputCompany');
		$company_id = $this->contact_model->addCompany($data_company);
		//update db->countries
		$data_country = $this->input->post('inputCountry');
		$country_id = $this->contact_model->addCountry($data_country);
		//update db->contacts		
		$data = array(
			'contact_name'=>$this->input->post('inputName'),
			'company_id'=>$company_id,
			'contact_phone'=>$this->input->post('inputPhone'),
			'contact_email'=>$this->input->post('inputEmail'),
			'country_id'=>$country_id,
			);
		$this->contact_model->updateContact($id, array('contact_id'=>$id), $data,$ip);
		echo json_encode(array('status'=>TRUE));
	}


	public function deleteContact($id){
		//add Log
		$ip = $this->input->ip_address();
		$action= 'deleted';
		$this->contact_model->addLog($ip, $id,$action);
		//delete contact
		$this->contact_model->deleteContact($id,$ip);
		echo json_encode(array('status'=>TRUE));
	}
}

	
 ?>