<?php 

$post = $this->input->post();

$data = array(
	'name_tc' => $post['name_inp'],
	);

$insert = $this->db->insert('adm_tax_category', $data);

if($insert){
	$this->setMessage("Berhasil menambah data kategori pajak");
}

redirect(site_url('administration/master_data/kategori_pajak'));