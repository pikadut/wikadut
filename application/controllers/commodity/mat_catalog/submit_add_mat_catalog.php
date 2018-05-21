<?php

  $post= $this->input->post();

  $input=array();

  $n = 0;

  $userdata = $this->data['userdata'];

  foreach ($post as $key => $value) {

    if(is_array($value)){

      foreach ($value as $key2 => $value2) { 

        //$this->form_validation->set_rules("code_inp[$key2]", "lang:code #$key2", 'required|is_unique[com_mat_catalog.mat_catalog_code]|max_length['.DEFAULT_MAXLENGTH_CODE.']');
        $this->form_validation->set_rules("group_level1_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
		$this->form_validation->set_rules("group_level2_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
		$this->form_validation->set_rules("group_level3_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
		$this->form_validation->set_rules("group_level4_inp[$key2]", "lang:group #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
		$this->form_validation->set_rules("info_inp[$key2]", "lang:info #$key2", 'required');
		$this->form_validation->set_rules("uom_inp[$key2]", "lang:uom #$key2", 'required');
		
		$long_desc = "";
        $input[$key2]['long_description']=$post['info_inp'][$key2];
		$long_desc .= $input[$key2]['long_description'];

		if(!empty($post['merek_inp'][$key2])){
		$input[$key2]['brand']=$post['merek_inp'][$key2];
		$long_desc .= "; MEREK: ".$input[$key2]['brand'];
		}
		
		if(!empty($post['material_inp'][$key2])){
		$input[$key2]['material']=$post['material_inp'][$key2];	
		$long_desc .= "; MATERIAL: ".$input[$key2]['material'];
		}
		
		if(!empty($post['tipe_inp'][$key2])){
		$input[$key2]['tipe']=$post['tipe_inp'][$key2];	
		$long_desc .= "; TIPE: ".$input[$key2]['tipe'];
		}
		
		if(!empty($post['part_inp'][$key2])){
		$input[$key2]['part_number']=$post['part_inp'][$key2];	
		$long_desc .= "; PART NUMBER: ".$input[$key2]['part_number'];
		}
		
		if(!empty($post['ukuran_inp'][$key2])){
		$input[$key2]['ukuran']=$post['ukuran_inp'][$key2];	
		$long_desc .= "; UKURAN: ".$input[$key2]['ukuran'];
		}
		
		if(!empty($post['spesifikasi_inp'][$key2])){
		$input[$key2]['spesifikasi']=$post['spesifikasi_inp'][$key2];	
		$long_desc .= "; SPESIFIKASI: ".$input[$key2]['spesifikasi'];
		}
		
		if(!empty($post['model_inp'][$key2])){
		$input[$key2]['model_number']=$post['model_inp'][$key2];	
		$long_desc .= "; MODEL: ".$input[$key2]['model_number'];
		}
		
		if(!empty($post['serial_inp'][$key2])){
		$input[$key2]['serial_number']=$post['serial_inp'][$key2];	
		$long_desc .= "; SERIAL: ".$input[$key2]['serial_number'];
		}
		
		if(!empty($post['warna_inp'][$key2])){
		$input[$key2]['warna']=$post['warna_inp'][$key2];	
		$long_desc .= "; WARNA: ".$input[$key2]['warna'];
		}
		
		if(!empty($post['uom_inp'][$key2])){
		$input[$key2]['uom']=strtoupper($post['uom_inp'][$key2]);	
		$long_desc .= "; SATUAN: ".$input[$key2]['uom'];
		}
		
		if(!empty($post['pabrik_inp'][$key2])){
		$input[$key2]['manufacturer']=$post['pabrik_inp'][$key2];	
		$long_desc .= "; PABRIK: ".$input[$key2]['manufacturer'];
		}
		
		if(!empty($post['lokasi_inp'][$key2])){
		$input[$key2]['lokasi']=$post['lokasi_inp'][$key2];	
		$long_desc .= "; LOKASI: ".$input[$key2]['lokasi'];
		}
		
		if(!empty($post['kode_inp'][$key2])){
		$input[$key2]['kode']=$post['kode_inp'][$key2];	
		$long_desc .= "; KODE: ".$input[$key2]['kode'];
		}
		
		if(!empty($post['others_inp'][$key2])){
		$input[$key2]['others']=$post['others_inp'][$key2];
		$long_desc .= "; LAIN-LAIN : ".$input[$key2]['others'];
		}
		
		$input[$key2]['short_description'] = $long_desc;
        
		$input[$key2]['mat_group_code']=$post['group_level4_inp'][$key2];
		if(!empty($post['image_inp'][$key2])){
		$input[$key2]['image']=$post['image_inp'][$key2];
		}
		if(!empty($post['attachment_inp'][$key2])){
        $input[$key2]['attachment']=$post['attachment_inp'][$key2];
		}
        $input[$key2]['status']="";
        $input[$key2]['last_update_by']=$userdata['employee_id'];
        $input[$key2]['comment']=$post['comment_inp'][$key2];

      }

      $n++;

    }

  }

  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->add_mat_catalog();

  } else {

$this->db->trans_begin();

    foreach ($input as $key => $value) {
      $com = $value['comment'];
      unset($value['comment']);
      $act = $this->Commodity_m->insertDataMatCatalog($value);
      if($act){
        $this->Comment_m->insertCommodity($act,"MATERIAL CATALOG",$com,0,"Buat");
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

    redirect(site_url("commodity/katalog/katalog_barang"));

  }
