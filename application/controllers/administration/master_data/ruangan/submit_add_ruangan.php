<?php 

$post = $this->input->post();

$data = array(
	'name_room' => $post['name_inp'],
	'desc_room' => $post['desc_inp'],
	'photo_room' => $post['attachment_inp'],
	);

$insert = $this->db->insert('adm_room', $data);

if($insert){
	$this->setMessage("Berhasil menambah data ruangan");
}

redirect(site_url('administration/master_data/ruangan'));