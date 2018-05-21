<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pos_name)",$search);
  $this->db->or_like("LOWER(district_name)",$search);
  $this->db->or_like("LOWER(fullname)",$search);
  $this->db->or_like("LOWER(phone)",$search);
  $this->db->or_like("LOWER(employee_type_name)",$search);
  $this->db->group_end();
}

$this->db->select("fullname,email,phone,pos_name,district_name,status,employee_type_name,id");

$data['total'] = $this->Administration_m->employee_view()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pos_name)",$search);
  $this->db->or_like("LOWER(district_name)",$search);
  $this->db->or_like("LOWER(fullname)",$search);
  $this->db->or_like("LOWER(phone)",$search);
  $this->db->or_like("LOWER(employee_type_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select("fullname,email,phone,pos_name,district_name,status,employee_type_name,id");

$rows = $this->Administration_m->employee_view()->result_array();

foreach ($rows as $key => $value) {
  $rows[$key]["status"] = (!empty($rows[$key]["status"])) ? "Aktif" : "Nonaktif";
}

$data['rows'] = $rows;

echo json_encode($data);