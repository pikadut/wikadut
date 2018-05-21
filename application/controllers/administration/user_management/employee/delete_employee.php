<?php

$this->db->where('id', $id);
$delete = $this->db->delete('adm_employee'); 
if($delete){
	$this->session->set_userdata("message","Berhasil menghapus data");
}
redirect(site_url('administration/user_management/employee'));
