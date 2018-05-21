<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

	$data = array(
		'adm_salutation_name' => $this->security->xss_clean($tambah['adm_salutation_name_slttn_inp']),
		);

	$insert = $this->db->insert('adm_salutation', $data);

	if($insert){
		$this->setMessage("Berhasil menambah salutation");
	}

}

redirect(site_url('administration/master_data/salutation'));