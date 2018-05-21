<?php 

$post = $this->input->post();

$userdata = $this->data['userdata'];

$ref = ($post['tipe_inp'] == 1) ? $post['ship_inp'] : $post['district_inp'];

if($post['tipe_inp'] == 1){
	$district_id = $this->db->where("id_ship",$ref)->get("adm_ship")->row()->district_ship;
} else {
	$district_id = $post['district_inp'];
}

$data = array(
	'code_war' =>$post['code_inp'],
	'name_war' => $post['name_inp'],
	'location_war' => $post['lokasi_inp'],
	'type_war' => $post['tipe_inp'],
	'ref_war' => $ref,
	"district_war"=>$district_id,
	"created_by_war"=>$userdata['employee_id'],
	"created_date_war"=>date("Y-m-d H:i:s")
	);

$insert = $this->db->insert('adm_warehouse', $data);

if($insert){
	$this->setMessage("Berhasil menambah data gudang");
}

redirect(site_url('administration/master_data/gudang'));