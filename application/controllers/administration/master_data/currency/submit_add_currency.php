<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

    $data = array(
        'curr_code' => $this->security->xss_clean($tambah['curr_code_currency_inp']),
        'curr_name' => $this->security->xss_clean($tambah['curr_name_currency_inp']),
        );

    $insert = $this->db->insert('adm_curr', $data);

    if($insert){
        $this->setMessage("Berhasil menambah data currency");
    }

}

redirect(site_url('administration/master_data/currency'));