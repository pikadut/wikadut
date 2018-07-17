<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$item_gbl = $this->session->userdata("item_gbl");
$klasifikasi_gbl = $this->session->userdata("klasifikasi_gbl");
$kantor_gbl = $this->session->userdata("kantor_gbl");
$vendor_gbl = $this->session->userdata("vendor_gbl");

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
// matikan ini -shan
// $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vw_vnd_header.vendor_id";
// end matikan
// ganti ini -shan
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";
// end 

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  
  $this->db->group_end();
}

if(!empty($item_gbl)){
  $this->db->where("product_code",$item_gbl);
}
if(!empty($kantor_gbl)){
  $this->db->where("district_code",$kantor_gbl);
}
if(!empty($klasifikasi_gbl)){
  $this->db->where("fin_class",$klasifikasi_gbl);
}
if(!empty($klasifikasi_gbl)){
  $this->db->like("vendor_name",$vendor_gbl);
}

$this->db->select("vw_vnd_header.vendor_id")->distinct();

$data['total'] = $this->db->join("vw_vnd_header","vw_vnd_header.vendor_id=vnd_product.vendor_id","left")->get("vnd_product")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  // nambahin ini -shan
   $this->db->or_like("LOWER('win')",$search);
  $this->db->or_like("LOWER('invited')",$search);
  $this->db->or_like("LOWER('reg')",$search);
  $this->db->or_like("LOWER('quote')",$search);
  $this->db->or_like("LOWER(reg_status_name)",$search);
  // end nambahin
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

// matikan ini -shan
// $this->db->select("vw_vnd_header.vendor_id,vendor_name,email_address,reg_status_name,
//   COALESCE
//   ((SELECT COUNT(ptm_number) FROM vw_bidder_list WHERE vw_vnd_header.vendor_id=pvs_vendor_code AND pvs_status = 2),0) as reg,
//   COALESCE
//   ((SELECT COUNT(ptm_number) FROM prc_tender_quo_main WHERE vw_vnd_header.vendor_id=ptv_vendor_code),0) as quote,
//   COALESCE
//   ((SELECT COUNT(ptm_number) FROM vw_bidder_list WHERE vw_vnd_header.vendor_id=pvs_vendor_code AND pvs_status IN (1,-1,-2,2)),0) as invited,
//   COALESCE
//   ((SELECT COUNT(ptm_number) FROM vw_bidder_list WHERE vw_vnd_header.vendor_id=pvs_vendor_code AND pvs_is_winner = 1),0) as win",FALSE)->distinct();
// end matikan


if(!empty($item_gbl)){
  $this->db->where("product_code",$item_gbl);
}
if(!empty($kantor_gbl)){
  $this->db->where("district_code",$kantor_gbl);
}
if(!empty($klasifikasi_gbl)){
  $this->db->where("fin_class",$klasifikasi_gbl);
}
if(!empty($klasifikasi_gbl)){
  $this->db->like("vendor_name",$vendor_gbl);
}

// matikan ini -shan
// $rows = $this->db->join("vw_vnd_header","vw_vnd_header.vendor_id=vnd_product.vendor_id","left")->get("vnd_product")->result_array();
// end matikan

// ganti ini
$rows = $this->db->get("vw_generate_bidder_list")->result_array();
// end ganti

//echo $this->db->last_query();

$status = array("R"=>"Revisi","A"=>"Aktif","N"=>"Nonaktif");

foreach ($rows as $key => $value) {
    $rows[$key]['reg'] = "<a href='".site_url('vendor/detail_vendor/reg/'.$rows[$key]['vendor_id'])."' target='_blank'>".$rows[$key]['reg']."</a>";
    $rows[$key]['quote'] = "<a href='".site_url('vendor/detail_vendor/quote/'.$rows[$key]['vendor_id'])."' target='_blank'>".$rows[$key]['quote']."</a>";
    $rows[$key]['invited'] = "<a href='".site_url('vendor/detail_vendor/invited/'.$rows[$key]['vendor_id'])."' target='_blank'>".$rows[$key]['invited']."</a>";
     $rows[$key]['win'] = "<a href='".site_url('vendor/detail_vendor/win/'.$rows[$key]['vendor_id'])."' target='_blank'>".$rows[$key]['win']."</a>";
  }

$data['rows'] = $rows;

echo json_encode($data);