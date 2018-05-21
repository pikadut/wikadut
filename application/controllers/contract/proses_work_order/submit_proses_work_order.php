<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];

$last_comment = array();

if(!empty($id)){
  $last_comment = $this->Comment_m->getWO("",$id)->row_array();
} 

$po_id = (!empty($last_comment['po_id'])) ? $last_comment['po_id'] : $post['po_id'];

$contract_id = (!empty($last_comment['contract_id'])) ? $last_comment['contract_id'] : $post['contract_id'];

$contract = $this->Contract_m->getData($contract_id)->row_array();

$contract_amount = $contract['contract_amount'];

$comment_id = (!empty($last_comment['comment_id'])) ? $last_comment['comment_id'] : "";

$this->form_validation->set_rules("scope_work_inp", "Deskripsi WO", 'required');  

$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 2011;

$totalwo = $this->db->select("COALESCE(SUM(sub_total),0) as total")->where("contract_id",$contract_id)->where("approved_date !=",null)
->join("ctr_po_header a","a.po_id=b.po_id")->get("ctr_po_item b")->row()->total;

$input = array();

$input_item = array();

$total_item = 0;

if($last_activity == 2011){

  if(isset($post['item'])){

    foreach ($post['item'] as $key => $value) {

      $qty = $post['qty_wo'][$key];
      $item = $this->db->where("contract_item_id",$key)->get("ctr_contract_item")->row_array();

      if($item['min_qty'] > $qty || $item['max_qty'] < $qty){

       $this->setMessage("Jumlah harus diantara minimum dan maksimum");

       if(!$error){
        $error = true;
      }

    } else {

      $sub_total = (1+(($item['ppn']+$item['pph'])/100))*($item['price']*$qty);

      $input_item[] = array(
        "contract_item_id"=>$key,
        "item_code"=>$item['item_code'],
        "short_description"=>$item['short_description'],
        "long_description"=>$item['long_description'],
        "price"=>$item['price'],
        "qty"=>$qty,
        "uom"=>$item['uom'],
        "sub_total"=>$sub_total,
        "ppn"=>$item['ppn'],
        "pph"=>$item['pph']
        );

      $total_item += $sub_total;

    }

  }

} else {

 $this->setMessage("Tidak ada item yang dipilih");
 if(!$error){
  $error = true;
}

}

if($totalwo+$total_item > $contract_amount){
 $this->setMessage("Nilai WO tidak dapat melebih nilai kontrak");
 if(!$error){
  $error = true;
}
}

}

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  //$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

if ($this->form_validation->run() == FALSE || $error){

  $this->renderMessage("error");

  //$this->ubah_tender_pengadaan();

} else {

  $this->db->trans_begin();

  if(!empty($id)){

    if($last_activity == 2011){

      $input = array(
        "start_date"=>$post['tgl_mulai_inp'],
        "end_date"=>$post['tgl_akhir_inp'],
        "po_notes"=>$post['scope_work_inp'],
        );

      $act = $this->Contract_m->updateWOData($po_id,$input);
    }

  } else {

    $ptm = $this->db
    ->where("contract_id",$contract_id)
    ->join("prc_tender_main a","a.ptm_number=b.ptm_number")
    ->get("ctr_contract_header b")->row_array();

    $po_number = $this->Contract_m->getUrutWO();

    $input = array(
      "po_number"=>$po_number,
      "creator_employee"=>$ptm['ptm_requester_id'],
      "creator_pos"=>$ptm['ptm_requester_pos_code'],
      "contract_id"=>$contract['contract_id'],
      "vendor_id"=>$contract['vendor_id'],
      "vendor_name"=>$contract['vendor_name'],
      "currency"=>$contract['currency'],
      "start_date"=>$post['tgl_mulai_inp'],
      "end_date"=>$post['tgl_akhir_inp'],
      "created_date"=>date("Y-m-d H:i:s"),
      "po_notes"=>$post['scope_work_inp'],
      "status"=>2011,
      );

    $act = $this->Contract_m->insertWOData($input);

    $po_id = $this->db->insert_id();

    $comment = $this->Comment_m->insertWO($contract_id,2011,"","","",
      $ptm['ptm_requester_pos_code'],$ptm['ptm_requester_pos_name'],$po_id);

    $comment_id = $this->db->insert_id();

  }

  if(!empty($input_item)){


    $deleted = array();

    foreach ($input_item as $key => $value) {

      $value['po_id'] = $po_id;

      if(!empty($id)){
        $act = $this->db->where(array("po_id"=>$po_id,"contract_item_id"=>$value['contract_item_id']))
        ->update("ctr_po_item",$value);
      } else {
        $this->Contract_m->insertWOItem($value);
      }

      if($act){
        $deleted[] = $act;
      }
    }

    //$this->Contract_m->deleteIfNotExistWOItem($po_id,$deleted);

  }



  $response = $post['status_inp'][0];

  $com = $post['comment_inp'][0];

  $return = $this->Procedure2_m->ctr_wo_comment_complete($po_id,$userdata['complete_name'],$last_activity,$response,$com,"",$comment_id,$contract_id,$userdata['employee_id']);

  if(!empty($return['nextactivity'])){

    $comment = $this->Comment_m->insertWO($contract_id,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$po_id);

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
