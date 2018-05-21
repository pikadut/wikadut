<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ptm_number";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_requester_name)",$search);
  $this->db->or_like("LOWER(ptm_requester_pos_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

// $this->db->where("ptp_eauction",1);
//shantika
$this->db->where("last_status","1100");
//end

$data['total'] = $this->Procrfq_m->getMonitorRFQ($id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_requester_name)",$search);
  $this->db->or_like("LOWER(ptm_requester_pos_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

// $this->db->where("ptp_eauction",1);
//shantika
$this->db->where("last_status","1100");
//end

$rows = $this->Procrfq_m->getMonitorRFQ($id)->result_array();

foreach ($rows as $key => $value) {

  $rows[$key]['mata_anggaran'] = $rows[$key]['ptm_mata_anggaran']." - ".$rows[$key]['ptm_nama_mata_anggaran'];
  $rows[$key]['sub_mata_anggaran'] = $rows[$key]['ptm_sub_mata_anggaran']." - ".$value['ptm_nama_sub_mata_anggaran'];
}

$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));