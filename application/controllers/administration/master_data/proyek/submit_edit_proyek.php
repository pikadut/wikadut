<?php 

$post= $this->input->post();

$id = $post['id'];

$data = array(
	'project_name' => $post['project_name_inp'],
	'description' => $post['desc_inp'],
	'date_start' => $post['date_start_inp'],
	'date_end' => $post['date_end_inp'],
	);

$this->db->where('id', $id);
$update = $this->db->update('adm_project_list', $data); 

if($update){
	$this->setMessage("Berhasil mengubah data proyek");
}

redirect(site_url('administration/master_data/proyek'));