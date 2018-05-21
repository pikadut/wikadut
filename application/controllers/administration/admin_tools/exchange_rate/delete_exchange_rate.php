<?php

		$this->db->where('exchange_rate_id', $id);
		$this->db->delete('adm_exchange_rate'); 
		redirect(site_url('administration/admin_tools/exchange_rate'));
	