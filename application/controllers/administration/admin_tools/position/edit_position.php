<?php 

    $this->db->where('pos_id', $id);
    $query = $this->db->get('adm_pos');

    $jobtitle=$this->Administration_m->get_job_title()->result_array();
    $dept=$this->Administration_m->get_divisi_departemen()->result_array();
    $district=$this->Administration_m->get_dist_name()->result_array();

    $data = array(
    'controller_name'=>"administration",
    'jobtitle' =>$jobtitle,
    'dept' =>$dept,
    'district' =>$district,
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/admin_tools/position/edit_position_v',"Ubah Posisi",$data);