<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];

$last_comment = $this->Comment_m->getProcurementRFQ("",$id)->row_array();

$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 0;

$ptm_number = $last_comment['tender_id'];

$tender = $this->Procrfq_m->getRFQ($last_comment['tender_id'])->row_array();

$input = array();

$input_doc = array();

$input_item = array();

$input_prep = array();

$user_id = null;

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  //$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

if($last_activity == 1029){
  $manajer_id = (isset($post['manager_inp'])) ? $post['manager_inp'] : "";
  $input['ptm_man_emp_id'] = $manajer_id;
  $user_id = $manajer_id;
}

if($last_activity == 1030){

  $pelaksana_id = (isset($post['pelaksana_pengadaan_inp'])) ? $post['pelaksana_pengadaan_inp'] : $tender['ptm_buyer'];
  
  $user_id = $pelaksana_id;
  
  $this->db->where("job_title","PELAKSANA PENGADAAN");

  $pelaksana = $this->Administration_m->getUserRule($pelaksana_id)->row_array();

  if(isset($post['pelaksana_pengadaan_inp'])){
    $this->form_validation->set_rules("pelaksana_pengadaan_inp", "Pelaksana Pengadaan", 'required|max_length['.DEFAULT_MAXLENGTH.']');
  }

  if(!empty($pelaksana)){
    $input['ptm_buyer_id'] = $pelaksana_id;
    $input['ptm_buyer'] = $pelaksana['complete_name'];
    $input['ptm_buyer_pos_code'] = $pelaksana['pos_id'];
    $input['ptm_buyer_pos_name'] = $pelaksana['pos_name'];
  }

}

$invited_vendor = (isset($this->data['selection_vendor_tender'])) ? $this->data['selection_vendor_tender'] : 0;

