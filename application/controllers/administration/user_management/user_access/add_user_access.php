<?php

    $employee_name=$this->Administration_m->employee_view()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'employee_name' =>$employee_name,
    );

    $this->template('administration/user_management/user_access/add_user_access_v',"Tambah User",$data);
  