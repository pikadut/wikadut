<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];
$res = $post['status_inp'];
$userdata = $this->data['userdata'];

$this->db->trans_begin();
//start code hlmifzi
$progress = $this->db->select("a.bastp_status,d.contract_amount,b.progress_percentage,b.progress_description,b.po_id,ctr_spe_pos,a.vendor_id,a.vendor_name,a.contract_id,d.contract_number,a.po_notes,a.creator_employee,a.po_id")
->where("a.po_id",$id)
->join("ctr_po_header a","a.po_id=b.po_id")
->join("ctr_contract_header d","a.contract_id=d.contract_id")
->join("prc_tender_main e","e.ptm_number=d.ptm_number")
->get("ctr_po_progress_header b")->row_array();
//end

$input = array(
  "bastp_status"=>99,
  "current_approver_pos"=>null,
  "current_approver_id"=>null,
  );

$posname = "";
$posid = null;

if(!empty($res)){

  switch ($progress['bastp_status']) {

    case 1:

    $title = "MANAJER USER";
    $bastp_status = 2;

    break;

    case 2:

    if($progress['contract_amount'] > 200000000){
      $title = "VP USER";
      $bastp_status = 3;
    } else {
     $title = "PIC BAST";
     $bastp_status = 4;
   }

   break;

   case 3:

   $title = "PIC BAST";
   $bastp_status = 4;

   break;

   case 4:

   $title = "MANAJER BAST";
   $bastp_status = 5;

   break;

   case 5:

   if($progress['contract_amount'] > 500000000){
     $title = "VP BAST";
     $bastp_status = 6;
   } else {
     $title = "";
     $bastp_status = null;
   }

   break;

   default:
   $title = "";
   $bastp_status = null;
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

$input = array("current_approver_pos"=>$posid,"current_approver_id"=>null,"bastp_status"=>$bastp_status);

}

$input['approved_date'] = date("Y-m-d H:i:s");

//startcode hlmifzi pindah db ke invoice
if(empty($title) && $bastp_status == null){

   $data_tagihan = [
          'vendor_id'           => $progress['vendor_id'],
          'vendor_name'         => $progress['vendor_name'],
          'contract_id'         => $progress['contract_id'],
          'contract_number'     => $progress['contract_number'],
          'creator_employee'    => $progress['creator_employee'],
          'po_id'               => $progress['po_id'],
  ];  

  $this->db->insert("ctr_invoice_header",$data_tagihan);
}
//end

$this->db->where("po_id",$id)->update("ctr_po_header",$input);

$progress_latest = $this->db
    ->where(array("po_id"=>$id,"progress_percentage"=>100))
    ->get("ctr_po_progress_header")->row_array();

$progress_id = $progress_latest['progress_id'];

$input = array(
  "progress_id"=>$progress_id,
  "comment_name"=>$userdata['complete_name'],
  "comment_date"=>date("Y-m-d H:i:s"),
  "comments"=>$post['komentar_inp'],
  "comment_type"=>0,
  "user_id"=>$userdata['employee_id'],
  "comment_activity"=> (!empty($res)) ? "Setuju" : "Revisi",
  );

$this->db->insert("ctr_po_progress_comment",$input);

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

