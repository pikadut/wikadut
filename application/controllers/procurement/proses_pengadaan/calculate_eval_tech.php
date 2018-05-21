<?php 

$this->load->model("Vendor_m");

$post = $this->input->post();

if(!empty($post)){

	$input = array();

	$userdata = $this->Administration_m->getLogin();

	$ptm_number = $this->session->userdata("rfq_id");

	$pqm_list = array();

	foreach ($post['eval_tech'] as $key => $value) {
		if(!empty($value)){
			$value = ($value > 100) ? 100 : $value;
			$this->db->where("pqt_id",$key)->update("prc_tender_quo_tech",array("pqt_value"=>$value));
			$pqm_id = $this->db->where("pqt_id",$key)->get("prc_tender_quo_tech")->row()->pqm_id;
			if(!in_array($pqm_id,$pqm_list)){
				$pqm_list[] = $pqm_id;
			}
		}
	}

	$vendor_list = array();
	foreach ($post['eval_note'] as $key => $value) {
		$vendor_list[] = $this->db->where("pte_id",$key)->get("prc_tender_eval")->row()->ptv_vendor_code;
		$this->db->where("pte_id",$key)->update("prc_tender_eval",array("pte_technical_remark"=>$value));
	}

	$this->db
	->where("ptm_number",$ptm_number)
	->where_not_in("ptv_vendor_code",$vendor_list)
	->update("prc_tender_eval",array("pte_technical_value"=>0));

	$return = array();

	foreach ($pqm_list as $key => $value) {
		$total = $this->db->select("SUM(pqt_value*(pqt_weight/100)) as total")->where("pqm_id",$value)->get("prc_tender_quo_tech")->row()->total;
		$head = $this->db->where("pqm_id",$value)->get("prc_tender_quo_main")->row_array();
		$vendor_id = $head['ptv_vendor_code'];
		if(in_array($vendor_id, $vendor_list)){
			$this->db->where(array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$head['ptv_vendor_code']))
			->update("prc_tender_eval",array("pte_technical_value"=>$total));
			$return[$vendor_id] = $total;
		}
	}

	$this->Procrfq_m->updateVendorStatusByGrade($ptm_number,"teknis");

	$this->output
	->set_content_type('application/json')
	->set_output(json_encode($return));

}