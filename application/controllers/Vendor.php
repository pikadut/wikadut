<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends Telescoope_Controller {

  var $data;

  public function __construct(){

        // Call the Model constructor
    parent::__construct();

    $this->load->model(array("Vendor_m","Administration_m",'Comment_m'));

    $this->load->library('grocery_CRUD');

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'vendor';

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
    
    $selection = array();
      
    
    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    if(empty($userdata)){
     redirect(site_url('log/in'));
   }

 }

  public function panduan(){
  
 }

 public function daftar_pekerjaan($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'daftar_pekerjaan_vendor':
    $this->daftar_pekerjaan_vendor();
    break;

    case 'daftar_pekerjaan_vendor_form':
    $this->daftar_pekerjaan_vendor_form($param2);
    break;

    default:
    $this->daftar_pekerjaan_vendor();
    break;

  }
}

 public function vendor_tools($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'aktivasi_vendor':
    $this->aktivasi_vendor();
    break;

    case 'aktivasi_vendor_form':
    $this->edit_aktivasi_vendor($param2);
    break;

    //start code hlmifzi
    case 'aktivasi_vendor_commodity_form':
    $this->edit_aktivasi_commodity_vendor($param2);
    break;
    //end

    default:
    $this->vendor_tools();
    break;

  }

}

public function daftar_vendor($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'daftar_seluruh_vendor':
    $this->daftar_seluruh_vendor();
    break;

    case 'lihat_detail_vendor':
    $this->lihat_detail_vendor();
    break;

    default:
    $this->daftar_vendor();
    break;

    case 'generate_bidder_list':
    $this->generate_bidder_list($param2);
    break;

    default:
    $this->generate_bidder_list($param2);
    break;

    case 'daftar_vendor_domisili_expired':
    $this->daftar_vendor_domisili_expired();
    break;

  }
}

  public function kinerja_vendor($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'kpi_vendor':
    $this->kpi_vendor();
    break;

    case 'kpi_vendor_form':
    $this->kpi_vendor_form($param2);
    break;

    case 'kpi_vendor':
    $this->kpi_vendor();
    break;


    case 'aktivasi_suspend_vendor_form':
    $this->aktivasi_suspend_vendor_form($param2);
    break;

    case 'aktivasi_suspend_vendor':
    $this->aktivasi_suspend_vendor();
    break;

    case 'suspend_vendor':
    $this->suspend_vendor();
    break;

    //hlmlifzi
    case 'suspend_commodity_vendor':
    $this->suspend_commodity_vendor();
    break;
    //end

    case 'suspend_vendor_form':
    $this->suspend_vendor_form($param2);
    break;

    //start hlmifzi
    case 'suspend_vendor_commodity_form':
    $this->suspend_vendor_commodity_form($param2);
    break;
    //end

    default:
    $this->suspend_vendor();
    break;

    case 'blacklist_vendor':
    $this->blacklist_vendor();
    break;

    case 'blacklist_vendor_form':
    $this->blacklist_vendor_form($param2);
    break;

    default:
    $this->blacklist_vendor();
    break;

  }

}

public function aktivasi_vendor(){
  include("vendor/vendor_tools/aktivasi_vendor.php");
}

public function data_aktivasi_vendor(){
  include("vendor/vendor_tools/data_aktivasi_vendor.php");
}

//start code hlmifzi
public function data_aktivasi_vendor_commodity(){
  include("vendor/vendor_tools/data_aktivasi_vendor_commodity.php");
}
//end

public function edit_aktivasi_vendor($id){
  include("vendor/vendor_tools/edit_aktivasi_vendor.php");
}

public function submit_edit_aktivasi_vendor(){
  include("vendor/vendor_tools/submit_edit_aktivasi_vendor.php");
}

//start code hlmifzi
public function edit_aktivasi_commodity_vendor($id){
  include("vendor/vendor_tools/edit_aktivasi_commodity_vendor.php");
}

public function submit_edit_aktivasi_commodity_vendor(){
  include("vendor/vendor_tools/submit_edit_aktivasi_commodity_vendor.php");
}
//end

public function daftar_seluruh_vendor(){
  include("vendor/daftar_vendor/daftar_seluruh_vendor/daftar_seluruh_vendor.php");
}

public function data_daftar_seluruh_vendor(){
  include("vendor/daftar_vendor/daftar_seluruh_vendor/data_daftar_seluruh_vendor.php");
}

public function lihat_detail_vendor(){
  include("vendor/daftar_vendor/daftar_seluruh_vendor/lihat_detail_vendor.php");
}

public function generate_bidder_list($param = ""){
  include("vendor/daftar_vendor/generate_bidder_list/generate_bidder_list.php");
}

public function data_generate_bidder_list(){
  include("vendor/daftar_vendor/generate_bidder_list/data_generate_bidder_list.php");
}

public function daftar_vendor_domisili_expired(){
  include("vendor/daftar_vendor/daftar_vendor_domisili_expired/daftar_vendor_domisili_expired.php");
}

