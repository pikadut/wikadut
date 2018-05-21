<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procurement extends Telescoope_Controller {

  var $data;

  public function __construct(){

    parent::__construct();

    $this->load->model(array("Workflow_m","Procurement_m","Procpagu_m","Procrfq_m","Procpr_m","Procplan_m","Procevaltemp_m","Administration_m","Comment_m","Administration_m","Procedure_m","Commodity_m"));
    
    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    //print_r($userdata);  

    $this->data['dir'] = 'procurement';

    $this->data['controller_name'] = $this->uri->segment(1);

    $this->session->set_userdata("module",$this->data['dir']);
    // haqim
    switch ($this->uri->segment(2)) {
      case 'submit_chat_pr':
        $dir = './uploads/'.PROCUREMENT_PERENCANAAN_CHAT_SPPBJ_FOLDER;
        break;
      case 'submit_chat_rfq':
        $dir = './uploads/'.PROCUREMENT_PERENCANAAN_CHAT_RFQ_FOLDER;
        break;

      default:
        $dir = './uploads/'.$this->data['dir'];
        break;
    }
    // end

    if (!file_exists($dir)){
      mkdir($dir, 0777, true);
    }

    $config['allowed_types'] = '*';
    $config['overwrite'] = false;
    $config['max_size'] = 3064;
    $config['upload_path'] = $dir;
    $this->load->library('upload', $config);

    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

    $this->data['doc_category'] = $this->Procurement_m->getKategoriDokumen()->result_array();
    
    $selection = array(
      "selection_mata_anggaran",
      "selection_perencanaan_pengadaan",
      "selection_permintaan_pengadaan",
      "selection_template_evaluasi",
      "selection_vendor_tender",
      "selection_vendor_tender_hadir",
      "selection_vendor_tender_hadir_2",
      "selection_panitia",
      "selection_klasifikasi",
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

 public function panduan(){
  redirect(base_url("guide/Manual_Procurement_Budgeting_PR.pdf"));
}

public function mata_anggaran($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'picker':
    $this->mata_anggaran_picker();
    break;

    default:
    $this->mata_anggaran();
    break;

  }

}


public function perencanaan_pengadaan($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'pembuatan_perencanaan_pengadaan':
    $this->pembuatan_perencanaan_pengadaan();
    break;

    case 'daftar_perencanaan_pengadaan':

    switch ($param2) {

      case 'lihat':
      $this->lihat_perencanaan_pengadaan();
      break;

      default:
      $this->daftar_perencanaan_pengadaan();
      break;

    }

    break;

    case 'update_daftar_perencanaan':

    switch ($param2) {

      case 'ubah':
      $this->ubah_perencanaan_pengadaan();
      break;

      default:
      $this->update_daftar_perencanaan();
      break;

    }

    break;

    case 'rekapitulasi_perencanaan_pengadaan':

    switch ($param2) {

      case 'approval':
      $this->approval_perencanaan_pengadaan();
      break;

      default:
      $this->daftar_rekapitulasi_perencanaan_pengadaan();
      break;

    }

    break;

    case 'picker':
    $this->perencanaan_pengadaan_picker();
    break;


    default:
    $this->daftar_perencanaan_pengadaan();
    break;

  }

}

public function proses_pengadaan($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'pembuatan_permintaan_pengadaan':
    $this->pembuatan_permintaan_pengadaan();
    break;

    //haqim
     case 'data_employee_chat':
     $this->data_employee_chat();
     break;
     //end

    case 'daftar_permintaan_pengadaan':

    switch ($param2) {

     case 'lihat':
     $this->lihat_permintaan_pengadaan();
     break;

     default:
     $this->daftar_permintaan_pengadaan();
     break;

   }

   break; 

   default:
   $this->daftar_permintaan_pengadaan();
   break;

 }

}

