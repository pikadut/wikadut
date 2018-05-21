<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract extends Telescoope_Controller {

	var $data;

	public function __construct(){

        // Call the Model constructor
		parent::__construct();

		$this->load->model(array("Procedure2_m","Procedure3_m","Contract_m","Procrfq_m","Administration_m","Comment_m","Administration_m","Workflow_m","Addendum_m"));

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'contract';

    $this->data['controller_name'] = $this->uri->segment(1);

    $dir = './uploads/'.$this->data['dir'];

    $this->session->set_userdata("module",$this->data['dir']);

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

    case 'proses_kontrak':
    $this->proses_kontrak();
    break;

    case 'proses_addendum':
    $this->proses_addendum();
    break;

    default:
    include("contract/daftar_pekerjaan/daftar_pekerjaan.php");
    break;

  }
  
}

public function monitor_bast(){
  include("contract/monitor/monitor_bast.php");
}

public function picker_progress_wo(){
  include("contract/proses_progress/picker_progress_wo.php");
}

public function picker_item_milestone(){
  include("contract/proses_progress/picker_item_milestone.php");
}

public function data_progress_wo(){
  include("contract/proses_progress/data_progress_wo.php");
}

public function lihat_bast(){
  include("contract/work_order/lihat_bast.php");
}

public function monitor_wo(){
  include("contract/monitor/monitor_wo.php");
}

public function lihat_wo($id = ""){
  include("contract/work_order/lihat_wo.php");
}

public function monitor_progress($act = "",$type = ""){
  include("contract/monitor/monitor_progress.php");
}

public function lihat_progress_wo($id = ""){
  include("contract/proses_progress/lihat_progress_wo.php");
}

public function data_monitor_wo(){
  include("contract/monitor/data_monitor_wo.php");
}

public function data_item_milestone(){
  include("contract/proses_kontrak/data_item_milestone.php");
}

