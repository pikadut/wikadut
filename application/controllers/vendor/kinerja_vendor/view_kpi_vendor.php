<?php 
  $view = 'vendor/kinerja_vendor/view_kpi_vendor_v';
  $data = array();
  $data['vendor'] = $this->Vendor_m->getVendorActive($id)->row_array();
  //hlmifzi
  $data['item'] = $this->db->where("vendor_id",$id)->get("vw_ctr_vendor_katalog")->result_array();
  $this->template($view,"Lihat KPI Vendor",$data);
?>