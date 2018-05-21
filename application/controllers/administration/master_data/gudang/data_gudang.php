<?php 

$get = $this->input->get();

$kantor = (isset($get['kantor']) && !empty($get['kantor'])) ? $get['kantor'] : "";

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "code_war";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(code_war)",$search);
  $this->db->or_like("LOWER(name_war)",$search);
  $this->db->or_like("LOWER(location_war)",$search);
  $this->db->group_end();
}

if(!empty($kantor)){
  $this->db->where("district_war",$kantor);
}

$data['total'] = $this->db->get("adm_warehouse")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(code_war)",$search);
  $this->db->or_like("LOWER(name_war)",$search);
  $this->db->or_like("LOWER(location_war)",$search);
  $this->db->group_end();
}

if(!empty($kantor)){
  $this->db->where("district_war",$kantor);
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->join("adm_district","district_war=district_id","left");

$rows = $this->db->get("adm_warehouse")->result_array();

foreach ($rows as $key => $value) {
  
}

$data['rows'] = $rows;

echo json_encode($data);