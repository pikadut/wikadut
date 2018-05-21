<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends Telescoope_Controller {

  var $data;

  public function __construct(){

      // Call the Model constructor
   parent::__construct();

   $this->load->model(array("Administration_m","Comment_m"));

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
    "laporan"
    );
  foreach ($selection as $key => $value) {
    $this->data[$value] = $this->session->userdata($value);
  }

  if(empty($userdata)){
   redirect(site_url('log/in'));
 }
 
}

public function index(){
  include("laporan/laporan.php");
}

public function lap_permintaan_pengadaan(){
  include("laporan/lap_permintaan_pengadaan.php");
}

public function lap_daftar_kontrak(){
  include("laporan/lap_daftar_kontrak.php");
}

public function lap_proc_value(){
  include("laporan/lap_proc_value.php");
}

public function lap_perm_cabang(){
  include("laporan/lap_perm_cabang.php");
}

public function monitor_distribusi_inv(){
  include("laporan/monitor_distribusi_inv.php");
}

public function tambah_distribusi_inv(){
  include("laporan/laporan.php");
}

public function monitor_permintaan_inv(){
  include("laporan/monitor_permintaan_inv.php");
}

public function tambah_permintaan_inv(){
  include("laporan/laporan.php");
}

public function stock_opname(){
  include("laporan/stock_opname.php");
}

public function tambah_stock_opname(){
  include("laporan/form_stock_opname.php");
}

public function semua_inv(){
  include("laporan/laporan.php");
}

public function laporan(){
  include("laporan/laporan.php");
}

public function ubah_status(){
  include("laporan/ubah_status.php");
}

public function ubah_batas(){
  include("laporan/ubah_batas.php");
}

public function detail(){
  include("laporan/detail.php");
}
public function penyesuaian(){
  include("laporan/penyesuaian.php");
}

public function picker_inv(){
  include("laporan/laporan.php");
}

public function picker_item_inv(){
  include("laporan/picker_item_inv.php");
}

public function picker_item_gudang_inv(){
  include("laporan/picker_item_gudang_inv.php");
}

}