<?php

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$activity_list = array(0=>"Penjualan Tiket",1=>"Penjualan Tiket");

$post = $this->input->post();

$last_id = $post['id'];

$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC TIKET");

if(!$position){
  $this->noAccess("Hanya PIC TIKET yang dapat mengubah permintaan tiket");
}


$input['tsm_created_date']=date("Y-m-d H:i:s");
$input['tsm_district_id']=$userdata['district_id'];
$input['tsm_district_name']=$userdata['district_name'];
$input['tsm_dept_id']=$userdata['dept_id'];
$input['tsm_dept_name']=$userdata['dept_name'];
$input['tsm_entry_pos_code']=$userdata['pos_id'];
$input['tsm_entry_pos_name']=$userdata['pos_name'];

if(!empty($position)){
$input['tsm_district_id']=$position['district_id'];
$input['tsm_district_name']=$position['district_name'];
$input['tsm_dept_id']=$position['dept_id'];
$input['tsm_dept_name']=$position['dept_name'];
$input['tsm_entry_pos_code']=$position['pos_id'];
$input['tsm_entry_pos_name']=$position['pos_name'];
}

if(!empty($userdata)){
$input['tsm_entry_name']=$userdata['complete_name'];
$input['tsm_entry_id']=$userdata['employee_id'];
}

$status=$post['status_inp'][0];
$input['tsm_status'] = $status;

if($status == 1 ){
  $input['tsm_status_name'] = 'Belum Disetujui';
} else {
  $input['tsm_status_name'] = 'Simpan Sementara';
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
			
			if(!empty($post['item_id'][$key2])){
				$input_item[$key2]['tsi_id']=$post['item_id'][$key2];
			}
			
			$input_item[$key2]['tsi_lane_name']=$post['item_lintasan'][$key2];
			$input_item[$key2]['tsi_code']=$post['item_kode'][$key2];
			$input_item[$key2]['tsi_description']=$post['item_deskripsi'][$key2];
			$input_item[$key2]['tsi_unit']=$post['item_satuan'][$key2];
			$input_item[$key2]['tsi_pengadaan']=$post['item_pengadaan'][$key2];
			$input_item[$key2]['tsi_remaining']=$post['item_sisa'][$key2];
			$input_item[$key2]['tsi_quantity']=$post['item_jumlah'][$key2];
			$input_item[$key2]['tsi_series']=$post['item_series'][$key2];
			$input_item[$key2]['tsi_expired']=$post['item_jumlah_exp'][$key2];
			$input_item[$key2]['tsi_series_expired']=$post['item_series_exp'][$key2];
			$input_item[$key2]['tsi_date']=date("Y-m-d H:i:s")[$key2];
			
		}	

    }

    $n++;

  }

}


$error = false;

/*
print_r($post);

print_r($input);

print_r($input_comment);

exit();
*/



if ($this->form_validation->run() == FALSE || $error){


  $this->renderMessage("error");

} else {

  $this->db->trans_begin();

  $act = $this->Tiksale_m->updateDataST($last_id,$input);

  if($act){

    $com=$post['comment_inp'][0];

    $attachment = $post['comment_attachment_inp'][0];

    $activity = $activity_list[$status];

    $wkf = $this->data['workflow_list'];
    
    $response = $wkf[$status];
    
    $this->Comment_m->insertTiketSold($last_id,$com,$response,$attachment,$activity);

     foreach ($input_comment as $key => $value) {
      $value['tsm_id'] = $last_id;
      $act = $this->Tiksale_m->insertDokumenST($value);
    }
	

	if(!empty($input_item)){

      $deleted = array();

      foreach ($input_item as $key => $value) {
        $value['tsm_id'] = $last_id;
        $act = $this->Tiksale_m->replaceItemST($key,$value);
       
        if($act){
          $deleted[] = $act;
        }
      }

      $this->Tiksale_m->deleteIfNotExistItemST($last_id,$deleted);

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

  $this->renderMessage("success",site_url("tiket/penjualan_tiket/update_daftar_penjualan_tiket"));

}