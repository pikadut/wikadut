<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends Telescoope_Controller {

	var $data;

	public function __construct(){

        // Call the Model constructor
		parent::__construct();

		$this->load->model(array('Administration_m',"Procpr_m","Procrfq_m","Contract_m","Vendor_m"));

		$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

		$userdata = $this->Administration_m->getLogin();

		$this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

		$sess = $this->session->all_userdata();


	}

	public function chat_inbox(){
		$this->db->select('a.status,a.ptm_number,c.ptm_subject_of_work,b.fullname,a.date_added,a.time_added');
	    $this->db->from('t_chat_main a');
	    $this->db->join('adm_employee b', 'a.id_employee_to = b.id');
	    $this->db->join('prc_tender_main c', 'a.ptm_number = c.ptm_number');
	    $this->db->where('a.id_employee_to',$this->session->userdata['user_id']);
		$data['rfq'] =  $this->db->get()->result_array();


		$this->template("chat_inbox_v","Chat Inbox Internal",$data);
	}

	public function chat_outbox(){
		$this->template("chat_outbox_v","Chat Outbox Internal");
	}

	public function chat_compose(){
		$this->template("chat_compose_v","Chat Compose Internal");
	}
}
