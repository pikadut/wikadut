<?php 

$post= $this->input->post();

$id = $post['id'];

$userdata = $this->Administration_m->getLogin();

$dept_code = (empty($post['code_inp'])) ? $userdata['dept_code'] : $post['code_inp'];
$dept_name = (empty($post['name_inp'])) ? $userdata['dept_name'] : $post['name_inp'];

$data = array(
	'code_cc' => $dept_code,
	'name_cc' => $dept_name,
	'subcode_cc' => $post['subcode_inp'],
	'subname_cc' => $post['subname_inp'],
	//'allocation_cc' => $post['allocation_inp'],
	//'dept_cc' => $post['dept_inp'],
	//'year_cc' => $post['year_inp'],
	);

$this->db->where('id_cc', $id);
$update = $this->db->update('adm_cost_center', $data); 

if($update){
	$this->setMessage("Berhasil mengubah data anggaran");
}

redirect(site_url('administration/master_data/anggaran'));