<?php 

$ubah = $this->input->post();

if(!empty($ubah)){

	$id = $ubah['id'];

	foreach (array('employee_type_name_emptype_inp') as $key => $value) {
		$ubah[$value] = $this->security->xss_clean($ubah[$value]);
	}

	$data = array(
		'employee_type_name' =>$ubah['employee_type_name_emptype_inp'],
		);    

	$update = $this->db->where('employee_type_id', $id)->update('adm_employee_type', $data);

	if($update){
		$this->setMessage("Berhasil menambah employee tipe");
	}

}

redirect(site_url('administration/master_data/employee_type'));