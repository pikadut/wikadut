<?php

$post = $this->input->post();
$input = array();

$error = false;

/*
print_r($post);
exit();
*/

$userdata = $this->data['userdata'];

/*
$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat perencanaan pengadaan");
}
*/

$this->form_validation->set_rules("nama_inp", "Nama", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("jenis_inp", "Jenis", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');
$this->form_validation->set_rules("passing_grade_inp", "Passing Grade", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("bobot_teknis_inp", "Bobot Teknis", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("bobot_harga_inp", "Bobot Harga", 'required|max_length['.DEFAULT_MAXLENGTH.']');

$input['evt_name']=$post['nama_inp'];
$input['evt_type']=$post['jenis_inp'];
$input['evt_passing_grade']=moneytoint($post['passing_grade_inp']);
$input['evt_tech_weight']=moneytoint($post['bobot_teknis_inp']);
$input['evt_price_weight']=moneytoint($post['bobot_harga_inp']);

$input_detail = array();

$n = 0;

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules("item_name[$key2]", "lang:name #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("item_bobot[$key2]", "lang:weight #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
      $this->form_validation->set_rules("item_jenis[$key2]", "lang:type #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

      $input_detail[$key2]['etd_item']=$post['item_name'][$key2];;
      $input_detail[$key2]['etd_weight']=moneytoint($post['item_bobot'][$key2]);
      $input_detail[$key2]['etd_mode']=$post['item_jenis'][$key2];

    }

    $n++;

  }

}

$total = 0;

$total_admin = 0;

foreach ($input_detail as $key => $value) {
  $total += moneytoint($value['etd_weight']);
  if($value['etd_mode'] == 0){
    $total_admin++;
  }
}

if($input['evt_passing_grade'] < 0 || $input['evt_passing_grade'] > 100){
  $this->setMessage("Passing grade harus diantara 1 - 100");
  if(!$error){
    $error = true;
  }
}

if($input['evt_type'] == 1 && $input['evt_tech_weight']+$input['evt_price_weight'] != 100){
  $this->setMessage("Akumulasi teknis & harga harus 100");
  if(!$error){
    $error = true;
  }
}


if($total_admin == 0){
  $this->setMessage("Item administrasi wajib ada");
  if(!$error){
    $error = true;
  }
}

if($total != 100){
  $this->setMessage("Item bobot teknis harus 100");
  if(!$error){
    $error = true;
  }
}

if ($this->form_validation->run() == FALSE || $error){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->renderMessage("error");

} else {

  $this->db->trans_begin();

  $act = $this->Procevaltemp_m->insertDataTemplateEvaluasi($input);

  if($act){

    $last_id = $this->db->insert_id();
    foreach ($input_detail as $key => $value) {
      $value['evt_id'] = $last_id;
      $act = $this->Procevaltemp_m->insertDataTemplateEvaluasiDetail($value);
    }

  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal menambah data");
    $this->db->trans_rollback();
    $this->renderMessage("error");
  }
  else
  {
    $this->setMessage("Sukses menambah data");
    $this->db->trans_commit();
    $this->renderMessage("success",site_url("procurement/procurement_tools/daftar_template_evaluasi_pengadaan"));
  }

}
