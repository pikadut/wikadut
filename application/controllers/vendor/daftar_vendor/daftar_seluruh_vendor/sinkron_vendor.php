<?php

        $this->load->model("Sinkron_m");

$login_status = $this->Sinkron_m->do_sinkron();

  redirect(site_url('vendor/daftar_vendor/daftar_seluruh_vendor'));

  //var_dump($login_status); die();

 ?>