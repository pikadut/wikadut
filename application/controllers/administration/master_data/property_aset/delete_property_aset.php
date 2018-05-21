<?php

$this->db->where('id_pa', $id);
$del = $this->db->delete('adm_property_asset'); 

if($del){
	$this->setMessage("Berhasil menghapus data property aset");
}

redirect(site_url('administration/master_data/property_aset'));