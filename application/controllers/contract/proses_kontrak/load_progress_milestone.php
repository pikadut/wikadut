<?php 

$view = 'contract/proses_kontrak/view/load_milestone_v';

$contract_id = $this->session->userdata("contract_id");

$data['act'] = $type = $this->uri->segment(3, 0);

$data['milestone'] = $this->Contract_m->getMilestone("",$contract_id)->result_array();

$this->load->view($view,$data);