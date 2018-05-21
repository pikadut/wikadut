<?php 

$this->db->where('id_ship', $id);
$query = $this->db->get('adm_ship');

$data = array(
	'controller_name'=>"administration",
	);

$data['data'] = $query->row_array();
$data['id'] = $id;
$data['district'] = $this->db->get("adm_district")->result_array();

$this->template('administration/master_data/kapal/edit_kapal_v',"Ubah Kapal",$data);