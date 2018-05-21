<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Addendum extends Telescoope_Controller {

	var $data;

	public function __construct(){

        // Call the Model constructor
		parent::__construct();

		$this->load->model(array("Procedure3_m","Contract_m","Addendum_m","Procrfq_m","Administration_m","Comment_m","Administration_m","Workflow_m","Addendum_m"));

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'addendum';

    $this->data['controller_name'] = $this->uri->segment(1);

    $this->session->set_userdata("module",$this->data['dir']);

    $dir = './uploads/'.$this->data['dir'];

    if (!file_exists($dir)){
      mkdir($dir, 0777, true);
    }

    $config['allowed_types'] = '*';
    $config['overwrite'] = false;
    $config['max_size'] = 3064;
    $config['upload_path'] = $dir;
    $this->load->library('upload', $config);

    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
    
    $selection = array(
      "selection_milestone"
      );
    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    if(empty($userdata)){
     redirect(site_url('log/in'));
   }
   
 }

 public function daftar_pekerjaan($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'proses_addendum':
    $this->proses_addendum();
    break;

    case 'proses_addendum':
    $this->proses_addendum();
    break;

    default:
    include("addendum/daftar_pekerjaan/daftar_pekerjaan.php");
    break;

  }
  
}

public function monitor($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'monitor_kontrak':

    switch ($param2) {
      case 'lihat':
      $this->lihat_kontrak();
      break;
      
      default:
      $this->monitor_kontrak();
      break;
    }

    break;

    case 'monitor_tagihan':
    $this->monitor_tagihan();
    break;

    default:
    
    break;

  }
  
}


public function proses_addendum(){
  include("addendum/proses_addendum/proses_addendum.php");
}

public function submit_proses_addendum(){
  include("addendum/proses_addendum/submit_proses_addendum.php");
}

public function data_pekerjaan_addendum(){
  include("addendum/daftar_pekerjaan/data_pekerjaan_addendum.php");
}

public function data_pekerjaan_kontrak(){
  include("addendum/daftar_pekerjaan/data_pekerjaan_kontrak.php");
}

public function update_milestone(){
  include("addendum/proses_addendum/update_milestone.php");
}

public function data_progress_milestone(){
  include("addendum/proses_addendum/data_progress_milestone.php");
}

public function data_comment_milestone(){
  include("addendum/proses_addendum/data_comment_milestone.php");
}

public function load_progress_milestone(){
  include("addendum/proses_addendum/load_progress_milestone.php");
}

public function save_milestone_progress(){
  include("addendum/proses_addendum/save_milestone_progress.php");
}

public function save_milestone_comment(){
  include("addendum/proses_addendum/save_milestone_comment.php");
}

public function tagihan_milestone(){
  include("addendum/proses_addendum/tagihan_milestone.php");
}

public function data_milestone(){
  include("addendum/proses_addendum/data_milestone.php");
}

public function save_invoice(){
  include("addendum/proses_addendum/save_invoice.php");
}

public function data_tagihan(){
  include("addendum/proses_addendum/data_tagihan.php");
}

public function lihat_tagihan(){
  include("addendum/proses_addendum/lihat_tagihan.php");
}

public function lihat_kontrak(){
  include("addendum/monitor/lihat_kontrak.php");
}

public function monitor_tagihan(){
  include("addendum/monitor/monitor_tagihan.php");
}

public function monitor_kontrak(){
  include("addendum/monitor/monitor_kontrak.php");
}
public function data_monitor_kontrak(){
  include("addendum/monitor/data_monitor_kontrak.php");
}


}
