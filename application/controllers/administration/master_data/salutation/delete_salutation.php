<?php

		$this->db->where('adm_salutation_id', $id);
		$this->db->delete('adm_salutation'); 
		redirect(site_url('administration/master_data/salutation'));
	