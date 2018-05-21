<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);
$vendor_id_commodity_suspend = $this->db->select('ccp_id')->where('aktif',1)->get('vnd_suspend_commodity_vendor')->result_array();
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Vendor_m->getUnsuspendVendor()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$ccp_id_suspend = array_column($vendor_id_commodity_suspend, 'ccp_id');

/**/

$rows = $this->db->where_not_in('ccp_id',$ccp_id_suspend)->get('vw_ctr_commodity_suspend')->result_array();

$status = array("A"=>"Aktif","S"=>"Suspend");

foreach ($rows as $key => $value) {
  
  }

$data['rows'] = $rows;

echo json_encode($data);