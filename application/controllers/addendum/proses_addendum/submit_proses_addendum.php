<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];

$last_comment = $this->Comment_m->getAddendum("",$id)->row_array();

$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 3000;

$contract_id = $last_comment['contract_id'];

$ammend_id = $last_comment['ammend_id'];

$contract = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $contract['ptm_number'];

$input = array();

$input_doc = array();

$input_item = array();

$input_prep = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");


if($last_activity == 3000){

    $input['subject_work'] = $post['subject_work_inp'];
  $input['scope_work'] = $post['scope_work_inp'];
  $input['ammend_description'] = $post['deskripsi_addendum_inp'];
  $input['ammend_reason'] = $post['justifikasi_addendum_inp'];
  $input['contract_type_2'] = $post['jenis_kontrak_inp'];
  $input['contract_amount'] = moneytoint($post['nilai_kontrak_inp']);
  $input['contract_number'] = $this->Contract_m->getUrut("",$post['jenis_kontrak_inp']);

  $mulai = $post['tgl_mulai_inp'];
  $akhir = $post['tgl_akhir_inp'];
  $input['start_date'] = $mulai;
  $input['end_date'] = $akhir;
  if(strtotime($akhir) < strtotime($mulai)){
    $this->setMessage("Tanggal berakhir kontrak tidak boleh kurang dari tanggal mulai kontrak");
    if(!$error){
      $error = true;
    }
  }

  $milestone = 0.0;

  if(isset($post['milestone_percent'])){

    foreach ($post['milestone_percent'] as $key => $value) {
      //echo moneytoint($value)."<br/>";
      $milestone += moneytoint($value);
    }

  }

  if($milestone != 100.0) {
    $this->setMessage("Milestone harus 100%");
    if(!$error){
      $error = true;
    }
  }

}

$input_doc = array();

$input_milestone = array();

$n = 0;

$this->form_validation->set_rules("id", 'ID', 'required');

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules($key."[".$key2."]", '', '');

      if(isset($post['doc_id_inp'][$key2])){
        $input_doc[$key2]['doc_id'] = $post['doc_id_inp'][$key2];
      }

      if(isset($post['doc_category_inp'][$key2])){
        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['category']= $post['doc_category_inp'][$key2];
      }
      if(isset($post['doc_desc_inp'][$key2])){
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $input_doc[$key2]['description']= $post['doc_desc_inp'][$key2];
      }
      if(isset($post['doc_attachment_inp'][$key2])){
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['filename']= $post['doc_attachment_inp'][$key2];
      }

      if(isset($post['doc_vendor_inp'][$key2])){
        $this->form_validation->set_rules("doc_vendor_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['publish']= $post['doc_vendor_inp'][$key2];
      }

      if(isset($post['milestone_percent'][$key2])){

        $this->form_validation->set_rules("milestone_percent[$key2]", "Bobot Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("milestone_desc[$key2]", "Jumlah Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $this->form_validation->set_rules("milestone_date[$key2]", "Tanggal Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        
        if(!empty($post['milestone_id'][$key2])){
          $input_milestone[$key2]['milestone_id']=$post['milestone_id'][$key2];
        }

        $input_milestone[$key2]['percentage']=moneytoint($post['milestone_percent'][$key2]);
        $input_milestone[$key2]['description']=$post['milestone_desc'][$key2];
        $input_milestone[$key2]['target_date']=$post['milestone_date'][$key2];

      }

    }

    $n++;

  }

}


if ($this->form_validation->run() == FALSE || $error){

  $this->renderMessage("error");

  //$this->ubah_tender_pengadaan();

} else {

  $this->db->trans_begin();


    if(!empty($input)){

      $act = $this->Addendum_m->updateData($ammend_id,$input);

    } else {

      $act = true;

    }


    $complete_comment = 1;

    if($act){

      if(!empty($input_doc)){

        $deleted = array();

        foreach ($input_doc as $key => $value) {
          $value['ammend_id'] = $ammend_id;
          $id = (isset($value['doc_id'])) ? $value['doc_id'] : "";
          $act = $this->Addendum_m->replaceDoc($id,$value);
          if($act){
            $deleted[] = $act;
          }
        }

        $this->Addendum_m->deleteIfNotExistDoc($ammend_id,$deleted);

      }

      if(!empty($input_milestone)){

        $deleted = array();

        foreach ($input_milestone as $key => $value) {
          $value['ammend_id'] = $ammend_id;
          $act = $this->Addendum_m->replaceMilestone($key,$value);
          if($act){
            $deleted[] = $act;
          }
        }

        $this->Addendum_m->deleteIfNotExistMilestone($ammend_id,$deleted);

      }

/*
      if($last_activity == 3000){

      //COPY ITEM

        $prc = $this->db->where("ptm_number",$ptm_number)->get("vw_prc_monitor")->row_array();

        $vendor_id = $prc['vendor_id'];

        $this->db->where("vendor_id",$vendor_id);

        $quo_item = $this->Procrfq_m->getViewVendorQuoComRFQ("","",$ptm_number)->result_array();

        foreach ($quo_item as $key => $value) {

         $list_qty = array($value['pqi_quantity'],$value['pqi_quantity']);

         $inp = array(
          "tit_id"=>$value['tit_id'],
          "ammend_id"=>$ammend_id,
          "item_code"=>$value['tit_code'],
          "short_description"=>$value['short_description'],
          "long_description"=>$value['long_description'],
          "price"=>$value['pqi_price'],
          "qty"=>$value['pqi_quantity'],
          "min_qty"=>min($list_qty),
          "max_qty"=>max($list_qty),
          "uom"=>$value['tit_unit'],
          );
         $act = $this->Addendum_m->insertItem($inp);

       }

     }

     */

     $response = $post['status_inp'][0];

     $com = $post['comment_inp'][0];

     $return = $this->Procedure3_m->ctr_ammend_comment_complete($ptm_number,$userdata['complete_name'],$last_activity,$response,$com,"",$last_comment['comment_id'],$contract_id,$ammend_id,$userdata['employee_id']);

     if(!empty($return['nextactivity'])){

       $comment = $this->Comment_m->insertAddendum($ammend_id,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$contract_id);

     }

     if(!empty($return['message'])){
      $this->setMessage($return['message']);
      if(!$error){
        $error = true;
      }
    }

  }

  if(!$error){
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
    $this->renderMessage("success",site_url("contract/daftar_pekerjaan"));
  } else {
    $this->renderMessage("error");
  }

}
