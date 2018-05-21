<?php 

    $this->db->where('district_id', $id);
    $query = $this->db->get('adm_district');

    $data = array(
    'controller_name'=>"administration",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/daftar_kantor/edit_daftar_kantor_v',"Ubah Daftar Kantor",$data);