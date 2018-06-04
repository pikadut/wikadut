<?php

$this->db->where('id', $id);
$del = $this->db->delete('adm_project_list'); 

if($del){
	$this->setMessage("Berhasil menghapus data proyek");
}

redirect(site_url('administration/master_data/proyek'));