public function procurement_tools($param1 = "" ,$param2 = "", $param3 = ""){

  switch ($param1) {

    case 'aanwijzing_online':
    $this->view_aanwijzing_online();
    break;

    case 'pembuatan_template_evaluasi_pengadaan':
    $this->template_evaluasi('buat');
    break;

    case 'daftar_template_evaluasi_pengadaan':
    $this->template_evaluasi();
    break;

    case 'update_lampiran_dokumen_pengadaan':
    $this->update_procurement("ubah_lampiran","Update Lampiran Dokumen Pengadaan");
    break;

    case 'pembatalan_pengadaan':
    $this->update_procurement("pembatalan_pengadaan","Pembatalan Pengadaan");
    break;

    case 'update_lampiran_dokumen_pengadaan':
    $this->update_procurement("ubah_lampiran","Update Lampiran Dokumen Pengadaan");
    break;

    case 'update_data_hps':
    $this->update_procurement("ubah_hps","Update Data HPS");
    break;

    case 'update_tanggal_pembukaan_penawaran':
    $this->update_procurement("ubah_tanggal","Update Tanggal Pembukaan Penawaran");
    break;
    
    case 'ubah_template_evaluasi':
    $this->template_evaluasi('ubah');
    break;

    case 'lihat_template_evaluasi':
    $this->template_evaluasi('lihat');
    break;

    case 'hapus_template_evaluasi':
    $this->template_evaluasi('hapus');
    break;

    case 'panitia_pengadaan':

    switch ($param2) {

      case 'add_panitia_pengadaan':
      $this->add_panitia_pengadaan();
      break;

      case 'ubah':
      $this->edit_panitia_pengadaan($param3);
      break;

      case 'hapus':
      $this->delete_panitia_pengadaan($param3);
      break;

      case 'add_panitia_detail':
      $this->add_panitia_detail($param3);
      break;

      case 'hapus_panitia_detail':
      $this->delete_panitia_detail($param3);
      break;

      case 'picker':
      $this->picker_panitia_pengadaan();
      break;

      default:
      $this->panitia_pengadaan();
      break;

    }
    
    break;

    case 'mata_anggaran':

    switch ($param2) {

      case 'add_mata_anggaran':
      $this->add_mata_anggaran();
      break;

      case 'add_master_mata_anggaran':
      $this->add_master_mata_anggaran();
      break;

      case 'ubah':
      $this->edit_mata_anggaran($param3);
      break;

      case 'ubah_master_anggaran':
      $this->edit_master_mata_anggaran($param3);
      break;

      case 'hapus':
      $this->delete_mata_anggaran($param3);
      break;


      default:
      $this->list_mata_anggaran();
      break;

    }

    break;

    case 'monitor_pengadaan':

    switch ($param2) {

     case 'lihat':
     $this->lihat_tender_pengadaan();
     break;

     case 'lihat_permintaan':
     $this->lihat_pr();
     break;

     default:
     $this->monitor_pengadaan();
     break;

   }

   break;

   case 'e_auction':

   switch ($param2) {

    case 'proses':
    $this->process_eauction($param3);
    break;

    case 'hapus':
    $this->delete_eauction($param3);
    break;

    default:
    $this->list_eauction();
    break;

  }

  break;

  default:
  $this->monitor_pengadaan();
  break;

}

}

public function template_evaluasi($param1 = "",$param2 = ""){

 switch ($param1) {

   case 'buat':
   $this->pembuatan_template_evaluasi();
   break;

   case 'lihat':
   $this->lihat_template_evaluasi();
   break;

   case 'ubah':
   $this->ubah_template_evaluasi();
   break;

   case 'hapus':
   $this->hapus_template_evaluasi();
   break;

   case 'picker':
   $this->picker_template_evaluasi();
   break;

   default:
   $this->daftar_template_evaluasi();
   break;

 }

}

public function daftar_pekerjaan($param1 = "" ,$param2 = ""){

  switch ($param1) {

    case 'proses':
    $this->ubah_permintaan_pengadaan();
    break;

    case 'proses_tender':
    $this->ubah_tender_pengadaan();
    break;

    default:
    include("procurement/daftar_pekerjaan/daftar_pekerjaan.php");
    break;

  }
  
}

public function data_riwayat_eauction(){
  include("procurement/eauction/data_riwayat.php");
}


