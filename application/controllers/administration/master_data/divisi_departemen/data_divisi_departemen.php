<?php 

$get = $this->input->get();

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "dep_code";
$kantor = (isset($get['kantor']) && !empty($get['kantor'])) ? $get['kantor'] : null;

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(dep_code)",$search);
  $this->db->or_like("LOWER(dept_name)",$search);
  $this->db->or_like("LOWER(district_name)",$search);
  $this->db->group_end();
}

if(!empty($kantor)){
  $this->db->where("district_id",$kantor);
}

$data['total'] = $this->Administration_m->get_divisi_departemen()->num_rows();

//echo $this->db->last_query();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(dep_code)",$search);
  $this->db->or_like("LOWER(dept_name)",$search);
  $this->db->or_like("LOWER(district_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if(!empty($kantor)){
  $this->db->where("district_id",$kantor);
}

$rows = $this->Administration_m->get_divisi_departemen()->result_array();

$status = array(0=>"Nonaktif",1=>"Aktif");

foreach ($rows as $key => $value) {
  
  $rows[$key]['dept_active'] = (isset($status[$rows[$key]['dept_active']])) ? $status[$rows[$key]['dept_active']] : "-";

  }

$data['rows'] = $rows;

echo json_encode($data);