<?php 

$this->load->model("Procpanitia_m");

  $get = $this->input->get();

  $filtering = $this->uri->segment(3, 0);

  $id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
  $order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
  $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
  $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
  $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
  $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id";

  if(!empty($id)){
    $this->db->where("id",$id);
  }
  
  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(id)",$search);
    $this->db->or_like("LOWER(committee_name)",$search);
    $this->db->or_like("LOWER(pos_name)",$search);
    $this->db->or_like("LOWER(fullname)",$search);
    $this->db->group_end();
  }

  $data['total'] = $this->Procpanitia_m->getPanitia()->num_rows();

  if(!empty($id)){
    $this->db->where("id",$id);
  }

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(id)",$search);
    $this->db->or_like("LOWER(committee_name)",$search);
    $this->db->or_like("LOWER(pos_name)",$search);
    $this->db->or_like("LOWER(fullname)",$search);
    $this->db->group_end();
  }

  if(!empty($order)){
    $this->db->order_by($field_order,$order);
  }

  if(!empty($limit)){
    $this->db->limit($limit,$offset);
  }

  $rows = $this->Procpanitia_m->getPanitia()->result_array();

  $selection = $this->data['selection_panitia'];

  foreach ($rows as $key => $value) {
    if(!empty($selection) && in_array($value['id'], $selection)){
      $rows[$key]['checkbox'] = true;
    }

  }

  $data['rows'] = $rows;

  echo json_encode($data);