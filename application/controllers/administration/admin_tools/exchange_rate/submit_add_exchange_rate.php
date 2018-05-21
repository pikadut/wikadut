<?php 

    $tambah= $this->input->post();

    $data = array(
        'curr_from' => $tambah['curr_from_inp'],
        'curr_to' => $tambah['curr_to_inp'],
        'curr_date' => $tambah['curr_date_inp'],
        'curr_value' => $tambah['curr_value_inp'],
  );

    $this->db->insert('adm_exchange_rate', $data);
    
    redirect(site_url('administration/admin_tools/exchange_rate'));