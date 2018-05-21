<?php

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$activity_list = array(0=>"Permintaan Tiket",1=>"Permintaan Tiket");

$post = $this->input->post();

$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat membuat permintaan tiket");
}


$input['tpm_number']=$this->Tikplan_m->getUrutPT();
$input['tpm_created_date']=date("Y-m-d H:i:s");
$input['tpm_district_id']=$userdata['district_id'];
$input['tpm_district_name']=$userdata['district_name'];
$input['tpm_dept_id']=$userdata['dept_id'];
$input['tpm_dept_name']=$userdata['dept_name'];
$input['tpm_planner_pos_code']=$userdata['pos_id'];
$input['tpm_planner_pos_name']=$userdata['pos_name'];

if(!empty($position)){
$input['tpm_district_id']=$position['district_id'];
$input['tpm_district_name']=$position['district_name'];
$input['tpm_dept_id']=$position['dept_id'];
$input['tpm_dept_name']=$position['dept_name'];
$input['tpm_planner_pos_code']=$position['pos_id'];
$input['tpm_planner_pos_name']=$position['pos_name'];
}

if(!empty($userdata)){
$input['tpm_planner']=$userdata['complete_name'];
$input['tpm_planner_id']=$userdata['employee_id'];
}

$status=$post['status_inp'][0];
$input['tpm_status'] = $status;


if($status == 4 ){
  $input['tpm_status_name'] = 'Revisi';
} else if($status == 1 ){
  $input['tpm_status_name'] = 'Belum Disetujui';
} else if($status == 0 ){
  $input['tpm_status_name'] = 'Simpan Sementara';
}


$input_comment = array();
$input_item = array();

$n = 0;

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) {
		
		if(isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])){
			
			$this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
			$this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
			$this->form_validation->set_rules("item_sisa[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
			//$this->form_validation->set_rules("item_angkut[$key2]", "Jasa Angkut #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
			//$this->form_validation->set_rules("item_pelabuhan[$key2]", "Jasa Pelabuhan #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
      		//$this->form_validation->set_rules("item_asuransi[$key2]", "Asuransi #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
      		
			$input_item[$key2]['tpi_code']=$post['item_kode'][$key2];
			$input_item[$key2]['tpi_description']=$post['item_deskripsi'][$key2];
			$input_item[$key2]['tpi_lane_name']=$post['item_lintasan'][$key2];
			$input_item[$key2]['tpi_quantity']=$post['item_jumlah'][$key2];
			$input_item[$key2]['tpi_date']=$post['item_tanggal'][$key2];
			$input_item[$key2]['tpi_unit']=$post['item_satuan'][$key2];
			$input_item[$key2]['tpi_note']=$post['item_keterangan'][$key2];
			$input_item[$key2]['tpi_remaining']=$post['item_sisa'][$key2];
			$input_item[$key2]['tpi_series']=$post['item_series'][$key2];
			$input_item[$key2]['tpi_series_end']=$post['item_series_end'][$key2];
			$input_item[$key2]['tpi_angkut']=$post['item_angkut'][$key2];
			$input_item[$key2]['tpi_pelabuhan']=$post['item_pelabuhan'][$key2];
			$input_item[$key2]['tpi_asuransi']=$post['item_asuransi'][$key2];
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

  $act = $this->Tikplan_m->insertDataPT($input);

  if($act){

    $last_id = $this->db->insert_id();

    $com=$post['comment_inp'][0];

    $attachment = $post['comment_attachment_inp'][0];

    $activity = $activity_list[$status];

    $wkf = $this->data['workflow_list'];
    
    $response = $wkf[$status];
    
    $this->Comment_m->insertTiketPlan($last_id,$com,$response,$attachment,$activity);

    foreach ($input_comment as $key => $value) {
      $value['tpm_id'] = $last_id;
      $act = $this->Tikplan_m->insertDokumenPT($value);
    }
	
	foreach ($input_item as $key => $value) {
      $value['tpm_id'] = $last_id;
      $act = $this->Tikplan_m->insertItemPT($value);
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

  $this->renderMessage("success",site_url("tiket/permintaan_tiket/daftar_permintaan_tiket"));

}
