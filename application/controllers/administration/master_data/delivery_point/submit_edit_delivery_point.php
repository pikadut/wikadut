<?php 

		$ubah= $this->input->post();
		$id=$ubah['id'];
		
        $data = array(
        'del_point_code' =>$ubah['del_point_code_delivpoint_inp'],
        'del_point_name' => $ubah['del_point_name_delivpoint_inp'],
  );    

		$this->db->where('del_point_id', $id);
		$update=$this->db->update('adm_del_point', $data);
		if($update){
    	$this->setMessage("Berhasil mengubah delivery point");
    }

		redirect(site_url('administration/master_data/delivery_point'));