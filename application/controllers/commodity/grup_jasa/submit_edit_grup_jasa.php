<?php


$post= $this->input->post();

$input=array();

$n = 0;

foreach ($post as $key => $value) {

  if(is_array($value)){ 

    foreach ($value as $key2 => $value2) { 

      $parent = $post['parent_inp'][$key2];

      $code = $post['code_inp'][$key2];

      $max_length_code = (!empty($parent)) ? 8 : 2;

      $current_code = $this->Commodity_m->getSrvGroup($key2)->row()->srv_group_code;

      if($current_code != $code){

        $this->form_validation->set_rules("code_inp[$key2]", "lang:code #$key2", 'required|is_unique[com_group.group_code]|numeric|min_length['.$max_length_code.']|max_length['.$max_length_code.']');

      }      

      $this->form_validation->set_rules("name_inp[$key2]", "lang:name #$key2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
        //$this->form_validation->set_rules("parent_inp[$key2]", "lang:parent #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

      $input[$key2]['srv_group_code']=url_title($code,"_",false);
      $input[$key2]['srv_group_name']=$post['name_inp'][$key2];
      $input[$key2]['srv_group_parent']=$parent;
      $input[$key2]['srv_group_status']=null;
      $input[$key2]['comment']=$post['comment_inp'][$key2];

    }

    $n++;

  }

}

if ($this->form_validation->run() == FALSE){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->edit_grup_jasa();

} else {

  $this->db->trans_begin();

  foreach ($input as $key => $value) {
    $com = $value['comment'];
    unset($value['comment']);
    $act = $this->Commodity_m->updateDataSrvGroup($key,$value);
    if($act){
      $this->Comment_m->insertCommodity("","SERVICE GROUP",$com,0,"Ubah",$key);
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

  redirect(site_url("commodity/katalog/grup_jasa"));

}
