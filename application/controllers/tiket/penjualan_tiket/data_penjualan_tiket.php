<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "tsm_id";

$mgr_cabang = $this->Administration_m->getPosition("PIC TIKET");
$mgr_pusat = $this->Administration_m->getPosition("APPROVAL TIKET");
$mgr_cabang_entry = $this->Administration_m->getPosition("PIC TIKET");

$pos = $this->Administration_m->getPosition();

/*$alldept = array();

$alldist = array();

foreach ($pos as $key => $value) {
  $alldept[] = $value['dept_id'];
  $alldist[] = $value['district_id'];
}
*/

if($mgr_cabang_entry){

  $this->db->where(array(
	"tsm_entry_pos_code"=>$mgr_cabang['pos_id']
    ));

} else if($mgr_pusat) {

  //$this->db->where_in("tsm_district_id",$alldist);
  //$this->db->where_in("tsm_dept_id",$alldept);

} else if($mgr_cabang) {

 $this->db->where(array(
  "tsm_district_id"=>$userdata['district_id']
  ));

}

if(!empty($id)){
  $this->db->where("tsm_id",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(tsm_id)",$search);
  $this->db->or_like("LOWER(tsm_month)",$search);
  $this->db->or_like("LOWER(tsm_year)",$search);
  $this->db->or_like("LOWER(tsm_entry_name)",$search);
  $this->db->or_like("LOWER(tsm_entry_pos_name)",$search);
  $this->db->or_like("LOWER(tsm_district_name)",$search);
  $this->db->or_like("LOWER(tsm_status_name)",$search);
  $this->db->group_end();
}

if(!empty($filtering)){
	
  switch ($filtering) {

  case 'approval':

  if($mgr_pusat){
     $this->db->where("tsm_status",1);
   } else {
    $this->db->where("tsm_status",99);
  }
  break;
  /*
  case 'entry':

    if($mgr_cabang_entry) {
    $this->db->where("tsm_status",999);
   } else {
    $this->db->where("tsm_status",99);
  }
  break;
  */
  case 'update':
  $this->db->where_in("tsm_status",array(0,4));
  break;
  
  case 'approved':
  $this->db->where("tsm_status",3);
  
  default:

  if(!$mgr_cabang){
    $this->db->where("tsm_status",99);
  }
  break;

}

}

$data['total'] = $this->Tiksale_m->getPenjualanTiket()->num_rows();


if($mgr_cabang_entry){

$this->db->where(array(
	"tsm_entry_pos_code"=>$mgr_cabang['pos_id']
    ));

} else if($mgr_pusat) {

  //$this->db->where_in("tsm_district_id",$alldist);
  //$this->db->where_in("tsm_dept_id",$alldept);

} else if($mgr_cabang) {

   $this->db->where(array(
  "tsm_district_id"=>$userdata['district_id']
  ));

}

if(!empty($id)){
  $this->db->where("tsm_id",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(tsm_id)",$search);
  $this->db->or_like("LOWER(tsm_month)",$search);
  $this->db->or_like("LOWER(tsm_year)",$search);
  $this->db->or_like("LOWER(tsm_entry_name)",$search);
  $this->db->or_like("LOWER(tsm_entry_pos_name)",$search);
  $this->db->or_like("LOWER(tsm_district_name)",$search);
  $this->db->or_like("LOWER(tsm_status_name)",$search);
  $this->db->group_end();
}

if(!empty($filtering)){
	
  switch ($filtering) {
	  
  case 'approval':

	if($mgr_pusat){
     $this->db->where("tsm_status",1);
   } else {
    $this->db->where("tsm_status",99);
  }
  break;
  
  case 'entry':

    if($mgr_cabang_entry) {
    $this->db->where("tsm_status",999);
   } else {
    $this->db->where("tsm_status",99);
  }
  break;
  
  case 'update':
  $this->db->where_in("tsm_status",array(0,4));
  break;
  
  case 'approved':
  $this->db->where("tsm_status",3);

  default:

  if(!$mgr_cabang){
    $this->db->where("tsm_status",99);
  }
  break;

}

}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Tiksale_m->getPenjualanTiket()->result_array();

$selection = $this->data['selection_penjualan_tiket'];

$status = array(0=>"Simpan Sementara",1=>"Belum Disetujui",2=>"Belum Disetujui GM Cabang",3=>"Telah Disetujui GM Cabang",4=>"Revisi");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['tsm_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
 // $rows[$key]['tsm_status'] = (isset($status[$rows[$key]['tsm_status']])) ? $status[$rows[$key]['tsm_status']] : "Belum Disetujui GM Cabang";
}

$data['rows'] = $rows;

echo json_encode($data);
