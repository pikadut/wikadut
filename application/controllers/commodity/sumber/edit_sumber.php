<?php

  $data = array();

  $post = $this->input->post();

  $selection = $this->data['selection_sourcing'];


if(empty($selection)){

  $this->setMessage("Pilih data belum disetujui yang ingin diubah");
  redirect(site_url("commodity/data_referensi/sumber"));

}

  foreach($selection as $k => $v){

    $getdata = $this->Commodity_m->getSourcing($v)->row_array();

    if(!empty($getdata)){
      $data["sourcing"][] = $getdata;
    }

  }

  $view = 'commodity/sumber/form_edit_sumber_v';

  $this->template($view,"Ubah Sumber",$data);