<?php

$get = $this->input->get();

$activity = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$ptm_number = $this->session->userdata("rfq_id");

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : $ptm_number;
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "pbm_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pbm_user)",$search);
  $this->db->or_like("LOWER(pbm_message)",$search);
  $this->db->or_where("pbm_id",$search);
  $this->db->group_end();
}


$data['total'] = $this->Procrfq_m->getMessageRFQ($ptm_number,$activity)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pbm_user)",$search);
  $this->db->or_like("LOWER(pbm_message)",$search);
  $this->db->or_where("pbm_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Procrfq_m->getMessageRFQ($ptm_number,$activity)->result_array();


foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

  $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($data));