if($last_activity == 1040){

  $metode_pengadaan = null;

  $sampul = null;

  $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

  $filtering_vendor = array();
  if(isset($post['klasifikasi_kecil_inp'])){
    $filtering_vendor[] = "K";
  }
  if(isset($post['klasifikasi_menengah_inp'])){
    $filtering_vendor[] = "M";
  }
  if(isset($post['klasifikasi_besar_inp'])){
    $filtering_vendor[] = "B";
  }

  if($prep['ptp_prequalify'] != 2){ 

    $input['ptm_contract_type'] = null;
    if(isset($post['jenis_kontrak_inp'])){
      $input['ptm_contract_type'] = $post['jenis_kontrak_inp'];
    }

    $input_prep['ptp_eauction'] = 0;
    if(isset($post['eauction_inp'])){
      $input_prep['ptp_eauction'] = $post['eauction_inp'];
    }

    $input_prep['ptp_prequalify'] = 0;
    if(isset($post['pq_inp'])){
      $input_prep['ptp_prequalify'] = $post['pq_inp'];
    }
    
    $input_prep['ptp_aanwijzing_online'] = 0;

    if(!empty($post['aanwijzing_online_inp'])){
      $input_prep['ptp_aanwijzing_online'] = 1;
    }

    if(isset($post['metode_pengadaan_inp'])){
      $metode_pengadaan = (!empty($post['metode_pengadaan_inp'])) ? $post['metode_pengadaan_inp'] : 0;
      $input_prep['ptp_tender_method'] = $metode_pengadaan;
    }

    if(isset($post['sistem_sampul_inp'])){
      $sampul = (!empty($post['sistem_sampul_inp'])) ? $post['sistem_sampul_inp'] : 0;
      $input_prep['ptp_submission_method'] = $sampul;

    }
    if(isset($post['template_evaluasi_inp'])){
      $input_prep['evt_id'] = (!empty($post['template_evaluasi_inp'])) ? $post['template_evaluasi_inp'] : 0;
    }
    if(isset($post['keterangan_metode_inp'])){
      $input_prep['ptp_inquiry_notes'] = $post['keterangan_metode_inp'];
    }

    $ptp_klasifikasi_peserta = (isset($post['klasifikasi_kecil_inp'])) ? 1 : 0;
    $ptp_klasifikasi_peserta .= (isset($post['klasifikasi_menengah_inp'])) ? 1 : 0;
    $ptp_klasifikasi_peserta .= (isset($post['klasifikasi_besar_inp'])) ? 1 : 0;

    $ptp_quo_type = 1;
    $ptp_quo_type .= (isset($post['quo_type_b_inp'])) ? 1 : 0;
    $ptp_quo_type .= (isset($post['quo_type_c_inp'])) ? 1 : 0;

    $input_prep['ptp_klasifikasi_peserta'] = $ptp_klasifikasi_peserta;
    $input_prep['ptp_quo_type'] = $ptp_quo_type;

    $eval_id = $post['template_evaluasi_inp'];

    if(!empty($eval_id)){
      $evaluasi = $this->Procevaltemp_m->getTemplateEvaluasi($eval_id)->row_array();
      $input_prep['evt_id'] = $eval_id;
      $input_prep['evt_description'] = $evaluasi['evt_name'];
      $input_prep['ptp_evaluation_method'] = $evaluasi['evt_type'];
    }

    $this->load->model("Procpanitia_m");

    $panitia_id = (isset($post['panitia_pengadaan_inp'])) ? $post['panitia_pengadaan_inp'] : 0;
    if(!empty($panitia_id)){
      $panitia = $this->Procpanitia_m->getPanitia($panitia_id)->row_array();
      if(!empty($panitia)){
        $input_prep['adm_bid_committee'] = $panitia_id;
        $input_prep['adm_bid_committee_name'] = $panitia['committee_name'];
      }
    }

    $hps = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

    if(count($invited_vendor) == 0 && $post['metode_pengadaan_inp'] != 2){
     $this->setMessage("Tidak ada vendor yang diundang");
     if(!$error){
      $error = true;
    }

  } 

  if(empty($eval_id)){
    $this->setMessage("Template evaluasi wajib diisi");
    if(!$error){
      $error = true;
    }
  }

/* PANITIA HILANG
if($hps['hps_sum'] > 2000*1000000 && empty($panitia_id)){
  $this->setMessage("Panitia wajib diisi");
  if(!$error){
    $error = true;
  }
}
*/

switch ($metode_pengadaan) {
  //Penunjukkan Langsung
  case 0:
/*
  if($hps['hps_sum'] > 50*1000000){
    $this->setMessage("Nilai SPPBJ Penunjukkan Langsung tidak boleh dari 50.000.000");
    if(!$error){
      $error = true;
    }
  }
*/
  if(count($invited_vendor) > 1){
   $this->setMessage("Hanya 1 vendor yang dapat diundang Penunjukkan Langsung");
   if(!$error){
    $error = true;
  }
}

break;

//Pemilihan Langsung
case 1:

/*

if($hps['hps_sum'] < 50*1000000 || $hps['hps_sum'] > 500*1000000){
  $this->setMessage("Nilai SPPBJ Pemilihan Langsung harus diantara 50.000.000 - 500.000.000");
  if(!$error){
    $error = true;
  }
}

*/

if(count($invited_vendor) < 3){
 $this->setMessage("Minimal 3 vendor yang diundang Pemilihan Langsung");
 if(!$error){
  $error = true;
}

}

break;

//Pelelangan
case 2:

/*

if($hps['hps_sum'] < 500*1000000){
  $this->setMessage("Nilai SPPBJ Pelelangan harus lebih dari 500.000.000");
  if(!$error){
    $error = true;
  }
}

if(count($invited_vendor) < 3){
 $this->setMessage("Minimal 3 vendor yang diundang Pelelangan");
 if(!$error){
  $error = true;
}

}
*/

break;

default:

$this->setMessage("Pilih metode pengadaan");
if(!$error){
  $error = true;
}

break;
}

}

if(!empty($post['tgl_pembukaan_pendaftaran_inp'])){
  $input_prep['ptp_reg_opening_date'] = $post['tgl_pembukaan_pendaftaran_inp'];
} else {
  $input_prep['ptp_reg_opening_date'] = "";
  if(in_array($sampul, array(1,2)) && $metode_pengadaan == 2){
   $this->setMessage("Tanggal pembukaan pendaftaran lelang harus terisi");
   if(!$error){
    $error = true;
  }
}
}
if(!empty($post['tgl_penutupan_pendaftaran_inp'])){
  $input_prep['ptp_reg_closing_date'] = $post['tgl_penutupan_pendaftaran_inp'];
} else {
  $input_prep['ptp_reg_closing_date'] = "";
  if(in_array($sampul, array(1,2)) && $metode_pengadaan == 2){
   $this->setMessage("Tanggal penutupan pendaftaran lelang harus terisi");
   if(!$error){
    $error = true;
  }
}
}
if(!empty($post['tgl_mulai_penawaran_inp'])){
  $input_prep['ptp_quot_opening_date'] = $post['tgl_mulai_penawaran_inp'];
} else {
  $input_prep['ptp_quot_opening_date'] = "";
}
if(!empty($post['tgl_akhir_penawaran_inp'])){
  $input_prep['ptp_quot_closing_date'] = $post['tgl_akhir_penawaran_inp'];
} else {
  $input_prep['ptp_quot_closing_date'] = "";
}
if(!empty($post['tgl_aanwijzing_inp'])){
  $input_prep['ptp_prebid_date'] = $post['tgl_aanwijzing_inp'];
} else {
  $input_prep['ptp_prebid_date'] = "";
}
if(!empty($post['lokasi_aanwijzing_inp'])){
  $input_prep['ptp_prebid_location'] = $post['lokasi_aanwijzing_inp'];
} else {
  $input_prep['ptp_prebid_location'] = "";
}
if(!empty($post['tgl_pembukaan_dok_penawaran_inp'])){
  $input_prep['ptp_doc_open_date'] = $post['tgl_pembukaan_dok_penawaran_inp'];
} else {
  $input_prep['ptp_doc_open_date'] = "";
}

$opening = strtotime($input_prep['ptp_reg_opening_date']);
$closing = strtotime($input_prep['ptp_reg_closing_date']);
$aanwijzing = strtotime($input_prep['ptp_prebid_date']);
$bid = strtotime($input_prep['ptp_quot_opening_date']);
$bid_close = strtotime($input_prep['ptp_quot_closing_date']);
$open_doc = strtotime($input_prep['ptp_doc_open_date']);

if(!empty($opening) && !empty($closing) && $opening > $closing){
  $this->setMessage("Tanggal pembukaan pendaftaran tidak boleh lebih dari penutupan pendaftaran");
  if(!$error){
    $error = true;
  }
}

if(!empty($closing) && !empty($aanwijzing) && $closing > $aanwijzing){
  $this->setMessage("Tanggal penutupan pendaftaran tidak boleh lebih dari aanwijzing");
  if(!$error){
    $error = true;
  }
}

if(!empty($aanwijzing) && !empty($bid) && $aanwijzing > $bid){
  $this->setMessage("Tanggal aanwijzing tidak boleh lebih dari mulai kirim penawaran");
  if(!$error){
    $error = true;
  }
}

if(!empty($bid) && !empty($bid_close) && $bid > $bid_close){
  $this->setMessage("Tanggal mulai kirim penawaran tidak boleh lebih dari akhir kirim penawaran");
  if(!$error){
    $error = true;
  }
}

if(!empty($bid_close) && !empty($open_doc) && $bid_close > $open_doc){
  $this->setMessage("Tanggal akhir kirim penawaran tidak boleh lebih dari pembukaan dokumen penawaran");
  if(!$error){
    $error = true;
  }
}

    //exit();

}


