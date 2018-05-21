<?php 

$userdata = $this->data['userdata'];

$data = array();

$mgr_pusat = $this->Administration_m->getPosition("APPROVAL TIKET");

if($mgr_pusat){
	$this->data['workflow_list'] = array(2=>"Setuju",4=>"Revisi");
} else {
	$this->noAccess("Hanya APPROVAL TIKET yang dapat mengelola approval permintaan tiket");
}

$post = $this->input->post();

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

$view = 'tiket/permintaan_tiket/approval_permintaan_tiket_v';

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['permintaan'] = $this->Tikplan_m->getPermintaanTiket($id)->row_array();

if(in_array($data['permintaan']['tpm_status'], array(0,4))){
	$this->noAccess("Permintaan tidak dapat disetujui");
}

$data['item'] = $this->Tikplan_m->getItemPT("",$id)->result_array();

$data["comment_list"][0] = $this->Comment_m->getTiketPlan($id)->result_array();

$this->template($view,"Rekapitulasi Permintaan Tiket",$data);