<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class docs extends Ecommerce_Controller {

	var $data;

	public function __construct(){

        // Call the Model constructor
		parent::__construct();

		$this->load->model(array("user_m","category_m"));

		$this->data['date_format'] = "h:i A | d M Y";

		$this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
		
		$this->data['data'] = array();

		$this->data['post'] = $this->input->post();
		
		$userdata = $this->user_m->getLogin();

        $this->data['dir'] = './uploads/blog_ecommerce';

		$this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
		
		if(empty($userdata)){
			redirect(site_url('log/in'));
		}
	}

	public function index(){

    $data['title'] = "Documentation";

    $this->template("docs_v","Documentation",$data);

  }


}