if($last_activity == 1071){

  $vnd_upd = array();

  $vnd_id = array();

  $this->db->where("ptm_number",$ptm_number)->update("prc_tender_vendor_status",array("pvs_pq_passed"=>0,"pvs_pq_reason"=>""));

  if(isset($post['alasan_pq_inp'])){
    foreach ($post['alasan_pq_inp'] as $key => $value) {
      $vnd_upd[$key]['pvs_pq_reason'] = $value;
    }
  }

  if(isset($post['lulus_pq_inp'])){
    foreach ($post['lulus_pq_inp'] as $key => $value) {
      $vnd_upd[$key]['pvs_pq_passed'] = 1;
    }
  }

  if(isset($post['attachment_pq_inp'])){
    foreach ($post['attachment_pq_inp'] as $key => $value) {
      $vnd_upd[$key]['pvs_pq_attachment'] = $value;
    }
  }

  foreach ($vnd_upd as $key => $value) {
    $cek = $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$key))
    ->get("prc_tender_vendor_status")->num_rows();
    if(!empty($cek)){
      $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$key))
      ->update("prc_tender_vendor_status",$value);
    } else {
      $value['ptm_number'] = $ptm_number;
      $value["pvs_vendor_code"] = $key;
      $this->db->insert("prc_tender_vendor_status",$value);
    }
  }

  //$this->db->where("ptm_number",$ptm_number)->where("pvs_pq_passed",1)->update("prc_tender_vendor_status",array("pvs_status"=>12));

}

