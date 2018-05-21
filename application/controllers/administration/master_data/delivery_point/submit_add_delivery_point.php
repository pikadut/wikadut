<?php 

    $tambah= $this->input->post();


    $data = array(
        'del_point_code' =>$tambah['del_point_code_delivpoint_inp'],
        'del_point_name' => $tambah['del_point_name_delivpoint_inp'],
        'del_point_active'=>1,
  );
    
    $insert=$this->db->insert('adm_del_point', $data);
    if($insert){
    	$this->setMessage("Berhasil menambah delivery point");
    }
    
    redirect(site_url('administration/master_data/delivery_point'));