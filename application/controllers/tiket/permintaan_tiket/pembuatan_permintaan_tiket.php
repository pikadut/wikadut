<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$post = $this->input->post();

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat membuat permintaan tiket");
}

$data['pos'] = $position;

$kodecabang = $position['district_id'];;

$data['lane_list'] = $this->Tikplan_m->getHarbourDistrictPT($kodecabang)->result_array();

$id = "";

$aksi = "tambah";

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

$view = 'tiket/permintaan_tiket/add_permintaan_tiket_v';


$this->template($view,"Pembuatan Permintaan Tiket",$data);
 