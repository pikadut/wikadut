<?php 

$post = $this->input->post();

$id = $post['id'];

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
	"updated_by_war"=>$userdata['employee_id'],
	"updated_date_war"=>date("Y-m-d H:i:s")
	);

$this->db->where('id_war', $id);
$update = $this->db->update('adm_warehouse', $data); 

if($update){
	$this->setMessage("Berhasil mengubah data gudang");
}

redirect(site_url('administration/master_data/gudang'));