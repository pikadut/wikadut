<?php

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$activity_list = array(0=>"Pembuatan Draft Penerimaan Tiket",1=>"Draft Penerimaan Tiket");

$post = $this->input->post();

$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat membuat penerimaan tiket");
}

$idtpm = $post['tpm_id'];

$penerimaan = $this->Tikplan_m->getPenerimaanTiket($idtpm)->row_array();


$input['tpm_id']=$idtpm;
$input['tpm_number']=$penerimaan['tpm_number'];;
$input['trm_created_date']=date("Y-m-d H:i:s");
$input['trm_district_id']=$penerimaan['tpm_district_id'];
$input['trm_district_name']=$penerimaan['tpm_district_name'];
$input['trm_dept_id']=$penerimaan['tpm_dept_id'];
$input['trm_dept_name']=$penerimaan['tpm_dept_name'];
$input['trm_entry_pos_code']=$userdata['pos_id'];
$input['trm_entry_pos_name']=$userdata['pos_name'];

if(!empty($position)){
$input['trm_district_id']=$position['district_id'];
$input['trm_district_name']=$position['district_name'];
$input['trm_dept_id']=$position['dept_id'];
$input['trm_dept_name']=$position['dept_name'];
$input['trm_entry_pos_code']=$position['pos_id'];
$input['trm_entry_pos_name']=$position['pos_name'];
}

if(!empty($userdata)){
$input['trm_entry']=$userdata['complete_name'];
$input['trm_entry_id']=$userdata['employee_id'];
}

$status=$post['status_inp'][0];
$input['trm_status'] = $status;


$input_comment = array();
$input_item = array();

$n = 0;

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) {
		
		if(isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])){
			
			$this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
			$this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
			
			$input_item[$key2]['tri_code']=$post['item_kode'][$key2];
			$input_item[$key2]['tri_description']=$post['item_deskripsi'][$key2];
			$input_item[$key2]['tri_lane_name']=$post['item_lintasan'][$key2];
			$input_item[$key2]['tri_quantity']=$post['item_jumlah'][$key2];
			$input_item[$key2]['tri_unit']=$post['item_satuan'][$key2];
			$input_item[$key2]['tri_note']=$post['item_keterangan'][$key2];
			$input_item[$key2]['tri_series']=$post['item_series'][$key2];
		}	

    }

    $n++;

  }

}


/*
print_r($post);

print_r($input);

print_r($input_comment);

exit();
*/


$error = false;

if($post['status_inp'][0] != '0'){ //Menambahkan eksepsi validasi untuk pembuatan draft permintaan pengadaan
  if(!isset($post['item_kode'])){
    $this->setMessage("Tidak ada item yang dipilih");
    if(!$error){
      $error = true;
    }
  }
}

if ($this->form_validation->run() == FALSE || $error){


  $this->renderMessage("error");

} else {

  $this->db->trans_begin();

  $act = $this->Tikplan_m->insertDataPenerimaanTiket($input);

  if($act){

    $last_id = $this->db->insert_id();

    $com=$post['comment_inp'][0];

    $attachment = $post['comment_attachment_inp'][0];

    $activity = $activity_list[$status];

    $wkf = $this->data['workflow_list'];
    
    $response = $wkf[$status];
    
    $this->Comment_m->insertTiketReceive($last_id,$com,$response,$attachment,$activity);

    foreach ($input_comment as $key => $value) {
      $value['trm_id'] = $last_id;
      $act = $this->Tikplan_m->insertDokumenPT($value);
    }
	
	foreach ($input_item as $key => $value) {
      $value['trm_id'] = $last_id;
      $act = $this->Tikplan_m->insertItemPenerimaanTiket($value);
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

  $this->renderMessage("success",site_url("tiket/penerimaan_tiket/daftar_pembuatan_penerimaan_tiket"));

}
