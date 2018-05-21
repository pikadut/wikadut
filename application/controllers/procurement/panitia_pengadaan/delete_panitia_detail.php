<?php
$id = $this->uri->segment(5, 0);
$data = $this->Administration_m->getBidCommittee2($id)->row_array(); 
if($data['used'] == 0){
	$delete = $this->db->where('team_order', $id)->delete('adm_bid_committee');
	if($delete){
		$this->setMessage("Berhasil menghapus anggota panitia pengadaan");
	}
} else {
	$this->setMessage("Data panitia pengadaan sudah digunakan dan tidak dapat dihapus");
}
redirect(site_url('procurement/procurement_tools/panitia_pengadaan/ubah/'.$data['committee_id']));