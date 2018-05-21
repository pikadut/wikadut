<?php
	
    $committeetype=$this->Administration_m->getCommitteeType()->result_array();
    $employee=$this->Administration_m->employee_view()->result_array();

    $data = array(
    'controller_name'=>"procurement",
    'committeetype' =>$committeetype,
    'employee' =>$employee,
    'committee_id'=>$id,
    );

    $this->template('procurement/panitia_pengadaan/add_panitia_detail_v',"Tambah Posisi Panitia Pengadaan",$data);
  