<?php

    $jobtitle=$this->Administration_m->get_job_title()->result_array();
    $dept=$this->Administration_m->get_divisi_departemen()->result_array();
    $district=$this->Administration_m->get_dist_name()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'jobtitle' =>$jobtitle,
    'dept' =>$dept,
    'district' =>$district,
    );

    $this->template('administration/admin_tools/position/add_position_v',"Tambah Position",$data);
  