<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiket extends Telescoope_Controller {

  var $data;

  public function __construct(){

    parent::__construct();

    $this->load->model(array("Tikplan_m","Tiksale_m","Workflow_m","Comment_m","Administration_m","Commodity_m"));
    
    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'tiket';

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

    //$this->data['doc_category'] = $this->Tiket_m->getKategoriDokumen()->result_array();
    
    $selection = array(
      "selection_permintaan_tiket",
      "selection_penerimaan_tiket",
      "selection_penjualan_tiket",
      "selection_tiket_cabang",
      "selection_district"
      );
    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    
    $this->data['workflow_list'] = array(3=>"Ditolak",2=>"Disetujui");

    if(empty($userdata)){
     redirect(site_url('log/in'));
   }

 }

public function daftar_pekerjaan($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'proses':
    $this->ubah_permintaan_tiket();
    break;

    default:    
    $this->daftar_pekerjaan_tiket();
    break;

  }

}


public function permintaan_tiket($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'pembuatan_permintaan_tiket':
    $this->pembuatan_permintaan_tiket();
    break;

    case 'daftar_permintaan_tiket':

    switch ($param2) {

      case 'lihat':
      $this->lihat_permintaan_tiket();
      break;

      default:
      $this->daftar_permintaan_tiket();
      break;

    }

    break;

    case 'update_daftar_permintaan_tiket':

    switch ($param2) {

      case 'ubah':
      $this->ubah_permintaan_tiket();
      break;

      default:
      $this->update_daftar_permintaan_tiket();
      break;

    }

    break;

    case 'rekapitulasi_permintaan_tiket':

    switch ($param2) {

      case 'approval':
      $this->approval_permintaan_tiket();
      break;

      default:
      $this->daftar_rekapitulasi_permintaan_tiket();
      break;

    }

    break;
	
    case 'daftar_pengiriman_tiket':

    switch ($param2) {

      case 'entry':
      $this->entry_pengiriman_tiket();
      break;

      default:
      $this->daftar_pengiriman_tiket();
      break;

    }

    break;	

    case 'rekapitulasi_pengiriman_tiket':

    switch ($param2) {
		
      case 'lihat':
      $this->lihat_pengiriman_tiket();
      break;

      default:
      $this->daftar_rekapitulasi_pengiriman_tiket();
      break;

    }
	
    break;
	
	case 'daftar_penerimaan_tiket':

    switch ($param2) {

      case 'entry':
      $this->entry_penerimaan_tiket();
      break;


      default:
      $this->daftar_penerimaan_tiket();
      break;

    }

    break;

    case 'rekapitulasi_penerimaan_tiket':

    switch ($param2) {
		
      case 'detail':
      $this->lihat_penerimaan_tiket();
      break;

      default:
      $this->daftar_rekapitulasi_penerimaan_tiket();
      break;

    }
	
    break;

    case 'picker':
    $this->permintaan_tiket_picker();
    break;


    default:
    $this->daftar_permintaan_tiket();
    break;

  }

}


public function penjualan_tiket($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'daftar_entry_penjualan_tiket':

    switch ($param2) {

      case 'entry':
      $this->entry_penjualan_tiket();
      break;

      default:
      $this->daftar_entry_penjualan_tiket();
      break;

    }

    case 'daftar_penjualan_tiket':

    switch ($param2) {

      case 'lihat':
      $this->lihat_penjualan_tiket();
      break;

      default:
      $this->daftar_penjualan_tiket();
      break;

    }

    break;

    case 'update_daftar_penjualan_tiket':

    switch ($param2) {

      case 'ubah':
      $this->ubah_penjualan_tiket();
      break;

      default:
      $this->update_daftar_penjualan_tiket();
      break;

    }

    break;

    case 'rekapitulasi_penjualan_tiket':

    switch ($param2) {

      case 'approval':
      $this->approval_penjualan_tiket();
      break;

      default:
      $this->daftar_rekapitulasi_penjualan_tiket();
      break;

    }

    break;

	case 'picktiksold':
	$this->picker_tiket_cabang();
    break;


    default:
    $this->daftar_penjualan_tiket();
    break;

  }

}


