<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/ubah_tender_pengadaan_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

$data['id'] = $id;

$data['pos'] = $position;

$this->data['dir'] = PROCUREMENT_TENDER_PENGADAAN_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("LUMPSUM"=>"LUMPSUM","HARGA SATUAN"=>"HARGA SATUAN");

$latest_comment = $this->Comment_m->getProcurementRFQ("",$id)->row_array();

$ptm_number = $latest_comment['tender_id'];

$permintaan = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

$this->db->where("job_title","PELAKSANA PENGADAAN");

$data['pelaksana_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

$data['last_comment'] = $latest_comment;

$data['permintaan'] = $permintaan;

$district_id = $permintaan['ptm_district_id'];

if(empty($district_id)){
  $district_id = $this->data['userdata']['district_id'];
}

$data['district_id'] = $district_id;

$this->session->set_userdata("selection_district",$district_id);

$activity_id = (!empty($latest_comment['activity'])) ? $latest_comment['activity'] : 1001;

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$this->session->set_userdata("activity_id",$activity_id);

$data['activity_id'] = $activity_id;

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = $this->Comment_m->getProcurementRFQActive($ptm_number)->result_array();

$data['document'] = $this->Procrfq_m->getDokumenRFQ("",$ptm_number)->result_array();

$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$manager_name = (!empty($permintaan['ptm_man_emp_id'])) ? $this->db->where("id",$permintaan['ptm_man_emp_id'])->get("adm_employee")->row()->fullname : "-";

$data['manager_name'] = $manager_name;

$pemb_dok_pen = $data['prep']['ptp_doc_open_date'];

if($activity_id == 1090 && strtotime($pemb_dok_pen) > time()){
  $this->setMessage("Belum saatnya pembukaan dokumen penawaran");
  redirect(site_url("procurement/daftar_pekerjaan"));
}

$id_panitia = $data['prep']['adm_bid_committee'];

if(!empty($data['prep'])){

  if($activity_id == 1090){
    $prebid = strtotime($data['prep']['ptp_prebid_date']);
    if($prebid > time()){
     $this->noAccess("Belum saatnya pembukaan penawaran.");
   }
 }

 if($activity_id == 1000){
  $bid = strtotime($data['prep']['ptp_quot_opening_date']);
  if($bid > time()){
    $this->noAccess("Belum saatnya evaluasi penawaran.");
  }
}

if($activity_id == 1114){
  $aanwijzing2 = strtotime($data['prep']['ptp_tgl_aanwijzing2']);
  if($aanwijzing2 > time()){
    $this->noAccess("Belum saatnya aanwijzing tahap 2.");
  }
}

}

$data['panitia'] = array();

if(!empty($id_panitia)){
  $this->load->model("Procpanitia_m");
  $data['panitia'] = $this->Procpanitia_m->getPanitia($id_panitia)->row_array();
}

$this->db->where("job_title","MANAJER PENGADAAN");
$data['manajer_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

//if(isset($data['prep']['adm_bid_committee'])){
$this->session->set_userdata("committee_id",$id_panitia);
//}


$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$vnd = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();
$temp = array();
foreach ($vnd as $key => $value) {
  $temp[$value['vendor_id']] = $value;
}

//$data['bidder_msg'] = $this->Procrfq_m->getMessageRFQ($ptm_number)->result_array();

$data['evaluation'] = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

$data['penata_perencana'] = $this->Administration_m->getUserByJob("PENATA PERENCANAAN")->result_array();

//$data['metode'] = array(0=>"Penunjukkan Langsung",1=>"Pemilihan Langsung",2=>"Pelelangan",3=>"Pembelian Langsung");

$data['metode'] = array(0=>"Penunjukkan Langsung",1=>"Pemilihan Langsung",2=>"Pelelangan");

$data['sampul'] = array(0=>"1 Sampul",1=>"2 Sampul",2=>"2 Tahap");

$vnd = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

$this->session->unset_userdata("selection_vendor_tender");

$vendor = array();

foreach ($vnd as $key => $value) {
  if($value['pvs_status'] > 0){
   $vendor[] = $value['pvs_vendor_code'];
 } else {
  unset($temp[$value['pvs_vendor_code']]);
}
}

$data['vendor_status'] = $vnd;
$data['vendor'] = $temp;
$data['vendor_aanwijzing'] = array();
$data['user_aanwijzing'] = array();
$userdata = $this->data['userdata'];

if(!empty($vendor)){

  $this->load->model("Vendor_m");

  $this->db
  ->select("vendor_id,vendor_name")
  ->distinct()
  ->where_in((int)"status",array(5,9))
  ->where("pvs_status >",0)
  ->where_in("vendor_id",$vendor)
  ->join("prc_tender_vendor_status","pvs_vendor_code=vendor_id","left")
  ->join("z_bidder_status","lkp_id=pvs_status","left"); 

    $vendor_aanwijzing = $this->Vendor_m->getBidderList()->result_array();

    $data['vendor_aanwijzing'] = $vendor_aanwijzing;

  foreach ($vendor_aanwijzing as $key => $value) {
    $data['user_aanwijzing'][$value['vendor_name']] = "Offline";
  }

  $this->session->set_userdata("selection_vendor_tender",$vendor);

}

$status_aanwijzing = $this->db->where(array(
  "key_ac"=>"0-".$ptm_number,
  ))->order_by("datetime_ac","asc")->get("adm_chat")
->result_array();


foreach ($status_aanwijzing as $key => $value) {
  $data['user_aanwijzing'][$value['name_ac']] = (!empty($value['message_ac'])) ? $value['message_ac'] : "Offline";
}

$nama_user = $userdata['complete_name'];
if(!isset($data['user_aanwijzing'][$nama_user])){
  $data['user_aanwijzing'][$nama_user] = "Offline";
}


$data['chat_aanwijzing'] = $this->db->where("key_ac","1-".$ptm_number)->get("adm_chat")
->result_array();
$data['chat_eauction'] = $this->db->where("key_ac","2-".$ptm_number)->get("adm_chat")
->result_array();

$this->session->set_userdata("rfq_id",$ptm_number);
//$this->template($view,$activity['awa_name'],$data);
$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);