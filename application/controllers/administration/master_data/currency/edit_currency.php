<?php 

    $this->db->where('curr_code', $id);
    $query = $this->db->get('adm_curr');

    $data = array(
    'controller_name'=>"administration",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/currency/edit_currency_v',"Ubah Mata Uang",$data);