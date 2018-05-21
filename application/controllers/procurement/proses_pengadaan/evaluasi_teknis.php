<?php 

$this->load->model("Vendor_m");

$data = array();

$act = $this->uri->segment(3, 0);

$data['act'] = $act;

$ptm_number = $this->session->userdata("rfq_id");

$vendor_id = $this->uri->segment(4, 0);

$post = $this->input->post();

$prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$evt_id = $prep['evt_id'];

$data['evaltemp'] = $this->Procevaltemp_m->getTemplateEvaluasi($evt_id)->row_array();

$data['prep'] = $prep;

$data['ptm_number'] = $ptm_number;

$pqm = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();

$quo_id = array();

$vendor_list = array();
$vendor_qualified = array();

foreach ($pqm as $key => $value) {

	//$this->db->where("pvs_status",4);
	$vnd = $this->Procrfq_m->getVendorStatusRFQ($value['ptv_vendor_code'],$ptm_number)->row_array();
	
	if(!empty($vnd)){
		$quo_id[] = $value['pqm_id'];
		if($vnd['pvs_status'] > 0 || ($act == "edit" && !in_array($vnd['pvs_status'], array(-12,-4,1,2)))){
			$vendor_list[] = $vnd;
			$vendor_qualified[] = $value['ptv_vendor_code'];
		}
	}

}


$this->db->where("pqt_weight !=",null)->where_in("pqm_id",$quo_id);

$myteknis = $this->Procrfq_m->getViewVendorQuoTechRFQ()->result_array();

$teknis = array();

foreach ($myteknis as $key => $value) {
	if(in_array($value['ptv_vendor_code'], $vendor_qualified)){
		if(!isset($teknis[$value['pqt_item'].$value['pqt_weight']])){
			$teknis[$value['pqt_item'].$value['pqt_weight']] = array("item"=>$value['pqt_item'],"weight"=>$value['pqt_weight'],"child"=>array());
		}
		$teknis[$value['pqt_item'].$value['pqt_weight']]['child'][] = array("id"=>$value['pqt_id'],"desc"=>$value['pqt_vendor_desc'],"value"=>$value['pqt_value'],"file"=>$value['pqt_attachment'],"vendor_id"=>$value['ptv_vendor_code']);
	}
}


$data['teknis'] = $teknis;

if(!empty($vendor_qualified)){
	$this->db->where_in("ptv_vendor_code",$vendor_qualified);
}

$data['nilai'] = $this->Procrfq_m->getEvalRFQ("",$ptm_number)->result_array();

$data['vendor'] = $vendor_list;

$data['comment'] = $this->Procrfq_m->getEvalComRFQ("",$ptm_number,"T")->result_array();

$view = 'procurement/proses_pengadaan/form/perbandingan_penawaran_teknis_v';

$this->load->view($view,$data);
