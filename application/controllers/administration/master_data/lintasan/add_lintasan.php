<?php

    $dist_name=$this->Administration_m->get_dist_name()->result_array();
	$dept_name=$this->Administration_m->get_harbour()->result_array();

    $data = array(
		'controller_name'=>"administration",
		'dept_name' =>$dept_name,
		'dist_name' =>$dist_name
    );
    $data['tipe_list'] = array("Tidak","Ya");
    $this->template('administration/master_data/lintasan/add_lintasan_v',"Tambah Lintasan",$data);
  