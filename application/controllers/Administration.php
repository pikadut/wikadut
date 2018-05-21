<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration extends Telescoope_Controller {

  var $data;

  public function __construct(){

        // Call the Model constructor
    parent::__construct();

    $this->load->model(array("Administration_m","Administration_m","Comment_m","Procedure_m"));

    $this->load->library('grocery_CRUD');

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'administration';

    $this->data['controller_name'] = $this->uri->segment(1);

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
      "selection_mata_anggaran");
    
    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    /*
    if($userdata['job_title'] != "ADMIN"){
      $this->noAccess();
    }
    */

    if(empty($userdata)){
     redirect(site_url('log/in'));
   }

 }

 public function user_management($param1 = "" ,$param2 = "", $param3= ""){

  switch ($param1) {

    case 'user_access':

    switch ($param2) {

      case 'add_user_access':
      $this->add_user_access();
      break;

      case 'ubah':
      $this->edit_user_access($param3);
      break;

      case 'hapus':
      $this->delete_user_access($param3);
      break;

      default:
      $this->user_access();
      break;

    }
    break;

    case 'employee':

    switch ($param2) {

      case 'add_employee':
      $this->add_employee();
      break;

      case 'ubah':
      $this->edit_employee($param3);
      break;

      case 'hapus':
      $this->delete_employee($param3);
      break;

      case 'add_job_post':
      $this->add_job_post($param3);
      break;

      case 'hapus_job_post':
      $this->delete_job_post($param3);
      break;

      default:
      $this->employee();
      break;

    }

    break;

    default:
    $this->user_management();
    break;

  }

}

public function master_data($param1 = "" ,$param2 = "",$param3 = ""){

  switch ($param1) {

    case 'divisi_departemen':

    switch ($param2) {

      case 'add_divisi_departemen':
      $this->add_divisi_departemen();
      break;

      case 'ubah':
      $this->edit_divisi_departemen($param3);
      break;

      case 'nonaktif':
      $this->nonaktif_divisi_departemen($param3);
      break;

      default:
      $this->divisi_departemen();
      break;

    }

    break;

    case 'gudang':

    switch ($param2) {

      case 'tambah':
      $this->add_gudang();
      break;

      case 'ubah':
      $this->edit_gudang($param3);
      break;

      case 'hapus':
      $this->delete_gudang($param3);
      break;

      default:
      $this->gudang();
      break;

    }

    break;


    case 'kapal':

    switch ($param2) {

      case 'tambah':
      $this->add_kapal();
      break;

      case 'ubah':
      $this->edit_kapal($param3);
      break;

      case 'hapus':
      $this->delete_kapal($param3);
      break;

      default:
      $this->kapal();
      break;

    }

    break;


    case 'ruangan':

    switch ($param2) {

      case 'tambah':
      $this->add_ruangan();
      break;

      case 'ubah':
      $this->edit_ruangan($param3);
      break;

      case 'hapus':
      $this->delete_ruangan($param3);
      break;

      default:
      $this->ruangan();
      break;

    }

    break;

    case 'property_aset':

    switch ($param2) {

      case 'tambah':
      $this->add_property_aset();
      break;

      case 'ubah':
      $this->edit_property_aset($param3);
      break;

      case 'hapus':
      $this->delete_property_aset($param3);
      break;

      default:
      $this->property_aset();
      break;

    }

    break;

    case 'anggaran':

    switch ($param2) {

      case 'tambah':
      $this->add_anggaran();
      break;

      case 'ubah':
      $this->edit_anggaran($param3);
      break;

      case 'hapus':
      $this->delete_anggaran($param3);
      break;

      default:
      $this->anggaran();
      break;

    }

    break;

    case 'kategori_pajak':

    switch ($param2) {

      case 'tambah':
      $this->add_kategori_pajak();
      break;

      case 'ubah':
      $this->edit_kategori_pajak($param3);
      break;

      case 'hapus':
      $this->delete_kategori_pajak($param3);
      break;

      default:
      $this->kategori_pajak();
      break;

    }

    break;
    
    case 'delivery_point':

    switch ($param2) {

      case 'add_delivery_point':
      $this->add_delivery_point();
      break;

      case 'ubah':
      $this->edit_delivery_point($param3);
      break;

      case 'nonaktif':
      $this->nonaktif_delivery_point($param3);
      break;

      default:
      $this->delivery_point();
      break;


    }

    break;

    case 'daftar_kantor':

    switch ($param2) {

      case 'add_daftar_kantor':
      $this->add_daftar_kantor();
      break;

      case 'ubah':
      $this->edit_daftar_kantor($param3);
      break;

      case 'hapus':
      $this->delete_daftar_kantor($param3);
      break;


      default:
      $this->daftar_kantor();
      break;

    }

    break;

    case 'currency':

    switch ($param2) {

      case 'add_currency':
      $this->add_currency();
      break;

      case 'ubah':
      $this->edit_currency($param3);
      break;

      case 'hapus':
      $this->delete_currency($param3);
      break;


      default:
      $this->currency();
      break;

    }

    break;

    case 'employee_type':

    switch ($param2) {

      case 'add_employee_type':
      $this->add_employee_type();
      break;

      case 'ubah':
      $this->edit_employee_type($param3);
      break;

      case 'hapus':
      $this->delete_employee_type($param3);
      break;


      default:
      $this->employee_type();
      break;

    }

    break;

    case 'salutation':

    switch ($param2) {

      case 'add_salutation':
      $this->add_salutation();
      break;

      case 'ubah':
      $this->edit_salutation($param3);
      break;

      case 'hapus':
      $this->delete_salutation($param3);
      break;


      default:
      $this->salutation();
      break;

    }

    break;

    case 'menu_management':

    $this->menu_management();

    break;
	
	
	case 'lintasan':

    switch ($param2) {

      case 'add_lintasan':
      $this->add_lintasan();
      break;

      case 'ubah':
      $this->edit_lintasan($param3);
      break;

      case 'nonaktif':
      $this->nonaktif_lintasan($param3);
      break;

      default:
      $this->lintasan();
      break;

    }

    break;
  }
}

