<?php

$get = $this->input->get();

$activity = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$ptm_number = $this->session->userdata("rfq_id");

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : $ptm_number;
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "pqm_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(total_ppn)",$search);
  $this->db->or_where("pqm_id",$search);
  $this->db->group_end();
}


$data['total'] = $this->Procrfq_m->getVendorQuoHistRFQ("",$ptm_number)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(total_ppn)",$search);
  $this->db->or_where("pqm_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Procrfq_m->getVendorQuoHistRFQ("",$ptm_number)->result_array();

foreach ($rows as $key => $value) {

  $rows[$key]['total_ppn'] = inttomoney($rows[$key]['total_ppn']);
  $rows[$key]['total'] = inttomoney($rows[$key]['total']);
  $rows[$key]['pqm_number'] = "<a href='".site_url('procurement/lihat_penawaran_hist/'.$rows[$key]['pqm_hist_id'])."' target='_blank'>".$rows[$key]['pqm_number']."</a>";

}

$data['rows'] = $rows;

  $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($data));
