<?php 

$rfq_number = $this->input->get('id');
$ybs = $this->data['userdata']['complete_name'];
$getdata['data'] = $this->Procrfq_m->chat_rfq($rfq_number,$ybs);

echo json_encode($getdata);