<?php 

		$id= $this->uri->segment(5, 0);

        $data = array(
        'dept_active' =>0,
  );    

		$this->db->where('dept_id', $id);
		$update=$this->db->update('adm_dept', $data);

		redirect(site_url('administration/master_data/divisi_departemen'));