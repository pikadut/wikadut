<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$ptm_number = $this->session->userdata("rfq_id");

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : $ptm_number;
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "pcl_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pcl_title)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_where("pcl_id",$search);
  $this->db->group_end();
}

if($filtering === "new"){
  $this->db->where(array("pcl_jwb_judul"=>null,"pcl_jwb_isi"=>null));
}

$data['total'] = $this->Procrfq_m->getClaimRFQ($ptm_number)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pcl_title)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_where("pcl_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}


if($filtering === "new"){
  $this->db->where(array("pcl_jwb_judul"=>null,"pcl_jwb_isi"=>null));
}


$rows = $this->Procrfq_m->getClaimRFQ($ptm_number)->result_array();


foreach ($rows as $key => $value) {

  $rows[$key]['pcl_created_date'] = date($this->data['date_format'],strtotime($rows[$key]['pcl_created_date']));
  $rows[$key]['current_approver_pos_name'] = $this->Administration_m->getPos($rows[$key]['current_approver_pos'])->row()->pos_name;

}


$data['rows'] = $rows;

echo json_encode($data);
