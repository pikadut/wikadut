<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

    foreach (array('pos_name_inp','job_title_inp') as $key => $value) {
        $tambah[$value] = $this->security->xss_clean($tambah[$value]);
    }

    $data = array(
        'pos_name' => $tambah['pos_name_inp'],
        'dept_id' => $tambah['dept_id_inp'],
        'job_title' =>$tambah['job_title_inp'],
        'district_id' => $tambah['district_id_inp'],
        );

    $insert = $this->db->insert('adm_pos', $data);

    if($insert){
        $this->setMessage("Berhasil menambah posisi");
    }

}

redirect(site_url('administration/admin_tools/position'));