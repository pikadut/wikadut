<?php 

  $view = 'vendor/kinerja_vendor/kpi_vendor_v';
  $kantor=$this->Administration_m->get_dist_name()->result_array();

  $data = array(
  	"kantor"=>$kantor,
      'jumlah' =>1,

    );

  $this->template($view,"KPI Vendor",$data);