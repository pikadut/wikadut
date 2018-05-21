<?php 

$post = $this->input->post();

$view = 'contract/proses_work_order/proses_work_order_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$data['id'] = $id;

$data['pos'] = $position;

$this->data['dir'] = CONTRACT_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","KONTRAK"=>"KONTRAK");

$last_comment = $this->Comment_m->getWO("",$id)->row_array();

$po_id = $last_comment['po_id'];

$activity_id = (!empty($last_comment['activity'])) ? $last_comment['activity'] : 2011;

$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();

$po = $this->Contract_m->getDataWO($po_id)->row_array();

$data['po'] = $po;

$contract_id = $po['contract_id'];

$kontrak = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $kontrak['ptm_number'];

$item = $this->Contract_m->getItem("",$contract_id)->result_array();

$x = $this->Contract_m->getWOItem("",$po_id)->result_array();

$wo_out = 0;

foreach ($x as $key => $value) {

	$data['item_wo'][$value['contract_item_id']] = $value['qty'];

}

$totalwo = $this->db->select("COALESCE(SUM(sub_total),0) as total")->where("contract_id",$contract_id)->where("approved_date !=",null)
->join("ctr_po_header a","a.po_id=b.po_id")->get("ctr_po_item b")->row()->total;

$data['totalwo'] = $totalwo;

$data['item'] = $item;

$this->db->where("job_title","PENGELOLA KONTRAK");

$data['pelaksana_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$this->db->where("job_title","MANAJER PENGADAAN");

$data['manajer_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$data['last_comment'] = $last_comment;

$data['kontrak'] = $kontrak;

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

//echo $this->db->last_query();

//startcode helmi

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

		$head[$value['vendor_name']]['total'] += ($value['pqi_price']*$value['pqi_quantity']) + (($value['pqi_price']*$value['pqi_quantity']) * 
		(($value['pqi_ppn']+$value['pqi_pph'])/100));

	}
}


$data['nilai_kontrak'] = $head; 

//end


$data['milestone'] = $this->Contract_m->getMilestone("",$contract_id)->result_array();

$data['document'] = $this->Contract_m->getDoc("",$contract_id)->result_array();

$data['doc_category'] = $this->Contract_m->getDocType()->result_array();

$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = $this->Comment_m->getWO($po_id)->result_array();

$this->session->set_userdata("rfq_id",$ptm_number);

$this->session->set_userdata("contract_id",$contract_id);

$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);