public function monitor_tiket($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'monitor_tiket_cabang':

    switch ($param2) {

      case 'lihat':
      $this->lihat_monitor_cabang();
      break;

      default:
      $this->monitor_cabang();
      break;

    }

    case 'monitor_tiket_lintasan':

    switch ($param2) {

      case 'lihat':
      $this->lihat_monitor_lintasan();
      break;

      default:
      $this->monitor_lintasan();
      break;

    }

    break;


    default:
    $this->daftar_monitor_tiket();
    break;

  }

}




public function daftar_pekerjaan_tiket(){
  include("tiket/daftar_pekerjaan/daftar_pekerjaan_tiket.php");
}

public function data_pekerjaan_pt(){ 
  include ("tiket/daftar_pekerjaan/data_pekerjaan_pt.php");
}

public function data_pekerjaan_dt(){ 
  include ("tiket/daftar_pekerjaan/data_pekerjaan_dt.php");
}

public function data_pekerjaan_rt(){ 
  include ("tiket/daftar_pekerjaan/data_pekerjaan_rt.php");
}

public function data_pekerjaan_st(){ 
  include ("tiket/daftar_pekerjaan/data_pekerjaan_st.php");
}


//NEW PERMINTAAN TIKET

public function picker_tiket(){ 
  include ("tiket/permintaan_tiket/picker_tiket.php");
}

public function pembuatan_permintaan_tiket(){
  include("tiket/permintaan_tiket/pembuatan_permintaan_tiket.php");
}

public function ubah_permintaan_tiket(){
  include("tiket/permintaan_tiket/ubah_permintaan_tiket.php");
}

public function submit_pembuatan_permintaan_tiket(){
  include("tiket/permintaan_tiket/submit_pembuatan_permintaan_tiket.php");
}

public function submit_ubah_permintaan_tiket(){
  include("tiket/permintaan_tiket/submit_ubah_permintaan_tiket.php");
}

public function daftar_rekapitulasi_permintaan_tiket(){
  include("tiket/permintaan_tiket/daftar_rekapitulasi_permintaan_tiket.php");
}

public function submit_approval_permintaan_tiket(){
  include("tiket/permintaan_tiket/submit_approval_permintaan_tiket.php");
}

public function approval_permintaan_tiket(){
  include("tiket/permintaan_tiket/approval_permintaan_tiket.php");
}

public function daftar_permintaan_tiket(){
  include("tiket/permintaan_tiket/daftar_permintaan_tiket.php");
}

public function update_daftar_permintaan_tiket(){
  include("tiket/permintaan_tiket/update_daftar_permintaan_tiket.php");
}

public function data_permintaan_tiket(){
  include("tiket/permintaan_tiket/data_permintaan_tiket.php");
}

public function lihat_permintaan_tiket(){
  include("tiket/permintaan_tiket/lihat_permintaan_tiket.php");
}


//NEW PENERIMAAN TIKET
public function daftar_rekapitulasi_penerimaan_tiket(){
  include("tiket/permintaan_tiket/daftar_rekapitulasi_penerimaan_tiket.php");
}

public function daftar_penerimaan_tiket(){
  include("tiket/permintaan_tiket/daftar_penerimaan_tiket.php");
}

public function entry_penerimaan_tiket(){
  include("tiket/permintaan_tiket/entry_penerimaan_tiket.php");
}

public function data_penerimaan_tiket(){
  include("tiket/permintaan_tiket/data_penerimaan_tiket.php");
}

public function lihat_penerimaan_tiket(){
  include("tiket/permintaan_tiket/lihat_penerimaan_tiket.php");
}

public function submit_entry_penerimaan_tiket(){
  include("tiket/permintaan_tiket/submit_entry_penerimaan_tiket.php");
}


