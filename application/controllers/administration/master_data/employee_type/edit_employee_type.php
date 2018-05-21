<?php 

    $this->db->where('employee_type_id', $id);
    $query = $this->db->get('adm_employee_type');

    $data = array(
    'controller_name'=>"administration",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/employee_type/edit_employee_type_v',"Ubah Tipe Pegawai",$data);