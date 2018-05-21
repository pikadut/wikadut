<?php 

$ubah = $this->input->post();

if(!empty($ubah)){

	$id = $ubah['id'];

	foreach (array('district_code_dftrkntr_inp','district_name_dftrkntr_inp') as $key => $value) {
		$ubah[$value] = $this->security->xss_clean($ubah[$value]);
	}

	$data = array(
		'district_code' => $ubah['district_code_dftrkntr_inp'],
		'district_name' => $ubah['district_name_dftrkntr_inp'],
		'district_prefix' => $ubah['singkatan_inp'],
		//'lat' => $ubah['lat_inp'], //tambah
        //'lng' => $ubah['lng_inp'], //tambah
		);    

	$update = $this->db->where('district_id', $id)->update('adm_district', $data); 
	
	if($update){
		$this->setMessage("Berhasil mengubah daftar kantor");
	}

}

redirect(site_url('administration/master_data/daftar_kantor'));