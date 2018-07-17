<?php 

  $get = $this->input->get();

  

  $order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
  $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
  $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
  $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
  $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "sourcing_id";
  
  if(!empty($search)){
    $this->db->like("LOWER('sourcing_id')",$search);
    $this->db->or_like("LOWER(sourcing_name)",$search);
  }

  $data['total'] = $this->Commodity_m->getSourcing()->num_rows();

  if(!empty($search)){
    $this->db->like("LOWER('sourcing_id')",$search);
    $this->db->or_like("LOWER(sourcing_name)",$search);
  }

  if(!empty($order)){
    $this->db->order_by($field_order,$order);
  }

  if(!empty($limit)){
    $this->db->limit($limit,$offset);
  }

  $rows = $this->Commodity_m->getSourcing()->result_array();

  $selection = $this->data['selection_sourcing'];

  $type = array("N"=>"Nasional","I"=>"Internasional");

  foreach ($rows as $key => $value) {
    if(!empty($selection) && in_array($value['sourcing_id'], $selection)){
      $rows[$key]['checkbox'] = true;
    }

    $rows[$key]['sourcing_type'] = (isset($type[$rows[$key]['sourcing_type']])) ? $type[$rows[$key]['sourcing_type']] : "";
  }

  $data['rows'] = $rows;

  echo json_encode($data);