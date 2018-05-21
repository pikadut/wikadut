<?php

$error = false;

$post = $this->input->post();

$ptm_number = $post['id'];

$input_doc = array();

$n = 0;

$this->form_validation->set_rules("id", 'ID', 'required');

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules($key."[".$key2."]", '', '');

      if(isset($post['doc_id_inp'][$key2])){
        $input_doc[$key2]['ptd_id'] = $post['doc_id_inp'][$key2];
      }

      if(isset($post['doc_category_inp'][$key2])){
        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['ptd_category']= $post['doc_category_inp'][$key2];
      }
      if(isset($post['doc_desc_inp'][$key2])){
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $input_doc[$key2]['ptd_description']= $post['doc_desc_inp'][$key2];
      }
      if(isset($post['doc_attachment_inp'][$key2])){
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['ptd_file_name']= $post['doc_attachment_inp'][$key2];
      }
      if(isset($post['doc_type_inp'][$key2])){
        $input_doc[$key2]['ptd_type']= $post['doc_type_inp'][$key2];
      }

    }

    $n++;

  }

}

if ($this->form_validation->run() == FALSE || $error){

  $this->renderMessage("error");

} else {

  $this->db->trans_begin();

  if(!empty($input_doc)){

    $deleted = array();

    foreach ($input_doc as $key => $value) {
      $value['ptm_number'] = $ptm_number;
      $act = $this->Procrfq_m->replaceDokumenRFQ($key,$value);
      if($act){
        $deleted[] = $act;
      }
    }

    $this->Procrfq_m->deleteIfNotExistDokumenRFQ($ptm_number,$deleted);

  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal mengubah data");
    $this->db->trans_rollback();
    $this->renderMessage("error");
  }
  else
  {
    $this->db->trans_commit();
    $this->renderMessage("success",site_url("procurement/procurement_tools/update_lampiran_dokumen_pengadaan"));
  }


}
