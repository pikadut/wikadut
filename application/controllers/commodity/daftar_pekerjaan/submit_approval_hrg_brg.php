<?php

$post= $this->input->post();

$input=array();

$n = 0;

$wkf = array("R"=>"Ditolak","A"=>"Disetujui");

$userdata = $this->data['userdata'];

foreach ($post as $key => $value) {

  foreach ($value as $key2 => $value2) { 

    $this->form_validation->set_rules("status_inp[$key2]", "lang:status #$key2", 'required');
    $this->form_validation->set_rules("comment_inp[$key2]", "lang:comment #$key2", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');
    $status = $post['status_inp'][$key2];
    $input[$key2]['status']=$status;
    $input[$key2]['update_by']=$userdata['employee_id'];
    $input[$key2]['comment']=$post['comment_inp'][$key2];
    $input[$key2]['response']=$wkf[$status];

  }

  $n++;

}

if ($this->form_validation->run() == FALSE){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->approval_hrg_brg();

} else {

  $this->db->trans_begin();

  foreach ($input as $key => $value) {
    $com = $value['comment'];
    unset($value['comment']);
        $response = $value['response'];
    unset($value['response']);
    $act = $this->Commodity_m->updateDataMatPrice($key,$value);
    if($act){
      $this->Comment_m->insertCommodity($value['mat_catalog_code'],"MATERIAL PRICE",$com,$key,$response);
    }
  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal approve data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses approve data");
    $this->db->trans_commit();
  }

  redirect(site_url("commodity/daftar_pekerjaan"));

}
