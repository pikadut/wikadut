<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];
$res = $post['status_inp'];
$userdata = $this->data['userdata'];

$this->db->trans_begin();
//hlmifzi
$progress = $this->db->select("a.progress_status,d.contract_amount,b.percentage,b.milestone_id,type_inv,ctr_spe_pos,b.progress_id")//end
->where("b.progress_id",$id)
->join("ctr_contract_milestone a","a.milestone_id=b.milestone_id")
->join("ctr_contract_header d","a.contract_id=d.contract_id")
->join("prc_tender_main e","e.ptm_number=d.ptm_number")
->get("ctr_contract_milestone_progress b")->row_array();

$input = array(
  "progress_status"=>99,
  "current_approver_pos"=>null,
  "current_approver_id"=>null,
  );

$milestone_id = $progress['milestone_id'];

$posname = "";
$posid = null;

if(!empty($res)){

  switch ($progress['progress_status']) {

    case 1:

    $title = "MANAJER USER";
    $status = 2;

    break;

    case 2:

    if($progress['contract_amount'] > 200000000){
      $title = "VP USER";
      $status = 3;
    } else {
     $title = "PIC BAST";
     $status = 4;
   }

   break;

   case 3:

   $title = "PIC BAST";
   $status = 4;

   break;

   case 4:

   $title = "MANAJER BAST";
   $status = 5;

   break;

   case 5:

   if($progress['contract_amount'] > 500000000){
    $title = "VP BAST";
    $status = 6;
  } else {
   $title = "";
   $status = null;
 }

 break;

 default:
 $title = "";
 $status = null;
 break;

}


 if(!empty($title)){

    $pos = $this->db->select("pos_id")
    ->where(array(
      "district_id"=>$userdata['district_id'],
      "dept_id"=>$userdata['dept_id'],
      "job_title"=>$title,
      ))->get("adm_pos")
    ->row_array();

    if(empty($pos)){

      $pos = $this->db->select("pos_id")
    ->where(array(
      "district_id"=>$userdata['district_id'],
      "job_title"=>$title,
      ))->get("adm_pos")
    ->row_array();

    }

    $posid = $pos['pos_id'];

  }

$input = array("current_approver_pos"=>$posid,"current_approver_id"=>null,"progress_status"=>$status);

} 

if(!empty($post['jenis_inp'])){
  $y['type_inv'] = $post['jenis_inp'];
}

if(empty($posid) && !empty($res)){
  $input["progress_percentage"] = $progress['percentage'];
  $y['status'] = 1;
}

if(!empty($y)){
  $this->db->where("milestone_id",$milestone_id)->update("ctr_contract_milestone_progress",$y);
}

$this->db->where("milestone_id",$milestone_id)->update("ctr_contract_milestone",$input);

$input = array(
  "milestone_id"=>$milestone_id,
  "comment_name"=>$userdata['complete_name'],
  "comment_date"=>date("Y-m-d H:i:s"),
  "comments"=>$post['komentar_inp'],
  "comment_type"=>0,
  "user_id"=>$userdata['employee_id'],
  "comment_activity"=> (!empty($res)) ? "Setuju" : "Revisi",
  );

$this->db->insert("ctr_contract_milestone_comment",$input);

//input lampiran hlmifzi
$input_comment = array();

$n = 0;
$last_id = $progress['milestone_id'];
foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      if(isset($post['doc_attachment_inp'][$key2]) && !empty($post['doc_attachment_inp'][$key2])){

        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

        $input_comment[$key2]['description']=$post['doc_desc_inp'][$key2];
        $input_comment[$key2]['filename']=$post['doc_attachment_inp'][$key2];
        $input_comment[$key2]['milestone_id'] = $last_id;
        $input_comment[$key2]['status']=1;
      }

    }

    $n++;

  }

}

 /*var_dump($input_comment);
  exit();*/
foreach ($input_comment as $key => $value) {

 
   $act =  $this->db->insert('ctr_contract_milestone_progress_doc',$input_comment[$key]);
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

