<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$ptm_number = $this->session->userdata("ptm_number");

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "tit_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(tit_id)",$search);
  $this->db->or_like("LOWER(tit_code)",$search);
  $this->db->or_like("LOWER(tit_description)",$search);
  $this->db->or_like("LOWER(tit_currency)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Procrfq_m->getItemRFQ($id,$ptm_number)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(tit_code)",$search);
  $this->db->or_like("LOWER(tit_description)",$search);
  $this->db->or_like("LOWER(tit_currency)",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select("tit_id as id,tit_description as deskripsi,tit_price as harga_satuan,tit_quantity as jumlah,tit_code as kode,tit_quantity as order_maksimum, 0 as order_minimum, tit_unit as satuan");

$rows = $this->Procrfq_m->getItemRFQ($id,$ptm_number)->result_array();

foreach ($rows as $key => $value) {
 $rows[$key]['jumlah'] = inttomoney($rows[$key]['jumlah']);
 $rows[$key]['harga_satuan'] = inttomoney($rows[$key]['harga_satuan']);
}

$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));