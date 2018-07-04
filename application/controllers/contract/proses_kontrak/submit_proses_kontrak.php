<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];

$last_comment = $this->Comment_m->getContract("",$id)->row_array();

$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 2000;

$ptm_number = $last_comment['tender_id'];

$contract_id = $last_comment['contract_id'];

$tender = $this->Procrfq_m->getRFQ($last_comment['tender_id'])->row_array();

$input = array();

$input_doc = array();

$input_item = array();

$input_prep = array();

$userdata = $this->data['userdata'];

$pelaksana_id = $userdata['employee_id'];

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  //$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

if($last_activity == 2000){

  $contract = $this->Contract_m->getContractNew($ptm_number)->row_array();
  $input['ptm_number'] = $ptm_number;
  $input['vendor_id'] = $contract['vendor_id'];
  $input['vendor_name'] = $contract['vendor_name'];
  $input['subject_work'] = $contract['ptm_subject_of_work'];
  $input['scope_work'] = $contract['ptm_scope_of_work'];
  $input['contract_type'] = $contract['ptm_contract_type'];
  $input['completed_tender_date'] = $contract['ptm_completed_date'];
  $input['contract_amount'] = $contract['total_contract'];

  if(isset($post['manager_kontrak_inp'])){
    $this->form_validation->set_rules("manager_kontrak_inp", "Manager Kontrak", 'required|max_length['.DEFAULT_MAXLENGTH.']');
  }

  $pelaksana_id = (isset($post['manager_kontrak_inp'])) ? $post['manager_kontrak_inp'] : null;

  $this->db->where("job_title","MANAJER PENGADAAN");

  $pelaksana = $this->Administration_m->getUserRule($pelaksana_id)->row_array();

  if(!empty($pelaksana)){
    $input['ctr_man_employee'] = $pelaksana['employee_id'];
    $input['ctr_man_pos'] = $pelaksana['pos_id'];
    $input['ctr_man_pos_name'] = $pelaksana['pos_name'];
  }

}

if($last_activity == 2001){

  if(isset($post['pelaksana_kontrak_inp'])){
    $this->form_validation->set_rules("pelaksana_kontrak_inp", "Pelaksana Kontrak", 'required|max_length['.DEFAULT_MAXLENGTH.']');
  }

  $pelaksana_id = (isset($post['pelaksana_kontrak_inp'])) ? $post['pelaksana_kontrak_inp'] : null;

  $this->db->where("job_title","PENGELOLA KONTRAK");

  $pelaksana = $this->Administration_m->getUserRule($pelaksana_id)->row_array();

  if(!empty($pelaksana)){
    $input['ctr_spe_employee'] = $pelaksana['employee_id'];
    $input['ctr_spe_pos'] = $pelaksana['pos_id'];
    $input['ctr_spe_pos_name'] = $pelaksana['pos_name'];
  }

}

$status_id = $post['status_inp'][0];

