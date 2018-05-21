<?php

		$this->db->where('curr_id', $id);
		$this->db->delete('adm_curr'); 
		redirect(site_url('administration/master_data/currency'));
	