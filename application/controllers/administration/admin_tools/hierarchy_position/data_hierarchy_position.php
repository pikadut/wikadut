<?php

switch ($id) {
	case 'inventory':
	$tabel = "adm_auth_hie_4";
	break;
	case 'rfq':
	$tabel = "adm_auth_hie_2";
	break;
	case 'pemenang':
	$tabel = "adm_auth_hie_3";
	break;
	default:
	$tabel = "adm_auth_hie";
	break;
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