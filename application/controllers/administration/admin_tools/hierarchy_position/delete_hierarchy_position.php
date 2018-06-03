<?php

$id = $this->uri->segment(5, 0);
$type = $this->uri->segment(6, 0);

switch ($type) {
	case 'rkp':
	$tabel = "adm_auth_hie_5";
	break;

	case 'rkap':
	$tabel = "adm_auth_hie_6"; 
	break;

	case 'pr-proyek':
	$tabel = "adm_auth_hie_7";
	break;

	case "pr-non-proyek":
	$tabel = "adm_auth_hie";
	break;

	case 'rfq-proyek':
	$tabel = "adm_auth_hie_8";
	break;

	case 'rfq-non-proyek':
	$tabel = "adm_auth_hie_2";
	break;

	case 'pemenang-proyek':
	$tabel = "adm_auth_hie_9";
	break;

	case 'pemenang-non-proyek':
	$tabel = "adm_auth_hie_3";
	break;

	case 'kontrak-proyek':
	$tabel = "adm_auth_hie_10";
	break;

	case 'kontrak-non-proyek':
	$tabel = "adm_auth_hie_11";
	break;

	// case 'inventory':
	// $tabel = "adm_auth_hie_4";
	// break;
	
	// default:
	// $tabel = "adm_auth_hie";
	// break;
}

$parent = $this->db->where('auth_hie_id', $id)->get($tabel)->row_array();
$child = $this->db->where('parent_id', $id)->get($tabel)->result_array();

$delete = $this->db->where('auth_hie_id', $id)->delete($tabel); 

if($delete){
	if(!empty($child)){
		foreach ($child as $key => $value) {
			$this->db->where("auth_hie_id",$value['auth_hie_id'])
			->update($type,array("parent_id"=>$parent['parent_id']));
		}
	}
	$this->setMessage("Berhasil menghapus hirakri posisi");
}
redirect(site_url('administration/admin_tools/hierarchy_position'));