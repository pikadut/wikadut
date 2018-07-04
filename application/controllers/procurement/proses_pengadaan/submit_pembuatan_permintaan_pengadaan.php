<?php

$post = $this->input->post();
$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

$this->form_validation->set_rules("perencanaan_pengadaan_inp", "Nomor Perencanaan Pengadaan", 'required|max_length['.DEFAULT_MAXLENGTH.']');
/*$this->form_validation->set_rules("lokasi_kebutuhan_inp", "Lokasi Kebutuhan", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');*/
$this->form_validation->set_rules("lokasi_pengiriman_inp", "Lokasi Pengiriman", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("tipe_pr", "Jenis PR", 'required|max_length['.DEFAULT_MAXLENGTH.']'); //y jenis pr

$perencanaan_id = $post['perencanaan_pengadaan_inp'];
$perencanaan = $this->Procplan_m->getPerencanaanPengadaan($perencanaan_id)->row_array();

$input['pr_subject_of_work']= (isset($post['nama_pekerjaan'])) ? $post['nama_pekerjaan'] : $perencanaan['ppm_subject_of_work'];
$input['pr_scope_of_work']= (isset($post['deskripsi_pekerjaan'])) ? $post['deskripsi_pekerjaan'] : $perencanaan['ppm_scope_of_work'];
$input['pr_mata_anggaran']=$perencanaan['ppm_mata_anggaran'];
$input['pr_nama_mata_anggaran']=$perencanaan['ppm_nama_mata_anggaran'];
$input['pr_sub_mata_anggaran']=$perencanaan['ppm_sub_mata_anggaran'];
$input['pr_nama_sub_mata_anggaran']=$perencanaan['ppm_nama_sub_mata_anggaran'];
$input['pr_currency']=$perencanaan['ppm_currency'];
$input['pr_pagu_anggaran']= (isset($post['total_pagu_inp'])) ? $post['total_pagu_inp'] : $perencanaan['ppm_pagu_anggaran'];
$input['pr_sisa_anggaran']= (isset($post['sisa_pagu_inp'])) ? $post['sisa_pagu_inp'] : $perencanaan['ppm_sisa_anggaran'];
$input['pr_dept_id']=$position['dept_id'];
$input['pr_dept_name']=$position['dept_name'];
$input['pr_created_date']=date("Y-m-d H:i:s");
$input['pr_requester_name']=$userdata['complete_name'];
$input['pr_requester_pos_code']=$position['pos_id'];
$input['pr_requester_pos_name']=$position['pos_name'];
$input['pr_requester_id']=$userdata['employee_id'];
$input['pr_project_name']=$perencanaan['ppm_project_name']; //y
$input['pr_type_of_plan']=$perencanaan['ppm_type_of_plan']; //y
$input['pr_type']=$post['tipe_pr'];//y
//start code hlmifzi
if (empty($post['swakelola_inp'])){
    $swakelola_inp = null;
} else {
   $swakelola_inp = $post['swakelola_inp'];
}
$input['isSwakelola']=$swakelola_inp;
//end code
$kebutuhan_id = (isset($post['lokasi_kebutuhan_inp'])) ? $post['lokasi_kebutuhan_inp'] : "";

if(!empty($kebutuhan_id)){
  $kebutuhan = $this->Administration_m->getDistrict($kebutuhan_id)->row_array();
  $input['pr_district']=$kebutuhan['district_name'];
  $input['pr_district_id']=$kebutuhan_id;
}

$pengiriman_id = (isset($post['lokasi_pengiriman_inp'])) ? $post['lokasi_pengiriman_inp'] : "";
if(!empty($pengiriman_id)){
  $pengiriman = $this->Administration_m->get_divisi_departemen($pengiriman_id)->row_array();
  $input['pr_delivery_point_id']=$pengiriman_id;
  $type = (!empty($pengiriman['dept_type'])) ? "Pelabuhan" : "Divisi";
  $input['pr_delivery_point']=$type." - ".$pengiriman['dept_name'];
}

$jenis_kontrak_inp = (isset($post['jenis_kontrak_inp'])) ? $post['jenis_kontrak_inp'] : "";
$input['pr_contract_type']=$jenis_kontrak_inp;
$input['ppm_id']=$perencanaan_id;
$input['pr_number']=$this->Procpr_m->getUrutPR();

$input_doc = array();

$input_item = array();

$n = 0;

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 


      $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
      $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

      $input_doc[$key2]['ppd_id']= (isset($post['doc_id_inp'][$key2])) ? $post['doc_id_inp'][$key2] : "";
      $input_doc[$key2]['ppd_category']=(isset($post['doc_category_inp'][$key2])) ? $post['doc_category_inp'][$key2] : "";
      $input_doc[$key2]['ppd_description']=(isset($post['doc_desc_inp'][$key2])) ? $post['doc_desc_inp'][$key2] : "";
      $input_doc[$key2]['ppd_file_name']=(isset($post['doc_attachment_inp'][$key2])) ? $post['doc_attachment_inp'][$key2] : "";

      if(isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])){

        $this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
        $this->form_validation->set_rules("item_satuan[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("item_harga_satuan[$key2]", "Harga #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');
        $this->form_validation->set_rules("item_subtotal[$key2]", "Subtotal #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');

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

      //$input_item[$n]['ppi_currency']=$com['currency'];
        $input_item[$key2]['ppi_currency']= "IDR";
        $input_item[$key2]['ppi_type']=$tipe;

      }

    }

    $n++;

  }

}

