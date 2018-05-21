<?php 

$userdata = $this->data['userdata'];

$contract_id = $this->session->userdata("contract_id");

$contract = $this->Contract_m->getData($contract_id)->row_array();

$post = $this->input->post();

$input = array();

$message = "";

$selection = $this->data['selection_milestone'];

if(empty($post)){
	$message = "Isi data penagihan";
} else if(empty($post['no_penagihan_inp'])){
	$message = "Isi nomor penagihan";
}else if(empty($post['rek_bank_inp'])){
	$message = "Isi rekening bank penagihan";
} else if(empty($post['tgl_penagihan_inp'])){
	$message = "Isi tanggal penagihan";
} else if(empty($selection)){
	$message = "Pilih milestone penagihan";
} else {

	$input = array(
		"invoice_date"=>$post['tgl_penagihan_inp'],
		"vendor_id"=> $contract['vendor_id'],
		"vendor_name"=> $contract['vendor_name'],
		"invoice_number"=> $post['no_penagihan_inp'],
		"contract_id"=> $contract['contract_id'],
		"contract_number"=> $contract['contract_number'],
		"bank_account"=> $post['rek_bank_inp'],
		"bank_account"=> $post['rek_bank_inp'],
		"created_date"=>date("Y-m-d H:i:s"),
		);

	  $this->db->trans_begin();

	$this->db->insert("ctr_invoice_header",$input);

	$invoice_id =  $this->db->insert_id();

	if(!empty($invoice_id)){

		$this->form_validation->set_rules("id", 'ID', 'required');

		$input_doc = array();

		foreach ($post as $key => $value) {

			if(is_array($value)){

				foreach ($value as $key2 => $value2) { 

					$this->form_validation->set_rules($key."[".$key2."]", '', '');

					if(isset($post['doc_id_tagihan_inp'][$key2])){
						$input_doc[$key2]['doc_id'] = $post['doc_id_tagihan_inp'][$key2];
					}

					if(isset($post['doc_category_tagihan_inp'][$key2])){
						$this->form_validation->set_rules("doc_category_tagihan_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
						$input_doc[$key2]['category']= $post['doc_category_tagihan_inp'][$key2];
					}
					if(isset($post['doc_desc_tagihan_inp'][$key2])){
						$this->form_validation->set_rules("doc_desc_tagihan_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
						$input_doc[$key2]['description']= $post['doc_desc_tagihan_inp'][$key2];
					}
					if(isset($post['doc_attachment_tagihan_inp'][$key2])){
						$this->form_validation->set_rules("doc_attachment_tagihan_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
						$input_doc[$key2]['filename']= $post['doc_attachment_tagihan_inp'][$key2];
					}

					if(isset($post['doc_vendor_tagihan_inp'][$key2])){
						$this->form_validation->set_rules("doc_vendor_tagihan_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
						$input_doc[$key2]['status']= $post['doc_vendor_tagihan_inp'][$key2];
					}

				}

			}

		}

		foreach ($input_doc as $key => $value) {
			$value['invoice_id'] = $invoice_id;
			$this->db->insert("ctr_invoice_doc",$value);
		}

		foreach ($selection as $key => $value) {
			$milestone = $this->Contract_m->getMilestone($value)->row_array();
			$total = $contract['contract_amount']*($milestone['percentage']/100);
			$input_item = array(
				"invoice_id"=>$invoice_id,
				"bastp_amount"=>$total,
				"bastp_subtotal"=>$total,
				"milestone_id"=> $value
				);
			$this->db->insert("ctr_invoice_item",$input_item);
		}

	}

	if ($this->db->trans_status() === FALSE)
  {
  	$message = "Gagal mengubah data";
    $this->db->trans_rollback();
  }
  else
  {
    $this->db->trans_commit();
    $this->session->set_userdata("selection_milestone",array());
  }

}

$this->output
->set_content_type('application/json')
->set_output(json_encode(array('message' => $message)));