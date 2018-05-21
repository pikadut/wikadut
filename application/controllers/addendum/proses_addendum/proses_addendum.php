<?php 

$post = $this->input->post();

$view = 'addendum/proses_addendum/proses_addendum_v';

$position = $this->Administration_m->getPosition("PIC USER");

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

$data['id'] = $id;

$data['pos'] = $position;

$this->data['dir'] = ADDENDUM_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","SPK"=>"SPK","KONTRAK"=>"KONTRAK");

$last_comment = $this->Comment_m->getAddendum("",$id)->row_array();

$contract_id = $last_comment['contract_id'];

$ammend_id = $last_comment['ammend_id'];

$activity_id = (!empty($last_comment['activity'])) ? $last_comment['activity'] : 2000;

$contract = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $contract['ptm_number'];

$activity = $this->Procedure3_m->getActivity($activity_id)->row_array();

$addendum = $this->Addendum_m->getData($ammend_id)->row_array();

$this->db->where("job_title","PENGELOLA KONTRAK");

$data['pelaksana_addendum'] = $this->Administration_m->getUserRule()->result_array();

$data['last_comment'] = $last_comment;

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