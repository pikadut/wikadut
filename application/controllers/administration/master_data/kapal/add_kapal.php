<?php

    $data = array(
    'controller_name'=>"administration",
    );
	$data['district'] = $this->db->get("adm_district")->result_array();

    $this->template('administration/master_data/kapal/add_kapal_v',"Tambah Kapal",$data);
  