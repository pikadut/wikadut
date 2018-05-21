<?php 
$view = 'vendor/kinerja_vendor/detail_barang_kpi_v';
$data = array("title"=>"Lihat KPI Vendor");
//start code hlmifzi
$data['nama_barang'] = $this->db->where("ccp_id_commodity_cat",$id)->get("vw_ctr_penilaian")->row()->group_name;
$data['item'] = $this->db->select('*')->where("vendor_id",$vendor)->where("ccp_id_commodity_cat",$id)->get('vw_ctr_penilaian')->result_array();

$this->load->view($view,$data);
?>