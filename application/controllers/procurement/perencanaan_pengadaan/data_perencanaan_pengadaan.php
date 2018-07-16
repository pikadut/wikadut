<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ppm_created_date";


$this->db->distinct();

$this->db->where('ppm_next_pos_id', $userdata['pos_id']);
$total_proses = $this->db->get('prc_plan_main a')->num_rows();

// $pic_user = $this->Administration_m->getPosition("PIC USER");
// $manajer_user = $this->Administration_m->getPosition("MANAJER USER");
// $kepala_anggaran = $this->Administration_m->getPosition("KEPALA ANGGARAN");
$pos = $this->Administration_m->getPosition();

$alldept = array();

$alldist = array();

foreach ($pos as $key => $value) {
  $alldept[] = $value['dept_id'];
  $alldist[] = $value['district_id'];
}

  if ($userdata['job_title'] == 'ADMIN' || $userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT') {
    $this->db->where_in("ppm_district_id",$alldist);
    $this->db->where_in("ppm_dept_id",$alldept);
  } else {
    $this->db->where('ppm_dept_id', $userdata['dept_id']);
  }

  



if(!empty($id)){
  $this->db->where("ppm_id",$id);
}

// echo "line 55\n";
if(!empty($search)){
  $this->db->group_start();
  // $this->db->like("LOWER(ppm_id)",$search);
  $this->db->or_like("LOWER(ppm_planner)",$search);
  $this->db->or_like("LOWER(ppm_planner_pos_name)",$search);
  $this->db->or_like("LOWER(ppm_subject_of_work)",$search);
  $this->db->group_end();
}

if(!empty($filtering)){
  switch ($filtering) {

    case 'approval':

    if ($total_proses > 0) {
      // $this->db->select('a.*');
      $this->db->where('ppm_next_pos_id', $userdata['pos_id']);
      $this->db->where("ppm_status !=",0);
      $this->db->where("ppm_status !=",4);
    }

    // if($kepala_anggaran) {
    //   $this->db->where("ppm_status",2);
    // } else if($manajer_user){
    //    $this->db->where("ppm_status",1);
     // }
     else {
      $this->db->where("ppm_status",99);
    }

    break;

    case 'update':
    $this->db->where_in("ppm_status",array(0,4));
    break;

    case 'approved':
    $this->db->where('ppm_next_pos_id', 212);
    $this->db->where("ppm_status",3);
    break;

    default:
    // if(!$pic_user){
      $this->db->where("ppm_status",99);
    // }

    break;

}

}
// $this->db->distinct();
// $this->db->select('a.*');
// $this->db->join('prc_plan_comment b', 'b.ppm_id = a.ppm_id','right');
$data['total'] = $this->Procplan_m->getPerencanaanPengadaan()->num_rows();


if(!empty($id)){
  $this->db->where("ppm_id",$id);
}

if ($userdata['job_title'] == 'ADMIN' || $userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT') {
    $this->db->where_in("ppm_district_id",$alldist);
    $this->db->where_in("ppm_dept_id",$alldept);
  } else {
    $this->db->where('ppm_dept_id', $userdata['dept_id']);
  }

if(!empty($search)){
  $this->db->group_start();
  // $this->db->like("LOWER(ppm_id)",$search);
  $this->db->or_like("LOWER(ppm_planner)", $search);
  $this->db->or_like("LOWER(ppm_planner_pos_name)",$search);
  $this->db->or_like("LOWER(ppm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ppm_dept_name)",$search);
  $this->db->or_like("LOWER(ppm_renc_kebutuhan_vw)",$search);
  $this->db->or_like("LOWER(ppm_renc_pelaksanaan_vw)",$search);
  $this->db->or_like("LOWER(ppm_dept_name)",$search);
  $this->db->or_like("LOWER(ppm_status_name)",$search);
  $this->db->group_end();
}

if(!empty($filtering)){
  switch ($filtering) {

    case 'approval':
    if ($total_proses > 0) {
      $this->db->where('ppm_next_pos_id', $userdata['pos_id']);
      $this->db->where("ppm_status !=",0);
      $this->db->where("ppm_status !=",4);
    }

  //   if($kepala_anggaran) {
  //     $this->db->where("ppm_status",2);
  //   } else if($manajer_user){
  //    $this->db->where("ppm_status",1);
   //
    else {
    $this->db->where("ppm_status",99);
  }

  break;

  case 'approved':
  $this->db->where('ppm_next_pos_id', 212);
  $this->db->where("ppm_status",3);
  $this->db->where("ppm_dept_id", $userdata['dept_id']); //y hany departemen
  break;

  case 'update':
  $this->db->where_in("ppm_status",array(0,4));
  break;

  // default:
  //   if(!$pic_user){
  //     $this->db->where("ppm_status",99);
  //   }

  break;

}

}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}
// $this->db->distinct();
// $this->db->select('a.*');
// $this->db->join('prc_plan_comment b', 'b.ppm_id = a.ppm_id');
$rows = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

$selection = $this->data['selection_perencanaan_pengadaan'];

$status = array(0=>"Simpan Sementara",1=>"Belum Disetujui",2=>"Telah Disetujui User",3=>"Telah Disetujui Kepala Anggaran",4=>"Revisi");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['ppm_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["ppm_pagu_anggaran"] = inttomoney($rows[$key]["ppm_pagu_anggaran"]);
  $rows[$key]["ppm_sisa_anggaran"] = inttomoney($rows[$key]["ppm_sisa_anggaran"]);
  $year = substr($rows[$key]["ppm_renc_kebutuhan"], 0, 4);
  $month = substr($rows[$key]["ppm_renc_kebutuhan"], 4, 2);
  $rows[$key]["ppm_renc_kebutuhan"] = getmonthname($month)." ".$year;
  $year = substr($rows[$key]["ppm_renc_pelaksanaan"], 0, 4);
  $month = substr($rows[$key]["ppm_renc_pelaksanaan"], 4, 2);
  $rows[$key]["ppm_renc_pelaksanaan"] = getmonthname($month)." ".$year;
  $rows[$key]['ppm_status'] = (isset($status[$rows[$key]['ppm_status']])) ? $status[$rows[$key]['ppm_status']] : "Belum Disetujui";
}

$data['rows'] = $rows;
echo json_encode($data);