public function data_daftar_vendor_domisili_expired(){
  include("vendor/daftar_vendor/daftar_vendor_domisili_expired/data_daftar_vendor_domisili_expired.php");
}

public function kpi_vendor(){
  include("vendor/kinerja_vendor/kpi_vendor.php");
}

public function data_kpi_vendor(){
  include("vendor/kinerja_vendor/data_kpi_vendor.php");
}

public function info_kpi_vendor($id = ""){
  include("vendor/kinerja_vendor/info_kpi_vendor.php");
}

public function view_kpi_vendor($id = ""){
  include("vendor/kinerja_vendor/view_kpi_vendor.php");
}

public function daftar_pekerjaan_vendor(){
  include("vendor/kinerja_vendor/daftar_pekerjaan_vendor.php");
}

public function data_daftar_pekerjaan_vendor(){
  include("vendor/kinerja_vendor/data_daftar_pekerjaan_vendor.php");
}

//hlmifzi
public function data_daftar_pekerjaan_commodity_vendor(){
  include("vendor/kinerja_vendor/data_daftar_pekerjaan_commodity_vendor.php");
}
//end

public function data_daftar_pekerjaan_blacklist_vendor(){
  include("vendor/kinerja_vendor/data_daftar_pekerjaan_blacklist_vendor.php");
}

public function daftar_pekerjaan_vendor_form($id){
  include("vendor/kinerja_vendor/daftar_pekerjaan_vendor_form.php");
}


//start code hlmifzi
public function daftar_pekerjaan_vendor_commodity_form($id){
  include("vendor/kinerja_vendor/daftar_pekerjaan_vendor_commodity_form.php");
}
//end

public function daftar_pekerjaan_blacklist_vendor_form($id){
  include("vendor/kinerja_vendor/daftar_pekerjaan_blacklist_vendor_form.php");
}

public function submit_daftar_pekerjaan_blacklist(){
  include("vendor/kinerja_vendor/submit_daftar_pekerjaan_blacklist.php");
}

public function submit_daftar_pekerjaan(){
  include("vendor/kinerja_vendor/submit_daftar_pekerjaan.php");
}

//start code hlmifzi
public function submit_daftar_pekerjaan_commodity(){
  include("vendor/kinerja_vendor/submit_daftar_pekerjaan_commodity.php");
}
// end


public function suspend_vendor(){
  include("vendor/kinerja_vendor/suspend_vendor.php");
}

//start hlmifzi
public function suspend_commodity_vendor(){
  include("vendor/kinerja_vendor/suspend_commodity_vendor.php");
}

//end


public function data_suspend_vendor(){
  include("vendor/kinerja_vendor/data_suspend_vendor.php");
}

//start hlmifzi
public function data_suspend_commodity_vendor(){
  include("vendor/kinerja_vendor/data_suspend_commodity_vendor.php");
}
//end

public function suspend_vendor_form($id){
  include("vendor/kinerja_vendor/suspend_vendor_form.php");
}

//start code hlmifzi
public function suspend_vendor_commodity_form($id){
  include("vendor/kinerja_vendor/suspend_vendor_commodity_form.php");
}
//end

public function submit_suspend_vendor(){
  include("vendor/kinerja_vendor/submit_suspend_vendor.php");
}

//start code hlmifzi
public function submit_suspend_commodity_vendor(){
  include("vendor/kinerja_vendor/submit_suspend_commodity_vendor.php");
}
//end


public function aktivasi_suspend_vendor(){

  include("vendor/kinerja_vendor/aktivasi_suspend_vendor.php");
}

public function data_aktivasi_suspend_vendor(){
  include("vendor/kinerja_vendor/data_aktivasi_suspend_vendor.php");
}

public function aktivasi_suspend_vendor_form($id){
  include("vendor/kinerja_vendor/aktivasi_suspend_vendor_form.php");
}

public function submit_aktivasi_suspend_vendor(){
  include("vendor/kinerja_vendor/submit_aktivasi_suspend_vendor.php");
}

public function blacklist_vendor(){
  include("vendor/kinerja_vendor/blacklist_vendor.php");
}

public function data_blacklist_vendor(){
  include("vendor/kinerja_vendor/data_blacklist_vendor.php");
}

public function data_blacklist_aktif(){
  include("vendor/kinerja_vendor/data_blacklist_aktif.php");
}

public function blacklist_vendor_form($id){
  include("vendor/kinerja_vendor/blacklist_vendor_form.php");
}

public function submit_blacklist_vendor(){
  include("vendor/kinerja_vendor/submit_blacklist_vendor.php");
}
//start code hlmifzi
public function detail_barang_kpi($id = "",$vendor=""){//end code
  include("vendor/kinerja_vendor/detail_barang_kpi.php");
}

public function detail_vendor($type = "",$id = ""){
  include("vendor/vendor_tools/detail_vendor.php");
}

}
