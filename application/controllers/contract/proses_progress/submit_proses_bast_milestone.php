<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];
$res = $post['status_inp'];
$userdata = $this->data['userdata'];

$this->db->trans_begin();
//start code hlmifzi
$progress = $this->db->select("bastp_status,d.contract_amount,b.percentage,a.progress_percentage,d.vendor_id,d.vendor_name,d.contract_id,d.contract_number,b.milestone_id,ctr_spe_pos")
->where("a.milestone_id",$id)
->join("ctr_contract_milestone a","a.milestone_id=b.milestone_id")
->join("ctr_contract_header d","a.contract_id=d.contract_id")
->join("prc_tender_main e","e.ptm_number=d.ptm_number")
->get("ctr_contract_milestone_progress b")->row_array();

//end

  $input = array(
    "bastp_status"=>99,
    "current_approver_pos"=>null,
    "current_approver_id"=>null,
    );

$milestone_id = $progress['milestone_id'];

$posname = "";
$posid = null;

if(!empty($res)){

  switch ($progress['bastp_status']) {

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

$input = array("current_approver_pos"=>$posid,"current_approver_id"=>null,"bastp_status"=>$status);

} 


//startcode hlmifzi pindah db ke invoice
if(empty($title) && $status == null){

   $data_tagihan = [
          'vendor_id'           => $progress['vendor_id'],
          'vendor_name'         => $progress['vendor_name'],
          'contract_id'         => $progress['contract_id'],
          'contract_number'     => $progress['contract_number'],
          'milestone_id'        => $progress['milestone_id'],
          'percentage'          => $progress['percentage'],
          'progress_percentage' => $progress['progress_percentage'],
  ];  

  $this->db->insert("ctr_invoice_milestone_header",$data_tagihan);
}
//end

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

