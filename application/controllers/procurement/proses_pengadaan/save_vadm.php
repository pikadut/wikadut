<?php 

$post = $this->input->post();

$input = array();

$pqt_check = 0;
$pqt_check_vendor = 0;

foreach ($post as $key => $value) {
	if(is_array($value)){
		foreach ($value as $key2 => $value2) {
			$input[$key2]['pqt_check'] = (isset($post['check_evaluation'][$key2])) ? 1 : 0;
			$input[$key2]['pqt_check_vendor'] = (isset($post['check_vendor'][$key2])) ? 1 : 0;
			$pqt_check_vendor += $input[$key2]['pqt_check_vendor'];
			$pqt_check += $input[$key2]['pqt_check'];
		}
	}
}

foreach ($input as $key => $value) {
	$this->Procrfq_m->updateQuoTechRFQ($key,$value);
}

$ptm_number = $post['id'];
$vendor_id = $post['vnd'];

$main = $this->Procrfq_m->getVendorQuoMainRFQ($vendor_id,$ptm_number)->row_array();

$tech = $this->Procrfq_m->getVendorQuoTechRFQ("",$main['pqm_id'])->result_array();
$pass = count($tech)*2;

$return = array();

foreach ($tech as $key => $value) {
	$total = $this->db->select("SUM(pqt_check+pqt_check_vendor) as total",false)->where("pqm_id",$value['pqm_id'])->get("prc_tender_quo_tech")->row()->total;
	$vendor_id = $main['ptv_vendor_code'];
	$return[$vendor_id] = (isset($return[$vendor_id])) ? $return[$vendor_id]+$total : $total;
}


$input2 = array("pvs_technical_remark"=>$post['note'],"pvs_commercial_remark"=>$post['note']);

$this->db
->where(array("pvs_vendor_code"=>$vendor_id,"ptm_number"=>$ptm_number))
->update("prc_tender_vendor_status",$input2);

$this->Procrfq_m->updateStatusVendorByQuo($ptm_number,$vendor_id);

foreach ($return as $vendor_id => $total) {
	$status = ($pqt_check_vendor == $pqt_check) ? 4 : -4;
	$adm_stat = ($pqt_check_vendor == $pqt_check) ? 1 : 0;
	$this->db->where(array(
		"ptm_number"=>$ptm_number,
		"pvs_vendor_code"=>$vendor_id))
	->update("prc_tender_vendor_status",array("pvs_status"=>$status,"pvs_technical_status"=>$adm_stat));
}