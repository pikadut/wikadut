<?php 

$post = $this->input->post();

$data = array( 
	'code_ship' =>$post['code_inp'],
	'name_ship' => $post['name_inp'],
	'district_ship' => $post['district_inp'],
	'detail_attachment' => $post['detail_attachment']
	);

$insert = $this->db->insert('adm_ship', $data);

if($insert){
	$this->setMessage("Berhasil menambah data kapal");
}

redirect(site_url('administration/master_data/kapal'));