public function admin_tools($param1 = "" ,$param2 = "",$param3 = "",$param4 = ""){

  switch ($param1) {

    case 'hierarchy_position':

    switch ($param2) {

      case 'add':
      $this->act_hierarchy_position($param2,$param3,$param4);
      break;

      case 'edit':
      $this->act_hierarchy_position($param2,$param3,$param4);
      break;

      case 'delete':
      $this->delete_hierarchy_position($param3,$param4);
      break;


      default:
      $this->hierarchy_position();
      break;

    }

    break;

    case 'position':

    switch ($param2) {

      case 'add_position':
      $this->add_position();
      break;

      case 'ubah':
      $this->edit_position($param3);
      break;

      default:
      $this->position();
      break;

    }

    break;

    case 'exchange_rate':

    switch ($param2) {

      case 'add_exchange_rate':
      $this->add_exchange_rate();
      break;

      case 'ubah':
      $this->edit_exchange_rate($param3);
      break;

      case 'hapus':
      $this->delete_exchange_rate($param3);
      break;

      default:
      $this->exchange_rate();
      break;

    }
    break;
	
	
	//START
	case 'lintasan':

    switch ($param2) {

      case 'tambah':
      $this->add_lintasan();
      break;

      case 'ubah':
      $this->edit_lintasan($param3);
      break;

      case 'hapus':
      $this->delete_lintasan($param3);
      break;

      default:
      $this->lintasan();
      break;

    }

    break;

  }
}


public function user_access(){
  include("administration/user_management/user_access/user_access.php");
}

public function add_user_access(){ 
  include ("administration/user_management/user_access/add_user_access.php");
}
public function edit_user_access($id){ 
  include ("administration/user_management/user_access/edit_user_access.php");
}

public function submit_add_user_access(){ 
  include ("administration/user_management/user_access/submit_add_user_access.php");
}

public function submit_edit_user_access(){ 
  include ("administration/user_management/user_access/submit_edit_user_access.php");
}

public function delete_user_access($id){ 
  include ("administration/user_management/user_access/delete_user_access.php");
}

public function data_user_access(){ 
  include ("administration/user_management/user_access/data_user_access.php");
}

public function alias_user_access(){ 
  include ("administration/user_management/user_access/alias_user_access.php");
}





public function employee(){
  include("administration/user_management/employee/employee.php");
}

public function add_employee(){ 
  include ("administration/user_management/employee/add_employee.php");
}
public function edit_employee($id){ 
  include ("administration/user_management/employee/edit_employee.php");
}

