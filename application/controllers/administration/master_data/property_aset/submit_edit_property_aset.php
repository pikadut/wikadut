<?php 

$post = $this->input->post();

if(!empty($post)){

	$id = $post['id'];

	$data = array(
		'name_pa' => $this->security->xss_clean($post['name_inp']),
		'desc_pa' => $this->security->xss_clean($post['desc_inp']),
		'commodity_pa' => $this->security->xss_clean($post['commodity_inp']),
		);

	$update = $this->db->where('id_pa',$id)->update('adm_property_asset', $data); 

	if($update){
		$this->setMessage("Berhasil mengubah data property aset");
	}

}

redirect(site_url('administration/master_data/property_aset'));