public function monitor($param1 = "" ,$param2 = "",$param3 = ""){

  switch ($param1) {

   case 'monitor_wo':

   switch ($param2) {
    case 'lihat':
    $this->lihat_wo($param2);
    break;
    
    default:
    $this->monitor_wo();
    break;
  }

  break;

  case 'monitor_bast':

  switch ($param2) {
    case 'lihat':
    $this->lihat_bast();
    break;
    
    default:
    $this->monitor_bast();
    break;
  }

  break;

  case 'monitor_progress':

  switch ($param2) {
    case 'lihat':
    $this->lihat_progress();
    break;
    
    default:
    $this->monitor_progress($param2,$param3);
    break;
  }

  break;

  case 'monitor_kontrak':

  switch ($param2) {
    case 'lihat':
    $this->lihat_kontrak();
    break;
    
    default:
    $this->monitor_kontrak($param2);
    break;
  }

  break;

  case 'monitor_adendum_kontrak':

  switch ($param2) {
    case 'lihat':
    $this->lihat_addendum();
    break;
    
    default:
    $this->monitor_addendum();
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

public function work_order($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'proses_work_order':
    $this->proses_work_order();
    break;


    default:
    include("contract/work_order/work_order.php");
    break;

  }
  
}


public function proses_kontrak(){
  include("contract/proses_kontrak/proses_kontrak.php");
}

public function proses_addendum(){
  include("addendum/proses_addendum/proses_addendum.php");
}

public function submit_proses_kontrak(){
  include("contract/proses_kontrak/submit_proses_kontrak.php");
}

public function data_pekerjaan_adendum(){
  include("contract/daftar_pekerjaan/data_pekerjaan_adendum.php");
}

public function data_pekerjaan_kontrak(){
  include("contract/daftar_pekerjaan/data_pekerjaan_kontrak.php");
}

public function update_milestone(){
  include("contract/proses_kontrak/update_milestone.php");
}

public function data_progress_milestone(){
  include("contract/proses_kontrak/data_progress_milestone.php");
}

public function data_monitor_progress_milestone(){
  include("contract/proses_progress/data_monitor_progress_milestone.php");
}

public function data_progress($type,$id = ""){
  include("contract/proses_progress/data_progress.php");
}


public function lihat_progress_milestone($id = ""){
  include("contract/proses_progress/lihat_progress_milestone.php");
}


public function data_monitor_progress_wo(){
  include("contract/proses_progress/data_monitor_progress_wo.php");
}

public function data_comment_milestone(){
  include("contract/proses_kontrak/data_comment_milestone.php");
}

public function load_progress_milestone(){
  include("contract/proses_kontrak/load_progress_milestone.php");
}

public function save_milestone_progress(){
  include("contract/proses_kontrak/save_milestone_progress.php");
}

public function save_milestone_comment(){
  include("contract/proses_kontrak/save_milestone_comment.php");
}

public function tagihan_milestone(){
  include("contract/proses_kontrak/tagihan_milestone.php");
}

public function data_milestone(){
  include("contract/proses_kontrak/data_milestone.php");
}

public function save_invoice(){
  include("contract/proses_kontrak/save_invoice.php");
}

public function data_tagihan(){
  include("contract/proses_kontrak/data_tagihan.php");
}

public function lihat_tagihan(){
  include("contract/proses_kontrak/lihat_tagihan.php");
}

public function lihat_kontrak(){
  include("contract/monitor/lihat_kontrak.php");
}

public function lihat_addendum(){
  include("addendum/monitor/lihat_addendum.php");
}

public function monitor_tagihan(){
  include("contract/monitor/monitor_tagihan.php");
}

public function monitor_kontrak($act = ""){
  include("contract/monitor/monitor_kontrak.php");
}

public function data_monitor_kontrak($act = ""){
  include("contract/monitor/data_monitor_kontrak.php");
}

public function monitor_addendum(){
  include("addendum/monitor/monitor_addendum.php");
}

public function data_monitor_addendum(){
  include("addendum/monitor/data_monitor_addendum.php");
}

public function data_pekerjaan_wo(){
  include("contract/daftar_pekerjaan/data_pekerjaan_wo.php");
}

public function create_work_order(){
  include("contract/work_order/work_order.php");
}

public function data_work_order(){
  include("contract/work_order/data_work_order.php");
}

public function proses_work_order($contract_id = ""){
	include("contract/proses_work_order/proses_work_order.php");
}

public function submit_proses_work_order(){
  include("contract/proses_work_order/submit_proses_work_order.php");
}

public function lihat_work_order(){
  include("contract/proses_work_order/lihat_work_order.php");
}

public function proses_wo($id = ""){
  include("contract/proses_work_order/proses_wo.php");
}

public function data_pekerjaan_progress_wo($id = ""){
  include("contract/daftar_pekerjaan/data_pekerjaan_progress_wo.php");
}

public function proses_progress_wo($id = ""){
  include("contract/proses_progress/proses_progress_wo.php");
}


public function proses_progress_milestone($id = ""){
  include("contract/proses_progress/proses_progress_milestone.php");
}

public function submit_proses_progress_milestone(){
  include("contract/proses_progress/submit_proses_progress_milestone.php");
}

public function submit_proses_progress_wo(){
  include("contract/proses_progress/submit_proses_progress_wo.php");
}

public function data_bast_wo(){
  include("contract/proses_progress/data_bast_wo.php");
}

public function data_bast_milestone(){
  include("contract/proses_progress/data_bast_milestone.php");
}

public function data_invoice_wo(){
  include("contract/proses_progress/data_invoice_wo.php");
}

public function data_invoice_milestone(){
  include("contract/proses_progress/data_invoice_milestone.php");
}

public function proses_bast_milestone($id = ""){
  include("contract/proses_progress/proses_bast_milestone.php");
}

public function proses_bast_wo($id = ""){
  include("contract/proses_progress/proses_bast_wo.php");
}

public function submit_proses_bast_wo($id = ""){
  include("contract/proses_progress/submit_proses_bast_wo.php");
}

//hlmifzi

public function proses_invoice_wo($id = ""){
  include("contract/proses_progress/proses_invoice_wo.php");
}

public function proses_invoice_milestone($id = ""){
  include("contract/proses_progress/proses_invoice_milestone.php");
}


public function submit_proses_invoice_wo($id = ""){
  include("contract/proses_progress/submit_proses_invoice_wo.php");
}

public function submit_proses_invoice_milestone($id = ""){
  include("contract/proses_progress/submit_proses_invoice_milestone.php");
}
//hlmifzi

public function submit_proses_bast_milestone($id = ""){
  include("contract/proses_progress/submit_proses_bast_milestone.php");
}

public function data_monitor_bast_milestone(){
  include("contract/monitor/data_monitor_bast_milestone.php");
}

public function data_monitor_bast_wo(){
  include("contract/monitor/data_monitor_bast_wo.php");
}

public function lihat_bast_wo($id = ""){
  include("contract/monitor/lihat_bast_wo.php");
}

public function lihat_bast_milestone($id = ""){
  include("contract/monitor/lihat_bast_milestone.php");
}

}