public function submit_employee(){ 
  include ("administration/user_management/employee/submit_employee.php");
}

public function submit_edit_employee(){ 
  include ("administration/user_management/employee/submit_edit_employee.php");
}

public function delete_employee($id){ 
  include ("administration/user_management/employee/delete_employee.php");
}

public function data_employee(){ 
  include ("administration/user_management/employee/data_employee.php");
}

public function alias_employee(){ 
  include ("administration/user_management/employee/alias_employee.php");
}

public function add_job_post($id){ 
  include ("administration/user_management/employee/add_job_post.php");
}

public function submit_job_post(){ 
  include ("administration/user_management/employee/submit_job_post.php");
}

public function data_job_post(){ 
  include ("administration/user_management/employee/data_job_post.php");
}

public function delete_job_post($id){ 
  include ("administration/user_management/employee/delete_job_post.php");
}

public function data_hierarchy_position($id = ""){ 
  include ("administration/admin_tools/hierarchy_position/data_hierarchy_position.php");
}

public function divisi_departemen(){
  include("administration/master_data/divisi_departemen/divisi_departemen.php");
}

public function data_divisi_departemen(){ 
  include ("administration/master_data/divisi_departemen/data_divisi_departemen.php");
}

public function alias_divisi_departemen(){ 
  include ("administration/master_data/divisi_departemen/alias_divisi_departemen.php");
}

public function add_divisi_departemen(){ 
  include ("administration/master_data/divisi_departemen/add_divisi_departemen.php");
}

public function submit_add_divisi_departemen(){ 
  include ("administration/master_data/divisi_departemen/submit_add_divisi_departemen.php");
}

public function edit_divisi_departemen($id){ 
  include ("administration/master_data/divisi_departemen/edit_divisi_departemen.php");
}

public function submit_edit_divisi_departemen(){ 
  include ("administration/master_data/divisi_departemen/submit_edit_divisi_departemen.php");
}

public function nonaktif_divisi_departemen(){ 
  include ("administration/master_data/divisi_departemen/nonaktif_divisi_departemen.php");
}


public function delivery_point(){
  include("administration/master_data/delivery_point/delivery_point.php");
}

public function data_delivery_point(){ 
  include ("administration/master_data/delivery_point/data_delivery_point.php");
}

public function alias_delivery_point(){ 
  include ("administration/master_data/delivery_point/alias_delivery_point.php");
}

public function add_delivery_point(){ 
  include ("administration/master_data/delivery_point/add_delivery_point.php");
}

public function submit_add_delivery_point(){ 
  include ("administration/master_data/delivery_point/submit_add_delivery_point.php");
}

public function edit_delivery_point($id){ 
  include ("administration/master_data/delivery_point/edit_delivery_point.php");
}

public function submit_edit_delivery_point(){ 
  include ("administration/master_data/delivery_point/submit_edit_delivery_point.php");
}

public function nonaktif_delivery_point(){ 
  include ("administration/master_data/delivery_point/nonaktif_delivery_point.php");
}



public function daftar_kantor(){
  include("administration/master_data/daftar_kantor/daftar_kantor.php");
}

public function data_daftar_kantor(){ 
  include ("administration/master_data/daftar_kantor/data_daftar_kantor.php");
}

public function alias_daftar_kantor(){ 
  include ("administration/master_data/daftar_kantor/alias_daftar_kantor.php");
}

public function add_daftar_kantor(){ 
  include ("administration/master_data/daftar_kantor/add_daftar_kantor.php");
}

public function submit_add_daftar_kantor(){ 
  include ("administration/master_data/daftar_kantor/submit_add_daftar_kantor.php");
}

public function edit_daftar_kantor($id){ 
  include ("administration/master_data/daftar_kantor/edit_daftar_kantor.php");
}

public function submit_edit_daftar_kantor(){ 
  include ("administration/master_data/daftar_kantor/submit_edit_daftar_kantor.php");
}

public function delete_daftar_kantor($id){ 
  include ("administration/master_data/daftar_kantor/delete_daftar_kantor.php");
}

public function gudang(){
  include("administration/master_data/gudang/gudang.php");
}

public function data_gudang(){ 
  include ("administration/master_data/gudang/data_gudang.php");
}

public function add_gudang(){ 
  include ("administration/master_data/gudang/add_gudang.php");
}

