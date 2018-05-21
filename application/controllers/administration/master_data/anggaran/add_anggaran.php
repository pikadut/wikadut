<?php

$userdata = $this->data['userdata'];

$data = array(
	'controller_name'=>"administration",
	'dept'=>$this->Administration_m->get_divisi_departemen()->result_array(),
	'kode_mata_anggaran' =>$userdata['dept_code'],
	'nama_mata_anggaran' =>$userdata['dept_name'],
	);

$this->template('administration/master_data/anggaran/add_anggaran_v',"Tambah Anggaran",$data);
