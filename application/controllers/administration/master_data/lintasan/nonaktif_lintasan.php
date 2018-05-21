<?php 

		$id= $this->uri->segment(5, 0);

        $data = array(
        'lane_active' =>0,
  );    

		$this->db->where('lane_id', $id);
		$update=$this->db->update('adm_lane', $data);

		redirect(site_url('administration/master_data/lintasan'));