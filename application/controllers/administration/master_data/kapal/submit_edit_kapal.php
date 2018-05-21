<?php 

$post= $this->input->post();
$id = $post['id'];

$data = array(
	'code_ship' =>$post['code_inp'],
	'name_ship' => $post['name_inp'],
	'district_ship' => $post['district_inp'],
	'detail_attachment' => $post['detail_attachment']
	);

$this->db->where('id_ship', $id);
$update = $this->db->update('adm_ship', $data); 

if($update){
	$this->setMessage("Berhasil mengubah data kapal");
}

redirect(site_url('administration/master_data/kapal'));