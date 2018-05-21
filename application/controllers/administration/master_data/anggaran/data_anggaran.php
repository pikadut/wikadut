<?php 

$get = $this->input->get();
$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id_cc";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(name_cc)",$search);
  $this->db->or_like("LOWER(code_cc)",$search);
  $this->db->or_like("LOWER(subname_cc)",$search);
  $this->db->or_like("LOWER(subcode_cc)",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("id_cc",$id);
}

$this->db->where("code_cc",$userdata['dept_code']);

$data['total'] = $this->db->get("adm_cost_center")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(name_cc)",$search);
  $this->db->or_like("LOWER(code_cc)",$search);
  $this->db->or_like("LOWER(subname_cc)",$search);
  $this->db->or_like("LOWER(subcode_cc)",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("id_cc",$id);
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where("code_cc",$userdata['dept_code']);

$this->db->join("adm_dept","dept_id=dept_cc","left");

$rows = $this->db->get("adm_cost_center")->result_array();

foreach ($rows as $key => $value) {
  
}

$data['rows'] = $rows;

$this->output
->set_content_type('application/json')
->set_output(json_encode($data));
ob_flush();