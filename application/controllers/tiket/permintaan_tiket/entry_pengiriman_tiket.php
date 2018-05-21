<?php 

$userdata = $this->data['userdata'];

$data = array();

$mgr_pusat_entry = $this->Administration_m->getPosition("APPROVAL TIKET");

if($mgr_pusat_entry){
	$this->data['workflow_list'] = array(5=>"Barang Telah Dikirim");
} else {
	$this->noAccess("Hanya APPROVAL TIKET yang dapat mengelola pengiriman tiket");
}

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

$view = 'tiket/permintaan_tiket/entry_pengiriman_tiket_v';

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['permintaan'] = $this->Tikplan_m->getPermintaanTiket($id)->row_array();

if(in_array($data['permintaan']['tpm_status'], array(0,4))){
	$this->noAccess("Pengiriman Tiket tidak dapat disetujui");
}

$data['item'] = $this->Tikplan_m->getItemPT("",$id)->result_array();

$data["comment_list"][0] = $this->Comment_m->getTiketPlan($id)->result_array();

$this->template($view,"Entry Pengiriman Tiket",$data);