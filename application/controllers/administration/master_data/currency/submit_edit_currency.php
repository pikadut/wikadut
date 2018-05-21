<?php 

$ubah = $this->input->post();

if(!empty($ubah)){

	$id = $ubah['id'];

	$data = array(
		'curr_code' => $this->security->xss_clean($ubah['curr_code_currency_inp']),
		'curr_name' => $this->security->xss_clean($ubah['curr_name_currency_inp']),
		);   

	$update = $this->db->where('curr_code', $id)->update('adm_curr', $data); 

	if($update){
		$this->setMessage("Berhasil mengubah data currency");
	}

}

redirect(site_url('administration/master_data/currency'));