$error = false;

//y validasi tipe pr
if($post['tipe_pr'] == "NON KONSOLIDASI" ){
  if ($post['total_alokasi_ppn_inp'] > 25000000) {
    $this->setMessage("Tipe PR non konsolidasi harus <= 25 juta");
    $error= true;
  }
}elseif ($post['tipe_pr'] == "KONSOLIDASI") {
  if($post['total_alokasi_ppn_inp'] <= 25000000){
    $this->setMessage("Tipe PR konsolidasi harus lebih dari 25 juta");
    $error = true;
  }elseif ($post['total_alokasi_ppn_inp'] > 20000000000) {
    $this->setMessage("Tipe PR konsolidasi harus <= 20 milyar");
    $error= true;
  }
}elseif ($post['tipe_pr'] == "MATERIAL STRATEGIS") {
  if($input['pr_type_of_plan'] == "rkap" and $post['total_alokasi_ppn_inp'] < 20000000000){
    $this->setMessage("Tipe PR material strategis non proyek harus > 20 milyar");
    $error = true;
  }elseif ($input['pr_type_of_plan'] == "rkp" and $post['total_alokasi_ppn_inp'] < 200000000000) {
    $this->setMessage("Tipe PR material strategis proyek harus > 200 milyar");
    $error = true;
  }else{
    $this->setMessage("Tipe proyek tidak ada");
    $error = true;
  }
}else{
  $this->setMessage("Tipe perencanaan harus dipilih");
  $error = true;
}
//end

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

if ($this->form_validation->run() == FALSE || $error){

  //$this->pembuatan_permintaan_pengadaan();

  $this->renderMessage("error");

} else {

  $this->db->trans_begin();

  $act = $this->Procpr_m->insertDataPR($input);

  $complete_comment = 1;

  if($act){

    $pr_number = $input['pr_number'];

    foreach ($input_doc as $key => $value) {
      if(!empty($value['ppd_file_name'])){
        $value['pr_number'] = $pr_number;
        $act = $this->Procpr_m->insertDokumenPR($value);
      }
    }

    foreach ($input_item as $key => $value) {
      if(!empty($value['ppi_quantity']) && !empty($value['ppi_price'])){
        $value['pr_number'] = $pr_number;
        $act = $this->Procpr_m->insertItemPR($value);
      }
    }


    $response =$post['status_inp'][0];

    $com = $post['comment_inp'][0];

    $attachment = $post['comment_attachment_inp'][0];

    $comment = $this->Comment_m->insertProcurementPR($pr_number,1000 ,$com,$response);

    $last_id = $this->db->insert_id();

    $return = $this->Procedure_m->prc_pr_comment_complete($pr_number,$userdata['complete_name'],1000,$response,$com,$attachment,$last_id,$perencanaan_id,$userdata['employee_id'],$swakelola_inp,$perencanaan['ppm_type_of_plan']);

    if(!empty($return['nextactivity'])){

     $comment = $this->Comment_m->insertProcurementPR($pr_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname']);

   } 

 }

 if ($this->db->trans_status() === FALSE)
 {
  $this->setMessage("Gagal menambah data");
  $this->db->trans_rollback();
}
else
{
  $this->setMessage("Sukses menambah data");
  $this->db->trans_commit();
}

$this->renderMessage("success",site_url("procurement/proses_pengadaan/daftar_permintaan_pengadaan"));

}
