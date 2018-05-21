<?php 

    $this->db->where('lane_id', $id);
    $query = $this->db->get('adm_lane');
    

    $dist_name=$this->Administration_m->get_dist_name()->result_array();
	$dept_name=$this->Administration_m->get_harbour()->result_array();

    $data = array(
		'controller_name'=>"administration",
		'dept_name' =>$dept_name,
		'dist_name' =>$dist_name
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;
    $data['tipe_list'] = array("Tidak","Ya");

    $this->template('administration/master_data/lintasan/edit_lintasan_v',"Ubah Lintasan",$data);