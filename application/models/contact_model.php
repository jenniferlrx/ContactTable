<?php 

class Contact_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function getContacts(){
		$query = $this->db->query('SELECT contacts.contact_id, contacts.contact_name, companies.company_name, contacts.contact_phone, contacts.contact_email, countries.country_name, contacts.contact_active FROM ((contacts INNER JOIN companies on contacts.company_id = companies.company_id) INNER JOIN countries on contacts.country_id=countries.country_id)');
		return $query->result();
	}


	public function addContact($data){
		$this->db->insert('contacts', $data);
		return $this->db->insert_id();
	}


	public function editContact($id,$ip){
		$sql = ('SELECT contacts.contact_id, contacts.contact_name, companies.company_name, contacts.contact_phone, contacts.contact_email, countries.country_name, contacts.contact_active FROM ((contacts INNER JOIN companies on contacts.company_id = companies.company_id) INNER JOIN countries on contacts.country_id=countries.country_id) WHERE contacts.contact_id= ?');
		$query = $this->db->query($sql, array($id));
		return $query->row();
	}


	public function updateContact($id, $where, $data,$ip){
		$this->db->update('contacts',$data,$where);
		return $this->db->affected_rows();
	}


	public function deleteContact($id, $ip){
		$this->db->update('contacts',array('contact_active'=>0),array('contact_id' => $id ));
	}


	// add a company record if it is new
	public function addCompany($data){
		$this->db->where('company_name',$data);
		$row = $this->db->get('companies')->row();
		if(isset($row)){
			return $row->company_id;
		}else{
			$insertData = array('company_name'=>$data);
			$this->db->insert('companies', $insertData);
		}
		return $this->db->insert_id();
	}


	// add a country record if it is new
	public function addCountry($data){
		$this->db->where('country_name',$data);
		$row = $this->db->get('countries')->row();
		if(isset($row)){
			return $row->country_id;
		}else{
			$insertData = array('country_name'=>$data);
			$this->db->insert('countries', $insertData);
		}
		return $this->db->insert_id();
	}


	// add log for edit/update/delete actions
	public function addLog($ip, $id, $action){
		$sql2 = ("INSERT INTO logger (ipAddress, contact_id, action) VALUES (?, $id, ?)");
        $query2 = $this->db->query($sql2, array($ip,$action));
	}
}


 ?>