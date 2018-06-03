<?php 

$post = $this->input->post();

if(!empty($post)){
	$data = array(
		'pos_id' =>$post['pos_id_inp'],
		'max_amount' =>moneytoint($post['max_amount_inp']),
		'currency' =>$post['curr_code_inp'],
		'parent_id' =>($post['parent_id_inp'] == $post['id'] && $post['id'] == 1) ? 0 : $post['parent_id_inp'],
		);

	switch ($post['type']) {
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