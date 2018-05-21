<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "exchange_rate_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(curr_from)",$search);
  $this->db->or_like("LOWER(curr_to)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Administration_m->getExchangeRate()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(curr_from)",$search);
  $this->db->or_like("LOWER(curr_to)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Administration_m->getExchangeRate()->result_array();
echo $this->db->last_query();

foreach ($rows as $key => $value) {

  $rows[$key]["curr_from"] = $this->Administration_m->convert_exchange_rate($rows[$key]["curr_from"]);
  $rows[$key]["curr_to"] = $this->Administration_m->convert_exchange_rate($rows[$key]["curr_to"]);
  
  }

$data['rows'] = $rows;

echo json_encode($data);