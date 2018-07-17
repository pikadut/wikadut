<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$dept = $this->Administration_m->getDeptUser();

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "pr_number";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER('nilai')",$search);
  $this->db->or_like("LOWER(pr_requester_pos_name)",$search);
  $this->db->or_where("pr_number",$search);
  $this->db->group_end();
}

// $this->db->where_in("pr_dept_id",$dept);
if ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' ) {
  $this->db->where_in("pr_dept_id",$userdata['dept_id']);
}

$data['total'] = $this->Procpr_m->getPR($id)->num_rows();


// $this->db->where_in("pr_dept_id",$dept);
if ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' ) {
  $this->db->where_in("pr_dept_id",$userdata['dept_id']);
}

if(!empty($search)){
  $this->db->group_start();
  // $this->db->like("LOWER(awa_name)",$search);
  // $this->db->like("LOWER(nilai)",$search);
  $this->db->like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_dept_name)",$search);
  $this->db->or_like("LOWER('nilai')",$search);
  $this->db->or_like("LOWER(status)",$search);
  // $this->db->or_where("pr_number",$search);
  $this->db->or_like("pr_number",$search);

  $this->db->group_end(); 
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}


$rows = $this->Procpr_m->getPR($id)->result_array();

$selection = $this->data['selection_permintaan_pengadaan'];

$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['pr_number'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['mata_anggaran'] = $rows[$key]['pr_mata_anggaran']." - ".$rows[$key]['pr_nama_mata_anggaran'];
  $rows[$key]['sub_mata_anggaran'] = $rows[$key]['pr_sub_mata_anggaran']." - ".$value['pr_nama_sub_mata_anggaran'];
}

$data['rows'] = $rows;

echo json_encode($data);
