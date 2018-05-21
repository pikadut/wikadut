<?php

    $currency=$this->Administration_m->getCurrency()->result_array();
    $data = array(
    'controller_name'=>"administration",
    'currency' =>$currency,
    );

    $this->template('administration/admin_tools/exchange_rate/add_exchange_rate_v',"Tambah Nilai Tukar",$data);
  