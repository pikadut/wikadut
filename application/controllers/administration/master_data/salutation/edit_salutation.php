<?php 

    $this->db->where('adm_salutation_id', $id);
    $query = $this->db->get('adm_salutation');

    $data = array(
    'controller_name'=>"administration",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/salutation/edit_salutation_v',"Ubah Salutation",$data);