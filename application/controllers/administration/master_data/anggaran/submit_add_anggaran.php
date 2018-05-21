<?php 

$post = $this->input->post();

$userdata = $this->Administration_m->getLogin();

$data = array(
	'code_cc' => $userdata['dept_code'],
	'name_cc' => $userdata['dept_name'],
	'subcode_cc' => $post['subcode_inp'],
	'subname_cc' => $post['subname_inp'],
	//'allocation_cc' => $post['allocation_inp'],
	//'dept_cc' => $post['dept_inp'],
	//'year_cc' => $post['year_inp'],
	);

$insert = $this->db->insert('adm_cost_center', $data);

if($insert){
	$this->setMessage("Berhasil menambah data anggaran");
}

redirect(site_url('administration/master_data/anggaran'));