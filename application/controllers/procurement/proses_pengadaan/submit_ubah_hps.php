<?php

$error = false;

$post = $this->input->post();

$ptm_number = $post['id'];

$input = array();

$input_item = array();

$n = 0;

$this->form_validation->set_rules("id", 'ID', 'required');

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules($key."[".$key2."]", '', '');

      if(isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])){

        $this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
        $this->form_validation->set_rules("item_satuan[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("item_harga_satuan[$key2]", "Harga #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');
        $this->form_validation->set_rules("item_subtotal[$key2]", "Subtotal #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');
        if(!empty($post['item_id'][$key2])){
          $input_item[$key2]['tit_id']=$post['item_id'][$key2];
        }
        $input_item[$key2]['tit_code']=$post['item_kode'][$key2];
        $input_item[$key2]['tit_description']=$post['item_deskripsi'][$key2];
        $input_item[$key2]['tit_quantity']=$post['item_jumlah'][$key2];
        $input_item[$key2]['tit_unit']=$post['item_satuan'][$key2];
        $input_item[$key2]['tit_price']=$post['item_harga_satuan'][$key2];

        $tipe = $post['item_tipe'][$key2];
        $kode = $post['item_kode'][$key2];

        if($tipe == "BARANG"){
          $com = $this->Commodity_m->getMatCatalog($kode)->row_array();
        } else {
          $com = $this->Commodity_m->getSrvCatalog($kode)->row_array();
        }

        $input_item[$key2]['tit_currency']= "IDR";
        //$input_item[$key2]['tit_currency']=$com['currency'];
        $input_item[$key2]['tit_type']=$tipe;

      }

    }

    $n++;

  }

}
//start code hlmifzi
if( $post['sisa_pagu_inp'] < 0){
  $this->setMessage("Sisa anggaran tidak boleh kurang dari 0");
  $error = true;
}
//end code hlmifzi

if ($this->form_validation->run() == FALSE || $error){

  $this->renderMessage("error");

  //$this->ubah_tender_pengadaan();

} else {

  $this->db->trans_begin();

  if(!empty($input_item)){

    $deleted = array();

    foreach ($input_item as $key => $value) {
      $value['ptm_number'] = $ptm_number;
      $act = $this->Procrfq_m->replaceItemRFQ($key,$value);
      if($act){
        $deleted[] = $act;
      }
    }

    $this->Procrfq_m->deleteIfNotExistItemRFQ($ptm_number,$deleted);

  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal mengubah data");
    $this->db->trans_rollback();
    $this->renderMessage("error");
  }
  else
  {
    $this->db->trans_commit();
    $this->renderMessage("success",site_url("procurement/procurement_tools/update_data_hps"));
  }

}