if($last_activity == 1112){

  if(!empty($post['tgl_penutupan_penawaran_2_inp'])){
    $input_prep['ptp_bid_opening2'] = $post['tgl_penutupan_penawaran_2_inp'];
  }
  if(!empty($post['lokasi_aanwijzing_2_inp'])){
    $input_prep['ptp_lokasi_aanwijzing2'] = $post['lokasi_aanwijzing_2_inp'];
  }
  if(!empty($post['tgl_aanwijzing_2_inp'])){
    $input_prep['ptp_tgl_aanwijzing2'] = $post['tgl_aanwijzing_2_inp'];
  }

  $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

  $bid = strtotime($prep['ptp_quot_opening_date']);
  $bid2 = strtotime($input_prep['ptp_bid_opening2']);
  $aanwijzing2 = strtotime($input_prep['ptp_tgl_aanwijzing2']);

  if($bid2 < $bid){
    $this->setMessage("Tanggal penutupan penawaran tahap 2 tidak boleh kurang dari penutupan penawaran");
    if(!$error){
      $error = true;
    }
  }

  if($bid2 < $aanwijzing2){
    $this->setMessage("Tanggal penutupan penawaran tahap 2 tidak boleh kurang dari aanwijzing tahap 2");
    if(!$error){
      $error = true;
    }
  }

}

if($last_activity == 1080){

  $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

  if($prep['ptp_tender_method'] == 2){

    $mendaftar = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->num_rows();

    if($mendaftar < 3){
      $this->setMessage("Minimal 3 vendor yang mendaftar");
      if(!$error){
        $error = true;
      }
    }
    
  }

}

if(in_array($last_activity, array(1073,1160))){
  $periode_sanggahan = moneytoint($post['periode_sanggahan_inp']);
  $sanggahan_start = date("Y-m-d H:i:s");
  $sanggahan_end = date("Y-m-d H:i:s",strtotime("+$periode_sanggahan day"));

  $begin = new DateTime( $sanggahan_start );
  $end = new DateTime($sanggahan_end);
  $end = $end->modify( '+0 day' ); 

  $interval = new DateInterval('P1D');
  $daterange = new DatePeriod($begin, $interval ,$end);

  $a = 0;
  foreach($daterange as $date){
    $x = $date->format("N");
    if($x < 6){
      //echo $date->format("Y-m-d N D")."<br/>";
      $a++;
    }
  }
//start hlmifzi
  if($periode_sanggahan != $a){
    $periode_sanggahan += ($periode_sanggahan-$a);
    $sanggahan_end = date("Y-m-d H:i:s",strtotime("+$periode_sanggahan day"));
  } elseif ($periode_sanggahan == 0) {
    $periode_sanggahan += 0;
    $sanggahan_end = date("Y-m-d H:i:s");
  }
//end

  $input_prep['ptp_denial_period'] = $periode_sanggahan;
  $input_prep['ptp_denial_period_start'] = $sanggahan_start;
  $input_prep['ptp_denial_period_end'] = $sanggahan_end;


}

