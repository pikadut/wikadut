<?php 

$data = array();

$milestone_id = $this->uri->segment(3, 0);

$act = $this->uri->segment(4, 0);

$data['act'] = $act;

$data['milestone_id'] = $milestone_id;

$post = $this->input->post();

$data['milestone'] = $this->Contract_m->getMilestone($milestone_id)->result_array();

$data['progress'] = $this->Contract_m->getMilestoneProgress("",$milestone_id)->result_array();

$view = 'contract/proses_kontrak/form/detail_update_milestone_v';

$this->load->view($view,$data);
