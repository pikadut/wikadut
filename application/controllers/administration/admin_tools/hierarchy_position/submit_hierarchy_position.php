<?php 

$post = $this->input->post();

if(!empty($post)){
	$data = array(
		'pos_id' =>$post['pos_id_inp'],
		'max_amount' =>moneytoint($post['max_amount_inp']),
		'currency' =>$post['curr_code_inp'],
		'parent_id' =>($post['parent_id_inp'] == $post['id'] && $post['id'] == 1) ? 0 : (!empty($post['parent_id_inp'])?$post['parent_id_inp'] : 0),
		);

	switch ($post['type']) {
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
		// default:
		// $tabel = "adm_auth_hie";
		// break;
	}

	if($post['act'] == "add"){
		$act = $this->db->insert($tabel, $data);
		$this->setMessage("Berhasil menambah hirarki posisi");
	} else {
		$act = $this->db->where("auth_hie_id",$post['id'])->update($tabel, $data);
		$this->setMessage("Berhasil mengubah hirarki posisi");
	}

}

redirect(site_url('administration/admin_tools/hierarchy_position'));