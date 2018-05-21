<?php

$get = $this->input->get();

$milestone_id = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "progress_id";


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_date)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->or_where("progress_id",$search);
  $this->db->group_end();
}

$data['total'] = $this->Contract_m->getMilestoneProgress("",$milestone_id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_date)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->or_where("progress_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Contract_m->getMilestoneProgress("",$milestone_id)->result_array();


$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {
   $rows[$key]['attachment'] = "<a href='".INTRANET_UPLOAD_FOLDER.'/contract/milestone/'.$rows[$key]['attachment']."' target='_blank'>".$rows[$key]['attachment']."</a>";
}

$data['rows'] = $rows;

echo json_encode($data);
