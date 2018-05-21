<?php 

$post = $this->input->post();

$userdata = $this->data['userdata'];

$check = $this->db->where("PPM_ID",$post['id'])->get("prc_eauction_header")->row_array();

$prc = $this->db->where("ptm_currency",$post['id'])->get("prc_tender_main")->row_array();

$bid_minutes = 10;

$inp = array(
    "HPS"=>$post['total_alokasi_inp'],
    "BATAS_ATAS"=>$post['b_atas_eauction_money_inp'],
    "BATAS_BAWAH"=>$post['b_bawah_eauction_money_inp'],
    "CREATED_BY"=>$userdata['employee_id'],
    "CREATED_DATE"=>date("Y-m-d H:i:s"),
    "DESKRIPSI"=>$post['deskripsi_eauction_inp'],
    "JUDUL"=>$post['judul_eauction_inp'],
    "MINIMAL_PENURUNAN"=>moneytoint($post['penurunan_eauction_inp']),
    "STATUS"=>"",
    "TANGGAL_BERAKHIR"=>$post['tgl_selesai_eauction_inp'],
    "TANGGAL_MULAI"=>$post['tgl_mulai_eauction_inp'],
    "TIPE"=>$post['tipe_eauction_inp'],
    "WAKTU_DETIK"=>$post['tipe_eauction_inp'],
    "CURR_ID"=>$prc['ptm_currency'],
    "BATAS_ATAS_PERCENT"=>$post['b_atas_eauction_percent_inp'],
    "BATAS_BAWAH_PERCENT"=>$post['b_bawah_eauction_percent_inp'],
    "MAX_BID_PER_MINUTE"=>$bid_minutes,
    );

if(!empty($check)){
    $act = $this->db->where("PPM_ID",$post['id'])->update("prc_eauction_header",$inp);
} else {
    $inp['PPM_ID'] = $post['id'];
    $act = $this->db->insert("prc_eauction_header",$inp);
}

if($act){

    if(isset($post['reset_inp'])){
        $this->db->where("PPM_ID",$post['id'])->delete("prc_eauction_history");
        $this->db->where("PPM_ID",$post['id'])->delete("prc_eauction_history_item");
    }

    $this->db->where("PPM_ID",$post['id'])->delete("prc_eauction_vendor");
    $this->db->where("PPM_ID",$post['id'])->delete("prc_eauction_item");

    $vendor = $this->db->where("ptm_number",$post['id'])->get("prc_tender_vendor_status")->result_array();

    foreach ($vendor as $key => $value) {
     $inp = array(
        "BID_IN_MINUTES"=>$bid_minutes,
        "VENDOR_ID"=>$value['pvs_vendor_code'],
        "PPM_ID"=>$post['id']
        );
     $this->db->insert("prc_eauction_vendor",$inp);
 }

 foreach ($post['harga_penurunan'] as $key => $value) {
    $inp = array(
        "TIT_ID"=>$key,
        "VALUE_MIN"=>moneytoint($value),
        "PPM_ID"=>$post['id']
        );
    $this->db->insert("prc_eauction_item",$inp);
}
$this->setMessage("Sukses mengubah data");
$this->renderMessage("success",site_url("procurement/procurement_tools/e_auction"));
} else {
  $this->renderMessage("error");
}