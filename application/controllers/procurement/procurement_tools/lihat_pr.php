<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/detail_permintaan_pengadaan_v';

$pr_number =  $this->uri->segment(5, 0);

$data['id'] = $pr_number;

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("LUMPSUM"=>"LUMPSUM","HARGA SATUAN"=>"HARGA SATUAN","RENTAL SERVICE"=>"RENTAL SERVICE");

$tender = $this->Procpr_m->getMonitorPR($pr_number)->row_array();

$data['permintaan'] = $tender;

$activity_id = $tender['last_status'];

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$comment = $this->Comment_m->getProcurementPRActive($pr_number)->result_array();


$is_user = false;

$employee = $this->data['userdata'];

foreach ($comment as $key => $value) {
	if($value['user_id'] == $employee['employee_id'] && !$is_user){
		$is_user = true;
	}
}

$data["comment_list"][0] = $comment;

$data['is_user'] = $is_user;

$data['document'] = $this->Procpr_m->getDokumenPR("",$pr_number)->result_array();

$data['item'] = $this->Procpr_m->getItemPR("",$pr_number)->result_array();

$data['redirect_back'] = 'procurement/procurement_tools/monitor_permintaan';

$this->session->set_userdata("pr_id",$pr_number);
//$this->template($view,$activity['awa_name'],$data);
$this->template($view,"Detail Permintaan (".$activity['awa_name'].")",$data);