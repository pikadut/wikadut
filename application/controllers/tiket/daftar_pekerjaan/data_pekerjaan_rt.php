<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "tpm_id";

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
	"tpm_planner_pos_code"=>$mgr_cabang_entry['pos_id']
    ));
	$this->db->where("tpm_status",5);
	
} else if($mgr_pusat) {

  //$this->db->where_in("tpm_district_id",$alldist);
  //$this->db->where_in("tpm_dept_id",$alldept);  
	$this->db->where("tpm_status",99);

} else if($mgr_cabang) {

 $this->db->where(array(
  "tpm_planner_pos_code"=>$mgr_cabang['pos_id']
  ));

}

if(!empty($id)){
  $this->db->where("tpm_id",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(tpm_id)",$search);
  $this->db->or_like("LOWER(tpm_planner)",$search);
  $this->db->or_like("LOWER(tpm_planner_pos_name)",$search);
  $this->db->or_like("LOWER(tpm_number)",$search);
  $this->db->or_like("LOWER(tpm_status_name)",$search);
  $this->db->group_end();
}

if(!empty($filtering)){
	
  switch ($filtering) {
	  
  case 'entry':

  if($mgr_cabang_entry) {
    $this->db->where("tpm_status",5);
   } else {
    $this->db->where("tpm_status",99);
  }
  break;

  case 'entried':
  $this->db->where("tpm_status",5);
  break;
  
  default:

  if(!$mgr_cabang_entry){
    $this->db->where("tpm_status",99);
  }
  break;

}

}

$data['total'] = $this->Tikplan_m->getPermintaanTiket()->num_rows();


if($mgr_cabang_entry){

	$this->db->where(array(
	"tpm_planner_pos_code"=>$mgr_cabang_entry['pos_id']
    ));
	$this->db->where("tpm_status",5);
	
} else if($mgr_pusat) {

  //$this->db->where_in("tpm_district_id",$alldist);
  //$this->db->where_in("tpm_dept_id",$alldept);
	$this->db->where("tpm_status",99);

} else if($mgr_cabang) {

   $this->db->where(array(
  "tpm_planner_pos_code"=>$mgr_cabang['pos_id']
  ));

}

if(!empty($id)){
  $this->db->where("tpm_id",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(tpm_id)",$search);
  $this->db->or_like("LOWER(tpm_planner)",$search);
  $this->db->or_like("LOWER(tpm_planner_pos_name)",$search);
  $this->db->or_like("LOWER(tpm_number)",$search);
  $this->db->or_like("LOWER(tpm_status_name)",$search);
  $this->db->group_end();
}

if(!empty($filtering)){
	
  switch ($filtering) {
	  
  case 'entry':

  if($mgr_cabang_entry) {
    $this->db->where("tpm_status",5);
   } else {
    $this->db->where("tpm_status",99);
  }
  break;
  
  case 'entried':
  $this->db->where("tpm_status",5);
  break;
  
  default:

  if(!$mgr_cabang_entry){
    $this->db->where("tpm_status",99);
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

$rows = $this->Tikplan_m->getPermintaanTiket()->result_array();

$selection = $this->data['selection_permintaan_tiket'];

//$status = array(0=>"Simpan Sementara",1=>"Belum Disetujui",2=>"Telah Disetujui Pusat",3=>"Barang Telah Diterima",4=>"Revisi");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['tpm_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  //$rows[$key]['tpm_status'] = (isset($status[$rows[$key]['tpm_status']])) ? $status[$rows[$key]['tpm_status']] : "Belum Disetujui";
}

$data['rows'] = $rows;

echo json_encode($data);
