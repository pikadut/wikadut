<?php 

$pr_number = $this->input->get('id');
$ybs = $this->data['userdata']['complete_name'];
$getdata['data'] = $this->Procpr_m->chat_pr($pr_number,$ybs);

echo json_encode($getdata);