<?php 

    $this->db->where('vendor_id', $id);
    $query = $this->db->get('vnd_header');

   
    $this->Vendor_m->getDaftarSuspend($id);

    $data = array(
    'controller_name'=>"vendor",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;
    $data["comment_list"][0] = $this->Comment_m->getVendorActive($id)->result_array();

    $this->template('vendor/kinerja_vendor/aktivasi_suspend_vendor_form_v',"Aktivasi Suspend Vendor",$data);