public function data_chat(){
  include("procurement/proses_pengadaan/data_chat.php");
}

public function picker_item_proc(){
  include("procurement/procurement_tools/picker_item_proc.php");
}

public function data_item_proc(){
  include("procurement/procurement_tools/data_item_proc.php");
}

public function data_penawaran(){
  include("procurement/proses_pengadaan/data_penawaran.php");
}

public function data_message(){
  include("procurement/proses_pengadaan/data_message.php");
}

public function lihat_penawaran($id){
  include("procurement/proses_pengadaan/lihat_penawaran.php");
}

public function lihat_penawaran_hist($id){
  include("procurement/proses_pengadaan/lihat_penawaran_hist.php");
}

public function data_panitia_pengadaan(){
  include("procurement/panitia_pengadaan/data_panitia_pengadaan.php");
}

public function data_vendor_tender(){
  include("procurement/proses_pengadaan/data_vendor_tender.php");
}

public function sendaanwijzing(){
  include("procurement/aanwijzing_online/sendaanwijzing.php");
}


public function save_vadm(){
  include("procurement/proses_pengadaan/save_vadm.php");
}

public function lihat_sanggahan(){
  include("procurement/sanggahan/lihat_sanggahan.php");
}

public function save_sanggahan(){
  include("procurement/sanggahan/save_sanggahan.php");
}

public function data_anggota_panitia_pengadaan(){
  include("procurement/panitia_pengadaan/data_anggota_panitia_pengadaan.php");
}

public function save_eval_com(){
  include("procurement/proses_pengadaan/save_eval_com.php");
}

public function verifikasi_vendor(){
  include("procurement/proses_pengadaan/verifikasi_vendor.php");
}

public function data_vendor_tender_view(){
  include("procurement/proses_pengadaan/data_vendor_tender_view.php");
}

public function picker_sanggahan(){
  include("procurement/sanggahan/picker_sanggahan.php");
}

public function data_sanggahan(){
  include("procurement/sanggahan/data_sanggahan.php");
}

public function picker_panitia_pengadaan(){
  include("procurement/panitia_pengadaan/picker_panitia_pengadaan.php");
}

public function ubah_tanggal(){
  include("procurement/proses_pengadaan/ubah_tanggal.php");
}
public function submit_ubah_tanggal(){
  include("procurement/proses_pengadaan/submit_ubah_tanggal.php");
}

public function ubah_lampiran(){
  include("procurement/proses_pengadaan/ubah_lampiran.php");
}
public function submit_ubah_lampiran(){
  include("procurement/proses_pengadaan/submit_ubah_lampiran.php");
}

public function ubah_hps(){
  include("procurement/proses_pengadaan/ubah_hps.php");
}
public function submit_ubah_hps(){
  include("procurement/proses_pengadaan/submit_ubah_hps.php");
}

public function pembatalan_pengadaan(){
  include("procurement/proses_pengadaan/pembatalan_pengadaan.php");
}

public function submit_pembatalan_pengadaan(){
  include("procurement/proses_pengadaan/submit_pembatalan_pengadaan.php");
}


public function submit_pembuatan_template_evaluasi(){
  include("procurement/template_evaluasi/submit_pembuatan_template_evaluasi.php");
}

public function submit_ubah_template_evaluasi(){
  include("procurement/template_evaluasi/submit_ubah_template_evaluasi.php");
}

public function hapus_template_evaluasi(){
  include("procurement/template_evaluasi/hapus_template_evaluasi.php");
}

public function data_monitor_pengadaan(){
  include("procurement/procurement_tools/data_monitor_pengadaan.php");
}

public function monitor_pengadaan(){
  include("procurement/procurement_tools/monitor_pengadaan.php");
}

public function data_monitor_pr(){
  include("procurement/procurement_tools/data_monitor_pr.php");
}

public function monitor_pr(){
  include("procurement/procurement_tools/monitor_pr.php");
}

public function data_pekerjaan_pr(){
  include("procurement/daftar_pekerjaan/data_pekerjaan_pr.php");
}

