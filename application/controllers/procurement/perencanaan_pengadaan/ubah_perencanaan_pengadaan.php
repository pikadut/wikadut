<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat mengelola perencanaan pengadaan");
}

$data['pos'] = $position;

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

  $view = 'procurement/perencanaan_pengadaan/edit_perencanaan_pengadaan_v';

  $id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

  $data['id'] = $id;

  $data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($id)->row_array();

if(!in_array($data['perencanaan']['ppm_status'], array(0,4))){
  $this->noAccess("Pengadaan sedang diproses tidak dapat diubah");
} else if(
  $data['perencanaan']['ppm_district_id'] != $userdata['district_id'] ||
  $data['perencanaan']['ppm_dept_id'] != $userdata['dept_id']
  ){
	$this->noAccess("Anda tidak berhak mengubah perencanaan user lain");
}

  $data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

  $data["comment_list"][0] = $this->Comment_m->getProcurementPlan($id)->result_array();

  $this->template($view,"Ubah Perencanaan Pengadaan",$data);