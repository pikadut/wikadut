<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$officer = $this->Administration_m->getPosition();

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ammend_id";


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(B.ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(B.vendor_name)",$search);
  $this->db->or_where("ammend_id",$search);
  $this->db->group_end();
}

$data['total'] = $this->Addendum_m->getData($id)->num_rows();


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(B.ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(B.vendor_name)",$search);
  $this->db->or_where("ammend_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Addendum_m->getData($id)->result_array();


$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {
  $act = $this->Workflow_m->getActivity($rows[$key]['status'])->row_array();
  $act = (isset($act['awa_name']) && !empty($act['awa_name'])) ? $act['awa_name'] : "";
  $rows[$key]['activity'] = $act;
}

$data['rows'] = $rows;

echo json_encode($data);
