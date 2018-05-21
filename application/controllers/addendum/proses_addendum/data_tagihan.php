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
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "invoice_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(invoice_date)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(bank_account)",$search);
  $this->db->or_where("invoice_id",$search);
  $this->db->group_end();
}

$data['total'] = $this->Contract_m->getInvoice("",$contract_id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(invoice_date)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(bank_account)",$search);
  $this->db->or_where("invoice_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Contract_m->getInvoice("",$contract_id)->result_array();

$selection = $this->data['selection_milestone'];

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['invoice_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['invoice_date'] = date(DEFAULT_FORMAT_DATE,strtotime($rows[$key]['invoice_date']));
  $rows[$key]['created_date'] = date(DEFAULT_FORMAT_DATE,strtotime($rows[$key]['created_date']));
} 

$data['rows'] = $rows;

echo json_encode($data);
