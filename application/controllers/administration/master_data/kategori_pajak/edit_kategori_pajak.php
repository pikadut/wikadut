<?php 

    $this->db->where('id_tc', $id);
    $query = $this->db->get('adm_tax_category');

    $data = array(
    'controller_name'=>"administration",
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/kategori_pajak/edit_kategori_pajak_v',"Ubah Kategori Pajak",$data);