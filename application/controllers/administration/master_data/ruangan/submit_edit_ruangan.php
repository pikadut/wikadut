<?php 

$post= $this->input->post();
$id = $post['id'];

$data = array(
	'name_room' => $post['name_inp'],
	'desc_room' => $post['desc_inp'],
	'photo_room' => $post['attachment_inp'],
	);

$this->db->where('id_room', $id);
$update = $this->db->update('adm_room', $data); 

if($update){
	$this->setMessage("Berhasil mengubah data ruangan");
}

redirect(site_url('administration/master_data/ruangan'));