//NEW PENGIRIMAN TIKET
public function daftar_rekapitulasi_pengiriman_tiket(){
  include("tiket/permintaan_tiket/daftar_rekapitulasi_pengiriman_tiket.php");
}

public function daftar_pengiriman_tiket(){
  include("tiket/permintaan_tiket/daftar_pengiriman_tiket.php");
}

public function entry_pengiriman_tiket(){
  include("tiket/permintaan_tiket/entry_pengiriman_tiket.php");
}

public function data_pengiriman_tiket(){
  include("tiket/permintaan_tiket/data_pengiriman_tiket.php");
}

public function lihat_pengiriman_tiket(){
  include("tiket/permintaan_tiket/lihat_pengiriman_tiket.php");
}

public function submit_entry_pengiriman_tiket(){
  include("tiket/permintaan_tiket/submit_entry_pengiriman_tiket.php");
}


//PENJUALAN TIKET

public function picker_tiket_cabang(){
  include("tiket/penjualan_tiket/picker_tiket_cabang.php");
}

public function pembuatan_penjualan_tiket(){
  include("tiket/penjualan_tiket/pembuatan_penjualan_tiket.php");
}

public function ubah_penjualan_tiket(){
  include("tiket/penjualan_tiket/ubah_penjualan_tiket.php");
}

public function submit_pembuatan_penjualan_tiket(){
  include("tiket/penjualan_tiket/submit_pembuatan_penjualan_tiket.php");
}

public function submit_ubah_penjualan_tiket(){
  include("tiket/penjualan_tiket/submit_ubah_penjualan_tiket.php");
}

public function daftar_rekapitulasi_penjualan_tiket(){
  include("tiket/penjualan_tiket/daftar_rekapitulasi_penjualan_tiket.php");
}

public function submit_approval_penjualan_tiket(){
  include("tiket/penjualan_tiket/submit_approval_penjualan_tiket.php");
}

public function approval_penjualan_tiket(){
  include("tiket/penjualan_tiket/approval_penjualan_tiket.php");
}

public function daftar_penjualan_tiket(){
  include("tiket/penjualan_tiket/daftar_penjualan_tiket.php");
}

public function update_daftar_penjualan_tiket(){
  include("tiket/penjualan_tiket/update_daftar_penjualan_tiket.php");
}

public function data_penjualan_tiket(){
  include("tiket/penjualan_tiket/data_penjualan_tiket.php");
}

public function data_tiket_cabang(){
  include("tiket/penjualan_tiket/data_tiket_cabang.php");
}

public function lihat_penjualan_tiket(){
  include("tiket/penjualan_tiket/lihat_penjualan_tiket.php");
}

public function entry_penjualan_tiket(){
  include("tiket/penjualan_tiket/entry_penjualan_tiket.php");
}

public function data_entry_penjualan_tiket(){
  include("tiket/penjualan_tiket/data_entry_penjualan_tiket.php");
}

public function daftar_entry_penjualan_tiket(){
  include("tiket/penjualan_tiket/daftar_entry_penjualan_tiket.php");
}


//MONITOR TIKET

public function data_monitor_cabang(){
  include("tiket/monitor_tiket/data_monitor_cabang.php");
}

public function data_monitor_lintasan(){
  include("tiket/monitor_tiket/data_monitor_lintasan.php");
}

public function lihat_monitor_cabang(){
  include("tiket/monitor_tiket/lihat_monitor_cabang.php");
}

public function lihat_monitor_lintasan(){
  include("tiket/monitor_tiket/lihat_monitor_lintasan.php");
}

public function daftar_monitor_tiket(){
  include("tiket/monitor_tiket/daftar_monitor_tiket.php");
}

public function monitor_lintasan(){
  include("tiket/monitor_tiket/monitor_lintasan.php");
}

public function monitor_cabang(){
  include("tiket/monitor_tiket/monitor_cabang.php");
}


}