if($last_activity == 1090){

  $vendor_status = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();
  $mendaftar = 0;
  $tidak_diverifikasi = 0;
  foreach ($vendor_status as $key => $value) {
    if($value['pvs_status'] != 1){
      $mendaftar++;
    }
    if($value['pvs_status'] == 3){
      $tidak_diverifikasi++;
    }
  }

  if(empty($mendaftar)){
    $this->setMessage("Tidak ada vendor yang mendaftar. Proses tidak dapat berlanjut");
    if(!$error){
      $error = true;
    }
  }

  if(!empty($tidak_diverifikasi)){
    $this->setMessage("Beberapa vendor belum di verifikasi. Proses tidak dapat berlanjut");
    if(!$error){
      $error = true;
    }
  }

}

if($last_activity == 1120){

 $getevalcalculated = $this->db->where("pte_price_value >",0)
 ->where("ptm_number",$ptm_number)->get("prc_tender_eval")->num_rows(); 

 if(empty($getevalcalculated)){
  $this->setMessage("Proses perhitungan evaluasi harga belum dilaksanakan. Proses tidak dapat berlanjut");
  if(!$error){
    $error = true;
  }
}

}

if($last_activity == 1180){

  if(isset($post['rank_inp']) && !empty($post['rank_inp'])){

    foreach ($post['rank_inp'] as $key => $value) {

      $winner = ($post['winner_inp'] == $key);

      if($winner){

       $quo_main = $this->Procrfq_m->getVendorQuoMainRFQ($key,$ptm_number)->row_array();
       $this->db->where(array("ptv_vendor_code"=>$key,"ptm_number"=>$ptm_number));
       $quo_item = $this->Procrfq_m->getViewVendorQuoComRFQ()->result_array();
       $rfq = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

       foreach ($quo_item as $k => $v) {

        if($v['catalog_type'] == "M"){

          $isi = array(
            "mat_catalog_code" => $v['tit_code'],
            "short_description" => $v['short_description'],
            "long_description" => $v['long_description'],
            "del_point_id" => $rfq['ptm_delivery_point_id'],
            "del_point_name" => $rfq['ptm_delivery_point'],
            "currency" => $quo_main['pqm_currency'],
            "vendor" => $v['vendor_name'],
            "total_cost" => $v['pqi_price'],
            "status"=>"A",
            "notes" => "No. Tender : ".$ptm_number.", Vendor : ".$v['vendor_name'].", No. Penawaran : ".$quo_main['pqm_number']
            );
          $this->db->insert("com_mat_price",$isi);

        } else {

          $isi = array(
            "srv_catalog_code" => $v['tit_code'],
            "short_description" => $v['short_description'],
            "long_description" => $v['long_description'],
            "del_point_id" => $rfq['ptm_delivery_point_id'],
            "del_point_name" => $rfq['ptm_delivery_point'],
            "currency" => $quo_main['pqm_currency'],
            "vendor" => $v['vendor_name'],
            "total_price" => $v['pqi_price'],
            "status"=>"A",
            "notes" => "No. Tender : ".$ptm_number.", Vendor : ".$v['vendor_name'].", No. Penawaran : ".$quo_main['pqm_number']
            );
          $this->db->insert("com_srv_price",$isi);

        }

      }

    }

    $inp = array(
      "pte_is_winner"=> ($winner) ? 1 : 0,
      "pte_rank"=>$value,
      );

    $this->db
    ->where(array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$key))
    ->update("prc_tender_eval",$inp);

    $inp = array(
      "pvs_is_winner"=> ($winner) ? 1 : 0,
      "pvs_status"=> ($winner) ? 11 : 24,
      );

    $this->db
    ->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$key))
    ->update("prc_tender_vendor_status",$inp);

  }

}