public function submit_add_gudang(){ 
  include ("administration/master_data/gudang/submit_add_gudang.php");
}

public function edit_gudang($id){ 
  include ("administration/master_data/gudang/edit_gudang.php");
}

public function submit_edit_gudang(){ 
  include ("administration/master_data/gudang/submit_edit_gudang.php");
}

public function delete_gudang($id){ 
  include ("administration/master_data/gudang/delete_gudang.php");
}

public function komponisasi_template(){
  include("administration/master_data/komponisasi_template/komponisasi_template.php");
}

public function data_komponisasi_template(){ 
  include ("administration/master_data/komponisasi_template/data_komponisasi_template.php");
}

public function tree_komponisasi_template(){ 
  include ("administration/master_data/komponisasi_template/tree_komponisasi_template.php");
}


public function add_komponisasi_template(){ 
  include ("administration/master_data/komponisasi_template/add_komponisasi_template.php");
}

public function submit_add_komponisasi_template(){ 
  include ("administration/master_data/komponisasi_template/submit_add_komponisasi_template.php");
}

public function edit_komponisasi_template($id){ 
  include ("administration/master_data/komponisasi_template/edit_komponisasi_template.php");
}

public function submit_edit_komponisasi_template(){ 
  include ("administration/master_data/komponisasi_template/submit_edit_komponisasi_template.php");
}

public function delete_komponisasi_template($id){ 
  include ("administration/master_data/komponisasi_template/delete_komponisasi_template.php");
}


public function kapal(){
  include("administration/master_data/kapal/kapal.php");
}

public function data_kapal(){ 
  include ("administration/master_data/kapal/data_kapal.php");
}

public function add_kapal(){ 
  include ("administration/master_data/kapal/add_kapal.php");
}

public function submit_add_kapal(){ 
  include ("administration/master_data/kapal/submit_add_kapal.php");
}

public function edit_kapal($id){ 
  include ("administration/master_data/kapal/edit_kapal.php");
}

public function submit_edit_kapal(){ 
  include ("administration/master_data/kapal/submit_edit_kapal.php");
}

public function delete_kapal($id){ 
  include ("administration/master_data/kapal/delete_kapal.php");
}


public function mata_anggaran_picker(){
  include("procurement/mata_anggaran/picker_mata_anggaran.php");
}

public function property_aset(){
  include("administration/master_data/property_aset/property_aset.php");
}

public function data_property_aset(){ 
  include ("administration/master_data/property_aset/data_property_aset.php");
}

public function add_property_aset(){ 
  include ("administration/master_data/property_aset/add_property_aset.php");
}

public function submit_add_property_aset(){ 
  include ("administration/master_data/property_aset/submit_add_property_aset.php");
}

public function edit_property_aset($id){ 
  include ("administration/master_data/property_aset/edit_property_aset.php");
}

public function submit_edit_property_aset(){ 
  include ("administration/master_data/property_aset/submit_edit_property_aset.php");
}

public function delete_property_aset($id){ 
  include ("administration/master_data/property_aset/delete_property_aset.php");
}


public function ruangan(){
  include("administration/master_data/ruangan/ruangan.php");
}

public function data_ruangan(){ 
  include ("administration/master_data/ruangan/data_ruangan.php");
}

public function add_ruangan(){ 
  include ("administration/master_data/ruangan/add_ruangan.php");
}

public function submit_add_ruangan(){ 
  include ("administration/master_data/ruangan/submit_add_ruangan.php");
}

public function edit_ruangan($id){ 
  include ("administration/master_data/ruangan/edit_ruangan.php");
}

public function submit_edit_ruangan(){ 
  include ("administration/master_data/ruangan/submit_edit_ruangan.php");
}

public function delete_ruangan($id){ 
  include ("administration/master_data/ruangan/delete_ruangan.php");
}


public function kategori_pajak(){
  include("administration/master_data/kategori_pajak/kategori_pajak.php");
}

public function data_kategori_pajak(){ 
  include ("administration/master_data/kategori_pajak/data_kategori_pajak.php");
}

public function add_kategori_pajak(){ 
  include ("administration/master_data/kategori_pajak/add_kategori_pajak.php");
}

public function submit_add_kategori_pajak(){ 
  include ("administration/master_data/kategori_pajak/submit_add_kategori_pajak.php");
}

