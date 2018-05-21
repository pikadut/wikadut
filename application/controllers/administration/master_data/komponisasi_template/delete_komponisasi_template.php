<?php

$this->db->where('id_war', $id);
$del = $this->db->delete('adm_warehouse'); 

if($del){
	$this->setMessage("Berhasil menghapus data gudang");
}

redirect(site_url('administration/master_data/gudang'));