$this->db
->where(array("ptm_number"=>$ptm_number))
->update("prc_tender_main",array("ptm_status"=>1901));

}

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

  //$this->ubah_tender_pengadaan();

} else {

  $this->db->trans_begin();

  if(!empty($input)){

    $act = $this->Procrfq_m->updateDataRFQ($ptm_number,$input);

  } else {

    $act = true;

  }

  //echo $this->db->last_query();

  $complete_comment = 1;

  if(!empty($input_prep)){

    $p = $this->Procrfq_m->getPrepRFQ($ptm_number)->num_rows();
    if(!empty($p)){
      $this->Procrfq_m->updatePrepRFQ($ptm_number,$input_prep);
    } else {
      $input_prep['ptm_number'] = $ptm_number;
      $this->Procrfq_m->updatePrepRFQ($input_prep);
    }
  }

    //echo $this->db->last_query();

  if(!empty($input_doc)){

    $deleted = array();

    foreach ($input_doc as $key => $value) {
      $value['ptm_number'] = $ptm_number;
      $act = $this->Procrfq_m->replaceDokumenRFQ($key,$value);
        //echo $this->db->last_query();
      if($act){
        $deleted[] = $act;
      }
    }

    $this->Procrfq_m->deleteIfNotExistDokumenRFQ($ptm_number,$deleted);
      //echo $this->db->last_query();

  }

  if($last_activity > 1090 && $last_activity <= 1180){
      //$this->Procrfq_m->updateVendorStatusByGrade($ptm_number,$last_activity);
  }


  if($last_activity == 1040){

    $this->load->model("Vendor_m");

    if(!empty($invited_vendor)){

      $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

        //print_r($invited_vendor);

      if($prep['ptp_tender_method'] == 2 && $prep['ptp_prequalify'] != 2){

        $this->db->where("ptm_number",$ptm_number)->delete("prc_tender_vendor");
        $this->db->where("ptm_number",$ptm_number)->delete("prc_tender_vendor_status");

      } else {

       $deleted = array();

       if(substr($prep['ptp_klasifikasi_peserta'], 0,1) == 1){
        $filtering_vendor[] = "K";
      }

      if(substr($prep['ptp_klasifikasi_peserta'], 1,1) == 1){
        $filtering_vendor[] = "M";
      }

      if(substr($prep['ptp_klasifikasi_peserta'], 2,1) == 1){
        $filtering_vendor[] = "B";
      }

      $this->db->where_in("fin_class",$filtering_vendor)->where_in("vendor_id",$invited_vendor);

      $list_vnd = $this->Vendor_m->getVendorActive()->result_array();

      if(isset($prep['ptp_prequalify']) && $prep['ptp_prequalify'] != 2){ 

       foreach ($list_vnd as $key => $value) {

        $inp = array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$value['vendor_id']);
        $act = $this->Procrfq_m->replaceVendorStatusRFQ($inp);

          //echo $this->db->last_query()."<br/>";

        if($act){
          $deleted[] = $act;
        }

      }

      $this->Procrfq_m->deleteIfNotExistVendorStatusRFQ($ptm_number,$deleted);

    }

      //echo $this->db->last_query()."<br/>";

  }

}

}

if($last_activity == 1060){

      //KIRIM EMAIL KE VENDOR


  $tender_name = $this->db->select("ptm_subject_of_work")->where("ptm_number",$ptm_number)->get("prc_tender_main")->row()->ptm_subject_of_work;

  $msg = "Dengan hormat,
  <br/>
  <br/>
  Bersama ini kami sampaikan bahwa ".COMPANY_NAME." membuka pendaftaran 
  untuk dapat berpartisipasi dalam pengadaan nomor <strong>$ptm_number</strong> 
  dengan nama pengadaan : '$tender_name' 
  (detail mengenai pengadaan ini dapat dilihat melalui ".COMPANY_WEBSITE.").
  <br/>
  Pendaftaran pengadaan dapat dilakukan melalui <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a> dengan memastikan bahwa data perusahaan anda sudah lengkap dan masih berlaku.";

  $invited_vendor = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

  foreach ($invited_vendor as $key => $value) {

   $deleted2 = array();

   $mail = $value['email_address'];

   //haqim
   // $mail = "adwasdp@adw.co.id";
   //end

   $email = $this->sendEmail($mail,"Pemberitahuan Pengadaan Nomor $ptm_number",$msg);

   $inp = array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$value['pvs_vendor_code'],"pvs_status"=>1);
   $act2 = $this->Procrfq_m->replaceVendorStatusRFQ($inp);

   if($act2){
    $deleted2[] = $act2;
  }

}

  //$this->Procrfq_m->deleteIfNotExistVendorStatusRFQ($ptm_number,$deleted2);

}

