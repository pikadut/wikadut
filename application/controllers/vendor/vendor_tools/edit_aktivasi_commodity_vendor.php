<?php 

    $this->db->where('ccp_id', $id);
    $query_commodity = $this->db->get('vnd_suspend_commodity_vendor')->row_array();

    $this->db->where('vendor_id', $query_commodity['vendor_id']);
    $query = $this->db->get('vnd_header');

    $data = array(
    'controller_name'=>"vendor",
    );
    
    $data['data_commodity'] = $query_commodity;
    $data['data'] = $query->row_array();
    $data['id'] = $id;
     $data['district'] = $this->Administration_m->getDistrict()->result_array();

    $this->template('vendor/vendor_tools/aktivasi_vendor_commodity_form',"Aktivasi Commodity Vendor",$data);