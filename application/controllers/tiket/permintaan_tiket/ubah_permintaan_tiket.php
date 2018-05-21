<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat mengelola permintaan tiket");
}

$data['pos'] = $position;

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

  $view = 'tiket/permintaan_tiket/edit_permintaan_tiket_v';

  $id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

  $data['id'] = $id;

  $data['permintaan'] = $this->Tikplan_m->getPermintaanTiket($id)->row_array();
  
  $data['item'] = $this->Tikplan_m->getItemPT("",$id)->result_array();
  
  $data['lane_list'] = $this->Tikplan_m->getHarbourPT()->result_array();

if(!in_array($data['permintaan']['tpm_status'], array(0,4))){
  $this->noAccess("Permintaan sedang diproses tidak dapat diubah");
} else if(
  $data['permintaan']['tpm_district_id'] != $userdata['district_id'] ||
  $data['permintaan']['tpm_dept_id'] != $userdata['dept_id']
  ){
	$this->noAccess("Anda tidak berhak mengubah permintaan tiket user lain");
}

  
  $data["comment_list"][0] = $this->Comment_m->getTiketPlan($id)->result_array();

  $this->template($view,"Ubah Permintaan Tiket",$data);