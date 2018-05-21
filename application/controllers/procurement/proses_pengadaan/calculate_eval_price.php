<?php 

$this->load->model("Vendor_m");

$post = $this->input->post();


if(!empty($post)){

	$input = array();

	$userdata = $this->Administration_m->getLogin();

	$ptm_number = $this->session->userdata("rfq_id");

	$update = array();

	$vendor_lolos = array();

	foreach ($post['eval_note'] as $key => $value) {
		$update = array();
		if(!empty($value)){
			$update['pte_price_remark'] = $value;
		}
		$update['pte_validity_offer'] = (isset($post['validity_offer'][$key])) ? 1 : 0;
		$update['pte_validity_bid_bond'] = (isset($post['validity_bid_bond'][$key])) ? 1 : 0;
		$this->db->where("pte_id",$key)->update("prc_tender_eval",$update);
		if(!empty($update['pte_validity_offer']) && !empty($update['pte_validity_bid_bond'])){
			$vnd_id = $this->db->where("pte_id",$key)->get("prc_tender_eval")->row()->ptv_vendor_code;
			$vendor_lolos[] = $vnd_id;
		}
	}

	$pqm_list = array();

	$return = array();

	$lowest_price = 0;

	if(!empty($vendor_lolos)){

	$this->db->select("MIN(total) as total")->where_in("ptv_vendor_code",$vendor_lolos);
	$lowest_price = $this->Procrfq_m->getVendorPriceRFQ("",$ptm_number)->row()->total;

	}

	$pqm_list = $this->Procrfq_m->getVendorPriceRFQ("",$ptm_number)->result_array();

	foreach ($pqm_list as $key => $value) {
		$total = ($lowest_price/$value['total'])*100;
		$this->db->where("vendor_name",$value['vendor_name']);
		$vendor_id = $this->Vendor_m->getVendor()->row()->vendor_id;
		$eval = $this->db->where(
			array("ptm_number"=>$value['ptm_number'],"ptv_vendor_code"=>$vendor_id))
		->get("prc_tender_eval")->row_array();
		if (!(!empty($eval) && $eval['pte_validity_offer'] == 1 && $eval['pte_validity_bid_bond'] == 1)){
			$total = 0;

		}
		$this->db
		->where("pte_id",$eval['pte_id'])
		->update("prc_tender_eval",array("pte_price_value"=>$total));
		$return[$vendor_id] = $total;
	}


	$this->output
	->set_content_type('application/json')
	->set_output(json_encode($return));

}