<?php 

    $this->db->where('vendor_id', $id);
    $query = $this->db->get('vnd_header');

    $data = array(
    'controller_name'=>"vendor",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;
    $data["comment_list"][0] = $this->Comment_m->getVendorActive($id)->result_array();

    $this->template('vendor/kinerja_vendor/suspend_vendor_form_v',"Suspend Vendor",$data);