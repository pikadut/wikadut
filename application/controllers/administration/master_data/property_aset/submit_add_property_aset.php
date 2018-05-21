<?php 

$post = $this->input->post();

if(!empty($post)){

	$data = array(
		'name_pa' => $this->security->xss_clean($post['name_inp']),
		'desc_pa' => $this->security->xss_clean($post['desc_inp']),
		'commodity_pa' => $this->security->xss_clean($post['commodity_inp']),
		);

	$insert = $this->db->insert('adm_property_asset', $data);

	if($insert){
		$this->setMessage("Berhasil menambah data property aset");
	}

}

redirect(site_url('administration/master_data/property_aset'));