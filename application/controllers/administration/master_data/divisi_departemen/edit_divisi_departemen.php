<?php 

    $this->db->where('dept_id', $id);
    $query = $this->db->get('adm_dept');
    

    $dist_name=$this->Administration_m->get_dist_name()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'dist_name' =>$dist_name,
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;
    $data['tipe_list'] = array("Divisi/Departemen","Pelabuhan");

    $this->template('administration/master_data/divisi_departemen/edit_divisi_departemen_v',"Ubah Divisi/Departemen/Pelabuhan",$data);