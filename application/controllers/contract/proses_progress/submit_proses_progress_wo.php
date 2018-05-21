<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];
$res = $post['status_inp'];
$userdata = $this->data['userdata'];

$this->db->trans_begin();

$progress = $this->db->select("b.status,d.contract_amount,b.progress_percentage,b.po_id,type_inv,ctr_spe_pos,b.progress_id")
->where("b.progress_id",$id)
->join("ctr_po_header a","a.po_id=b.po_id")
->join("ctr_contract_header d","a.contract_id=d.contract_id")
->join("prc_tender_main e","e.ptm_number=d.ptm_number")
->get("ctr_po_progress_header b")->row_array();

$input = array(
  "status"=>99,
  "current_approver_pos"=>null,
  "current_approver_id"=>null,
  );

$posname = "";
$posid = null;

if(!empty($res)){

  switch ($progress['status']) {

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

  $input = array("current_approver_pos"=>$posid,"current_approver_id"=>null,"status"=>$status);

}

if(empty($posid) && !empty($res)){
  $x["progress_percentage"] = $progress['progress_percentage'];
  $x['approved_date'] = date("Y-m-d H:i:s");
  $this->db->where("po_id",$progress['po_id'])->update("ctr_po_header",$x);
}

if(!empty($post['jenis_inp'])){
  $input['type_inv'] = $post['jenis_inp'];
}

$this->db->where("progress_id",$id)->update("ctr_po_progress_header",$input);

$input = array(
  "progress_id"=>$id,
  "comment_name"=>$userdata['complete_name'],
  "comment_date"=>date("Y-m-d H:i:s"),
  "comments"=>$post['komentar_inp'],
  "comment_type"=>0,
  "user_id"=>$userdata['employee_id'],
  "comment_activity"=> (!empty($res)) ? "Setuju" : "Revisi",
  );

$this->db->insert("ctr_po_progress_comment",$input);

if(empty($posid)){
  $q = $this->db->where("progress_id",$id)->get("ctr_po_progress_item")->result_array();
  foreach ($q as $key => $value){
    $upd = array("approved_qty"=>$value['progress_qty']+$value['approved_qty'],"progress_qty"=>0);
    $this->db->where("progress_item_id",$value['progress_item_id'])
    ->update("ctr_po_progress_item",$upd);
  }
}

//input lampiran hlmifzi
$input_comment = array();

$n = 0;
$last_id = $progress['progress_id'];
foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      if(isset($post['doc_attachment_inp'][$key2]) && !empty($post['doc_attachment_inp'][$key2])){

        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

        $input_comment[$key2]['description']=$post['doc_desc_inp'][$key2];
        $input_comment[$key2]['filename']=$post['doc_attachment_inp'][$key2];
        $input_comment[$key2]['progress_id'] = $last_id;
        $input_comment[$key2]['status']=1;
      }

    }

    $n++;

  }

}

 /*var_dump($input_comment);
  exit();*/
foreach ($input_comment as $key => $value) {

 
   $act =  $this->db->insert('ctr_po_progress_doc',$input_comment[$key]);
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

