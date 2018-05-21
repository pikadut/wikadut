<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "mat_group_code";
$parent = (isset($get['parent']) && !empty($get['parent'])) ? $get['parent'] : "";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(group_code)",$search);
  $this->db->or_like("LOWER(group_name)",$search);
  $this->db->group_end();
}

if(!empty($parent)){
	$this->db->where("group_parent", $parent);
}


if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("group_status",null);
}


$data['total'] = $this->Commodity_m->getMatGroup()->num_rows();

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("group_status",null);
}


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(group_code)",$search);
  $this->db->or_like("LOWER(group_name)",$search);
  $this->db->group_end();
}

if(!empty($parent)){
	$this->db->where("group_parent", $parent);
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Commodity_m->getMatGroup()->result_array();

$selection = $this->data['selection_mat_group'];

$status = array("R"=>"Revisi","A"=>"Aktif");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['mat_group_code'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['mat_group_status'] = (isset($status[$rows[$key]['mat_group_status']])) ? $status[$rows[$key]['mat_group_status']] : "Belum Disetujui";
  //$rows[$key]["mat_group_parent"] = $this->Commodity_m->getMatLevelName($rows[$key]["mat_group_parent"]);
  if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_grup_brg/".$rows[$key]["mat_group_code"]);
  }
}

$data['rows'] = $rows;

echo json_encode($data);
