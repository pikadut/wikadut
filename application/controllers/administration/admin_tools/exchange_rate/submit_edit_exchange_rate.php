<?php 

		$ubah= $this->input->post();
		$id=$ubah['id'];
		
        $data = array(
        'curr_from' => $ubah['curr_from_inp'],
        'curr_to' => $ubah['curr_to_inp'],
        'curr_date' => $ubah['curr_date_inp'],
        'curr_value' => $ubah['curr_value_inp'],
  );    

		$this->db->where('exchange_rate_id', $id);
		$this->db->update('adm_exchange_rate', $data); 

		redirect(site_url('administration/admin_tools/exchange_rate'));