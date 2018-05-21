<?php

$this->db->where('id_tc', $id);
$del = $this->db->delete('adm_tax_category'); 

if($del){
	$this->setMessage("Berhasil menghapus data kategori pajak");
}

redirect(site_url('administration/master_data/kategori_pajak'));