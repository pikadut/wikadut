<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$ptm_number = $this->session->userdata("rfq_id");

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(id)",$search);
  $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_requester_name)",$search);
  $this->db->or_like("LOWER(ptm_requester_pos_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

$data['total'] = $this->db->select("vendor_name,tgl_bid,jumlah_bid")->where("ppm_id",$ptm_number)
->join("vnd_header b","b.vendor_id=a.vendor_id")
->get("prc_eauction_history a")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(id)",$search);
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

$rows = $this->db->select("vendor_name,tgl_bid,jumlah_bid")->where("ppm_id",$ptm_number)
->join("vnd_header b","b.vendor_id=a.vendor_id")
->get("prc_eauction_history a")->result_array();

foreach ($rows as $key => $value) {
  $rows[$key]['tgl_bid'] = date("d/m/Y H:i:s",strtotime($rows[$key]['tgl_bid']));
  $rows[$key]['jumlah_bid'] = inttomoney($rows[$key]['jumlah_bid']);
}

$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));