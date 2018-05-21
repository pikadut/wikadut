<?php 

$data = array();

$milestone_id = $this->uri->segment(3, 0);

$data['milestone_id'] = $milestone_id;

$post = $this->input->post();

$data['milestone'] = $this->Contract_m->getMilestone($milestone_id)->row_array();

$view = 'contract/proses_kontrak/form/tagihan_milestone_v';

$this->load->view($view,$data);
