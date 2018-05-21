<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

/*
$officer = $this->Administration_m->getPosition();

$pos = array();

foreach ($officer as $key => $value) {
  $pos[] = $value['pos_id'];
}
*/

$buyer = null;

if(!empty($userdata) && $userdata['job_title'] == 'PELAKSANA PENGADAAN'){
  $buyer = $userdata['employee_id'];
}


$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ptc_start_date";
if($field_order == "ptm_number"){
  $field_order = "A.ptm_number";
}

if($userdata['job_title'] != "VP PENGADAAN"){
  if(!empty($userdata['pos_id'])){
    $this->db->where("ptc_pos_code",$userdata['pos_id'],false);
  } else {
    $this->db->where("A.ptm_number","");
  }
} else {
  $this->db->where("ptc_pos_code",$userdata['pos_id'],false);
  $this->db->group_start();
  $this->db->where("ptm_status",null)->or_where("ptm_status >=",1030);
  $this->db->group_end();
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_requester_name)",$search);
  $this->db->or_like("LOWER(ptm_requester_pos_name)",$search);
  $this->db->or_like("A.ptm_number",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("ptm_status",1);
}

$this->db->select("ptc_id");

$data['total'] = $this->Procrfq_m->getPekerjaanRFQ($id,$userdata['employee_id'],$buyer)->num_rows();


if($userdata['job_title'] != "VP PENGADAAN"){
  if(!empty($userdata['pos_id'])){
    $this->db->where("ptc_pos_code",$userdata['pos_id'],false);
  } else {
    $this->db->where("A.ptm_number","");
  }
} else {
  $this->db->where("ptc_pos_code",$userdata['pos_id'],false);
  $this->db->group_start();
  $this->db->where("ptm_status",null)->or_where("ptm_status >=",1030);
  $this->db->group_end();
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_requester_name)",$search);
  $this->db->or_like("LOWER(ptm_requester_pos_name)",$search);
  $this->db->or_like("A.ptm_number",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("ptm_status",1);
}

$this->db->select("ptc_id,A.ptm_number,ptm_requester_name,ptm_subject_of_work,ptm_delivery_point,awa_name as activity,DATE_FORMAT(ptc_start_date,'%d/%m/%Y %H:%i') as waktu");

$rows = $this->Procrfq_m->getPekerjaanRFQ($id,$userdata['employee_id'],$buyer)->result_array();

$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
