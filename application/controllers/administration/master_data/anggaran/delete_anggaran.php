<?php

$this->db->where('id_cc', $id);
$del = $this->db->delete('adm_cost_center'); 

if($del){
	$this->setMessage("Berhasil menghapus data anggaran");
}

redirect(site_url('administration/master_data/anggaran'));