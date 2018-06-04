<?php

    $dist_name=$this->Administration_m->get_dist_name()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'dist_name' =>$dist_name,
   	'tipe_list' => "Divisi/Departemen"
    );
    // $data['tipe_list'] = array("Divisi/Departemen","Pelabuhan");
    $this->template('administration/master_data/divisi_departemen/add_divisi_departemen_v',"Tambah Divisi/Departemen",$data);
  