<?php 

$view = 'procurement/proses_pengadaan/view/load_evaluation_v';

$ptm_number = $this->session->userdata("rfq_id");

$data['act'] = $this->uri->segment(3, 0);

$data['viewer'] = $this->uri->segment(4, 0);

$data['activity_id'] = $this->session->userdata("activity_id");

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$eval = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

$data['evaluation'] = $eval;

$first_price = array();

$this->db->distinct()->select("ptv_vendor_code");
$history = $this->Procrfq_m->getVendorQuoHistRFQ("",$ptm_number)->result_array();

foreach ($history as $key => $value) {
	if(!isset($first_price[$value['ptv_vendor_code']])){
		$this->db->distinct()->select("total,total_ppn")->order_by("pqm_created_date","asc");
		$dat = $this->Procrfq_m->getVendorQuoHistRFQ($value['ptv_vendor_code'],$ptm_number)->row_array();
		$first_price[$value['ptv_vendor_code']] = array(
			"total"=>$dat['total'],
			"total_ppn"=>$dat['total_ppn'],
			);
	}
}

$data['first_price'] = $first_price;

$this->load->view($view,$data);