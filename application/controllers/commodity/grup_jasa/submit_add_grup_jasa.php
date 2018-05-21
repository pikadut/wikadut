<?php

$post= $this->input->post();

$input=array();

$n = 0;

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules("name_inp[$key2]", "lang:name #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("level2_inp[$key2]", "lang:parent #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');

      $input[$key2]['srv_group_name']=$post['name_inp'][$key2];
	  if(empty($post['level3_inp'][$key2])){
		$input[$key2]['srv_group_parent']=$post['level2_inp'][$key2];
	  }
	  else{
		$input[$key2]['srv_group_parent']=$post['level3_inp'][$key2];
	  }

    }

    $n++;

  }

}

if ($this->form_validation->run() == FALSE){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->add_grup_jasa();

} else {

  $this->db->trans_begin();

  foreach ($input as $key => $value) {
   $act = $this->Commodity_m->insertDataSrvGroup($value);
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

redirect(site_url("commodity/katalog/grup_jasa"));

}
