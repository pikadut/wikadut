<?php 

		$id= $this->uri->segment(5, 0);

        $data = array(
        'del_point_active' =>0,
  );    

		$this->db->where('del_point_id', $id);
		$update=$this->db->update('adm_del_point', $data);

		redirect(site_url('administration/master_data/delivery_point'));