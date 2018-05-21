<?php

$this->db->where('id_room', $id);
$del = $this->db->delete('adm_room'); 

if($del){
	$this->setMessage("Berhasil menghapus data ruangan");
}

redirect(site_url('administration/master_data/ruangan'));