<?php 

    $this->db->where('del_point_id', $id);
    $query = $this->db->get('adm_del_point');

    $data = array(
    'controller_name'=>"administration",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/delivery_point/edit_delivery_point_v',"Ubah Delivery Point",$data);