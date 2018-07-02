<?php

/*
%20 is whitespace, $id is taken from url
*/
switch ($id) {
	case 'rkp':
	$tabel = "adm_auth_hie_rkp";
	// $tabel = "adm_auth_hie_5";
	break;

	case 'rkap':
	$tabel = "adm_auth_hie_rkap"; 
	// $tabel = "adm_auth_hie_6"; 
	break;

	case 'pr-proyek':
	$tabel = "adm_auth_hie_pr_proyek";
	// $tabel = "adm_auth_hie_7";
	break;

	case "pr-non-proyek":
	$tabel = "adm_auth_hie_pr_non_proyek";
	break;

	case 'rfq-proyek':
	$tabel = "adm_auth_hie_rfq_proyek";
	// $tabel = "adm_auth_hie_8";
	break;

	case 'rfq-non-proyek':
	$tabel = "adm_auth_hie_rfq_non_proyek";
	// $tabel = "adm_auth_hie_2";
	break;

	case 'pemenang-proyek':
	$tabel = "adm_auth_hie_pemenang_proyek";
	// $tabel = "adm_auth_hie_9";
	break;

	case 'pemenang-non-proyek':
	// $tabel = "adm_auth_hie_3";
	$tabel = "adm_auth_hie_pemenang_non_proyek";
	break;

	case 'kontrak-proyek':
	$tabel = "adm_auth_hie_kontrak_proyek";
	// $tabel = "adm_auth_hie_10";
	break;

	case 'kontrak-non-proyek':
	$tabel = "adm_auth_hie_kontrak_non_proyek";
	// $tabel = "adm_auth_hie_11";
	break;

	// default:
	// $tabel = "adm_auth_hie";
	// break;
	// case 'inventory':
	// $tabel = "adm_auth_hie_4";
	// break;
	
	
}

$param = $this->input->get("id");

$param = ($param == "#") ? 0 : $param;

$get = $this->db->where("parent_id",$param)->get($tabel)->result_array();

$n = 0;

$data = array();

foreach ($get as $key => $value) {

	$pos = $this->db->where("pos_id",$value['pos_id'])->get("adm_pos")->row_array();
	$child = $this->db->where("parent_id",$value['auth_hie_id'])->get($tabel)->num_rows();
	//$name = $value['auth_hie_id']." : ".$pos['pos_name']." (".$pos['pos_id'].") (".inttomoney($value['max_amount']).") - ".$pos['job_title'];
	$name = $pos['pos_name']." (".inttomoney($value['max_amount']).")";
	$have_child = (!empty($child));
	$data[$n] = array("id"=>(int)$value['auth_hie_id'],"text"=>$name,"children"=>$have_child,
		"state"=>array("opened"=>true));
	$n++;
}

$this->output
->set_content_type('application/json')
->set_output(json_encode($data));