<?php 

$get = $this->input->get();

$this->db->last_query();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "lane_code";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(lane_code)",$search);
  $this->db->or_like("LOWER(origin_lane)",$search);
  $this->db->or_like("LOWER(destination_lane)",$search);
  $this->db->or_like("LOWER(district_name)",$search);
  $this->db->or_like("LOWER(roundtrip_type_name)",$search);
  $this->db->or_like("LOWER(lane_active_name)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Administration_m->get_lintasan()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(lane_code)",$search);
  $this->db->or_like("LOWER(origin_lane)",$search);
  $this->db->or_like("LOWER(destination_lane)",$search);
  $this->db->or_like("LOWER(district_name)",$search);
  $this->db->or_like("LOWER(roundtrip_type_name)",$search);
  $this->db->or_like("LOWER(lane_active_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Administration_m->get_lintasan()->result_array();

//$roundtrip = array(0=>"Tidak",1=>"Ya");
//$status = array(0=>"Nonaktif",1=>"Aktif");

foreach ($rows as $key => $value) {
  
  //$rows[$key]['roundtrip_type'] = (isset($roundtrip[$rows[$key]['roundtrip_type']])) ? $roundtrip[$rows[$key]['roundtrip_type']] : "-";
  //$rows[$key]['lane_active'] = (isset($status[$rows[$key]['lane_active']])) ? $status[$rows[$key]['lane_active']] : "-";

  }

$data['rows'] = $rows;

echo json_encode($data);