if($last_activity == 1080){

  $invited_vendor = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

  if(!empty($invited_vendor)){

   foreach ($invited_vendor as $key => $value) {

    $inp = array("ptv_is_attend"=>0);

    $where = array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$value['pvs_vendor_code']);

    $check = $this->db->where($where)->get('prc_tender_vendor')->row_array();

    if(empty($check)){
     $this->db->insert('prc_tender_vendor',array_merge($inp,$where));
   }

 }

}

$vendor_attend = (isset($post['vendor_hadir'])) ? $post['vendor_hadir'] : array();

//$vendor_attend = $post['vendor_attend_tender'];

if(!empty($vendor_attend)){

  $is_attend = array();

  foreach ($vendor_attend as $key => $value) {

    $is_attend[] = $key;

    $inp = array("ptv_is_attend"=>$value);

    $where = array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$key);

    $check = $this->db->where($where)->get("prc_tender_vendor")->row_array();

    if(!empty($check)){
      $this->db->where($where)->update('prc_tender_vendor',$inp);
    } else {
      $this->db->where($where)->insert('prc_tender_vendor',$inp);
    }

  }


}

$eval_id = $this->Procrfq_m->getPrepRFQ($ptm_number)->row()->evt_id;

$evaluasi = $this->Procevaltemp_m->getTemplateEvaluasi($eval_id)->row_array();

$invited_vendor = $this->Procrfq_m->getVendorRFQ("",$ptm_number)->result_array();

$deleted3 = array();

foreach ($invited_vendor as $key => $value) {

 $inp = array(
  "ptm_number"=>$ptm_number,
  "ptv_vendor_code"=>$value['ptv_vendor_code'],
  "pte_passing_grade"=>$evaluasi['evt_passing_grade'],
  "pte_technical_weight"=>$evaluasi['evt_tech_weight'],
  "pte_price_weight"=>$evaluasi['evt_price_weight']
  );
 $act3 = $this->Procrfq_m->replaceEvalRFQ($inp);

 if($act3){
  $deleted3[] = $act3;
}

}

if(!empty($deleted3)){
  $this->Procrfq_m->deleteIfNotExistEvalRFQ($ptm_number,$deleted3);
}

}

if($last_activity == 1114){

  //$vendor_attend = $post['vendor_attend_tender'];
  $vendor_attend = (isset($post['vendor_hadir_2'])) ? $post['vendor_hadir_2'] : array();

  if(!empty($vendor_attend)){

   foreach ($vendor_attend as $key => $value) {

    $inp = array("ptv_is_attend_2"=>$value);

    $where = array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$key);

    $this->db->where($where)->update('prc_tender_vendor',$inp);

  }

}

}

if($last_activity == 1113){

  $this->db->where(array("pvs_status"=>5,"ptm_number"=>$ptm_number))
  ->update("prc_tender_vendor_status",array("pvs_status"=>2));

}

if($last_activity == 1170 || $last_activity == 1160){

  $sta = array(1160=>9,1170=>8);

  $eval = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

  foreach ($eval as $key => $value) {
    if(strtolower($value['pass']) == "lulus"){
      $this->db->where(array("pvs_vendor_code"=>$value['ptv_vendor_code'],"ptm_number"=>$ptm_number))
      ->update("prc_tender_vendor_status",array("pvs_status"=>$sta[$last_activity]));
    }
  }

}


