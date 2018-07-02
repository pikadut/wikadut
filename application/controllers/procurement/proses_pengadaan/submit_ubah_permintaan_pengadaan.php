<?php

$post = $this->input->post();

$id = $post['id'];

$last_comment = $this->Comment_m->getProcurementPR("",$id)->row_array();

$pr_number = $last_comment['tender_id'];

$tender = $this->Procpr_m->getPR()->row_array();

$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

$perencanaan_id = (isset($post['perencanaan_pengadaan_inp'])) ? $post['perencanaan_pengadaan_inp'] : $tender['ppm_id'];
$perencanaan = $this->Procplan_m->getPerencanaanPengadaan($perencanaan_id)->row_array();

$error = false;

if($last_comment['activity'] == 1000){

$input['pr_subject_of_work']= (isset($post['nama_pekerjaan'])) ? $post['nama_pekerjaan'] : $perencanaan['ppm_subject_of_work'];
$input['pr_scope_of_work']= (isset($post['deskripsi_pekerjaan'])) ? $post['deskripsi_pekerjaan'] : $perencanaan['ppm_scope_of_work'];
$input['pr_pagu_anggaran']= (isset($post['total_pagu_inp'])) ? $post['total_pagu_inp'] : $perencanaan['ppm_pagu_anggaran'];
$input['pr_sisa_anggaran']= (isset($post['sisa_pagu_inp'])) ? $post['sisa_pagu_inp'] : $perencanaan['ppm_sisa_anggaran'];

  if(isset($post['perencanaan_pengadaan_inp'])){
    $this->form_validation->set_rules("perencanaan_pengadaan_inp", "Nomor Perencanaan Pengadaan", 'required|max_length['.DEFAULT_MAXLENGTH.']');
  }

  if(isset($post['lokasi_kebutuhan_inp'])){
    $this->form_validation->set_rules("lokasi_kebutuhan_inp", "Lokasi Kebutuhan", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');
    $input['pr_district_id']=$post['lokasi_kebutuhan_inp'];
  }
  if(isset($post['lokasi_pengiriman_inp'])){

    $this->form_validation->set_rules("lokasi_pengiriman_inp", "Lokasi Pengiriman", 'required|max_length['.DEFAULT_MAXLENGTH.']');
    $input['pr_delivery_point_id']=$post['lokasi_pengiriman_inp'];
  }
  if(isset($post['jenis_kontrak_inp'])){
    $input['pr_contract_type']=$post['jenis_kontrak_inp'];
  }

if($input['pr_sisa_anggaran'] < 0){
  $this->setMessage("Sisa anggaran tidak boleh kurang dari 0");
  $error = true;
}

if($post['status_inp'][0] != '289'){ //Menambahkan eksepsi validasi untuk pembuatan draft permintaan pengadaan
if(!isset($post['item_kode'])){
  $this->setMessage("Tidak ada item yang dipilih");
  if(!$error){
    $error = true;
  }
}
}


}


//echo $this->db->last_query();

$pr_number = $last_comment['tender_id'];

$input_doc = array();

$input_item = array();

$n = 0;

//print_r($post);

$this->form_validation->set_rules("id", 'ID', 'required');

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules($key."[".$key2."]", '', '');

      if(isset($post['doc_id_inp'][$key2])){
        $input_doc[$key2]['ppd_id'] = $post['doc_id_inp'][$key2];
      }

      if(isset($post['doc_category_inp'][$key2])){
        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['ppd_category']= $post['doc_category_inp'][$key2];
      }
      if(isset($post['doc_desc_inp'][$key2])){
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $input_doc[$key2]['ppd_description']= $post['doc_desc_inp'][$key2];
      }
      if(isset($post['doc_attachment_inp'][$key2])){
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['ppd_file_name']= $post['doc_attachment_inp'][$key2];
      }

       if(isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])){

        $this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
        $this->form_validation->set_rules("item_satuan[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("item_harga_satuan[$key2]", "Harga #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');
        $this->form_validation->set_rules("item_subtotal[$key2]", "Subtotal #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');

        if(!empty($post['item_id'][$key2])){
          $input_item[$key2]['ppi_id']=$post['item_id'][$key2];
        }

        $input_item[$key2]['ppi_code']=$post['item_kode'][$key2];
        $input_item[$key2]['ppi_description']=$post['item_deskripsi'][$key2];
        $input_item[$key2]['ppi_quantity']=$post['item_jumlah'][$key2];
        $input_item[$key2]['ppi_unit']=$post['item_satuan'][$key2];
        $input_item[$key2]['ppi_price']=$post['item_harga_satuan'][$key2];

        $input_item[$key2]['ppi_ppn']=$post['item_ppn_satuan'][$key2];
        if ($post['item_pph_satuan'][$key2] == '') {
          $input_item[$key2]['ppi_pph'] = null;
        }else{
          $input_item[$key2]['ppi_pph']=$post['item_pph_satuan'][$key2]; 
        }

        $tipe = $post['item_tipe'][$key2];
        $kode = $post['item_kode'][$key2];

        if($tipe == "BARANG"){
          $com = $this->Commodity_m->getMatCatalog($kode)->row_array();
        } else {
          $com = $this->Commodity_m->getSrvCatalog($kode)->row_array();
        }

        $input_item[$key2]['ppi_currency']= "IDR";
        //$input_item[$key2]['ppi_currency']=$com['currency'];
        $input_item[$key2]['ppi_type']=$tipe;

      }

    }

    $n++;

  }

}

