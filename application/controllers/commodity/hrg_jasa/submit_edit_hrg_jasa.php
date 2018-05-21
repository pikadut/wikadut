<?php

$post= $this->input->post();

$input=array();

$n = 0;

$userdata = $this->data['userdata'];

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules("catalog_inp[$key2]", "lang:catalog #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("del_point_inp[$key2]", "lang:office #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("sourcing_inp[$key2]", "lang:sourcing #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("total_price_inp[$key2]", "lang:total_price #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      //$this->form_validation->set_rules("currency_inp[$key2]", "lang:currency #$key2", 'max_length[3]');
      $this->form_validation->set_rules("vendor_inp[$key2]", "lang:vendor #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("note_inp[$key2]", "lang:note #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
      $this->form_validation->set_rules("comment_inp[$key2]", "lang:comment #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');

      $catalog_id = $post['catalog_inp'][$key2];
      $del_point_id = $post['del_point_inp'][$key2];
      $catalog = $this->Commodity_m->getSrvCatalog($catalog_id)->row_array();
      $del_point = $this->Administration_m->getDelPoint($del_point_id)->row_array();

      $input[$key2]['srv_catalog_code']=$catalog_id;
      $input[$key2]['short_description']=$catalog['short_description'];
      $input[$key2]['long_description']=$catalog['long_description'];
      $input[$key2]['del_point_id']=$del_point_id;
      $input[$key2]['del_point_name']=$del_point['del_point_name'];
      $input[$key2]['sourcing_id']=$post['sourcing_inp'][$key2];
      $input[$key2]['sourcing_date']=$post['sourcing_date_inp'][$key2];
      $input[$key2]['total_price']= moneytoint($post['total_price_inp'][$key2]);
      $input[$key2]['currency']=$post['currency_inp'][$key2];
      $input[$key2]['vendor']=$post['vendor_inp'][$key2];
      //$input[$key2]['is_active']=$post['active_inp'][$key2];
      $input[$key2]['attachment']=$post['attachment_inp'][$key2];
      $input[$key2]['notes']=$post['note_inp'][$key2];
      $input[$key2]['status']="";
      $input[$key2]['updated_by']=$userdata['employee_id'];
      $input[$key2]['comment']=$post['comment_inp'][$key2];

    }

    $n++;

  }

}

if ($this->form_validation->run() == FALSE){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->edit_hrg_jasa();

} else {

  $this->db->trans_begin();

  foreach ($input as $key => $value) {
    $com = $value['comment'];
    unset($value['comment']);
    $act = $this->Commodity_m->updateDataSrvPrice($key,$value);
    if($act){
      $this->Comment_m->insertCommodity($value['srv_catalog_code'],"SERVICE PRICE",$com,$key,"Ubah");
    }
  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal mengubah data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses mengubah data");
    $this->db->trans_commit();
  }

  
  redirect(site_url("commodity/daftar_harga/daftar_harga_jasa"));

}