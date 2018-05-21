<?php 

$get = $this->input->get();

$userdata = $this->Administration_m->getLogin();

$pos_id = (isset($get['pos_id'])) ? $get['pos_id'] : "";

$job_title = (isset($get['job_title'])) ? str_replace("_", " ", $get['job_title']) : "";

$district_id = (isset($get['district_id'])) ? str_replace("_", " ", $get['district_id']) : $userdata['district_id'];

$dept_id = (isset($get['dept_id'])) ? str_replace("_", " ", $get['dept_id']) : "";

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "employee_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(complete_name)",$search);
  $this->db->or_like("LOWER(user_name)",$search);
  $this->db->or_like("LOWER(job_title)",$search);
  $this->db->or_like("LOWER(pos_name)",$search);
  $this->db->group_end();
}

if(!empty($pos_id)){
  $this->db->where("pos_id",$pos_id);
}

if(!empty($dept_id)){
  $this->db->where("dept_id",$dept_id);
}

if(!empty($district_id)){
  $this->db->where("district_id",$district_id);
}

if(!empty($job_title)){
  $this->db->where("job_title",$job_title);
}

$data['total'] = $this->Administration_m->getUserRule()->num_rows();

if(!empty($pos_id)){
  $this->db->where("pos_id",$pos_id);
}

if(!empty($district_id)){
  $this->db->where("district_id",$district_id);
}

if(!empty($job_title)){
  $this->db->where("job_title",$job_title);
}

if(!empty($dept_id)){
  $this->db->where("dept_id",$dept_id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(complete_name)",$search);
  $this->db->or_like("LOWER(user_name)",$search);
  $this->db->or_like("LOWER(job_title)",$search);
  $this->db->or_like("LOWER(pos_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Administration_m->getUserRule()->result_array();

foreach ($rows as $key => $value) {
  
}

$data['rows'] = $rows;

echo json_encode($data);