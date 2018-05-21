<?php 

    $this->db->where('id', $id);
    $query = $this->db->get('adm_committee');

    $data = array(
    	'controller_name'=>"procurement",
    	"dir"=>"procurement/panitia"
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('procurement/panitia_pengadaan/edit_panitia_pengadaan_v',"Ubah Panitia Pengadaan",$data);