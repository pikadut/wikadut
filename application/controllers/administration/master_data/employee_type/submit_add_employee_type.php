<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

	foreach (array('employee_type_name_emptype_inp') as $key => $value) {
		$tambah[$value] = $this->security->xss_clean($tambah[$value]);
	}

	$data = array(
		'employee_type_name' => $tambah['employee_type_name_emptype_inp'],
		);

	$insert = $this->db->insert('adm_employee_type', $data);

	if($insert){
		$this->setMessage("Berhasil menambah employee tipe");
	}

}

redirect(site_url('administration/master_data/employee_type'));