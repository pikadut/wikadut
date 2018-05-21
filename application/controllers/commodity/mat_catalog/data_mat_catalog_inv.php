<?php 
//tambah file baru
$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "updated_datetime";

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

if(!empty($id)){
  $this->db->where("mat_catalog_code",$id);

  //hlmifzi
  if(strlen($id) == 14){
      $this->session->set_userdata("code_group",substr($id, 0,8));
  } elseif (strlen($id) == 15) {
      $this->session->set_userdata("code_group",substr($id, 0,9));
  } elseif (strlen($id) == 16) {
      $this->session->set_userdata("code_group",substr($id, 0,10));
  }
  
}

//$last_item = $this->session->userdata("code_group");

// if(!empty($last_item) && empty($id)){
//   $this->db->where("code_group",$last_item);
// }

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(mat_catalog_code)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
  $this->db->or_like("LOWER(name_group)",$search);
  $this->db->or_like("LOWER(uom)",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

$data['total'] = $this->Commodity_m->getMatCatalog()->num_rows();

if(!empty($id)){
  $this->db->where("mat_catalog_code",$id);
}

// if(!empty($last_item) && empty($id)){
//   $this->db->where("code_group",$last_item);
//}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(mat_catalog_code)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
  $this->db->or_like("LOWER(name_group)",$search);
  $this->db->or_like("LOWER(uom)",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Commodity_m->getMatCatalog()->result_array();

$selection = $this->data['selection_mat_catalog'];

$status = array("R"=>"warning","A"=>"success","N"=>"default");

foreach ($rows as $key => $value) {

  if(!empty($selection) && in_array($value['mat_catalog_code'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["total_price"] = inttomoney($rows[$key]["total_price"]);
  //$rows[$key]["mat_group_code"] = $this->Commodity_m->getMatLevelName($rows[$key]["mat_group_code"]);
  $label = (isset($status[$rows[$key]['status']])) ? $status[$rows[$key]['status']] : "primary";
  $rows[$key]['status_name'] = "<span class='label label-$label'>".$value['status_name']."</span>";
  $rows[$key]['short_description'] = anchor(site_url("commodity/lihat_katalog_barang/".$value["mat_catalog_code"]), $value["short_description"], 'target="_blank"');
  if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_kat_brg/".$rows[$key]["mat_catalog_code"]);
  }

}

$data['rows'] = $rows;
//var_dump($this->session->userdata());
echo json_encode($data);