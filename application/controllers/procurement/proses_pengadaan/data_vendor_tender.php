<?php

$this->load->model("Vendor_m");

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "asc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_name";

$selection_vendor = $this->data['selection_vendor_tender'];

$selection_district = $this->data['selection_district'];

$klasifikasi = $this->session->userdata('klasifikasi');

$ptm_number = $this->session->userdata("rfq_id");

$last_comment = $this->Comment_m->getProcurementRFQ("",$ptm_number)->row_array();

$status = $this->session->userdata("activity_id");

$this->db->select("group_code")
->join("vw_com_catalog","vw_com_catalog.catalog_code=prc_tender_item.tit_code");

$item = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

$data_item = array();

foreach ($item as $key => $value) {
  if(!in_array(substr($value['group_code'], 0, 4),$data_item)){
    $data_item[] = substr($value['group_code'], 0, 4);
  }
}

if(isset($klasifikasi) && !empty($klasifikasi)){
  $str = substr($klasifikasi, 0, strlen($klasifikasi)-1);
  $klasifikasi = explode("_", $str);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->group_end();
}

if($filtering === "selected"){
  if(!empty($selection_vendor)){
    $this->db->where_in("vendor_id",$selection_vendor);
  } else {
    $this->db->where("fin_class","X");
  }
} else if($filtering === "selected_tahap2"){
  if(!empty($selection_vendor)){
    $this->db->where_in("vendor_id",$selection_vendor);
    
    $this->db->where("pvs_status !=",-5);
  } else {
    $this->db->where("fin_class","X");
  }
} else {

  if(isset($klasifikasi) && !empty($klasifikasi)){
    $this->db->where_in("fin_class",$klasifikasi);
  }  else {
    if(!empty($selection_vendor)){
      $this->db->where_in("vendor_id",$selection_vendor);
    } else {
      $this->db->where("fin_class","X");
    }
  }
}

if($status > 1040){
  $this->db->where("ptm_number",$ptm_number);
  $this->db->select("vendor_id,vendor_name,fin_class,district_name,lkp_description");
} else {
  $this->db->select("vendor_id,vendor_name,fin_class,district_name");
}

if(!empty($data_item)){
  $this->db->where_in("code_group",$data_item);
}

$this->db
->distinct()
->where_in("status",array(5,9))
->join("prc_tender_vendor_status","pvs_vendor_code=vendor_id","left")
->join("z_bidder_status","lkp_id=pvs_status","left")
->join("adm_district","adm_district.district_id=vw_vnd_bidder_list.district_id","left");


if(!empty($selection_district) && empty($filtering)){
  $this->db->where("adm_district.district_id",$selection_district);
}

$data['total'] = $this->Vendor_m->getBidderList($id)->num_rows();
//echo $this->db->last_query();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->group_end();
}


if($filtering === "selected"){
  if(!empty($selection_vendor)){
    $this->db->where_in("vendor_id",$selection_vendor);
  } else {
    $this->db->where("fin_class","X");
  }
} else if($filtering === "selected_tahap2"){
  if(!empty($selection_vendor)){
    $this->db->where_in("vendor_id",$selection_vendor);
    $this->db->where("pvs_status !=",-5);
  } else {
    $this->db->where("fin_class","X");
  }
} else {

  if(isset($klasifikasi) && !empty($klasifikasi)){
    $this->db->where_in("fin_class",$klasifikasi);
  }  else {
    if(!empty($selection_vendor)){
      $this->db->where_in("vendor_id",$selection_vendor);
    } else {
      $this->db->where("fin_class","X");
    }
  }
}


if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if($status > 1040){
  $this->db->where("ptm_number",$ptm_number);
  $this->db->select("vendor_id,vendor_name,fin_class,district_name,lkp_description");
} else {
  $this->db->select("vendor_id,vendor_name,fin_class,district_name");
}

if(!empty($data_item)){
  $this->db->where_in("code_group",$data_item);
}


$this->db
->distinct()
->where_in("status",array(5,9))
->join("prc_tender_vendor_status","pvs_vendor_code=vendor_id","left")
->join("z_bidder_status","lkp_id=pvs_status","left")
->join("adm_district","adm_district.district_id=vw_vnd_bidder_list.district_id","left");


if(!empty($selection_district) && empty($filtering)){
  $this->db->where("adm_district.district_id",$selection_district);
}

$rows = $this->Vendor_m->getBidderList($id)->result_array();
//echo $this->db->last_query();

if($filtering === "selected"){
  $vendor_attend = (isset($this->data['selection_vendor_tender_hadir'])) ? $this->data['selection_vendor_tender_hadir'] : array();
} else if($filtering === "selected_tahap2"){
  $vendor_attend = (isset($this->data['selection_vendor_tender_hadir_2'])) ? $this->data['selection_vendor_tender_hadir_2'] : array();
}

$klasifikasi = array("K"=>"Kecil","M"=>"Menengah","B"=>"Besar");

foreach ($rows as $key => $value) {
  if(isset($vendor_attend) && !empty($vendor_attend) && in_array($value['vendor_id'], $vendor_attend)){
    $rows[$key]['checkbox'] = true;
  }
  if(isset($selection_vendor) && !empty($selection_vendor) && in_array($value['vendor_id'], $selection_vendor)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['vendor_name'] = "<a href='".site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$rows[$key]['vendor_id'])."' target='_blank'>".$rows[$key]['vendor_name']."</a>";
  $rows[$key]['fin_class'] = (isset($klasifikasi[$rows[$key]['fin_class']])) ? $klasifikasi[$rows[$key]['fin_class']] : "-";
  $attend = $this->Procrfq_m->getVendorRFQ($value['vendor_id'],$ptm_number)->row_array();
  $attend = (isset($attend['ptv_is_attend']) && !empty($attend['ptv_is_attend'])) ? "Ya" : "Tidak";
  $rows[$key]['attend'] = $attend;
}

$data['rows'] = $rows;
// echo $this->db->last_query();
echo json_encode($data);
