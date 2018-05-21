<?php 

$view = 'vendor/daftar_vendor/generate_bidder_list/generate_bidder_list_v';

if($param == '1'){
	$this->session->unset_userdata("item_gbl");
	$this->session->unset_userdata("klasifikasi_gbl");
	$this->session->unset_userdata("kantor_gbl");
}

$komoditi=$this->db->get("vw_com_catalog")->result_array();
$kantor=$this->Administration_m->get_dist_name()->result_array();
$item_gbl = $this->session->userdata("item_gbl");
$klasifikasi_gbl = $this->session->userdata("klasifikasi_gbl");
$kantor_gbl = $this->session->userdata("kantor_gbl");
$vendor_gbl = $this->session->userdata("vendor_gbl");
$data = array(
	'item_gbl'=>$item_gbl,
	'klasifikasi_gbl'=>$klasifikasi_gbl,
	'vendor_gbl'=>$vendor_gbl,
	'kantor_gbl'=>$kantor_gbl,
	'jumlah' =>1,
	'komoditi' =>$komoditi,
	'kantor' =>$kantor,
	);

$this->template($view,"Generate Bidder List",$data);