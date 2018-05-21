<?php 

    $this->db->where('id', $id);
    $query = $this->db->get('adm_employee');

    $salutation=$this->Administration_m->get_salutation()->result_array();
    $job_pos=$this->Administration_m->get_job_pos()->result_array();
    $type=$this->Administration_m->get_employee_type()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'salutation' =>$salutation,
    'job_pos' =>$job_pos,
    'type' =>$type,
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/user_management/employee/edit_employee_v',"Ubah Employee",$data);