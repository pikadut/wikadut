<?php 

$post = $this->input->post();

$view = 'contract/proses_kontrak/lihat_monitor_kontrak_v';

$position = $this->Administration_m->getPosition("PIC USER");

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$ammend_id = $id;

$data['pos'] = $position;

$this->data['dir'] = ADDENDUM_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","SPK"=>"SPK","KONTRAK"=>"KONTRAK");

$addendum = $this->Addendum_m->getData($ammend_id)->row_array();

$contract_id = $addendum['contract_id'];

$activity_id = (!empty($addendum['status'])) ? $addendum['status'] : 3000;

$contract = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $contract['ptm_number'];

$activity = $this->Procedure3_m->getActivity($activity_id)->row_array();

$this->db->where("job_title","PENGELOLA KONTRAK");

$data['pelaksana_addendum'] = $this->Administration_m->getUserRule()->result_array();

$data['kontrak'] = $contract;

$data['addendum'] = $addendum;

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$data['item'] = $this->Addendum_m->getItem("",$ammend_id)->result_array();

$data['milestone'] = $this->Addendum_m->getMilestone("",$ammend_id)->result_array();

$data['document'] = $this->Contract_m->getDoc("",$contract_id)->result_array();

$data['doc_category'] = $this->Addendum_m->getDocType()->result_array();

$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure3_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = $this->Comment_m->getAddendumActive($ammend_id)->result_array();

$this->session->set_userdata("rfq_id",$ptm_number);

$this->session->set_userdata("contract_id",$contract_id);

$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);