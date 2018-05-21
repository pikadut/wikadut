<?php 

    $this->db->where('vendor_id', $id);
    $query = $this->db->get('vnd_header');

    $this->Vendor_m->getDaftarSuspend($id);

    $this->data['workflow_list'] = array("R"=>"Ditolak","A"=>"Disetujui");

    $data = array(
    'controller_name'=>"vendor",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;
    $data["comment_list"][0] = $this->Comment_m->getVendorActive($id)->result_array();

    $this->template('vendor/kinerja_vendor/daftar_pekerjaan_vendor_form_v',"Daftar Pekerjaan Vendor",$data);