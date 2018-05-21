<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

	$tambah['dist_id_divbirnit_inp'] = $this->security->xss_clean($tambah['dist_id_divbirnit_inp']);

	$nama = $this->Administration_m->get_divbirnit_dept_name($tambah['dist_id_divbirnit_inp']);

	$data = array(
		'dep_code' =>$tambah['dep_code_divbirnit_inp'],
		'dept_name' => $tambah['dept_name_divbirnit_inp'],
		'district_id' => $tambah['dist_id_divbirnit_inp'],
		'district_name' => $nama,
		);

	$insert = $this->db->insert('adm_dept', $data);

	if($insert){
		$this->setMessage("Berhasil menambah divisi/departemen");
	}

}

redirect(site_url('administration/master_data/divisi_biro_unit'));

