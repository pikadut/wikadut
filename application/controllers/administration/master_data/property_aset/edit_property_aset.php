<?php 

$this->db->where('id_pa', $id);
$query = $this->db->get('adm_property_asset');

$data = array(
	'controller_name'=>"administration",
	);

$data['data'] = $query->row_array();
$data['id'] = $id;
    $data['komoditi_type'] = array("Tanah","Bangunan","Alat Angkutan","Peralatan Gedung","Inventaris Kantor","Komputer","Perangkat Lunak","Jasa Konstruksi","Jasa Non Konstruksi");

$this->template('administration/master_data/property_aset/edit_property_aset_v',"Ubah Property Aset",$data);