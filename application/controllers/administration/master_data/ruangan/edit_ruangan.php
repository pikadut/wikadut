<?php 

    $this->db->where('id_room', $id);
    $query = $this->db->get('adm_room');

    $data = array(
    'controller_name'=>"administration",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/ruangan/edit_ruangan_v',"Ubah Ruangan",$data);