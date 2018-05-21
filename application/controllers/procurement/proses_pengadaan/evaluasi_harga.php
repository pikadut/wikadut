<?php 

$this->load->model("Vendor_m");

$data = array();

$act = $this->uri->segment(3, 0);

$data['act'] = $act;

$ptm_number = $this->session->userdata("rfq_id");

$vendor_id = $this->uri->segment(4, 0);

$post = $this->input->post();

$prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$data['tender'] = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

$evt_id = $prep['evt_id'];

$data['evaltemp'] = $this->Procevaltemp_m->getTemplateEvaluasi($evt_id)->row_array();

$data['prep'] = $prep;

$data['ptm_number'] = $ptm_number;

$pqm = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();

$quo_id = array();

$vendor_list = array();
$vendor_qualified = array();
$head = array();
$harga = array();
$total_harga = array();

foreach ($pqm as $key => $value) {

	//$this->db->where("pvs_status",4);
	$vnd = $this->Procrfq_m->getVendorStatusRFQ($value['ptv_vendor_code'],$ptm_number)->row_array();
	
	if(!empty($vnd)){
		$quo_id[] = $value['pqm_id'];
		$vnd['type_quo'] = $value['pqm_type'];
		$vnd['id'] = $value['pqm_id'];

		if($vnd['pvs_status'] > 0){
		$vendor_list[] = $vnd;
			$vendor_qualified[] = $value['ptv_vendor_code'];
			$head[$vnd['vendor_name']] = array("bid_bond"=>$value['pqm_bid_bond_value'],"valid_time"=>$value['pqm_valid_thru'],
				"subtotal"=>0,"subtotal_tax"=>0,"total"=>0);
		}
	}

}

$this->db->where("tit_id !=",null)->where_in("pqm_id",$quo_id);

$myharga = $this->Procrfq_m->getViewVendorQuoComRFQ()->result_array();

foreach ($myharga as $key => $value) {

	if(in_array($value['ptv_vendor_code'], $vendor_qualified)){

		$harga[$value['tit_id']][$value['vendor_name']] = array(
			"id"=>$value['tit_id'],
			"desc"=>$value['pqi_description'],
			"price"=>$value['pqi_price'],
			"qty"=>$value['pqi_quantity'],
			"ppn"=>$value['pqi_ppn'],
			"pph"=>$value['pqi_pph'],
			"guarantee"=>$value['pqi_guarantee'],
			"guarantee_type"=>$value['pqi_guarantee_type'],
			"deliverable"=>$value['pqi_deliverable'],
			"deliverable_type"=>$value['pqi_deliverable_type'],
			);

		if(!isset($head[$value['vendor_name']]['subtotal'])){
			$head[$value['vendor_name']]['subtotal'] = 0;
		}
		$head[$value['vendor_name']]['subtotal'] += $value['pqi_price']*$value['pqi_quantity'];

		if(!isset($head[$value['vendor_name']]['subtotal_tax'])){
			$head[$value['vendor_name']]['subtotal_tax'] = 0;
		}

		$head[$value['vendor_name']]['subtotal_tax'] += ($value['pqi_price']*$value['pqi_quantity']) * 
		(($value['pqi_ppn']+$value['pqi_pph'])/100);

		if(!isset($head[$value['vendor_name']]['total'])){
			$head[$value['vendor_name']]['total'] = 0;
		}
		$head[$value['vendor_name']]['total'] += ($value['pqi_price']*$value['pqi_quantity']) + (($value['pqi_price']*$value['pqi_quantity']) * 
		(($value['pqi_ppn']+$value['pqi_pph'])/100));

	}
}

$data['head'] = $head;

$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

$data['harga'] = $harga;

if(!empty($vendor_qualified)){
	$this->db->where_in("ptv_vendor_code",$vendor_qualified);
}

$data['nilai'] = $this->Procrfq_m->getEvalRFQ("",$ptm_number)->result_array();

$data['vendor'] = $vendor_list;

$data['comment'] = $this->Procrfq_m->getEvalComRFQ("",$ptm_number,"C")->result_array();

$view = 'procurement/proses_pengadaan/form/perbandingan_penawaran_harga_v';

$this->load->view($view,$data);
