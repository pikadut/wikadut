<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Ecommerce_Controller {

	var $data = array();

	public function __construct(){

        // Call the Model constructor
		parent::__construct();

		$this->load->model(array("globalparam_m","user_m"));

		$global = $this->globalparam_m->getData();

		foreach($global as $key => $val){
			$this->data[$key] = $val;
		}

		$this->data['date_format'] = "h:i A | d M Y";

		$this->data['data'] = array();

		$this->data['post'] = $this->input->post();

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = true;

		$this->load->library('upload', $config);

		$userdata = $this->user_m->getLogin();

		$this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

		if(empty($userdata)){
			redirect(site_url('log/in'));
		}

	}

	public function index(){
		
		$login = $this->data['userdata'];
		if($login['role_user'] != "admin"){
			show_404();
		}

		$this->data['body'] = "setting_view_v";
		$this->data['res'] = $this->globalparam_m->getAllData()->result_array();
		$this->data['position_link'] = "Setting";
		$this->template("setting_v","Setting",$this->data);

	}


	public function submit(){

		$this->data['position_link'] = "Submit Setting";

		$post = $this->input->post();

		$upl = $this->globalparam_m->getDataByType("image")->result_array();

		foreach ($upl as $key => $value) {
			
			if(!empty($_FILES[$value['name_gp']]['tmp_name'])){

				if ($this->upload->do_upload($value['name_gp'])){
					$upl = $this->upload->data();
					$input = array(
						'value_gp'	=> $upl['file_name']
						);

					$label = $this->db->where("name_gp",$value["name_gp"])->get("global_param_ec")->row()->alias_gp;

					$update = $this->db->where("name_gp",$value["name_gp"])->update("global_param_ec",$input);

					$affected = $this->db->affected_rows();

					if($affected > 0){
						//$this->globalparam_m->log("User mengganti ".$label);
					}

				}  else {
					$error = $this->upload->display_errors();
					$this->setMessage($error);
				}
			}

		}


		foreach ($post as $key => $value) {
			
			$input = array(
				'value_gp' => $value
				);

			$label = $this->db->where("name_gp",$key)->get("global_param_ec")->row()->alias_gp;

			$update = $this->db->where("name_gp",$key)->update("global_param_ec",$input);

			$affected = $this->db->affected_rows();

			if($affected > 0){

				//$this->globalparam_m->log("User mengganti ".$label);

			}

		}

			//echo $this->db->last_query();

		redirect(site_url("setting"));

	}

	public function deleteimg($id = ""){

		if(!empty($id)){
			$delete = $this->globalparam_m->deleteImg($id);
			$label = $this->db->where("id_gp",$id)->get("global_param_ec")->row()->alias_gp;
			if($delete){
				//$this->globalparam_m->log("User menghapus gambar ".$label);
			}
		}

		redirect(site_url("setting"));

	}


}
