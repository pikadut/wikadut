<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends Telescoope_Controller {

	var $data;

	public function __construct(){

		parent::__construct();

		$this->load->model(array("Inventory_m","Administration_m","Comment_m","Workflow_m"));

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'inventory';

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
      "selection_inventory",
      );

    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    if(empty($userdata)){
     redirect(site_url('log/in'));
   }
   
 }

 public function index(){
  include("inventory/pekerjaan_inventory.php");
}

public function monitor($param1 = "" ,$param2 = ""){

  $title = "Monitor Inventory";
  $dataurl = "inventory";

  switch ($param1) {

    case 'monitor_distribusi':
    $title = "Monitor Distribusi";
    $dataurl = "distribution";
    break;

    case 'monitor_permintaan':
    $title = "Monitor Permintaan";
    $dataurl = "request";
    break;

    case 'monitor_opname':
    $title = "Monitor Opname";
    $dataurl = "opname";
    break;

    case 'monitor_penyesuaian':
    $title = "Monitor Penyesuaian";
    $dataurl = "adjustment";
    break;

    default:
    $title = "Monitor Pencatatan";
    $dataurl = "pencatatan";
    break;

  }

  include("inventory/monitor_inventory.php");

}

public function daftar_pekerjaan(){
  include("inventory/pekerjaan_inventory.php");
}

public function data_monitor($action = ""){
  include("inventory/data_monitor.php");
}

public function get_header_acquisition(){
  include("inventory/get_header_acquisition.php");
}

public function get_header_request(){
  include("inventory/get_header_request.php");
}

public function get_opname_pelaksana(){
  include("inventory/get_opname_pelaksana.php");
}

public function get_header_opname(){
  include("inventory/get_header_opname.php");
}

public function data_pekerjaan($action = ""){
  include("inventory/data_pekerjaan.php");
}

public function tambah_pencatatan(){
  $action = "acquisition_id";
  $id = "";
  include("inventory/form_inventory.php");
}

public function tambah_distribusi(){
  $action = "distribution_id";
  $id = "";
  include("inventory/form_inventory.php");
}

public function proses($id = ""){
  $action = "inventory_id";
  include("inventory/form_inventory.php");
}

public function lihat($id = ""){
  $action = "inventory_id";
  $readonly = true;
  include("inventory/form_inventory.php");
}

public function tambah_permintaan(){
  $action = "request_id";
  $id = "";
  include("inventory/form_inventory.php");
}

public function tambah_penyesuaian(){
  $action = "adjustment_id";
  $id = "";
  include("inventory/form_inventory.php");
}

public function tambah_stock_opname(){
  $action = "opname_id";
  $id = "";
  include("inventory/form_inventory.php");
}

public function semua(){
  include("inventory/daftar_inventory.php");
}

public function data_inventory($label = ""){
  include("inventory/data_inventory.php");
}

public function ubah_status(){
  include("inventory/ubah_status.php");
}

public function ubah_batas(){
  include("inventory/ubah_batas.php");
}

public function get_header_adjustment(){
  include("inventory/get_header_adjustment.php");
}

public function get_gudang_item_penyimpanan(){
  include("inventory/get_gudang_item_penyimpanan.php");
}

public function buat_sppbj(){
  $this->session->set_userdata("inventory",$id);
  redirect("procurement/proses_pengadaan/pembuatan_permintaan_pengadaan");
}

public function detail($id){
  $action = "view";
  include("inventory/detail.php");
}
public function penyesuaian(){
  include("inventory/penyesuaian.php");
}

public function picker_inv(){
  include("inventory/picker_inventory.php");
}

public function submit_inv(){
  include("inventory/submit_inventory.php");
}

public function picker_item_inv(){
  include("inventory/picker_item_inv.php");
}

public function picker_item_acquisition(){
  include("inventory/picker_item_acquisition.php");
}

public function data_item_inventory(){
  include("inventory/data_item_inventory.php");
}

public function get_header_distribution(){
  include("inventory/get_header_distribution.php");
}

public function reset($id = ""){
  if($id == "rahasia"){
    $table = array(
      "inv_acquisition_dist",
      "inv_acquisition_header",
      "inv_acquisition_item",
      "inv_adjustment_header",
      "inv_adjustment_item",
      "inv_comment",
      "inv_distribution_header",
      "inv_distribution_item",
      "inv_inventory_header",
      "inv_request_header",
      "inv_request_item",
      "inv_stockopname_comment",
      "inv_stockopname_header",
      "inv_stockopname_panitia"
      );
    foreach ($table as $key => $value) {
      $this->db->truncate($value);
      echo $this->db->last_query()."<br/>";
    }
  }
}

}