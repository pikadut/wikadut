<?php

$post = $this->input->post();

$input = array();


$userdata = $this->data['userdata'];

$mgr_cabang_entry = $this->Administration_m->getPosition("PIC TIKET");

if($mgr_cabang_entry){
	$this->data['workflow_list'] = array(3=>"Barang telah diterima");
} else {
	$this->noAccess("Hanya PIC TIKET yang dapat mengelola penerimaan tiket");
}

$this->form_validation->set_rules("status_inp[0]", "lang:status[0]", 'required');
$this->form_validation->set_rules("comment_inp[0]", "lang:comment[0]", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');


$status = $post['status_inp'][0];

$wkf = array(3=>"Barang Telah Diterima",4=>"Tolak");

$activity_list = array(3=>"Penerimaan Barang");

$input['trm_status']=$status;
$input['trm_status_activity']=$status;


if($status == 3 ){
	$input['tpm_id']=$post['tpm_id'];
	$input['tpm_number']=$post['tpm_number'];
	$input['trm_created_date']=date("Y-m-d H:i:s");
	$input['trm_district_id']=$userdata['district_id'];
	$input['trm_district_name']=$userdata['district_name'];
	$input['trm_dept_id']=$userdata['dept_id'];
	$input['trm_dept_name']=$userdata['dept_name'];
	$input['trm_created_date'] = date("Y-m-d H:i:s");
	$input['trm_entry_pos_code'] = $userdata['pos_id'];
	$input['trm_entry_pos_name'] = $userdata['pos_name'];
	$input['trm_entry_name']=$userdata['complete_name'];
	$input['trm_entry_id']=$userdata['employee_id'];
	$input['trm_status_name']='Barang Telah Diterima';
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
			$this->form_validation->set_rules("item_sisa[$key2]", "Sisa #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
      		
			if(!empty($post['item_id'][$key2])){
				$input_item[$key2]['tri_id']=$post['item_id'][$key2];
			}
			
			$input_item[$key2]['tri_code']=$post['item_kode'][$key2];
			$input_item[$key2]['tri_description']=$post['item_deskripsi'][$key2];
			$input_item[$key2]['tri_lane_name']=$post['item_lintasan'][$key2];
			$input_item[$key2]['tri_quantity']=$post['item_jumlah'][$key2];
			$input_item[$key2]['tri_date']=$post['item_tanggal'][$key2];
			$input_item[$key2]['tri_unit']=$post['item_satuan'][$key2];
			$input_item[$key2]['tri_note']=$post['item_keterangan'][$key2];
			$input_item[$key2]['tri_remaining']=$post['item_sisa'][$key2];
			$input_item[$key2]['tri_series']=$post['item_series'][$key2];
			$input_item[$key2]['tri_series_end']=$post['item_series_end'][$key2];
			$input_item[$key2]['tri_angkut']=$post['item_angkut'][$key2];
			$input_item[$key2]['tri_pelabuhan']=$post['item_pelabuhan'][$key2];
			$input_item[$key2]['tri_asuransi']=$post['item_asuransi'][$key2];
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


if ($this->form_validation->run() == FALSE){

  $this->renderMessage("error");


} else {

  $this->db->trans_begin();

  $act = $this->Tikplan_m->insertDataPenerimaanTiket($input);  


  if($act){
	  
	$last_id = $this->db->insert_id();
	
	$tpm = $post['tpm_id'][0];
	
	$response = $wkf[$status];

	$activity = $activity_list[$status];

	$com = $post['comment_inp'][0];

	$attachment = $post['comment_attachment_inp'][0];
	
    $this->Comment_m->insertTiketPlan($tpm,$com,$response,$attachment,$activity);
	
    foreach ($input_comment as $key => $value) {
      $value['tpm_id'] = $tpm;
      $act = $this->Tikplan_m->insertDokumenPT($value);
    }
	
	foreach ($input_item as $key => $value) {
      $value['trm_id'] = $last_id;
      $act = $this->Tikplan_m->insertItemPenerimaanTiket($value);
    }
	

  }
  

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal entry data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses entry data");
    $this->db->trans_commit();
  }

  $this->renderMessage("success",site_url("tiket/permintaan_tiket/daftar_penerimaan_tiket"));

}
