<?php 
    
    $id = $this->db->where('id_suspend_commodity_vendor',$id)->get('vnd_suspend_commodity_vendor')->row_array();

    $this->db->where('vendor_id', $id['vendor_id']);
    $query = $this->db->get('vnd_header');

    $this->Vendor_m->getDaftarSuspend($id['vendor_id']);

    $this->data['workflow_list'] = array("R"=>"Ditolak","A"=>"Disetujui");

    $data = array(
    'controller_name'=>"vendor",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id['ccp_id'];
    $data['commodity'] =  $this->db->where('ccp_id',$id['ccp_id'])->get('vnd_suspend_commodity_vendor')->row_array();
    $data["comment_list"][0] = $this->Comment_m->getVendorCommodityActive($id['ccp_id'])->result_array();

    $this->template('vendor/kinerja_vendor/daftar_pekerjaan_vendor_commodity_form_v',"Daftar Pekerjaan Vendor Commodity",$data);