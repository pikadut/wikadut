<?php

$userdata = $this->data['userdata'];

$view = 'procurement/eauction/form_v';

$ptm_number = $id;

$data = array(
	'controller_name'=>"procurement",
	"id"=>$ptm_number,
	);

$this->session->set_userdata("rfq_id",$ptm_number);

$activity_id = 1109;

$permintaan = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

$data['permintaan'] = $permintaan;

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$data["comment_list"][0] = $this->Comment_m->getProcurementRFQActive($ptm_number)->result_array();

$data['document'] = $this->Procrfq_m->getDokumenRFQ("",$ptm_number)->result_array();

$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$data['workflow_list'] = $this->Procedure_m->getResponseList($activity_id);

$eauction_header = $this->db->where("PPM_ID",$ptm_number)->get("prc_eauction_header")->row_array();

$data['eauction_header'] = $eauction_header;

$data['activity_id'] = $activity_id;

$data['dari'] = (isset($eauction_header['TANGGAL_MULAI'])) ?  strtotime($eauction_header["TANGGAL_MULAI"]) : 0;
$data['sampai'] = (isset($eauction_header['TANGGAL_BERAKHIR'])) ?  strtotime($eauction_header["TANGGAL_BERAKHIR"]) : 0;


$eauction_detail = $this->db->where("PPM_ID",$ptm_number)->get("prc_eauction_item")->result_array();

foreach ($eauction_detail as $key => $value) {
	$data['eauction_detail'][$value['TIT_ID']] = $value['VALUE_MIN'];
}

$this->template($view,"E-Auction (".$activity_id.")",$data);
