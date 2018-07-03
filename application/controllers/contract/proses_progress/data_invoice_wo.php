<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "po_id";

if(!empty($userdata['pos_id'])){
  $this->db->group_start();
  $this->db->where((int)"c.current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("c.current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("po_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("po_id",$search);
  $this->db->group_end();
}

$this->db
->select("po_id")
->where("COALESCE(invoice_status,null) !=",null)
->join("ctr_contract_header a","a.contract_id=c.contract_id");

$data['total'] = $this->db->get("ctr_invoice_header c")->num_rows();

if(!empty($userdata['pos_id'])){
  $this->db->group_start();
  $this->db->where((int)"c.current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("c.current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("po_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("po_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select("po_id,a.contract_number,c.invoice_number,c.created_date,c.invoice_date,invoice_notes,
  CASE invoice_status 
      WHEN 1 THEN 'Persetujuan INVOICE WO'  
      WHEN 2 THEN 'Persetujuan INVOICE WO' 
      WHEN 3 THEN 'Persetujuan INVOICE WO' 
      WHEN 4 THEN 'Persetujuan INVOICE WO' 
      WHEN 5 THEN 'Persetujuan INVOICE WO' 
      WHEN 6 THEN 'Persetujuan INVOICE WO' 
      WHEN 99 THEN 'Revisi'
  ELSE 'Aktif' END AS activity,c.vendor_name
  ")
->where("COALESCE(invoice_status,null) !=",null)
->join("ctr_contract_header a","a.contract_id=c.contract_id");
$rows = $this->db->get("ctr_invoice_header c")->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
  