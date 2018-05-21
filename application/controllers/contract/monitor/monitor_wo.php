<?php 
$this->session->unset_userdata("contract_id");
$this->session->unset_userdata("ptm_number");
  $view = 'contract/monitor/monitor_wo_v';
  $data = array();
  $this->template($view,"Monitor WO",$data);
?>