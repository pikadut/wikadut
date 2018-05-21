<?php

$this->load->model("Procrfq_m");

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "pvs_vendor_code";

$selection = $this->data['selection_vendor_tender'];
$rfq_id = $this->session->userdata("rfq_id");

$proc = $this->db->where("ptm_number",$rfq_id)->get("prc_tender_prep")->row_array();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_where("pvs_vendor_code",$search);
  $this->db->group_end();
}

if(!empty($rfq_id)){
  $this->db->where("ptm_number",$rfq_id);
}

if($proc['ptp_prequalify'] == 2){
  $this->db->where("pvs_pq_passed",1);
}

$this->db->distinct()->select("pvs_vendor_code");

$data['total'] = $this->Procrfq_m->getVendorBidderRFQ($id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_where("pvs_vendor_code",$search);
  $this->db->group_end();
}

if(!empty($rfq_id)){
  $this->db->where("ptm_number",$rfq_id);
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if($proc['ptp_prequalify'] == 2){
  $this->db->where("pvs_pq_passed",1);
}

$this->db->distinct();

$rows = $this->Procrfq_m->getVendorBidderRFQ($id)->result_array();


$klasifikasi = array("K"=>"Kecil","M"=>"Menengah","B"=>"Besar");

foreach ($rows as $key => $value) {
  $rows[$key]['vendor_name'] = "<a href='".site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$rows[$key]['pvs_vendor_code'])."' target='_blank'>".$rows[$key]['vendor_name']."</a>";
  $rows[$key]['fin_class'] = (isset($klasifikasi[$rows[$key]['fin_class']])) ? $klasifikasi[$rows[$key]['fin_class']] : "-";
}

$data['rows'] = $rows;

echo json_encode($data);
