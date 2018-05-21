<?php


    $salutation=$this->Administration_m->get_salutation()->result_array();
    $job_pos=$this->Administration_m->get_job_pos()->result_array();
    $type=$this->Administration_m->get_employee_type()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'salutation' =>$salutation,
    'job_pos' =>$job_pos,
    'type' =>$type,
    );

    $this->template('administration/user_management/employee/add_employee_v',"Tambah Employee",$data);
  