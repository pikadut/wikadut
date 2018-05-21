<?php 

$post = $this->input->post();

if(!empty($post)){

    $id = $this->security->xss_clean($post['dist_id_divbirnit_inp']);

    $nama = $this->Administration_m->get_divbirnit_dept_name($id);

    $data = array(
        'dep_code' =>$this->security->xss_clean($post['dep_code_divbirnit_inp']),
        'dept_name' => $this->security->xss_clean($post['dept_name_divbirnit_inp']),
        'district_id' => $id,
        'district_name' => $nama,
        'dept_type'=>$post['tipe_inp'],
        'dept_active'=>1,
        'gambar_maps' => $post['gambar_attachment'],
        // 'no_sertifikat' => $post['no_sertifikat_inp'],
        // 'tgl_penerbitan' => $post['tgl_penerbitan_inp'],
        // 'luas' => $post['luas_inp'],
        // 'nama_pemegang_hak' => $post['nama_pemegang_hak_inp'],
        //'status_operasional' => $post['status_operasional_inp']
        );

    $insert = $this->db->insert('adm_dept', $data);
    
    if($insert){
        $this->setMessage("Berhasil menambah divisi/departemen");
    }

}

redirect(site_url('administration/master_data/divisi_departemen'));