if ($this->form_validation->run() == FALSE || $error){

  //$this->ubah_permintaan_pengadaan();

  $this->renderMessage("error");

} else {

  $this->db->trans_begin();

  $act = $this->Procpr_m->updateDataPR($pr_number,$input);

  $act = true;
  
  $complete_comment = 1;

  if($act){

    if(!empty($input_doc)){

      $deleted = array();

      foreach ($input_doc as $key => $value) {
        $value['pr_number'] = $pr_number;
        $id = (isset($value['ppd_id'])) ? $value['ppd_id'] : "";
        $act = $this->Procpr_m->replaceDokumenPR($id,$value);
        if($act){
          $deleted[] = $act;
        }
      }

      $this->Procpr_m->deleteIfNotExistDokumenPR($pr_number,$deleted);

    }

    if(!empty($input_item)){

      $deleted = array();

      foreach ($input_item as $key => $value) {
        $value['pr_number'] = $pr_number;
        $act = $this->Procpr_m->replaceItemPR($key,$value);
       
        if($act){
          $deleted[] = $act;
        }
      }

      $this->Procpr_m->deleteIfNotExistItemPR($pr_number,$deleted);

    }

    $response = $post['status_inp'][0];

    $com = $post['comment_inp'][0];

    $attachment = $post['comment_attachment_inp'][0];

    $this->db->select('*');
    $this->db->from('prc_pr_main');
    $this->db->where('pr_number', $pr_number);
    $isSwakelola = $this->db->get()->row_array();

    $return = $this->Procedure_m->prc_pr_comment_complete($pr_number,$userdata['complete_name'],$last_comment['activity'],$response,$com,$attachment,$last_comment['comment_id'],$perencanaan_id,$userdata['employee_id'],$isSwakelola['isSwakelola']);

    if(!empty($return['nextactivity'])){

      if(!empty($return['newnumber'])){
        $comment = $this->Comment_m->insertProcurementRFQ($return['newnumber'],$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname']);
      } else {
        $comment = $this->Comment_m->insertProcurementPR($pr_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname']);
      }

    } else {

  }

}

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

//echo $this->db->last_query();

$this->renderMessage("success",site_url("procurement/daftar_pekerjaan"));
//$this->renderMessage("success");

}
