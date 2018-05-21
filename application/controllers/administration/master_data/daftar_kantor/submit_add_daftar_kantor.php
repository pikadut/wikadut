<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

    foreach (array('district_code_dftrkntr_inp','district_name_dftrkntr_inp') as $key => $value) {
        $tambah[$value] = $this->security->xss_clean($tambah[$value]);
    }

    $data = array(
        'district_code' =>$tambah['district_code_dftrkntr_inp'],
        'district_name' => $tambah['district_name_dftrkntr_inp'],
        'district_prefix' => $tambah['singkatan_inp'],
        //'lat' => $tambah['lat_inp'], //tambah
        //'lng' => $tambah['lng_inp'], //tambah
        );

    $insert = $this->db->insert('adm_district', $data);

    if($insert){
    	$this->setMessage("Berhasil menambah daftar kantor");
    }

}

redirect(site_url('administration/master_data/daftar_kantor'));