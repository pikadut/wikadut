<?php

  $get = $this->input->get();

  $filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
  $order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
  $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
  $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
  $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
  $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "updated_datetime";
  
  if(!empty($id)){
    $this->db->where("srv_price_id",$id);
  }

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(srv_price_id)",$search);
    $this->db->or_like("LOWER(A.srv_catalog_code)",$search);
    $this->db->or_like("LOWER(del_point_name)",$search);
    $this->db->or_like("LOWER(A.short_description)",$search);
    $this->db->or_like("LOWER(vendor)",$search);
    $this->db->group_end();
  }

  if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("A.status","");
}

  if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("A.status","A");
}


  $data['total'] = $this->Commodity_m->getSrvPrice()->num_rows();

    if(!empty($id)){
    $this->db->where("srv_price_id",$id);
  }

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(srv_price_id)",$search);
    $this->db->or_like("LOWER(A.srv_catalog_code)",$search);
    $this->db->or_like("LOWER(del_point_name)",$search);
    $this->db->or_like("LOWER(A.short_description)",$search);
    $this->db->or_like("LOWER(vendor)",$search);
    $this->db->group_end();
  }

  if(!empty($order)){
    $this->db->order_by($field_order,$order);
  }

  if(!empty($limit)){
    $this->db->limit($limit,$offset);
  }

  if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("A.status","");
}

  if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("A.status","A");
}


  $rows = $this->Commodity_m->getSrvPrice()->result_array();

  //echo $this->db->last_query();

  $selection = $this->data['selection_srv_price'];

$status = array("R"=>"warning","A"=>"success","N"=>"default");

  foreach ($rows as $key => $value) {
    if(!empty($selection) && in_array($value['srv_price_id'], $selection)){
      $rows[$key]['checkbox'] = true;
    }
    $rows[$key]["total_price"] = inttomoney($rows[$key]["total_price"]);
    $rows[$key]["sourcing_date"] = date("d M Y H:i",strtotime($rows[$key]["sourcing_date"]));
    //$rows[$key]["sourcing_id"] = $this->Commodity_m->getSourcingName($rows[$key]["sourcing_id"]);
      $label = (isset($status[$rows[$key]['status']])) ? $status[$rows[$key]['status']] : "primary";
  $rows[$key]['status_name'] = "<span class='label label-$label'>".$value['status_name']."</span>";
    $rows[$key]['is_active'] = ($rows[$key]['is_active'] == 1) ? "Aktif" : "Tidak Aktif";
      if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_hrg_jasa/".$rows[$key]["srv_price_id"]);
  }
  }

  $data['rows'] = $rows;

  echo json_encode($data);
