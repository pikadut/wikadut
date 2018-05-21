<?php 
$this->session->unset_userdata("contract_id");
$this->session->unset_userdata("ptm_number");
$view = 'contract/monitor/monitor_progress_v';
$data = array("act"=>$act,"type"=>$type);
if(!empty($act)){
	$this->load->view($view,$data);
} else {
	$this->template($view,"Monitor Progress",$data);
}
?>