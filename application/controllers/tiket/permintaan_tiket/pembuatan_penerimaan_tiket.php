<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$post = $this->input->post();

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat membuat penerimaan tiket");
}

$data['pos'] = $position;

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['penerimaan'] = $this->Tikplan_m->getPenerimaanTiket($id)->row_array();
  
$data['item'] = $this->Tikplan_m->getItemPT("",$id)->result_array();
  
$data['lane_list'] = $this->Tikplan_m->getHarbourPT()->result_array();

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

$view = 'tiket/permintaan_tiket/entry_penerimaan_tiket_v';


$this->template($view,"Pembuatan Penerimaan Tiket",$data);
 