if(in_array($last_activity, array(2030))){

  $this->form_validation->set_rules("nama_bank_inp", "Institusi Keuangan", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("no_jaminan_inp", "No Jaminan", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("nilai_jaminan_inp", "Nilai Jaminan", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("mulai_berlaku_inp", "Mulai Berlaku", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("berlaku_hingga_inp", "Berlaku Hingga", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("jaminan_file_inp", "File Jaminan", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("jenis_kontrak_inp", "Jenis Kontrak", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("tgl_mulai_inp", "Tanggal Mulai Kontrak", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("tgl_akhir_inp", "Tanggal Akhir Kontrak", 
    'required|max_length['.DEFAULT_MAXLENGTH.']');

  $input['created_date'] = date("Y-m-d H:i:s");
  $input['pf_bank'] = $post['nama_bank_inp'];
  $input['pf_amount'] = moneytoint($post['nilai_jaminan_inp']);
  $input['pf_number'] = $post['no_jaminan_inp'];
  $input['pf_start_date'] = (!empty($post['mulai_berlaku_inp'])) ? date("Y-m-d",strtotime($post['mulai_berlaku_inp'])) 
  : null;
  $input['pf_end_date'] = (!empty($post['berlaku_hingga_inp'])) ? date("Y-m-d",strtotime($post['berlaku_hingga_inp'])) 
  : null;
  $input['pf_attachment'] = $post['jaminan_file_inp'];

}

if(in_array($last_activity, array(2010))){

  if(isset($post['min_qty'])){

    foreach ($post['min_qty'] as $key => $min) {

      $max = $post['max_qty'][$key];

      if($max < $min || $min < 1){

        $this->setMessage("Jumlah minimum harus diatas nol dan Jumlah maksimum tidak boleh dibawah jumlah minimum");

        if(!$error){
          $error = true;
        }

      }

    }

  }

}

if(in_array($last_activity, array(2030))){

  $contract = $this->Contract_m->getData($contract_id)->row_array();
  
  $tipe_pengadaan = $this->Administration_m->isHeadQuatersProcurement($ptm_number);

  $getdept = $this->db->select("dep_code")
  ->join("adm_dept","ptm_dept_id=dept_id")
  ->where("ptm_number",$ptm_number)
  ->get("prc_tender_main")
  ->row()->dep_code;

  $input['contract_number'] = $this->Contract_m->getUrut("", $contract['contract_type'], $post['jenis_kontrak_inp'], $tipe_pengadaan, $getdept);

}

if(in_array($last_activity, array(2010,2030))){

  $contract = $this->Contract_m->getData($contract_id)->row_array();

  $input['subject_work'] = $post['subject_work_inp'];
  $input['scope_work'] = $post['scope_work_inp'];
  $input['contract_type_2'] = $post['jenis_kontrak_inp'];

  $mulai = $post['tgl_mulai_inp'];
  $akhir = $post['tgl_akhir_inp'];
  $input['start_date'] = (!empty($mulai)) ? date("Y-m-d",strtotime($mulai)) : null;
  $input['end_date'] = (!empty($mulai)) ? date("Y-m-d",strtotime($akhir)) : null;
  if(strtotime($akhir) < strtotime($mulai)){
    $this->setMessage("Tanggal berakhir kontrak tidak boleh kurang dari tanggal mulai kontrak");
    if(!$error){
      $error = true;
    }
  }

  if($contract['contract_type'] != "HARGA SATUAN" && !empty($status_id) && $status_id == 444){

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

} else {

  $this->db->trans_begin();


  if(!empty($input)){

    $act = $this->Contract_m->updateData($contract_id,$input);

  } else {

    $act = true;

  }

  $complete_comment = 1;

    //if($act){

  if(!empty($input_doc)){

    $deleted = array();

    foreach ($input_doc as $key => $value) {
      $value['contract_id'] = $contract_id;
      $id = (isset($value['doc_id'])) ? $value['doc_id'] : "";
      $act = $this->Contract_m->replaceDoc($id,$value);
      if($act){
        $deleted[] = $act;
      }
    }

    $this->Contract_m->deleteIfNotExistDoc($contract_id,$deleted);

  }

  if(!empty($input_milestone)){

    $deleted = array();

    foreach ($input_milestone as $key => $value) {
      $value['contract_id'] = $contract_id;
      $act = $this->Contract_m->replaceMilestone($key,$value);
      if($act){
        $deleted[] = $act;
      }
    }

    $this->Contract_m->deleteIfNotExistMilestone($contract_id,$deleted);

  }

  if(isset($post['tax_ppn'])){

    foreach ($post['tax_ppn'] as $key => $value) {
      $getitem = $this->db->where("contract_item_id",$key)->get("ctr_contract_item")->row_array();
      $ppn = $value;
      $pph = (!empty($post['tax_pph'][$key])) ? $post['tax_pph'][$key] : NULL;
      $input['sub_total'] = (1+(($ppn+$pph)/100))*($getitem['price']*$getitem['qty']);
      $input = array("ppn"=>$ppn,"pph"=>$pph);
      if(isset($post['min_qty'])){
        $input['min_qty'] = $post['min_qty'][$key];
      }
      if(isset($post['max_qty'])){
        $input['max_qty'] = $post['max_qty'][$key];
      }
      $this->db->where("contract_item_id",$key)->update("ctr_contract_item",$input);
    }

  }

  $response = $post['status_inp'][0];

  $com = $post['comment_inp'][0];

  $attachment = $post['comment_attachment_inp'][0];

//hlmifzi
if ($last_activity == 2901) {
  //start code hlmifzi
  $jumlah = count($post['id_question']);
  $penilaian = [];
  $contract = $this->Contract_m->getContractNew($ptm_number)->row_array();

  for ($a=0; $a < $jumlah; $a++) { 
    $penilaian[$a]['contract_id']= $contract_id;
    $penilaian[$a]['vendor_id']= $contract['vendor_id'];
    $penilaian[$a]['ccp_id_question']= $post['id_question'][$a];
    $penilaian[$a]['ccp_answer']= $post['jawaban'][$a];
    $penilaian[$a]['ccp_id_commodity_cat']=$post['id_commodity_cat'];
    $penilaian[$a]['user_Created']=$userdata['employee_id'];
    $penilaian[$a]['date_created']=date('Y-m-d h:i:s');
    $penilaian[$a]['aktif']=1;
  }

/*var_dump($penilaian);
exit();*/
foreach ($penilaian as $key => $value) {

  $this->db->insert('ctr_contract_penilaian',$penilaian[$key]);
}
}


  $return = $this->Procedure2_m->ctr_contract_comment_complete($ptm_number,$userdata['complete_name'],$last_activity,$response,$com,$attachment,$last_comment['comment_id'],$contract_id,$userdata['employee_id']);

  if(!empty($return['nextactivity'])){

      //haqim
      if ($response == '445') {
        $ccc_user = null;
      } else {
        $ccc_user = $pelaksana_id;
      }

      // print_r($return);
      $comment = $this->Comment_m->insertContract($ptm_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$contract_id,$ccc_user);

    //previous
   // $comment = $this->Comment_m->insertContract($ptm_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$contract_id,$pelaksana_id);
      // end

      //end
 }




 if(!empty($return['message'])){
  $this->setMessage($return['message']);
  if(!$error){
    $error = true;
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
