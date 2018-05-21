<?php 
$this->session->unset_userdata("contract_id");
$this->session->unset_userdata("ptm_number");

$view = 'contract/monitor/monitor_kontrak_v';
$data = array("act"=>$act);
if(!empty($act)){
	$this->load->view($view,$data);
} else {
	$this->template($view,"Monitor Kontrak",$data);
}
?>