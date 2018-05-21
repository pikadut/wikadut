<?php
$id = $this->uri->segment(5, 0);
$delete = $this->db->where('id', $id)->delete('adm_committee'); 
if($delete){
	$this->setMessage("Berhasil menghapus panitia pengadaan");
}
redirect(site_url('procurement/procurement_tools/panitia_pengadaan'));