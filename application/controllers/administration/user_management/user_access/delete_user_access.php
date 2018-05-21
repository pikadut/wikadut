<?php
$id = $this->uri->segment(5, 0);
$delete = $this->db->where('id', $id)->delete('adm_user'); 
if($delete){
	$this->setMessage("Berhasil menghapus user");
}
redirect(site_url('administration/user_management/user_access'));
