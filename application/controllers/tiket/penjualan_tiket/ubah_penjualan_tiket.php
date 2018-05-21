<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat mengelola penjualan tiket");
}

$data['pos'] = $position;

$post = $this->input->post();

  $this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

  $view = 'tiket/penjualan_tiket/edit_penjualan_tiket_v';

  $id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

  $data['id'] = $id;

  $data['penjualan'] = $this->Tiksale_m->getPenjualanTiket($id)->row_array();
  
  $data['item'] = $this->Tiksale_m->getItemST("",$id)->result_array();
  
  
if(!in_array($data['penjualan']['tsm_status'], array(0,4))){
  $this->noAccess("Data penjualan yang sedang diproses tidak dapat diubah");
} else if(
  $data['penjualan']['tsm_district_id'] != $userdata['district_id'] ||
  $data['penjualan']['tsm_dept_id'] != $userdata['dept_id']
  ){
	$this->noAccess("Anda tidak berhak mengubah penjualan tiket user lain");
}

  
  $data["comment_list"][0] = $this->Comment_m->getTiketSold($id)->result_array();

  $this->template($view,"Ubah Entry Penjualan Tiket",$data);