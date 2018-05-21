<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "milestone_id";

if(!empty($userdata['pos_id'])){
  $this->db->group_start();
  $this->db->where("c.current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("c.current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("milestone_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("milestone_id",$search);
  $this->db->group_end();
}

$this->db
->select("milestone_id")
->join("ctr_contract_header a","a.contract_id=c.contract_id");

$data['total'] = $this->db->get("ctr_contract_milestone c")->num_rows();

if(!empty($userdata['pos_id'])){
  $this->db->group_start();
  $this->db->where("c.current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("c.current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("milestone_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("milestone_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select("milestone_id,description,percentage,a.contract_number,
  CASE c.bastp_status 
      WHEN 1 THEN 'Persetujuan BAST Milestone'  
      WHEN 2 THEN 'Persetujuan BAST Milestone' 
      WHEN 3 THEN 'Persetujuan BAST Milestone' 
      WHEN 4 THEN 'Persetujuan BAST Milestone' 
      WHEN 5 THEN 'Persetujuan BAST Milestone' 
      WHEN 6 THEN 'Persetujuan BAST Milestone' 
      WHEN 99 THEN 'Revisi'
  ELSE 'Aktif' END AS activity,vendor_name
  ")
->join("ctr_contract_header a","a.contract_id=c.contract_id");
$rows = $this->db->get("ctr_contract_milestone c")->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
  