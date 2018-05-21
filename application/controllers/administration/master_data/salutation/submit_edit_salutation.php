<?php 

$ubah = $this->input->post();

if(!empty($ubah)){

	$id = $ubah['id'];

	$data = array(
		'adm_salutation_name' => $this->security->xss_clean($ubah['adm_salutation_name_slttn_inp']),
		);    

	$update = $this->db->where('adm_salutation_id', $id)->update('adm_salutation', $data);

	if($update){
		$this->setMessage("Berhasil mengubah salutation");
	}

}

redirect(site_url('administration/master_data/salutation'));