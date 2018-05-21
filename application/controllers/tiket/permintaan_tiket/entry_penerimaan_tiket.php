<?php 

$userdata = $this->data['userdata'];

$data = array();

$mgr_cabang_entry = $this->Administration_m->getPosition("PIC TIKET");

if($mgr_cabang_entry){
	$this->data['workflow_list'] = array(3=>"Barang telah diterima");
} else {
	$this->noAccess("Hanya PIC TIKET yang dapat mengelola penerimaan tiket");
}

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

$view = 'tiket/permintaan_tiket/entry_penerimaan_tiket_v';

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['permintaan'] = $this->Tikplan_m->getPermintaanTiket($id)->row_array();

if(in_array($data['permintaan']['tpm_status'], array(0,4))){
	$this->noAccess("Penerimaan tidak dapat disetujui");
}

$data['item1'] = $this->Tikplan_m->getItemPT("",$id)->result_array();

$data['item'] = $this->Tikplan_m->getItemDT("",$id)->result_array();

$data["comment_list"][0] = $this->Comment_m->getTiketPlan($id)->result_array();

$this->template($view,"Entry Penerimaan Tiket",$data);