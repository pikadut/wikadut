<?php
	
    $job_pos=$this->Administration_m->get_job_pos()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'job_pos' =>$job_pos,
    'employee_id'=>$id,
    );

    $this->template('administration/user_management/employee/add_job_post_v',"Tambah Posisi",$data);
  