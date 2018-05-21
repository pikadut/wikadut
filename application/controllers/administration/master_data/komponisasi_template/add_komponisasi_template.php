<?php
$data = array(
	'controller_name'=>"administration",
	);
$data['gudang_type'] = array("Kantor","Kapal");
$data['office'] = $this->db->get("adm_district")->result_array();
    $data['ship'] = $this->db->select("id_ship,code_ship,name_ship,district_name")
    ->join("adm_district","district_id=district_ship")->get("adm_ship")->result_array();

$this->template('administration/master_data/gudang/add_gudang_v',"Tambah Gudang",$data);
