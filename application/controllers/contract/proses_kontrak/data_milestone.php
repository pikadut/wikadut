<?php

$get = $this->input->get();

$contract_id = $this->session->userdata("contract_id");

$contract = $this->Contract_m->getData($contract_id)->row_array();

$done = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "milestone_id";

if($done){

  $milestone_exist = array();
  $already_milestone = $this->Contract_m->getInvoiceItem()->result_array();

  foreach ($already_milestone as $key => $value) {
    if(!empty($value['milestone_id'])){
      $milestone_exist[] = $value['milestone_id'];
    }
  }

  $this->db->where("progress_percentage",100);

  if(!empty($milestone_exist)){
    $this->db->where_not_in("milestone_id",$milestone_exist);
  }

}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_date)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->or_where("milestone_id",$search);
  $this->db->group_end();
}

$data['total'] = $this->Contract_m->getMilestone("",$contract_id)->num_rows();

if($done){
  $this->db->where("progress_percentage",100);
  if(!empty($milestone_exist)){
    $this->db->where_not_in("milestone_id",$milestone_exist);
  }
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_date)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->or_where("milestone_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Contract_m->getMilestone("",$contract_id)->result_array();

$selection = $this->data['selection_milestone'];

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['milestone_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['total'] = inttomoney($contract['contract_amount']*($rows[$key]['percentage']/100));
} 

$data['rows'] = $rows;

echo json_encode($data);
