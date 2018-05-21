<?php 

$post= $this->input->post();
$id = $post['id'];

$data = array(
	'name_tc' => $post['name_inp'],
	);

$this->db->where('id_tc', $id);
$update = $this->db->update('adm_tax_category', $data); 

if($update){
	$this->setMessage("Berhasil mengubah data kategori pajak");
}

redirect(site_url('administration/master_data/kategori_pajak'));