public function edit_kategori_pajak($id){ 
  include ("administration/master_data/kategori_pajak/edit_kategori_pajak.php");
}

public function submit_edit_kategori_pajak(){ 
  include ("administration/master_data/kategori_pajak/submit_edit_kategori_pajak.php");
}

public function delete_kategori_pajak($id){ 
  include ("administration/master_data/kategori_pajak/delete_kategori_pajak.php");
}


public function anggaran(){
  include("administration/master_data/anggaran/anggaran.php");
}

public function data_anggaran(){ 
  include ("administration/master_data/anggaran/data_anggaran.php");
}

public function add_anggaran(){ 
  include ("administration/master_data/anggaran/add_anggaran.php");
}

public function submit_add_anggaran(){ 
  include ("administration/master_data/anggaran/submit_add_anggaran.php");
}

public function edit_anggaran($id){ 
  include ("administration/master_data/anggaran/edit_anggaran.php");
}

public function submit_edit_anggaran(){ 
  include ("administration/master_data/anggaran/submit_edit_anggaran.php");
}

public function delete_anggaran($id){ 
  include ("administration/master_data/anggaran/delete_anggaran.php");
}

public function picker_anggaran(){ 
  include ("administration/master_data/anggaran/picker_anggaran.php");
}

public function currency(){
  include("administration/master_data/currency/currency.php");
}

public function data_currency(){ 
  include ("administration/master_data/currency/data_currency.php");
}

public function alias_currency(){ 
  include ("administration/master_data/currency/alias_currency.php");
}

public function add_currency(){ 
  include ("administration/master_data/currency/add_currency.php");
}

public function submit_add_currency(){ 
  include ("administration/master_data/currency/submit_add_currency.php");
}

public function edit_currency($id){ 
  include ("administration/master_data/currency/edit_currency.php");
}

public function submit_edit_currency(){ 
  include ("administration/master_data/currency/submit_edit_currency.php");
}

public function delete_currency($id){ 
  include ("administration/master_data/currency/delete_currency.php");
}



public function employee_type(){
  include("administration/master_data/employee_type/employee_type.php");
}

public function data_employee_type(){ 
  include ("administration/master_data/employee_type/data_employee_type.php");
}

public function alias_employee_type(){ 
  include ("administration/master_data/employee_type/alias_employee_type.php");
}

public function add_employee_type(){ 
  include ("administration/master_data/employee_type/add_employee_type.php");
}

public function submit_add_employee_type(){ 
  include ("administration/master_data/employee_type/submit_add_employee_type.php");
}

public function edit_employee_type($id){ 
  include ("administration/master_data/employee_type/edit_employee_type.php");
}

public function submit_edit_employee_type(){ 
  include ("administration/master_data/employee_type/submit_edit_employee_type.php");
}

public function delete_employee_type($id){ 
  include ("administration/master_data/employee_type/delete_employee_type.php");
}




public function salutation(){
  include("administration/master_data/salutation/salutation.php");
}

public function data_salutation(){ 
  include ("administration/master_data/salutation/data_salutation.php");
}

public function alias_salutation(){ 
  include ("administration/master_data/salutation/alias_salutation.php");
}

public function add_salutation(){ 
  include ("administration/master_data/salutation/add_salutation.php");
}

public function submit_add_salutation(){ 
  include ("administration/master_data/salutation/submit_add_salutation.php");
}

public function edit_salutation($id){ 
  include ("administration/master_data/salutation/edit_salutation.php");
}

public function submit_edit_salutation(){ 
  include ("administration/master_data/salutation/submit_edit_salutation.php");
}

public function delete_salutation($id){ 
  include ("administration/master_data/salutation/delete_salutation.php");
}

public function data_user_list(){
  include("administration/user_management/data_user_list.php");
}

public function menu_management(){
  include("administration/master_data/menu_management/menu_management.php");
}

public function data_menu_management(){
  include("administration/master_data/menu_management/data_menu_management.php");
}

public function submit_menu_management(){
  include("administration/master_data/menu_management/submit_menu_management.php");
}

public function data_master_mata_anggaran(){ 
  include ("administration/master_data/mata_anggaran/master_mata_anggaran/data_master_mata_anggaran.php");
}

public function add_master_mata_anggaran(){ 
  include ("administration/master_data/mata_anggaran/master_mata_anggaran/add_master_mata_anggaran.php");
}

