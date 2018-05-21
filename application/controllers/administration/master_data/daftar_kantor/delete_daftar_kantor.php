<?php

$cek = $this->db->where('district_id', $id)->get('adm_dept')->num_rows();

if(empty($cek)){
	$this->db->where('district_id', $id)->delete('adm_district');
} else {
	$this->setMessage("Data sudah dipakai. Tidak dapat dihapus","Error");
}

redirect(site_url('administration/master_data/daftar_kantor'));
