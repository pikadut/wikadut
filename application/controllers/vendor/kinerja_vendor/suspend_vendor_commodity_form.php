<?php 
	$id = $this->db->where('ccp_id',$id)->get('vw_ctr_commodity_suspend')->row_array();

    $this->db->where('vendor_id', $id['vendor_id']);
    $query = $this->db->get('vnd_header');

    $data = array(
    'controller_name'=>"vendor",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id['ccp_id'];
    $data['commodity'] =  $this->db->where('ccp_id',$id['ccp_id'])->get('vw_ctr_commodity_suspend')->row_array();
    $data["comment_list"][0] = $this->Comment_m->getVendorCommodityActive($id['ccp_id'])->result_array();

    $this->template('vendor/kinerja_vendor/suspend_vendor_commodity_form_v',"Suspend Commodity Vendor",$data);
