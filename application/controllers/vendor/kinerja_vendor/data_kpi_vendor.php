<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

$kantor_gbl = $this->session->userdata("kantor_gbl");

if(!empty($search)){
  $this->db->group_start();
  // matiin yang ini -shan
  // $this->db->like("LOWER(process_number)",$search);
  // end matiin
  $this->db->or_like("LOWER(vendor_name)",$search);
  // nambahin ini -shan
   $this->db->or_like("LOWER(fin_class_name)",$search);
  // end nambahin
  $this->db->group_end();
}

if(!empty($kantor_gbl)){
  $this->db->where("district_code",$kantor_gbl);
}
if(!empty($item_gbl)){
  $this->db->where("product_code",$item_gbl);
}

$this->db->distinct()->select("vendor_id,vendor_name,fin_class_name");

$data['total'] = $this->Vendor_m->getVendor()->num_rows();

if(!empty($kantor_gbl)){
  $this->db->where("district_code",$kantor_gbl);
}
if(!empty($item_gbl)){
  $this->db->where("product_code",$item_gbl);
}

if(!empty($search)){
  $this->db->group_start();
  // matiin yang ini -shan
  // $this->db->like("LOWER(process_number)",$search);
  // akhir matiin
  $this->db->or_like("LOWER(vendor_name)",$search);
  // nambahin ini
   $this->db->or_like("LOWER(fin_class_name)",$search);
  // end nambahin
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->distinct()->select("vendor_id,vendor_name,fin_class_name");

$rows = $this->Vendor_m->getVendor()->result_array();

foreach ($rows as $key => $value) {
  
  }

$data['rows'] = $rows;

echo json_encode($data);