public function data_pekerjaan_rfq(){
  include("procurement/daftar_pekerjaan/data_pekerjaan_rfq.php");
}


public function ubah_template_evaluasi(){
  include("procurement/template_evaluasi/ubah_template_evaluasi.php");
}

public function lihat_template_evaluasi(){
  include("procurement/template_evaluasi/lihat_template_evaluasi.php");
}

public function data_template_evaluasi(){
  include("procurement/template_evaluasi/data_template_evaluasi.php");
}

public function perencanaan_pengadaan_picker(){
  include("procurement/perencanaan_pengadaan/picker_perencanaan_pengadaan.php");
}

public function picker_template_evaluasi(){
  include("procurement/template_evaluasi/picker_template_evaluasi.php");
}


public function data_mata_anggaran(){
  include("procurement/mata_anggaran/data_mata_anggaran.php");
}

public function pembuatan_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/pembuatan_perencanaan_pengadaan.php");
}

public function ubah_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/ubah_perencanaan_pengadaan.php");
}

public function submit_pembuatan_perencanaan_pengadaan(){

  include("procurement/perencanaan_pengadaan/submit_pembuatan_perencanaan_pengadaan.php");
}

public function submit_ubah_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/submit_ubah_perencanaan_pengadaan.php");
}

public function daftar_rekapitulasi_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/daftar_rekapitulasi_perencanaan_pengadaan.php");
}

public function submit_approval_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/submit_approval_perencanaan_pengadaan.php");
}

public function daftar_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan.php");
}
public function update_daftar_perencanaan(){
  include("procurement/perencanaan_pengadaan/update_daftar_perencanaan.php");
}

public function daftar_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/daftar_permintaan_pengadaan.php");
}

public function approval_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/approval_perencanaan_pengadaan.php");
}

public function data_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/data_perencanaan_pengadaan.php");
}

public function data_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/data_permintaan_pengadaan.php");
}

public function lihat_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/lihat_perencanaan_pengadaan.php");
}

public function lihat_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/lihat_permintaan_pengadaan.php");
}

public function view_aanwijzing_online(){
  include("procurement/aanwijzing_online/view_aanwijzing_online.php");
}

public function lihat_tender_pengadaan(){
  include("procurement/procurement_tools/lihat_tender_pengadaan.php");
}

public function lihat_pr(){
  include("procurement/procurement_tools/lihat_pr.php");
}

public function alias_perencanaan_pengadaan(){
  include("procurement/perencanaan_pengadaan/alias_perencanaan_pengadaan.php");
}

public function alias_sanggahan(){
  include("procurement/sanggahan/alias_sanggahan.php");
}

public function alias_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/alias_permintaan_pengadaan.php");
}

public function pembuatan_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/pembuatan_permintaan_pengadaan.php");
}
public function submit_ubah_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/submit_ubah_permintaan_pengadaan.php");
}

public function ubah_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/ubah_permintaan_pengadaan.php"); 
}

public function submit_ubah_tender_pengadaan(){
  include("procurement/proses_pengadaan/submit_ubah_tender_pengadaan.php");
}

public function ubah_tender_pengadaan(){
  include("procurement/proses_pengadaan/ubah_tender_pengadaan.php"); 
}

public function submit_pembuatan_permintaan_pengadaan(){
  include("procurement/proses_pengadaan/submit_pembuatan_permintaan_pengadaan.php");
}

public function daftar_template_evaluasi(){
  include("procurement/template_evaluasi/daftar_template_evaluasi.php");
}

public function pembuatan_template_evaluasi(){
  include("procurement/template_evaluasi/pembuatan_template_evaluasi.php");
}

public function update_procurement($function_name = "",$title = ""){
  include("procurement/procurement_tools/update_procurement.php");
}

public function evaluasi_teknis(){
  include("procurement/proses_pengadaan/evaluasi_teknis.php");
}

public function evaluasi_harga(){
  include("procurement/proses_pengadaan/evaluasi_harga.php");
}

public function data_eval_com(){
  include("procurement/proses_pengadaan/data_eval_com.php");
}

