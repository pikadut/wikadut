<?php

$this->db->where('id_ship', $id);
$del = $this->db->delete('adm_ship'); 

if($del){
	$this->setMessage("Berhasil menghapus data kapal");
}

redirect(site_url('administration/master_data/kapal'));