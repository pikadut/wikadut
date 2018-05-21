<?php

  $post= $this->input->post();

  $input=array();

  $n = 0;

  $userdata = $this->data['userdata'];

  foreach ($post as $key => $value) {

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules("group_level1_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
	  $this->form_validation->set_rules("group_level2_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
	  $this->form_validation->set_rules("group_level3_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
	  $this->form_validation->set_rules("group_level4_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("info_inp[$key2]", "lang:info #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');

      if($post['group_level4_inp'][$key2] != substr($key2,0,strlen($post['group_level4_inp'][$key2]))){
		$input[$key2]['srv_group_code']=$post['group_level4_inp'][$key2];
	  }
      $input[$key2]['long_description']=$post['info_inp'][$key2];
	  $input[$key2]['short_description']=$post['info_inp'][$key2];
	  if(!empty($post['tipe_inp'][$key2])){
	  $input[$key2]['tipe']=$post['tipe_inp'][$key2];
	  $input[$key2]['short_description'] .= "; TIPE : ".$input[$key2]['tipe'];
	  }
	  if(!empty($post['lokasi_inp'][$key2])){
	  $input[$key2]['lokasi']=$post['lokasi_inp'][$key2];
	  $input[$key2]['short_description'] .= "; LOKASI : ".$input[$key2]['lokasi'];
	  }
	  if(!empty($post['uraian_inp'][$key2])){
	  $input[$key2]['others']=$post['uraian_inp'][$key2];
	  $input[$key2]['short_description'] .= "; LAIN-LAIN : ".$input[$key2]['others'];
	  }
      $input[$key2]['status']="";
      $input[$key2]['last_update_by']=$userdata['employee_id'];
      $input[$key2]['comment']=$post['comment_inp'][$key2];

    }

    $n++;

  }

  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->edit_kat_jasa();

  } else {

    $this->db->trans_begin();

    foreach ($input as $key => $value) {
      $com = $value['comment'];
      unset($value['comment']);
      $act = $this->Commodity_m->updateDataSrvCatalog($key,$value);
      if($act){
		if(isset($value["srv_group_code"])){
			$this->Comment_m->updateCommodity($key,$act);
			$this->Comment_m->insertCommodity($act,"SERVICE CATALOG",$com,0,"Ubah");
		}
		else{
			$this->Comment_m->insertCommodity($key,"SERVICE CATALOG",$com,0,"Ubah");
		}
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

    redirect(site_url("commodity/katalog/katalog_jasa"));

  }
