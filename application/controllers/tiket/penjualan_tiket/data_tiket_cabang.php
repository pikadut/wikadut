<?php 

$get = $this->input->get();

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat membuat laporan penjualan tiket");
}

$data['pos'] = $position;

$kodecabang = $position['district_id'];

//$lane_name = (isset($get['tsm_lane_name'])) ? $get['tsm_lane_name'] : "";

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ticket_code";

$id = (isset($get['ticket_code']) && !empty($get['ticket_code'])) ? $get['ticket_code'] : "";


if(!empty($id)){
  $this->db->where("ticket_code",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ticket_code)",$search);
  $this->db->or_like("LOWER(ticket_description)",$search);
  $this->db->or_like("LOWER(ticket_stock_branch)",$search);
  $this->db->or_like("LOWER(ticket_unit)",$search);
  $this->db->group_end();
}


//$data['total'] = $this->Tiksale_m->getTiketCabang($lane_name,$kodecabang)->num_rows();

$data['total'] = $this->Tiksale_m->getTiketCabang($kodecabang)->num_rows();


if(!empty($id)){
  $this->db->where("ticket_code",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ticket_code)",$search);
  $this->db->or_like("LOWER(ticket_description)",$search);
  $this->db->or_like("LOWER(ticket_stock_branch)",$search);
  $this->db->or_like("LOWER(ticket_unit)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

//$rows = $this->Tiksale_m->getTiketCabang($lane_name,$kodecabang)->result_array();

$rows = $this->Tiksale_m->getTiketCabang($kodecabang)->result_array();

$selection = $this->data['selection_tiket_cabang'];

foreach ($rows as $key => $value) {

  if(!empty($selection) && in_array($value['ticket_code'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['ticket_description'] = anchor(site_url("commodity/lihat_katalog_barang/".$value["ticket_code"]), $value["ticket_description"], 'target="_blank"');
  

}

$data['rows'] = $rows;

echo json_encode($data);