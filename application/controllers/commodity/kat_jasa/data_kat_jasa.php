<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "updated_datetime";

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

if(!empty($id)){
  $this->db->where("srv_catalog_code",$id);
  $this->session->set_userdata("code_group",substr($id, 0,8));
}

$last_item = $this->session->userdata("code_group");

if(!empty($last_item) && empty($id)){
  $this->db->where("code_group",$last_item);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(srv_catalog_code)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
  $this->db->or_like("LOWER(name_group)",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

$data['total'] = $this->Commodity_m->getSrvCatalog()->num_rows();
//echo $this->db->last_query();

if(!empty($id)){
  $this->db->where("srv_catalog_code",$id);
}

if(!empty($last_item) && empty($id)){
  $this->db->where("code_group",$last_item);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(srv_catalog_code)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
  $this->db->or_like("LOWER(name_group)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

$rows = $this->Commodity_m->getSrvCatalog()->result_array();

$selection = $this->data['selection_srv_catalog'];

$status = array("R"=>"warning","A"=>"success","N"=>"default");

foreach ($rows as $key => $value) {

  if(!empty($selection) && in_array($value['srv_catalog_code'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["total_price"] = inttomoney($rows[$key]["total_price"]);
  //$rows[$key]["srv_group_code"] = $this->Commodity_m->getSrvLevelName($rows[$key]["srv_group_code"]);
  $rows[$key]['short_description'] = anchor(site_url("commodity/lihat_katalog_jasa/".$value["srv_catalog_code"]), $value["short_description"], 'target="_blank"');
  $label = (isset($status[$rows[$key]['status']])) ? $status[$rows[$key]['status']] : "primary";
  $rows[$key]['status_name'] = "<span class='label label-$label'>".$value['status_name']."</span>";
  if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_kat_jasa/".$rows[$key]["srv_catalog_code"]);
  }

}

$data['rows'] = $rows;

echo json_encode($data);
