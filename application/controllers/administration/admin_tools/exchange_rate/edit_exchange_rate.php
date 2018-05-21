<?php 

    $this->db->where('exchange_rate_id', $id);
    $query = $this->db->get('adm_exchange_rate');

    $currency=$this->Administration_m->getCurrency()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'currency' =>$currency,
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/admin_tools/exchange_rate/edit_exchange_rate_v',"Ubah Nilai Tukar",$data);