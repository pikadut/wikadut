<?php 

$userdata = $this->data['userdata'];

$data = array();

$mgr_pusat = $this->Administration_m->getPosition("APPROVAL TIKET");

if($mgr_pusat){
	$this->data['workflow_list'] = array(2=>"Setuju",4=>"Revisi");
} else {
	$this->noAccess("Hanya APPROVAL TIKET yang dapat mengelola approval penjualan tiket");
}

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

$view = 'tiket/penjualan_tiket/approval_penjualan_tiket_v';

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['penjualan'] = $this->Tiksale_m->getPenjualanTiket($id)->row_array();

if(in_array($data['penjualan']['tsm_status'], array(0,4))){
	$this->noAccess("Data Penjualan tidak dapat disetujui");
}

$data['item'] = $this->Tiksale_m->getItemST("",$id)->result_array();

$data["comment_list"][0] = $this->Comment_m->getTiketSold($id)->result_array();

$this->template($view,"Rekapitulasi Penjualan Tiket",$data);