public function calculate_eval_tech(){
  include("procurement/proses_pengadaan/calculate_eval_tech.php");
}

public function calculate_eval_price(){
  include("procurement/proses_pengadaan/calculate_eval_price.php");
}

public function load_evaluation(){
  include("procurement/proses_pengadaan/load_evaluation.php");
}


public function list_mata_anggaran(){
  include("procurement/mata_anggaran/mata_anggaran.php");
}

/*
public function data_mata_anggaran(){ 
  include ("procurement/mata_anggaran/data_mata_anggaran.php");
}
*/

public function alias_mata_anggaran(){ 
  include ("procurement/mata_anggaran/alias_mata_anggaran.php");
}

public function add_mata_anggaran(){ 
  include ("procurement/mata_anggaran/add_mata_anggaran.php");
}

public function submit_add_mata_anggaran(){ 
  include ("procurement/mata_anggaran/submit_add_mata_anggaran.php");
}

public function edit_mata_anggaran($id){ 
  include ("procurement/mata_anggaran/edit_mata_anggaran.php");
}

public function submit_edit_mata_anggaran(){ 
  include ("procurement/mata_anggaran/submit_edit_mata_anggaran.php");
}

public function delete_mata_anggaran($id){ 
  include ("procurement/mata_anggaran/delete_mata_anggaran.php");
}


public function panitia_pengadaan(){
  include("procurement/panitia_pengadaan/panitia_pengadaan.php");
}

public function add_panitia_pengadaan(){ 
  include ("procurement/panitia_pengadaan/add_panitia_pengadaan.php");
}
public function edit_panitia_pengadaan($id){ 
  include ("procurement/panitia_pengadaan/edit_panitia_pengadaan.php");
}

public function submit_add_panitia_pengadaan(){ 
  include ("procurement/panitia_pengadaan/submit_add_panitia_pengadaan.php");
}

public function submit_edit_panitia_pengadaan(){ 
  include ("procurement/panitia_pengadaan/submit_edit_panitia_pengadaan.php");
}

public function delete_panitia_pengadaan($id){ 
  include ("procurement/panitia_pengadaan/delete_panitia_pengadaan.php");
}

public function add_panitia_detail($id){ 
  include ("procurement/panitia_pengadaan/add_panitia_detail.php");
}

public function submit_panitia_detail(){ 
  include ("procurement/panitia_pengadaan/submit_panitia_detail.php");
}

public function data_panitia_detail(){ 
  include ("procurement/panitia_pengadaan/data_panitia_detail.php");
}

public function delete_panitia_detail($id){ 
  include ("procurement/panitia_pengadaan/delete_panitia_detail.php");
}

public function list_eauction(){ 
  include ("procurement/eauction/list.php");
}

public function process_eauction($id){ 
  include ("procurement/eauction/form.php");
}

public function delete_eauction($id){ 
  include ("procurement/eauction/delete.php");
}

public function picker_eauction(){ 
  include ("procurement/eauction/picker.php");
}

public function submit_eauction(){ 
  include ("procurement/eauction/submit.php");
}

public function data_eauction(){ 
  include ("procurement/eauction/data.php");
}

public function remove_vendor(){ 
  include ("procurement/procurement_tools/remove_vendor.php");
}

public function eauction_list(){
  include ("procurement/eauction/list_all.php");
}

public function data_aanwijzing_online(){
  include ("procurement/aanwijzing_online/data_aanwijzing_online.php");
}

public function proses_aanwijzing_online($id = ""){
  include ("procurement/aanwijzing_online/proses_aanwijzing_online.php");
}

//haqim
public function data_employee_chat(){
  include("procurement/proses_pengadaan/data_employee_chat.php");
}

public function submit_chat_pr(){
  include("procurement/proses_pengadaan/submit_chat_pr.php");
}

public function chat_pr(){
  include("procurement/proses_pengadaan/chat_pr.php");
}

public function chat_rfq(){
  include("procurement/proses_pengadaan/chat_rfq.php");
}

public function submit_chat_rfq(){
  include("procurement/proses_pengadaan/submit_chat_rfq.php");
}
//end

}
