<?php

$error = false;

$post = $this->input->post();

$ptm_number = $post['id'];

$input_prep = array();

//hlmifzi
$this->db->where('ptm_number', $ptm_number);
$this->db->where('ptp_bid_opening2 !=', null);
$opening2 = $this->db->get('prc_tender_prep')->row_array();
/*var_dump($opening2);
exit();*/

if (empty($opening2)) {
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

        $input_prep['ptp_aanwijzing_online'] = 0;

        if(!empty($post['aanwijzing_online_inp'])){
          $input_prep['ptp_aanwijzing_online'] = 1;
        }
} else {
  $input_prep['ptp_tgl_aanwijzing2'] = $post['tgl_aanwijzing_2_inp'];
  $input_prep['ptp_bid_opening2'] = $post['tgl_penutupan_penawaran_2_inp'];
  $input_prep['ptp_lokasi_aanwijzing2'] = $post['lokasi_aanwijzing_2_inp'];
}
//end hlmifzi


$this->db->trans_begin();

if(!empty($input_prep)){
  $this->Procrfq_m->updatePrepRFQ($ptm_number,$input_prep);
}


if ($this->db->trans_status() === FALSE)
{
  $this->setMessage("Gagal mengubah data");
  $this->renderMessage("error");
  $this->db->trans_rollback();
}
else
{
  $this->db->trans_commit();
  $this->renderMessage("success",site_url("procurement/procurement_tools/update_tanggal_pembukaan_penawaran"));
}
