<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$x = $this->session->userdata("selected_progress");

$exp = explode("_", $x);

$type = $exp[0];

$progress_id = $exp[1];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "progress_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("progress_id",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("c.po_item_id",$id);
}

if(!empty($progress_id) && $type == "wo"){
  $this->db->where("progress_id",$progress_id);
} else {
  $this->db->where("progress_id","");
}

$this->db->select("c.po_item_id as id")
->join("ctr_po_item c","c.po_item_id=b.po_item_id")
->join("ctr_contract_item a","a.contract_item_id=c.contract_item_id","left")
->order_by("progress_item_id","desc");
$data['total'] = $this->db->get("ctr_po_progress_item b")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("progress_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if(!empty($progress_id) && $type == "wo"){
  $this->db->where("progress_id",$progress_id);
} else {
  $this->db->where("progress_id","");
}

if(!empty($id)){
  $this->db->where("c.po_item_id",$id);
}

$this->db->select("c.po_item_id as id,c.item_code as kode,c.short_description as deskripsi, c.uom as satuan, c.price as harga_satuan, approved_qty as jumlah, a.min_qty as order_minimum, a.max_qty as order_maksimum")
->join("ctr_po_item c","c.po_item_id=b.po_item_id")
->join("ctr_contract_item a","a.contract_item_id=c.contract_item_id","left")
->order_by("progress_item_id","desc");
$rows = $this->db->get("ctr_po_progress_item b")->result_array();

foreach ($rows as $key => $value) {
  $rows[$key]['harga_satuan'] = inttomoney($value['harga_satuan']);
  $rows[$key]['jumlah'] = inttomoney($value['jumlah']);
  $rows[$key]['order_maksimum'] = inttomoney($value['order_maksimum']);
  $rows[$key]['order_minimum'] = inttomoney($value['order_minimum']);
}

$data['rows'] = $rows;

echo json_encode($data);
