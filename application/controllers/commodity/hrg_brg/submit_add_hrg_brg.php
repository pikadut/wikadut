<?php

$post= $this->input->post();

$input=array();

$n = 0;

$userdata = $this->data['userdata'];

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      //$this->form_validation->set_rules("code_inp[$key2]", "lang:code #$key2", 'required|integer|is_unique[com_mat_price.mat_price_id]|max_length['.DEFAULT_MAXLENGTH_CODE.']');
      $this->form_validation->set_rules("catalog_inp[$key2]", "lang:catalog #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("del_point_inp[$key2]", "lang:office #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("sourcing_inp[$key2]", "lang:sourcing #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("sourcing_date_inp[$key2]", "lang:sourcing_date #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("total_cost_inp[$key2]", "lang:total_cost #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("unit_price_inp[$key2]", "lang:unit_price #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("handling_cost_inp[$key2]", "lang:handling_cost #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("insurance_cost_inp[$key2]", "lang:insurance_cost #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("freight_cost_inp[$key2]", "lang:freight_cost #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("tax_duty_inp[$key2]", "lang:tax_duty #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("discount_inp[$key2]", "lang:discount #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      //$this->form_validation->set_rules("currency_inp[$key2]", "lang:currency #$key2", 'max_length[3]');
      $this->form_validation->set_rules("vendor_inp[$key2]", "lang:vendor #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("note_inp[$key2]", "lang:note #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
      $this->form_validation->set_rules("comment_inp[$key2]", "lang:comment #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');

      //$input[$key2]['mat_price_id']=url_title($post['code_inp'][$key2],"_",false);
      $catalog_id = $post['catalog_inp'][$key2];
      $del_point_id = $post['del_point_inp'][$key2];
      $catalog = $this->Commodity_m->getMatCatalog($catalog_id)->row_array();
      $del_point = $this->Administration_m->getDelPoint($del_point_id)->row_array();

      $input[$key2]['mat_catalog_code']=$catalog_id;
      $input[$key2]['short_description']=$catalog['short_description'];
      $input[$key2]['long_description']=$catalog['long_description'];
      $input[$key2]['del_point_id']=$del_point_id;
      $input[$key2]['del_point_name']=$del_point['del_point_name'];
      $input[$key2]['sourcing_id']=$post['sourcing_inp'][$key2];
      $input[$key2]['sourcing_date']=$post['sourcing_date_inp'][$key2];
      $input[$key2]['unit_price']= moneytoint($post['unit_price_inp'][$key2]);
      $input[$key2]['handling_cost']= moneytoint($post['handling_cost_inp'][$key2]);
      $input[$key2]['insurance_cost']= moneytoint($post['insurance_cost_inp'][$key2]);
      $input[$key2]['freight_cost']= moneytoint($post['freight_cost_inp'][$key2]);
      $input[$key2]['tax_duty']= moneytoint($post['tax_duty_inp'][$key2]);
      $input[$key2]['total_cost']= moneytoint($post['total_cost_inp'][$key2]);
      $input[$key2]['discount']= moneytoint($post['discount_inp'][$key2]);
      $input[$key2]['currency']=$post['currency_inp'][$key2];
      $input[$key2]['vendor']=$post['vendor_inp'][$key2];
      //$input[$key2]['is_active']=$post['active_inp'][$key2];
      $input[$key2]['attachment']=$post['attachment_inp'][$key2];
      $input[$key2]['notes']=$post['note_inp'][$key2];
      $input[$key2]['status']="";
      $input[$key2]['update_by']=$userdata['employee_id'];
      $input[$key2]['comment']=$post['comment_inp'][$key2];

    }

    $n++;

  }

}

if ($this->form_validation->run() == FALSE){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->add_hrg_brg();

} else {

  $this->db->trans_begin();

  foreach ($input as $key => $value) {
    $com = $value['comment'];
    unset($value['comment']);
    $act = $this->Commodity_m->insertDataMatPrice($value);
    if($act){
      $this->Comment_m->insertCommodity($value['mat_catalog_code'],"MATERIAL PRICE",$com,$act,"Buat");
    }
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

  
  redirect(site_url("commodity/daftar_harga/daftar_harga_barang"));

}