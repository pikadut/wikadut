<?php

$post = $this->input->post();

//$last_id = $post['id'];

$input = array();

//$key2 = 0;

$userdata = $this->data['userdata'];

//$idtpm = $post['tpm_id'];

$penerimaan = $this->Tikplan_m->getPenerimaanTiket($idtpm)->row_array();

$this->form_validation->set_rules("status_inp[0]", "lang:status[0]", 'required');
$this->form_validation->set_rules("comment_inp[0]", "lang:comment[0]", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');


$status = $post['status_inp'][0];

$statusreq = $post['status_inp'][0];

$wkf = array(3=>"Setuju",4=>"Tolak");

$activity_list = array(3=>"Barang diterima");

$response = $wkf[$status];

$activity = $activity_list[$status];

$com = $post['comment_inp'][0];

$attachment = $post['comment_attachment_inp'][0];


$input['trm_status']=$status;
$input['trm_status_activity']=$status;

$input_comment = array();

if($status == 3 ){
  $input['trm_entried_date'] = date("Y-m-d H:i:s");
  $input['trm_entried_pos_code'] = $userdata['pos_id'];
  $input['trm_entried_pos_name'] = $userdata['pos_name'];
}

/*
print_r($post);

print_r($input);

print_r($input_comment);

exit();
*/



$n = 0;


foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 
	
		if(isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])){
			
			$this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
			$this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
			$this->form_validation->set_rules("item_sisa[$key2]", "Sisa #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');
      		
			if(!empty($post['item_id'][$key2])){
				$input_item[$key2]['tpi_id']=$post['item_id'][$key2];
			}
			
			$input_item[$key2]['tpi_code']=$post['item_kode'][$key2];
			$input_item[$key2]['tpi_description']=$post['item_deskripsi'][$key2];
			$input_item[$key2]['tpi_lane_name']=$post['item_lintasan'][$key2];
			$input_item[$key2]['tpi_quantity']=$post['item_jumlah'][$key2];
			$input_item[$key2]['tpi_unit']=$post['item_satuan'][$key2];
			$input_item[$key2]['tpi_note']=$post['item_keterangan'][$key2];;
			$input_item[$key2]['tpi_series']=$post['item_series'][$key2];
		}	

    }

    $n++;

  }

}


if ($this->form_validation->run() == FALSE){

  $this->renderMessage("error");


} else {

  $this->db->trans_begin();

  $act = //$this->Tikplan_m->updateStatusPT($last_id,$status);  
		 $this->Tikplan_m->insertDataPenerimaanTiket($last_id,$input);  

  $last_id = $this->db->insert_id();

  if($act){

    //$this->Comment_m->updateDataPT($last_id,$com,$response,$attachment,$activity);
    $this->Comment_m->insertTiketReceived($last_id,$com,$response,$attachment,$activity);
	
     foreach ($input_comment as $key => $value) {
      $value['trm_id'] = $last_id;
      $act = $this->Tikplan_m->insertDokumenPT($value);
    }
	
	if(!empty($input_item)){

      $deleted = array();

      foreach ($input_item as $key => $value) {
        $value['trm_id'] = $last_id;
        $act = $this->Tikplan_m->insertItemPenerimaanTiket($value);
       
        if($act){
          $deleted[] = $act;
        }
      }

      $this->Tikplan_m->deleteIfNotExistItemPT($last_id,$deleted);

    }
	

  }
  

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal approve data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses approve data");
    $this->db->trans_commit();
  }

  $this->renderMessage("success",site_url("tiket/permintaan_tiket/rekapitulasi_permintaan_tiket"));

}
