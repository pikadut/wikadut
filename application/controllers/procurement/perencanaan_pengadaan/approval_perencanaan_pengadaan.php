<?php 

$userdata = $this->data['userdata'];

$data = array();

// $manajer_user = $this->Administration_m->getPosition("MANAJER USER");

// $kepala_anggaran = $this->Administration_m->getPosition("KEPALA ANGGARAN");

$this->db->where('ppm_next_pos_id', $userdata['pos_id']);
// $this->db->join('prc_plan_comment b', 'b.ppm_id = a.ppm_id', 'left');
$total_proses = $this->db->get('prc_plan_main a')->num_rows();

// if($manajer_user){
// 	$this->data['workflow_list'] = array(3=>"Setuju",4=>"Revisi");
// } else if($kepala_anggaran){
// 	$this->data['workflow_list'] = array(3=>"Setuju",4=>"Revisi");
// } 
if ($total_proses) {
	$this->data['workflow_list'] = array(3=>"Setuju",4=>"Revisi");
}
else {
	$this->noAccess("Anda tidak dapat mengelola approval perencanaan pengadaan");
	// $this->noAccess("Hanya VP USER & KEPALA ANGGARAN yang dapat mengelola approval perencanaan pengadaan");
}

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'procurement/perencanaan_pengadaan/approval_perencanaan_pengadaan_v';

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($id)->row_array();

if(in_array($data['perencanaan']['ppm_status'], array(0,4))){
	$this->noAccess("Perencanaan tidak dapat diapprove");
}

$data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

$data["comment_list"][0] = $this->Comment_m->getProcurementPlan($id)->result_array();

$this->template($view,"Rekapitulasi Perencanaan Pengadaan",$data);