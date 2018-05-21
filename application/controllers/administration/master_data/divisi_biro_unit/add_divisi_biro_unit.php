<?php

    $dist_name=$this->Administration_m->get_dist_name()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'dist_name' =>$dist_name,
    );

    $this->template('administration/master_data/divisi_biro_unit/add_divisi_biro_unit_v',"Tambah Divisi/Departemen",$data);
  