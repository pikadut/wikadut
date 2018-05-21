<?php

$post = $this->input->post();

if(!empty($post)){

  $input = array();

  $n = 0;

  foreach ($post as $key => $value) {

    if(is_array($value)){

      foreach ($value as $key2 => $value2) { 

      //$this->form_validation->set_rules("code_inp[$key2]", "lang:code #$key2", 'required|integer|is_unique[com_sourcing.sourcing_id]|max_length['.DEFAULT_MAXLENGTH_CODE.']');
        $this->form_validation->set_rules("name_inp[$key2]", "lang:sourcing #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("type_inp[$key2]", "lang:type #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

      //$input[$key2]['sourcing_id']=url_title($post['code_inp'][$key2],"_",false);
        $input[$key2]['sourcing_name']=$post['name_inp'][$key2];
        $input[$key2]['sourcing_type']=$post['type_inp'][$key2];

      }

      $n++;

    }

  }

  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->add_sumber();

  } else {

    $this->db->trans_begin();

    foreach ($input as $key => $value) {

      $act = $this->Commodity_m->insertDataSourcing($value);

    }

    if ($this->db->trans_status() === FALSE)
    {
      $this->setMessage("Gagal menambah data");
      $this->db->trans_rollback();
    }
    else
    {
      $this->setMessage("Sukses menambah data");
      $this->db->trans_commit();
    }

    redirect(site_url("commodity/data_referensi/sumber"));

  }

} else {

  redirect(site_url("commodity/data_referensi/sumber"));

}