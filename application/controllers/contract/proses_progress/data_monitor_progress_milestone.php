<?php

$get = $this->input->get();

$param1 = $this->uri->segment(3, 0);

$param2 = $this->uri->segment(4, 0);

$userdata = $this->data['userdata'];

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

if(!empty($param1) && $param1 == "active"){
  $this->db->where("c.progress_status",null);
}

if(!empty($param2)){
  $this->db->where("type_inv",$param2);
}

$this->db->select("progress_id")
->join("ctr_contract_milestone c","c.milestone_id=b.milestone_id")
->join("ctr_contract_header a","a.contract_id=c.contract_id");

$data['total'] = $this->db->get("ctr_contract_milestone_progress b")->num_rows();

if(!empty($param1) && $param1 == "active"){
  $this->db->where("c.progress_status",null);
}

if(!empty($param2)){
  $this->db->where("type_inv",$param2);
}

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

$this->db->select("b.*,a.contract_number,
  CASE c.progress_status 
      WHEN 1 THEN 'Menunggu Persetujuan PIC User' 
      WHEN 2 THEN 'Menunggu Persetujuan Manajer User'
      WHEN 3 THEN 'Menunggu Persetujuan VP USER'
      WHEN 4 THEN 'Menunggu Persetujuan PIC BAST'
      WHEN 5 THEN 'Menunggu Persetujuan Manajer BAST'
      WHEN 6 THEN 'Finalisasi Persetujuan VP BAST'
      WHEN 99 THEN 'Revisi'
  ELSE 'Aktif' END AS activity,vendor_name,bastp_number
  ");
$this->db
->join("ctr_contract_milestone c","c.milestone_id=b.milestone_id")
->join("ctr_contract_header a","a.contract_id=c.contract_id");

$rows = $this->db->get("ctr_contract_milestone_progress b")->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);