public function submit_add_master_mata_anggaran(){ 
  include ("administration/master_data/mata_anggaran/master_mata_anggaran/submit_add_master_mata_anggaran.php");
}

public function edit_master_mata_anggaran($id){ 
  include ("administration/master_data/mata_anggaran/master_mata_anggaran/edit_master_mata_anggaran.php");
}

public function submit_edit_master_mata_anggaran(){ 
  include ("administration/master_data/mata_anggaran/master_mata_anggaran/submit_edit_master_mata_anggaran.php");
}

public function delete_master_mata_anggaran($id){ 
  include ("administration/master_data/mata_anggaran/master_mata_anggaran/delete_master_mata_anggaran.php");
}

public function hierarchy_position(){
  include("administration/admin_tools/hierarchy_position/hierarchy_position.php");
}

public function act_hierarchy_position($act,$id,$type = ""){ 
  include ("administration/admin_tools/hierarchy_position/form_hierarchy_position.php");
}

public function submit_hierarchy_position(){ 
  include ("administration/admin_tools/hierarchy_position/submit_hierarchy_position.php");
}

public function edit_hierarchy_position($id){ 
  include ("administration/admin_tools/hierarchy_position/edit_hierarchy_position.php");
}

public function submit_edit_hierarchy_position(){ 
  include ("administration/admin_tools/hierarchy_position/submit_edit_hierarchy_position.php");
}

public function delete_hierarchy_position($id){ 
  include ("administration/admin_tools/hierarchy_position/delete_hierarchy_position.php");
}



public function position(){
  include("administration/admin_tools/position/position.php");
}

public function data_position(){ 
  include ("administration/admin_tools/position/data_position.php");
}

public function add_position(){ 
  include ("administration/admin_tools/position/add_position.php");
}

public function submit_add_position(){ 
  include ("administration/admin_tools/position/submit_add_position.php");
}

public function edit_position($id){ 
  include ("administration/admin_tools/position/edit_position.php");
}

public function submit_edit_position(){ 
  include ("administration/admin_tools/position/submit_edit_position.php");
}

public function delete_position($id){ 
  include ("administration/admin_tools/position/delete_position.php");

}

public function exchange_rate(){
  include("administration/admin_tools/exchange_rate/exchange_rate.php");
}

public function data_exchange_rate(){ 
  include ("administration/admin_tools/exchange_rate/data_exchange_rate.php");
}

public function alias_exchange_rate(){ 
  include ("administration/admin_tools/exchange_rate/alias_exchange_rate.php");
}

public function add_exchange_rate(){ 
  include ("administration/admin_tools/exchange_rate/add_exchange_rate.php");
}

public function submit_add_exchange_rate(){ 
  include ("administration/admin_tools/exchange_rate/submit_add_exchange_rate.php");
}

public function edit_exchange_rate($id){ 
  include ("administration/admin_tools/exchange_rate/edit_exchange_rate.php");
}

public function submit_edit_exchange_rate(){ 
  include ("administration/admin_tools/exchange_rate/submit_edit_exchange_rate.php");
}

public function delete_exchange_rate($id){ 
  include ("administration/admin_tools/exchange_rate/delete_exchange_rate.php");
}

public function generate_menu(){ 
  include ("administration/master_data/menu_management/generate_menu.php");
}

public function generate_anggaran(){ 
  include ("administration/master_data/anggaran/generate_anggaran.php");
}


public function lintasan(){
  include("administration/master_data/lintasan/lintasan.php");
}

public function data_lintasan(){ 
  include ("administration/master_data/lintasan/data_lintasan.php");
}

public function alias_lintasan(){ 
  include ("administration/master_data/lintasan/alias_lintasan.php");
}

public function add_lintasan(){ 
  include ("administration/master_data/lintasan/add_lintasan.php");
}

public function submit_add_lintasan(){ 
  include ("administration/master_data/lintasan/submit_add_lintasan.php");
}

public function edit_lintasan($id){ 
  include ("administration/master_data/lintasan/edit_lintasan.php");
}

public function submit_edit_lintasan(){ 
  include ("administration/master_data/lintasan/submit_edit_lintasan.php");
}

public function nonaktif_lintasan(){ 
  include ("administration/master_data/lintasan/nonaktif_lintasan.php");
}


}