if($last_activity == 1090){

  $eval_id = $this->Procrfq_m->getPrepRFQ($ptm_number)->row()->evt_id;

  $evaluasi = $this->Procevaltemp_m->getTemplateEvaluasi($eval_id)->row_array();

  $this->db->where("pvs_status",4);

  $qualified_vendor = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

  foreach ($qualified_vendor as $key => $value) {

   $deleted3 = array();

   $inp = array(
    "ptm_number"=>$ptm_number,
    "ptv_vendor_code"=>$value['pvs_vendor_code'],
    "pte_passing_grade"=>$evaluasi['evt_passing_grade'],
    "pte_technical_weight"=>$evaluasi['evt_tech_weight'],
    "pte_price_weight"=>$evaluasi['evt_price_weight']
    );
   $act3 = $this->Procrfq_m->replaceEvalRFQ($inp);

   if($act3){
    $deleted3[] = $act3;
  }

}

  //$this->Procrfq_m->deleteIfNotExistEvalRFQ($ptm_number,$deleted3);

}

if($last_activity == 1140){

  if(isset($post['msg_nego_inp']) && !empty($post['msg_nego_inp'])){

    $vnd_id = $post['vendor_nego_inp'];

    $inp = array(
      "ptm_number"=>$ptm_number,
      "awa_id"=>$last_activity,
      "pbm_vendor_code"=> $vnd_id,
      "pbm_message"=>$post['msg_nego_inp'],
      "pbm_date"=>date("Y-m-d H:i:s"),
      "pbm_mode"=>null,
      "pbm_user"=>$userdata['complete_name'],
      );

    $msg = $this->Procrfq_m->insertMessageRFQ($inp);

    if($msg){

      $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code !="=>$vnd_id))
      ->update("prc_tender_vendor_status",array("pvs_is_negotiate"=>0));
      $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$vnd_id))
      ->update("prc_tender_vendor_status",array("pvs_is_negotiate"=>1,"pvs_status"=>10));

    }

  }

}


if($last_activity == 1073){

  $this->db
  ->where("ptm_number",$ptm_number)
  ->where("pvs_pq_passed !=",1)
  ->update("prc_tender_vendor_status",
    array("pvs_status"=>"-12"));
  $this->db
  ->where("ptm_number",$ptm_number)
  ->where("pvs_pq_passed",1)
  ->update("prc_tender_vendor_status",
    array("pvs_status"=>"12"));

}

if(!empty($return['message'])){
  $this->setMessage($return['message']);
  if(!$error){
    $error = true;
  }
}

$response = $post['status_inp'][0];

$com = $post['comment_inp'][0];

$attachment = $post['comment_attachment_inp'][0];

$return = $this->Procedure_m->prc_tender_comment_complete($ptm_number,$userdata['complete_name'],$last_activity,$response,$com,$attachment,$last_comment['comment_id'],$userdata['employee_id']);

if(!empty($return['nextactivity'])){

/*

  $tender_name = $this->db->select("ptm_subject_of_work")
  ->where("ptm_number",$ptm_number)
  ->get("prc_tender_main")->row()->ptm_subject_of_work;

  $msg = "Dengan hormat,
  <br/>
  <br/>
  Bersama ini kami sampaikan bahwa ".COMPANY_NAME." membuka pendaftaran 
  untuk dapat berpartisipasi dalam pengadaan nomor <strong>$ptm_number</strong> 
  dengan nama pengadaan : '$tender_name' 
  (detail mengenai pengadaan ini dapat dilihat melalui ".COMPANY_WEBSITE.").
  <br/>
  Pendaftaran pengadaan dapat dilakukan melalui eSCM dengan memastikan bahwa data perusahaan anda sudah lengkap dan masih berlaku.";

  $mail = "adwmrt@adw.co.id";

  $email = $this->sendEmail($mail,"Pemberitahuan Pengadaan Nomor $ptm_number",$msg);

  */

  $update = $this->db
  ->where(array("ptm_number"=>$ptm_number))
  ->update("prc_tender_main",array(
    "ptm_status" => $return['nextactivity'],
    ));

  if($return['nextjobtitle'] == "MANAJER PENGADAAN" && empty($user_id)){
    $user_id = $tender['ptm_man_emp_id'];
  }

  $comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$user_id);

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
  $this->renderMessage("success",site_url("procurement/daftar_pekerjaan"));
  //$this->renderMessage("success");
} else {
  $this->renderMessage("error");
}

}
