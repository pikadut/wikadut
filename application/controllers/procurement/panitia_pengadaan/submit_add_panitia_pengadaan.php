<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

    foreach (array('committee_name_inp','panitia_file_inp') as $key => $value) {
        $tambah[$value] = $this->security->xss_clean($tambah[$value]);
    }

    $data = array(
        'committee_name' =>$tambah['committee_name_inp'],
        'committee_doc'=>$tambah['panitia_file_inp']
        );

    $insert = $this->db->insert('adm_committee', $data);

    if($insert){
        $last_id = $this->db->insert_id();
        $this->setMessage("Berhasil menambah panitia pengadaan");
        redirect(site_url('procurement/procurement_tools/panitia_pengadaan/ubah/'.$last_id));
    }
    
} else {

    redirect(site_url('procurement/procurement_tools/panitia_pengadaan'));
    
}