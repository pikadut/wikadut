<?php 

    $this->db->where('vendor_id', $id);
    $query = $this->db->get('vnd_header');

    $data = array(
    'controller_name'=>"vendor",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;
     $data['district'] = $this->Administration_m->getDistrict()->result_array();

    $this->template('vendor/vendor_tools/aktivasi_vendor_form',"Aktivasi Vendor",$data);