<?php

$id = $this->uri->segment(5, 0);
$type = $this->uri->segment(6, 0);

switch ($type) {
	case 'rkp':
	$tabel = "adm_auth_hie_rkp";
	break;

	case 'rkap':
	$tabel = "adm_auth_hie_rkap"; 
	break;

	case 'pr-proyek':
	$tabel = "adm_auth_hie_pr_proyek";
	break;

	case "pr-non-proyek":
	$tabel = "adm_auth_hie_pr_non_proyek";
	break;

	case 'rfq-proyek':
	$tabel = "adm_auth_hie_rfq_proyek";
	break;

	case 'rfq-non-proyek':
	$tabel = "adm_auth_hie_rfq_non_proyek";
	break;

	case 'pemenang-proyek':
	$tabel = "adm_auth_hie_pemenang_proyek";
	break;

	case 'pemenang-non-proyek':
	$tabel = "adm_auth_hie_pemenang_non_proyek";
	break;

	case 'kontrak-proyek':
	$tabel = "adm_auth_hie_kontrak_proyek";
	break;

	case 'kontrak-non-proyek':
	$tabel = "adm_auth_hie_kontrak_non_proyek";
	break;

	// case 'inventory':
	// $tabel = "adm_auth_hie_4";
	// break;
	
	// default:
	// $tabel = "adm_auth_hie";
	// break;
}
// echo $id;
// echo $type;
// echo $tabel;
// exit();
$parent = $this->db->where('auth_hie_id', $id)->get($tabel)->row_array();
$child = $this->db->where('parent_id', $id)->get($tabel)->result_array();

$delete = $this->db->where('auth_hie_id', $id)->delete($tabel); 

if($delete){
	if(!empty($child)){
		foreach ($child as $key => $value) {
			$this->db->where("auth_hie_id",$value['auth_hie_id'])
			// ->update($type,array("parent_id"=>$parent['parent_id']));
			->update($tabel,array("parent_id"=>$parent['parent_id']));

		}
	}
	$this->setMessage("Berhasil menghapus hirarki posisi");
}
redirect(site_url('administration/admin_tools/hierarchy_position'));