<?php 

    $data = array(
    'controller_name'=>"administration",
    );

    $this->db->where('id', $id);
    $query = $this->db->get('adm_project_list');
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/proyek/edit_proyek_v',"Ubah Data Proyek",$data);