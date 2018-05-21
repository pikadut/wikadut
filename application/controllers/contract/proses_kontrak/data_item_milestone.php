<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "contract_item_id";

$contract_id = $this->session->userdata("contract_id");

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Contract_m->getItem(null,$contract_id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select("contract_item_id as id,short_description as deskripsi,price as harga_satuan,qty as jumlah,item_code as kode,max_qty as order_maksimum, min_qty as order_minimum, uom as satuan");

$rows = $this->Contract_m->getItem(null,$contract_id)->result_array();

foreach ($rows as $key => $value) {
  $rows[$key]['jumlah'] = inttomoney($rows[$key]['jumlah']);
  $rows[$key]['harga_satuan'] = inttomoney($rows[$key]['harga_satuan']);
  $rows[$key]['order_maksimum'] = inttomoney($rows[$key]['order_maksimum']);
  $rows[$key]['order_minimum'] = inttomoney($rows[$key]['order_minimum']);
}

$data['rows'] = $rows;

echo json_encode($data);