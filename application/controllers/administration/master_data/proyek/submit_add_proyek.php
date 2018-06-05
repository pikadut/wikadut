<?php 

$post = $this->input->post();

// var_dump($post);

if (strtotime($post['date_start_inp']) > strtotime($post['date_end_inp']) ) {
	$this->setMessage("Tanggal mulai tidak boleh melebihi Tanggal akhir ");
	redirect(site_url('administration/master_data/proyek/tambah'));
}else{
	$data = array(
		'project_name' => $post['project_name_inp'],
		'description' => $post['desc_inp'],
		'date_start' => $post['date_start_inp'],
		'date_end' => $post['date_end_inp'],
		'disabled' => 0,
		// 'status' => $post['status_inp'],
	);

	$insert = $this->db->insert('adm_project_list', $data);

	if($insert){
	$this->setMessage("Berhasil menambah data proyek");
	}

	redirect(site_url('administration/master_data/proyek'));
}
