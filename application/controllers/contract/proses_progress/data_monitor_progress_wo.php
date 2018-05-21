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

$this->db->select("progress_id")

->join("ctr_po_header c","c.po_id=b.po_id")
->join("ctr_contract_header a","a.contract_id=c.contract_id");

if(!empty($param1) && $param1 == "active"){
  $this->db->where("b.status",null);
}

if(!empty($param2)){
  $this->db->where("type_inv",$param2);
}

$data['total'] = $this->db->get("ctr_po_progress_header b")->num_rows();

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

if(!empty($param1) && $param1 == "active"){
  $this->db->where("b.status",null);
}

if(!empty($param2)){
  $this->db->where("type_inv",$param2);
}

$this->db->select("b.*,c.po_number,
  CASE b.status 
      WHEN 1 THEN 'Menunggu Persetujuan PIC User' 
      WHEN 2 THEN 'Menunggu Persetujuan Manajer User'
      WHEN 3 THEN 'Menunggu Persetujuan VP USER'
      WHEN 4 THEN 'Menunggu Persetujuan PIC BAST'
      WHEN 5 THEN 'Menunggu Persetujuan Manajer BAST'
      WHEN 6 THEN 'Finalisasi Persetujuan VP BAST'
      WHEN 99 THEN 'Revisi'
  ELSE 'Aktif' END AS activity,bastp_number,pos_name
  ")
->join("ctr_po_header c","c.po_id=b.po_id")
->join("ctr_contract_header a","a.contract_id=c.contract_id");
$this->db->join("adm_pos","b.current_approver_pos=pos_id","left");
$rows = $this->db->get("ctr_po_progress_header b")->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
