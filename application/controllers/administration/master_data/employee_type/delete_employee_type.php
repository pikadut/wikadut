<?php

$check = $this->db->where("employee_type_id",$id)->get("adm_employee")->num_rows();
if(empty($check)){
$this->db->where('employee_type_id', $id);
$this->db->delete('adm_employee_type'); 
} else {
	$this->setMessage("Data sudah dipakai. Tidak dapat dihapus","Error");
}
redirect(site_url('administration/master_data/employee_type'));
