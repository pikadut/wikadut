<?php 

$post = $this->input->post();

$view = 'contract/proses_work_order/proses_work_order_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$data['id'] = null;

$data['contract_id'] = $contract_id;

$data['pos'] = $position;

$this->data['dir'] = CONTRACT_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","KONTRAK"=>"KONTRAK");

$contract = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $contract['ptm_number'];

$activity_id = 2011;

$totalwo = $this->db->select("COALESCE(SUM(sub_total),0) as total")->where("contract_id",$contract_id)->where("approved_date !=",null)
->join("ctr_po_header a","a.po_id=b.po_id")->get("ctr_po_item b")->row()->total;

$data['totalwo'] = $totalwo;

$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();

$this->db->where("job_title","PENGELOLA KONTRAK");

$data['pelaksana_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$data['kontrak'] = $contract;

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$item = $this->Contract_m->getItem("",$contract_id)->result_array();

$data['item'] = $item;

$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = array();

$this->session->set_userdata("rfq_id",$ptm_number);

$this->session->set_userdata("contract_id",$contract_id);

$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);