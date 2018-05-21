<?php 

$post = $this->input->post();

$view = 'contract/proses_kontrak/proses_kontrak_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

$data['id'] = $id;

$data['pos'] = $position;
//haqim
$this->data['dir'] = CONTRACT_FOLDER."/comment";
//end

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","PERJANJIAN"=>"PERJANJIAN");

$last_comment = $this->Comment_m->getContract("",$id)->row_array();

$ptm_number = $last_comment['tender_id'];

$contract_id = $last_comment['contract_id'];

$activity_id = (!empty($last_comment['activity'])) ? $last_comment['activity'] : 2000;

$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();

if($activity_id == 2000){

	$kontrak = $this->Contract_m->getContractNew($ptm_number)->row_array();

} else {

	$kontrak = $this->Contract_m->getData($contract_id)->row_array();

}


$this->db->where(array(
	"job_title"=>"PENGELOLA KONTRAK",
	"district_id"=>$this->data['userdata']['district_id']
	));

$data['pelaksana_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$this->db->where(array(
	"job_title"=>"MANAJER PENGADAAN",
	"district_id"=>$this->data['userdata']['district_id']
	));

$data['manajer_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$data['last_comment'] = $last_comment;

$data['tipe_pengadaan'] = $this->Administration_m->isHeadQuatersProcurement($ptm_number);

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

/*

$getdept = $this->db->select("dep_code")
->join("adm_dept","ptm_dept_id=dept_id")
->where("ptm_number",$ptm_number)
->get("prc_tender_main")
->row()->dep_code;

$kontrak['contract_number'] = $this->Contract_m->getUrut("",$kontrak['contract_type'],
	$kontrak['contract_type_2'],$data['tipe_pengadaan'],$getdept);

*/

	$data['kontrak'] = $kontrak;

	$manager_name = (!empty($kontrak['ctr_man_employee'])) ? 
	$this->db->where("id",$kontrak['ctr_man_employee'])->get("adm_employee")->row()->fullname : "";

	$data['manager_name'] = $manager_name;

	$spe_name = (!empty($kontrak['ctr_spe_employee'])) ? 
	$this->db->where("id",$kontrak['ctr_spe_employee'])->get("adm_employee")->row()->fullname : "";

	$data['specialist_name'] = $spe_name;

	$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

	$data['item'] = $this->Contract_m->getItem("",$contract_id)->result_array();
     //hlmifzi
	$data['kode_item'] = $this->Contract_m->getItem("",$contract_id)->row_array();
	//end

	$data['milestone'] = $this->Contract_m->getMilestone("",$contract_id)->result_array();

	$data['document'] = $this->Contract_m->getDoc("",$contract_id)->result_array();

	$data['doc_category'] = $this->Contract_m->getDocType()->result_array();

	$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

	$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

	$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);

	$data["comment_list"][0] = $this->Comment_m->getContractActive($ptm_number)->result_array();

	//start code hlmifzi
	$data['penilaian']= $this->db->get('adm_question_kpi_vendor')->result_array();

	$this->session->set_userdata("rfq_id",$ptm_number);

	$this->session->set_userdata("contract_id",$contract_id);

	$this->session->set_userdata("module",'contract');

	$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);