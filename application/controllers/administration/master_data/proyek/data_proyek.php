<?php 

$get = $this->input->get();
$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(project_name)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->or_like("LOWER(date_start)",$search);
  $this->db->or_like("LOWER(date_end)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("id",$id);
}
$disabled = 1;
// $this->db->where("code_cc",$userdata['dept_code']);
if (!empty($picker)) {
  $this->db->where('status', "aktif");
}
$this->db->where("disabled !=", $disabled);
$data['total'] = $this->db->get("vw_adm_project_list")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(project_name)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->or_like("LOWER(date_start)",$search);
  $this->db->or_like("LOWER(date_end)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("id",$id);
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

// $this->db->where("code_cc",$userdata['dept_code']);

// $this->db->join("adm_dept","dept_id=dept_cc","left");
if (!empty($picker)) {
  $this->db->where('status', "aktif");
}
$this->db->where("disabled !=", $disabled);
$rows = $this->db->get("vw_adm_project_list")->result_array();

foreach ($rows as $key => $value) {
  
}

$data['rows'] = $rows;
// echo $this->db->last_query();
$this->output
->set_content_type('application/json')
->set_output(json_encode($data));
ob_flush();