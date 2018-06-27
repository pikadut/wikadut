<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/detail_tender_pengadaan_v';

$ptm_number = $this->uri->segment(5, 0);

$data['id'] = $ptm_number;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("LUMPSUM"=>"LUMPSUM","HARGA SATUAN"=>"HARGA SATUAN","RENTAL SERVICE"=>"RENTAL SERVICE");

$tender = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$this->db->where("job_title","PELAKSANA PENGADAAN");

$data['pelaksana_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

$data['permintaan'] = $tender;

$activity_id = $tender['last_status'];

$data['activity_id'] = $activity_id;

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$comment = $this->Comment_m->getProcurementRFQActive($ptm_number)->result_array();

$is_user = false;

$employee = $this->data['userdata'];

foreach ($comment as $key => $value) {
	if($value['user_id'] == $employee['employee_id'] && !$is_user){
		$is_user = true;
	}
}

$data['is_user'] = $is_user;

$data["comment_list"][0] = $comment;

$data['document'] = $this->Procrfq_m->getDokumenRFQ("",$ptm_number)->result_array();

$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

if(isset($data['prep']['adm_bid_committee'])){
	$this->session->set_userdata("committee_id",$data['prep']['adm_bid_committee']);
}

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$data['vendor'] = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();

$data['bidder_msg'] = $this->Procrfq_m->getMessageRFQ($ptm_number)->result_array();

$data['evaluation'] = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

$data['penata_perencana'] = $this->Administration_m->getUserByJob("PENATA PERENCANAAN")->result_array();

$data['metode'] = array(0=>"Penunjukkan Langsung",1=>"Pemilihan Langsung",2=>"Pelelangan",3=>"Pembelian Langsung");

$data['sampul'] = array(0=>"1 Sampul",1=>"2 Sampul",2=>"2 Tahap");

$data['redirect_back'] = 'procurement/procurement_tools/monitor_pengadaan';

$vnd = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

$manager_name = (!empty($tender['ptm_man_emp_id'])) ? $this->db->where("id",$tender['ptm_man_emp_id'])->get("adm_employee")->row()->fullname : "";

$data['manager_name'] = $manager_name;

$vendor = array();

foreach ($vnd as $key => $value) {
	$vendor[] = $value['pvs_vendor_code'];
}

$data['vendor_status'] = $vnd;

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

$this->session->set_userdata("uri_string",uri_string());

$this->session->set_userdata("selection_vendor_tender",$vendor);

$this->session->set_userdata("rfq_id",$ptm_number);
//$this->template($view,$activity['awa_name'],$data);
$this->template($view,"Detail Pengadaan (".$activity['awa_name'].")",$data);